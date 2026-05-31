<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration: Đổi tên tất cả bảng từ PascalCase sang snake_case
 * Giai đoạn 7.2 – Chuẩn hóa kiến trúc Laravel
 *
 * KHÔNG xóa dữ liệu, chỉ đổi tên bảng.
 */
return new class extends Migration
{
    /**
     * Danh sách ánh xạ tên bảng cũ (PascalCase) → mới (snake_case)
     */
    private array $bangCanDoi = [
        'chi_phi_thuc_tes'      => 'chi_phi_thuc_tes',
        'chi_tiet_dat_tours'    => 'chi_tiet_dat_tours',
        'chi_tiet_dich_vus'     => 'chi_tiet_dich_vus',
        'danh_gia_khs'         => 'danh_gia_khs',
        'dat_tour_uu_dais'     => 'dat_tour_uu_dais',
        'dich_vu_thems'        => 'dich_vu_thems',
        'dich_vu_tour_thuc_tes' => 'dich_vu_tour_thuc_tes',
        'diem_danhs'          => 'diem_danhs',
        'don_dat_tours'        => 'don_dat_tours',
        'ds_nguoi_dong_hanhs'   => 'ds_nguoi_dong_hanhs',
        'giao_diches'          => 'giao_diches',
        'hanh_dongs'          => 'hanh_dongs',
        'hanh_dong_xanhs'      => 'hanh_dong_xanhs',
        'hdx_tour_thuc_tes'    => 'hdx_tour_thuc_tes',
        'ho_chieu_sos'         => 'ho_chieu_sos',
        'khuyen_mai_khs'      => 'khuyen_mai_khs',
        'lich_su_tours'        => 'lich_su_tours',
        'lich_trinh_tours'     => 'lich_trinh_tours',
        'nang_luc_nhan_viens'   => 'nang_luc_nhan_viens',
        'nhan_viens'          => 'nhan_viens',
        'nhat_ky_doi_diems'     => 'nhat_ky_doi_diems',
        'nhat_ky_he_thongs'     => 'nhat_ky_he_thongs',
        'nhat_ky_su_cos'        => 'nhat_ky_su_cos',
        'phan_cong_tours'      => 'phan_cong_tours',
        'quyet_toans'         => 'quyet_toans',
        'tai_khoans'          => 'tai_khoans',
        'tour_maus'           => 'tour_maus',
        'tour_thuc_tes'        => 'tour_thuc_tes',
        'vai_tros'            => 'vai_tros',
        'vouchers'           => 'vouchers',
        'yeu_cau_ho_tros'       => 'yeu_cau_ho_tros',
    ];

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->bangCanDoi as $tenCu => $tenMoi) {
            // Chỉ rename nếu bảng cũ tồn tại và bảng mới chưa tồn tại
            if (Schema::hasTable($tenCu) && !Schema::hasTable($tenMoi)) {
                Schema::rename($tenCu, $tenMoi);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // Đảo ngược: đổi tên bảng mới về tên cũ
        foreach ($this->bangCanDoi as $tenCu => $tenMoi) {
            if (Schema::hasTable($tenMoi) && !Schema::hasTable($tenCu)) {
                Schema::rename($tenMoi, $tenCu);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
};
