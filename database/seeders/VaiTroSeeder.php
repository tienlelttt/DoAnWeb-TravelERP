<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaiTroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['MaVaiTro' => 'ADMIN', 'TenHienThi' => 'Quản trị hệ thống'],
            ['MaVaiTro' => 'SANPHAM', 'TenHienThi' => 'Nhân viên sản phẩm'],
            ['MaVaiTro' => 'KINHDOANH', 'TenHienThi' => 'Nhân viên kinh doanh'],
            ['MaVaiTro' => 'DIEUHANH', 'TenHienThi' => 'Nhân viên điều hành'],
            ['MaVaiTro' => 'KETOAN', 'TenHienThi' => 'Kế toán'],
            ['MaVaiTro' => 'HDV', 'TenHienThi' => 'Hướng dẫn viên'],
            ['MaVaiTro' => 'KHACHHANG', 'TenHienThi' => 'Khách hàng'],
        ];

        // Dùng insertOrIgnore để chạy nhiều lần không bị lỗi trùng khóa chính
        DB::table('VAITRO')->insertOrIgnore($roles);
    }
}
