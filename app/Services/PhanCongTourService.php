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
            $tourThucTe = TourThucTe::with('tourMau')->where('ma_tour_thuc_te', $maTourThucTe)->lockForUpdate()->first();
            if (!$tourThucTe) {
                throw AppException::notFound("Không tìm thấy tour thực tế");
            }

            if (!in_array($tourThucTe->trang_thai, ['CHO_KICH_HOAT', 'MO_BAN'])) {
                throw AppException::badRequest("Chỉ được phân công HDV cho tour ở trạng thái chờ kích hoạt hoặc đang mở bán");
            }

            $hdv = NhanVien::where('ma_nhan_vien', $maNhanVien)->first();
            if (!$hdv) {
                throw AppException::notFound("Không tìm thấy nhân viên hướng dẫn");
            }

            // Kiểm tra xem đã phân công chưa
            $daPhanCong = PhanCongTour::where('ma_tour_thuc_te', $maTourThucTe)
                ->where('ma_nhan_vien', $maNhanVien)
                ->where('trang_thai_chap_nhan', '!=', 'TU_CHOI')
                ->exists();
            
            if ($daPhanCong) {
                throw AppException::badRequest("Hướng dẫn viên này đã được phân công cho tour này");
            }

            // Tính ngày kết thúc của tour mới
            $thoiLuongMoi = $tourThucTe->tourMau->thoi_luong;
            $ngayKhoiHanhMoi = Carbon::parse($tourThucTe->ngay_khoi_hanh);
            $ngayKetThucMoi = $ngayKhoiHanhMoi->copy()->addDays($thoiLuongMoi);

            // Kiểm tra trùng lịch (TRG_KT_TRUNG_LICH_HDV)
            $this->phanCongTourRepo->kiemTraTrungLichHDV($maNhanVien, $ngayKhoiHanhMoi, $ngayKetThucMoi);

            // Tạo phân công mới
            $maPhanCong = $this->maTuDongService->taoMaPhanCongTour();
            $phanCong = new PhanCongTour();
            $phanCong->ma_phan_cong_tour = $maPhanCong;
            $phanCong->ma_tour_thuc_te = $maTourThucTe;
            $phanCong->ma_nhan_vien = $maNhanVien;
            $phanCong->ngay_phan_cong = now();
            $phanCong->trang_thai_chap_nhan = 'CHO_PHAN_HOI';
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
            $phanCong = PhanCongTour::where('ma_phan_cong_tour', $maPhanCongTour)->lockForUpdate()->first();
            if (!$phanCong) {
                throw AppException::notFound("Không tìm thấy thông tin phân công");
            }

            if ($phanCong->ma_nhan_vien !== $maNhanVienYeuCau) {
                throw AppException::forbidden("Bạn không có quyền phản hồi phân công của người khác");
            }

            if ($phanCong->trang_thai_chap_nhan !== 'CHO_PHAN_HOI') {
                throw AppException::badRequest("Chỉ có thể phản hồi các phân công đang ở trạng thái chờ");
            }

            if (!in_array($trangThaiTraLoi, ['DA_DONG_Y', 'TU_CHOI'])) {
                throw AppException::badRequest("Trạng thái trả lời không hợp lệ");
            }

            $phanCong->trang_thai_chap_nhan = $trangThaiTraLoi;
            $phanCong->ngay_phan_hoi = now();
            $phanCong->save();

            // Nếu đồng ý, kiểm tra và mở bán tour nếu đủ điều kiện (TRG_TTT_OPEN_REQUIRE_HDV)
            if ($trangThaiTraLoi === 'DA_DONG_Y') {
                $this->kiemTraVaMoBanTour($phanCong->ma_tour_thuc_te);
            }

            return $phanCong;
        });
    }

    /**
     * Logic kiểm tra và tự động mở bán tour nếu đã có ít nhất 1 HDV đồng ý
     */
    public function kiemTraVaMoBanTour(string $maTourThucTe)
    {
        $tourThucTe = TourThucTe::where('ma_tour_thuc_te', $maTourThucTe)->lockForUpdate()->first();
        if ($tourThucTe && $tourThucTe->trang_thai === 'CHO_KICH_HOAT') {
            $soLuongHDV = $this->phanCongTourRepo->kiemTraSoLuongHDVDongY($maTourThucTe);
            if ($soLuongHDV > 0) {
                $tourThucTe->trang_thai = 'MO_BAN';
                $tourThucTe->save();
            }
        }
    }

    /**
     * Lấy danh sách tour cần phân công
     */
    public function danhSachTourCanPhanCong()
    {
        // Các tour chuẩn bị khởi hành và số lượng HDV < yêu cầu (nếu có logic đếm HDV)
        // Hiện tại chỉ lấy các tour trạng thái CHO_KICH_HOAT hoặc MO_BAN và chưa khởi hành
        return TourThucTe::with('tourMau')
            ->whereIn('trang_thai', ['CHO_KICH_HOAT', 'MO_BAN'])
            ->where('ngay_khoi_hanh', '>', now())
            ->orderBy('ngay_khoi_hanh', 'asc')
            ->paginate(10);
    }

    /**
     * Lấy danh sách HDV khả dụng cho một tour (không trùng lịch)
     */
    public function danhSachHdvKhaDung(string $maTourThucTe)
    {
        $tourThucTe = TourThucTe::with('tourMau')->where('ma_tour_thuc_te', $maTourThucTe)->first();
        if (!$tourThucTe) {
            throw AppException::notFound("Không tìm thấy tour thực tế");
        }

        $thoiLuong = $tourThucTe->tourMau->thoi_luong;
        $ngayKhoiHanh = Carbon::parse($tourThucTe->ngay_khoi_hanh);
        $ngayKetThuc = $ngayKhoiHanh->copy()->addDays($thoiLuong);

        // Lấy tất cả nhân viên có vai trò HDV và đang DANG_LAM
        $tatCaHdv = NhanVien::whereHas('taiKhoan', function($q) {
            $q->where('vai_tro', 'HDV');
        })->where('trang_thai_lam_viec', 'DANG_LAM')->get();

        $hdvKhaDung = collect();

        foreach ($tatCaHdv as $hdv) {
            try {
                // Tận dụng hàm kiểm tra trùng lịch có sẵn
                $this->phanCongTourRepo->kiemTraTrungLichHDV($hdv->ma_nhan_vien, $ngayKhoiHanh, $ngayKetThuc);
                $hdvKhaDung->push($hdv);
            } catch (\Exception $e) {
                // Trùng lịch, bỏ qua
            }
        }

        return $hdvKhaDung;
    }

    /**
     * Hủy phân công
     */
    public function huyPhanCong(string $maPhanCong)
    {
        return DB::transaction(function () use ($maPhanCong) {
            $phanCong = PhanCongTour::where('ma_phan_cong_tour', $maPhanCong)->lockForUpdate()->first();
            if (!$phanCong) {
                throw AppException::notFound("Không tìm thấy thông tin phân công");
            }
            
            // Xoa phan cong de giu du lieu van hanh gon gang.
            $phanCong->delete();
            return true;
        });
    }
}
