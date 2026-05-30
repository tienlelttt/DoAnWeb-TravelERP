<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThanhToanMockRequest;
use App\Http\Requests\BaoChuyenKhoanRequest;
use App\Services\ThanhToanService;
use App\Http\Resources\DonDatTourResource;
use App\Http\Resources\GiaoDichResource;
use Illuminate\Http\JsonResponse;

class ThanhToanController extends Controller
{
    protected $thanhToanService;

    public function __construct(ThanhToanService $thanhToanService)
    {
        $this->thanhToanService = $thanhToanService;
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
        $donDatTour = $this->thanhToanService->thanhToanMock($request->validated()['maDatTour'], $user->MaTaiKhoan);

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
    public function baoChuyenKhoan(BaoChuyenKhoanRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();
        $giaoDich = $this->thanhToanService->baoChuyenKhoan($data['maDatTour'], $data['maGDNH'], $user->MaTaiKhoan);

        return $this->successResponse(new GiaoDichResource($giaoDich), "Báo chuyển khoản ngân hàng thành công. Vui lòng chờ Sales duyệt giao dịch.");
    }
}
