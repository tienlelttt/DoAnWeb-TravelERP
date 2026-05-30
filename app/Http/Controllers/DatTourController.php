<?php

namespace App\Http\Controllers;

use App\Http\Requests\DatTourRequest;
use App\Services\DatTourService;
use Illuminate\Http\Request;

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
        $result = $this->datTourService->datTour($user->MaTaiKhoan, $request->validated());
        return $this->successResponse($result, 'Đặt tour thành công', 201);
    }

    public function danhSachCuaToi(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->query('per_page', 10);
        $result = $this->datTourService->danhSachCuaToi($user->MaTaiKhoan, $perPage);
        return $this->successResponse($result, 'Lấy danh sách đơn đặt tour thành công');
    }

    public function chiTietCuaToi($maDatTour)
    {
        $user = auth()->user();
        $result = $this->datTourService->chiTietCuaToi($user->MaTaiKhoan, $maDatTour);
        return $this->successResponse($result, 'Lấy chi tiết đơn đặt tour thành công');
    }

    public function huyDatTour($maDatTour)
    {
        $user = auth()->user();
        $this->datTourService->huyDatTour($user->MaTaiKhoan, $maDatTour);
        return $this->successResponse(null, 'Hủy đơn đặt tour thành công');
    }
}
