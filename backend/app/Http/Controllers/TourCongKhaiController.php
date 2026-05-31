<?php

namespace App\Http\Controllers;

use App\Services\TourThucTeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TourCongKhaiController extends Controller
{
    use ApiResponse;

    protected $tourThucTeService;

    public function __construct(TourThucTeService $tourThucTeService)
    {
        $this->tourThucTeService = $tourThucTeService;
    }

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

    public function chiTietTour($maTourThucTe)
    {
        return $this->ok("Thành công", 
            $this->tourThucTeService->chiTietCongKhai($maTourThucTe)
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
