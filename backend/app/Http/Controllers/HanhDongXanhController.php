<?php

namespace App\Http\Controllers;

use App\Services\HanhDongXanhService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\HanhDongXanhRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Module quản lý hành động xanh.
class HanhDongXanhController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected $hanhDongXanhService;

    public function __construct(HanhDongXanhService $hanhDongXanhService)
    {
        $this->hanhDongXanhService = $hanhDongXanhService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
        ];
    }

    // UC20 | Nhân viên sản phẩm | Lấy danh sách hành động xanh.
    public function danhSach(Request $request)
    {
        $maTourThucTe = $request->query('maTourThucTe');
        return $this->ok("Thành công", $this->hanhDongXanhService->danhSach($maTourThucTe));
    }

    // UC20 | Nhân viên sản phẩm | Xem chi tiết hành động xanh.
    public function chiTiet($id)
    {
        return $this->ok("Thành công", $this->hanhDongXanhService->chiTiet($id));
    }

    // UC20 | Nhân viên sản phẩm, Quản trị viên | Thêm mới hành động xanh.
    public function taoMoi(HanhDongXanhRequest $request)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        return $this->created($this->hanhDongXanhService->taoMoi($request->validated()));
    }

    // UC20 | Nhân viên sản phẩm, Quản trị viên | Cập nhật hành động xanh.
    public function capNhat(HanhDongXanhRequest $request, $id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        return $this->ok("Cập nhật hành động xanh thành công", $this->hanhDongXanhService->capNhat($id, $request->validated()));
    }

    // UC20 | Nhân viên sản phẩm, Quản trị viên | Xóa hành động xanh.
    public function xoa($id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        $this->hanhDongXanhService->xoa($id);
        return $this->noContent('Xóa hành động xanh thành công');
    }

    private function checkRole(array $roles)
    {
        $userRole = auth()->user()->vai_tro;
        if (!in_array($userRole, $roles)) {
            throw new \App\Exceptions\AppException(403, "FORBIDDEN", "Bạn không có quyền truy cập");
        }
    }
}
