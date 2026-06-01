<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('don_dat_tours', function (Blueprint $table) {
            $table->index(['ma_khach_hang', 'ngay_dat'], 'idx_don_dat_tours_khach_ngay');
            $table->index(['ma_tour_thuc_te', 'trang_thai'], 'idx_don_dat_tours_tour_trang_thai');
            $table->index('trang_thai', 'idx_don_dat_tours_trang_thai');
        });

        Schema::table('tour_thuc_tes', function (Blueprint $table) {
            $table->index(['trang_thai', 'ngay_khoi_hanh'], 'idx_tour_thuc_tes_trang_thai_ngay');
            $table->index('ma_tour_mau', 'idx_tour_thuc_tes_tour_mau');
        });

        Schema::table('giao_diches', function (Blueprint $table) {
            $table->index(['ma_dat_tour', 'trang_thai'], 'idx_giao_diches_dat_tour_trang_thai');
            $table->index(['loai_giao_dich', 'trang_thai'], 'idx_giao_diches_loai_trang_thai');
        });

        Schema::table('phan_cong_tours', function (Blueprint $table) {
            $table->unique(['ma_tour_thuc_te', 'ma_nhan_vien'], 'uq_phan_cong_tours_tour_nhan_vien');
            $table->index(['ma_nhan_vien', 'trang_thai_chap_nhan'], 'idx_phan_cong_tours_nhan_vien_trang_thai');
        });

        Schema::table('chi_phi_thuc_tes', function (Blueprint $table) {
            $table->index(['ma_tour_thuc_te', 'trang_thai_duyet'], 'idx_chi_phi_tour_trang_thai');
            $table->index(['ma_nhan_vien', 'ngay_khai'], 'idx_chi_phi_nhan_vien_ngay');
        });

        Schema::table('nhat_ky_su_cos', function (Blueprint $table) {
            $table->index(['ma_tour_thuc_te', 'thoi_gian_bao_cao'], 'idx_su_co_tour_thoi_gian');
            $table->index(['ma_nhan_vien_bao_cao', 'thoi_gian_bao_cao'], 'idx_su_co_nhan_vien_thoi_gian');
        });

        Schema::table('dat_tour_uu_dais', function (Blueprint $table) {
            $table->unique(['ma_dat_tour', 'ma_voucher'], 'uq_dat_tour_uu_dais_dat_tour_voucher');
        });

        Schema::table('khuyen_mai_khs', function (Blueprint $table) {
            $table->unique(['ma_khach_hang', 'ma_voucher'], 'uq_khuyen_mai_khs_khach_voucher');
            $table->index(['ma_khach_hang', 'trang_thai'], 'idx_khuyen_mai_khs_khach_trang_thai');
        });

        Schema::table('nhat_ky_he_thongs', function (Blueprint $table) {
            $table->index(['ma_tai_khoan', 'thoi_gian'], 'idx_nhat_ky_he_thongs_tai_khoan_thoi_gian');
            $table->index('thoi_gian', 'idx_nhat_ky_he_thongs_thoi_gian');
        });
    }

    public function down(): void
    {
        Schema::table('nhat_ky_he_thongs', function (Blueprint $table) {
            $table->dropIndex('idx_nhat_ky_he_thongs_tai_khoan_thoi_gian');
            $table->dropIndex('idx_nhat_ky_he_thongs_thoi_gian');
        });

        Schema::table('khuyen_mai_khs', function (Blueprint $table) {
            $table->dropUnique('uq_khuyen_mai_khs_khach_voucher');
            $table->dropIndex('idx_khuyen_mai_khs_khach_trang_thai');
        });

        Schema::table('dat_tour_uu_dais', function (Blueprint $table) {
            $table->dropUnique('uq_dat_tour_uu_dais_dat_tour_voucher');
        });

        Schema::table('nhat_ky_su_cos', function (Blueprint $table) {
            $table->dropIndex('idx_su_co_tour_thoi_gian');
            $table->dropIndex('idx_su_co_nhan_vien_thoi_gian');
        });

        Schema::table('chi_phi_thuc_tes', function (Blueprint $table) {
            $table->dropIndex('idx_chi_phi_tour_trang_thai');
            $table->dropIndex('idx_chi_phi_nhan_vien_ngay');
        });

        Schema::table('phan_cong_tours', function (Blueprint $table) {
            $table->dropUnique('uq_phan_cong_tours_tour_nhan_vien');
            $table->dropIndex('idx_phan_cong_tours_nhan_vien_trang_thai');
        });

        Schema::table('giao_diches', function (Blueprint $table) {
            $table->dropIndex('idx_giao_diches_dat_tour_trang_thai');
            $table->dropIndex('idx_giao_diches_loai_trang_thai');
        });

        Schema::table('tour_thuc_tes', function (Blueprint $table) {
            $table->dropIndex('idx_tour_thuc_tes_trang_thai_ngay');
            $table->dropIndex('idx_tour_thuc_tes_tour_mau');
        });

        Schema::table('don_dat_tours', function (Blueprint $table) {
            $table->dropIndex('idx_don_dat_tours_khach_ngay');
            $table->dropIndex('idx_don_dat_tours_tour_trang_thai');
            $table->dropIndex('idx_don_dat_tours_trang_thai');
        });
    }
};
