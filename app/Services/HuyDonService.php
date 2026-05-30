<?php

namespace App\Services;

use App\Models\DonDatTour;
use App\Models\TourThucTe;
use App\Models\ChiTietDatTour;
use App\Models\YeuCauHoTro;
use App\Models\GiaoDich;
use App\Models\LichSuTour;
use App\Models\NhanVien;
use App\Exceptions\AppException;
use App\Repositories\HuyDonRepository;
use App\Repositories\YeuCauHoTroRepository;
use App\Repositories\GiaoDichRepository;
use App\Repositories\LichSuTourRepository;
use App\Services\MaTuDongService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HuyDonService
{
    protected $huyDonRepository;
    protected $yeuCauHoTroRepository;
    protected $giaoDichRepository;
    protected $lichSuTourRepository;
    protected $maTuDongService;

    public function __construct(
        HuyDonRepository $huyDonRepository,
        YeuCauHoTroRepository $yeuCauHoTroRepository,
        GiaoDichRepository $giaoDichRepository,
        LichSuTourRepository $lichSuTourRepository,
        MaTuDongService $maTuDongService
    ) {
        $this->huyDonRepository = $huyDonRepository;
        $this->yeuCauHoTroRepository = $yeuCauHoTroRepository;
        $this->giaoDichRepository = $giaoDichRepository;
        $this->lichSuTourRepository = $lichSuTourRepository;
        $this->maTuDongService = $maTuDongService;
    }

    /**
     * Sales duyệt đơn đặt tour dạng VIP hoặc công nợ không qua thanh toán trực tuyến
     *
     * @param string $maDatTour
     * @return DonDatTour
     */
    public function duyetDonVip(string $maDatTour): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour) {
            // 1. Tìm đơn đặt tour
            $don = DonDatTour::where('MaDatTour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->TrangThai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Đơn hàng không ở trạng thái 'Chờ xác nhận'");
            }

            // 2. Khóa dòng TourThucTe liên quan
            $tour = TourThucTe::lockForUpdate()->find($don->MaTourThucTe);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế tương ứng");
            }

            // 3. Tạo giao dịch thành công (Công nợ / VIP)
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $this->giaoDichRepository->taoGiaoDich([
                'MaGiaoDich' => $maGiaoDich,
                'MaDatTour' => $don->MaDatTour,
                'LoaiGiaoDich' => 'THANH_TOAN',
                'PhuongThuc' => 'CONG_NO',
                'SoTien' => $don->TongTien,
                'MaGDNH' => 'VIP_' . strtoupper(Str::random(10)),
                'TrangThai' => 'THANH_CONG',
                'NgayThanhToan' => Carbon::now(),
            ]);

            // 4. Chuyển trạng thái đơn hàng sang DA_XAC_NHAN
            $this->huyDonRepository->capNhatTrangThai($don, 'DA_XAC_NHAN');

            // 5. Tạo lịch sử tour cho khách hàng chính
            $ctNguoiDat = ChiTietDatTour::where('MaDatTour', $don->MaDatTour)
                ->where('LoaiKhach', 'NGUOI_DAT')
                ->first();

            $this->lichSuTourRepository->taoLichSu([
                'MaLichSuTour' => $this->maTuDongService->taoMaLichSuTour(),
                'MaKhachHang' => $don->MaKhachHang,
                'MaTourThucTe' => $don->MaTourThucTe,
                'MaChiTietDat' => $ctNguoiDat ? $ctNguoiDat->MaChiTietDat : null,
                'NgayThamGia' => $tour->NgayKhoiHanh,
            ]);

            return $don;
        });
    }

    /**
     * Khách hàng yêu cầu hủy đơn hàng (tự động tính phí hủy bậc thang)
     *
     * @param string $maDatTour
     * @param string $lyDo
     * @param string $maTaiKhoan
     * @return DonDatTour
     */
    public function yeuCauHuyDon(string $maDatTour, string $lyDo, string $maTaiKhoan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $lyDo, $maTaiKhoan) {
            // 1. Tìm đơn đặt tour và kiểm tra quyền sở hữu
            $don = DonDatTour::where('MaDatTour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            $khachHang = \App\Models\HoChieuSo::where('MaTaiKhoan', $maTaiKhoan)->first();
            if (!$khachHang || $don->MaKhachHang !== $khachHang->MaKhachHang) {
                throw AppException::forbidden("Bạn không có quyền yêu cầu hủy đơn hàng này");
            }

            // Chỉ cho hủy đơn đã xác nhận
            if ($don->TrangThai !== 'DA_XAC_NHAN') {
                throw AppException::badRequest("Chỉ có thể yêu cầu hủy đơn ở trạng thái 'Đã xác nhận'");
            }

            // 2. Tính số ngày còn lại trước khởi hành
            $tour = TourThucTe::find($don->MaTourThucTe);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy thông tin tour khởi hành");
            }

            $ngayKhoiHanh = Carbon::parse($tour->NgayKhoiHanh)->startOfDay();
            $now = Carbon::now()->startOfDay();
            $soNgayConLai = $now->diffInDays($ngayKhoiHanh, false);

            // Phải hủy tối thiểu trước 2 ngày
            if ($soNgayConLai < 2) {
                throw AppException::badRequest("Chỉ được yêu cầu hủy tour tối thiểu 2 ngày trước ngày khởi hành");
            }

            // 3. Tính phí phạt hủy tour theo chính sách công ty
            $phiHuy = $this->tinhPhiHuyTour($don, $soNgayConLai);
            $soTienHoan = (float) $don->TongTien - $phiHuy;

            // 4. Cập nhật đơn đặt tour sang trạng thái CHO_HUY
            $this->huyDonRepository->capNhatTrangThai($don, 'CHO_HUY');

            // 5. Tạo ticket yêu cầu hỗ trợ (YEUCAUHOTRO)
            $maYeuCau = $this->maTuDongService->taoMaYeuCauHoTro();
            $this->yeuCauHoTroRepository->taoYeuCau([
                'MaYeuCauHoTro' => $maYeuCau,
                'MaDatTour' => $don->MaDatTour,
                'MaKhachHang' => $don->MaKhachHang,
                'LoaiYeuCau' => 'HUY_TOUR',
                'NoiDung' => "Lý do: {$lyDo} | Phí hủy: " . number_format($phiHuy) . " VND | Số tiền hoàn dự kiến: " . number_format($soTienHoan) . " VND",
                'TrangThai' => 'CHUA_XU_LY',
            ]);

            // 6. Tạo giao dịch HOAN_TIEN chờ xử lý (CHO_THANH_TOAN)
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $this->giaoDichRepository->taoGiaoDich([
                'MaGiaoDich' => $maGiaoDich,
                'MaDatTour' => $don->MaDatTour,
                'LoaiGiaoDich' => 'HOAN_TIEN',
                'PhuongThuc' => 'CHUYEN_KHOAN',
                'SoTien' => $soTienHoan,
                'MaGDNH' => null,
                'TrangThai' => 'CHO_THANH_TOAN',
                'NgayThanhToan' => null,
            ]);

            return $don;
        });
    }

    /**
     * Nhân viên Kinh doanh (Sales) xử lý yêu cầu hủy đơn hàng
     *
     * @param string $maDatTour
     * @param string $trangThaiXacNhan
     * @param string $maTaiKhoan
     * @return DonDatTour
     */
    public function xuLyHuyDon(string $maDatTour, string $trangThaiXacNhan, string $maTaiKhoan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $trangThaiXacNhan, $maTaiKhoan) {
            // 1. Tìm đơn và ticket liên quan
            $don = DonDatTour::where('MaDatTour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->TrangThai !== 'CHO_HUY') {
                throw AppException::badRequest("Đơn đặt tour không ở trạng thái 'Chờ hủy'");
            }

            $ticket = $this->yeuCauHoTroRepository->timTicketHuyTourChoDuyet($maDatTour);
            if (!$ticket) {
                throw AppException::badRequest("Không tìm thấy yêu cầu hủy tour đang chờ duyệt cho đơn hàng này");
            }

            // Lấy hồ sơ nhân viên
            $nhanVien = NhanVien::where('MaTaiKhoan', $maTaiKhoan)->first();
            $maNhanVien = $nhanVien ? $nhanVien->MaNhanVien : null;

            if (strtoupper($trangThaiXacNhan) === 'DONG_Y' || strtoupper($trangThaiXacNhan) === 'TC') {
                // Đồng ý duyệt hủy đơn
                $ticket->TrangThai = 'DA_XU_LY';
                $ticket->MaNhanVienXuLy = $maNhanVien;
                $ticket->save();

                // Hủy bỏ bản ghi lịch sử tham gia tour vì khách hàng không còn đi nữa
                $maChiTietDats = ChiTietDatTour::where('MaDatTour', $don->MaDatTour)->pluck('MaChiTietDat')->toArray();
                LichSuTour::whereIn('MaChiTietDat', $maChiTietDats)->delete();
            } else {
                // Từ chối duyệt hủy đơn -> Đơn quay lại DA_XAC_NHAN
                $this->huyDonRepository->capNhatTrangThai($don, 'DA_XAC_NHAN');

                $ticket->TrangThai = 'TU_CHOI';
                $ticket->MaNhanVienXuLy = $maNhanVien;
                $ticket->save();

                // Hủy giao dịch HOAN_TIEN
                GiaoDich::where('MaDatTour', $don->MaDatTour)
                    ->where('LoaiGiaoDich', 'HOAN_TIEN')
                    ->where('TrangThai', 'CHO_THANH_TOAN')
                    ->update(['TrangThai' => 'THAT_BAI']);
            }

            return $don;
        });
    }

    /**
     * Kế toán xác nhận hoàn tiền thực tế cho khách hàng qua ngân hàng
     *
     * @param string $maDatTour
     * @param string $trangThaiXacNhan
     * @return DonDatTour
     */
    public function hoanTienThucTe(string $maDatTour, string $trangThaiXacNhan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $trangThaiXacNhan) {
            // 1. Tìm đơn hàng
            $don = DonDatTour::where('MaDatTour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->TrangThai !== 'CHO_HUY') {
                throw AppException::badRequest("Đơn đặt tour không ở trạng thái 'Chờ hủy'");
            }

            // 2. Tìm giao dịch hoàn tiền chờ duyệt
            $giaoDich = GiaoDich::where('MaDatTour', $maDatTour)
                ->where('LoaiGiaoDich', 'HOAN_TIEN')
                ->where('TrangThai', 'CHO_THANH_TOAN')
                ->first();

            if (!$giaoDich) {
                throw AppException::badRequest("Không tìm thấy giao dịch hoàn tiền đang chờ cho đơn hàng này");
            }

            // 3. Tìm ticket yêu cầu hủy đã được Sales duyệt
            $ticket = $this->yeuCauHoTroRepository->timTicketHuyTourDaDuyet($maDatTour);
            if (!$ticket) {
                throw AppException::badRequest("Yêu cầu hủy đơn chưa được nhân viên Kinh doanh phê duyệt");
            }

            // 4. Khóa dòng TourThucTe liên quan để cộng lại số chỗ
            $tour = TourThucTe::lockForUpdate()->find($don->MaTourThucTe);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế tương ứng");
            }

            if (strtoupper($trangThaiXacNhan) === 'DONG_Y' || strtoupper($trangThaiXacNhan) === 'TC') {
                // Hoàn tất hoàn tiền
                $giaoDich->TrangThai = 'DA_HOAN_TIEN'; // Hoặc THANH_CONG
                $giaoDich->NgayThanhToan = Carbon::now();
                $giaoDich->MaGDNH = 'REFUND_' . strtoupper(Str::random(10));
                $giaoDich->save();

                // Đổi đơn sang DA_HUY chính thức
                $this->huyDonRepository->capNhatTrangThai($don, 'DA_HUY');

                // Giải phóng chỗ trống ChoConLai thực tế của tour
                $soKhach = ChiTietDatTour::where('MaDatTour', $don->MaDatTour)->count();
                $tour->ChoConLai += $soKhach;
                $tour->save();
            } else {
                // Từ chối hoàn tiền
                $giaoDich->TrangThai = 'THAT_BAI';
                $giaoDich->save();

                // Đơn hàng chuyển sang trạng thái tranh chấp TU_CHOI_HOAN_TIEN
                $this->huyDonRepository->capNhatTrangThai($don, 'TU_CHOI_HOAN_TIEN');
            }

            return $don;
        });
    }

    /**
     * Hàm tính phí phạt hủy tour bậc thang theo ngày
     *
     * @param DonDatTour $don
     * @param int $soNgayConLai
     * @return float
     */
    private function tinhPhiHuyTour(DonDatTour $don, int $soNgayConLai): float
    {
        $tongTien = (float) $don->TongTien;

        if ($soNgayConLai > 15) {
            // Hủy > 15 ngày trước ngày khởi hành: Phí hủy là 10%
            return $tongTien * 0.1;
        } elseif ($soNgayConLai >= 7) {
            // Hủy từ 7 đến 15 ngày: Phí hủy là 30%
            return $tongTien * 0.3;
        } elseif ($soNgayConLai >= 3) {
            // Hủy từ 3 đến 6 ngày: Phí hủy là 50%
            return $tongTien * 0.5;
        } else {
            // Hủy dưới 3 ngày: Phí hủy là 100%
            return $tongTien;
        }
    }
}
