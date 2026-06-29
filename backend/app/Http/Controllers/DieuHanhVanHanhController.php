<?php

namespace App\Http\Controllers;

use App\Services\VanHanhService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Module quản lý điều phối HDV.
class DieuHanhVanHanhController extends Controller
{
    public function __construct(
        private VanHanhService $vanHanhService
    ) {}

    // UC37 | Nhân viên điều hành | Lấy danh sách điều phối HDV.
    public function danhSachDoan(string $maTour): JsonResponse
    {
        return $this->successResponse(
            $this->vanHanhService->layDanhSachKhachDieuHanh($maTour),
            'Thành công'
        );
    }

    // UC37 | Nhân viên điều hành | Lấy danh sách điều phối HDV (danhSachSuCo).
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
