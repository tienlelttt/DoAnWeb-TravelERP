<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThanhToanMockRequest;
use App\Http\Requests\BaoChuyenKhoanRequest;
use App\Http\Requests\KhoiTaoThanhToanRequest;
use App\Models\GiaoDich;
use App\Services\ThanhToanService;
use App\Http\Resources\DonDatTourResource;
use App\Http\Resources\GiaoDichResource;
use App\Services\VnpayService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ThanhToanController extends Controller
{
    protected ThanhToanService $thanhToanService;
    protected VnpayService $vnpayService;

    public function __construct(ThanhToanService $thanhToanService, VnpayService $vnpayService)
    {
        $this->thanhToanService = $thanhToanService;
        $this->vnpayService = $vnpayService;
    }

    /**
     * Khách hàng thực hiện thanh toán mock trực tuyến
     *
     * @param ThanhToanMockRequest $request
     * @return JsonResponse
     */
    public function thanhToanMock(ThanhToanMockRequest $request): JsonResponse
    {
        $user = auth()->user();
        $donDatTour = $this->thanhToanService->thanhToanMock($request->validated()['maDatTour'], $user->ma_tai_khoan);

        // Load các relation để DonDatTourResource render đầy đủ
        $donDatTour->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        return $this->successResponse(new DonDatTourResource($donDatTour), "Thanh toán trực tuyến thành công");
    }

    /**
     * Khách hàng báo chuyển khoản ngân hàng thủ công
     *
     * @param BaoChuyenKhoanRequest $request
     * @return JsonResponse
     */
    public function khoiTaoThanhToan(KhoiTaoThanhToanRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();
        $maDatTour = $data['maDonDatTour'] ?? $data['maDatTour'];
        $phuongThuc = strtoupper($data['phuongThuc'] ?? 'VNPAY');
        $mock = (bool) ($data['mock'] ?? false);

        if ($mock || $phuongThuc === 'MOCK') {
            $donDatTour = $this->thanhToanService->thanhToanMock($maDatTour, $user->ma_tai_khoan);
            $giaoDich = GiaoDich::where('ma_dat_tour', $donDatTour->ma_dat_tour)
                ->orderBy('created_at', 'desc')
                ->first();

            return $this->successResponse(
                $this->thanhToanResponse($giaoDich, null, 'Thanh toán mock thành công'),
                'Khởi tạo thanh toán thành công'
            );
        }

        $payUrl = $this->vnpayService->taoUrlThanhToan($maDatTour, $user->ma_tai_khoan, $request->ip());
        $giaoDich = GiaoDich::where('ma_dat_tour', $maDatTour)
            ->where('trang_thai', 'CHO_THANH_TOAN')
            ->orderBy('created_at', 'desc')
            ->first();

        return $this->successResponse(
            $this->thanhToanResponse($giaoDich, $payUrl, 'Đã khởi tạo giao dịch thanh toán'),
            'Khởi tạo thanh toán thành công'
        );
    }

    public function baoChuyenKhoan(BaoChuyenKhoanRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();
        $giaoDich = $this->thanhToanService->baoChuyenKhoan($data['maDatTour'], $data['maGDNH'], $user->ma_tai_khoan);
        return $this->successResponse(new GiaoDichResource($giaoDich), "Báo chuyển khoản ngân hàng thành công. Vui lòng chờ Sales duyệt giao dịch.");
    }

    /**
     * Tạo URL thanh toán VNPAY
     */
    public function xacNhanDaChuyenKhoan(string $maDatTour): JsonResponse
    {
        $user = auth()->user();
        $giaoDich = $this->thanhToanService->baoChuyenKhoan($maDatTour, 'KHACH_XAC_NHAN_' . now()->format('YmdHis'), $user->ma_tai_khoan);

        return $this->successResponse(
            $this->thanhToanResponse($giaoDich, null, 'Đã ghi nhận khách hàng chuyển khoản, chờ xác nhận'),
            'Đã ghi nhận khách hàng chuyển khoản, chờ xác nhận'
        );
    }

    public function hetHanThanhToanQr(string $maDatTour): JsonResponse
    {
        $giaoDich = GiaoDich::where('ma_dat_tour', $maDatTour)
            ->where('trang_thai', 'CHO_THANH_TOAN')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($giaoDich) {
            $giaoDich->trang_thai = 'THAT_BAI';
            $giaoDich->save();
        }

        return $this->successResponse(null, 'Mã QR đã hết hạn, đơn đã hết hạn giữ chỗ');
    }

    public function ketQua(string $maDatTour): JsonResponse
    {
        $giaoDich = GiaoDich::where('ma_dat_tour', $maDatTour)
            ->orderBy('created_at', 'desc')
            ->first();

        return $this->successResponse(
            $this->thanhToanResponse($giaoDich, null, $giaoDich ? 'Lấy kết quả thanh toán thành công' : 'Chưa có giao dịch thanh toán'),
            'Lấy kết quả thanh toán thành công'
        );
    }

    public function taoThanhToanVnpay(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'maDatTour' => 'required|string'
        ], [
            'maDatTour.required' => 'Vui lòng cung cấp mã đặt tour'
        ]);

        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $url = $this->vnpayService->taoUrlThanhToan($request->maDatTour, $maTaiKhoan, $request->ip());

        return $this->successResponse(['paymentUrl' => $url], "Tạo URL thanh toán VNPAY thành công");
    }

    /**
     * Frontend gọi API này sau khi nhận được callback từ VNPAY qua Return URL
     */
    public function vnpayReturn(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->vnpayService->xacThucGiaoDich($request);
        
        if ($result['success']) {
            return $this->successResponse($result, $result['message']);
        } else {
            return $this->errorResponse($result['message'], 400);
        }
    }

    /**
     * VNPAY gọi trực tiếp API này (Webhook/IPN) để cập nhật trạng thái ngầm
     */
    public function vnpayIpn(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->vnpayService->xacThucGiaoDich($request);
            
            if ($result['success'] || $result['message'] === 'Giao dịch đã được xử lý trước đó') {
                return response()->json([
                    'RspCode' => '00',
                    'Message' => 'Confirm Success'
                ]);
            } else {
                return response()->json([
                    'RspCode' => '00', // Vẫn trả 00 để VNPAY biết là ta đã nhận đc thất bại
                    'Message' => 'Transaction Failed'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'RspCode' => '99',
                'Message' => 'Unknown Error'
            ]);
        }
    }
    private function thanhToanResponse(?GiaoDich $giaoDich, ?string $payUrl, string $thongBao): array
    {
        return [
            'maGiaoDich' => $giaoDich?->ma_giao_dich,
            'maDatTour' => $giaoDich?->ma_dat_tour,
            'trangThai' => $giaoDich?->trang_thai ?? 'CHO_THANH_TOAN',
            'phuongThuc' => $giaoDich?->phuong_thuc,
            'soTien' => $giaoDich ? (float) $giaoDich->so_tien : null,
            'ngayThanhToan' => $giaoDich?->ngay_thanh_toan,
            'payUrl' => $payUrl,
            'thongBao' => $thongBao,
        ];
    }
}
