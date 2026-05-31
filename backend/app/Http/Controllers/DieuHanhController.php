<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhanCongTourRequest;
use App\Services\PhanCongTourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DieuHanhController extends Controller
{
    protected PhanCongTourService $phanCongService;

    public function __construct(PhanCongTourService $phanCongService)
    {
        $this->phanCongService = $phanCongService;
    }

    /**
     * API Phân công HDV (Dành cho Điều Hành)
     */
    public function phanCongTour(PhanCongTourRequest $request): JsonResponse
    {
        $data = $request->validated();
        $phanCong = $this->phanCongService->phanCongHDV($data["maTourThucTe"], $data["maNhanVien"]);
        
        return $this->successResponse($phanCong, "Phân công hướng dẫn viên thành công");
    }

    /**
     * API Lấy danh sách tour cần phân công
     */
    public function tourCanPhanCong(): JsonResponse
    {
        $data = $this->phanCongService->danhSachTourCanPhanCong();
        return $this->successResponse($data);
    }

    /**
     * API Lấy danh sách HDV khả dụng cho tour
     */
    public function hdvKhaDung(Request $request): JsonResponse
    {
        $request->validate(['maTourThucTe' => 'required|string']);
        $data = $this->phanCongService->danhSachHdvKhaDung($request->maTourThucTe);
        return $this->successResponse($data);
    }

    /**
     * API Huỷ phân công
     */
    public function huyPhanCong(string $maPhanCong): JsonResponse
    {
        $this->phanCongService->huyPhanCong($maPhanCong);
        return $this->noContent("Hủy phân công thành công");
    }
}
