<?php

namespace App\Http\Controllers;

use App\Services\VanHanhService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function danhSachSuCo(string $maTour, Request $request): JsonResponse
    {
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));

        return $this->paginatedResponse(
            $this->vanHanhService->layDanhSachSuCoDieuHanh($maTour, $perPage),
            'Thành công'
        );
    }

    public function chiPhiCuaTour(string $maTour, Request $request): JsonResponse
    {
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));

        return $this->paginatedResponse(
            $this->vanHanhService->layDanhSachChiPhiDieuHanh($maTour, $perPage),
            'Thành công'
        );
    }
}
