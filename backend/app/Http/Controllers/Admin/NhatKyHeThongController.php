<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhatKyHeThong;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class NhatKyHeThongController extends Controller
{
    use ApiResponse;

    /**
     * API Lấy danh sách nhật ký hệ thống (Audit logs) dành cho ADMIN
     */
    public function danhSach(Request $request): JsonResponse
    {
        $query = NhatKyHeThong::query();

        if ($request->has('maTaiKhoan')) {
            $query->where('ma_tai_khoan', $request->maTaiKhoan);
        }

        if ($request->has('hanhDong')) {
            $query->where('hanh_dong', 'like', '%' . $request->hanhDong . '%');
        }

        if ($request->has('doiTuong')) {
            $query->where('doi_tuong', 'like', '%' . $request->doiTuong . '%');
        }
        
        if ($request->has('maDoiTuong')) {
            $query->where('ma_doi_tuong', $request->maDoiTuong);
        }

        if ($request->has('tuThoiGian')) {
            $query->where('thoi_gian', '>=', $request->tuThoiGian);
        }

        if ($request->has('denThoiGian')) {
            $query->where('thoi_gian', '<=', $request->denThoiGian);
        }

        $logs = $query->orderBy('thoi_gian', 'desc')->paginate($request->get('size', 20));

        return $this->successResponse($logs);
    }
}
