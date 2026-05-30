<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhGiaRequest;
use App\Services\DanhGiaService;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    protected $danhGiaService;

    public function __construct(DanhGiaService $danhGiaService)
    {
        $this->danhGiaService = $danhGiaService;
    }

    public function guiDanhGia(DanhGiaRequest $request)
    {
        $user = auth()->user();
        $result = $this->danhGiaService->guiDanhGia($user->MaTaiKhoan, $request->validated());
        return $this->successResponse($result, 'Đánh giá tour thành công', 201);
    }

    public function danhSachDanhGia(Request $request, $maTourThucTe)
    {
        $perPage = $request->query('per_page', 10);
        $result = $this->danhGiaService->danhSachDanhGia($maTourThucTe, $perPage);
        return $this->successResponse($result, 'Lấy danh sách đánh giá thành công');
    }

    public function tatCaDanhGia(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $result = $this->danhGiaService->tatCaDanhGia($perPage);
        return $this->successResponse($result, 'Lấy danh sách đánh giá thành công');
    }
}
