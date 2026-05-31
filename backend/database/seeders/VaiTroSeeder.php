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
            ['ma_vai_tro' => 'ADMIN', 'ten_hien_thi' => 'Quản trị hệ thống'],
            ['ma_vai_tro' => 'SANPHAM', 'ten_hien_thi' => 'Nhân viên sản phẩm'],
            ['ma_vai_tro' => 'KINHDOANH', 'ten_hien_thi' => 'Nhân viên kinh doanh'],
            ['ma_vai_tro' => 'DIEUHANH', 'ten_hien_thi' => 'Nhân viên điều hành'],
            ['ma_vai_tro' => 'KETOAN', 'ten_hien_thi' => 'Kế toán'],
            ['ma_vai_tro' => 'HDV', 'ten_hien_thi' => 'Hướng dẫn viên'],
            ['ma_vai_tro' => 'KHACHHANG', 'ten_hien_thi' => 'Khách hàng'],
        ];

        // Dùng insertOrIgnore để chạy nhiều lần không bị lỗi trùng khóa chính
        DB::table('vai_tros')->insertOrIgnore($roles);
    }
}
