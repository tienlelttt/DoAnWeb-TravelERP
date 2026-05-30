<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\MaTuDongService;

class TaiKhoanAdminSeeder extends Seeder
{
    public function run(MaTuDongService $maTuDongService): void
    {
        $adminUsername = 'admin_test';
        if (!DB::table('TAIKHOAN')->where('TenDangNhap', $adminUsername)->exists()) {
            DB::table('TAIKHOAN')->insert([
                'MaTaiKhoan' => $maTuDongService->taoMaTaiKhoanTheoVaiTro('ADMIN'),
                'TenDangNhap' => $adminUsername,
                'MatKhau' => Hash::make('123456'),
                'HoTen' => 'Quản Trị Viên Test',
                'VaiTro' => 'ADMIN',
                'TrangThai' => 'HOAT_DONG'
            ]);
        }

        $sanphamUsername = 'sanpham_test';
        if (!DB::table('TAIKHOAN')->where('TenDangNhap', $sanphamUsername)->exists()) {
            DB::table('TAIKHOAN')->insert([
                'MaTaiKhoan' => $maTuDongService->taoMaTaiKhoanTheoVaiTro('SANPHAM'),
                'TenDangNhap' => $sanphamUsername,
                'MatKhau' => Hash::make('123456'),
                'HoTen' => 'Nhân Viên Sản Phẩm Test',
                'VaiTro' => 'SANPHAM',
                'TrangThai' => 'HOAT_DONG'
            ]);
        }
    }
}
