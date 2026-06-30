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
    // Phê duyệt dữ liệu.
    public function duyetDonVip(string $maDatTour): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour) {
            // 1. Tìm đơn đặt tour
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->trang_thai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Đơn hàng không ở trạng thái 'Chờ xác nhận'");
            }

            // 2. Khóa dòng TourThucTe liên quan
            $tour = TourThucTe::lockForUpdate()->find($don->ma_tour_thuc_te);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế tương ứng");
            }

            // 3. Tạo giao dịch thành công (Công nợ / VIP)
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $this->giaoDichRepository->taoGiaoDich([
                'ma_giao_dich' => $maGiaoDich,
                'ma_dat_tour' => $don->ma_dat_tour,
                'loai_giao_dich' => 'THANH_TOAN',
                'phuong_thuc' => 'CONG_NO',
                'so_tien' => $don->tong_tien,
                'ma_gdnh' => 'VIP_' . strtoupper(Str::random(10)),
                'trang_thai' => 'THANH_CONG',
                'ngay_thanh_toan' => Carbon::now(),
            ]);

            // 4. Chuyển trạng thái đơn hàng sang DA_XAC_NHAN
            $this->huyDonRepository->capNhatTrangThai($don, 'DA_XAC_NHAN');

            // 5. Tạo lịch sử tour cho khách hàng chính
            $ctNguoiDat = ChiTietDatTour::where('ma_dat_tour', $don->ma_dat_tour)
                ->where('loai_khach', 'NGUOI_DAT')
                ->first();

            $this->lichSuTourRepository->taoLichSu([
                'ma_lich_su_tour' => $this->maTuDongService->taoMaLichSuTour(),
                'ma_khach_hang' => $don->ma_khach_hang,
                'ma_tour_thuc_te' => $don->ma_tour_thuc_te,
                'ma_chi_tiet_dat' => $ctNguoiDat ? $ctNguoiDat->ma_chi_tiet_dat : null,
                'ngay_tham_gia' => $tour->ngay_khoi_hanh,
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
    // Hủy dữ liệu.
    public function yeuCauHuyDon(string $maDatTour, string $lyDo, string $maTaiKhoan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $lyDo, $maTaiKhoan) {
            // 1. Tìm đơn đặt tour và kiểm tra quyền sở hữu
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            $khachHang = \App\Models\HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->first();
            if (!$khachHang || $don->ma_khach_hang !== $khachHang->ma_khach_hang) {
                throw AppException::forbidden("Bạn không có quyền yêu cầu hủy đơn hàng này");
            }

            // Chỉ cho hủy đơn đã xác nhận, chờ xác nhận hoặc đã thanh toán
            if (!in_array($don->trang_thai, ['DA_XAC_NHAN', 'CHO_XAC_NHAN', 'DA_THANH_TOAN'])) {
                throw AppException::badRequest("Chỉ có thể yêu cầu hủy đơn ở trạng thái 'Đã xác nhận', 'Đã thanh toán' hoặc 'Chờ xác nhận'");
            }

            // 2. Tính số ngày còn lại trước khởi hành
            $tour = TourThucTe::find($don->ma_tour_thuc_te);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy thông tin tour khởi hành");
            }

            $ngayKhoiHanh = Carbon::parse($tour->ngay_khoi_hanh)->startOfDay();
            $now = Carbon::now()->startOfDay();
            $soNgayConLai = $now->diffInDays($ngayKhoiHanh, false);

            // Phải hủy tối thiểu trước 2 ngày
            if ($soNgayConLai < 2) {
                throw AppException::badRequest("Chỉ được yêu cầu hủy tour tối thiểu 2 ngày trước ngày khởi hành");
            }

            // 3. Tính phí phạt hủy tour theo chính sách công ty
            $phiHuy = $this->tinhPhiHuyTour($don, $soNgayConLai);
            $soTienHoan = (float) $don->tong_tien - $phiHuy;

            // 4. Cập nhật đơn đặt tour sang trạng thái CHO_HUY
            $this->huyDonRepository->capNhatTrangThai($don, 'CHO_HUY');

            // 5. Tạo ticket yêu cầu hỗ trợ (yeu_cau_ho_tros)
            $maYeuCau = $this->maTuDongService->taoMaYeuCauHoTro();
            $this->yeuCauHoTroRepository->taoYeuCau([
                'ma_yeu_cau_ho_tro' => $maYeuCau,
                'ma_dat_tour' => $don->ma_dat_tour,
                'ma_khach_hang' => $don->ma_khach_hang,
                'loai_yeu_cau' => 'HUY_TOUR',
                'noi_dung' => "Lý do: {$lyDo} | Phí hủy: " . number_format($phiHuy) . " VND | Số tiền hoàn dự kiến: " . number_format($soTienHoan) . " VND",
                'trang_thai' => 'CHUA_XU_LY',
            ]);

            // 6. Tạo giao dịch HOAN_TIEN chờ xử lý (CHO_THANH_TOAN)
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $this->giaoDichRepository->taoGiaoDich([
                'ma_giao_dich' => $maGiaoDich,
                'ma_dat_tour' => $don->ma_dat_tour,
                'loai_giao_dich' => 'HOAN_TIEN',
                'phuong_thuc' => 'CHUYEN_KHOAN',
                'so_tien' => $soTienHoan,
                'ma_gdnh' => null,
                'trang_thai' => 'CHO_THANH_TOAN',
                'ngay_thanh_toan' => null,
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
    // Hủy dữ liệu (xuLyHuyDon).
    public function xuLyHuyDon(string $maDatTour, string $trangThaiXacNhan, string $maTaiKhoan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $trangThaiXacNhan, $maTaiKhoan) {
            // 1. Tìm đơn và ticket liên quan
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->trang_thai !== 'CHO_HUY') {
                throw AppException::badRequest("Đơn đặt tour không ở trạng thái 'Chờ hủy'");
            }

            $ticket = $this->yeuCauHoTroRepository->timTicketHuyTourChoDuyet($maDatTour);
            if (!$ticket) {
                throw AppException::badRequest("Không tìm thấy yêu cầu hủy tour đang chờ duyệt cho đơn hàng này");
            }

            // Lấy hồ sơ nhân viên
            $nhanVien = NhanVien::where('ma_tai_khoan', $maTaiKhoan)->first();
            $maNhanVien = $nhanVien ? $nhanVien->ma_nhan_vien : null;

            if (strtoupper($trangThaiXacNhan) === 'DONG_Y' || strtoupper($trangThaiXacNhan) === 'TC') {
                // Đồng ý duyệt hủy đơn
                $ticket->trang_thai = 'DA_XU_LY';
                $ticket->ma_nhan_vien_xu_ly = $maNhanVien;
                $ticket->save();

                $maChiTietDats = ChiTietDatTour::where('ma_dat_tour', $don->ma_dat_tour)->pluck('ma_chi_tiet_dat')->toArray();
                LichSuTour::whereIn('ma_chi_tiet_dat', $maChiTietDats)->delete();
            } else {
                // Từ chối duyệt hủy đơn -> Đơn quay lại trạng thái cũ
                $giaoDichThanhToan = GiaoDich::where('ma_dat_tour', $don->ma_dat_tour)
                    ->where('loai_giao_dich', 'THANH_TOAN')
                    ->where('trang_thai', 'THANH_CONG')
                    ->first();
                
                $trangThaiCu = $giaoDichThanhToan ? 'DA_XAC_NHAN' : 'CHO_XAC_NHAN';
                $this->huyDonRepository->capNhatTrangThai($don, $trangThaiCu);

                $ticket->trang_thai = 'TU_CHOI';
                $ticket->ma_nhan_vien_xu_ly = $maNhanVien;
                $ticket->save();

                GiaoDich::where('ma_dat_tour', $don->ma_dat_tour)
                    ->where('loai_giao_dich', 'HOAN_TIEN')
                    ->where('trang_thai', 'CHO_THANH_TOAN')
                    ->update(['trang_thai' => 'THAT_BAI']);
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
    // Hoàn tiền dữ liệu.
    public function hoanTienThucTe(string $maDatTour, string $trangThaiXacNhan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $trangThaiXacNhan) {
            // 1. Tìm đơn hàng
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->trang_thai !== 'CHO_HUY') {
                throw AppException::badRequest("Đơn đặt tour không ở trạng thái 'Chờ hủy'");
            }

            // 2. Tìm giao dịch hoàn tiền chờ duyệt
            $giaoDich = GiaoDich::where('ma_dat_tour', $maDatTour)
                ->where('loai_giao_dich', 'HOAN_TIEN')
                ->where('trang_thai', 'CHO_THANH_TOAN')
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
            $tour = TourThucTe::lockForUpdate()->find($don->ma_tour_thuc_te);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế tương ứng");
            }

            if (strtoupper($trangThaiXacNhan) === 'DONG_Y' || strtoupper($trangThaiXacNhan) === 'TC') {
                // Hoàn tất hoàn tiền
                $giaoDich->trang_thai = 'DA_HOAN_TIEN'; // Hoặc THANH_CONG
                $giaoDich->ngay_thanh_toan = Carbon::now();
                $giaoDich->ma_gdnh = 'REFUND_' . strtoupper(Str::random(10));
                $giaoDich->save();

                // Đổi đơn sang DA_HUY chính thức
                $this->huyDonRepository->capNhatTrangThai($don, 'DA_HUY');

                // Giải phóng chỗ trống cho_con_lai thực tế của tour
                $soKhach = ChiTietDatTour::where('ma_dat_tour', $don->ma_dat_tour)->count();
                $tour->cho_con_lai += $soKhach;
                $tour->save();
            } else {
                // Từ chối hoàn tiền
                $giaoDich->trang_thai = 'THAT_BAI';
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
    // Hủy dữ liệu (tinhPhiHuyTour).
    private function tinhPhiHuyTour(DonDatTour $don, int $soNgayConLai): float
    {
        $tongTien = (float) $don->tong_tien;

        if ($soNgayConLai > 15) {
            return $tongTien * 0.1;
        } elseif ($soNgayConLai >= 7) {
            return $tongTien * 0.3;
        } elseif ($soNgayConLai >= 3) {
            return $tongTien * 0.5;
        } else {
            return $tongTien;
        }
    }
}
