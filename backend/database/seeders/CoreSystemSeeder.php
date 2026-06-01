<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CoreSystemSeeder extends Seeder
{
    /**
     * Nạp dữ liệu vào cơ sở dữ liệu.
     */
    public function run(): void
    {
        $this->command->info("Đang khởi tạo Roles...");

        $roles = [
            ['ma_vai_tro' => 'ADMIN',     'ten_hien_thi' => 'Quản trị hệ thống'],
            ['ma_vai_tro' => 'SANPHAM',   'ten_hien_thi' => 'Nhân viên sản phẩm'],
            ['ma_vai_tro' => 'KINHDOANH', 'ten_hien_thi' => 'Nhân viên kinh doanh'],
            ['ma_vai_tro' => 'DIEUHANH',  'ten_hien_thi' => 'Nhân viên điều hành'],
            ['ma_vai_tro' => 'KETOAN',    'ten_hien_thi' => 'Kế toán'],
            ['ma_vai_tro' => 'HDV',       'ten_hien_thi' => 'Hướng dẫn viên'],
            ['ma_vai_tro' => 'KHACHHANG', 'ten_hien_thi' => 'Khách hàng'],
        ];

        foreach ($roles as $role) {
            DB::table('vai_tros')->updateOrInsert(
                ['ma_vai_tro' => $role['ma_vai_tro']],
                ['ten_hien_thi' => $role['ten_hien_thi']]
            );
        }

        $this->command->info("Đang khởi tạo tài khoản Admin mặc định...");

        DB::table('tai_khoans')->updateOrInsert(
            ['ma_tai_khoan' => 'TK_ADMIN01'],
            [
                'ten_dang_nhap' => 'admin',
                'mat_khau'      => Hash::make('password'),
                'ho_ten'        => 'Admin',
                'cccd'          => '079099000001',
                'ngay_sinh'     => '1988-01-12',
                'email'         => 'admin@digitaltravel.vn',
                'so_dien_thoai' => '0900000001',
                'vai_tro'       => 'ADMIN',
                'trang_thai'    => 'HOAT_DONG',
            ]
        );

        DB::table('nhan_viens')->updateOrInsert(
            ['ma_nhan_vien' => 'NV_ADMIN01'],
            [
                'ma_tai_khoan'         => 'TK_ADMIN01',
                'loai_nhan_vien'       => 'ADMIN',
                'ngay_vao_lam'         => '2022-01-01',
                'trang_thai_lam_viec'  => 'HOAT_DONG',
            ]
        );

        $this->command->info("CoreSystemSeeder hoàn tất!");
    }
}