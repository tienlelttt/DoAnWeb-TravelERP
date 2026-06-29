<?php

namespace App\Http\Controllers;

use App\Http\Requests\DangKyNhanVienRequest;
use App\Http\Requests\GanVaiTroRequest;
use App\Http\Resources\TaiKhoanResource;
use App\Http\Resources\NhanVienResponseResource;
use App\Http\Resources\ContractPaginationResource;
use App\Models\NhanVien;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Module quản lý dữ liệu.
class QuanTriCompatController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    // Đăng ký dữ liệu.
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

    // Lấy danh sách dữ liệu.
    public function danhSachNhanVien(Request $request)
    {
        $query = NhanVien::with('taiKhoan');

        if ($request->has('vaiTro')) {
            $vaiTro = $request->input('vaiTro');
            $query->whereHas('taiKhoan', function($q) use ($vaiTro) {
                $q->where('vai_tro', $vaiTro);
            });
        }

        if ($request->has('trangThai')) {
            $trangThai = $request->input('trangThai');
            $query->whereHas('taiKhoan', function($q) use ($trangThai) {
                $q->where('trang_thai', $trangThai);
            });
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('ma_nhan_vien', 'like', "%{$search}%")
                  ->orWhereHas('taiKhoan', function($inner) use ($search) {
                      $inner->where('ho_ten', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('so_dien_thoai', 'like', "%{$search}%")
                            ->orWhere('ten_dang_nhap', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->input('size', 10);
        $nhanViens = $query->paginate($perPage);

        $nhanViens->getCollection()->transform(function($nv) {
            return new NhanVienResponseResource($nv);
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => new ContractPaginationResource($nhanViens)
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    // Xem chi tiết dữ liệu.
    public function chiTietNhanVien(NhanVien $nhanVien)
    {
        $nhanVien->load('taiKhoan');

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Chi tiết nhân viên',
            'data' => new NhanVienResponseResource($nhanVien)
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function ganVaiTro(GanVaiTroRequest $request, NhanVien $nhanVien)
    {
        $maVaiTro = $request->input('maVaiTro');

        DB::transaction(function () use ($nhanVien, $maVaiTro) {
            if ($nhanVien->taiKhoan) {
                $nhanVien->taiKhoan->update([
                    'vai_tro' => $maVaiTro
                ]);
            }
            $nhanVien->update([
                'loai_nhan_vien' => $maVaiTro
            ]);
        });

        $nhanVien->load('taiKhoan');

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Cập nhật vai trò thành công',
            'data' => new NhanVienResponseResource($nhanVien)
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function moKhoaTaiKhoan(NhanVien $nhanVien)
    {
        if ($nhanVien->taiKhoan) {
            $nhanVien->taiKhoan->update([
                'trang_thai' => 'HOAT_DONG'
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Mở khóa tài khoản thành công',
            'data' => null
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function khoaTaiKhoan(NhanVien $nhanVien)
    {
        if ($nhanVien->taiKhoan) {
            $nhanVien->taiKhoan->update([
                'trang_thai' => 'KHOA'
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Khóa tài khoản thành công',
            'data' => null
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
