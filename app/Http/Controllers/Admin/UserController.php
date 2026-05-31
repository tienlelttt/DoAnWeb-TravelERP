<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\CustomPaginatedResourceCollection;
use App\Http\Resources\TaiKhoanResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'vaiTro']);
        $perPage = $request->input('size', 10);
        
        $users = $this->userService->getList($filters, $perPage);
        
        $users->getCollection()->transform(function($user) {
            return new TaiKhoanResource($user);
        });
        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => new \App\Http\Resources\SpringPaginationResource($users)
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->validated());

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Tạo tài khoản thành công',
            'data' => new TaiKhoanResource($user)
        ], 201);
    }

    public function show($id)
    {
        $user = \App\Models\TaiKhoan::findOrFail($id);
        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Chi tiết tài khoản',
            'data' => new TaiKhoanResource($user)
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->userService->update($id, $request->validated());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Cập nhật tài khoản thành công',
            'data' => new TaiKhoanResource($user)
        ]);
    }

    public function destroy($id)
    {
        $this->userService->delete($id);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Khóa tài khoản thành công',
            'data' => null
        ]);
    }
}
