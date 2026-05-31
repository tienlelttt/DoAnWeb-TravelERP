<?php

namespace App\Http\Controllers;

use App\Http\Requests\XuLyHuyRequest;
use App\Services\HuyDonService;
use App\Http\Resources\DonDatTourResource;
use Illuminate\Http\JsonResponse;

class XuLyHuyController extends Controller
{
    protected $huyDonService;

    public function __construct(HuyDonService $huyDonService)
    {
        $this->huyDonService = $huyDonService;
    }

    /**
     * Nhân viên Kinh doanh (Sales) xử lý yêu cầu hủy đơn hàng
     *
     * @param XuLyHuyRequest $request
     * @return JsonResponse
     */
    public function xuLyHuy(XuLyHuyRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();
        $donDatTour = $this->huyDonService->xuLyHuyDon($data['maDatTour'], $data['trangThai'], $user->ma_tai_khoan);

        // Load các relation
        $donDatTour->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        $message = (strtoupper($data['trangThai']) === 'DONG_Y' || strtoupper($data['trangThai']) === 'TC')
            ? "Đã phê duyệt yêu cầu hủy đơn hàng. Vui lòng chờ Kế toán hoàn tiền."
            : "Đã từ chối yêu cầu hủy đơn hàng. Đơn hàng quay về trạng thái hoạt động.";

        return $this->successResponse(new DonDatTourResource($donDatTour), $message);
    }

    /**
     * Nhân viên Kinh doanh (Sales) duyệt đơn đặt tour VIP hoặc công nợ trực tiếp
     *
     * @param string $maDon
     * @return JsonResponse
     */
    public function duyetDonVip(string $maDon): JsonResponse
    {
        $donDatTour = $this->huyDonService->duyetDonVip($maDon);

        // Load các relation
        $donDatTour->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        return $this->successResponse(new DonDatTourResource($donDatTour), "Duyệt đơn đặt tour VIP/công nợ thành công");
    }
}
