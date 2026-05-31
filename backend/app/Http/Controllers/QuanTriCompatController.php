<?php

namespace App\Http\Controllers;

use App\Http\Requests\DangKyNhanVienRequest;
use App\Http\Resources\TaiKhoanResource;
use App\Services\UserService;

class QuanTriCompatController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function dangKyNhanVien(DangKyNhanVienRequest $request)
    {
        $taiKhoan = $this->userService->taoNhanVienQuanTri($request->validated());

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Tạo tài khoản nhân viên thành công',
            'data' => new TaiKhoanResource($taiKhoan),
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }
}
