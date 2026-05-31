<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Đổi tên tất cả cột từ PascalCase sang snake_case
 * Giai đoạn 7.2 – Chuẩn hóa kiến trúc Laravel
 *
 * KHÔNG xóa dữ liệu, chỉ đổi tên cột.
 * Thực hiện sau khi đã đổi tên bảng (migration 000001).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // ── Bảng chi_phi_thuc_tes ─────────────────────────────────────────────
        Schema::table('chi_phi_thuc_tes', function (Blueprint $table) {
            $table->renameColumn('ma_chi_phi_thuc_te', 'ma_chi_phi_thuc_te');
            $table->renameColumn('ma_tour_thuc_te',   'ma_tour_thuc_te');
            $table->renameColumn('ma_nhan_vien',      'ma_nhan_vien');
            $table->renameColumn('danh_muc',         'danh_muc');
            $table->renameColumn('thanh_tien',       'thanh_tien');
            $table->renameColumn('hoa_don_anh',       'hoa_don_anh');
            $table->renameColumn('trang_thai_duyet',  'trang_thai_duyet');
            $table->renameColumn('ngay_khai',        'ngay_khai');
        });

        // ── Bảng chi_tiet_dat_tours ───────────────────────────────────────────
        Schema::table('chi_tiet_dat_tours', function (Blueprint $table) {
            $table->renameColumn('ma_chi_tiet_dat',        'ma_chi_tiet_dat');
            $table->renameColumn('ma_dat_tour',            'ma_dat_tour');
            $table->renameColumn('ma_khach_hang',          'ma_khach_hang');
            $table->renameColumn('ma_nguoi_dong_hanh',      'ma_nguoi_dong_hanh');
            $table->renameColumn('loai_khach',            'loai_khach');
            $table->renameColumn('gia_tai_thoi_diem_dat',    'gia_tai_thoi_diem_dat');
        });

        // ── Bảng chi_tiet_dich_vus ───────────────────────────────────────────
        Schema::table('chi_tiet_dich_vus', function (Blueprint $table) {
            $table->renameColumn('ma_chi_tiet_dich_vu', 'ma_chi_tiet_dich_vu');
            $table->renameColumn('ma_dat_tour',        'ma_dat_tour');
            $table->renameColumn('ma_dich_vu_them',     'ma_dich_vu_them');
            $table->renameColumn('so_luong',          'so_luong');
            $table->renameColumn('don_gia',           'don_gia');
            $table->renameColumn('thanh_tien',        'thanh_tien');
        });

        // ── Bảng danh_gia_khs ─────────────────────────────────────────────────
        Schema::table('danh_gia_khs', function (Blueprint $table) {
            $table->renameColumn('ma_danh_gia_khach_hang', 'ma_danh_gia_khach_hang');
            $table->renameColumn('ma_tour_thuc_te',        'ma_tour_thuc_te');
            $table->renameColumn('ma_khach_hang',         'ma_khach_hang');
            $table->renameColumn('so_sao',               'so_sao');
            $table->renameColumn('nhan_xet',             'nhan_xet');
            $table->renameColumn('ngay_danh_gia',         'ngay_danh_gia');
        });

        // ── Bảng dat_tour_uu_dais ─────────────────────────────────────────────
        Schema::table('dat_tour_uu_dais', function (Blueprint $table) {
            $table->renameColumn('ma_dat_tour',    'ma_dat_tour');
            $table->renameColumn('ma_voucher',    'ma_voucher');
            $table->renameColumn('so_tien_uu_dai', 'so_tien_uu_dai');
            $table->renameColumn('ngay_ap_dung',   'ngay_ap_dung');
        });

        // ── Bảng dich_vu_thems ───────────────────────────────────────────────
        Schema::table('dich_vu_thems', function (Blueprint $table) {
            $table->renameColumn('ma_dich_vu_them', 'ma_dich_vu_them');
            $table->renameColumn('ten',          'ten');
            $table->renameColumn('don_vi_tinh',    'don_vi_tinh');
            $table->renameColumn('don_gia',       'don_gia');
        });

        // ── Bảng dich_vu_tour_thuc_tes (pivot) ────────────────────────────────
        Schema::table('dich_vu_tour_thuc_tes', function (Blueprint $table) {
            $table->renameColumn('ma_tour_thuc_te', 'ma_tour_thuc_te');
            $table->renameColumn('ma_dich_vu_them', 'ma_dich_vu_them');
        });

        // ── Bảng diem_danhs ───────────────────────────────────────────────────
        Schema::table('diem_danhs', function (Blueprint $table) {
            $table->renameColumn('ma_diem_danh',      'ma_diem_danh');
            $table->renameColumn('ma_tour_thuc_te',    'ma_tour_thuc_te');
            $table->renameColumn('ma_khach_hang',     'ma_khach_hang');
            $table->renameColumn('ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh');
            $table->renameColumn('loai_khach',       'loai_khach');
            $table->renameColumn('ma_nhan_vien',      'ma_nhan_vien');
            $table->renameColumn('thoi_gian',        'thoi_gian');
            $table->renameColumn('dia_diem',         'dia_diem');
            $table->renameColumn('trang_thai',       'trang_thai');
        });

        // ── Bảng don_dat_tours ────────────────────────────────────────────────
        Schema::table('don_dat_tours', function (Blueprint $table) {
            $table->renameColumn('ma_dat_tour',      'ma_dat_tour');
            $table->renameColumn('ma_tour_thuc_te',   'ma_tour_thuc_te');
            $table->renameColumn('ma_khach_hang',    'ma_khach_hang');
            $table->renameColumn('ngay_dat',        'ngay_dat');
            $table->renameColumn('tong_tien',       'tong_tien');
            $table->renameColumn('trang_thai',      'trang_thai');
            $table->renameColumn('thoi_gian_het_han', 'thoi_gian_het_han');
            $table->renameColumn('ghi_chu',         'ghi_chu');
            $table->renameColumn('hanh_dong_xanh',   'hanh_dong_xanh');
        });

        // ── Bảng ds_nguoi_dong_hanhs ──────────────────────────────────────────
        Schema::table('ds_nguoi_dong_hanhs', function (Blueprint $table) {
            $table->renameColumn('ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh');
            $table->renameColumn('ma_dat_tour',        'ma_dat_tour');
            $table->renameColumn('ho_ten',            'ho_ten');
            $table->renameColumn('cccd',             'cccd');
            $table->renameColumn('so_dien_thoai',      'so_dien_thoai');
            $table->renameColumn('ngay_sinh',         'ngay_sinh');
            $table->renameColumn('gioi_tinh',         'gioi_tinh');
            $table->renameColumn('ghi_chu',           'ghi_chu');
        });

        // ── Bảng giao_diches ──────────────────────────────────────────────────
        Schema::table('giao_diches', function (Blueprint $table) {
            $table->renameColumn('ma_giao_dich',    'ma_giao_dich');
            $table->renameColumn('ma_dat_tour',      'ma_dat_tour');
            $table->renameColumn('loai_giao_dich',   'loai_giao_dich');
            $table->renameColumn('phuong_thuc',     'phuong_thuc');
            $table->renameColumn('so_tien',         'so_tien');
            $table->renameColumn('ma_gdnh',         'ma_gdnh');
            $table->renameColumn('trang_thai',      'trang_thai');
            $table->renameColumn('ngay_thanh_toan',  'ngay_thanh_toan');
        });

        // ── Bảng hanh_dongs ───────────────────────────────────────────────────
        Schema::table('hanh_dongs', function (Blueprint $table) {
            $table->renameColumn('ma_ghi_nhan_hanh_dong',  'ma_ghi_nhan_hanh_dong');
            $table->renameColumn('ma_tour_thuc_te',        'ma_tour_thuc_te');
            $table->renameColumn('ma_khach_hang',         'ma_khach_hang');
            $table->renameColumn('ma_hanh_dong_xanh',      'ma_hanh_dong_xanh');
            $table->renameColumn('ma_nhan_vien_xac_minh',   'ma_nhan_vien_xac_minh');
            $table->renameColumn('thoi_gian',            'thoi_gian');
            $table->renameColumn('minh_chung',           'minh_chung');
        });

        // ── Bảng hanh_dong_xanhs ──────────────────────────────────────────────
        Schema::table('hanh_dong_xanhs', function (Blueprint $table) {
            $table->renameColumn('ma_hanh_dong_xanh', 'ma_hanh_dong_xanh');
            $table->renameColumn('ten_hanh_dong',     'ten_hanh_dong');
            $table->renameColumn('diem_cong',        'diem_cong');
        });

        // ── Bảng hdx_tour_thuc_tes (pivot) ────────────────────────────────────
        Schema::table('hdx_tour_thuc_tes', function (Blueprint $table) {
            $table->renameColumn('ma_tour_thuc_te',   'ma_tour_thuc_te');
            $table->renameColumn('ma_hanh_dong_xanh', 'ma_hanh_dong_xanh');
        });

        // ── Bảng ho_chieu_sos ─────────────────────────────────────────────────
        Schema::table('ho_chieu_sos', function (Blueprint $table) {
            $table->renameColumn('ma_khach_hang',   'ma_khach_hang');
            $table->renameColumn('ma_tai_khoan',     'ma_tai_khoan');
            $table->renameColumn('ghi_chu_y_te',      'ghi_chu_y_te');
            $table->renameColumn('di_ung',          'di_ung');
            $table->renameColumn('hang_thanh_vien',  'hang_thanh_vien');
            $table->renameColumn('diem_xanh',       'diem_xanh');
        });

        // ── Bảng khuyen_mai_khs (pivot) ───────────────────────────────────────
        Schema::table('khuyen_mai_khs', function (Blueprint $table) {
            $table->renameColumn('ma_khach_hang', 'ma_khach_hang');
            $table->renameColumn('ma_voucher',   'ma_voucher');
            $table->renameColumn('ngay_het_han',  'ngay_het_han');
            $table->renameColumn('ngay_nhan',    'ngay_nhan');
            $table->renameColumn('trang_thai',   'trang_thai');
        });

        // ── Bảng lich_su_tours ────────────────────────────────────────────────
        Schema::table('lich_su_tours', function (Blueprint $table) {
            $table->renameColumn('ma_lich_su_tour',  'ma_lich_su_tour');
            $table->renameColumn('ma_khach_hang',   'ma_khach_hang');
            $table->renameColumn('ma_tour_thuc_te',  'ma_tour_thuc_te');
            $table->renameColumn('ma_chi_tiet_dat',  'ma_chi_tiet_dat');
            $table->renameColumn('ngay_tham_gia',   'ngay_tham_gia');
        });

        // ── Bảng lich_trinh_tours ─────────────────────────────────────────────
        Schema::table('lich_trinh_tours', function (Blueprint $table) {
            $table->renameColumn('ma_lich_trinh_tour', 'ma_lich_trinh_tour');
            $table->renameColumn('ma_tour_mau',        'ma_tour_mau');
            $table->renameColumn('ngay_thu',          'ngay_thu');
            $table->renameColumn('hoat_dong',         'hoat_dong');
            $table->renameColumn('mo_ta',             'mo_ta');
            $table->renameColumn('thuc_don',          'thuc_don');
        });

        // ── Bảng nang_luc_nhan_viens ──────────────────────────────────────────
        Schema::table('nang_luc_nhan_viens', function (Blueprint $table) {
            $table->renameColumn('ma_nang_luc_nhan_vien', 'ma_nang_luc_nhan_vien');
            $table->renameColumn('ma_nhan_vien',         'ma_nhan_vien');
            $table->renameColumn('ngon_ngu',            'ngon_ngu');
            $table->renameColumn('chung_chi',           'chung_chi');
            $table->renameColumn('chuyen_mon',          'chuyen_mon');
            $table->renameColumn('danh_gia',            'danh_gia');
            $table->renameColumn('so_danh_gia',          'so_danh_gia');
        });

        // ── Bảng nhan_viens ───────────────────────────────────────────────────
        Schema::table('nhan_viens', function (Blueprint $table) {
            $table->renameColumn('ma_nhan_vien',      'ma_nhan_vien');
            $table->renameColumn('ma_tai_khoan',      'ma_tai_khoan');
            $table->renameColumn('loai_nhan_vien',    'loai_nhan_vien');
            $table->renameColumn('ngay_vao_lam',      'ngay_vao_lam');
            $table->renameColumn('trang_thai_lam_viec','trang_thai_lam_viec');
        });

        // ── Bảng nhat_ky_doi_diems ────────────────────────────────────────────
        Schema::table('nhat_ky_doi_diems', function (Blueprint $table) {
            $table->renameColumn('ma_nhat_ky_doi_diem', 'ma_nhat_ky_doi_diem');
            $table->renameColumn('ma_khach_hang',      'ma_khach_hang');
            $table->renameColumn('ma_voucher',        'ma_voucher');
            $table->renameColumn('diem_quy_doi',       'diem_quy_doi');
            $table->renameColumn('ngay_quy_doi',       'ngay_quy_doi');
        });

        // ── Bảng nhat_ky_he_thongs ────────────────────────────────────────────
        Schema::table('nhat_ky_he_thongs', function (Blueprint $table) {
            $table->renameColumn('ma_nhat_ky_he_thong', 'ma_nhat_ky_he_thong');
            $table->renameColumn('ma_tai_khoan',       'ma_tai_khoan');
            $table->renameColumn('hanh_dong',         'hanh_dong');
            $table->renameColumn('doi_tuong',         'doi_tuong');
            $table->renameColumn('ma_doi_tuong',       'ma_doi_tuong');
            $table->renameColumn('ghi_chu',           'ghi_chu');
            $table->renameColumn('thoi_gian',         'thoi_gian');
        });

        // ── Bảng nhat_ky_su_cos ───────────────────────────────────────────────
        Schema::table('nhat_ky_su_cos', function (Blueprint $table) {
            $table->renameColumn('ma_nhat_ky_su_co',       'ma_nhat_ky_su_co');
            $table->renameColumn('ma_tour_thuc_te',        'ma_tour_thuc_te');
            $table->renameColumn('ma_nhan_vien_bao_cao',    'ma_nhan_vien_bao_cao');
            $table->renameColumn('ma_khach_hang',         'ma_khach_hang');
            $table->renameColumn('ma_nguoi_dong_hanh',     'ma_nguoi_dong_hanh');
            $table->renameColumn('mo_ta',                'mo_ta');
            $table->renameColumn('giai_phap',            'giai_phap');
            $table->renameColumn('muc_do',               'muc_do');
            $table->renameColumn('loai_su_co',            'loai_su_co');
            $table->renameColumn('thoi_gian_bao_cao',      'thoi_gian_bao_cao');
        });

        // ── Bảng phan_cong_tours ──────────────────────────────────────────────
        Schema::table('phan_cong_tours', function (Blueprint $table) {
            $table->renameColumn('ma_phan_cong_tour',     'ma_phan_cong_tour');
            $table->renameColumn('ma_tour_thuc_te',        'ma_tour_thuc_te');
            $table->renameColumn('ma_nhan_vien',          'ma_nhan_vien');
            $table->renameColumn('ngay_phan_cong',        'ngay_phan_cong');
            $table->renameColumn('ngay_phan_hoi',         'ngay_phan_hoi');
            $table->renameColumn('trang_thai_chap_nhan',   'trang_thai_chap_nhan');
        });

        // ── Bảng quyet_toans ──────────────────────────────────────────────────
        Schema::table('quyet_toans', function (Blueprint $table) {
            $table->renameColumn('ma_quyet_toan',    'ma_quyet_toan');
            $table->renameColumn('ma_tour_thuc_te',   'ma_tour_thuc_te');
            $table->renameColumn('tong_doanh_thu',   'tong_doanh_thu');
            $table->renameColumn('tong_chi_phi',     'tong_chi_phi');
            $table->renameColumn('gia_cam_ket',      'gia_cam_ket');
            $table->renameColumn('loi_nhuan',       'loi_nhuan');
            $table->renameColumn('ma_nhan_vien',     'ma_nhan_vien');
            $table->renameColumn('ngay_quyet_toan',  'ngay_quyet_toan');
            $table->renameColumn('trang_thai',      'trang_thai');
            $table->renameColumn('ghi_chu',         'ghi_chu');
            $table->renameColumn('hoa_don_anh',      'hoa_don_anh');
        });

        // ── Bảng tai_khoans ───────────────────────────────────────────────────
        Schema::table('tai_khoans', function (Blueprint $table) {
            $table->renameColumn('ma_tai_khoan',   'ma_tai_khoan');
            $table->renameColumn('ten_dang_nhap',  'ten_dang_nhap');
            $table->renameColumn('mat_khau',      'mat_khau');
            $table->renameColumn('ho_ten',        'ho_ten');
            $table->renameColumn('cccd',         'cccd');
            $table->renameColumn('ngay_sinh',     'ngay_sinh');
            $table->renameColumn('email',        'email');
            $table->renameColumn('so_dien_thoai',  'so_dien_thoai');
            $table->renameColumn('vai_tro',       'vai_tro');
            $table->renameColumn('trang_thai',    'trang_thai');
        });

        // ── Bảng tour_maus ────────────────────────────────────────────────────
        Schema::table('tour_maus', function (Blueprint $table) {
            $table->renameColumn('ma_tour_mau',   'ma_tour_mau');
            $table->renameColumn('tieu_de',      'tieu_de');
            $table->renameColumn('mo_ta',        'mo_ta');
            $table->renameColumn('thoi_luong',   'thoi_luong');
            $table->renameColumn('gia_san',      'gia_san');
            $table->renameColumn('danh_gia',     'danh_gia');
            $table->renameColumn('so_danh_gia',   'so_danh_gia');
        });

        // ── Bảng tour_thuc_tes ────────────────────────────────────────────────
        Schema::table('tour_thuc_tes', function (Blueprint $table) {
            $table->renameColumn('ma_tour_thuc_te',   'ma_tour_thuc_te');
            $table->renameColumn('ma_tour_mau',       'ma_tour_mau');
            $table->renameColumn('ngay_khoi_hanh',    'ngay_khoi_hanh');
            $table->renameColumn('gia_hien_hanh',     'gia_hien_hanh');
            $table->renameColumn('so_khach_toi_da',    'so_khach_toi_da');
            $table->renameColumn('so_khach_toi_thieu', 'so_khach_toi_thieu');
            $table->renameColumn('cho_con_lai',       'cho_con_lai');
            $table->renameColumn('trang_thai',       'trang_thai');
        });

        // ── Bảng vai_tros ─────────────────────────────────────────────────────
        Schema::table('vai_tros', function (Blueprint $table) {
            $table->renameColumn('ma_vai_tro',    'ma_vai_tro');
            $table->renameColumn('ten_hien_thi',  'ten_hien_thi');
        });

        // ── Bảng vouchers ─────────────────────────────────────────────────────
        Schema::table('vouchers', function (Blueprint $table) {
            $table->renameColumn('ma_voucher',        'ma_voucher');
            $table->renameColumn('ma_code',           'ma_code');
            $table->renameColumn('loai_uu_dai',        'loai_uu_dai');
            $table->renameColumn('gia_tri_giam',       'gia_tri_giam');
            $table->renameColumn('muc_giam_toi_da',    'muc_giam_toi_da');
            $table->renameColumn('dieu_kien_ap_dung',   'dieu_kien_ap_dung');
            $table->renameColumn('so_luot_phat_hanh',  'so_luot_phat_hanh');
            $table->renameColumn('so_luot_da_dung',    'so_luot_da_dung');
            $table->renameColumn('ngay_hieu_luc',     'ngay_hieu_luc');
            $table->renameColumn('ngay_het_han',      'ngay_het_han');
            $table->renameColumn('trang_thai',       'trang_thai');
        });

        // ── Bảng yeu_cau_ho_tros ──────────────────────────────────────────────
        Schema::table('yeu_cau_ho_tros', function (Blueprint $table) {
            $table->renameColumn('ma_yeu_cau_ho_tro',   'ma_yeu_cau_ho_tro');
            $table->renameColumn('ma_dat_tour',         'ma_dat_tour');
            $table->renameColumn('ma_khach_hang',       'ma_khach_hang');
            $table->renameColumn('loai_yeu_cau',        'loai_yeu_cau');
            $table->renameColumn('noi_dung',           'noi_dung');
            $table->renameColumn('trang_thai',         'trang_thai');
            $table->renameColumn('ma_nhan_vien_xu_ly',    'ma_nhan_vien_xu_ly');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // ── Đảo ngược: đổi lại tên cột về PascalCase ─────────────────────────
        Schema::table('chi_phi_thuc_tes', function (Blueprint $table) {
            $table->renameColumn('ma_chi_phi_thuc_te', 'ma_chi_phi_thuc_te');
            $table->renameColumn('ma_tour_thuc_te',    'ma_tour_thuc_te');
            $table->renameColumn('ma_nhan_vien',        'ma_nhan_vien');
            $table->renameColumn('danh_muc',            'danh_muc');
            $table->renameColumn('thanh_tien',          'thanh_tien');
            $table->renameColumn('hoa_don_anh',         'hoa_don_anh');
            $table->renameColumn('trang_thai_duyet',    'trang_thai_duyet');
            $table->renameColumn('ngay_khai',           'ngay_khai');
        });

        Schema::table('tai_khoans', function (Blueprint $table) {
            $table->renameColumn('ma_tai_khoan',  'ma_tai_khoan');
            $table->renameColumn('ten_dang_nhap', 'ten_dang_nhap');
            $table->renameColumn('mat_khau',      'mat_khau');
            $table->renameColumn('ho_ten',        'ho_ten');
            $table->renameColumn('cccd',          'cccd');
            $table->renameColumn('ngay_sinh',     'ngay_sinh');
            $table->renameColumn('email',         'email');
            $table->renameColumn('so_dien_thoai', 'so_dien_thoai');
            $table->renameColumn('vai_tro',       'vai_tro');
            $table->renameColumn('trang_thai',    'trang_thai');
        });

        Schema::enableForeignKeyConstraints();
    }
};
