<?php

namespace App\Http\Controllers;

use App\Services\DichVuThemService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DichVuThemRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Module quản lý dịch vụ bổ sung.
class DichVuThemController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected $dichVuThemService;

    public function __construct(DichVuThemService $dichVuThemService)
    {
        $this->dichVuThemService = $dichVuThemService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
        ];
    }

    // UC15 | Nhân viên sản phẩm, NV kế toán | Lấy danh sách dịch vụ bổ sung.
    public function danhSach(Request $request)
    {
        $maTourThucTe = $request->query('maTourThucTe');
        return $this->ok("Thành công", $this->dichVuThemService->danhSach($maTourThucTe));
    }

    // UC15 | Nhân viên sản phẩm, NV kế toán | Xem chi tiết dịch vụ bổ sung.
    public function chiTiet($id)
    {
        return $this->ok("Thành công", $this->dichVuThemService->chiTiet($id));
    }

    // UC15 | Nhân viên sản phẩm, Quản trị viên | Thêm mới dịch vụ bổ sung.
    public function taoMoi(DichVuThemRequest $request)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        return $this->created($this->dichVuThemService->taoMoi($request->validated()));
    }

    // UC15 | Nhân viên sản phẩm, Quản trị viên | Cập nhật dịch vụ bổ sung.
    public function capNhat(DichVuThemRequest $request, $id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        return $this->ok("Cập nhật dịch vụ thành công", $this->dichVuThemService->capNhat($id, $request->validated()));
    }

    // UC15 | Nhân viên sản phẩm, Quản trị viên | Xóa dịch vụ bổ sung.
    public function xoa($id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        $this->dichVuThemService->xoa($id);
        return $this->noContent('Xóa dịch vụ thành công');
    }

    private function checkRole(array $roles)
    {
        $userRole = auth()->user()->vai_tro;
        if (!in_array($userRole, $roles)) {
            throw new \App\Exceptions\AppException(403, "FORBIDDEN", "Bạn không có quyền truy cập");
        }
    }
}
