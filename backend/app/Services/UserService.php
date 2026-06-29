<?php

namespace App\Services;

use App\Models\TaiKhoan;
use App\Models\NhanVien;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private MaTuDongService $maTuDongService
    ) {}

    // UC61 | Quản trị viên | Lấy danh sách tài khoản người dùng.
    public function getList($filters = [], $perPage = 10)
    {
        $query = TaiKhoan::query();

        if (isset($filters['vaiTro'])) {
            $query->where('vai_tro', $filters['vaiTro']);
        }
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('ho_ten', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('so_dien_thoai', 'like', "%{$search}%")
                  ->orWhere('ten_dang_nhap', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    // UC61 | Quản trị viên | Thêm mới tài khoản người dùng.
    public function create(array $data)
    {
        $data['ma_tai_khoan'] = $this->maTuDongService->taoMaTaiKhoanTheoVaiTro($data['vaiTro']);
        $data['mat_khau'] = Hash::make($data['matKhau']);
        
        $taiKhoanData = [
            'ma_tai_khoan' => $data['ma_tai_khoan'],
            'ten_dang_nhap' => $data['tenDangNhap'],
            'mat_khau' => $data['mat_khau'],
            'ho_ten' => $data['hoTen'],
            'cccd' => $data['cccd'] ?? null,
            'ngay_sinh' => $data['ngaySinh'] ?? null,
            'email' => $data['email'] ?? null,
            'so_dien_thoai' => $data['soDienThoai'] ?? null,
            'vai_tro' => $data['vaiTro'],
            'trang_thai' => $data['trangThai'] ?? 'HOAT_DONG',
        ];

        return TaiKhoan::create($taiKhoanData);
    }

    public function taoNhanVienQuanTri(array $data): TaiKhoan
    {
        return DB::transaction(function () use ($data) {
            $maVaiTro = strtoupper($data['maVaiTro'] ?? $data['vaiTro']);
            $vaiTroNhanVien = ['ADMIN', 'SANPHAM', 'KINHDOANH', 'DIEUHANH', 'KETOAN', 'HDV'];

            if (!in_array($maVaiTro, $vaiTroNhanVien, true)) {
                throw AppException::badRequest('Vai trò không hợp lệ cho tài khoản nhân viên');
            }

            $taiKhoan = TaiKhoan::create([
                'ma_tai_khoan' => $this->maTuDongService->taoMaTaiKhoanTheoVaiTro($maVaiTro),
                'ten_dang_nhap' => $data['tenDangNhap'],
                'mat_khau' => Hash::make($data['matKhau']),
                'ho_ten' => $data['hoTen'],
                'email' => $data['email'] ?? null,
                'so_dien_thoai' => $data['soDienThoai'] ?? null,
                'vai_tro' => $maVaiTro,
                'trang_thai' => 'HOAT_DONG',
            ]);

            NhanVien::create([
                'ma_nhan_vien' => $this->maTuDongService->taoMaNhanVien(),
                'ma_tai_khoan' => $taiKhoan->ma_tai_khoan,
                'loai_nhan_vien' => $maVaiTro,
                'ngay_vao_lam' => now(),
                'trang_thai_lam_viec' => 'HOAT_DONG',
            ]);

            return $taiKhoan->load('vaiTro');
        });
    }

    // UC61 | Quản trị viên | Cập nhật tài khoản người dùng.
    public function update($id, array $data)
    {
        $taiKhoan = TaiKhoan::findOrFail($id);

        $updateData = [
            'ten_dang_nhap' => $data['tenDangNhap'],
            'ho_ten' => $data['hoTen'],
            'cccd' => $data['cccd'] ?? null,
            'ngay_sinh' => $data['ngaySinh'] ?? null,
            'email' => $data['email'] ?? null,
            'so_dien_thoai' => $data['soDienThoai'] ?? null,
            'vai_tro' => $data['vaiTro'],
            'trang_thai' => $data['trangThai'],
        ];

        if (!empty($data['matKhau'])) {
            $updateData['mat_khau'] = Hash::make($data['matKhau']);
        }

        $taiKhoan->update($updateData);

        return $taiKhoan;
    }

    // UC61 | Quản trị viên | Xóa tài khoản người dùng.
    public function delete($id)
    {
        $taiKhoan = TaiKhoan::findOrFail($id);
        // Có thể thực hiện xóa mềm (KHOA) thay vì xóa cứng
        $taiKhoan->update(['trang_thai' => 'KHOA']);
        return true;
    }
}
