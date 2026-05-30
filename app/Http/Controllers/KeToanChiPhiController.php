<?php

namespace App\Http\Controllers;

use App\Services\KeToanChiPhiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KeToanChiPhiController extends Controller
{
    protected KeToanChiPhiService $keToanChiPhiService;

    public function __construct(KeToanChiPhiService $keToanChiPhiService)
    {
        $this->keToanChiPhiService = $keToanChiPhiService;
    }

    public function danhSachChiPhi(Request $request): JsonResponse
    {
        $filters = [
            "maTour" => $request->query("maTour"),
            "trangThaiDuyet" => $request->query("trangThaiDuyet")
        ];

        $data = $this->keToanChiPhiService->danhSachChiPhi($filters);
        return $this->successResponse($data, "Lấy danh sách chi phí thành công");
    }

    public function duyetChiPhi(string $maChiPhi): JsonResponse
    {
        $chiPhi = $this->keToanChiPhiService->duyetChiPhi($maChiPhi);
        return $this->successResponse($chiPhi, "Đã duyệt khoản chi phí");
    }

    public function tuChoiChiPhi(string $maChiPhi): JsonResponse
    {
        $chiPhi = $this->keToanChiPhiService->tuChoiChiPhi($maChiPhi);
        return $this->successResponse($chiPhi, "Đã từ chối khoản chi phí");
    }

    public function yeuCauBoSungChiPhi(string $maChiPhi): JsonResponse
    {
        $chiPhi = $this->keToanChiPhiService->yeuCauBoSungChiPhi($maChiPhi);
        return $this->successResponse($chiPhi, "Đã yêu cầu bổ sung chứng từ chi phí");
    }
}
