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
        if (!DB::table('tai_khoans')->where('ten_dang_nhap', $adminUsername)->exists()) {
            DB::table('tai_khoans')->insert([
                'ma_tai_khoan' => $maTuDongService->taoMaTaiKhoanTheoVaiTro('ADMIN'),
                'ten_dang_nhap' => $adminUsername,
                'mat_khau' => Hash::make('123456'),
                'ho_ten' => 'Quản Trị Viên Test',
                'vai_tro' => 'ADMIN',
                'trang_thai' => 'HOAT_DONG'
            ]);
        }

        $sanphamUsername = 'sanpham_test';
        if (!DB::table('tai_khoans')->where('ten_dang_nhap', $sanphamUsername)->exists()) {
            DB::table('tai_khoans')->insert([
                'ma_tai_khoan' => $maTuDongService->taoMaTaiKhoanTheoVaiTro('SANPHAM'),
                'ten_dang_nhap' => $sanphamUsername,
                'mat_khau' => Hash::make('123456'),
                'ho_ten' => 'Nhân Viên Sản Phẩm Test',
                'vai_tro' => 'SANPHAM',
                'trang_thai' => 'HOAT_DONG'
            ]);
        }
    }
}
