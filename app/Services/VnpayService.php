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
    public function taoUrlThanhToan(string $maDatTour, string $maTaiKhoan, string $ipAddress): string
    {
        $don = DonDatTour::where('MaDatTour', $maDatTour)->first();
        if (!$don) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
        }

        $khachHang = \App\Models\HoChieuSo::where('MaTaiKhoan', $maTaiKhoan)->first();
        if (!$khachHang || $don->MaKhachHang !== $khachHang->MaKhachHang) {
            throw AppException::forbidden("Bạn không có quyền thanh toán cho đơn hàng này");
        }

        if ($don->TrangThai !== 'CHO_XAC_NHAN') {
            throw AppException::badRequest("Chỉ có thể thanh toán cho đơn hàng ở trạng thái 'Chờ xác nhận'");
        }

        // Tạo giao dịch chờ thanh toán nếu chưa có
        $giaoDich = GiaoDich::where('MaDatTour', $maDatTour)
            ->where('TrangThai', 'CHO_THANH_TOAN')
            ->first();

        if (!$giaoDich) {
            $maGiaoDich = $this->maTuDongService->taoMaGiaoDich();
            $giaoDich = $this->giaoDichRepository->taoGiaoDich([
                'MaGiaoDich' => $maGiaoDich,
                'MaDatTour' => $don->MaDatTour,
                'LoaiGiaoDich' => 'THANH_TOAN',
                'PhuongThuc' => 'VNPAY',
                'SoTien' => $don->TongTien,
                'MaGDNH' => 'QR_' . $don->MaDatTour, // Tương tự Java
                'TrangThai' => 'CHO_THANH_TOAN',
                'NgayThanhToan' => Carbon::now(), // Theo logic của Java (Tạo giao dịch chờ)
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

        $vnp_TxnRef = $giaoDich->MaGiaoDich;
        $vnp_OrderInfo = "Thanh toan don dat tour " . $maDatTour;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $don->TongTien * 100; // VNPAY nhận số tiền nhân 100
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

        // Sort data by key
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

        $giaoDich = GiaoDich::where('MaGiaoDich', $maGiaoDich)->first();
        if (!$giaoDich) {
            throw AppException::notFound("Không tìm thấy giao dịch: " . $maGiaoDich);
        }

        // Nếu giao dịch đã được xử lý (bởi IPN hoặc Return trước đó) thì bỏ qua phần cập nhật Database
        if ($giaoDich->TrangThai !== 'CHO_THANH_TOAN') {
            return [
                'success' => $giaoDich->TrangThai === 'THANH_CONG',
                'message' => 'Giao dịch đã được xử lý trước đó',
                'giaoDich' => $giaoDich
            ];
        }

        DB::beginTransaction();
        try {
            if ($vnp_ResponseCode == '00') { // 00 là mã thành công của VNPAY
                $don = DonDatTour::where('MaDatTour', $giaoDich->MaDatTour)->first();
                $tour = TourThucTe::lockForUpdate()->find($don->MaTourThucTe);

                // Cập nhật giao dịch
                $giaoDich->TrangThai = 'THANH_CONG';
                $giaoDich->MaGDNH = $vnp_TransactionNo; // Lưu mã GD VNPAY
                $giaoDich->NgayThanhToan = Carbon::now();
                $giaoDich->save();

                // Cập nhật đơn hàng
                $don->TrangThai = 'DA_XAC_NHAN';
                $don->save();

                // Cập nhật số chỗ
                $soKhach = ChiTietDatTour::where('MaDatTour', $don->MaDatTour)->count();
                if ($tour->ChoConLai >= $soKhach) {
                    $tour->ChoConLai -= $soKhach;
                    $tour->save();
                } else {
                    DB::rollBack();
                    throw AppException::badRequest("Tour không còn đủ chỗ cho đơn đặt này");
                }

                // Ghi nhận lịch sử tour
                $ctNguoiDat = ChiTietDatTour::where('MaDatTour', $don->MaDatTour)
                    ->where('LoaiKhach', 'NGUOI_DAT')
                    ->first();

                $daCoLich = \App\Models\LichSuTour::where('MaKhachHang', $don->MaKhachHang)
                    ->where('MaTourThucTe', $tour->MaTourThucTe)
                    ->exists();

                if (!$daCoLich) {
                    $this->lichSuTourRepository->taoLichSu([
                        'MaLichSuTour' => $this->maTuDongService->taoMaLichSuTour(),
                        'MaKhachHang' => $don->MaKhachHang,
                        'MaTourThucTe' => $don->MaTourThucTe,
                        'MaChiTietDat' => $ctNguoiDat ? $ctNguoiDat->MaChiTietDat : null,
                        'NgayThamGia' => $tour->NgayKhoiHanh ?? Carbon::now(),
                    ]);
                }
                
                DB::commit();
                return [
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                    'giaoDich' => $giaoDich
                ];
            } else {
                $giaoDich->TrangThai = 'THAT_BAI';
                $giaoDich->MaGDNH = $vnp_TransactionNo;
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
