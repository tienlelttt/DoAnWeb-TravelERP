<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('chi_phi_thuc_tes', function (Blueprint $table) {
            $table->string('ma_chi_phi_thuc_te', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_nhan_vien', 50);
            $table->string('danh_muc', 200);
            $table->decimal('thanh_tien', 18, 2);
            $table->string('hoa_don_anh', 1000)->nullable();
            $table->string('trang_thai_duyet', 20);
            $table->dateTime('ngay_khai');
            $table->timestamps();
        });

        Schema::create('chi_tiet_dat_tours', function (Blueprint $table) {
            $table->string('ma_chi_tiet_dat', 50)->primary();
            $table->string('ma_dat_tour', 50);
            $table->string('ma_khach_hang', 50)->nullable();
            $table->string('ma_nguoi_dong_hanh', 50)->nullable();
            $table->string('loai_khach', 30);
            $table->decimal('gia_tai_thoi_diem_dat', 18, 2);
            $table->timestamps();
        });

        Schema::create('chi_tiet_dich_vus', function (Blueprint $table) {
            $table->string('ma_chi_tiet_dich_vu', 50)->primary();
            $table->string('ma_dat_tour', 50);
            $table->string('ma_dich_vu_them', 50);
            $table->bigInteger('so_luong');
            $table->decimal('don_gia', 18, 2);
            $table->decimal('thanh_tien', 18, 2);
            $table->timestamps();
        });

        Schema::create('danh_gia_khs', function (Blueprint $table) {
            $table->string('ma_danh_gia_khach_hang', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_khach_hang', 50);
            $table->integer('so_sao');
            $table->string('nhan_xet', 255)->nullable();
            $table->dateTime('ngay_danh_gia');
            $table->timestamps();
        });

        Schema::create('dat_tour_uu_dais', function (Blueprint $table) {
            $table->string('ma_dat_tour', 50)->nullable();
            $table->string('ma_voucher', 50)->nullable();
            $table->decimal('so_tien_uu_dai', 18, 2);
            $table->dateTime('ngay_ap_dung')->nullable();
            $table->timestamps();
        });

        Schema::create('dich_vu_thems', function (Blueprint $table) {
            $table->string('ma_dich_vu_them', 50)->primary();
            $table->string('ten', 200);
            $table->string('don_vi_tinh', 100)->nullable();
            $table->decimal('don_gia', 18, 2);
            $table->timestamps();
        });

        Schema::create('dich_vu_tour_thuc_tes', function (Blueprint $table) {
            $table->string('ma_tour_thuc_te', 50)->nullable();
            $table->string('ma_dich_vu_them', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('diem_danhs', function (Blueprint $table) {
            $table->string('ma_diem_danh', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_khach_hang', 50)->nullable();
            $table->string('ma_nguoi_dong_hanh', 50)->nullable();
            $table->string('loai_khach', 30);
            $table->string('ma_nhan_vien', 50);
            $table->dateTime('thoi_gian');
            $table->string('dia_diem', 500)->nullable();
            $table->string('trang_thai', 30);
            $table->timestamps();
        });

        Schema::create('don_dat_tours', function (Blueprint $table) {
            $table->string('ma_dat_tour', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_khach_hang', 50);
            $table->dateTime('ngay_dat');
            $table->decimal('tong_tien', 18, 2);
            $table->string('trang_thai', 30);
            $table->dateTime('thoi_gian_het_han')->nullable();
            $table->string('ghi_chu', 2000)->nullable();
            $table->string('hanh_dong_xanh', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('ds_nguoi_dong_hanhs', function (Blueprint $table) {
            $table->string('ma_nguoi_dong_hanh', 50)->primary();
            $table->string('ma_dat_tour', 50);
            $table->string('ho_ten', 200);
            $table->string('cccd', 20)->nullable();
            $table->string('so_dien_thoai', 20)->nullable();
            $table->dateTime('ngay_sinh')->nullable();
            $table->string('gioi_tinh', 20)->nullable();
            $table->string('ghi_chu', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('giao_diches', function (Blueprint $table) {
            $table->string('ma_giao_dich', 50)->primary();
            $table->string('ma_dat_tour', 50);
            $table->string('loai_giao_dich', 50);
            $table->string('phuong_thuc', 50);
            $table->decimal('so_tien', 18, 2);
            $table->string('ma_gdnh', 200)->nullable();
            $table->string('trang_thai', 30);
            $table->dateTime('ngay_thanh_toan')->nullable();
            $table->timestamps();
        });

        Schema::create('hanh_dongs', function (Blueprint $table) {
            $table->string('ma_ghi_nhan_hanh_dong', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_khach_hang', 50);
            $table->string('ma_hanh_dong_xanh', 50);
            $table->string('ma_nhan_vien_xac_minh', 50);
            $table->dateTime('thoi_gian');
            $table->string('minh_chung', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('hanh_dong_xanhs', function (Blueprint $table) {
            $table->string('ma_hanh_dong_xanh', 50)->primary();
            $table->string('ten_hanh_dong', 200);
            $table->bigInteger('diem_cong');
            $table->timestamps();
        });

        Schema::create('hdx_tour_thuc_tes', function (Blueprint $table) {
            $table->string('ma_tour_thuc_te', 50)->nullable();
            $table->string('ma_hanh_dong_xanh', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('ho_chieu_sos', function (Blueprint $table) {
            $table->string('ma_khach_hang', 50)->primary();
            $table->string('ma_tai_khoan', 50);
            $table->string('ghi_chu_y_te', 255)->nullable();
            $table->string('di_ung', 1000)->nullable();
            $table->string('hang_thanh_vien', 20);
            $table->bigInteger('diem_xanh');
            $table->timestamps();
        });

        Schema::create('khuyen_mai_khs', function (Blueprint $table) {
            $table->string('ma_khach_hang', 50)->nullable();
            $table->string('ma_voucher', 50)->nullable();
            $table->dateTime('ngay_het_han')->nullable();
            $table->dateTime('ngay_nhan');
            $table->string('trang_thai', 20);
            $table->timestamps();
        });

        Schema::create('lich_su_tours', function (Blueprint $table) {
            $table->string('ma_lich_su_tour', 50)->primary();
            $table->string('ma_khach_hang', 50);
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_chi_tiet_dat', 50)->nullable();
            $table->dateTime('ngay_tham_gia')->nullable();
            $table->timestamps();
        });

        Schema::create('lich_trinh_tours', function (Blueprint $table) {
            $table->string('ma_lich_trinh_tour', 50)->primary();
            $table->string('ma_tour_mau', 50);
            $table->integer('ngay_thu');
            $table->string('hoat_dong', 1000)->nullable();
            $table->text('mo_ta')->nullable();
            $table->string('thuc_don', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('nang_luc_nhan_viens', function (Blueprint $table) {
            $table->string('ma_nang_luc_nhan_vien', 50)->primary();
            $table->string('ma_nhan_vien', 50);
            $table->string('ngon_ngu', 200)->nullable();
            $table->string('chung_chi', 500)->nullable();
            $table->string('chuyen_mon', 500)->nullable();
            $table->decimal('danh_gia', 18, 2)->nullable();
            $table->integer('so_danh_gia')->nullable();
            $table->timestamps();
        });

        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->string('ma_nhan_vien', 50)->primary();
            $table->string('ma_tai_khoan', 50);
            $table->string('loai_nhan_vien', 50)->nullable();
            $table->dateTime('ngay_vao_lam')->nullable();
            $table->string('trang_thai_lam_viec', 20);
            $table->timestamps();
        });

        Schema::create('nhat_ky_doi_diems', function (Blueprint $table) {
            $table->string('ma_nhat_ky_doi_diem', 50)->primary();
            $table->string('ma_khach_hang', 50);
            $table->string('ma_voucher', 50);
            $table->bigInteger('diem_quy_doi');
            $table->dateTime('ngay_quy_doi');
            $table->timestamps();
        });

        Schema::create('nhat_ky_he_thongs', function (Blueprint $table) {
            $table->string('ma_nhat_ky_he_thong', 50)->primary();
            $table->string('ma_tai_khoan', 50)->nullable();
            $table->string('hanh_dong', 100);
            $table->string('doi_tuong', 100)->nullable();
            $table->string('ma_doi_tuong', 50)->nullable();
            $table->string('ghi_chu', 255)->nullable();
            $table->dateTime('thoi_gian');
            $table->timestamps();
        });

        Schema::create('nhat_ky_su_cos', function (Blueprint $table) {
            $table->string('ma_nhat_ky_su_co', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_nhan_vien_bao_cao', 50);
            $table->string('ma_khach_hang', 50)->nullable();
            $table->string('ma_nguoi_dong_hanh', 50)->nullable();
            $table->text('mo_ta');
            $table->string('giai_phap', 255)->nullable();
            $table->string('muc_do', 20);
            $table->string('loai_su_co', 30);
            $table->dateTime('thoi_gian_bao_cao');
            $table->timestamps();
        });

        Schema::create('phan_cong_tours', function (Blueprint $table) {
            $table->string('ma_phan_cong_tour', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->string('ma_nhan_vien', 50);
            $table->dateTime('ngay_phan_cong');
            $table->dateTime('ngay_phan_hoi')->nullable();
            $table->string('trang_thai_chap_nhan', 20)->default('CHO_PHAN_HOI');
            $table->timestamps();
        });

        Schema::create('quyet_toans', function (Blueprint $table) {
            $table->string('ma_quyet_toan', 50)->primary();
            $table->string('ma_tour_thuc_te', 50);
            $table->decimal('tong_doanh_thu', 18, 2);
            $table->decimal('tong_chi_phi', 18, 2);
            $table->decimal('gia_cam_ket', 18, 2)->nullable();
            $table->decimal('loi_nhuan', 18, 2);
            $table->string('ma_nhan_vien', 50);
            $table->dateTime('ngay_quyet_toan');
            $table->string('trang_thai', 20);
            $table->string('ghi_chu', 255)->nullable();
            $table->string('hoa_don_anh', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('tai_khoans', function (Blueprint $table) {
            $table->string('ma_tai_khoan', 50)->primary();
            $table->string('ten_dang_nhap', 100)->unique();
            $table->string('mat_khau', 255);
            $table->string('ho_ten', 200);
            $table->string('cccd', 20)->nullable()->unique();
            $table->dateTime('ngay_sinh')->nullable();
            $table->string('email', 200)->nullable()->unique();
            $table->string('so_dien_thoai', 20)->nullable();
            $table->string('vai_tro', 50);
            $table->string('trang_thai', 20);
            $table->timestamps();
        });

        Schema::create('tour_maus', function (Blueprint $table) {
            $table->string('ma_tour_mau', 50)->primary();
            $table->string('tieu_de', 500);
            $table->text('mo_ta')->nullable();
            $table->integer('thoi_luong');
            $table->decimal('gia_san', 18, 2);
            $table->decimal('danh_gia', 18, 2)->nullable();
            $table->integer('so_danh_gia')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_thuc_tes', function (Blueprint $table) {
            $table->string('ma_tour_thuc_te', 50)->primary();
            $table->string('ma_tour_mau', 50);
            $table->dateTime('ngay_khoi_hanh');
            $table->decimal('gia_hien_hanh', 18, 2);
            $table->integer('so_khach_toi_da');
            $table->integer('so_khach_toi_thieu');
            $table->integer('cho_con_lai');
            $table->string('trang_thai', 20);
            $table->timestamps();
        });

        Schema::create('vai_tros', function (Blueprint $table) {
            $table->string('ma_vai_tro', 50)->primary();
            $table->string('ten_hien_thi', 100);
            $table->timestamps();
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('ma_voucher', 50)->primary();
            $table->string('ma_code', 50)->unique();
            $table->string('loai_uu_dai', 20);
            $table->decimal('gia_tri_giam', 18, 2);
            $table->decimal('muc_giam_toi_da', 18, 2)->nullable();
            $table->string('dieu_kien_ap_dung', 2000)->nullable();
            $table->integer('so_luot_phat_hanh');
            $table->integer('so_luot_da_dung');
            $table->dateTime('ngay_hieu_luc');
            $table->dateTime('ngay_het_han');
            $table->string('trang_thai', 20);
            $table->timestamps();
        });

        Schema::create('yeu_cau_ho_tros', function (Blueprint $table) {
            $table->string('ma_yeu_cau_ho_tro', 50)->primary();
            $table->string('ma_dat_tour', 50)->nullable();
            $table->string('ma_khach_hang', 50);
            $table->string('loai_yeu_cau', 100);
            $table->string('noi_dung', 255);
            $table->string('trang_thai', 20);
            $table->string('ma_nhan_vien_xu_ly', 50)->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('chi_phi_thuc_tes');
        Schema::dropIfExists('chi_tiet_dat_tours');
        Schema::dropIfExists('chi_tiet_dich_vus');
        Schema::dropIfExists('danh_gia_khs');
        Schema::dropIfExists('dat_tour_uu_dais');
        Schema::dropIfExists('dich_vu_thems');
        Schema::dropIfExists('dich_vu_tour_thuc_tes');
        Schema::dropIfExists('diem_danhs');
        Schema::dropIfExists('don_dat_tours');
        Schema::dropIfExists('ds_nguoi_dong_hanhs');
        Schema::dropIfExists('giao_diches');
        Schema::dropIfExists('hanh_dongs');
        Schema::dropIfExists('hanh_dong_xanhs');
        Schema::dropIfExists('hdx_tour_thuc_tes');
        Schema::dropIfExists('ho_chieu_sos');
        Schema::dropIfExists('khuyen_mai_khs');
        Schema::dropIfExists('lich_su_tours');
        Schema::dropIfExists('lich_trinh_tours');
        Schema::dropIfExists('nang_luc_nhan_viens');
        Schema::dropIfExists('nhan_viens');
        Schema::dropIfExists('nhat_ky_doi_diems');
        Schema::dropIfExists('nhat_ky_he_thongs');
        Schema::dropIfExists('nhat_ky_su_cos');
        Schema::dropIfExists('phan_cong_tours');
        Schema::dropIfExists('quyet_toans');
        Schema::dropIfExists('tai_khoans');
        Schema::dropIfExists('tour_maus');
        Schema::dropIfExists('tour_thuc_tes');
        Schema::dropIfExists('vai_tros');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('yeu_cau_ho_tros');
        Schema::enableForeignKeyConstraints();
    }
};
