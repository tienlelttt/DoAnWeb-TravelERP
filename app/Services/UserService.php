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

    public function getList($filters = [], $perPage = 10)
    {
        $query = TaiKhoan::query();

        if (isset($filters['vaiTro'])) {
            $query->where('VaiTro', $filters['vaiTro']);
        }
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('HoTen', 'like', "%{$search}%")
                  ->orWhere('Email', 'like', "%{$search}%")
                  ->orWhere('SoDienThoai', 'like', "%{$search}%")
                  ->orWhere('TenDangNhap', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data)
    {
        $data['MaTaiKhoan'] = $this->maTuDongService->taoMaTaiKhoanTheoVaiTro($data['vaiTro']);
        $data['MatKhau'] = Hash::make($data['matKhau']);
        
        // Map keys
        $taiKhoanData = [
            'MaTaiKhoan' => $data['MaTaiKhoan'],
            'TenDangNhap' => $data['tenDangNhap'],
            'MatKhau' => $data['MatKhau'],
            'HoTen' => $data['hoTen'],
            'CCCD' => $data['cccd'] ?? null,
            'NgaySinh' => $data['ngaySinh'] ?? null,
            'Email' => $data['email'] ?? null,
            'SoDienThoai' => $data['soDienThoai'] ?? null,
            'VaiTro' => $data['vaiTro'],
            'TrangThai' => $data['trangThai'] ?? 'HOAT_DONG',
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
                'MaTaiKhoan' => $this->maTuDongService->taoMaTaiKhoanTheoVaiTro($maVaiTro),
                'TenDangNhap' => $data['tenDangNhap'],
                'MatKhau' => Hash::make($data['matKhau']),
                'HoTen' => $data['hoTen'],
                'Email' => $data['email'] ?? null,
                'SoDienThoai' => $data['soDienThoai'] ?? null,
                'VaiTro' => $maVaiTro,
                'TrangThai' => 'HOAT_DONG',
            ]);

            NhanVien::create([
                'MaNhanVien' => $this->maTuDongService->taoMaNhanVien(),
                'MaTaiKhoan' => $taiKhoan->MaTaiKhoan,
                'LoaiNhanVien' => $maVaiTro,
                'NgayVaoLam' => now(),
                'TrangThaiLamViec' => 'HOAT_DONG',
            ]);

            return $taiKhoan->load('vaiTro');
        });
    }

    public function update($id, array $data)
    {
        $taiKhoan = TaiKhoan::findOrFail($id);

        $updateData = [
            'TenDangNhap' => $data['tenDangNhap'],
            'HoTen' => $data['hoTen'],
            'CCCD' => $data['cccd'] ?? null,
            'NgaySinh' => $data['ngaySinh'] ?? null,
            'Email' => $data['email'] ?? null,
            'SoDienThoai' => $data['soDienThoai'] ?? null,
            'VaiTro' => $data['vaiTro'],
            'TrangThai' => $data['trangThai'],
        ];

        if (!empty($data['matKhau'])) {
            $updateData['MatKhau'] = Hash::make($data['matKhau']);
        }

        $taiKhoan->update($updateData);

        return $taiKhoan;
    }

    public function delete($id)
    {
        $taiKhoan = TaiKhoan::findOrFail($id);
        // Có thể thực hiện xóa mềm (KHOA) thay vì xóa cứng
        $taiKhoan->update(['TrangThai' => 'KHOA']);
        return true;
    }
}
