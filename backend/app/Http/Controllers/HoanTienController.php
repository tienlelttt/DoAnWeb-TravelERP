<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoanTienRequest;
use App\Services\HuyDonService;
use App\Http\Resources\DonDatTourResource;
use Illuminate\Http\JsonResponse;

class HoanTienController extends Controller
{
    protected $huyDonService;

    public function __construct(HuyDonService $huyDonService)
    {
        $this->huyDonService = $huyDonService;
    }

    /**
     * Nhân viên Kế toán (KeToan) xác nhận hoàn tiền thực tế cho khách hàng
     *
     * @param HoanTienRequest $request
     * @return JsonResponse
     */
    public function hoanTien(HoanTienRequest $request): JsonResponse
    {
        $data = $request->validated();
        $donDatTour = $this->huyDonService->hoanTienThucTe($data['maDatTour'], $data['trangThai']);

        // Load các relation
        $donDatTour->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        $message = (strtoupper($data['trangThai']) === 'DONG_Y' || strtoupper($data['trangThai']) === 'TC')
            ? "Xác nhận đã hoàn tiền cho khách hàng và khôi phục chỗ trống của Tour thành công"
            : "Từ chối xác nhận hoàn tiền cho khách hàng thành công. Đơn hàng chuyển sang trạng thái tranh chấp.";

        return $this->successResponse(new DonDatTourResource($donDatTour), $message);
    }
}
