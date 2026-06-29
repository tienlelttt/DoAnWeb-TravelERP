<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealDataSeeder extends Seeder
{
    /**
     * Nạp dữ liệu nghiệp vụ (Sử dụng dữ liệu thực/Demo)
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command->warn('CẨN THẬN: Bạn đang định nạp dữ liệu vào môi trường PRODUCTION.');
            if (!$this->command->confirm('Bạn có chắc chắn muốn nạp dữ liệu nghiệp vụ không?')) {
                return;
            }
        }

        $resolveSeedPath = function (string $path): string {
            $isAbsolute = str_starts_with($path, '/') || preg_match('/^[A-Za-z]:[\\\\\\/]/', $path) === 1;
            return $isAbsolute ? $path : base_path($path);
        };

        $taiKhoanPath = $resolveSeedPath(env('SEED_SQL_TAI_KHOAN_PATH', 'database/raw-sql/accounts_seed.sql'));
        $khoiTaoPath = $resolveSeedPath(env('SEED_SQL_KHOI_TAO_PATH', 'database/raw-sql/business_demo_seed.sql'));


        if (!file_exists($taiKhoanPath)) {
            $this->command?->info("Bỏ qua RealDataSeeder vì không tìm thấy file SQL tại thư mục database/raw-sql.");
            return;
        }

        $this->command->info("Đang nạp dữ liệu từ các file SQL thuần...");
        $taiKhoanSql = file_get_contents($taiKhoanPath);
        $khoiTaoSql = file_get_contents(database_path('raw-sql/business_full_seed_generated.sql'));

        // Bỏ BOM nếu có
        $taiKhoanSql = preg_replace('/^\xEF\xBB\xBF/', '', $taiKhoanSql);
        $khoiTaoSql = preg_replace('/^\xEF\xBB\xBF/', '', $khoiTaoSql);

        $this->command->info("Bắt đầu dọn dẹp và nạp dữ liệu vào Database...");

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("SET sql_mode = 'PIPES_AS_CONCAT';");

        $tablesToTruncate = [
            'chi_phi_thuc_tes', 'chi_tiet_dat_tours', 'chi_tiet_dich_vus', 'danh_gia_khs', 'dat_tour_uu_dais',
            'dich_vu_thems', 'dich_vu_tour_thuc_tes', 'diem_danhs', 'don_dat_tours', 'ds_nguoi_dong_hanhs',
            'giao_diches', 'hanh_dongs', 'hanh_dong_xanhs', 'hdx_tour_thuc_tes', 'ho_chieu_sos',
            'khuyen_mai_khs', 'lich_su_tours', 'lich_trinh_tours', 'nang_luc_nhan_viens',
            'nhat_ky_doi_diems', 'nhat_ky_he_thongs', 'nhat_ky_su_cos', 'phan_cong_tours', 'quyet_toans',
            'tour_maus', 'tour_thuc_tes', 'vouchers', 'yeu_cau_ho_tros'
        ];

        foreach ($tablesToTruncate as $table) {
            DB::table($table)->truncate();
        }
        
        DB::table('nhan_viens')->where('ma_nhan_vien', '!=', 'NV_ADMIN01')->delete();
        DB::table('tai_khoans')->where('ma_tai_khoan', '!=', 'TK_ADMIN01')->delete();
        
        $this->command->info("Đã làm sạch dữ liệu cũ.");

        $executeSqlBlocks = function ($sql) {
            $blocks = preg_split('/^\s*\/[\s\r\n]*$/m', $sql);

            foreach ($blocks as $block) {
                $block = trim($block);
                if (empty($block)) {
                    continue;
                }
                
                if (stripos($block, 'them_don_tmnew') !== false) {
                    $this->command->info("Đang sinh dữ liệu nghiệp vụ bằng logic PHP native...");
                    $this->seedNativeTmnewOrders();
                    continue;
                }
                
                DB::unprepared($block);
            }
        };

        $this->command->info("Đang nạp file tài khoản nhân viên...");
        DB::unprepared($taiKhoanSql);

        $this->command->info("Đang nạp file khởi tạo dữ liệu nghiệp vụ du lịch...");
        $executeSqlBlocks($khoiTaoSql);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("Seed dữ liệu hoàn thành thành công và an toàn!");
    }

    private function seedNativeTmnewOrders(): void
    {
        $this->themDonTmnew('PN10', 'TTT_PHONGNHA_01', 'KH_03', 5450000, 10, 'DVT_TMNEW_CAVE', 10, 220000, 'VC_TMNEW_1M', 1000000, 'NOW() - INTERVAL 3 DAY', 'CHUYEN_KHOAN', 'Đoàn mười khách đặt tour Phong Nha.', 'HDX_TMNEW_WATER:10', 501);
        $this->themDonTmnew('CM06', 'TTT_CAMAU_02', 'KH_04', 7100000, 6, 'DVT_TMNEW_BOAT', 1, 1800000, null, 0, 'NOW() - INTERVAL 120 DAY', 'THE_QUOC_TE', 'Đoàn sáu khách hoàn thành tour Cà Mau.', 'HDX_TMNEW_LOCAL:6', 502);
        $this->themDonTmnew('BB04', 'TTT_BABE_02', 'KH_08', 3600000, 4, 'DVT_TMNEW_HOMESTAY', 2, 420000, null, 0, 'NOW() - INTERVAL 5 DAY', 'VI_DIEN_TU', 'Bốn khách đang tham gia tour Ba Bể.', 'HDX_TMNEW_WATER:4', 503);
        $this->themDonTmnew('PN05', 'TTT_PHONGNHA_02', 'KH_02', 5400000, 5, 'DVT_TMNEW_CAVE', 5, 220000, null, 0, 'NOW() - INTERVAL 145 DAY', 'CHUYEN_KHOAN', 'Năm khách đã đi tour Phong Nha.', 'HDX_TMNEW_LOCAL:5', 504);
    }

    private function themDonTmnew(string $p_MaGon, string $p_MaTour, string $p_MaKhachHang, float $p_GiaTour, int $p_SoKhach, string $p_MaDichVu, int $p_SoLuongDV, float $p_DonGiaDV, ?string $p_MaVoucher, float $p_TienUuDai, string $p_NgayDat, string $p_PhuongThuc, string $p_GhiChu, string $p_HanhDong, int $p_Seed): void 
    {
        $v_MaDatTour = 'DDT_TMNEW_' . $p_MaGon;
        $v_TongTien = $p_SoKhach * $p_GiaTour + $p_SoLuongDV * $p_DonGiaDV - $p_TienUuDai;

        DB::table('don_dat_tours')->insert([
            'ma_dat_tour'       => $v_MaDatTour,
            'ma_tour_thuc_te'   => $p_MaTour,
            'ma_khach_hang'     => $p_MaKhachHang,
            'ngay_dat'          => DB::raw($p_NgayDat),
            'tong_tien'         => $v_TongTien,
            'trang_thai'        => 'CHO_XAC_NHAN',
            'thoi_gian_het_han' => DB::raw("({$p_NgayDat}) + INTERVAL 4 DAY"),
            'ghi_chu'           => $p_GhiChu,
            'hanh_dong_xanh'    => $p_HanhDong,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('chi_tiet_dat_tours')->insert([
            'ma_chi_tiet_dat'       => 'CTDT_TMN_' . $p_MaGon . '_KH',
            'ma_dat_tour'           => $v_MaDatTour,
            'ma_khach_hang'         => $p_MaKhachHang,
            'ma_nguoi_dong_hanh'    => null,
            'loai_khach'            => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => $p_GiaTour,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        for ($i = 1; $i <= $p_SoKhach - 1; $i++) {
            $v_Ndh = 'NDH_TMN_' . $p_MaGon . '_' . str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $ngaySinh = date('Y-m-d', strtotime("-240 months"));

            DB::table('ds_nguoi_dong_hanhs')->insert([
                'ma_nguoi_dong_hanh' => $v_Ndh,
                'ma_dat_tour'        => $v_MaDatTour,
                'ho_ten'             => 'Người đồng hành ' . $i,
                'cccd'               => '0888' . str_pad((string)($p_Seed * 100 + $i), 8, '0', STR_PAD_LEFT),
                'so_dien_thoai'      => '0944' . str_pad((string)($p_Seed * 100 + $i), 6, '0', STR_PAD_LEFT),
                'ngay_sinh'          => $ngaySinh,
                'gioi_tinh'          => ($i % 2 === 0) ? 'NỮ' : 'NAM',
                'ghi_chu'            => 'Khách đi cùng',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            DB::table('chi_tiet_dat_tours')->insert([
                'ma_chi_tiet_dat'       => 'CTDT_TMN_' . $p_MaGon . '_N' . $i,
                'ma_dat_tour'           => $v_MaDatTour,
                'ma_khach_hang'         => null,
                'ma_nguoi_dong_hanh'    => $v_Ndh,
                'loai_khach'            => 'NGUOI_DONG_HANH',
                'gia_tai_thoi_diem_dat' => $p_GiaTour,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }

        DB::table('chi_tiet_dich_vus')->insert([
            'ma_chi_tiet_dich_vu' => 'CTDV_TMN_' . $p_MaGon,
            'ma_dat_tour'         => $v_MaDatTour,
            'ma_dich_vu_them'     => $p_MaDichVu,
            'so_luong'            => $p_SoLuongDV,
            'don_gia'             => $p_DonGiaDV,
            'thanh_tien'          => $p_SoLuongDV * $p_DonGiaDV,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        if ($p_MaVoucher !== null) {
            DB::table('dat_tour_uu_dais')->insert([
                'ma_dat_tour'    => $v_MaDatTour,
                'ma_voucher'     => $p_MaVoucher,
                'so_tien_uu_dai' => $p_TienUuDai,
                'ngay_ap_dung'   => DB::raw($p_NgayDat),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        DB::table('giao_diches')->insert([
            'ma_giao_dich'    => 'GD_TMN_' . $p_MaGon . '_PAY',
            'ma_dat_tour'     => $v_MaDatTour,
            'loai_giao_dich'  => 'THANH_TOAN',
            'phuong_thuc'     => $p_PhuongThuc,
            'so_tien'         => $v_TongTien,
            'ma_gdnh'         => 'BANK-TMN-' . $p_MaGon,
            'trang_thai'      => 'THANH_CONG',
            'ngay_thanh_toan' => DB::raw("({$p_NgayDat}) + INTERVAL 1 DAY"),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
