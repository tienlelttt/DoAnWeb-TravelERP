<?php

namespace App\Http\Controllers;

use App\Http\Requests\HuyDonRequest;
use App\Services\HuyDonService;
use App\Http\Resources\DonDatTourResource;
use Illuminate\Http\JsonResponse;

// Module quản lý dữ liệu.
class HuyDonController extends Controller
{
    protected $huyDonService;

    public function __construct(HuyDonService $huyDonService)
    {
        $this->huyDonService = $huyDonService;
    }

    /**
     * Khách hàng gửi yêu cầu hủy đơn hàng (tự động tính phí hủy)
     *
     * @param HuyDonRequest $request
     * @return JsonResponse
     */
    // Hủy dữ liệu.
    public function yeuCauHuyDon(HuyDonRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();
        $donDatTour = $this->huyDonService->yeuCauHuyDon($data['maDatTour'], $data['lyDo'], $user->ma_tai_khoan);

        // Load các relation để trả về response chuẩn
        $donDatTour->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        return $this->successResponse(new DonDatTourResource($donDatTour), "Gửi yêu cầu hủy đơn hàng thành công. Vui lòng chờ Kinh doanh duyệt.");
    }
}
