<?php

namespace App\Http\Controllers;

use App\Services\TourMauService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TaoTourMauRequest;
use App\Http\Requests\CapNhatTourMauRequest;
use App\Http\Requests\LichTrinhRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Module quản lý tour mẫu.
class TourMauController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected $tourMauService;

    public function __construct(TourMauService $tourMauService)
    {
        $this->tourMauService = $tourMauService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
        ];
    }

    // UC01 | Quản trị viên, Nhân viên sản phẩm | Lấy danh sách tour mẫu.
    public function danhSach(Request $request)
    {
        $this->checkRole(['ADMIN', 'SANPHAM', 'KINHDOANH', 'DIEUHANH', 'KETOAN', 'HDV']);
        
        $tieuDe = $request->query('tieuDe');
        $thoiLuongMin = $request->query('thoiLuongMin');
        $thoiLuongMax = $request->query('thoiLuongMax');
        $size = $request->query('size', 10);

        return $this->ok("Thành công", 
            $this->tourMauService->danhSach($tieuDe, $thoiLuongMin, $thoiLuongMax, $size)
        );
    }

    // UC01 | Quản trị viên, Nhân viên sản phẩm | Xem chi tiết tour mẫu.
    public function chiTiet($id)
    {
        $this->checkRole(['ADMIN', 'SANPHAM', 'KINHDOANH', 'DIEUHANH', 'KETOAN', 'HDV']);
        
        return $this->ok("Thành công", 
            $this->tourMauService->chiTiet($id)
        );
    }

    // UC01 | Nhân viên sản phẩm, Quản trị viên | Thêm mới tour mẫu.
    public function taoMoi(TaoTourMauRequest $request)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        return $this->created(
            $this->tourMauService->taoMoi($request->validated())
        );
    }

    // UC01 | Nhân viên sản phẩm, Quản trị viên | Cập nhật tour mẫu.
    public function capNhat(CapNhatTourMauRequest $request, $id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        return $this->ok("Cập nhật thành công", 
            $this->tourMauService->capNhat($id, $request->validated())
        );
    }

    // UC01 | Nhân viên sản phẩm, Quản trị viên | Xóa tour mẫu.
    public function xoa($id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        $this->tourMauService->xoaMem($id);
        return $this->noContent('Xóa tour mẫu thành công');
    }

    public function saoChep($id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        return $this->created(
            $this->tourMauService->saoChep($id)
        );
    }

    public function themLichTrinh(LichTrinhRequest $request, $id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        return $this->created(
            $this->tourMauService->themLichTrinh($id, $request->validated())
        );
    }

    public function suaLichTrinh(LichTrinhRequest $request, $id, $maLichTrinh)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        return $this->ok("Cập nhật lịch trình thành công", 
            $this->tourMauService->suaLichTrinh($id, $maLichTrinh, $request->validated())
        );
    }

    // UC01 | Nhân viên sản phẩm, Quản trị viên | Xóa tour mẫu (xoaLichTrinh).
    public function xoaLichTrinh($id, $maLichTrinh)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        
        $this->tourMauService->xoaLichTrinh($id, $maLichTrinh);
        return $this->noContent('Xóa lịch trình thành công');
    }

    private function checkRole(array $roles)
    {
        $userRole = auth()->user()->vai_tro;
        if (!in_array($userRole, $roles)) {
            throw new \App\Exceptions\AppException(403, "Bạn không có quyền truy cập");
        }
    }
}
