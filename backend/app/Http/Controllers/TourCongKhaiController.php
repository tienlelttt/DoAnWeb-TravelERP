<?php

namespace App\Http\Controllers;

use App\Services\TourThucTeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

// Module quản lý tour công khai.
class TourCongKhaiController extends Controller
{
    use ApiResponse;

    protected $tourThucTeService;

    public function __construct(TourThucTeService $tourThucTeService)
    {
        $this->tourThucTeService = $tourThucTeService;
    }

    // UC25 | Khách hàng | Lấy danh sách tour công khai.
    public function danhSachTour(Request $request)
    {
        $giaTu = $request->query("giaTu");
        $giaDen = $request->query("giaDen");
        $thoiLuongMin = $request->query("thoiLuongMin");
        $thoiLuongMax = $request->query("thoiLuongMax");
        $size = $request->query("size", 10);

        return $this->ok("Thành công", 
            $this->tourThucTeService->danhSachCongKhai($giaTu, $giaDen, $thoiLuongMin, $thoiLuongMax, $size)
        );
    }

    // UC25 | Khách hàng | Xem chi tiết tour công khai.
    public function chiTietTour($maTourThucTe)
    {
        return $this->ok("Thành công", 
            $this->tourThucTeService->chiTietCongKhai($maTourThucTe)
        );
    }

    public function lichTrinh(string $maTourThucTe): JsonResponse
    {
        $tour = \App\Models\TourThucTe::with('tourMau.lichTrinhTours')->find($maTourThucTe);
        if (!$tour || !$tour->tourMau) {
            throw \App\Exceptions\AppException::notFound("Không tìm thấy tour: {$maTourThucTe}");
        }

        return $this->successResponse(
            $tour->tourMau->lichTrinhTours()->orderBy('ngay_thu')->get(),
            "Thành công"
        );
    }

    public function danhGia(string $maTourThucTe): JsonResponse
    {
        return $this->successResponse($this->tourThucTeService->layDanhGia($maTourThucTe), "Thành công");
    }

    public function hanhDongXanh(string $maTourThucTe): JsonResponse
    {
        $data = $this->tourThucTeService->layHanhDongXanh($maTourThucTe);
        return $this->successResponse(\App\Http\Resources\HanhDongXanhResource::collection($data), "Thành công");
    }

    public function dichVuThem(string $maTourThucTe): JsonResponse
    {
        $data = $this->tourThucTeService->layDichVuThem($maTourThucTe);
        return $this->successResponse(\App\Http\Resources\DichVuThemResource::collection($data), "Thành công");
    }
}
