<?php

namespace App\Http\Controllers;

use App\Http\Requests\DatTourRequest;
use App\Services\DatTourService;
use Illuminate\Http\Request;

// Module quản lý đơn đặt tour.
class DatTourController extends Controller
{
    protected $datTourService;

    public function __construct(DatTourService $datTourService)
    {
        $this->datTourService = $datTourService;
    }

    public function datTour(DatTourRequest $request)
    {
        $user = auth()->user();
        $result = $this->datTourService->datTour($user->ma_tai_khoan, $request->validated());
        return $this->successResponse($result, 'Đặt tour thành công', 201);
    }

    // UC34 | Nhân viên | Lấy danh sách đơn đặt tour.
    public function danhSachCuaToi(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->query('per_page', 10);
        $result = $this->datTourService->danhSachCuaToi($user->ma_tai_khoan, $perPage);
        return $this->successResponse($result, 'Lấy danh sách đơn đặt tour thành công');
    }

    // UC34 | Nhân viên | Xem chi tiết đơn đặt tour.
    public function chiTietCuaToi($maDatTour)
    {
        $user = auth()->user();
        $result = $this->datTourService->chiTietCuaToi($user->ma_tai_khoan, $maDatTour);
        return $this->successResponse($result, 'Lấy chi tiết đơn đặt tour thành công');
    }

    // UC34 | Nhân viên | Hủy đơn đặt tour.
    public function huyDatTour($maDatTour)
    {
        $user = auth()->user();
        $this->datTourService->huyDatTour($user->ma_tai_khoan, $maDatTour);
        return $this->successResponse(null, 'Hủy đơn đặt tour thành công');
    }
}
