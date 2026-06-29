<?php

namespace App\Http\Controllers;

use App\Services\TourThucTeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TaoTourThucTeRequest;
use App\Http\Requests\CapNhatTourThucTeRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Module quản lý tour thực tế.
class TourThucTeController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected $tourThucTeService;

    public function __construct(TourThucTeService $tourThucTeService)
    {
        $this->tourThucTeService = $tourThucTeService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
        ];
    }

    // UC10 | Quản trị viên, Nhân viên sản phẩm | Lấy danh sách tour thực tế.
    public function danhSach(Request $request)
    {
        $this->checkRole(['ADMIN', 'SANPHAM', 'KINHDOANH', 'DIEUHANH', 'KETOAN', 'HDV']);
        
        $trangThai = $request->query('trangThai');
        $maTourMau = $request->query('maTourMau');
        $giaTu = $request->query('giaTu');
        $giaDen = $request->query('giaDen');
        $thoiLuongMin = $request->query('thoiLuongMin');
        $thoiLuongMax = $request->query('thoiLuongMax');
        $congKhai = $request->query('congKhai', 'false');
        $size = $request->query('size', 10);

        if ($congKhai === 'true') {
            return $this->ok("Thành công", 
                $this->tourThucTeService->danhSachCongKhai($giaTu, $giaDen, $thoiLuongMin, $thoiLuongMax, $size)
            );
        } else {
            return $this->ok("Thành công", 
                $this->tourThucTeService->danhSach($trangThai, $maTourMau, $giaTu, $giaDen, $size)
            );
        }
    }

    // UC10 | Quản trị viên, Nhân viên sản phẩm | Xem chi tiết tour thực tế.
    public function chiTiet($id)
    {
        $this->checkRole(['ADMIN', 'SANPHAM', 'KINHDOANH', 'DIEUHANH', 'KETOAN', 'HDV']);
        
        return $this->ok("Thành công", 
            $this->tourThucTeService->chiTiet($id)
        );
    }

    // UC10 | Nhân viên sản phẩm, Nhân viên điều hành | Thêm mới tour thực tế.
    public function taoMoi(TaoTourThucTeRequest $request)
    {
        $this->checkRole(['SANPHAM', 'DIEUHANH', 'ADMIN']);
        
        return $this->created(
            $this->tourThucTeService->taoMoi($request->validated())
        );
    }

    // UC10 | Nhân viên sản phẩm, Nhân viên điều hành | Cập nhật tour thực tế.
    public function capNhat(CapNhatTourThucTeRequest $request, $id)
    {
        $this->checkRole(['SANPHAM', 'DIEUHANH', 'ADMIN']);
        
        return $this->ok("Cập nhật thành công", 
            $this->tourThucTeService->capNhat($id, $request->validated())
        );
    }

    // UC10 | Nhân viên sản phẩm, Nhân viên điều hành | Xóa tour thực tế.
    public function xoa($id, Request $request)
    {
        $this->checkRole(['SANPHAM', 'DIEUHANH', 'ADMIN']);
        
        $lyDo = $request->input('ly_do_huy');
        $this->tourThucTeService->xoa($id, $lyDo);
        return $this->noContent('Hủy tour thực tế thành công');
    }

    private function checkRole(array $roles)
    {
        $userRole = auth()->user()->vai_tro;
        if (!in_array($userRole, $roles)) {
            throw \App\Exceptions\AppException::forbidden("Bạn không có quyền truy cập");
        }
    }
}
