<?php

namespace App\Http\Controllers;

use App\Services\HanhDongXanhService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\HanhDongXanhRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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

    public function danhSach(Request $request)
    {
        $maTourThucTe = $request->query('maTourThucTe');
        return $this->ok("Thành công", $this->hanhDongXanhService->danhSach($maTourThucTe));
    }

    public function chiTiet($id)
    {
        return $this->ok("Thành công", $this->hanhDongXanhService->chiTiet($id));
    }

    public function taoMoi(HanhDongXanhRequest $request)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        return $this->created($this->hanhDongXanhService->taoMoi($request->validated()));
    }

    public function capNhat(HanhDongXanhRequest $request, $id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        return $this->ok("Cập nhật hành động xanh thành công", $this->hanhDongXanhService->capNhat($id, $request->validated()));
    }

    public function xoa($id)
    {
        $this->checkRole(['SANPHAM', 'ADMIN']);
        $this->hanhDongXanhService->xoa($id);
        return $this->noContent('Xóa hành động xanh thành công');
    }

    private function checkRole(array $roles)
    {
        $userRole = auth()->user()->VaiTro;
        if (!in_array($userRole, $roles)) {
            throw new \App\Exceptions\AppException(403, "FORBIDDEN", "Bạn không có quyền truy cập");
        }
    }
}
