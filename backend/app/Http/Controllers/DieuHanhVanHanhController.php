<?php

namespace App\Http\Controllers;

use App\Services\VanHanhService;
use Illuminate\Http\JsonResponse;

class DieuHanhVanHanhController extends Controller
{
    public function __construct(
        private VanHanhService $vanHanhService
    ) {}

    public function danhSachDoan(string $maTour): JsonResponse
    {
        return $this->successResponse(
            $this->vanHanhService->layDanhSachKhachDieuHanh($maTour),
            'Thành công'
        );
    }

    public function danhSachSuCo(string $maTour): JsonResponse
    {
        return $this->successResponse(
            $this->vanHanhService->layDanhSachSuCoDieuHanh($maTour),
            'Thành công'
        );
    }

    public function chiPhiCuaTour(string $maTour): JsonResponse
    {
        return $this->successResponse(
            $this->vanHanhService->layDanhSachChiPhiDieuHanh($maTour),
            'Thành công'
        );
    }
}
