<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Kiểm tra vai trò người dùng.
     * Sử dụng: middleware('role:KHACHHANG') hoặc middleware('role:KINHDOANH,ADMIN')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status'  => 401,
                'success' => false,
                'message' => 'Chưa đăng nhập hoặc token hết hạn',
                'data'    => null,
                'error'   => 'UNAUTHENTICATED',
            ], 401, [], JSON_UNESCAPED_UNICODE);
        }

        // $user->vai_tro là chuỗi FK như 'KHACHHANG', 'ADMIN', ...
        if (!empty($roles) && !in_array($user->vai_tro, $roles, true)) {
            return response()->json([
                'status'  => 403,
                'success' => false,
                'message' => 'Bạn không có quyền truy cập tài nguyên này',
                'data'    => null,
                'error'   => 'FORBIDDEN',
            ], 403, [], JSON_UNESCAPED_UNICODE);
        }

        return $next($request);
    }
}
