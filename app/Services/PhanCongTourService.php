<?php

namespace App\Services;

use App\Models\PhanCongTour;
use App\Models\TourThucTe;
use App\Models\NhanVien;
use App\Repositories\PhanCongTourRepository;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PhanCongTourService
{
    protected PhanCongTourRepository $phanCongTourRepo;
    protected MaTuDongService $maTuDongService;

    public function __construct(PhanCongTourRepository $phanCongTourRepo, MaTuDongService $maTuDongService)
    {
        $this->phanCongTourRepo = $phanCongTourRepo;
        $this->maTuDongService = $maTuDongService;
    }

    /**
     * Nhân viên điều hành phân công HDV cho Tour
     */
    public function phanCongHDV(string $maTourThucTe, string $maNhanVien)
    {
        return DB::transaction(function () use ($maTourThucTe, $maNhanVien) {
            $tourThucTe = TourThucTe::with('tourMau')->where('MaTourThucTe', $maTourThucTe)->lockForUpdate()->first();
            if (!$tourThucTe) {
                throw AppException::notFound("Không tìm thấy tour thực tế");
            }

            if (!in_array($tourThucTe->TrangThai, ['CHO_KICH_HOAT', 'MO_BAN'])) {
                throw AppException::badRequest("Chỉ được phân công HDV cho tour ở trạng thái chờ kích hoạt hoặc đang mở bán");
            }

            $hdv = NhanVien::where('MaNhanVien', $maNhanVien)->first();
            if (!$hdv) {
                throw AppException::notFound("Không tìm thấy nhân viên hướng dẫn");
            }

            // Kiểm tra xem đã phân công chưa
            $daPhanCong = PhanCongTour::where('MaTourThucTe', $maTourThucTe)
                ->where('MaNhanVien', $maNhanVien)
                ->where('TrangThaiChapNhan', '!=', 'TU_CHOI')
                ->exists();
            
            if ($daPhanCong) {
                throw AppException::badRequest("Hướng dẫn viên này đã được phân công cho tour này");
            }

            // Tính ngày kết thúc của tour mới
            $thoiLuongMoi = $tourThucTe->tourMau->ThoiLuong;
            $ngayKhoiHanhMoi = Carbon::parse($tourThucTe->NgayKhoiHanh);
            $ngayKetThucMoi = $ngayKhoiHanhMoi->copy()->addDays($thoiLuongMoi);

            // Kiểm tra trùng lịch (TRG_KT_TRUNG_LICH_HDV)
            $this->phanCongTourRepo->kiemTraTrungLichHDV($maNhanVien, $ngayKhoiHanhMoi, $ngayKetThucMoi);

            // Tạo phân công mới
            $maPhanCong = $this->maTuDongService->taoMaPhanCongTour();
            $phanCong = new PhanCongTour();
            $phanCong->MaPhanCongTour = $maPhanCong;
            $phanCong->MaTourThucTe = $maTourThucTe;
            $phanCong->MaNhanVien = $maNhanVien;
            $phanCong->NgayPhanCong = now();
            $phanCong->TrangThaiChapNhan = 'CHO_PHAN_HOI';
            $phanCong->save();

            return $phanCong;
        });
    }

    /**
     * HDV phản hồi phân công (Đồng ý hoặc Từ chối)
     */
    public function hdvTraLoiPhanCong(string $maPhanCongTour, string $trangThaiTraLoi, string $maNhanVienYeuCau)
    {
        return DB::transaction(function () use ($maPhanCongTour, $trangThaiTraLoi, $maNhanVienYeuCau) {
            $phanCong = PhanCongTour::where('MaPhanCongTour', $maPhanCongTour)->lockForUpdate()->first();
            if (!$phanCong) {
                throw AppException::notFound("Không tìm thấy thông tin phân công");
            }

            if ($phanCong->MaNhanVien !== $maNhanVienYeuCau) {
                throw AppException::forbidden("Bạn không có quyền phản hồi phân công của người khác");
            }

            if ($phanCong->TrangThaiChapNhan !== 'CHO_PHAN_HOI') {
                throw AppException::badRequest("Chỉ có thể phản hồi các phân công đang ở trạng thái chờ");
            }

            if (!in_array($trangThaiTraLoi, ['DA_DONG_Y', 'TU_CHOI'])) {
                throw AppException::badRequest("Trạng thái trả lời không hợp lệ");
            }

            $phanCong->TrangThaiChapNhan = $trangThaiTraLoi;
            $phanCong->NgayPhanHoi = now();
            $phanCong->save();

            // Nếu đồng ý, kiểm tra và mở bán tour nếu đủ điều kiện (TRG_TTT_OPEN_REQUIRE_HDV)
            if ($trangThaiTraLoi === 'DA_DONG_Y') {
                $this->kiemTraVaMoBanTour($phanCong->MaTourThucTe);
            }

            return $phanCong;
        });
    }

    /**
     * Logic kiểm tra và tự động mở bán tour nếu đã có ít nhất 1 HDV đồng ý
     */
    public function kiemTraVaMoBanTour(string $maTourThucTe)
    {
        $tourThucTe = TourThucTe::where('MaTourThucTe', $maTourThucTe)->lockForUpdate()->first();
        if ($tourThucTe && $tourThucTe->TrangThai === 'CHO_KICH_HOAT') {
            $soLuongHDV = $this->phanCongTourRepo->kiemTraSoLuongHDVDongY($maTourThucTe);
            if ($soLuongHDV > 0) {
                $tourThucTe->TrangThai = 'MO_BAN';
                $tourThucTe->save();
            }
        }
    }
}
