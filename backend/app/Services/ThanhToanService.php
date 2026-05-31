<?php

namespace App\Services;

use App\Models\DonDatTour;
use App\Models\TourThucTe;
use App\Models\ChiTietDatTour;
use App\Models\GiaoDich;
use App\Exceptions\AppException;
use App\Repositories\GiaoDichRepository;
use App\Repositories\LichSuTourRepository;
use App\Services\MaTuDongService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ThanhToanService
{
    protected $giaoDichRepository;
    protected $lichSuTourRepository;
    protected $maTuDongService;

    public function __construct(
        GiaoDichRepository $giaoDichRepository,
        LichSuTourRepository $lichSuTourRepository,
        MaTuDongService $maTuDongService
    ) {
        $this->giaoDichRepository = $giaoDichRepository;
        $this->lichSuTourRepository = $lichSuTourRepository;
        $this->maTuDongService = $maTuDongService;
    }

    /**
     * Thanh toán trực tuyến (Mock Payment) cho Khách hàng
     *
     * @param string $maDatTour
     * @param string $maTaiKhoan
     * @return DonDatTour
     */
    public function thanhToanMock(string $maDatTour, string $maTaiKhoan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $maTaiKhoan) {
            // 1. Tìm đơn đặt tour và kiểm tra quyền sở hữu
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            // Lấy hồ sơ khách hàng từ tài khoản đang đăng nhập
            $khachHang = \App\Models\HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->first();
            if (!$khachHang || $don->ma_khach_hang !== $khachHang->ma_khach_hang) {
                throw AppException::forbidden("Bạn không có quyền thực hiện thanh toán cho đơn hàng này");
            }

            // 2. Kiểm tra trạng thái đơn đặt tour phải ở trạng thái CHO_XAC_NHAN
            if ($don->trang_thai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Chỉ có thể thanh toán cho đơn hàng ở trạng thái 'Chờ xác nhận'");
            }

            // 3. Khóa dòng TourThucTe liên quan bằng lockForUpdate để tránh overbooking
            $tour = TourThucTe::lockForUpdate()->find($don->ma_tour_thuc_te);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế tương ứng");
            }

            // 4. Tạo giao dịch thành công trực tiếp
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $this->giaoDichRepository->taoGiaoDich([
                'ma_giao_dich' => $maGiaoDich,
                'ma_dat_tour' => $don->ma_dat_tour,
                'loai_giao_dich' => 'THANH_TOAN',
                'phuong_thuc' => 'MOCK',
                'so_tien' => $don->tong_tien,
                'ma_gdnh' => 'MOCK_PAYMENT_' . strtoupper(Str::random(10)),
                'trang_thai' => 'THANH_CONG',
                'ngay_thanh_toan' => Carbon::now(),
            ]);

            // 5. Cập nhật đơn đặt tour sang trạng thái DA_XAC_NHAN
            $don->trang_thai = 'DA_XAC_NHAN';
            $don->save();

            // 6. Tạo bản ghi lich_su_tours cho khách hàng chính (người đặt)
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
     * Khách hàng báo đã chuyển khoản ngân hàng thủ công
     *
     * @param string $maDatTour
     * @param string $maGDNH
     * @param string $maTaiKhoan
     * @return GiaoDich
     */
    public function baoChuyenKhoan(string $maDatTour, string $maGDNH, string $maTaiKhoan): GiaoDich
    {
        return DB::transaction(function () use ($maDatTour, $maGDNH, $maTaiKhoan) {
            // 1. Tìm đơn đặt tour và kiểm tra
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            $khachHang = \App\Models\HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->first();
            if (!$khachHang || $don->ma_khach_hang !== $khachHang->ma_khach_hang) {
                throw AppException::forbidden("Bạn không có quyền thực hiện thao tác này trên đơn hàng này");
            }

            if ($don->trang_thai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Chỉ có thể báo chuyển khoản cho đơn hàng ở trạng thái 'Chờ xác nhận'");
            }

            // Kiểm tra xem đã có giao dịch báo chuyển khoản đang chờ duyệt chưa
            $giaoDichTonTai = GiaoDich::where('ma_dat_tour', $maDatTour)
                ->where('trang_thai', 'CHO_THANH_TOAN')
                ->where('ma_gdnh', 'like', 'KHXN:%')
                ->exists();

            if ($giaoDichTonTai) {
                throw AppException::badRequest("Bạn đã báo chuyển khoản cho đơn hàng này rồi, vui lòng đợi duyệt");
            }

            // 2. Tạo giao dịch ở trạng thái CHO_THANH_TOAN với tiền tố KHXN:
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            return $this->giaoDichRepository->taoGiaoDich([
                'ma_giao_dich' => $maGiaoDich,
                'ma_dat_tour' => $don->ma_dat_tour,
                'loai_giao_dich' => 'THANH_TOAN',
                'phuong_thuc' => 'CHUYEN_KHOAN',
                'so_tien' => $don->tong_tien,
                'ma_gdnh' => 'KHXN:' . trim($maGDNH),
                'trang_thai' => 'CHO_THANH_TOAN',
                'ngay_thanh_toan' => null,
            ]);
        });
    }

    /**
     * Nhân viên Kinh Doanh (Sales) xác nhận thanh toán chuyển khoản thủ công
     *
     * @param string $maDatTour
     * @param string $trangThaiXacNhan
     * @return DonDatTour
     */
    public function xacNhanThanhToan(string $maDatTour, string $trangThaiXacNhan): DonDatTour
    {
        return DB::transaction(function () use ($maDatTour, $trangThaiXacNhan) {
            // 1. Tìm đơn đặt tour
            $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->trang_thai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Đơn đặt tour không ở trạng thái 'Chờ xác nhận'");
            }

            // 2. Tìm giao dịch báo chuyển khoản đang chờ
            $giaoDich = $this->giaoDichRepository->timGiaoDichChoDuyet($maDatTour);
            if (!$giaoDich) {
                throw AppException::badRequest("Không tìm thấy giao dịch chuyển khoản chờ xác nhận cho đơn hàng này");
            }

            // 3. Khóa dòng TourThucTe liên quan
            $tour = TourThucTe::lockForUpdate()->find($don->ma_tour_thuc_te);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế tương ứng");
            }

            if (strtoupper($trangThaiXacNhan) === 'DONG_Y' || strtoupper($trangThaiXacNhan) === 'TC') {
                // Đồng ý xác nhận thanh toán thành công
                // Cập nhật trạng thái giao dịch
                $giaoDich->trang_thai = 'THANH_CONG';
                $giaoDich->ngay_thanh_toan = Carbon::now();
                // Loại bỏ tiền tố KHXN: để lưu lại mã giao dịch ngân hàng chính thức
                $giaoDich->ma_gdnh = str_replace('KHXN:', '', $giaoDich->ma_gdnh);
                $giaoDich->save();

                // Cập nhật trạng thái đơn hàng sang DA_XAC_NHAN
                $don->trang_thai = 'DA_XAC_NHAN';
                $don->save();

                // Tạo bản ghi lich_su_tours cho khách hàng chính
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
            } else {
                // Từ chối xác nhận thanh toán (ví dụ: khách báo chuyển khoản giả mạo)
                // Cập nhật trạng thái giao dịch thành THAT_BAI
                $giaoDich->trang_thai = 'THAT_BAI';
                $giaoDich->save();
            }

            return $don;
        });
    }
}
