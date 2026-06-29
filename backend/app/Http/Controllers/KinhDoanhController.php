<?php

namespace App\Http\Controllers;

use App\Http\Requests\XacNhanThanhToanRequest;
use App\Services\ThanhToanService;
use App\Http\Resources\DonDatTourResource;
use Illuminate\Http\JsonResponse;

// Module quản lý dữ liệu.
class KinhDoanhController extends Controller
{
    protected $thanhToanService;

    public function __construct(ThanhToanService $thanhToanService)
    {
        $this->thanhToanService = $thanhToanService;
    }

    /**
     * Nhân viên Kinh Doanh (Sales) xác nhận thanh toán chuyển khoản
     *
     * @param XacNhanThanhToanRequest $request
     * @return JsonResponse
     */
    // Thanh toán dữ liệu.
    public function xacNhanThanhToan(XacNhanThanhToanRequest $request): JsonResponse
    {
        $data = $request->validated();
        $donDatTour = $this->thanhToanService->xacNhanThanhToan($data['maDatTour'], $data['trangThai']);

        // Load các relation
        $donDatTour->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        $message = (strtoupper($data['trangThai']) === 'DONG_Y' || strtoupper($data['trangThai']) === 'TC')
            ? "Xác nhận duyệt thanh toán thành công"
            : "Từ chối xác nhận thanh toán thành công";

        return $this->successResponse(new DonDatTourResource($donDatTour), $message);
    }
}
