<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhanCongTourRequest;
use App\Services\PhanCongTourService;
use Illuminate\Http\JsonResponse;

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
}
