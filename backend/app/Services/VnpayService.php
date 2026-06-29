<?php

namespace App\Services;

use App\Models\DonDatTour;
use App\Models\TourThucTe;
use App\Models\ChiTietDatTour;
use App\Models\GiaoDich;
use App\Exceptions\AppException;
use App\Repositories\GiaoDichRepository;
use App\Repositories\LichSuTourRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VnpayService
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
     * Tạo URL thanh toán VNPAY
     */
    // Thanh toán dữ liệu.
    public function taoUrlThanhToan(string $maDatTour, string $maTaiKhoan, string $ipAddress): string
    {
        $don = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
        if (!$don) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
        }

        $khachHang = \App\Models\HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->first();
        if (!$khachHang || $don->ma_khach_hang !== $khachHang->ma_khach_hang) {
            throw AppException::forbidden("Bạn không có quyền thanh toán cho đơn hàng này");
        }

        if ($don->trang_thai !== 'CHO_XAC_NHAN') {
            throw AppException::badRequest("Chỉ có thể thanh toán cho đơn hàng ở trạng thái 'Chờ xác nhận'");
        }

        // Tạo giao dịch chờ thanh toán nếu chưa có
        $giaoDich = GiaoDich::where('ma_dat_tour', $maDatTour)
            ->where('trang_thai', 'CHO_THANH_TOAN')
            ->first();

        if (!$giaoDich) {
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $giaoDich = $this->giaoDichRepository->taoGiaoDich([
                'ma_giao_dich' => $maGiaoDich,
                'ma_dat_tour' => $don->ma_dat_tour,
                'loai_giao_dich' => 'THANH_TOAN',
                'phuong_thuc' => 'VNPAY',
                'so_tien' => $don->tong_tien,
                'ma_gdnh' => 'QR_' . $don->ma_dat_tour,
                'trang_thai' => 'CHO_THANH_TOAN',
                'ngay_thanh_toan' => Carbon::now(),
            ]);
        }

        // Tạo tham số gửi VNPAY
        $vnp_TmnCode = config('vnpay.tmn_code');
        $vnp_HashSecret = config('vnpay.hash_secret');
        $vnp_Url = config('vnpay.url');
        $vnp_Returnurl = config('vnpay.return_url');
        
        // Cấu hình VNPAY yêu cầu truyền thời gian định dạng YmdHis
        $startTime = date("YmdHis");
        $expireTime = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $giaoDich->ma_giao_dich;
        $vnp_OrderInfo = "Thanh toan don dat tour " . $maDatTour;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $don->tong_tien * 100; // VNPAY nhận số tiền nhân 100
        $vnp_Locale = "vn";
        $vnp_IpAddr = $ipAddress;

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expireTime
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * Xác thực và xử lý Return/IPN từ VNPAY
     */

    public function xacThucGiaoDich(Request $request): array
    {
        $vnp_HashSecret = config('vnpay.hash_secret');
        $inputData = array();
        
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']); // Bỏ type nếu có
        
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        if ($secureHash !== $vnp_SecureHash) {
            throw AppException::badRequest("Chữ ký xác thực VNPAY không hợp lệ");
        }

        $maGiaoDich = $inputData['vnp_TxnRef'];
        $vnp_ResponseCode = $inputData['vnp_ResponseCode'];
        $vnp_TransactionNo = $inputData['vnp_TransactionNo'];

        $giaoDich = GiaoDich::where('ma_giao_dich', $maGiaoDich)->first();
        if (!$giaoDich) {
            throw AppException::notFound("Không tìm thấy giao dịch: " . $maGiaoDich);
        }

        // Nếu giao dịch đã được xử lý (bởi IPN hoặc Return trước đó) thì bỏ qua phần cập nhật Database
        if ($giaoDich->trang_thai !== 'CHO_THANH_TOAN') {
            return [
                'success' => $giaoDich->trang_thai === 'THANH_CONG',
                'message' => 'Giao dịch đã được xử lý trước đó',
                'giaoDich' => $giaoDich
            ];
        }

        DB::beginTransaction();
        try {
            if ($vnp_ResponseCode == '00') { // 00 là mã thành công của VNPAY
                $don = DonDatTour::where('ma_dat_tour', $giaoDich->ma_dat_tour)->first();
                $tour = TourThucTe::lockForUpdate()->find($don->ma_tour_thuc_te);

                $giaoDich->trang_thai = 'THANH_CONG';
                $giaoDich->ma_gdnh = $vnp_TransactionNo; // Lưu mã GD VNPAY
                $giaoDich->ngay_thanh_toan = Carbon::now();
                $giaoDich->save();

                $don->trang_thai = 'DA_XAC_NHAN';
                $don->save();

                $soKhach = ChiTietDatTour::where('ma_dat_tour', $don->ma_dat_tour)->count();
                if ($tour->cho_con_lai >= $soKhach) {
                    $tour->cho_con_lai -= $soKhach;
                    $tour->save();
                } else {
                    DB::rollBack();
                    throw AppException::badRequest("Tour không còn đủ chỗ cho đơn đặt này");
                }

                // Ghi nhận lịch sử tour
                $ctNguoiDat = ChiTietDatTour::where('ma_dat_tour', $don->ma_dat_tour)
                    ->where('loai_khach', 'NGUOI_DAT')
                    ->first();

                $daCoLich = \App\Models\LichSuTour::where('ma_khach_hang', $don->ma_khach_hang)
                    ->where('ma_tour_thuc_te', $tour->ma_tour_thuc_te)
                    ->exists();

                if (!$daCoLich) {
                    $this->lichSuTourRepository->taoLichSu([
                        'ma_lich_su_tour' => $this->maTuDongService->taoMaLichSuTour(),
                        'ma_khach_hang' => $don->ma_khach_hang,
                        'ma_tour_thuc_te' => $don->ma_tour_thuc_te,
                        'ma_chi_tiet_dat' => $ctNguoiDat ? $ctNguoiDat->ma_chi_tiet_dat : null,
                        'ngay_tham_gia' => $tour->ngay_khoi_hanh ?? Carbon::now(),
                    ]);
                }
                
                DB::commit();
                return [
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                    'giaoDich' => $giaoDich
                ];
            } else {
                $giaoDich->trang_thai = 'THAT_BAI';
                $giaoDich->ma_gdnh = $vnp_TransactionNo;
                $giaoDich->save();
                DB::commit();
                
                return [
                    'success' => false,
                    'message' => 'Thanh toán thất bại hoặc đã bị hủy (Mã lỗi: ' . $vnp_ResponseCode . ')',
                    'giaoDich' => $giaoDich
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
