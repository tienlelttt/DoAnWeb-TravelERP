<?php

namespace App\Http\Middleware;

use App\Models\NhatKyHeThong;
use App\Services\MaTuDongService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditLogMiddleware
{
    public function __construct(
        private MaTuDongService $maTuDongService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Chỉ log các method thay đổi dữ liệu
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $user = auth('api')->user();

            if ($user) {
                // Xác định Action name
                $action = $request->method();
                
                // Xác định Target (ví dụ: api/admin/users/TK001 -> users)
                $path = $request->path();
                $segments = $request->segments();
                
                $objectName = null;
                $objectId = null;
                
                // Cố gắng parse objectName và objectId từ URL
                if (count($segments) >= 3) {
                    $objectName = $segments[2]; // VD: users
                    if (count($segments) >= 4) {
                        $objectId = $segments[3]; // VD: TK001
                    }
                } else {
                    $objectName = $path;
                }

                $maNhatKy = $this->maTuDongService->taoMaNhatKyHeThong();

                NhatKyHeThong::create([
                    'ma_nhat_ky_he_thong' => $maNhatKy,
                    'ma_tai_khoan' => $user->ma_tai_khoan,
                    'hanh_dong' => $action . ' ' . $objectName,
                    'doi_tuong' => $objectName,
                    'ma_doi_tuong' => $objectId,
                    'thoi_gian' => now()
                ]);
            }
        }

        return $response;
    }
}
