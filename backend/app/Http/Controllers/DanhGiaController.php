<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhGiaRequest;
use App\Services\DanhGiaService;
use Illuminate\Http\Request;

// Module quản lý đánh giá.
class DanhGiaController extends Controller
{
    protected $danhGiaService;

    public function __construct(DanhGiaService $danhGiaService)
    {
        $this->danhGiaService = $danhGiaService;
    }

    // UC35 | Khách hàng | Gửi đánh giá.
    public function guiDanhGia(DanhGiaRequest $request)
    {
        $user = auth()->user();
        $result = $this->danhGiaService->guiDanhGia($user->ma_tai_khoan, $request->validated());
        return $this->successResponse($result, 'Đánh giá tour thành công', 201);
    }

    // UC35 | Khách hàng | Lấy danh sách đánh giá.
    public function danhSachDanhGia(Request $request, $maTourThucTe)
    {
        $perPage = $request->query('size', $request->query('per_page', 10));
        $result = $this->danhGiaService->danhSachDanhGia($maTourThucTe, $perPage);
        return $this->successResponse($result, 'Lấy danh sách đánh giá thành công');
    }

    public function tatCaDanhGia(Request $request)
    {
        $perPage = $request->query('size', $request->query('per_page', 10));
        $result = $this->danhGiaService->tatCaDanhGia($perPage);
        return $this->successResponse($result, 'Lấy danh sách đánh giá thành công');
    }
}
