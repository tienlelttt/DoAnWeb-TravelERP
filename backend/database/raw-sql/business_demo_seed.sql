-- Chay sau:


--
-- Ghi chu nghiep vu:
-- - tour_thuc_tes khong co FK truc tiep den nhan vien dieu hanh.
-- - Seed nay the hien nguoi dieu hanh bang nhat_ky_he_thongs:
--   TK_MGR01 / NV_MGR01 ghi nhan THEM/CAP_NHAT tren tung tour_thuc_tes.
-- - ten tour_maus dung dinh dang: Dia diem - tieu de.

-- ------------------------------------------------------------
-- 0. RESET DU LIEU LIEN KET NEU CHAY LAI SCRIPT
-- ------------------------------------------------------------
UPDATE tour_thuc_tes
SET trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te LIKE 'TTT_%'
  AND trang_thai = 'DA_QUYET_TOAN';

DELETE FROM danh_gia_khs        WHERE ma_danh_gia_khach_hang LIKE 'DG_%';
DELETE FROM yeu_cau_ho_tros      WHERE ma_yeu_cau_ho_tro LIKE 'YCHT_%' OR ma_dat_tour LIKE 'DDT_%';
DELETE FROM nhat_ky_doi_diems    WHERE ma_nhat_ky_doi_diem LIKE 'NKDD_%';
DELETE FROM quyet_toans        WHERE ma_quyet_toan LIKE 'QT_%';
DELETE FROM chi_phi_thuc_tes     WHERE ma_chi_phi_thuc_te LIKE 'CP_%';
DELETE FROM nhat_ky_su_cos       WHERE ma_nhat_ky_su_co LIKE 'SC_%';
DELETE FROM hanh_dongs         WHERE ma_ghi_nhan_hanh_dong LIKE 'HD_%';
DELETE FROM diem_danhs         WHERE ma_diem_danh LIKE 'DD_%';
DELETE FROM phan_cong_tours     WHERE ma_phan_cong_tour LIKE 'PC_%';
DELETE FROM lich_su_tours       WHERE ma_lich_su_tour LIKE 'LST_%';
DELETE FROM giao_diches         WHERE ma_giao_dich LIKE 'GD_%';
DELETE FROM dat_tour_uu_dais    WHERE ma_dat_tour LIKE 'DDT_%' OR ma_voucher LIKE 'VC_%';
DELETE FROM khuyen_mai_khs     WHERE ma_khach_hang LIKE 'KH_%' OR ma_voucher LIKE 'VC_%';
DELETE FROM vouchers          WHERE ma_voucher LIKE 'VC_%';
DELETE FROM chi_tiet_dich_vus    WHERE ma_chi_tiet_dich_vu LIKE 'CTDV_%';
DELETE FROM chi_tiet_dat_tours   WHERE ma_chi_tiet_dat LIKE 'CTDT_%';
DELETE FROM ds_nguoi_dong_hanhs  WHERE ma_nguoi_dong_hanh LIKE 'NDH_%';
DELETE FROM don_dat_tours       WHERE ma_dat_tour LIKE 'DDT_%';
DELETE FROM hdx_tour_thuc_tes   WHERE ma_tour_thuc_te LIKE 'TTT_%' OR ma_hanh_dong_xanh LIKE 'HDX_%';
DELETE FROM dich_vu_tour_thuc_tes WHERE ma_tour_thuc_te LIKE 'TTT_%' OR ma_dich_vu_them LIKE 'DVT_%';
DELETE FROM tour_thuc_tes       WHERE ma_tour_thuc_te LIKE 'TTT_%';
DELETE FROM lich_trinh_tours    WHERE ma_lich_trinh_tour LIKE 'LTT_%';
DELETE FROM tour_maus          WHERE ma_tour_mau LIKE 'TM_%';
DELETE FROM hanh_dong_xanhs     WHERE ma_hanh_dong_xanh LIKE 'HDX_%';
DELETE FROM dich_vu_thems       WHERE ma_dich_vu_them LIKE 'DVT_%';
DELETE FROM nang_luc_nhan_viens  WHERE ma_nang_luc_nhan_vien LIKE 'NL_%';
DELETE FROM nhat_ky_he_thongs    WHERE ma_nhat_ky_he_thong LIKE 'NKHT_%';
DELETE FROM ho_chieu_sos        WHERE ma_khach_hang LIKE 'KH_%';
DELETE FROM nhan_viens         WHERE ma_nhan_vien IN ('NV_HDV11', 'NV_HDV12');
DELETE FROM tai_khoans         WHERE ma_tai_khoan IN ('TK_HDV11', 'TK_HDV12');
DELETE FROM tai_khoans         WHERE ma_tai_khoan LIKE 'TK_KH_%';

-- ------------------------------------------------------------
-- 1. NANG LUC HDV VA KHACH HANG
-- ------------------------------------------------------------
-- Hai hÆ°á»›ng dáº«n viÃªn bá»• sung phá»¥c vá»¥ mÃ n hÃ¬nh lá»‹ch sá»­ vÃ  lá»‹ch sáº¯p khá»Ÿi hÃ nh.
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV11', 'hdv11', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'VÃµ Thuá»³ DÆ°Æ¡ng', '048192006811', '1992-06-08', 'thuyduong.hdv@digitaltravel.vn', '0908112211', 'HDV', 'HOAT_DONG');
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV12', 'hdv12', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyá»…n Quá»‘c Viá»‡t', '092189007512', '1989-07-15', 'quocviet.hdv@digitaltravel.vn', '0908223312', 'HDV', 'HOAT_DONG');

INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV11', 'TK_HDV11', 'HDV', '2022-03-14', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV12', 'TK_HDV12', 'HDV', '2021-10-04', 'HOAT_DONG');

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV01', 'NV_HDV01', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a; SÆ¡ cáº¥p cá»©u cÆ¡ báº£n', 'TÃ¢y Báº¯c, Trekking, Tour xanh', 4.80, 126);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV02', 'NV_HDV02', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh, Tiáº¿ng HÃ n', 'Tháº» HDV quá»‘c táº¿', 'Biá»ƒn Ä‘áº£o, di sáº£n miá»n Trung, gia Ä‘Ã¬nh', 4.70, 98);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV03', 'NV_HDV03', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a', 'Miá»n nÃºi phÃ­a Báº¯c, tour cá»™ng Ä‘á»“ng', 4.76, 84);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV04', 'NV_HDV04', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Trung', 'Tháº» HDV ná»™i Ä‘á»‹a; SÆ¡ cáº¥p cá»©u cÆ¡ báº£n', 'Di sáº£n miá»n Trung, áº©m thá»±c Ä‘á»‹a phÆ°Æ¡ng', 4.68, 71);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV05', 'NV_HDV05', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a', 'Biá»ƒn Ä‘áº£o, nghá»‰ dÆ°á»¡ng gia Ä‘Ã¬nh', 4.72, 79);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV06', 'NV_HDV06', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a', 'Du thuyá»n, tour cao cáº¥p', 4.74, 68);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV07', 'NV_HDV07', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a; SÆ¡ cáº¥p cá»©u cÆ¡ báº£n', 'TÃ¢m linh miá»n Báº¯c, TrÃ ng An, tour gia Ä‘Ã¬nh', 4.69, 63);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV08', 'NV_HDV08', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a', 'ÄÃ  Láº¡t, Má»™c ChÃ¢u, nÃ´ng tráº¡i vÃ  tráº£i nghiá»‡m cá»™ng Ä‘á»“ng', 4.71, 76);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV09', 'NV_HDV09', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh, Tiáº¿ng HÃ n', 'Tháº» HDV quá»‘c táº¿; Cá»©u há»™ biá»ƒn cÆ¡ báº£n', 'PhÃº Quá»‘c, CÃ´n Äáº£o, tour biá»ƒn Ä‘áº£o vÃ  gia Ä‘Ã¬nh', 4.73, 82);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV10', 'NV_HDV10', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a', 'TÃ¢y NguyÃªn, Cáº§n ThÆ¡, tour vÄƒn hÃ³a vÃ  áº©m thá»±c Ä‘á»‹a phÆ°Æ¡ng', 4.66, 58);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV11', 'NV_HDV11', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh, Tiáº¿ng HÃ n', 'Tháº» HDV quá»‘c táº¿; Chá»©ng nháº­n sÆ¡ cáº¥p cá»©u du lá»‹ch', 'Di sáº£n miá»n Trung, biá»ƒn Quy NhÆ¡n, tráº£i nghiá»‡m vÄƒn hoÃ¡ Ä‘á»‹a phÆ°Æ¡ng', 4.86, 94);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV12', 'NV_HDV12', 'Tiáº¿ng Viá»‡t, Tiáº¿ng Anh', 'Tháº» HDV ná»™i Ä‘á»‹a; Chá»©ng nháº­n an toÃ n Ä‘Æ°á»ng thuá»·', 'Miá»n TÃ¢y sÃ´ng nÆ°á»›c, chá»£ ná»•i, du lá»‹ch cá»™ng Ä‘á»“ng bá»n vá»¯ng', 4.81, 88);

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_01', 'khach01', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Tráº§n Minh Khoa', '079199000101', '1995-02-14', 'khach01@digitaltravel.vn', '0911000101', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_02', 'khach02', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Pháº¡m Ngá»c Linh', '079199000102', '1997-08-20', 'khach02@digitaltravel.vn', '0911000102', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_03', 'khach03', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'LÃª Thu HÃ ', '079199000103', '1992-11-03', 'khach03@digitaltravel.vn', '0911000103', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_04', 'khach04', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyá»…n Báº£o ChÃ¢u', '079199000104', '1989-05-09', 'khach04@digitaltravel.vn', '0911000104', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_05', 'khach05', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Äá»— Quang Huy', '079199000105', '1986-12-25', 'khach05@digitaltravel.vn', '0911000105', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_06', 'khach06', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'BÃ¹i Anh ThÆ°', '079199000106', '1999-04-18', 'khach06@digitaltravel.vn', '0911000106', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_07', 'khach07', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'HoÃ ng Viá»‡t Anh', '079199000107', '1991-01-16', 'khach07@digitaltravel.vn', '0911000107', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_08', 'khach08', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'VÅ© KhÃ¡nh Vy', '079199000108', '1994-09-27', 'khach08@digitaltravel.vn', '0911000108', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_09', 'khach09', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Äáº·ng Gia HÃ¢n', '079199000109', '1988-03-30', 'khach09@digitaltravel.vn', '0911000109', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_10', 'khach10', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Mai PhÆ°Æ¡ng Nhi', '079199000110', '1996-06-12', 'khach10@digitaltravel.vn', '0911000110', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_11', 'khach11', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Cao Minh TrÃ­', '079199000111', '1984-10-08', 'khach11@digitaltravel.vn', '0911000111', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_12', 'khach12', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Trá»‹nh Má»¹ DuyÃªn', '079199000112', '1998-07-07', 'khach12@digitaltravel.vn', '0911000112', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_13', 'khach13', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyá»…n Äá»©c Long', '079199000113', '1985-09-19', 'khach13@digitaltravel.vn', '0911000113', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_14', 'khach14', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'LÃ¢m Tuá»‡ Minh', '079199000114', '1990-02-28', 'khach14@digitaltravel.vn', '0911000114', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_15', 'khach15', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Phan Gia Báº£o', '079199000115', '1993-12-02', 'khach15@digitaltravel.vn', '0911000115', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_16', 'khach16', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyá»…n Tháº£o NguyÃªn', '079199000116', '1994-04-21', 'khach16@digitaltravel.vn', '0911000116', 'KHACHHANG', 'HOAT_DONG');
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_17', 'khach17', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Pháº¡m Minh Anh', '079199000117', '1996-09-12', 'khach17@digitaltravel.vn', '0911000117', 'KHACHHANG', 'HOAT_DONG');
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_18', 'khach18', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'VÅ© HoÃ ng Yáº¿n', '079199000118', '1991-03-06', 'khach18@digitaltravel.vn', '0911000118', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_01', 'TK_KH_01', NULL, 'Háº£i sáº£n', 'DONG', 650);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_02', 'TK_KH_02', 'Bá»‡nh hen suyá»…n nháº¹', NULL, 'BAC', 2400);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_03', 'TK_KH_03', 'Bá»‡nh tim máº¡ch, trÃ¡nh hoáº¡t Ä‘á»™ng gáº¯ng sá»©c vÃ  leo dá»‘c dÃ i.', 'Äáº­u phá»™ng', 'THANH_VIEN', 200);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_04', 'TK_KH_04', 'Äau khá»›p gá»‘i, Æ°u tiÃªn phÃ²ng táº§ng tháº¥p vÃ  lá»‹ch trÃ¬nh Ã­t báº­c thang.', NULL, 'VANG', 5600);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_05', 'TK_KH_05', 'KhÃ´ng cÃ³ ghi chÃº y táº¿ Ä‘áº·c biá»‡t.', NULL, 'KIM_CUONG', 10200);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_06', 'TK_KH_06', 'Dá»… say xe, Æ°u tiÃªn gháº¿ phÃ­a trÆ°á»›c.', NULL, 'DONG', 850);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_07', 'TK_KH_07', 'Dá»‹ á»©ng khÃ³i thuá»‘c, Æ°u tiÃªn phÃ²ng vÃ  khu vá»±c Äƒn uá»‘ng khÃ´ng hÃºt thuá»‘c.', NULL, 'THANH_VIEN', 120);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_08', 'TK_KH_08', 'Huyáº¿t Ã¡p cao, cáº§n lá»‹ch trÃ¬nh nháº¹ vÃ  thá»i gian nghá»‰ giá»¯a cÃ¡c Ä‘iá»ƒm.', 'Sá»¯a bÃ²', 'DONG', 780);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_09', 'TK_KH_09', 'Tiá»ƒu Ä‘Æ°á»ng type 2, cáº§n bá»¯a Äƒn Ä‘Ãºng giá» vÃ  háº¡n cháº¿ Ä‘á»“ ngá»t.', NULL, 'BAC', 3100);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_10', 'TK_KH_10', 'Bá»‡nh dáº¡ dÃ y, trÃ¡nh mÃ³n quÃ¡ cay vÃ  Ä‘á»“ uá»‘ng cÃ³ gas.', 'Háº£i sáº£n cÃ³ vá»', 'VANG', 6200);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_11', 'TK_KH_11', 'Äau lÆ°ng, cáº§n lá»‹ch trÃ¬nh Ã­t leo dá»‘c vÃ  háº¡n cháº¿ ngá»“i xe quÃ¡ lÃ¢u.', NULL, 'KIM_CUONG', 11800);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_12', 'TK_KH_12', 'Ä‚n chay trÆ°á»ng', NULL, 'BAC', 2800);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_13', 'TK_KH_13', NULL , NULL, 'VANG', 7100);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_14', 'TK_KH_14', NULL, 'Trá»©ng gÃ ', 'DONG', 950);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_15', 'TK_KH_15', NULL, 'Pháº¥n hoa', 'THANH_VIEN', 320);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_16', 'TK_KH_16', NULL, NULL, 'DONG', 520);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_17', 'TK_KH_17', NULL, NULL, 'THANH_VIEN', 460);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_18', 'TK_KH_18', NULL, NULL, 'DONG', 610);

-- ------------------------------------------------------------
-- 2. DANH MUC TOUR, DICH VU, HANH DONG XANH
-- ------------------------------------------------------------
INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_SAPA', 'Sa Pa - SÄƒn mÃ¢y Fansipan vÃ  báº£n CÃ¡t CÃ¡t',
        'KhÃ¡m phÃ¡ Sa Pa theo cÃ¡ch trá»n váº¹n nháº¥t cÃ¹ng hÃ nh trÃ¬nh sÄƒn mÃ¢y Fansipan vÃ  báº£n CÃ¡t CÃ¡t, nÆ¡i du khÃ¡ch Ä‘Æ°á»£c cháº¡m vÃ o váº» Ä‘áº¹p nÃºi rá»«ng TÃ¢y Báº¯c, vÄƒn hÃ³a báº£n Ä‘á»‹a vÃ  nhá»‹p sá»‘ng bÃ¬nh yÃªn giá»¯a mÃ¢y trá»i. Vá»›i lá»‹ch trÃ¬nh 3 ngÃ y, tour cÃ¢n báº±ng giá»¯a tham quan, nghá»‰ dÆ°á»¡ng vÃ  tráº£i nghiá»‡m Ä‘á»‹a phÆ°Æ¡ng, phÃ¹ há»£p cho gia Ä‘Ã¬nh, nhÃ³m báº¡n vÃ  du khÃ¡ch yÃªu thiÃªn nhiÃªn.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Fansipan vÃ  báº£n CÃ¡t CÃ¡t
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 4500000, 4.70, 86);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_DANANG', 'ÄÃ  Náºµng - Di sáº£n miá»n Trung xanh',
        'Táº­n hÆ°á»Ÿng miá»n Trung nÄƒng Ä‘á»™ng cÃ¹ng hÃ nh trÃ¬nh ÄÃ  Náºµng, SÆ¡n TrÃ , Há»™i An vÃ  Má»¹ SÆ¡n, nÆ¡i biá»ƒn xanh, di sáº£n vÃ  áº©m thá»±c Ä‘á»‹a phÆ°Æ¡ng hÃ²a quyá»‡n trong má»™t chuyáº¿n Ä‘i giÃ u cáº£m xÃºc. Vá»›i lá»‹ch trÃ¬nh 4 ngÃ y, tour Ä‘Æ°á»£c thiáº¿t káº¿ Ä‘á»ƒ du khÃ¡ch vá»«a cÃ³ thá»i gian khÃ¡m phÃ¡ cÃ¡c biá»ƒu tÆ°á»£ng ná»•i báº­t vá»«a nghá»‰ ngÆ¡i thoáº£i mÃ¡i trong khÃ´ng gian thÃ¢n thiá»‡n vÃ  an toÃ n.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan SÆ¡n TrÃ , Há»™i An vÃ  Má»¹ SÆ¡n
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 4, 6200000, 4.60, 73);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_DALAT', 'ÄÃ  Láº¡t - Rá»«ng thÃ´ng vÃ  nÃ´ng tráº¡i xanh',
        'KhÃ¡m phÃ¡ ÄÃ  Láº¡t theo cÃ¡ch trá»n váº¹n nháº¥t cÃ¹ng hÃ nh trÃ¬nh ÄÃ  Láº¡t - Rá»«ng thÃ´ng vÃ  nÃ´ng tráº¡i xanh, nÆ¡i má»—i Ä‘iá»ƒm dá»«ng khÃ´ng chá»‰ lÃ  má»™t chuyáº¿n tham quan mÃ  cÃ²n lÃ  tráº£i nghiá»‡m Ä‘Ã¡ng nhá»› vá» vÄƒn hÃ³a, thiÃªn nhiÃªn vÃ  con ngÆ°á»i báº£n Ä‘á»‹a. Vá»›i lá»‹ch trÃ¬nh 3 ngÃ y, tour Ä‘Æ°á»£c thiáº¿t káº¿ hÃ i hÃ²a giá»¯a nghá»‰ dÆ°á»¡ng, khÃ¡m phÃ¡ vÃ  cÃ¡c hoáº¡t Ä‘á»™ng tráº£i nghiá»‡m xanh, mang Ä‘áº¿n cáº£m giÃ¡c thÆ° thÃ¡i nhÆ°ng váº«n Ä‘áº§y cáº£m há»©ng cho má»i du khÃ¡ch Ä‘á»ƒ báº¡n táº­n hÆ°á»Ÿng chuyáº¿n Ä‘i má»™t cÃ¡ch tiá»‡n lá»£i, an toÃ n vÃ  Ä‘Ã¡ng nhá»› cÃ¹ng Digital Travel.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan nÃ´ng tráº¡i xanh vÃ  cÃ¡c Ä‘iá»ƒm trong lá»‹ch trÃ¬nh
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 3900000, 4.50, 64);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_NINHBINH', 'Ninh BÃ¬nh - TrÃ ng An vÃ  chÃ¹a BÃ¡i ÄÃ­nh',
        'Du ngoáº¡n Ninh BÃ¬nh vá»›i hÃ nh trÃ¬nh TrÃ ng An, Hoa LÆ° vÃ  chÃ¹a BÃ¡i ÄÃ­nh, nÆ¡i cáº£nh quan non nÆ°á»›c, di sáº£n cá»‘ Ä‘Ã´ vÃ  khÃ´ng gian tÃ¢m linh táº¡o nÃªn má»™t chuyáº¿n Ä‘i nháº¹ nhÃ ng nhÆ°ng sÃ¢u láº¯ng. Lá»‹ch trÃ¬nh 2 ngÃ y phÃ¹ há»£p cho du khÃ¡ch muá»‘n Ä‘á»•i giÃ³ cuá»‘i tuáº§n, tráº£i nghiá»‡m vÄƒn hÃ³a miá»n Báº¯c vÃ  táº­n hÆ°á»Ÿng dá»‹ch vá»¥ Ä‘Æ°á»£c sáº¯p xáº¿p gá»n gÃ ng.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan TrÃ ng An, Hoa LÆ° vÃ  chÃ¹a BÃ¡i ÄÃ­nh
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 2, 2800000, 4.80, 112);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_PHUQUOC', 'PhÃº Quá»‘c - Biá»ƒn xanh vÃ  hoÃ ng hÃ´n Nam Äáº£o',
        'Táº­n hÆ°á»Ÿng PhÃº Quá»‘c vá»›i hÃ nh trÃ¬nh biá»ƒn xanh, hoÃ ng hÃ´n Nam Äáº£o vÃ  nhá»¯ng tráº£i nghiá»‡m nghá»‰ dÆ°á»¡ng thÆ° thÃ¡i giá»¯a thiÃªn nhiÃªn Ä‘áº£o ngá»c. Trong 4 ngÃ y, du khÃ¡ch Ä‘Æ°á»£c káº¿t há»£p tham quan, táº¯m biá»ƒn, khÃ¡m phÃ¡ Ä‘áº·c sáº£n Ä‘á»‹a phÆ°Æ¡ng vÃ  nghá»‰ ngÆ¡i theo nhá»‹p cháº­m rÃ£i, phÃ¹ há»£p cho gia Ä‘Ã¬nh, cáº·p Ä‘Ã´i vÃ  nhÃ³m báº¡n.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Nam Äáº£o vÃ  cÃ¡c Ä‘iá»ƒm trong lá»‹ch trÃ¬nh
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 4, 7600000, 4.40, 59);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HUE', 'Huáº¿ - Kinh thÃ nh vÃ  áº©m thá»±c cá»‘ Ä‘Ã´',
        'Äi qua chiá»u sÃ¢u vÄƒn hÃ³a cá»‘ Ä‘Ã´ cÃ¹ng hÃ nh trÃ¬nh Huáº¿ - Kinh thÃ nh vÃ  áº©m thá»±c, nÆ¡i du khÃ¡ch Ä‘Æ°á»£c khÃ¡m phÃ¡ Äáº¡i Ná»™i, lÄƒng táº©m, lÃ ng nghá» vÃ  nhá»¯ng hÆ°Æ¡ng vá»‹ tinh táº¿ cá»§a Ä‘áº¥t kinh ká»³. Lá»‹ch trÃ¬nh 3 ngÃ y mang nhá»‹p Ä‘iá»‡u cháº­m rÃ£i, giÃ u cháº¥t vÄƒn hÃ³a vÃ  phÃ¹ há»£p vá»›i du khÃ¡ch yÃªu lá»‹ch sá»­, kiáº¿n trÃºc vÃ  áº©m thá»±c Ä‘á»‹a phÆ°Æ¡ng.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Äáº¡i Ná»™i, lÄƒng táº©m vÃ  lÃ ng nghá»
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 4100000, 4.65, 91);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HAGIANG', 'HÃ  Giang - Cung Ä‘Æ°á»ng Ä‘Ã¡ vÃ  chá»£ phiÃªn',
        'Cháº¡m vÃ o váº» Ä‘áº¹p hÃ¹ng vÄ© cá»§a miá»n cá»±c Báº¯c qua cung Ä‘Æ°á»ng Ä‘Ã¡ HÃ  Giang, nÆ¡i cao nguyÃªn Ä‘Ã¡, chá»£ phiÃªn, báº£n lÃ ng vÃ  nhá»¯ng khÃºc cua Ä‘Ã¨o táº¡o nÃªn má»™t hÃ nh trÃ¬nh Ä‘áº§y cáº£m há»©ng. Vá»›i 4 ngÃ y di chuyá»ƒn vÃ  khÃ¡m phÃ¡, tour phÃ¹ há»£p cho du khÃ¡ch yÃªu thiÃªn nhiÃªn, vÄƒn hÃ³a vÃ¹ng cao vÃ  nhá»¯ng tráº£i nghiá»‡m chÃ¢n thá»±c trÃªn Ä‘Æ°á»ng.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan cao nguyÃªn Ä‘Ã¡ vÃ  cÃ¡c Ä‘iá»ƒm chá»£ phiÃªn
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 4, 5900000, 4.30, 41);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HALONG', 'Háº¡ Long - Du thuyá»n vá»‹nh xanh',
        'KhÃ¡m phÃ¡ Háº¡ Long trÃªn du thuyá»n giá»¯a vá»‹nh xanh, nÆ¡i nhá»¯ng dÃ£y nÃºi Ä‘Ã¡ vÃ´i, lÃ n nÆ°á»›c Ãªm vÃ  khoáº£nh kháº¯c hoÃ ng hÃ´n táº¡o nÃªn tráº£i nghiá»‡m nghá»‰ dÆ°á»¡ng Ä‘Ã¡ng nhá»›. Lá»‹ch trÃ¬nh 3 ngÃ y káº¿t há»£p tham quan, thÆ° giÃ£n trÃªn tÃ u vÃ  khÃ¡m phÃ¡ CÃ¡t BÃ , phÃ¹ há»£p cho du khÃ¡ch muá»‘n táº­n hÆ°á»Ÿng má»™t chuyáº¿n Ä‘i tiá»‡n nghi nhÆ°ng váº«n gáº§n gÅ©i thiÃªn nhiÃªn.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Vá»‹nh Háº¡ Long vÃ  CÃ¡t BÃ 
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 5600000, 4.55, 67);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_CANTHO', 'Cáº§n ThÆ¡ - Chá»£ ná»•i vÃ  miá»‡t vÆ°á»n sÃ´ng nÆ°á»›c',
        'Tráº£i nghiá»‡m nhá»‹p sá»‘ng miá»n TÃ¢y qua hÃ nh trÃ¬nh Cáº§n ThÆ¡, chá»£ ná»•i CÃ¡i RÄƒng vÃ  miá»‡t vÆ°á»n sÃ´ng nÆ°á»›c, nÆ¡i du khÃ¡ch Ä‘Æ°á»£c cáº£m nháº­n sá»± má»™c máº¡c, hÃ o sáº£ng vÃ  giÃ u báº£n sáº¯c cá»§a vÃ¹ng Ä‘áº¥t phÃ¹ sa. Lá»‹ch trÃ¬nh 3 ngÃ y nháº¹ nhÃ ng, nhiá»u hoáº¡t Ä‘á»™ng Ä‘á»i sá»‘ng Ä‘á»‹a phÆ°Æ¡ng vÃ  phÃ¹ há»£p cho gia Ä‘Ã¬nh, nhÃ³m báº¡n hoáº·c khÃ¡ch muá»‘n nghá»‰ ngáº¯n ngÃ y.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan chá»£ ná»•i CÃ¡i RÄƒng vÃ  miá»‡t vÆ°á»n
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 3500000, 4.75, 88);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_CONDAO', 'CÃ´n Äáº£o - Biá»ƒn hoang sÆ¡ vÃ  kÃ½ á»©c lá»‹ch sá»­',
        'Äáº¿n CÃ´n Äáº£o Ä‘á»ƒ cáº£m nháº­n váº» Ä‘áº¹p hoang sÆ¡ cá»§a biá»ƒn Ä‘áº£o vÃ  chiá»u sÃ¢u lá»‹ch sá»­ qua nhá»¯ng Ä‘iá»ƒm Ä‘áº¿n giÃ u kÃ½ á»©c. Trong 4 ngÃ y, tour káº¿t há»£p nghá»‰ biá»ƒn, tham quan di tÃ­ch, tráº£i nghiá»‡m thiÃªn nhiÃªn vÃ  hoáº¡t Ä‘á»™ng báº£o vá»‡ mÃ´i trÆ°á»ng, mang Ä‘áº¿n má»™t chuyáº¿n Ä‘i yÃªn bÃ¬nh nhÆ°ng nhiá»u dÆ° Ã¢m.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan CÃ´n Äáº£o, di tÃ­ch lá»‹ch sá»­ vÃ  bÃ£i biá»ƒn
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 4, 8300000, 4.60, 52);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_MOCCHAU', 'Má»™c ChÃ¢u - Äá»“i chÃ¨ vÃ  mÃ¹a hoa cao nguyÃªn',
        'Táº­n hÆ°á»Ÿng Má»™c ChÃ¢u trong sáº¯c xanh cá»§a Ä‘á»“i chÃ¨, mÃ¹a hoa cao nguyÃªn vÃ  khÃ´ng khÃ­ trong lÃ nh cá»§a nÃºi rá»«ng TÃ¢y Báº¯c. Lá»‹ch trÃ¬nh 2 ngÃ y Ä‘Æ°á»£c thiáº¿t káº¿ gá»n gÃ ng, dá»… Ä‘i, phÃ¹ há»£p cho chuyáº¿n nghá»‰ cuá»‘i tuáº§n vá»›i cÃ¡c Ä‘iá»ƒm tham quan thiÃªn nhiÃªn, nÃ´ng tráº¡i vÃ  vÄƒn hÃ³a Ä‘á»‹a phÆ°Æ¡ng.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Ä‘á»“i chÃ¨, nÃ´ng tráº¡i vÃ  Ä‘iá»ƒm mÃ¹a hoa
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 2, 2600000, 4.50, 74);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_QUYNHON', 'Quy NhÆ¡n - Ká»³ Co Eo GiÃ³ vÃ  lÃ ng chÃ i',
        'KhÃ¡m phÃ¡ Quy NhÆ¡n qua Ká»³ Co, Eo GiÃ³ vÃ  nhá»¯ng lÃ ng chÃ i ven biá»ƒn, nÆ¡i váº» Ä‘áº¹p biá»ƒn xanh, vÃ¡ch Ä‘Ã¡ vÃ  áº©m thá»±c miá»n Trung táº¡o nÃªn má»™t hÃ nh trÃ¬nh Ä‘áº§y nÄƒng lÆ°á»£ng. Vá»›i 3 ngÃ y, tour cÃ¢n báº±ng giá»¯a tham quan, nghá»‰ biá»ƒn vÃ  tráº£i nghiá»‡m Ä‘á»i sá»‘ng Ä‘á»‹a phÆ°Æ¡ng, phÃ¹ há»£p cho du khÃ¡ch thÃ­ch biá»ƒn vÃ  nhá»¯ng khung cáº£nh rá»™ng má»Ÿ.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Ká»³ Co, Eo GiÃ³ vÃ  lÃ ng chÃ i
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 5200000, 4.68, 81);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HOIAN', 'Há»™i An - Phá»‘ cá»• vÃ  lÃ ng rau TrÃ  Quáº¿',
        'Dáº¡o bÆ°á»›c qua Há»™i An vá»›i phá»‘ cá»•, lÃ ng rau TrÃ  Quáº¿ vÃ  nhá»¯ng tráº£i nghiá»‡m vÄƒn hÃ³a nháº¹ nhÃ ng, nÆ¡i tá»«ng con phá»‘, mÃ³n Äƒn vÃ  náº¿p sá»‘ng Ä‘á»‹a phÆ°Æ¡ng Ä‘á»u mang nÃ©t duyÃªn riÃªng. Lá»‹ch trÃ¬nh 3 ngÃ y káº¿t há»£p tham quan di sáº£n, tráº£i nghiá»‡m áº©m thá»±c vÃ  hoáº¡t Ä‘á»™ng cá»™ng Ä‘á»“ng, phÃ¹ há»£p cho du khÃ¡ch yÃªu sá»± cháº­m rÃ£i vÃ  tinh táº¿.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan phá»‘ cá»• Há»™i An vÃ  lÃ ng rau TrÃ  Quáº¿
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 4400000, 4.72, 93);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_BUONMATHUOT', 'BuÃ´n Ma Thuá»™t - CÃ  phÃª vÃ  thÃ¡c Dray Nur',
        'KhÃ¡m phÃ¡ BuÃ´n Ma Thuá»™t qua hÆ°Æ¡ng cÃ  phÃª, vÄƒn hÃ³a TÃ¢y NguyÃªn vÃ  váº» Ä‘áº¹p máº¡nh máº½ cá»§a thÃ¡c Dray Nur. Trong 3 ngÃ y, tour Ä‘Æ°a du khÃ¡ch Ä‘áº¿n báº£o tÃ ng cÃ  phÃª, BuÃ´n ÄÃ´n vÃ  cÃ¡c khÃ´ng gian vÄƒn hÃ³a báº£n Ä‘á»‹a, táº¡o nÃªn chuyáº¿n Ä‘i giÃ u tráº£i nghiá»‡m, gáº§n gÅ©i thiÃªn nhiÃªn vÃ  con ngÆ°á»i Ä‘á»‹a phÆ°Æ¡ng.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan báº£o tÃ ng cÃ  phÃª, BuÃ´n ÄÃ´n vÃ  thÃ¡c Dray Nur
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 4000000, 4.65, 80);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_PULUONG', 'PÃ¹ LuÃ´ng - Ruá»™ng báº­c thang vÃ  báº£n lÃ ng',
        'Trá»Ÿ vá» nhá»‹p sá»‘ng an yÃªn cá»§a PÃ¹ LuÃ´ng vá»›i ruá»™ng báº­c thang, báº£n lÃ ng vÃ  nhá»¯ng cung Ä‘Æ°á»ng Ä‘i bá»™ nháº¹ giá»¯a thung lÅ©ng xanh. Lá»‹ch trÃ¬nh 2 ngÃ y phÃ¹ há»£p cho du khÃ¡ch muá»‘n táº¡m rá»i phá»‘ thá»‹, nghá»‰ táº¡i khÃ´ng gian gáº§n gÅ©i thiÃªn nhiÃªn vÃ  tráº£i nghiá»‡m vÄƒn hÃ³a cá»™ng Ä‘á»“ng má»™t cÃ¡ch vá»«a sá»©c.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan PÃ¹ LuÃ´ng, báº£n lÃ ng vÃ  ruá»™ng báº­c thang
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 2, 3200000, 4.63, 76);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_MUINE', 'MÅ©i NÃ© - Äá»“i cÃ¡t vÃ  biá»ƒn xanh Phan Thiáº¿t',
        'Táº­n hÆ°á»Ÿng MÅ©i NÃ© vá»›i Ä‘á»“i cÃ¡t, lÃ ng chÃ i vÃ  biá»ƒn xanh Phan Thiáº¿t, nÆ¡i náº¯ng giÃ³ miá»n duyÃªn háº£i mang Ä‘áº¿n má»™t chuyáº¿n Ä‘i rá»±c rá»¡ vÃ  thÆ° thÃ¡i. Lá»‹ch trÃ¬nh 3 ngÃ y káº¿t há»£p tham quan, nghá»‰ biá»ƒn vÃ  thÆ°á»Ÿng thá»©c Ä‘áº·c sáº£n Ä‘á»‹a phÆ°Æ¡ng, phÃ¹ há»£p cho nhÃ³m báº¡n, gia Ä‘Ã¬nh vÃ  nhá»¯ng ai yÃªu khÃ´ng khÃ­ biá»ƒn.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan Ä‘á»“i cÃ¡t, lÃ ng chÃ i MÅ©i NÃ© vÃ  cÃ¡c Ä‘iá»ƒm biá»ƒn
- LÆ°u trÃº vÃ  bá»¯a Äƒn theo lá»‹ch trÃ¬nh
- HÆ°á»›ng dáº«n viÃªn du lá»‹ch
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT
- Tips cho hÆ°á»›ng dáº«n viÃªn vÃ  tÃ i xáº¿', 3, 4700000, 4.42, 69);

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_SAPA_01', 'TM_SAPA', 1, 'HÃ  Ná»™i - Sa Pa - CÃ¡t CÃ¡t', 'Di chuyá»ƒn, nháº­n phÃ²ng, tham quan báº£n CÃ¡t CÃ¡t.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m lam, gÃ  Ä‘á»“i | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_SAPA_02', 'TM_SAPA', 2, 'Fansipan - Chá»£ Ä‘Ãªm Sa Pa', 'SÄƒn mÃ¢y Fansipan vÃ  tá»± do khÃ¡m phÃ¡ thá»‹ tráº¥n.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u cÃ¡ táº§m | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_SAPA_03', 'TM_SAPA', 3, 'Táº£ Van - HÃ  Ná»™i', 'Tham quan Táº£ Van, Äƒn trÆ°a vÃ  vá» láº¡i HÃ  Ná»™i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m rang, Ä‘áº·c sáº£n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_01', 'TM_DANANG', 1, 'ÄÃ  Náºµng - SÆ¡n TrÃ ', 'ÄÃ³n khÃ¡ch, tham quan bÃ¡n Ä‘áº£o SÆ¡n TrÃ .', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Háº£i sáº£n Ä‘á»‹a phÆ°Æ¡ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_02', 'TM_DANANG', 2, 'Há»™i An', 'Tham quan phá»‘ cá»•, Äƒn trÆ°a Ä‘áº·c sáº£n.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Cao láº§u, mÃ¬ Quáº£ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_03', 'TM_DANANG', 3, 'BÃ  NÃ  Hills', 'Tham quan BÃ  NÃ  Hills, cáº§u VÃ ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Buffet | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_04', 'TM_DANANG', 4, 'Mua sáº¯m - Tiá»…n khÃ¡ch', 'Mua sáº¯m Ä‘áº·c sáº£n, tiá»…n khÃ¡ch ra sÃ¢n bay.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Háº£i sáº£n nháº¹ | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DALAT_01', 'TM_DALAT', 1, 'NÃ´ng tráº¡i há»¯u cÆ¡', 'LÃ m quen lá»‹ch trÃ¬nh xanh vÃ  thu hoáº¡ch rau sáº¡ch.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Rau cá»§ cao nguyÃªn | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DALAT_02', 'TM_DALAT', 2, 'Äá»“i chÃ¨ Cáº§u Äáº¥t', 'Ngáº¯m bÃ¬nh minh, tham quan xÆ°á»Ÿng chÃ¨.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u tháº£ | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DALAT_03', 'TM_DALAT', 3, 'LÃ ng hoa Váº¡n ThÃ nh', 'Tham quan lÃ ng hoa, xe Ä‘Æ°a khÃ¡ch vá».', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m niÃªu | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_NB_01', 'TM_NINHBINH', 1, 'TrÃ ng An - Hoa LÆ°', 'Äi thuyá»n tham quan TrÃ ng An, thÄƒm cá»‘ Ä‘Ã´ Hoa LÆ°.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: DÃª nÃºi, cÆ¡m chÃ¡y | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_NB_02', 'TM_NINHBINH', 2, 'ChÃ¹a BÃ¡i ÄÃ­nh', 'Tham quan chÃ¹a BÃ¡i ÄÃ­nh, káº¿t thÃºc chÆ°Æ¡ng trÃ¬nh.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m chay | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HUE_01', 'TM_HUE', 1, 'Kinh thÃ nh Huáº¿', 'Tham quan Äáº¡i Ná»™i vÃ  nghe ca Huáº¿ trÃªn sÃ´ng HÆ°Æ¡ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn bÃ² Huáº¿ | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HUE_02', 'TM_HUE', 2, 'LÄƒng táº©m', 'Tham quan lÄƒng Tá»± Äá»©c, Kháº£i Äá»‹nh.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃ¡nh bÃ¨o náº­m lá»c | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HUE_03', 'TM_HUE', 3, 'Chá»£ ÄÃ´ng Ba', 'Mua sáº¯m Ä‘áº·c sáº£n, tiá»…n khÃ¡ch ra ga/sÃ¢n bay.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn thá»‹t nÆ°á»›ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HALONG_01', 'TM_HALONG', 1, 'HÃ  Ná»™i - Háº¡ Long - Du thuyá»n', 'Nháº­n phÃ²ng trÃªn du thuyá»n vÃ  ngáº¯m hoÃ ng hÃ´n trÃªn vá»‹nh.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Háº£i sáº£n trÃªn tÃ u | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CANTHO_01', 'TM_CANTHO', 1, 'Cáº§n ThÆ¡ - Báº¿n Ninh Kiá»u', 'ÄÃ³n khÃ¡ch vÃ  tham quan báº¿n Ninh Kiá»u buá»•i tá»‘i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u máº¯m miá»n TÃ¢y | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_01', 'TM_CONDAO', 1, 'CÃ´n Äáº£o - BÃ£i Äáº§m Tráº§u', 'Nháº­n phÃ²ng, nghá»‰ biá»ƒn vÃ  hÆ°á»›ng dáº«n quy táº¯c báº£o vá»‡ mÃ´i trÆ°á»ng biá»ƒn.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Háº£i sáº£n Ä‘á»‹a phÆ°Æ¡ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MOCCHAU_01', 'TM_MOCCHAU', 1, 'Äá»“i chÃ¨ trÃ¡i tim', 'Tham quan Ä‘á»“i chÃ¨, cáº§u kÃ­nh vÃ  nÃ´ng tráº¡i bÃ² sá»¯a.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃª chao, rau cáº£i mÃ¨o | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_QUYNHON_01', 'TM_QUYNHON', 1, 'Ká»³ Co - Eo GiÃ³', 'Äi canoe ra Ká»³ Co, tham quan Eo GiÃ³ vÃ  lÃ ng chÃ i NhÆ¡n LÃ½.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn cháº£ cÃ¡ Quy NhÆ¡n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HOIAN_01', 'TM_HOIAN', 1, 'Phá»‘ cá»• Há»™i An - TrÃ  Quáº¿', 'Tham quan phá»‘ cá»• vÃ  lá»›p náº¥u Äƒn táº¡i lÃ ng rau TrÃ  Quáº¿.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Cao láº§u, bÃ¡nh váº¡c | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BMT_01', 'TM_BUONMATHUOT', 1, 'Báº£o tÃ ng cÃ  phÃª - BuÃ´n ÄÃ´n', 'Tráº£i nghiá»‡m vÄƒn hÃ³a cÃ  phÃª vÃ  khÃ´ng gian TÃ¢y NguyÃªn.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: GÃ  nÆ°á»›ng cÆ¡m lam | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PULUONG_01', 'TM_PULUONG', 1, 'Báº£n ÄÃ´n - Ruá»™ng báº­c thang', 'Äi bá»™ nháº¹ quanh báº£n, ngáº¯m hoÃ ng hÃ´n trÃªn thung lÅ©ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Vá»‹t Cá»• LÅ©ng, rau rá»«ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MUINE_01', 'TM_MUINE', 1, 'Äá»“i cÃ¡t bay - LÃ ng chÃ i MÅ©i NÃ©', 'Tham quan Ä‘á»“i cÃ¡t, lÃ ng chÃ i vÃ  nghá»‰ biá»ƒn buá»•i chiá»u.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u tháº£ Phan Thiáº¿t | Chiá»u: TrÃ¡i cÃ¢y nháº¹');

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HALONG_02', 'TM_HALONG', 2, 'Hang Sá»­ng Sá»‘t - Ä‘áº£o Titop', 'Tham quan hang, chÃ¨o kayak vÃ  ngáº¯m toÃ n cáº£nh vá»‹nh tá»« Ä‘á»‰nh Titop.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m Viá»‡t trÃªn tÃ u | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HALONG_03', 'TM_HALONG', 3, 'CÃ¡t BÃ  - HÃ  Ná»™i', 'Tráº£i nghiá»‡m buá»•i sÃ¡ng trÃªn vá»‹nh, tráº£ phÃ²ng vÃ  vá» láº¡i HÃ  Ná»™i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn háº£i sáº£n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CANTHO_02', 'TM_CANTHO', 2, 'Chá»£ ná»•i CÃ¡i RÄƒng - miá»‡t vÆ°á»n', 'Äi chá»£ ná»•i sá»›m, thÄƒm vÆ°á»n trÃ¡i cÃ¢y vÃ  lÃ m bÃ¡nh dÃ¢n gian.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÃ¡ lÃ³c nÆ°á»›ng trui | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CANTHO_03', 'TM_CANTHO', 3, 'NhÃ  cá»• BÃ¬nh Thá»§y - tiá»…n khÃ¡ch', 'Tham quan nhÃ  cá»•, mua Ä‘áº·c sáº£n vÃ  káº¿t thÃºc chÆ°Æ¡ng trÃ¬nh.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Há»§ tiáº¿u Nam Vang | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_02', 'TM_CONDAO', 2, 'HÃ²n Báº£y Cáº¡nh - báº£o tá»“n biá»ƒn', 'Tráº£i nghiá»‡m biá»ƒn Ä‘áº£o vÃ  nghe giá»›i thiá»‡u vá» báº£o tá»“n rÃ¹a biá»ƒn.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m niÃªu háº£i sáº£n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_03', 'TM_CONDAO', 3, 'Di tÃ­ch CÃ´n Äáº£o', 'Tham quan cÃ¡c Ä‘iá»ƒm di tÃ­ch lá»‹ch sá»­ vÃ  báº£o tÃ ng Ä‘á»‹a phÆ°Æ¡ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃ¡nh xÃ¨o háº£i sáº£n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_04', 'TM_CONDAO', 4, 'Äáº§m Tráº§u - tiá»…n khÃ¡ch', 'Nghá»‰ biá»ƒn buá»•i sÃ¡ng, mua Ä‘áº·c sáº£n vÃ  ra sÃ¢n bay.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m Ä‘oÃ n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MOCCHAU_02', 'TM_MOCCHAU', 2, 'ThÃ¡c Dáº£i Yáº¿m - káº¿t thÃºc', 'Tham quan thÃ¡c, mua Ä‘áº·c sáº£n sá»¯a vÃ  vá» láº¡i Ä‘iá»ƒm Ä‘Ã³n.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u gÃ  Ä‘en | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_QUYNHON_02', 'TM_QUYNHON', 2, 'Eo GiÃ³ - ThÃ¡p ÄÃ´i', 'Tham quan Eo GiÃ³, ThÃ¡p ÄÃ´i vÃ  thÆ°á»Ÿng thá»©c Ä‘áº·c sáº£n Ä‘á»‹a phÆ°Æ¡ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Nem nÆ°á»›ng, bÃ¡nh xÃ¨o tÃ´m nháº£y | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_QUYNHON_03', 'TM_QUYNHON', 3, 'LÃ ng chÃ i - tiá»…n khÃ¡ch', 'Tráº£i nghiá»‡m lÃ ng chÃ i, mua Ä‘áº·c sáº£n vÃ  káº¿t thÃºc tour.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m nhÃ  hÃ ng biá»ƒn | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HOIAN_02', 'TM_HOIAN', 2, 'Má»¹ SÆ¡n - rá»«ng dá»«a Báº£y Máº«u', 'Tham quan Má»¹ SÆ¡n, Ä‘i thuyá»n thÃºng vÃ  Äƒn tá»‘i phá»‘ cá»•.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: MÃ¬ Quáº£ng, bÃ¡nh Ä‘áº­p | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HOIAN_03', 'TM_HOIAN', 3, 'TrÃ  Quáº¿ - tiá»…n khÃ¡ch', 'Tráº£i nghiá»‡m lÃ ng rau, mua quÃ  vÃ  káº¿t thÃºc chÆ°Æ¡ng trÃ¬nh.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m gÃ  Há»™i An | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BMT_02', 'TM_BUONMATHUOT', 2, 'ThÃ¡c Dray Nur - BuÃ´n ÄÃ´n', 'Tham quan thÃ¡c, tÃ¬m hiá»ƒu vÄƒn hÃ³a ÃŠ ÄÃª vÃ  M''NÃ´ng.', 'CÆ¡m lam, thá»‹t nÆ°á»›ng');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BMT_03', 'TM_BUONMATHUOT', 3, 'LÃ ng cÃ  phÃª - tiá»…n khÃ¡ch', 'ThÆ°á»Ÿng thá»©c cÃ  phÃª, mua quÃ  vÃ  ra sÃ¢n bay.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn Ä‘á» BuÃ´n Ma Thuá»™t | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PULUONG_02', 'TM_PULUONG', 2, 'HiÃªu - káº¿t thÃºc', 'Äi bá»™ nháº¹ ra thÃ¡c HiÃªu, Äƒn trÆ°a vÃ  vá» láº¡i HÃ  Ná»™i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m báº£n | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MUINE_02', 'TM_MUINE', 2, 'BÃ u Tráº¯ng - Suá»‘i TiÃªn', 'Ngáº¯m bÃ¬nh minh BÃ u Tráº¯ng, tham quan Suá»‘i TiÃªn vÃ  nghá»‰ biá»ƒn.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Háº£i sáº£n nÆ°á»›ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MUINE_03', 'TM_MUINE', 3, 'Phan Thiáº¿t - tiá»…n khÃ¡ch', 'Tham quan láº§u Ã”ng HoÃ ng, mua Ä‘áº·c sáº£n vÃ  káº¿t thÃºc tour.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u tháº£ Phan Thiáº¿t | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_01', 'TM_HAGIANG', 1, 'HÃ  Ná»™i - Quáº£n Báº¡', 'Di chuyá»ƒn lÃªn HÃ  Giang, nháº­n phÃ²ng vÃ  tham quan cá»•ng trá»i Quáº£n Báº¡.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Tháº¯ng cá»‘, rau cáº£i mÃ¨o | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_02', 'TM_HAGIANG', 2, 'YÃªn Minh - Äá»“ng VÄƒn', 'Tham quan rá»«ng thÃ´ng YÃªn Minh, dinh vua MÃ¨o vÃ  phá»‘ cá»• Äá»“ng VÄƒn.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u gÃ  Ä‘en | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_03', 'TM_HAGIANG', 3, 'MÃ£ PÃ¬ LÃ¨ng - MÃ¨o Váº¡c', 'Äi cung Ä‘Æ°á»ng MÃ£ PÃ¬ LÃ¨ng, sÃ´ng Nho Quáº¿ vÃ  chá»£ phiÃªn Ä‘á»‹a phÆ°Æ¡ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m lam, thá»‹t lá»£n cáº¯p nÃ¡ch | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_04', 'TM_HAGIANG', 4, 'MÃ¨o Váº¡c - HÃ  Ná»™i', 'Mua Ä‘áº·c sáº£n, tráº£ phÃ²ng vÃ  vá» láº¡i HÃ  Ná»™i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Phá»Ÿ chua HÃ  Giang | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_01', 'TM_PHUQUOC', 1, 'DÆ°Æ¡ng ÄÃ´ng - BÃ£i TrÆ°á»ng', 'ÄÃ³n khÃ¡ch, nháº­n phÃ²ng vÃ  ngáº¯m hoÃ ng hÃ´n trÃªn BÃ£i TrÆ°á»ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Gá»i cÃ¡ trÃ­ch | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_02', 'TM_PHUQUOC', 2, 'Nam Äáº£o - HÃ²n ThÆ¡m', 'Tham quan Nam Äáº£o, tráº£i nghiá»‡m cÃ¡p treo vÃ  bÃ£i biá»ƒn HÃ²n ThÆ¡m.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Háº£i sáº£n nÆ°á»›ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_03', 'TM_PHUQUOC', 3, 'Ráº¡ch Váº¹m - vÆ°á»n tiÃªu', 'Tham quan Ráº¡ch Váº¹m, vÆ°á»n tiÃªu vÃ  cÆ¡ sá»Ÿ nÆ°á»›c máº¯m truyá»n thá»‘ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn quáº­y | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_04', 'TM_PHUQUOC', 4, 'Chá»£ DÆ°Æ¡ng ÄÃ´ng - tiá»…n khÃ¡ch', 'Mua Ä‘áº·c sáº£n, tráº£ phÃ²ng vÃ  káº¿t thÃºc tour.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÆ¡m gia Ä‘Ã¬nh | Chiá»u: TrÃ¡i cÃ¢y nháº¹');

INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_SINGLE', 'Phá»¥ thu phÃ²ng Ä‘Æ¡n', 'PhÃ²ng/Ä‘Ãªm', 650000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_AIRPORT', 'ÄÆ°a Ä‘Ã³n sÃ¢n bay riÃªng', 'LÆ°á»£t', 350000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_DINNER', 'Bá»¯a tá»‘i Ä‘áº·c sáº£n nÃ¢ng cáº¥p', 'Suáº¥t', 280000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_INSURANCE', 'Báº£o hiá»ƒm du lá»‹ch má»Ÿ rá»™ng', 'NgÆ°á»i', 120000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_PHOTO', 'GÃ³i chá»¥p áº£nh hÃ nh trÃ¬nh', 'GÃ³i', 900000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_BOTTLE', 'Mang bÃ¬nh nÆ°á»›c cÃ¡ nhÃ¢n trong tour', 80);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_CLEANUP', 'Tham gia nháº·t rÃ¡c táº¡i Ä‘iá»ƒm tham quan', 150);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_EBILL', 'Äá»“ng Ã½ nháº­n hÃ³a Ä‘Æ¡n Ä‘iá»‡n tá»­', 50);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_TREE', 'ÄÃ³ng gÃ³p trá»“ng cÃ¢y táº¡i Ä‘iá»ƒm Ä‘áº¿n', 200);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_LOCAL', 'Sá»­ dá»¥ng sáº£n pháº©m Ä‘á»‹a phÆ°Æ¡ng thay Ä‘á»“ nhá»±a dÃ¹ng má»™t láº§n', 100);

-- ------------------------------------------------------------
-- 3. TOUR THUC TE - DU 7 TRANG THAI TOUR
-- ------------------------------------------------------------
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CKH', 'TM_HAGIANG', DATE(NOW()) + INTERVAL 90 DAY, 6100000, 18, 6, 18, 'CHO_KICH_HOAT');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MB', 'TM_SAPA', DATE(NOW()) + INTERVAL 45 DAY, 4800000, 20, 8, 20, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_SDR', 'TM_DANANG', DATE(NOW()) + INTERVAL 12 DAY, 6500000, 24, 10, 24, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_DDR', 'TM_DALAT', DATE(NOW()) - INTERVAL 1 DAY, 4200000, 16, 6, 16, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_KT', 'TM_NINHBINH', DATE(NOW()) - INTERVAL 10 DAY, 3000000, 30, 12, 30, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HUY', 'TM_PHUQUOC', DATE(NOW()) + INTERVAL 75 DAY, 7900000, 18, 8, 18, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_QT', 'TM_HUE', DATE(NOW()) - INTERVAL 20 DAY, 4300000, 22, 8, 22, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MB', 'DVT_SINGLE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MB', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SDR', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DDR', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUY', 'DVT_SINGLE');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DDR', 'HDX_BOTTLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DDR', 'HDX_CLEANUP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MB', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_QT', 'HDX_EBILL');

-- HDV phu trach tung tour. Dieu hanh theo doi bang nhat_ky_he_thongs o cuoi script.
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_MB_HDV01', 'TTT_MB', 'NV_HDV01', NOW() - INTERVAL 8 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_SDR_HDV02', 'TTT_SDR', 'NV_HDV02', NOW() - INTERVAL 7 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_DDR_HDV01', 'TTT_DDR', 'NV_HDV01', NOW() - INTERVAL 6 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_KT_HDV02', 'TTT_KT', 'NV_HDV02', NOW() - INTERVAL 5 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_HUY_HDV02', 'TTT_HUY', 'NV_HDV02', NOW() - INTERVAL 4 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_QT_HDV01', 'TTT_QT', 'NV_HDV01', NOW() - INTERVAL 3 DAY, 'DA_DONG_Y');

-- ------------------------------------------------------------
-- 4. vouchers VA VI KHUYEN MAI
-- ------------------------------------------------------------
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_EARLY10', 'EARLY-10', 'PHAN_TRAM', 10, 500000, 'Giáº£m 10% cho Ä‘Æ¡n Ä‘áº·t sá»›m', 100, 0, DATE(NOW()) - INTERVAL 30 DAY, DATE(NOW()) + INTERVAL 120 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_GREEN500', 'GREEN-500', 'SO_TIEN', 500000, 'Äá»•i Ä‘iá»ƒm xanh láº¥y voucher 500.000 VND', 50, 0, DATE(NOW()) - INTERVAL 15 DAY, DATE(NOW()) + INTERVAL 90 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_EXPIRED', 'EXPIRED', 'SO_TIEN', 300000, 'Voucher háº¿t háº¡n Ä‘á»ƒ minh há»a tráº¡ng thÃ¡i', 10, 0, DATE(NOW()) - INTERVAL 90 DAY, DATE(NOW()) - INTERVAL 10 DAY, 'VO_HIEU_HOA');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_FAMILY700', 'FAMILY-700', 'SO_TIEN', 700000, 'Giáº£m cho nhÃ³m gia Ä‘Ã¬nh tá»« 3 khÃ¡ch trá»Ÿ lÃªn', 80, 0, DATE(NOW()) - INTERVAL 20 DAY, DATE(NOW()) + INTERVAL 150 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_MEMBER15', 'MEMBER-15', 'PHAN_TRAM', 15, 750000, 'Æ¯u Ä‘Ã£i 15% cho thÃ nh viÃªn háº¡ng vÃ ng trá»Ÿ lÃªn', 60, 0, DATE(NOW()) - INTERVAL 10 DAY, DATE(NOW()) + INTERVAL 120 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_DIEMXANH800', 'DIEMXANH-800', 'SO_TIEN', 800000, 'Quy Ä‘á»•i 800 Ä‘iá»ƒm xanh khi Ä‘áº·t tour', 40, 0, DATE(NOW()) - INTERVAL 5 DAY, DATE(NOW()) + INTERVAL 120 DAY, 'SAN_SANG');

INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_01', 'VC_EARLY10', DATE(NOW()) + INTERVAL 60 DAY, NOW() - INTERVAL 12 DAY, 'CO_HIEU_LUC');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_02', 'VC_GREEN500', DATE(NOW()) + INTERVAL 45 DAY, NOW() - INTERVAL 10 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_02', 'VC_EARLY10', DATE(NOW()) + INTERVAL 60 DAY, NOW() - INTERVAL 25 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_03', 'VC_EARLY10', DATE(NOW()) + INTERVAL 60 DAY, NOW() - INTERVAL 8 DAY, 'DA_THU_HOI');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_04', 'VC_EXPIRED', DATE(NOW()) - INTERVAL 1 DAY, NOW() - INTERVAL 40 DAY, 'HET_HAN');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_16', 'VC_FAMILY700', DATE(NOW()) + INTERVAL 90 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_13', 'VC_MEMBER15', DATE(NOW()) + INTERVAL 80 DAY, NOW() - INTERVAL 4 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_14', 'VC_FAMILY700', DATE(NOW()) + INTERVAL 90 DAY, NOW() - INTERVAL 2 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_05', 'VC_DIEMXANH800', DATE(NOW()) + INTERVAL 90 DAY, NOW() - INTERVAL 6 HOUR, 'DA_SU_DUNG');

-- ------------------------------------------------------------
-- 5. DON DAT TOUR - DU 7 TRANG THAI DON DAT
-- ------------------------------------------------------------
-- Fix trigger TRG_KT_TOUR_MO_BAN de ho tro viec insert du lieu qua khu;

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CHO_XN', 'TTT_MB', 'KH_01', NOW() - INTERVAL 1 DAY, 10250000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Chá» khÃ¡ch xÃ¡c nháº­n thanh toÃ¡n', 'HDX_EBILL:1');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_DA_XN', 'TTT_MB', 'KH_02', NOW() - INTERVAL 2 DAY, 14250000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Ãp dá»¥ng voucher VC_GREEN500: táº¡m tÃ­nh 14.750.000, giáº£m 500.000, tá»•ng sau giáº£m 14.250.000. ÄÆ¡n Ä‘Ã£ thanh toÃ¡n Ä‘á»§, trigger sáº½ chuyá»ƒn DA_XAC_NHAN.', 'HDX_EBILL:1');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HET_HAN', 'TTT_MB', 'KH_03', NOW() - INTERVAL 3 DAY, 4800000, 'HET_HAN_GIU_CHO',
        NOW() - INTERVAL 2 DAY, 'KhÃ¡ch khÃ´ng thanh toÃ¡n trong thá»i gian giá»¯ chá»—', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CHO_HUY', 'TTT_SDR', 'KH_04', NOW() - INTERVAL 4 DAY, 6500000, 'CHO_HUY',
        NOW() + INTERVAL 1 DAY, 'KhÃ¡ch gá»­i yÃªu cáº§u há»§y, Ä‘á»™i Ä‘iá»u hÃ nh xá»­ lÃ½', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_TU_CHOI_HT', 'TTT_SDR', 'KH_05', NOW() - INTERVAL 4 DAY, 6500000, 'TU_CHOI_HOAN_TIEN',
        NOW() + INTERVAL 1 DAY, 'QuÃ¡ háº¡n hoÃ n tiá»n theo chÃ­nh sÃ¡ch', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_TT_FAIL', 'TTT_SDR', 'KH_06', NOW() - INTERVAL 1 DAY, 6500000, 'THANH_TOAN_THAT_BAI',
        NOW() + INTERVAL 1 DAY, 'NgÃ¢n hÃ ng tráº£ vá» tháº¥t báº¡i', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_DANG_DIEN_RA', 'TTT_DDR', 'KH_01', NOW() - INTERVAL 5 DAY, 8400000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'ÄÆ¡n cho tour Ä‘ang diá»…n ra', 'HDX_BOTTLE:1,HDX_CLEANUP:1');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_KET_THUC', 'TTT_KT', 'KH_04', NOW() - INTERVAL 15 DAY, 6000000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'ÄÆ¡n Ä‘Ã£ hoÃ n thÃ nh tour vÃ  Ä‘á»§ Ä‘iá»u kiá»‡n Ä‘Ã¡nh giÃ¡', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HUY', 'TTT_HUY', 'KH_05', NOW() - INTERVAL 7 DAY, 15800000, 'DA_HUY',
        NOW() + INTERVAL 1 DAY, 'ÄÆ¡n sáº½ bá»‹ há»§y tá»± Ä‘á»™ng khi tour bá»‹ há»§y', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_QUYET_TOAN', 'TTT_QT', 'KH_02', NOW() - INTERVAL 25 DAY, 8300000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Ãp dá»¥ng voucher VC_EARLY10: tiá»n tour 8.600.000, dá»‹ch vá»¥ 560.000, giáº£m 860.000, tá»•ng sau giáº£m 8.300.000. ÄÆ¡n thuá»™c tour Ä‘Ã£ quyáº¿t toÃ¡n.', 'HDX_EBILL:1');

-- Don dat tour 5 nguoi cho tour Da Nang
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_5_PEOPLE', 'TTT_SDR', 'KH_03', NOW() - INTERVAL 3 DAY, 32500000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'ÄÆ¡n Ä‘áº·t 5 ngÆ°á»i (1 khÃ¡ch, 4 Ä‘á»“ng hÃ nh).', 'HDX_BOTTLE:1');

-- Nguoi dong hanh
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CHO_XN_01', 'DDT_CHO_XN', 'Tráº§n Gia Báº£o', '079299000201', '0922000201', '2014-07-11', 'NAM', 'Tráº» em Ä‘i cÃ¹ng gia Ä‘Ã¬nh');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DA_XN_01', 'DDT_DA_XN', 'Pháº¡m Minh QuÃ¢n', '079299000202', '0922000202', '1994-03-02', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DA_XN_02', 'DDT_DA_XN', 'Pháº¡m Tuá»‡ Nhi', '079299000203', '0922000203', '2018-10-05', 'NU', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DDR_01', 'DDT_DANG_DIEN_RA', 'Tráº§n Má»¹ Anh', '079299000204', '0922000204', '1998-01-19', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_KT_01', 'DDT_KET_THUC', 'Nguyá»…n Minh TÃ¢m', '079299000205', '0922000205', '1988-09-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HUY_01', 'DDT_HUY', 'Äá»— Minh Nháº­t', '079299000206', '0922000206', '1985-06-06', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_QT_01', 'DDT_QUYET_TOAN', 'Pháº¡m Mai Chi', '079299000207', '0922000207', '1996-04-22', 'NU', NULL);

-- Nguoi dong hanh cho don 5 nguoi
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_01', 'DDT_5_PEOPLE', 'LÃª Minh', '079299000301', '0922000301', '1990-01-01', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_02', 'DDT_5_PEOPLE', 'LÃª Hoa', '079299000302', '0922000302', '1992-02-02', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_03', 'DDT_5_PEOPLE', 'LÃª An', '079299000303', '0922000303', '2015-03-03', 'NAM', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_04', 'DDT_5_PEOPLE', 'LÃª BÃ¬nh', '079299000304', '0922000304', '2018-04-04', 'NAM', 'Tráº» em');

-- Chi tiet hanh khach
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CHO_XN_KH', 'DDT_CHO_XN', 'KH_01', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CHO_XN_NDH1', 'DDT_CHO_XN', NULL, 'NDH_CHO_XN_01', 'NGUOI_DONG_HANH', 4800000);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DA_XN_KH', 'DDT_DA_XN', 'KH_02', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DA_XN_NDH1', 'DDT_DA_XN', NULL, 'NDH_DA_XN_01', 'NGUOI_DONG_HANH', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DA_XN_NDH2', 'DDT_DA_XN', NULL, 'NDH_DA_XN_02', 'NGUOI_DONG_HANH', 4800000);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HET_HAN_KH', 'DDT_HET_HAN', 'KH_03', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CHO_HUY_KH', 'DDT_CHO_HUY', 'KH_04', NULL, 'NGUOI_DAT', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_TU_CHOI_KH', 'DDT_TU_CHOI_HT', 'KH_05', NULL, 'NGUOI_DAT', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_TT_FAIL_KH', 'DDT_TT_FAIL', 'KH_06', NULL, 'NGUOI_DAT', 6500000);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DDR_KH', 'DDT_DANG_DIEN_RA', 'KH_01', NULL, 'NGUOI_DAT', 4200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DDR_NDH1', 'DDT_DANG_DIEN_RA', NULL, 'NDH_DDR_01', 'NGUOI_DONG_HANH', 4200000);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_KT_KH', 'DDT_KET_THUC', 'KH_04', NULL, 'NGUOI_DAT', 3000000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_KT_NDH1', 'DDT_KET_THUC', NULL, 'NDH_KT_01', 'NGUOI_DONG_HANH', 3000000);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUY_KH', 'DDT_HUY', 'KH_05', NULL, 'NGUOI_DAT', 7900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUY_NDH1', 'DDT_HUY', NULL, 'NDH_HUY_01', 'NGUOI_DONG_HANH', 7900000);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_QT_KH', 'DDT_QUYET_TOAN', 'KH_02', NULL, 'NGUOI_DAT', 4300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_QT_NDH1', 'DDT_QUYET_TOAN', NULL, 'NDH_QT_01', 'NGUOI_DONG_HANH', 4300000);

-- Chi tiet dat tour cho don 5 nguoi (Gia Da Nang: 6500000)
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_5P_KH', 'DDT_5_PEOPLE', 'KH_03', NULL, 'NGUOI_DAT', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_5P_NDH1', 'DDT_5_PEOPLE', NULL, 'NDH_5P_01', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_5P_NDH2', 'DDT_5_PEOPLE', NULL, 'NDH_5P_02', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_5P_NDH3', 'DDT_5_PEOPLE', NULL, 'NDH_5P_03', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_5P_NDH4', 'DDT_5_PEOPLE', NULL, 'NDH_5P_04', 'NGUOI_DONG_HANH', 6500000);

-- Dich vu trong don
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CHO_XN_SINGLE', 'DDT_CHO_XN', 'DVT_SINGLE', 1, 650000, 650000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_DA_XN_AIRPORT', 'DDT_DA_XN', 'DVT_AIRPORT', 1, 350000, 350000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_QT_DINNER', 'DDT_QUYET_TOAN', 'DVT_DINNER', 2, 280000, 560000);

-- Uu dai ap dung vao don, trigger se tang so_luot_da_dung cua voucher.
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai)
VALUES ('DDT_DA_XN', 'VC_GREEN500', 500000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai)
VALUES ('DDT_QUYET_TOAN', 'VC_EARLY10', 860000);

-- Giao dich thanh toan/refund - du 4 trang thai giao dich.
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_DA_XN_PAY', 'DDT_DA_XN', 'THANH_TOAN', 'CHUYEN_KHOAN', 14250000, 'BANK-001', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_DDR_PAY', 'DDT_DANG_DIEN_RA', 'THANH_TOAN', 'THE_NOI_DIA', 8400000, 'BANK-002', 'THANH_CONG', NOW() - INTERVAL 4 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_KT_PAY', 'DDT_KET_THUC', 'THANH_TOAN', 'CHUYEN_KHOAN', 6000000, 'BANK-003', 'THANH_CONG', NOW() - INTERVAL 14 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HUY_PAY', 'DDT_HUY', 'THANH_TOAN', 'CHUYEN_KHOAN', 15800000, 'BANK-004', 'THANH_CONG', NOW() - INTERVAL 6 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_QT_PAY', 'DDT_QUYET_TOAN', 'THANH_TOAN', 'THE_QUOC_TE', 8300000, 'BANK-005', 'THANH_CONG', NOW() - INTERVAL 24 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CHO_TT', 'DDT_CHO_XN', 'THANH_TOAN', 'CHUYEN_KHOAN', 10250000, 'BANK-006', 'CHO_THANH_TOAN', NULL);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_TT_FAIL', 'DDT_TT_FAIL', 'THANH_TOAN', 'THE_NOI_DIA', 6500000, 'BANK-007', 'THAT_BAI', NOW() - INTERVAL 1 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_REFUND_DONE', 'DDT_TU_CHOI_HT', 'HOAN_TIEN', 'HE_THONG', 0, 'BANK-008', 'DA_HOAN_TIEN', NOW() - INTERVAL 1 DAY);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_5P_PAY', 'DDT_5_PEOPLE', 'THANH_TOAN', 'CHUYEN_KHOAN', 32500000, 'BANK-5P', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

-- ------------------------------------------------------------
-- 6. VAN HANH TOUR DANG DIEN RA, KET THUC, HUY, QUYET TOAN
-- ------------------------------------------------------------
UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 1 DAY,
    trang_thai = 'DANG_DIEN_RA'
WHERE ma_tour_thuc_te = 'TTT_DDR';

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 15 DAY,
    trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te = 'TTT_KT';

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 30 DAY,
    trang_thai = 'DA_QUYET_TOAN'
WHERE ma_tour_thuc_te = 'TTT_QT';

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_DDR_KH_OK', 'TTT_DDR', 'KH_01', NULL, 'NGUOI_DAT', 'NV_HDV01', NOW() - INTERVAL 2 HOUR, 'Quáº£ng trÆ°á»ng LÃ¢m ViÃªn', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_DDR_NDH_WAIT', 'TTT_DDR', NULL, 'NDH_DDR_01', 'NGUOI_DONG_HANH', 'NV_HDV01', NOW() - INTERVAL 90 MINUTE, 'Quáº£ng trÆ°á»ng LÃ¢m ViÃªn', 'CHUA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_DDR_NDH_ABS', 'TTT_DDR', NULL, 'NDH_DDR_01', 'NGUOI_DONG_HANH', 'NV_HDV01', NOW() - INTERVAL 1 HOUR, 'NÃ´ng tráº¡i ÄÃ  Láº¡t', 'VANG');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DDR_BOTTLE', 'TTT_DDR', 'KH_01', 'HDX_BOTTLE', 'NV_HDV01', NOW() - INTERVAL 1 HOUR,
        'áº¢nh check-in vá»›i bÃ¬nh nÆ°á»›c cÃ¡ nhÃ¢n');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DDR_CLEANUP', 'TTT_DDR', 'KH_01', 'HDX_CLEANUP', 'NV_HDV01', NOW() - INTERVAL 30 MINUTE,
        'HDV xÃ¡c nháº­n khÃ¡ch tham gia nháº·t rÃ¡c táº¡i Ä‘iá»ƒm tham quan');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DDR_WEATHER', 'TTT_DDR', 'NV_HDV01', 'MÆ°a lá»›n báº¥t ngá» táº¡i Ä‘iá»ƒm tham quan.',
        'Äá»•i lá»‹ch tham quan trong nhÃ  vÃ  cáº¥p Ã¡o mÆ°a cho khÃ¡ch.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 20 MINUTE);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DDR_MEDICAL', 'TTT_DDR', 'NV_HDV01', 'KhÃ¡ch bá»‹ say xe cáº§n theo dÃµi.',
        'Sáº¯p xáº¿p gháº¿ Ä‘áº§u xe, cáº¥p nÆ°á»›c áº¥m vÃ  theo dÃµi sá»©c khá»e.', 'SOS', 'Y_TE', NOW() - INTERVAL 10 MINUTE);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_APPROVED', 'TTT_DDR', 'NV_HDV01', 'Ão mÆ°a dá»± phÃ²ng', 320000, 'https://seed.local/hoa-don/ao-mua.jpg', 'DA_DUYET', NOW() - INTERVAL 1 HOUR);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_PENDING', 'TTT_DDR', 'NV_HDV01', 'NÆ°á»›c uá»‘ng bá»• sung', 180000, 'https://seed.local/hoa-don/nuoc.jpg', 'CHO_DUYET', NOW() - INTERVAL 30 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_REJECT', 'TTT_DDR', 'NV_HDV01', 'Phá»¥ phÃ­ khÃ´ng há»£p lá»‡', 90000, NULL, 'TU_CHOI', NOW() - INTERVAL 20 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_NEED_MORE', 'TTT_DDR', 'NV_HDV01', 'VÃ© gá»­i xe', 120000, NULL, 'YEU_CAU_BO_SUNG', NOW() - INTERVAL 10 MINUTE);

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 7 DAY,
    trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te = 'TTT_KT';

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_KT_KH04', 'KH_04', 'TTT_KT', 'CTDT_KT_KH', DATE(NOW()) - INTERVAL 7 DAY);

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_KT_KH04', 'TTT_KT', 'KH_04', 5, 'Lá»‹ch trÃ¬nh gá»n, HDV chÄƒm sÃ³c tá»‘t vÃ  giáº£i thÃ­ch rÃµ vá» TrÃ ng An.', NOW() - INTERVAL 2 DAY);

UPDATE tour_thuc_tes
SET trang_thai = 'HUY'
WHERE ma_tour_thuc_te = 'TTT_HUY';

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HUY_REFUND_WAIT', 'DDT_HUY', 'HOAN_TIEN', 'HE_THONG', 14220000, 'BANK-009', 'CHO_THANH_TOAN', NULL);

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 24 DAY,
    trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te = 'TTT_QT';

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_QT_KH02', 'KH_02', 'TTT_QT', 'CTDT_QT_KH', DATE(NOW()) - INTERVAL 24 DAY);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_QT_HOTEL', 'TTT_QT', 'NV_HDV01', 'KhÃ¡ch sáº¡n Huáº¿ 2 Ä‘Ãªm', 4800000, 'https://seed.local/hoa-don/hue-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 20 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_QT_BUS', 'TTT_QT', 'NV_HDV01', 'Xe du lá»‹ch Huáº¿', 2600000, 'https://seed.local/hoa-don/hue-bus.jpg', 'DA_DUYET', NOW() - INTERVAL 20 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_QT_TICKET', 'TTT_QT', 'NV_HDV01', 'VÃ© tham quan Äáº¡i Ná»™i', 900000, 'https://seed.local/hoa-don/hue-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_HUE_DONE', 'TTT_QT', 0, 0, 11000000, 0, 'NV_KT01', NOW() - INTERVAL 18 DAY, 'DA_QUYET_TOAN',
        'Trigger tÃ­nh láº¡i tong_doanh_thu, tong_chi_phi, loi_nhuan vÃ  chá»‘t tour DA_QUYET_TOAN.');

-- ------------------------------------------------------------
-- 6B. 5 BO DATA BO SUNG DE MINH HOA TOAN DIEN HON
-- ------------------------------------------------------------
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HALONG', 'TM_HALONG', DATE(NOW()) + INTERVAL 130 DAY, 5900000, 26, 10, 26, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CANTHO', 'TM_CANTHO', DATE(NOW()) + INTERVAL 135 DAY, 3700000, 28, 12, 28, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CONDAO', 'TM_CONDAO', DATE(NOW()) + INTERVAL 145 DAY, 8600000, 18, 8, 18, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MOCCHAU', 'TM_MOCCHAU', DATE(NOW()) + INTERVAL 150 DAY, 2800000, 24, 10, 24, 'MO_BAN');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_QUYNHON', 'TM_QUYNHON', DATE(NOW()) + INTERVAL 160 DAY, 5500000, 22, 8, 22, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HALONG', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HALONG', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CANTHO', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CONDAO', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MOCCHAU', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_QUYNHON', 'DVT_AIRPORT');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HALONG', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CANTHO', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CONDAO', 'HDX_CLEANUP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MOCCHAU', 'HDX_TREE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_QUYNHON', 'HDX_BOTTLE');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_HALONG_HDV02', 'TTT_HALONG', 'NV_HDV02', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_CANTHO_HDV01', 'TTT_CANTHO', 'NV_HDV01', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_CONDAO_HDV02', 'TTT_CONDAO', 'NV_HDV02', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_MOCCHAU_HDV01', 'TTT_MOCCHAU', 'NV_HDV01', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_QUYNHON_HDV02', 'TTT_QUYNHON', 'NV_HDV02', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y');

-- Goi 1: Ha Long - tour dang mo ban, co don cho thanh toan va don da xac nhan.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HALONG_CHO', 'TTT_HALONG', 'KH_07', NOW() - INTERVAL 1 DAY, 11920000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'KhÃ¡ch Ä‘ang giá»¯ chá»— du thuyá»n Háº¡ Long.', 'HDX_EBILL:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HALONG_OK', 'TTT_HALONG', 'KH_08', NOW() - INTERVAL 2 DAY, 18600000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'NhÃ³m gia Ä‘Ã¬nh Ä‘Ã£ thanh toÃ¡n Ä‘á»§.', 'HDX_EBILL:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HALONG_TRE_EM', 'TTT_HALONG', 'KH_15', NOW() - INTERVAL 6 HOUR, 8970000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'ÄÆ¡n cÃ³ tráº» em dÆ°á»›i 10 tuá»•i Ä‘i kÃ¨m.', 'HDX_EBILL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_CHO_01', 'DDT_HALONG_CHO', 'HoÃ ng Minh Äá»©c', '079299000208', '0922000208', '1990-02-21', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_OK_01', 'DDT_HALONG_OK', 'VÅ© Thanh SÆ¡n', '079299000209', '0922000209', '1962-08-14', 'NAM', 'NgÆ°á»i cao tuá»•i');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_OK_02', 'DDT_HALONG_OK', 'VÅ© Minh Anh', '079299000210', '0922000210', '2012-12-01', 'NU', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_TRE_EM_01', 'DDT_HALONG_TRE_EM', 'Phan Minh Khang', '079299000220', '0922000220',
        DATE_ADD(DATE(NOW()), INTERVAL (-84) MONTH), 'NAM', 'Tráº» em duoi 10 tuoi');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_CHO_KH', 'DDT_HALONG_CHO', 'KH_07', NULL, 'NGUOI_DAT', 5900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_CHO_NDH1', 'DDT_HALONG_CHO', NULL, 'NDH_HALONG_CHO_01', 'NGUOI_DONG_HANH', 5900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_OK_KH', 'DDT_HALONG_OK', 'KH_08', NULL, 'NGUOI_DAT', 5900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_OK_NDH1', 'DDT_HALONG_OK', NULL, 'NDH_HALONG_OK_01', 'NGUOI_DONG_HANH', 5900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_OK_NDH2', 'DDT_HALONG_OK', NULL, 'NDH_HALONG_OK_02', 'NGUOI_DONG_HANH', 5900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_TRE_EM_KH', 'DDT_HALONG_TRE_EM', 'KH_15', NULL, 'NGUOI_DAT', 5900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_TRE_EM_NDH1', 'DDT_HALONG_TRE_EM', NULL, 'NDH_HALONG_TRE_EM_01', 'NGUOI_DONG_HANH', 2950000);

INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HALONG_CHO_INS', 'DDT_HALONG_CHO', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HALONG_OK_PHOTO', 'DDT_HALONG_OK', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HALONG_TRE_EM_INS', 'DDT_HALONG_TRE_EM', 'DVT_INSURANCE', 1, 120000, 120000);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HALONG_CHO', 'DDT_HALONG_CHO', 'THANH_TOAN', 'CHUYEN_KHOAN', 11920000, 'BANK-010', 'CHO_THANH_TOAN', NULL);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HALONG_OK', 'DDT_HALONG_OK', 'THANH_TOAN', 'THE_QUOC_TE', 18600000, 'BANK-011', 'THANH_CONG', NOW() - INTERVAL 1 DAY);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HALONG_TRE_EM_PAY', 'DDT_HALONG_TRE_EM', 'THANH_TOAN', 'CHUYEN_KHOAN', 8970000, 'BANK-025', 'THANH_CONG', NOW() - INTERVAL 5 HOUR);

-- Goi 2: Can Tho - mo ban, khach cong ty da thanh toan va co yeu cau hoa don.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_OK', 'TTT_CANTHO', 'KH_09', NOW() - INTERVAL 3 DAY, 7680000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'KhÃ¡ch cáº§n hÃ³a Ä‘Æ¡n cÃ´ng ty sau thanh toÃ¡n.', 'HDX_LOCAL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_01', 'DDT_CANTHO_OK', 'Äáº·ng Minh Tuá»‡', '079299000211', '0922000211', '1987-05-18', 'NAM', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KH', 'DDT_CANTHO_OK', 'KH_09', NULL, 'NGUOI_DAT', 3700000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_NDH1', 'DDT_CANTHO_OK', NULL, 'NDH_CANTHO_01', 'NGUOI_DONG_HANH', 3700000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CANTHO_DINNER', 'DDT_CANTHO_OK', 'DVT_DINNER', 1, 280000, 280000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_OK', 'DDT_CANTHO_OK', 'THANH_TOAN', 'CHUYEN_KHOAN', 7680000, 'BANK-012', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

UPDATE tour_thuc_tes
SET trang_thai = 'MO_BAN'
WHERE ma_tour_thuc_te = 'TTT_CANTHO';

-- Goi 3: Con Dao - dang dien ra, co diem danh, hanh dong xanh va su co phuong tien.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CONDAO_OK', 'TTT_CONDAO', 'KH_10', NOW() - INTERVAL 5 DAY, 17320000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'KhÃ¡ch Ä‘i biá»ƒn Ä‘áº£o, cÃ³ dá»‹ á»©ng háº£i sáº£n cÃ³ vá».', 'HDX_CLEANUP:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CONDAO_01', 'DDT_CONDAO_OK', 'Mai Báº£o Nam', '079299000212', '0922000212', '1993-11-23', 'NAM', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CONDAO_KH', 'DDT_CONDAO_OK', 'KH_10', NULL, 'NGUOI_DAT', 8600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CONDAO_NDH1', 'DDT_CONDAO_OK', NULL, 'NDH_CONDAO_01', 'NGUOI_DONG_HANH', 8600000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CONDAO_INS', 'DDT_CONDAO_OK', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CONDAO_OK', 'DDT_CONDAO_OK', 'THANH_TOAN', 'THE_NOI_DIA', 17320000, 'BANK-013', 'THANH_CONG', NOW() - INTERVAL 4 DAY);

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()),
    trang_thai = 'DANG_DIEN_RA'
WHERE ma_tour_thuc_te = 'TTT_CONDAO';

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_CONDAO_KH_OK', 'TTT_CONDAO', 'KH_10', NULL, 'NGUOI_DAT', 'NV_HDV02', NOW() - INTERVAL 3 HOUR, 'SÃ¢n bay CÃ´n Äáº£o', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_CONDAO_NDH_OK', 'TTT_CONDAO', NULL, 'NDH_CONDAO_01', 'NGUOI_DONG_HANH', 'NV_HDV02', NOW() - INTERVAL 3 HOUR, 'SÃ¢n bay CÃ´n Äáº£o', 'DA_DIEM_DANH');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_CONDAO_CLEANUP', 'TTT_CONDAO', 'KH_10', 'HDX_CLEANUP', 'NV_HDV02', NOW() - INTERVAL 1 HOUR,
        'áº¢nh nhÃ³m khÃ¡ch thu gom rÃ¡c trÃªn bÃ£i biá»ƒn');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_CONDAO_TRANSPORT', 'TTT_CONDAO', 'NV_HDV02', 'Xe Ä‘Æ°a Ä‘Ã³n cháº­m 20 phÃºt do thá»i tiáº¿t.',
        'ThÃ´ng bÃ¡o khÃ¡ch, Ä‘iá»u xe dá»± phÃ²ng vÃ  Ä‘á»•i lá»‹ch tham quan nháº¹.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 40 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CONDAO_WATER', 'TTT_CONDAO', 'NV_HDV02', 'NÆ°á»›c uá»‘ng bá»• sung táº¡i báº¿n tÃ u', 240000, 'https://seed.local/hoa-don/condao-water.jpg', 'CHO_DUYET', NOW() - INTERVAL 35 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CONDAO_TRANSFER', 'TTT_CONDAO', 'NV_HDV02', 'Xe trung chuyá»ƒn dá»± phÃ²ng', 750000, 'https://seed.local/hoa-don/condao-transfer.jpg', 'DA_DUYET', NOW() - INTERVAL 25 MINUTE);

-- Goi 4: Moc Chau - da ket thuc, co lich su va danh gia tu khach hang.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_MOCCHAU_OK', 'TTT_MOCCHAU', 'KH_11', NOW() - INTERVAL 20 DAY, 6500000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'KhÃ¡ch cáº§n lá»‹ch trÃ¬nh Ã­t leo dá»‘c.', 'HDX_TREE:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_MOCCHAU_01', 'DDT_MOCCHAU_OK', 'Cao Báº£o Ngá»c', '079299000213', '0922000213', '1986-02-09', 'NU', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MOCCHAU_KH', 'DDT_MOCCHAU_OK', 'KH_11', NULL, 'NGUOI_DAT', 2800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MOCCHAU_NDH1', 'DDT_MOCCHAU_OK', NULL, 'NDH_MOCCHAU_01', 'NGUOI_DONG_HANH', 2800000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_MOCCHAU_PHOTO', 'DDT_MOCCHAU_OK', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_MOCCHAU_OK', 'DDT_MOCCHAU_OK', 'THANH_TOAN', 'CHUYEN_KHOAN', 6500000, 'BANK-014', 'THANH_CONG', NOW() - INTERVAL 19 DAY);

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 12 DAY,
    trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te = 'TTT_MOCCHAU';

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_MOCCHAU_KH11', 'KH_11', 'TTT_MOCCHAU', 'CTDT_MOCCHAU_KH', DATE(NOW()) - INTERVAL 12 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_MOCCHAU_TRAIL', 'TTT_MOCCHAU', 'NV_HDV01', 'ÄÆ°á»ng vÃ o Ä‘á»“i chÃ¨ áº©m Æ°á»›t sau mÆ°a.',
        'Chuyá»ƒn sang lá»‘i Ä‘i phá»¥, nháº¯c khÃ¡ch mang giÃ y chá»‘ng trÆ¡n.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 11 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_MOCCHAU_RAINCOAT', 'TTT_MOCCHAU', 'NV_HDV01', 'Ão mÆ°a má»ng cho khÃ¡ch', 180000, 'https://seed.local/hoa-don/mocchau-raincoat.jpg', 'DA_DUYET', NOW() - INTERVAL 11 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_MOCCHAU_LOCAL', 'TTT_MOCCHAU', 'NV_HDV01', 'PhÃ­ xe Ä‘iá»‡n vÃ o nÃ´ng tráº¡i', 300000, 'https://seed.local/hoa-don/mocchau-ev.jpg', 'CHO_DUYET', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_MOCCHAU_KH11', 'TTT_MOCCHAU', 'KH_11', 4, 'Cáº£nh Ä‘áº¹p, lá»‹ch trÃ¬nh há»£p lÃ½ cho ngÆ°á»i khÃ´ng muá»‘n Ä‘i bá»™ quÃ¡ nhiá»u.', NOW() - INTERVAL 5 DAY);

-- Goi 5: Quy Nhon - tour bi huy, don da thanh toan se sinh ho tro hoan tien.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_QUYNHON_HUY', 'TTT_QUYNHON', 'KH_07', NOW() - INTERVAL 6 DAY, 11350000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Tour dá»± kiáº¿n há»§y do Ä‘iá»u kiá»‡n thá»i tiáº¿t biá»ƒn.', 'HDX_BOTTLE:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_QUYNHON_01', 'DDT_QUYNHON_HUY', 'HoÃ ng Báº£o TrÃ¢m', '079299000214', '0922000214', '1992-04-04', 'NU', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_QUYNHON_KH', 'DDT_QUYNHON_HUY', 'KH_07', NULL, 'NGUOI_DAT', 5500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_QUYNHON_NDH1', 'DDT_QUYNHON_HUY', NULL, 'NDH_QUYNHON_01', 'NGUOI_DONG_HANH', 5500000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_QUYNHON_AIRPORT', 'DDT_QUYNHON_HUY', 'DVT_AIRPORT', 1, 350000, 350000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_QUYNHON_PAY', 'DDT_QUYNHON_HUY', 'THANH_TOAN', 'CHUYEN_KHOAN', 11350000, 'BANK-015', 'THANH_CONG', NOW() - INTERVAL 5 DAY);

UPDATE tour_thuc_tes
SET trang_thai = 'HUY'
WHERE ma_tour_thuc_te = 'TTT_QUYNHON';

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_QUYNHON_REFUND', 'DDT_QUYNHON_HUY', 'HOAN_TIEN', 'HE_THONG', 10215000, 'BANK-016', 'CHO_THANH_TOAN', NULL);

-- Goi 6: Hoi An - mo ban, nhom gia dinh giu cho va chua thanh toan.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HOIAN', 'TM_HOIAN', DATE(NOW()) + INTERVAL 172 DAY, 4600000, 24, 8, 24, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HOIAN', 'DVT_DINNER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HOIAN', 'HDX_LOCAL');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_HOIAN_HDV01', 'TTT_HOIAN', 'NV_HDV01', NOW() - INTERVAL 1 DAY, 'DA_DONG_Y');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HOIAN_CHO', 'TTT_HOIAN', 'KH_12', NOW() - INTERVAL 8 HOUR, 14640000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Gia Ä‘Ã¬nh Ä‘ang giá»¯ chá»— tour Há»™i An.', 'HDX_LOCAL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HOIAN_01', 'DDT_HOIAN_CHO', 'Trá»‹nh Báº£o KhÃ¡nh', '079299000215', '0922000215', '1991-10-10', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HOIAN_02', 'DDT_HOIAN_CHO', 'Trá»‹nh Minh An', '079299000216', '0922000216', '2017-05-12', 'NU', 'Tráº» em');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HOIAN_KH', 'DDT_HOIAN_CHO', 'KH_12', NULL, 'NGUOI_DAT', 4600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HOIAN_NDH1', 'DDT_HOIAN_CHO', NULL, 'NDH_HOIAN_01', 'NGUOI_DONG_HANH', 4600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HOIAN_NDH2', 'DDT_HOIAN_CHO', NULL, 'NDH_HOIAN_02', 'NGUOI_DONG_HANH', 4600000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HOIAN_DINNER', 'DDT_HOIAN_CHO', 'DVT_DINNER', 3, 280000, 840000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HOIAN_CHO', 'DDT_HOIAN_CHO', 'THANH_TOAN', 'CHUYEN_KHOAN', 14640000, 'BANK-017', 'CHO_THANH_TOAN', NULL);

-- Don dat tour co su dung voucher FAMILY-700.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HOIAN_VOUCHER', 'TTT_HOIAN', 'KH_16', NOW() - INTERVAL 4 HOUR, 9060000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Ãp dá»¥ng voucher VC_FAMILY700: tiá»n tour 9.200.000, dá»‹ch vá»¥ 560.000, giáº£m 700.000, tá»•ng sau giáº£m 9.060.000.', 'HDX_LOCAL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HOIAN_VOUCHER_01', 'DDT_HOIAN_VOUCHER', 'Trá»‹nh HoÃ ng PhÃºc', '079299000219', '0922000219', '1995-01-24', 'NAM', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HOIAN_VOUCHER_KH', 'DDT_HOIAN_VOUCHER', 'KH_16', NULL, 'NGUOI_DAT', 4600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HOIAN_VOUCHER_NDH1', 'DDT_HOIAN_VOUCHER', NULL, 'NDH_HOIAN_VOUCHER_01', 'NGUOI_DONG_HANH', 4600000);

INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HOIAN_VOUCHER_DINNER', 'DDT_HOIAN_VOUCHER', 'DVT_DINNER', 2, 280000, 560000);

INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai)
VALUES ('DDT_HOIAN_VOUCHER', 'VC_FAMILY700', 700000);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HOIAN_VOUCHER_PAY', 'DDT_HOIAN_VOUCHER', 'THANH_TOAN', 'CHUYEN_KHOAN', 9060000, 'BANK-024', 'THANH_CONG', NOW() - INTERVAL 3 HOUR);

-- Goi 7: Buon Ma Thuot - mo ban, thanh vien vang da dung voucher phan tram.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BUONMATHUOT', 'TM_BUONMATHUOT', DATE(NOW()) + INTERVAL 180 DAY, 4100000, 20, 8, 20, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BUONMATHUOT', 'DVT_INSURANCE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BUONMATHUOT', 'HDX_EBILL');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_BUONMATHUOT_HDV02', 'TTT_BUONMATHUOT', 'NV_HDV02', NOW() - INTERVAL 1 DAY, 'DA_DONG_Y');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_BUONMATHUOT_OK', 'TTT_BUONMATHUOT', 'KH_13', NOW() - INTERVAL 2 DAY, 7174000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Ãp dá»¥ng voucher VC_MEMBER15: táº¡m tÃ­nh 8.440.000, giáº£m 1.266.000, tá»•ng sau giáº£m 7.174.000. KhÃ¡ch háº¡ng vÃ ng sá»­ dá»¥ng Æ°u Ä‘Ã£i thÃ nh viÃªn.', 'HDX_EBILL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_BUONMATHUOT_01', 'DDT_BUONMATHUOT_OK', 'Nguyá»…n HoÃ i Nam', '079299000217', '0922000217', '1984-06-17', 'NAM', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_BUONMATHUOT_KH', 'DDT_BUONMATHUOT_OK', 'KH_13', NULL, 'NGUOI_DAT', 4100000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_BUONMATHUOT_NDH1', 'DDT_BUONMATHUOT_OK', NULL, 'NDH_BUONMATHUOT_01', 'NGUOI_DONG_HANH', 4100000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_BUONMATHUOT_INS', 'DDT_BUONMATHUOT_OK', 'DVT_INSURANCE', 2, 120000, 240000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai)
VALUES ('DDT_BUONMATHUOT_OK', 'VC_MEMBER15', 1266000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_BUONMATHUOT_OK', 'DDT_BUONMATHUOT_OK', 'THANH_TOAN', 'THE_QUOC_TE', 7174000, 'BANK-018', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

UPDATE tour_thuc_tes
SET trang_thai = 'MO_BAN'
WHERE ma_tour_thuc_te = 'TTT_BUONMATHUOT';

-- Goi 8: Pu Luong - da ket thuc, voucher so tien va danh gia sau tour.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_PULUONG', 'TM_PULUONG', DATE(NOW()) + INTERVAL 185 DAY, 3300000, 18, 6, 18, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PULUONG', 'DVT_PHOTO');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PULUONG', 'HDX_TREE');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_PULUONG_HDV02', 'TTT_PULUONG', 'NV_HDV02', NOW() - INTERVAL 1 DAY, 'DA_DONG_Y');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_PULUONG_OK', 'TTT_PULUONG', 'KH_14', NOW() - INTERVAL 28 DAY, 6800000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Ãp dá»¥ng voucher VC_FAMILY700: táº¡m tÃ­nh 7.500.000, giáº£m 700.000, tá»•ng sau giáº£m 6.800.000. Gia Ä‘Ã¬nh Ä‘Ã£ Ä‘i tour PÃ¹ LuÃ´ng.', 'HDX_TREE:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_PULUONG_01', 'DDT_PULUONG_OK', 'LÃ¢m Gia HÃ¢n', '079299000218', '0922000218', '2019-03-15', 'NU', 'Tráº» em duoi 6 tuoi');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_PULUONG_KH', 'DDT_PULUONG_OK', 'KH_14', NULL, 'NGUOI_DAT', 3300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_PULUONG_NDH1', 'DDT_PULUONG_OK', NULL, 'NDH_PULUONG_01', 'NGUOI_DONG_HANH', 3300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_PULUONG_PHOTO', 'DDT_PULUONG_OK', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai)
VALUES ('DDT_PULUONG_OK', 'VC_FAMILY700', 700000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_PULUONG_OK', 'DDT_PULUONG_OK', 'THANH_TOAN', 'CHUYEN_KHOAN', 6800000, 'BANK-019', 'THANH_CONG', NOW() - INTERVAL 27 DAY);

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 18 DAY,
    trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te = 'TTT_PULUONG';

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_PULUONG_KH14', 'KH_14', 'TTT_PULUONG', 'CTDT_PULUONG_KH', DATE(NOW()) - INTERVAL 18 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_PULUONG_CHILD', 'TTT_PULUONG', 'NV_HDV02', 'Tráº» nhá» má»‡t sau cháº·ng Ä‘i bá»™ Báº£n ÄÃ´n.',
        'RÃºt ngáº¯n cung Ä‘i bá»™ vÃ  bá»‘ trÃ­ xe Ä‘iá»‡n vá» homestay.', 'THAP', 'Y_TE', NOW() - INTERVAL 17 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_PULUONG_EV', 'TTT_PULUONG', 'NV_HDV02', 'Xe Ä‘iá»‡n há»— trá»£ gia Ä‘Ã¬nh cÃ³ tráº» nhá»', 360000, 'https://seed.local/hoa-don/puluong-ev.jpg', 'DA_DUYET', NOW() - INTERVAL 17 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_PULUONG_SNACK', 'TTT_PULUONG', 'NV_HDV02', 'Äá»“ Äƒn nháº¹ cho tráº» em', 150000, 'https://seed.local/hoa-don/puluong-snack.jpg', 'DA_DUYET', NOW() - INTERVAL 17 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_PULUONG_KH14', 'TTT_PULUONG', 'KH_14', 5, 'Homestay sáº¡ch, HDV chu Ä‘Ã¡o vÃ  lá»‹ch trÃ¬nh phÃ¹ há»£p gia Ä‘Ã¬nh cÃ³ tráº» nhá».', NOW() - INTERVAL 8 DAY);

-- Goi 9: Mui Ne - mo ban, mot thanh toan that bai can kinh doanh ho tro lai.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MUINE', 'TM_MUINE', DATE(NOW()) + INTERVAL 190 DAY, 4900000, 26, 10, 26, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MUINE', 'DVT_AIRPORT');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MUINE', 'HDX_BOTTLE');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_MUINE_HDV01', 'TTT_MUINE', 'NV_HDV01', NOW() - INTERVAL 1 DAY, 'DA_DONG_Y');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_MUINE_FAIL', 'TTT_MUINE', 'KH_15', NOW() - INTERVAL 6 HOUR, 5250000, 'THANH_TOAN_THAT_BAI',
        NOW() + INTERVAL 1 DAY, 'Thanh toÃ¡n khÃ´ng thÃ nh cÃ´ng, cáº§n liÃªn há»‡ láº¡i khÃ¡ch.', 'HDX_BOTTLE:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_MUINE_DIEMXANH', 'TTT_MUINE', 'KH_05', NOW() - INTERVAL 4 HOUR, 4450000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Sá»­ dá»¥ng 800 Ä‘iá»ƒm xanh lÃºc Ä‘áº·t tour qua voucher VC_DIEMXANH800: tiá»n tour 4.900.000, dá»‹ch vá»¥ 350.000, giáº£m 800.000, tá»•ng sau giáº£m 4.450.000.', 'HDX_BOTTLE:1');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MUINE_KH', 'DDT_MUINE_FAIL', 'KH_15', NULL, 'NGUOI_DAT', 4900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MUINE_DIEMXANH_KH', 'DDT_MUINE_DIEMXANH', 'KH_05', NULL, 'NGUOI_DAT', 4900000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_MUINE_AIRPORT', 'DDT_MUINE_FAIL', 'DVT_AIRPORT', 1, 350000, 350000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_MUINE_DIEMXANH_AIRPORT', 'DDT_MUINE_DIEMXANH', 'DVT_AIRPORT', 1, 350000, 350000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai)
VALUES ('DDT_MUINE_DIEMXANH', 'VC_DIEMXANH800', 800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_MUINE_FAIL', 'DDT_MUINE_FAIL', 'THANH_TOAN', 'THE_NOI_DIA', 5250000, 'BANK-020', 'THAT_BAI', NOW() - INTERVAL 5 HOUR);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_MUINE_DIEMXANH_PAY', 'DDT_MUINE_DIEMXANH', 'THANH_TOAN', 'VI_DIEN_TU', 4450000, 'BANK-026', 'THANH_CONG', NOW() - INTERVAL 3 HOUR);

-- Cac don van CHO_XAC_NHAN du da co giao dich THANH_CONG mot phan.
-- Trigger chi chuyen DA_XAC_NHAN khi tong thanh toan thanh cong >= tong_tien.
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CHO_XN_COC', 'DDT_CHO_XN', 'THANH_TOAN', 'CHUYEN_KHOAN', 2000000, 'BANK-021', 'THANH_CONG', NOW() - INTERVAL 2 HOUR);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HALONG_COC', 'DDT_HALONG_CHO', 'THANH_TOAN', 'THE_NOI_DIA', 3000000, 'BANK-022', 'THANH_CONG', NOW() - INTERVAL 3 HOUR);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HOIAN_COC', 'DDT_HOIAN_CHO', 'THANH_TOAN', 'VI_DIEN_TU', 4500000, 'BANK-023', 'THANH_CONG', NOW() - INTERVAL 4 HOUR);

-- Cap nhat tour Da Nang sang MO_BAN sau khi da seed cac don dat phu hop.
UPDATE tour_thuc_tes
SET trang_thai = 'MO_BAN'
WHERE ma_tour_thuc_te = 'TTT_SDR';

-- Recalculate cho_con_lai sau cac thay doi trang thai don/tour do trigger chi lang nghe chi_tiet_dat_tours.
UPDATE chi_tiet_dat_tours
SET ma_dat_tour = ma_dat_tour
WHERE ma_chi_tiet_dat LIKE 'CTDT_%';

-- ------------------------------------------------------------
-- 7. HO TRO, DOI DIEM, NHAT KY DIEU HANH
-- ------------------------------------------------------------
INSERT INTO nhat_ky_doi_diems (ma_nhat_ky_doi_diem, ma_khach_hang, ma_voucher, diem_quy_doi, ngay_quy_doi)
VALUES ('NKDD_KH05_GREEN', 'KH_05', 'VC_GREEN500', 500, NOW() - INTERVAL 9 DAY);
INSERT INTO nhat_ky_doi_diems (ma_nhat_ky_doi_diem, ma_khach_hang, ma_voucher, diem_quy_doi, ngay_quy_doi)
VALUES ('NKDD_KH05_BOOKING', 'KH_05', 'VC_DIEMXANH800', 800, NOW() - INTERVAL 4 HOUR);

INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_CHO_BS', 'DDT_CHO_HUY', 'KH_04', 'HUY_TOUR', 'KhÃ¡ch cáº§n bá»• sung lÃ½ do há»§y vÃ  xÃ¡c nháº­n phÃ­ há»§y.', 'CHO_BO_SUNG', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_CHO_GT', 'DDT_TT_FAIL', 'KH_06', 'THANH_TOAN', 'Cáº§n giáº£i trÃ¬nh káº¿t quáº£ Ä‘á»‘i soÃ¡t vá»›i ngÃ¢n hÃ ng.', 'CHO_GIAI_TRINH', 'NV_SALES01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_DA_XL', 'DDT_DA_XN', 'KH_02', 'DOI_DICH_VU', 'ÄÃ£ xÃ¡c nháº­n dá»‹ch vá»¥ Ä‘Æ°a Ä‘Ã³n sÃ¢n bay riÃªng.', 'DA_XU_LY', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TU_CHOI', 'DDT_TU_CHOI_HT', 'KH_05', 'HOAN_TIEN', 'Tá»« chá»‘i hoÃ n tiá»n do khÃ´ng Ä‘áº¡t Ä‘iá»u kiá»‡n chÃ­nh sÃ¡ch.', 'TU_CHOI', 'NV_KT01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_CANTHO_INVOICE', 'DDT_CANTHO_OK', 'KH_09', 'HOA_DON', 'KhÃ¡ch yÃªu cáº§u xuáº¥t hÃ³a Ä‘Æ¡n cÃ´ng ty cho tour Cáº§n ThÆ¡.', 'CHUA_XU_LY', 'NV_KT01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_HALONG_SERVICE', 'DDT_HALONG_OK', 'KH_08', 'DICH_VU_THEM', 'XÃ¡c nháº­n láº¡i gÃ³i chá»¥p áº£nh hÃ nh trÃ¬nh trÃªn du thuyá»n.', 'DA_XU_LY', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_HOIAN_MEAL', 'DDT_HOIAN_CHO', 'KH_12', 'AN_UONG', 'KhÃ¡ch cáº§n xÃ¡c nháº­n thá»±c Ä‘Æ¡n chay cho cáº£ gia Ä‘Ã¬nh.', 'CHO_BO_SUNG', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_MUINE_PAYMENT', 'DDT_MUINE_FAIL', 'KH_15', 'THANH_TOAN', 'Thanh toÃ¡n tháº» ná»™i Ä‘á»‹a tháº¥t báº¡i, cáº§n kinh doanh liÃªn há»‡ hÆ°á»›ng dáº«n láº¡i.', 'CHUA_XU_LY', 'NV_SALES01');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_CKH_DH', 'TK_MGR01', 'THEM', 'TOURTHUCTE_DIEU_HANH', 'TTT_CKH', NOW() - INTERVAL 10 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_MB_DH', 'TK_MGR01', 'THEM', 'TOURTHUCTE_DIEU_HANH', 'TTT_MB', NOW() - INTERVAL 8 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_SDR_DH', 'TK_MGR01', 'CAP_NHAT', 'TOURTHUCTE_DIEU_HANH', 'TTT_SDR', NOW() - INTERVAL 7 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_DDR_DH', 'TK_MGR01', 'CAP_NHAT', 'TOURTHUCTE_DIEU_HANH', 'TTT_DDR', NOW() - INTERVAL 6 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_KT_DH', 'TK_MGR01', 'CAP_NHAT', 'TOURTHUCTE_DIEU_HANH', 'TTT_KT', NOW() - INTERVAL 5 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_HUY_DH', 'TK_MGR01', 'CAP_NHAT', 'TOURTHUCTE_DIEU_HANH', 'TTT_HUY', NOW() - INTERVAL 4 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_QT_DH', 'TK_MGR01', 'CAP_NHAT', 'TOURTHUCTE_DIEU_HANH', 'TTT_QT', NOW() - INTERVAL 3 DAY);

-- Nhat ky cua nhan vien Sales khi tao / cap nhat Don Dat Tour
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_DDT_MB_THEM', 'TK_SALES01', 'THEM', 'DONDATTOUR_SALES', 'DDT_CHO_XN', NOW() - INTERVAL 1 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_DDT_MB_CN', 'TK_SALES01', 'CAP_NHAT', 'DONDATTOUR_SALES', 'DDT_DA_XN', NOW() - INTERVAL 2 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_DDT_SDR_HUY', 'TK_SALES01', 'CAP_NHAT', 'DONDATTOUR_SALES', 'DDT_CHO_HUY', NOW() - INTERVAL 4 DAY);

-- Nhat ky cua HDV khi tao Chi Phi Thuc Te trong luc di tour
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_CP_DDR_THEM1', 'TK_HDV01', 'THEM', 'CHIPHITHUCTE_HDV', 'CP_DDR_APPROVED', NOW() - INTERVAL 1 HOUR);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_CP_DDR_THEM2', 'TK_HDV01', 'THEM', 'CHIPHITHUCTE_HDV', 'CP_DDR_PENDING', NOW() - INTERVAL 30 MINUTE);

-- Nhat ky cua Ke Toan khi duyet Chi Phi va lam Quyet Toan cho tour Da Quyet Toan
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_CP_QT_DUYET1', 'TK_KT01', 'CAP_NHAT', 'CHIPHITHUCTE_KETOAN', 'CP_QT_HOTEL', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_CP_QT_DUYET2', 'TK_KT01', 'CAP_NHAT', 'CHIPHITHUCTE_KETOAN', 'CP_QT_BUS', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_QT_HUE_THEM', 'TK_KT01', 'THEM', 'QUYETTOAN_KETOAN', 'QT_HUE_DONE', NOW() - INTERVAL 18 DAY);
-- Cap nhat lai trang_thai cho tour_thuc_tes sau khi da them don_dat_tours (de thoa man trigger MO_BAN)
UPDATE tour_thuc_tes SET trang_thai = 'MO_BAN' WHERE ma_tour_thuc_te = 'TTT_SDR';
UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA' WHERE ma_tour_thuc_te = 'TTT_DDR';
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_KT';
UPDATE tour_thuc_tes SET trang_thai = 'HUY' WHERE ma_tour_thuc_te = 'TTT_HUY';
UPDATE tour_thuc_tes SET trang_thai = 'DA_QUYET_TOAN' WHERE ma_tour_thuc_te = 'TTT_QT';

-- Bo qua insert lich_su_tours vi da duoc insert o tren.
-- Tam thoi bypass ham kiem tra de insert du lieu mau;

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_NB_01', 'TTT_KT', 'KH_04', 5, 'Cáº£nh ráº¥t Ä‘áº¹p vÃ  HDV nhiá»‡t tÃ¬nh.', NOW() - INTERVAL 2 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HUE_01', 'TTT_QT', 'KH_02', 4, 'Äá»“ Äƒn ngon nhÆ°ng thá»i tiáº¿t hÆ¡i sÆ°Æ¡ng mÃ¹.', NOW() - INTERVAL 5 DAY);


-- BO SUNG: KHACH HANG DAT TOUR DANG MO BAN (KEM THANH TOAN)

-- Dat tour cho Hoi An
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han)
VALUES ('DDT_HA_NEW', 'TTT_HOIAN', 'KH_09', NOW() - INTERVAL 2 DAY, 11960000, 'DA_XAC_NHAN', NOW());

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HA_NEW_01', 'DDT_HA_NEW', 'Nguyá»…n VÄƒn BÃ¬nh', '079299000301', '0922000301', '1995-05-15', 'NAM', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HA_NEW_KH', 'DDT_HA_NEW', 'KH_09', NULL, 'NGUOI_DAT', 5980000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HA_NEW_NDH', 'DDT_HA_NEW', NULL, 'NDH_HA_NEW_01', 'NGUOI_DONG_HANH', 5980000);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HA_NEW', 'DDT_HA_NEW', 'THANH_TOAN', 'THE_TIN_DUNG', 11960000, 'BANK-HA-NEW', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

-- Dat tour cho Mui Ne
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han)
VALUES ('DDT_MN_NEW', 'TTT_MUINE', 'KH_10', NOW() - INTERVAL 1 DAY, 5910000, 'DA_XAC_NHAN', NOW());
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MN_NEW_KH', 'DDT_MN_NEW', 'KH_10', NULL, 'NGUOI_DAT', 5910000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_MN_NEW', 'DDT_MN_NEW', 'THANH_TOAN', 'VNPAY', 5910000, 'BANK-MN-NEW', 'THANH_CONG', NOW() - INTERVAL 12 HOUR);


-- BO SUNG: DATA TOUR QUA KHU DE CO DANH GIA CHO HOI AN, MUI NE, HA LONG

-- 1. Tour thuc te trong qua khu (ban dau set MO_BAN de vuot trigger)
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HOIAN_OLD', 'TM_HOIAN', DATE(NOW()) - INTERVAL 20 DAY, 5980000, 24, 10, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MUINE_OLD', 'TM_MUINE', DATE(NOW()) - INTERVAL 20 DAY, 5910000, 26, 10, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HALONG_OLD', 'TM_HALONG', DATE(NOW()) - INTERVAL 20 DAY, 6790000, 26, 10, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_SAPA_OLD', 'TM_SAPA', DATE(NOW()) - INTERVAL 35 DAY, 4800000, 24, 8, 24, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HOIAN_OLD', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MUINE_OLD', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HALONG_OLD', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_OLD', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_OLD', 'DVT_SINGLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HOIAN_OLD', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MUINE_OLD', 'HDX_BOTTLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HALONG_OLD', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_SAPA_OLD', 'HDX_CLEANUP');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_HOIAN_OLD_HDV04', 'TTT_HOIAN_OLD', 'NV_HDV04', NOW() - INTERVAL 35 DAY, 'DA_DONG_Y', NOW() - INTERVAL 34 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_MUINE_OLD_HDV05', 'TTT_MUINE_OLD', 'NV_HDV05', NOW() - INTERVAL 35 DAY, 'DA_DONG_Y', NOW() - INTERVAL 34 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_HALONG_OLD_HDV06', 'TTT_HALONG_OLD', 'NV_HDV06', NOW() - INTERVAL 35 DAY, 'DA_DONG_Y', NOW() - INTERVAL 34 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_SAPA_OLD_HDV03', 'TTT_SAPA_OLD', 'NV_HDV03', NOW() - INTERVAL 55 DAY, 'DA_DONG_Y', NOW() - INTERVAL 54 DAY);

-- 2. Don dat tour trong qua khu
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han)
VALUES ('DDT_HA_OLD', 'TTT_HOIAN_OLD', 'KH_06', NOW() - INTERVAL 30 DAY, 5980000, 'DA_XAC_NHAN', NOW());
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HA_OLD', 'DDT_HA_OLD', 'KH_06', NULL, 'NGUOI_DAT', 5980000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HA_OLD', 'DDT_HA_OLD', 'THANH_TOAN', 'CHUYEN_KHOAN', 5980000, 'BANK-HA', 'THANH_CONG', NOW() - INTERVAL 29 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han)
VALUES ('DDT_MN_OLD', 'TTT_MUINE_OLD', 'KH_07', NOW() - INTERVAL 30 DAY, 5910000, 'DA_XAC_NHAN', NOW());
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MN_OLD', 'DDT_MN_OLD', 'KH_07', NULL, 'NGUOI_DAT', 5910000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_MN_OLD', 'DDT_MN_OLD', 'THANH_TOAN', 'CHUYEN_KHOAN', 5910000, 'BANK-MN', 'THANH_CONG', NOW() - INTERVAL 29 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han)
VALUES ('DDT_HL_OLD', 'TTT_HALONG_OLD', 'KH_08', NOW() - INTERVAL 30 DAY, 6790000, 'DA_XAC_NHAN', NOW());
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HL_OLD', 'DDT_HL_OLD', 'KH_08', NULL, 'NGUOI_DAT', 6790000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HL_OLD', 'DDT_HL_OLD', 'THANH_TOAN', 'CHUYEN_KHOAN', 6790000, 'BANK-HL', 'THANH_CONG', NOW() - INTERVAL 29 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_01', 'TTT_SAPA_OLD', 'KH_01', NOW() - INTERVAL 50 DAY, 4800000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 48 DAY, 'KhÃ¡ch láº» Ä‘Ã£ thanh toÃ¡n Ä‘á»§ tour Sa Pa quÃ¡ khá»©.', 'HDX_CLEANUP:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_02', 'TTT_SAPA_OLD', 'KH_02', NOW() - INTERVAL 50 DAY, 9600000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 48 DAY, 'Cáº·p Ä‘Ã´i Ä‘Ã£ thanh toÃ¡n Ä‘á»§ tour Sa Pa.', 'HDX_CLEANUP:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_03', 'TTT_SAPA_OLD', 'KH_03', NOW() - INTERVAL 49 DAY, 15240000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 47 DAY, 'NhÃ³m 3 khÃ¡ch cÃ³ thÃªm bá»¯a tá»‘i Ä‘áº·c sáº£n.', 'HDX_CLEANUP:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_04', 'TTT_SAPA_OLD', 'KH_04', NOW() - INTERVAL 49 DAY, 5450000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 47 DAY, 'KhÃ¡ch yÃªu cáº§u phá»¥ thu phÃ²ng Ä‘Æ¡n.', NULL);
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_05', 'TTT_SAPA_OLD', 'KH_05', NOW() - INTERVAL 48 DAY, 19200000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 46 DAY, 'Gia Ä‘Ã¬nh 4 ngÆ°á»i Ä‘Ã£ thanh toÃ¡n Ä‘á»§.', 'HDX_CLEANUP:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_02_01', 'DDT_SAPA_OLD_02', 'Pháº¡m Quang Hiáº¿u', '079299000401', '0922000401', '1994-09-09', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_03_01', 'DDT_SAPA_OLD_03', 'LÃª Báº£o Ngá»c', '079299000402', '0922000402', '1996-12-11', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_03_02', 'DDT_SAPA_OLD_03', 'LÃª Minh Quan', '079299000403', '0922000403', '1992-03-15', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_05_01', 'DDT_SAPA_OLD_05', 'Äá»— Thanh LÃ¢m', '079299000404', '0922000404', '1988-08-08', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_05_02', 'DDT_SAPA_OLD_05', 'Äá»— Minh KhÃ´i', '079299000405', '0922000405', '2012-05-20', 'NAM', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_05_03', 'DDT_SAPA_OLD_05', 'Äá»— Gia HÃ¢n', '079299000406', '0922000406', '2016-11-02', 'NU', 'Tráº» em');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_01_KH', 'DDT_SAPA_OLD_01', 'KH_01', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_02_KH', 'DDT_SAPA_OLD_02', 'KH_02', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_02_NDH1', 'DDT_SAPA_OLD_02', NULL, 'NDH_SAPA_OLD_02_01', 'NGUOI_DONG_HANH', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_03_KH', 'DDT_SAPA_OLD_03', 'KH_03', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_03_NDH1', 'DDT_SAPA_OLD_03', NULL, 'NDH_SAPA_OLD_03_01', 'NGUOI_DONG_HANH', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_03_NDH2', 'DDT_SAPA_OLD_03', NULL, 'NDH_SAPA_OLD_03_02', 'NGUOI_DONG_HANH', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_04_KH', 'DDT_SAPA_OLD_04', 'KH_04', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_05_KH', 'DDT_SAPA_OLD_05', 'KH_05', NULL, 'NGUOI_DAT', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_05_NDH1', 'DDT_SAPA_OLD_05', NULL, 'NDH_SAPA_OLD_05_01', 'NGUOI_DONG_HANH', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_05_NDH2', 'DDT_SAPA_OLD_05', NULL, 'NDH_SAPA_OLD_05_02', 'NGUOI_DONG_HANH', 4800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OLD_05_NDH3', 'DDT_SAPA_OLD_05', NULL, 'NDH_SAPA_OLD_05_03', 'NGUOI_DONG_HANH', 4800000);

INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_SAPA_OLD_03_DINNER', 'DDT_SAPA_OLD_03', 'DVT_DINNER', 3, 280000, 840000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_SAPA_OLD_04_SINGLE', 'DDT_SAPA_OLD_04', 'DVT_SINGLE', 1, 650000, 650000);

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_SAPA_OLD_01_PAY', 'DDT_SAPA_OLD_01', 'THANH_TOAN', 'CHUYEN_KHOAN', 4800000, 'BANK-SAPA-001', 'THANH_CONG', NOW() - INTERVAL 49 DAY);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_SAPA_OLD_02_PAY', 'DDT_SAPA_OLD_02', 'THANH_TOAN', 'THE_QUOC_TE', 9600000, 'BANK-SAPA-002', 'THANH_CONG', NOW() - INTERVAL 49 DAY);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_SAPA_OLD_03_PAY', 'DDT_SAPA_OLD_03', 'THANH_TOAN', 'VI_DIEN_TU', 15240000, 'BANK-SAPA-003', 'THANH_CONG', NOW() - INTERVAL 48 DAY);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_SAPA_OLD_04_PAY', 'DDT_SAPA_OLD_04', 'THANH_TOAN', 'CHUYEN_KHOAN', 5450000, 'BANK-SAPA-004', 'THANH_CONG', NOW() - INTERVAL 48 DAY);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_SAPA_OLD_05_PAY', 'DDT_SAPA_OLD_05', 'THANH_TOAN', 'THE_NOI_DIA', 19200000, 'BANK-SAPA-005', 'THANH_CONG', NOW() - INTERVAL 47 DAY);

-- 3. Chuyen trang thai tour sang KET_THUC de pass logic
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te IN ('TTT_HOIAN_OLD', 'TTT_MUINE_OLD', 'TTT_HALONG_OLD', 'TTT_SAPA_OLD');

-- 4. Them Lich Su Tour 
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HA_OLD', 'KH_06', 'TTT_HOIAN_OLD', 'CTDT_HA_OLD', DATE(NOW()) - INTERVAL 20 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_MN_OLD', 'KH_07', 'TTT_MUINE_OLD', 'CTDT_MN_OLD', DATE(NOW()) - INTERVAL 20 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HL_OLD', 'KH_08', 'TTT_HALONG_OLD', 'CTDT_HL_OLD', DATE(NOW()) - INTERVAL 20 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_SAPA_OLD_KH01', 'KH_01', 'TTT_SAPA_OLD', 'CTDT_SAPA_OLD_01_KH', DATE(NOW()) - INTERVAL 35 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_SAPA_OLD_KH02', 'KH_02', 'TTT_SAPA_OLD', 'CTDT_SAPA_OLD_02_KH', DATE(NOW()) - INTERVAL 35 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_SAPA_OLD_KH03', 'KH_03', 'TTT_SAPA_OLD', 'CTDT_SAPA_OLD_03_KH', DATE(NOW()) - INTERVAL 35 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_SAPA_OLD_KH04', 'KH_04', 'TTT_SAPA_OLD', 'CTDT_SAPA_OLD_04_KH', DATE(NOW()) - INTERVAL 35 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_SAPA_OLD_KH05', 'KH_05', 'TTT_SAPA_OLD', 'CTDT_SAPA_OLD_05_KH', DATE(NOW()) - INTERVAL 35 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_HOIAN_OLD_MEAL', 'TTT_HOIAN_OLD', 'NV_HDV04', 'Má»™t khÃ¡ch bÃ¡o mÃ³n chay Ä‘Æ°á»£c phá»¥c vá»¥ cháº­m.',
        'HDV lÃ m viá»‡c láº¡i vá»›i nhÃ  hÃ ng vÃ  Ä‘á»•i mÃ³n riÃªng cho khÃ¡ch.', 'THAP', 'AN_UONG', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_MUINE_OLD_WEATHER', 'TTT_MUINE_OLD', 'NV_HDV05', 'GiÃ³ máº¡nh táº¡i Ä‘á»“i cÃ¡t vÃ o buá»•i chiá»u.',
        'Äá»•i lá»‹ch chá»¥p áº£nh sÃ¡ng sá»›m ngÃ y tiáº¿p theo vÃ  cáº¥p nÆ°á»›c bá»• sung.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_HALONG_OLD_ROUTE', 'TTT_HALONG_OLD', 'NV_HDV06', 'Cáº£ng tÃ u Ä‘á»•i giá» lÃªn du thuyá»n 30 phÃºt.',
        'Cáº­p nháº­t thÃ´ng tin cho khÃ¡ch vÃ  sáº¯p xáº¿p khu chá» riÃªng.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_SAPA_OLD_FOG', 'TTT_SAPA_OLD', 'NV_HDV03', 'SÆ°Æ¡ng mÃ¹ dÃ y táº¡i Fansipan lÃ m giáº£m táº§m nhÃ¬n.',
        'Äá»•i khung giá» tham quan vÃ  bá»• sung Ä‘iá»ƒm check-in trong nhÃ .', 'THAP', 'THOI_TIET', NOW() - INTERVAL 34 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_SAPA_OLD_MEDICAL', 'TTT_SAPA_OLD', 'NV_HDV03', 'Má»™t khÃ¡ch bá»‹ Ä‘au chÃ¢n nháº¹ sau cháº·ng Ä‘i bá»™.',
        'Há»— trá»£ bÄƒng cá»‘ Ä‘á»‹nh, sáº¯p xáº¿p xe Ä‘iá»‡n vÃ  theo dÃµi sá»©c khá»e.', 'THAP', 'Y_TE', NOW() - INTERVAL 33 DAY);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HOIAN_OLD_WATER', 'TTT_HOIAN_OLD', 'NV_HDV04', 'NÆ°á»›c uá»‘ng bá»• sung', 210000, 'https://seed.local/hoa-don/hoian-water.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_MUINE_OLD_JEEP', 'TTT_MUINE_OLD', 'NV_HDV05', 'Xe jeep BÃ u Tráº¯ng phÃ¡t sinh', 650000, 'https://seed.local/hoa-don/muine-jeep.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HALONG_OLD_LOUNGE', 'TTT_HALONG_OLD', 'NV_HDV06', 'Khu chá» khÃ¡ch táº¡i cáº£ng', 480000, 'https://seed.local/hoa-don/halong-lounge.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_SAPA_OLD_MEDICAL', 'TTT_SAPA_OLD', 'NV_HDV03', 'Bá»™ y táº¿ vÃ  bÄƒng cá»‘ Ä‘á»‹nh', 260000, 'https://seed.local/hoa-don/sapa-medical.jpg', 'DA_DUYET', NOW() - INTERVAL 33 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_SAPA_OLD_EV', 'TTT_SAPA_OLD', 'NV_HDV03', 'Xe Ä‘iá»‡n há»— trá»£ khÃ¡ch', 420000, 'https://seed.local/hoa-don/sapa-ev.jpg', 'DA_DUYET', NOW() - INTERVAL 33 DAY);

-- 5. Them Danh Gia cho cac tour nay
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HA_01', 'TTT_HOIAN_OLD', 'KH_06', 5, 'Tráº£i nghiá»‡m ráº¥t tuyá»‡t vá»i, phá»‘ cá»• Ä‘áº¹p.', NOW() - INTERVAL 15 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_MN_01', 'TTT_MUINE_OLD', 'KH_07', 4, 'Äá»“i cÃ¡t ráº¥t rá»™ng vÃ  Ä‘áº¹p, tuy nhiÃªn trá»i hÆ¡i náº¯ng.', NOW() - INTERVAL 15 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HL_01', 'TTT_HALONG_OLD', 'KH_08', 5, 'Du thuyá»n Ä‘áº¹p, Ä‘á»“ Äƒn ngon, phá»¥c vá»¥ chu Ä‘Ã¡o.', NOW() - INTERVAL 15 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH01', 'TTT_SAPA_OLD', 'KH_01', 5, 'Fansipan nhiá»u sÆ°Æ¡ng nhÆ°ng HDV Ä‘á»•i lá»‹ch ráº¥t linh hoáº¡t.', NOW() - INTERVAL 30 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH02', 'TTT_SAPA_OLD', 'KH_02', 5, 'KhÃ¡ch sáº¡n sáº¡ch, bá»¯a Äƒn Ä‘á»‹a phÆ°Æ¡ng ngon vÃ  lá»‹ch trÃ¬nh vá»«a sá»©c.', NOW() - INTERVAL 30 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH03', 'TTT_SAPA_OLD', 'KH_03', 4, 'Cáº§n thÃªm thá»i gian tá»± do á»Ÿ chá»£ Ä‘Ãªm, cÃ²n láº¡i ráº¥t á»•n.', NOW() - INTERVAL 29 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH04', 'TTT_SAPA_OLD', 'KH_04', 5, 'PhÃ²ng Ä‘Æ¡n Ä‘Æ°á»£c sáº¯p xáº¿p Ä‘Ãºng yÃªu cáº§u, HDV chÄƒm sÃ³c ká»¹.', NOW() - INTERVAL 29 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH05', 'TTT_SAPA_OLD', 'KH_05', 4, 'Gia Ä‘Ã¬nh hÃ i lÃ²ng, tráº» nhá» Ä‘Æ°á»£c há»— trá»£ khi Ä‘i bá»™.', NOW() - INTERVAL 28 DAY);


-- Bá»” SUNG: TOUR THá»°C Táº¾ á»ž NHIá»€U TRáº NG THÃI, Dá»® LIá»†U LIÃŠN QUAN Äáº¦Y Äá»¦

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_NINHBINH_CKH_02', 'TM_NINHBINH', DATE(NOW()) + INTERVAL 210 DAY, 3000000, 22, 8, 22, 'CHO_KICH_HOAT');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_DALAT_MB_02', 'TM_DALAT', DATE(NOW()) + INTERVAL 220 DAY, 4300000, 20, 8, 20, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_PHUQUOC_SDR_02', 'TM_PHUQUOC', DATE(NOW()) + INTERVAL 8 DAY, 7900000, 24, 10, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BUONMATHUOT_DDR_02', 'TM_BUONMATHUOT', DATE(NOW()) - INTERVAL 1 DAY, 4200000, 18, 8, 18, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CANTHO_KT_02', 'TM_CANTHO', DATE(NOW()) - INTERVAL 14 DAY, 3800000, 26, 10, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HAGIANG_HUY_02', 'TM_HAGIANG', DATE(NOW()) + INTERVAL 240 DAY, 6300000, 18, 8, 18, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HUE_QT_02', 'TM_HUE', DATE(NOW()) - INTERVAL 45 DAY, 4400000, 22, 8, 22, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DALAT_MB_02', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PHUQUOC_SDR_02', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BUONMATHUOT_DDR_02', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CANTHO_KT_02', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HAGIANG_HUY_02', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUE_QT_02', 'DVT_SINGLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DALAT_MB_02', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PHUQUOC_SDR_02', 'HDX_BOTTLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BUONMATHUOT_DDR_02', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CANTHO_KT_02', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HAGIANG_HUY_02', 'HDX_TREE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HUE_QT_02', 'HDX_LOCAL');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_NB_CKH_02_HDV07', 'TTT_NINHBINH_CKH_02', 'NV_HDV07', NOW() - INTERVAL 2 DAY, 'CHO_PHAN_HOI', NULL);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_DALAT_MB_02_HDV08', 'TTT_DALAT_MB_02', 'NV_HDV08', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y', NOW() - INTERVAL 1 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_PHUQUOC_SDR_02_HDV09', 'TTT_PHUQUOC_SDR_02', 'NV_HDV09', NOW() - INTERVAL 5 DAY, 'DA_DONG_Y', NOW() - INTERVAL 4 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_BMT_DDR_02_HDV10', 'TTT_BUONMATHUOT_DDR_02', 'NV_HDV10', NOW() - INTERVAL 12 DAY, 'DA_DONG_Y', NOW() - INTERVAL 11 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_CANTHO_KT_02_HDV07', 'TTT_CANTHO_KT_02', 'NV_HDV07', NOW() - INTERVAL 25 DAY, 'DA_DONG_Y', NOW() - INTERVAL 24 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_HAGIANG_HUY_02_HDV08', 'TTT_HAGIANG_HUY_02', 'NV_HDV08', NOW() - INTERVAL 7 DAY, 'TU_CHOI', NOW() - INTERVAL 6 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_HUE_QT_02_HDV09', 'TTT_HUE_QT_02', 'NV_HDV09', NOW() - INTERVAL 60 DAY, 'DA_DONG_Y', NOW() - INTERVAL 59 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_DALAT_MB_02_CHO', 'TTT_DALAT_MB_02', 'KH_06', NOW() - INTERVAL 6 HOUR, 8720000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Hai khÃ¡ch giá»¯ chá»— tour ÄÃ  Láº¡t, Ä‘Ã£ thanh toÃ¡n cá»c má»™t pháº§n.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DALAT_MB_02_01', 'DDT_DALAT_MB_02_CHO', 'BÃ¹i Minh Ngá»c', '079299000501', '0922000501', '1998-02-14', 'Ná»®', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DALAT_MB_02_KH', 'DDT_DALAT_MB_02_CHO', 'KH_06', NULL, 'NGUOI_DAT', 4300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_DALAT_MB_02_NDH1', 'DDT_DALAT_MB_02_CHO', NULL, 'NDH_DALAT_MB_02_01', 'NGUOI_DONG_HANH', 4300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_DALAT_MB_02_INS', 'DDT_DALAT_MB_02_CHO', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_DALAT_MB_02_COC', 'DDT_DALAT_MB_02_CHO', 'THANH_TOAN', 'CHUYEN_KHOAN', 3000000, 'BANK-DALAT-02', 'THANH_CONG', NOW() - INTERVAL 2 HOUR);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_PHUQUOC_SDR_02_OK', 'TTT_PHUQUOC_SDR_02', 'KH_07', NOW() - INTERVAL 12 DAY, 16150000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 10 DAY, 'Gia Ä‘Ã¬nh ba ngÆ°á»i Ä‘i PhÃº Quá»‘c, thanh toÃ¡n Ä‘á»§ trÆ°á»›c ngÃ y khá»Ÿi hÃ nh.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_PHUQUOC_SDR_02_01', 'DDT_PHUQUOC_SDR_02_OK', 'HoÃ ng Gia Báº£o', '079299000502', '0922000502', '1990-06-06', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_PHUQUOC_SDR_02_02', 'DDT_PHUQUOC_SDR_02_OK', 'HoÃ ng Minh ChÃ¢u', '079299000503', '0922000503', '2016-09-09', 'Ná»®', 'Tráº» em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_PHUQUOC_SDR_02_KH', 'DDT_PHUQUOC_SDR_02_OK', 'KH_07', NULL, 'NGUOI_DAT', 7900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_PHUQUOC_SDR_02_NDH1', 'DDT_PHUQUOC_SDR_02_OK', NULL, 'NDH_PHUQUOC_SDR_02_01', 'NGUOI_DONG_HANH', 7900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_PHUQUOC_SDR_02_NDH2', 'DDT_PHUQUOC_SDR_02_OK', NULL, 'NDH_PHUQUOC_SDR_02_02', 'NGUOI_DONG_HANH', 0);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_PHUQUOC_SDR_02_AIR', 'DDT_PHUQUOC_SDR_02_OK', 'DVT_AIRPORT', 1, 350000, 350000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_PHUQUOC_SDR_02_PAY', 'DDT_PHUQUOC_SDR_02_OK', 'THANH_TOAN', 'THE_QUOC_TE', 16150000, 'BANK-PHUQUOC-02', 'THANH_CONG', NOW() - INTERVAL 11 DAY);
UPDATE tour_thuc_tes SET trang_thai = 'MO_BAN' WHERE ma_tour_thuc_te = 'TTT_PHUQUOC_SDR_02';

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_BMT_DDR_02_OK', 'TTT_BUONMATHUOT_DDR_02', 'KH_08', NOW() - INTERVAL 10 DAY, 8680000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 8 DAY, 'Hai khÃ¡ch Ä‘ang tham gia tour BuÃ´n Ma Thuá»™t.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_BMT_DDR_02_01', 'DDT_BMT_DDR_02_OK', 'VÅ© Háº£i ÄÄƒng', '079299000504', '0922000504', '1989-12-12', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_BMT_DDR_02_KH', 'DDT_BMT_DDR_02_OK', 'KH_08', NULL, 'NGUOI_DAT', 4200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_BMT_DDR_02_NDH1', 'DDT_BMT_DDR_02_OK', NULL, 'NDH_BMT_DDR_02_01', 'NGUOI_DONG_HANH', 4200000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_BMT_DDR_02_DINNER', 'DDT_BMT_DDR_02_OK', 'DVT_DINNER', 1, 280000, 280000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_BMT_DDR_02_PAY', 'DDT_BMT_DDR_02_OK', 'THANH_TOAN', 'CHUYEN_KHOAN', 8680000, 'BANK-BMT-02', 'THANH_CONG', NOW() - INTERVAL 9 DAY);
UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA' WHERE ma_tour_thuc_te = 'TTT_BUONMATHUOT_DDR_02';
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BMT_DDR_02_KH_OK', 'TTT_BUONMATHUOT_DDR_02', 'KH_08', NULL, 'NGUOI_DAT', 'NV_HDV10', NOW() - INTERVAL 4 HOUR, 'Báº£o tÃ ng CÃ  phÃª', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BMT_DDR_02_NDH_OK', 'TTT_BUONMATHUOT_DDR_02', NULL, 'NDH_BMT_DDR_02_01', 'NGUOI_DONG_HANH', 'NV_HDV10', NOW() - INTERVAL 4 HOUR, 'Báº£o tÃ ng CÃ  phÃª', 'DA_DIEM_DANH');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_BMT_DDR_02_LOCAL', 'TTT_BUONMATHUOT_DDR_02', 'KH_08', 'HDX_LOCAL', 'NV_HDV10', NOW() - INTERVAL 2 HOUR,
        'KhÃ¡ch sá»­ dá»¥ng bÃ¬nh nÆ°á»›c cÃ¡ nhÃ¢n vÃ  mua sáº£n pháº©m Ä‘á»‹a phÆ°Æ¡ng khÃ´ng dÃ¹ng tÃºi nhá»±a.');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_BMT_DDR_02_RAIN', 'TTT_BUONMATHUOT_DDR_02', 'NV_HDV10', 'MÆ°a lá»›n khi tham quan thÃ¡c Dray Nur.',
        'Äá»•i lá»‹ch tham quan trong nhÃ  vÃ  phÃ¡t Ã¡o mÆ°a cho khÃ¡ch.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 90 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BMT_DDR_02_RAINCOAT', 'TTT_BUONMATHUOT_DDR_02', 'NV_HDV10', 'Ão mÆ°a vÃ  khÄƒn khÃ´', 220000, 'https://seed.local/hoa-don/bmt-ao-mua.jpg', 'CHO_DUYET', NOW() - INTERVAL 80 MINUTE);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_OK', 'TTT_CANTHO_KT_02', 'KH_09', NOW() - INTERVAL 25 DAY, 8500000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 23 DAY, 'NhÃ³m hai khÃ¡ch Ä‘Ã£ hoÃ n thÃ nh tour Cáº§n ThÆ¡.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_01', 'DDT_CANTHO_KT_02_OK', 'Äáº·ng Minh KhÃ´i', '079299000505', '0922000505', '1986-01-21', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_KH', 'DDT_CANTHO_KT_02_OK', 'KH_09', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_NDH1', 'DDT_CANTHO_KT_02_OK', NULL, 'NDH_CANTHO_KT_02_01', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CANTHO_KT_02_PHOTO', 'DDT_CANTHO_KT_02_OK', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_PAY', 'DDT_CANTHO_KT_02_OK', 'THANH_TOAN', 'CHUYEN_KHOAN', 8500000, 'BANK-CANTHO-02', 'THANH_CONG', NOW() - INTERVAL 24 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_02', 'TTT_CANTHO_KT_02', 'KH_12', NOW() - INTERVAL 24 DAY, 3800000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 22 DAY, 'KhÃ¡ch láº» Ä‘áº·t tour Cáº§n ThÆ¡, cáº§n thá»±c Ä‘Æ¡n chay.', 'HDX_EBILL:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_02_KH', 'DDT_CANTHO_KT_02_02', 'KH_12', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_02_PAY', 'DDT_CANTHO_KT_02_02', 'THANH_TOAN', 'VI_DIEN_TU', 3800000, 'BANK-CANTHO-022', 'THANH_CONG', NOW() - INTERVAL 23 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_03', 'TTT_CANTHO_KT_02', 'KH_13', NOW() - INTERVAL 24 DAY, 7600000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 22 DAY, 'Hai khÃ¡ch Ä‘i nghá»‰ cuá»‘i tuáº§n, Æ°u tiÃªn phÃ²ng yÃªn tÄ©nh.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_03_01', 'DDT_CANTHO_KT_02_03', 'Nguyá»…n HoÃ i Nam', '079299000508', '0922000508', '1984-06-17', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_03_KH', 'DDT_CANTHO_KT_02_03', 'KH_13', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_03_NDH1', 'DDT_CANTHO_KT_02_03', NULL, 'NDH_CANTHO_KT_02_03_01', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_03_PAY', 'DDT_CANTHO_KT_02_03', 'THANH_TOAN', 'CHUYEN_KHOAN', 7600000, 'BANK-CANTHO-023', 'THANH_CONG', NOW() - INTERVAL 23 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_04', 'TTT_CANTHO_KT_02', 'KH_14', NOW() - INTERVAL 23 DAY, 12300000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 21 DAY, 'Gia Ä‘Ã¬nh ba ngÆ°á»i Ä‘áº·t thÃªm gÃ³i chá»¥p áº£nh hÃ nh trÃ¬nh.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_04_01', 'DDT_CANTHO_KT_02_04', 'LÃ¢m Gia HÃ¢n', '079299000509', '0922000509', '2019-03-15', 'Ná»®', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_04_02', 'DDT_CANTHO_KT_02_04', 'LÃ¢m Minh PhÃºc', '079299000510', '0922000510', '1988-05-03', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_04_KH', 'DDT_CANTHO_KT_02_04', 'KH_14', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_04_NDH1', 'DDT_CANTHO_KT_02_04', NULL, 'NDH_CANTHO_KT_02_04_01', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_04_NDH2', 'DDT_CANTHO_KT_02_04', NULL, 'NDH_CANTHO_KT_02_04_02', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CANTHO_KT_02_04_PHOTO', 'DDT_CANTHO_KT_02_04', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_04_PAY', 'DDT_CANTHO_KT_02_04', 'THANH_TOAN', 'THE_NOI_DIA', 12300000, 'BANK-CANTHO-024', 'THANH_CONG', NOW() - INTERVAL 22 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_05', 'TTT_CANTHO_KT_02', 'KH_15', NOW() - INTERVAL 23 DAY, 4700000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 21 DAY, 'KhÃ¡ch láº» Ä‘áº·t thÃªm gÃ³i áº£nh, thanh toÃ¡n Ä‘á»§ má»™t láº§n.', 'HDX_EBILL:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_05_KH', 'DDT_CANTHO_KT_02_05', 'KH_15', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CANTHO_KT_02_05_PHOTO', 'DDT_CANTHO_KT_02_05', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_05_PAY', 'DDT_CANTHO_KT_02_05', 'THANH_TOAN', 'CHUYEN_KHOAN', 4700000, 'BANK-CANTHO-025', 'THANH_CONG', NOW() - INTERVAL 22 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_06', 'TTT_CANTHO_KT_02', 'KH_06', NOW() - INTERVAL 22 DAY, 7600000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 20 DAY, 'Hai khÃ¡ch Ä‘i tour Cáº§n ThÆ¡, cáº§n xÃ¡c nháº­n xe Ä‘Æ°a Ä‘Ã³n.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_06_01', 'DDT_CANTHO_KT_02_06', 'BÃ¹i Minh An', '079299000511', '0922000511', '1995-10-10', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_06_KH', 'DDT_CANTHO_KT_02_06', 'KH_06', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_06_NDH1', 'DDT_CANTHO_KT_02_06', NULL, 'NDH_CANTHO_KT_02_06_01', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_06_PAY', 'DDT_CANTHO_KT_02_06', 'THANH_TOAN', 'THE_QUOC_TE', 7600000, 'BANK-CANTHO-026', 'THANH_CONG', NOW() - INTERVAL 21 DAY);

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_CANTHO_KT_02';
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CANTHO_KT_02_KH09', 'KH_09', 'TTT_CANTHO_KT_02', 'CTDT_CANTHO_KT_02_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CANTHO_KT_02_KH12', 'KH_12', 'TTT_CANTHO_KT_02', 'CTDT_CANTHO_KT_02_02_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CANTHO_KT_02_KH13', 'KH_13', 'TTT_CANTHO_KT_02', 'CTDT_CANTHO_KT_02_03_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CANTHO_KT_02_KH14', 'KH_14', 'TTT_CANTHO_KT_02', 'CTDT_CANTHO_KT_02_04_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CANTHO_KT_02_KH15', 'KH_15', 'TTT_CANTHO_KT_02', 'CTDT_CANTHO_KT_02_05_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CANTHO_KT_02_KH06', 'KH_06', 'TTT_CANTHO_KT_02', 'CTDT_CANTHO_KT_02_06_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_CANTHO_KT_02_BOAT', 'TTT_CANTHO_KT_02', 'NV_HDV07', 'Thuyá»n chá»£ ná»•i Ä‘á»•i báº¿n Ä‘Ã³n khÃ¡ch do triá»u cÆ°á»ng.',
        'ThÃ´ng bÃ¡o sá»›m, Ä‘iá»u xe trung chuyá»ƒn vÃ  giá»¯ nguyÃªn lá»‹ch tham quan.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 13 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CANTHO_KT_02_TRANSFER', 'TTT_CANTHO_KT_02', 'NV_HDV07', 'Xe trung chuyá»ƒn ra báº¿n phá»¥', 420000, 'https://seed.local/hoa-don/cantho-transfer.jpg', 'DA_DUYET', NOW() - INTERVAL 13 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH09', 'TTT_CANTHO_KT_02', 'KH_09', 5, 'Lá»‹ch trÃ¬nh há»£p lÃ½, hÆ°á»›ng dáº«n viÃªn xá»­ lÃ½ Ä‘á»•i báº¿n ráº¥t chuyÃªn nghiá»‡p.', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH12', 'TTT_CANTHO_KT_02', 'KH_12', 5, 'Thá»±c Ä‘Æ¡n chay Ä‘Æ°á»£c chuáº©n bá»‹ chu Ä‘Ã¡o, chá»£ ná»•i ráº¥t thÃº vá»‹.', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH13', 'TTT_CANTHO_KT_02', 'KH_13', 4, 'Tour nháº¹ nhÃ ng, khÃ¡ch sáº¡n yÃªn tÄ©nh, nÃªn thÃªm thá»i gian á»Ÿ miá»‡t vÆ°á»n.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH14', 'TTT_CANTHO_KT_02', 'KH_14', 5, 'Gia Ä‘Ã¬nh cÃ³ tráº» nhá» váº«n Ä‘i ráº¥t thoáº£i mÃ¡i, áº£nh hÃ nh trÃ¬nh Ä‘áº¹p.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH15', 'TTT_CANTHO_KT_02', 'KH_15', 4, 'Dá»‹ch vá»¥ tá»‘t, di chuyá»ƒn Ä‘Ãºng giá», pháº§n Äƒn sÃ¡ng cÃ³ thá»ƒ Ä‘a dáº¡ng hÆ¡n.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH06', 'TTT_CANTHO_KT_02', 'KH_06', 5, 'HÆ°á»›ng dáº«n viÃªn nhiá»‡t tÃ¬nh vÃ  há»— trá»£ xe Ä‘Æ°a Ä‘Ã³n ráº¥t rÃµ rÃ ng.', NOW() - INTERVAL 8 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HAGIANG_HUY_02_OK', 'TTT_HAGIANG_HUY_02', 'KH_10', NOW() - INTERVAL 9 DAY, 12720000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 7 DAY, 'Hai khÃ¡ch Ä‘Ã£ thanh toÃ¡n, tour bá»‹ há»§y do sáº¡t lá»Ÿ Ä‘Æ°á»ng Ä‘Ã¨o.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HAGIANG_HUY_02_01', 'DDT_HAGIANG_HUY_02_OK', 'Mai HoÃ ng Long', '079299000506', '0922000506', '1991-04-04', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HAGIANG_HUY_02_KH', 'DDT_HAGIANG_HUY_02_OK', 'KH_10', NULL, 'NGUOI_DAT', 6300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HAGIANG_HUY_02_NDH1', 'DDT_HAGIANG_HUY_02_OK', NULL, 'NDH_HAGIANG_HUY_02_01', 'NGUOI_DONG_HANH', 6300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HAGIANG_HUY_02_INS', 'DDT_HAGIANG_HUY_02_OK', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HAGIANG_HUY_02_PAY', 'DDT_HAGIANG_HUY_02_OK', 'THANH_TOAN', 'CHUYEN_KHOAN', 12720000, 'BANK-HAGIANG-02', 'THANH_CONG', NOW() - INTERVAL 8 DAY);
UPDATE tour_thuc_tes SET trang_thai = 'HUY' WHERE ma_tour_thuc_te = 'TTT_HAGIANG_HUY_02';
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HAGIANG_HUY_02_REFUND', 'DDT_HAGIANG_HUY_02_OK', 'HOAN_TIEN', 'HE_THONG', 12720000, 'BANK-HAGIANG-RF02', 'CHO_THANH_TOAN', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HUE_QT_02_OK', 'TTT_HUE_QT_02', 'KH_11', NOW() - INTERVAL 65 DAY, 9450000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 63 DAY, 'Hai khÃ¡ch hoÃ n thÃ nh tour Huáº¿ vÃ  Ä‘Ã£ quyáº¿t toÃ¡n.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HUE_QT_02_01', 'DDT_HUE_QT_02_OK', 'Cao Minh Anh', '079299000507', '0922000507', '1982-07-17', 'Ná»®', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUE_QT_02_KH', 'DDT_HUE_QT_02_OK', 'KH_11', NULL, 'NGUOI_DAT', 4400000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUE_QT_02_NDH1', 'DDT_HUE_QT_02_OK', NULL, 'NDH_HUE_QT_02_01', 'NGUOI_DONG_HANH', 4400000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HUE_QT_02_SINGLE', 'DDT_HUE_QT_02_OK', 'DVT_SINGLE', 1, 650000, 650000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HUE_QT_02_PAY', 'DDT_HUE_QT_02_OK', 'THANH_TOAN', 'THE_QUOC_TE', 9450000, 'BANK-HUE-02', 'THANH_CONG', NOW() - INTERVAL 64 DAY);
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_HUE_QT_02';
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HUE_QT_02_KH11', 'KH_11', 'TTT_HUE_QT_02', 'CTDT_HUE_QT_02_KH', DATE(NOW()) - INTERVAL 45 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_HUE_QT_02_FOOD', 'TTT_HUE_QT_02', 'NV_HDV09', 'Má»™t khÃ¡ch dá»‹ á»©ng nháº¹ vá»›i mÃ³n Äƒn cÃ³ tÃ´m.',
        'Äá»•i suáº¥t Äƒn riÃªng vÃ  ghi chÃº láº¡i vá»›i nhÃ  hÃ ng cÃ¡c bá»¯a sau.', 'THAP', 'AN_UONG', NOW() - INTERVAL 44 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_HOTEL', 'TTT_HUE_QT_02', 'NV_HDV09', 'KhÃ¡ch sáº¡n Huáº¿ 2 Ä‘Ãªm', 3900000, 'https://seed.local/hoa-don/hue02-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 43 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_MEAL', 'TTT_HUE_QT_02', 'NV_HDV09', 'Suáº¥t Äƒn thay tháº¿ cho khÃ¡ch dá»‹ á»©ng', 260000, 'https://seed.local/hoa-don/hue02-meal.jpg', 'DA_DUYET', NOW() - INTERVAL 43 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_TICKET', 'TTT_HUE_QT_02', 'NV_HDV09', 'VÃ© tham quan Äáº¡i Ná»™i', 700000, 'https://seed.local/hoa-don/hue02-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 42 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HUE_QT_02_KH11', 'TTT_HUE_QT_02', 'KH_11', 5, 'Tour Huáº¿ chá»‰n chu, xá»­ lÃ½ dá»‹ á»©ng mÃ³n Äƒn ráº¥t nhanh vÃ  chu Ä‘Ã¡o.', NOW() - INTERVAL 40 DAY);
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_HUE_02_DONE', 'TTT_HUE_QT_02', 0, 0, 8500000, 0, 'NV_KT01', NOW() - INTERVAL 39 DAY, 'DA_QUYET_TOAN',
        'Quyáº¿t toÃ¡n tour Huáº¿ bá»• sung, doanh thu vÃ  chi phÃ­ Ä‘Æ°á»£c trigger tÃ­nh láº¡i.');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_NB_CKH_02_PC', 'TK_MGR01', 'THEM', 'PHANCONGTOUR_DIEU_HANH', 'PC_NB_CKH_02_HDV07', NOW() - INTERVAL 2 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_BMT_DDR_02_CP', 'TK_HDV10', 'THEM', 'CHIPHITHUCTE_HDV', 'CP_BMT_DDR_02_RAINCOAT', NOW() - INTERVAL 75 MINUTE);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_HUE_QT_02_DONE', 'TK_KT01', 'THEM', 'QUYETTOAN_KETOAN', 'QT_HUE_02_DONE', NOW() - INTERVAL 39 DAY);

-- ------------------------------------------------------------
-- 20 TOUR MO BAN BO SUNG - DON DAT, HANH KHACH, DICH VU, THANH TOAN LIEN KET
-- Luu y: danh gia khach hang chi hop le voi tour da ket thuc/quyet toan theo trigger nghiep vu.
-- ------------------------------------------------------------
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_SAPA_OPEN_03', 'TM_SAPA', DATE(NOW()) + INTERVAL 270 DAY, 4950000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_DANANG_OPEN_03', 'TM_DANANG', DATE(NOW()) + INTERVAL 276 DAY, 6750000, 32, 12, 32, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_DALAT_OPEN_03', 'TM_DALAT', DATE(NOW()) + INTERVAL 282 DAY, 4350000, 24, 8, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_NINHBINH_OPEN_03', 'TM_NINHBINH', DATE(NOW()) + INTERVAL 288 DAY, 3200000, 34, 12, 34, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_PHUQUOC_OPEN_03', 'TM_PHUQUOC', DATE(NOW()) + INTERVAL 294 DAY, 8150000, 26, 10, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HUE_OPEN_03', 'TM_HUE', DATE(NOW()) + INTERVAL 300 DAY, 4550000, 28, 10, 28, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HAGIANG_OPEN_03', 'TM_HAGIANG', DATE(NOW()) + INTERVAL 306 DAY, 6500000, 22, 8, 22, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HOIAN_OPEN_03', 'TM_HOIAN', DATE(NOW()) + INTERVAL 312 DAY, 4750000, 26, 8, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HALONG_OPEN_03', 'TM_HALONG', DATE(NOW()) + INTERVAL 318 DAY, 6150000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CANTHO_OPEN_03', 'TM_CANTHO', DATE(NOW()) + INTERVAL 324 DAY, 3950000, 32, 12, 32, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CONDAO_OPEN_03', 'TM_CONDAO', DATE(NOW()) + INTERVAL 330 DAY, 8850000, 20, 8, 20, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MOCCHAU_OPEN_03', 'TM_MOCCHAU', DATE(NOW()) + INTERVAL 336 DAY, 2950000, 26, 10, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_QUYNHON_OPEN_03', 'TM_QUYNHON', DATE(NOW()) + INTERVAL 342 DAY, 5750000, 26, 8, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BUONMATHUOT_OPEN_03', 'TM_BUONMATHUOT', DATE(NOW()) + INTERVAL 348 DAY, 4300000, 24, 8, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_PULUONG_OPEN_03', 'TM_PULUONG', DATE(NOW()) + INTERVAL 354 DAY, 3450000, 22, 8, 22, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MUINE_OPEN_03', 'TM_MUINE', DATE(NOW()) + INTERVAL 360 DAY, 5100000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_SAPA_OPEN_04', 'TM_SAPA', DATE(NOW()) + INTERVAL 366 DAY, 5050000, 28, 10, 28, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_DANANG_OPEN_04', 'TM_DANANG', DATE(NOW()) + INTERVAL 372 DAY, 6900000, 34, 12, 34, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_PHUQUOC_OPEN_04', 'TM_PHUQUOC', DATE(NOW()) + INTERVAL 378 DAY, 8350000, 26, 10, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HUE_OPEN_04', 'TM_HUE', DATE(NOW()) + INTERVAL 384 DAY, 4650000, 28, 10, 28, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_OPEN_03', 'DVT_SINGLE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DANANG_OPEN_03', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DALAT_OPEN_03', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_NINHBINH_OPEN_03', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PHUQUOC_OPEN_03', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUE_OPEN_03', 'DVT_SINGLE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HAGIANG_OPEN_03', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HOIAN_OPEN_03', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HALONG_OPEN_03', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CANTHO_OPEN_03', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CONDAO_OPEN_03', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MOCCHAU_OPEN_03', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_QUYNHON_OPEN_03', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BUONMATHUOT_OPEN_03', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PULUONG_OPEN_03', 'DVT_PHOTO');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MUINE_OPEN_03', 'DVT_AIRPORT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_OPEN_04', 'DVT_SINGLE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DANANG_OPEN_04', 'DVT_DINNER');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PHUQUOC_OPEN_04', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUE_OPEN_04', 'DVT_SINGLE');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_SAPA_OPEN_03', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DANANG_OPEN_03', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DALAT_OPEN_03', 'HDX_BOTTLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_NINHBINH_OPEN_03', 'HDX_TREE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PHUQUOC_OPEN_03', 'HDX_CLEANUP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HUE_OPEN_03', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HAGIANG_OPEN_03', 'HDX_TREE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HOIAN_OPEN_03', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HALONG_OPEN_03', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CANTHO_OPEN_03', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CONDAO_OPEN_03', 'HDX_CLEANUP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MOCCHAU_OPEN_03', 'HDX_TREE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_QUYNHON_OPEN_03', 'HDX_BOTTLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BUONMATHUOT_OPEN_03', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PULUONG_OPEN_03', 'HDX_TREE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MUINE_OPEN_03', 'HDX_BOTTLE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_SAPA_OPEN_04', 'HDX_EBILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DANANG_OPEN_04', 'HDX_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PHUQUOC_OPEN_04', 'HDX_CLEANUP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HUE_OPEN_04', 'HDX_LOCAL');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OPEN_03_GD1', 'TTT_SAPA_OPEN_03', 'KH_01', NOW() - INTERVAL 5 DAY, 25350000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Gia Ä‘Ã¬nh 5 khÃ¡ch, yÃªu cáº§u 2 phÃ²ng gáº§n nhau vÃ  suáº¥t Äƒn khÃ´ng háº£i sáº£n cho ngÆ°á»i Ä‘áº·t.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_01', 'DDT_SAPA_OPEN_03_GD1', 'Nguyá»…n Minh Äá»©c', '001086030101', '0903000101', '1986-03-12', 'NAM', 'Chá»“ng ngÆ°á»i Ä‘áº·t tour');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_02', 'DDT_SAPA_OPEN_03_GD1', 'Nguyá»…n Báº£o An', '001112030102', '0903000102', '2012-08-24', 'Ná»¯', 'Tráº» em 12 tuá»•i');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_03', 'DDT_SAPA_OPEN_03_GD1', 'Nguyá»…n Gia Huy', '001116030103', '0903000103', '2016-11-05', 'NAM', 'Tráº» em 8 tuá»•i');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_04', 'DDT_SAPA_OPEN_03_GD1', 'Tráº§n Thá»‹ Kim LiÃªn', '001060030104', '0903000104', '1960-02-18', 'Ná»¯', 'NgÆ°á»i cao tuá»•i, háº¡n cháº¿ leo dá»‘c');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OPEN_03_GD1_KH', 'DDT_SAPA_OPEN_03_GD1', 'KH_01', NULL, 'NGUOI_DAT', 4950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OPEN_03_GD1_NDH1', 'DDT_SAPA_OPEN_03_GD1', NULL, 'NDH_SAPA_OPEN_03_GD1_01', 'NGUOI_DONG_HANH', 4950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OPEN_03_GD1_NDH2', 'DDT_SAPA_OPEN_03_GD1', NULL, 'NDH_SAPA_OPEN_03_GD1_02', 'NGUOI_DONG_HANH', 4950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OPEN_03_GD1_NDH3', 'DDT_SAPA_OPEN_03_GD1', NULL, 'NDH_SAPA_OPEN_03_GD1_03', 'NGUOI_DONG_HANH', 4950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_SAPA_OPEN_03_GD1_NDH4', 'DDT_SAPA_OPEN_03_GD1', NULL, 'NDH_SAPA_OPEN_03_GD1_04', 'NGUOI_DONG_HANH', 4950000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_SAPA_OPEN_03_GD1_SINGLE', 'DDT_SAPA_OPEN_03_GD1', 'DVT_SINGLE', 1, 600000, 600000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_SAPA_OPEN_03_GD1_PAY', 'DDT_SAPA_OPEN_03_GD1', 'THANH_TOAN', 'CHUYEN_KHOAN', 25350000, 'BANK-OPEN-0301', 'THANH_CONG', NOW() - INTERVAL 4 DAY);

-- Cac don con lai moi don co nguoi dat tour va thanh toan rieng, phu hop gia tour/dich vu.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_DANANG_OPEN_03_FAMILY', 'TTT_DANANG_OPEN_03', 'KH_06', NOW() - INTERVAL 3 DAY, 27300000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Gia Ä‘Ã¬nh bá»‘n khÃ¡ch, cáº§n Ä‘Æ°a Ä‘Ã³n sÃ¢n bay ÄÃ  Náºµng vÃ  bÃ n Äƒn riÃªng tá»‘i á»Ÿ Há»™i An.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_03_01', 'DDT_DANANG_OPEN_03_FAMILY', 'BÃ¹i Thanh Phong', '048087030111', '0903000111', '1987-01-19', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_03_02', 'DDT_DANANG_OPEN_03_FAMILY', 'BÃ¹i An NhiÃªn', '048014030112', '0903000112', '2014-05-07', 'Ná»¯', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_03_03', 'DDT_DANANG_OPEN_03_FAMILY', 'BÃ¹i Gia Khang', '048017030113', '0903000113', '2017-09-22', 'NAM', 'Tráº» em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_KH', 'DDT_DANANG_OPEN_03_FAMILY', 'KH_06', NULL, 'NGUOI_DAT', 6750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_NDH1', 'DDT_DANANG_OPEN_03_FAMILY', NULL, 'NDH_DANANG_OPEN_03_01', 'NGUOI_DONG_HANH', 6750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_NDH2', 'DDT_DANANG_OPEN_03_FAMILY', NULL, 'NDH_DANANG_OPEN_03_02', 'NGUOI_DONG_HANH', 6750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_NDH3', 'DDT_DANANG_OPEN_03_FAMILY', NULL, 'NDH_DANANG_OPEN_03_03', 'NGUOI_DONG_HANH', 6750000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_DANANG_OPEN_03_DINNER', 'DDT_DANANG_OPEN_03_FAMILY', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_DANANG_OPEN_03_PAY', 'DDT_DANANG_OPEN_03_FAMILY', 'THANH_TOAN', 'CHUYEN_KHOAN', 27300000, 'BANK-OPEN-0302', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_DALAT_OPEN_03_COUPLE', 'TTT_DALAT_OPEN_03', 'KH_07', NOW() - INTERVAL 2 DAY, 9100000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch Ä‘i nghá»‰ dÆ°á»¡ng, Ä‘áº·t Ä‘Æ°a Ä‘Ã³n sÃ¢n bay LiÃªn KhÆ°Æ¡ng.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DALAT_OPEN_03_01', 'DDT_DALAT_OPEN_03_COUPLE', 'Táº¡ Minh QuÃ¢n', '026091030114', '0903000114', '1991-03-03', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DALAT_OPEN_03_KH', 'DDT_DALAT_OPEN_03_COUPLE', 'KH_07', NULL, 'NGUOI_DAT', 4350000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DALAT_OPEN_03_NDH1', 'DDT_DALAT_OPEN_03_COUPLE', NULL, 'NDH_DALAT_OPEN_03_01', 'NGUOI_DONG_HANH', 4350000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_DALAT_OPEN_03_AIRPORT', 'DDT_DALAT_OPEN_03_COUPLE', 'DVT_AIRPORT', 1, 400000, 400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_DALAT_OPEN_03_PAY', 'DDT_DALAT_OPEN_03_COUPLE', 'THANH_TOAN', 'VI_DIEN_TU', 9100000, 'BANK-OPEN-0303', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_NINHBINH_OPEN_03_TEAM', 'TTT_NINHBINH_OPEN_03', 'KH_08', NOW() - INTERVAL 2 DAY, 16900000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'NhÃ³m nÄƒm khÃ¡ch Ä‘i cuá»‘i tuáº§n, Ä‘áº·t gÃ³i áº£nh hÃ nh trÃ¬nh.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_01', 'DDT_NINHBINH_OPEN_03_TEAM', 'Äinh Háº£i Long', '037089030115', '0903000115', '1989-04-12', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_02', 'DDT_NINHBINH_OPEN_03_TEAM', 'Äinh Ngá»c HÃ¢n', '037092030116', '0903000116', '1992-02-23', 'Ná»¯', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_03', 'DDT_NINHBINH_OPEN_03_TEAM', 'Trá»‹nh Gia PhÃºc', '037090030117', '0903000117', '1990-10-08', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_04', 'DDT_NINHBINH_OPEN_03_TEAM', 'Trá»‹nh HoÃ i ThÆ°Æ¡ng', '037093030118', '0903000118', '1993-07-16', 'Ná»¯', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_KH', 'DDT_NINHBINH_OPEN_03_TEAM', 'KH_08', NULL, 'NGUOI_DAT', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH1', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_01', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH2', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_02', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH3', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_03', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH4', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_04', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_NINHBINH_OPEN_03_PHOTO', 'DDT_NINHBINH_OPEN_03_TEAM', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_NINHBINH_OPEN_03_PAY', 'DDT_NINHBINH_OPEN_03_TEAM', 'THANH_TOAN', 'CHUYEN_KHOAN', 16900000, 'BANK-OPEN-0304', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_PHUQUOC_OPEN_03_FAMILY', 'TTT_PHUQUOC_OPEN_03', 'KH_09', NOW() - INTERVAL 3 DAY, 32600000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Bá»‘n khÃ¡ch nghá»‰ biá»ƒn, cáº§n xuáº¥t hÃ³a Ä‘Æ¡n cÃ´ng ty sau khi thanh toÃ¡n.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_03_01', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'VÃµ Nháº­t Minh', '091087030119', '0903000119', '1987-12-09', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_03_02', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'VÃµ Mai Chi', '091013030120', '0903000120', '2013-01-29', 'Ná»¯', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_03_03', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'VÃµ KhÃ¡nh An', '091016030121', '0903000121', '2016-06-11', 'NAM', 'Tráº» em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_KH', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'KH_09', NULL, 'NGUOI_DAT', 8150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_NDH1', 'DDT_PHUQUOC_OPEN_03_FAMILY', NULL, 'NDH_PHUQUOC_OPEN_03_01', 'NGUOI_DONG_HANH', 8150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_NDH2', 'DDT_PHUQUOC_OPEN_03_FAMILY', NULL, 'NDH_PHUQUOC_OPEN_03_02', 'NGUOI_DONG_HANH', 8150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_NDH3', 'DDT_PHUQUOC_OPEN_03_FAMILY', NULL, 'NDH_PHUQUOC_OPEN_03_03', 'NGUOI_DONG_HANH', 8150000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_PHUQUOC_OPEN_03_PAY', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'THANH_TOAN', 'THE_NOI_DIA', 32600000, 'BANK-OPEN-0305', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HUE_OPEN_03_COUPLE', 'TTT_HUE_OPEN_03', 'KH_10', NOW() - INTERVAL 2 DAY, 9750000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch tham quan di sáº£n, má»™t khÃ¡ch dá»‹ á»©ng háº£i sáº£n cÃ³ vá».', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_OPEN_03_01', 'DDT_HUE_OPEN_03_COUPLE', 'Mai Thanh BÃ¬nh', '075086030122', '0903000122', '1986-08-18', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_OPEN_03_KH', 'DDT_HUE_OPEN_03_COUPLE', 'KH_10', NULL, 'NGUOI_DAT', 4550000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_OPEN_03_NDH1', 'DDT_HUE_OPEN_03_COUPLE', NULL, 'NDH_HUE_OPEN_03_01', 'NGUOI_DONG_HANH', 4550000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HUE_OPEN_03_SINGLE', 'DDT_HUE_OPEN_03_COUPLE', 'DVT_SINGLE', 1, 650000, 650000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HUE_OPEN_03_PAY', 'DDT_HUE_OPEN_03_COUPLE', 'THANH_TOAN', 'CHUYEN_KHOAN', 9750000, 'BANK-OPEN-0306', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HAGIANG_OPEN_03_TEAM', 'TTT_HAGIANG_OPEN_03', 'KH_11', NOW() - INTERVAL 4 DAY, 19620000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khÃ¡ch yÃªu thiÃªn nhiÃªn, cáº§n lá»‹ch trÃ¬nh Ã­t leo dá»‘c vÃ  báº£o hiá»ƒm bá»• sung.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HAGIANG_OPEN_03_01', 'DDT_HAGIANG_OPEN_03_TEAM', 'Cao Minh Khoa', '024084030123', '0903000123', '1984-02-10', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HAGIANG_OPEN_03_02', 'DDT_HAGIANG_OPEN_03_TEAM', 'Cao Ngá»c Linh', '024090030124', '0903000124', '1990-05-21', 'Ná»¯', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HAGIANG_OPEN_03_KH', 'DDT_HAGIANG_OPEN_03_TEAM', 'KH_11', NULL, 'NGUOI_DAT', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HAGIANG_OPEN_03_NDH1', 'DDT_HAGIANG_OPEN_03_TEAM', NULL, 'NDH_HAGIANG_OPEN_03_01', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HAGIANG_OPEN_03_NDH2', 'DDT_HAGIANG_OPEN_03_TEAM', NULL, 'NDH_HAGIANG_OPEN_03_02', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HAGIANG_OPEN_03_INS', 'DDT_HAGIANG_OPEN_03_TEAM', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HAGIANG_OPEN_03_PAY', 'DDT_HAGIANG_OPEN_03_TEAM', 'THANH_TOAN', 'CHUYEN_KHOAN', 19620000, 'BANK-OPEN-0307', 'THANH_CONG', NOW() - INTERVAL 3 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HOIAN_OPEN_03_GROUP', 'TTT_HOIAN_OPEN_03', 'KH_12', NOW() - INTERVAL 3 DAY, 19300000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Bá»‘n khÃ¡ch Äƒn chay, Ä‘áº·t thÃªm bá»¯a tá»‘i tráº£i nghiá»‡m mÃ³n Ä‘á»‹a phÆ°Æ¡ng.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HOIAN_OPEN_03_01', 'DDT_HOIAN_OPEN_03_GROUP', 'NgÃ´ Thanh NhÃ£', '048092030125', '0903000125', '1992-04-04', 'Ná»¯', 'Ä‚n chay');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HOIAN_OPEN_03_02', 'DDT_HOIAN_OPEN_03_GROUP', 'NgÃ´ Minh Triáº¿t', '048089030126', '0903000126', '1989-01-15', 'NAM', 'Ä‚n chay');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HOIAN_OPEN_03_03', 'DDT_HOIAN_OPEN_03_GROUP', 'LÃ½ HoÃ i An', '048094030127', '0903000127', '1994-09-27', 'Ná»¯', 'Ä‚n chay');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_KH', 'DDT_HOIAN_OPEN_03_GROUP', 'KH_12', NULL, 'NGUOI_DAT', 4750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_NDH1', 'DDT_HOIAN_OPEN_03_GROUP', NULL, 'NDH_HOIAN_OPEN_03_01', 'NGUOI_DONG_HANH', 4750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_NDH2', 'DDT_HOIAN_OPEN_03_GROUP', NULL, 'NDH_HOIAN_OPEN_03_02', 'NGUOI_DONG_HANH', 4750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_NDH3', 'DDT_HOIAN_OPEN_03_GROUP', NULL, 'NDH_HOIAN_OPEN_03_03', 'NGUOI_DONG_HANH', 4750000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HOIAN_OPEN_03_DINNER', 'DDT_HOIAN_OPEN_03_GROUP', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HOIAN_OPEN_03_PAY', 'DDT_HOIAN_OPEN_03_GROUP', 'THANH_TOAN', 'VI_DIEN_TU', 19300000, 'BANK-OPEN-0308', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HALONG_OPEN_03_COUPLE', 'TTT_HALONG_OPEN_03', 'KH_13', NOW() - INTERVAL 2 DAY, 13200000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch cáº§n phÃ²ng yÃªn tÄ©nh vÃ  gÃ³i áº£nh trÃªn du thuyá»n.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HALONG_OPEN_03_01', 'DDT_HALONG_OPEN_03_COUPLE', 'DÆ°Æ¡ng HoÃ i Nam', '022087030128', '0903000128', '1987-06-06', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HALONG_OPEN_03_KH', 'DDT_HALONG_OPEN_03_COUPLE', 'KH_13', NULL, 'NGUOI_DAT', 6150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HALONG_OPEN_03_NDH1', 'DDT_HALONG_OPEN_03_COUPLE', NULL, 'NDH_HALONG_OPEN_03_01', 'NGUOI_DONG_HANH', 6150000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HALONG_OPEN_03_PHOTO', 'DDT_HALONG_OPEN_03_COUPLE', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HALONG_OPEN_03_PAY', 'DDT_HALONG_OPEN_03_COUPLE', 'THANH_TOAN', 'THE_QUOC_TE', 13200000, 'BANK-OPEN-0309', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_CANTHO_OPEN_03_FAMILY', 'TTT_CANTHO_OPEN_03', 'KH_14', NOW() - INTERVAL 2 DAY, 12150000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Gia Ä‘Ã¬nh ba khÃ¡ch cÃ³ tráº» nhá», cáº§n mÃ³n khÃ´ng trá»©ng gÃ .', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_CANTHO_OPEN_03_01', 'DDT_CANTHO_OPEN_03_FAMILY', 'LÃ¢m Minh PhÃºc', '092088030129', '0903000129', '1988-05-03', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_CANTHO_OPEN_03_02', 'DDT_CANTHO_OPEN_03_FAMILY', 'LÃ¢m Gia HÃ¢n', '092019030130', '0903000130', '2019-03-15', 'Ná»¯', 'Tráº» em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CANTHO_OPEN_03_KH', 'DDT_CANTHO_OPEN_03_FAMILY', 'KH_14', NULL, 'NGUOI_DAT', 3950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CANTHO_OPEN_03_NDH1', 'DDT_CANTHO_OPEN_03_FAMILY', NULL, 'NDH_CANTHO_OPEN_03_01', 'NGUOI_DONG_HANH', 3950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CANTHO_OPEN_03_NDH2', 'DDT_CANTHO_OPEN_03_FAMILY', NULL, 'NDH_CANTHO_OPEN_03_02', 'NGUOI_DONG_HANH', 3950000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_CANTHO_OPEN_03_DINNER', 'DDT_CANTHO_OPEN_03_FAMILY', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_CANTHO_OPEN_03_PAY', 'DDT_CANTHO_OPEN_03_FAMILY', 'THANH_TOAN', 'CHUYEN_KHOAN', 12150000, 'BANK-OPEN-0310', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_CONDAO_OPEN_03_COUPLE', 'TTT_CONDAO_OPEN_03', 'KH_15', NOW() - INTERVAL 2 DAY, 17820000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch nghá»‰ dÆ°á»¡ng biá»ƒn Ä‘áº£o, Ä‘Äƒng kÃ½ báº£o hiá»ƒm vÃ  hoáº¡t Ä‘á»™ng lÃ m sáº¡ch bÃ£i biá»ƒn.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_CONDAO_OPEN_03_01', 'DDT_CONDAO_OPEN_03_COUPLE', 'Há»“ Minh QuÃ¢n', '095090030131', '0903000131', '1990-11-20', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CONDAO_OPEN_03_KH', 'DDT_CONDAO_OPEN_03_COUPLE', 'KH_15', NULL, 'NGUOI_DAT', 8850000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CONDAO_OPEN_03_NDH1', 'DDT_CONDAO_OPEN_03_COUPLE', NULL, 'NDH_CONDAO_OPEN_03_01', 'NGUOI_DONG_HANH', 8850000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_CONDAO_OPEN_03_INS', 'DDT_CONDAO_OPEN_03_COUPLE', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_CONDAO_OPEN_03_PAY', 'DDT_CONDAO_OPEN_03_COUPLE', 'THANH_TOAN', 'VI_DIEN_TU', 17820000, 'BANK-OPEN-0311', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_MOCCHAU_OPEN_03_COUPLE', 'TTT_MOCCHAU_OPEN_03', 'KH_01', NOW() - INTERVAL 1 DAY, 6800000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch Ä‘i ngáº¯m mÃ¹a hoa, Ä‘áº·t gÃ³i áº£nh hÃ nh trÃ¬nh.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_MOCCHAU_OPEN_03_01', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'Tráº§n Minh HoÃ ng', '014086030132', '0903000132', '1986-09-09', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MOCCHAU_OPEN_03_KH', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'KH_01', NULL, 'NGUOI_DAT', 2950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MOCCHAU_OPEN_03_NDH1', 'DDT_MOCCHAU_OPEN_03_COUPLE', NULL, 'NDH_MOCCHAU_OPEN_03_01', 'NGUOI_DONG_HANH', 2950000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_MOCCHAU_OPEN_03_PHOTO', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_MOCCHAU_OPEN_03_PAY', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'THANH_TOAN', 'THE_NOI_DIA', 6800000, 'BANK-OPEN-0312', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_QUYNHON_OPEN_03_TEAM', 'TTT_QUYNHON_OPEN_03', 'KH_02', NOW() - INTERVAL 1 DAY, 17650000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khÃ¡ch Ä‘i biá»ƒn, cáº§n Ä‘Æ°a Ä‘Ã³n sÃ¢n bay PhÃ¹ CÃ¡t.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_QUYNHON_OPEN_03_01', 'DDT_QUYNHON_OPEN_03_TEAM', 'LÃª HoÃ ng Duy', '052091030133', '0903000133', '1991-02-02', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_QUYNHON_OPEN_03_02', 'DDT_QUYNHON_OPEN_03_TEAM', 'LÃª Ngá»c Ãnh', '052094030134', '0903000134', '1994-08-08', 'Ná»¯', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_QUYNHON_OPEN_03_KH', 'DDT_QUYNHON_OPEN_03_TEAM', 'KH_02', NULL, 'NGUOI_DAT', 5750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_QUYNHON_OPEN_03_NDH1', 'DDT_QUYNHON_OPEN_03_TEAM', NULL, 'NDH_QUYNHON_OPEN_03_01', 'NGUOI_DONG_HANH', 5750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_QUYNHON_OPEN_03_NDH2', 'DDT_QUYNHON_OPEN_03_TEAM', NULL, 'NDH_QUYNHON_OPEN_03_02', 'NGUOI_DONG_HANH', 5750000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_QUYNHON_OPEN_03_AIRPORT', 'DDT_QUYNHON_OPEN_03_TEAM', 'DVT_AIRPORT', 1, 400000, 400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_QUYNHON_OPEN_03_PAY', 'DDT_QUYNHON_OPEN_03_TEAM', 'THANH_TOAN', 'CHUYEN_KHOAN', 17650000, 'BANK-OPEN-0313', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_BMT_OPEN_03_COUPLE', 'TTT_BUONMATHUOT_OPEN_03', 'KH_03', NOW() - INTERVAL 1 DAY, 8720000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch yÃªu cÃ  phÃª, Ä‘Äƒng kÃ½ báº£o hiá»ƒm du lá»‹ch.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_BMT_OPEN_03_01', 'DDT_BMT_OPEN_03_COUPLE', 'Phan Anh Tuáº¥n', '066090030135', '0903000135', '1990-01-28', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_BMT_OPEN_03_KH', 'DDT_BMT_OPEN_03_COUPLE', 'KH_03', NULL, 'NGUOI_DAT', 4300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_BMT_OPEN_03_NDH1', 'DDT_BMT_OPEN_03_COUPLE', NULL, 'NDH_BMT_OPEN_03_01', 'NGUOI_DONG_HANH', 4300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_BMT_OPEN_03_INS', 'DDT_BMT_OPEN_03_COUPLE', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_BMT_OPEN_03_PAY', 'DDT_BMT_OPEN_03_COUPLE', 'THANH_TOAN', 'VI_DIEN_TU', 8720000, 'BANK-OPEN-0314', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_PULUONG_OPEN_03_FAMILY', 'TTT_PULUONG_OPEN_03', 'KH_04', NOW() - INTERVAL 1 DAY, 14700000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Bá»‘n khÃ¡ch nghá»‰ dÆ°á»¡ng sinh thÃ¡i, cáº§n phÃ²ng táº§ng tháº¥p cho ngÆ°á»i lá»›n tuá»•i.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PULUONG_OPEN_03_01', 'DDT_PULUONG_OPEN_03_FAMILY', 'VÅ© Minh SÆ¡n', '038083030136', '0903000136', '1983-03-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PULUONG_OPEN_03_02', 'DDT_PULUONG_OPEN_03_FAMILY', 'VÅ© Tháº£o Vy', '038012030137', '0903000137', '2012-12-12', 'Ná»¯', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PULUONG_OPEN_03_03', 'DDT_PULUONG_OPEN_03_FAMILY', 'VÅ© Háº£i ÄÄƒng', '038015030138', '0903000138', '2015-04-04', 'NAM', 'Tráº» em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_KH', 'DDT_PULUONG_OPEN_03_FAMILY', 'KH_04', NULL, 'NGUOI_DAT', 3450000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_NDH1', 'DDT_PULUONG_OPEN_03_FAMILY', NULL, 'NDH_PULUONG_OPEN_03_01', 'NGUOI_DONG_HANH', 3450000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_NDH2', 'DDT_PULUONG_OPEN_03_FAMILY', NULL, 'NDH_PULUONG_OPEN_03_02', 'NGUOI_DONG_HANH', 3450000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_NDH3', 'DDT_PULUONG_OPEN_03_FAMILY', NULL, 'NDH_PULUONG_OPEN_03_03', 'NGUOI_DONG_HANH', 3450000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_PULUONG_OPEN_03_PHOTO', 'DDT_PULUONG_OPEN_03_FAMILY', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_PULUONG_OPEN_03_PAY', 'DDT_PULUONG_OPEN_03_FAMILY', 'THANH_TOAN', 'CHUYEN_KHOAN', 14700000, 'BANK-OPEN-0315', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_MUINE_OPEN_03_TEAM', 'TTT_MUINE_OPEN_03', 'KH_05', NOW() - INTERVAL 1 DAY, 15700000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khÃ¡ch nghá»‰ dÆ°á»¡ng MÅ©i NÃ©, cáº§n xe Ä‘Æ°a Ä‘Ã³n tá»« ga Phan Thiáº¿t.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_MUINE_OPEN_03_01', 'DDT_MUINE_OPEN_03_TEAM', 'Äáº·ng Quang Huy', '060088030139', '0903000139', '1988-08-13', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_MUINE_OPEN_03_02', 'DDT_MUINE_OPEN_03_TEAM', 'Äáº·ng Ngá»c TrÃ¢m', '060091030140', '0903000140', '1991-06-25', 'Ná»¯', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MUINE_OPEN_03_KH', 'DDT_MUINE_OPEN_03_TEAM', 'KH_05', NULL, 'NGUOI_DAT', 5100000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MUINE_OPEN_03_NDH1', 'DDT_MUINE_OPEN_03_TEAM', NULL, 'NDH_MUINE_OPEN_03_01', 'NGUOI_DONG_HANH', 5100000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MUINE_OPEN_03_NDH2', 'DDT_MUINE_OPEN_03_TEAM', NULL, 'NDH_MUINE_OPEN_03_02', 'NGUOI_DONG_HANH', 5100000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_MUINE_OPEN_03_AIRPORT', 'DDT_MUINE_OPEN_03_TEAM', 'DVT_AIRPORT', 1, 400000, 400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_MUINE_OPEN_03_PAY', 'DDT_MUINE_OPEN_03_TEAM', 'THANH_TOAN', 'THE_QUOC_TE', 15700000, 'BANK-OPEN-0316', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_SAPA_OPEN_04_COUPLE', 'TTT_SAPA_OPEN_04', 'KH_06', NOW() - INTERVAL 1 DAY, 10700000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch Ä‘áº·t phá»¥ thu phÃ²ng Ä‘Æ¡n do lá»‹ch ngá»§ khÃ¡c nhau.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_OPEN_04_01', 'DDT_SAPA_OPEN_04_COUPLE', 'BÃ¹i Minh An', '001095030141', '0903000141', '1995-10-10', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_OPEN_04_KH', 'DDT_SAPA_OPEN_04_COUPLE', 'KH_06', NULL, 'NGUOI_DAT', 5050000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_OPEN_04_NDH1', 'DDT_SAPA_OPEN_04_COUPLE', NULL, 'NDH_SAPA_OPEN_04_01', 'NGUOI_DONG_HANH', 5050000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_SAPA_OPEN_04_SINGLE', 'DDT_SAPA_OPEN_04_COUPLE', 'DVT_SINGLE', 1, 600000, 600000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_SAPA_OPEN_04_PAY', 'DDT_SAPA_OPEN_04_COUPLE', 'THANH_TOAN', 'CHUYEN_KHOAN', 10700000, 'BANK-OPEN-0317', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_DANANG_OPEN_04_TEAM', 'TTT_DANANG_OPEN_04', 'KH_07', NOW() - INTERVAL 1 DAY, 21000000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khÃ¡ch Ä‘i miá»n Trung, Ä‘áº·t thÃªm bá»¯a tá»‘i phá»‘ cá»•.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_04_01', 'DDT_DANANG_OPEN_04_TEAM', 'Táº¡ KhÃ¡nh Duy', '048092030142', '0903000142', '1992-12-12', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_04_02', 'DDT_DANANG_OPEN_04_TEAM', 'Táº¡ Há»“ng Nhung', '048094030143', '0903000143', '1994-03-18', 'Ná»¯', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_04_KH', 'DDT_DANANG_OPEN_04_TEAM', 'KH_07', NULL, 'NGUOI_DAT', 6900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_04_NDH1', 'DDT_DANANG_OPEN_04_TEAM', NULL, 'NDH_DANANG_OPEN_04_01', 'NGUOI_DONG_HANH', 6900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_04_NDH2', 'DDT_DANANG_OPEN_04_TEAM', NULL, 'NDH_DANANG_OPEN_04_02', 'NGUOI_DONG_HANH', 6900000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_DANANG_OPEN_04_DINNER', 'DDT_DANANG_OPEN_04_TEAM', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_DANANG_OPEN_04_PAY', 'DDT_DANANG_OPEN_04_TEAM', 'THANH_TOAN', 'VI_DIEN_TU', 21000000, 'BANK-OPEN-0318', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_PHUQUOC_OPEN_04_COUPLE', 'TTT_PHUQUOC_OPEN_04', 'KH_08', NOW() - INTERVAL 1 DAY, 16820000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khÃ¡ch cÃ³ ngÆ°á»i cao tuá»•i, Ä‘Äƒng kÃ½ báº£o hiá»ƒm vÃ  phÃ²ng gáº§n thang mÃ¡y.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_04_01', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'ÄoÃ n Thá»‹ Háº¡nh', '091060030144', '0903000144', '1960-07-07', 'Ná»¯', 'NgÆ°á»i cao tuá»•i');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_04_KH', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'KH_08', NULL, 'NGUOI_DAT', 8350000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_04_NDH1', 'DDT_PHUQUOC_OPEN_04_COUPLE', NULL, 'NDH_PHUQUOC_OPEN_04_01', 'NGUOI_DONG_HANH', 8350000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_PHUQUOC_OPEN_04_INS', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_PHUQUOC_OPEN_04_PAY', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'THANH_TOAN', 'THE_NOI_DIA', 16820000, 'BANK-OPEN-0319', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HUE_OPEN_04_SOLO', 'TTT_HUE_OPEN_04', 'KH_09', NOW() - INTERVAL 1 DAY, 5300000, 'CHO_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'KhÃ¡ch láº» cáº§n xuáº¥t hÃ³a Ä‘Æ¡n cÃ´ng ty, giá»¯ chá»— chá» xÃ¡c nháº­n chuyá»ƒn khoáº£n.', 'HDX_LOCAL:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_OPEN_04_KH', 'DDT_HUE_OPEN_04_SOLO', 'KH_09', NULL, 'NGUOI_DAT', 4650000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HUE_OPEN_04_SINGLE', 'DDT_HUE_OPEN_04_SOLO', 'DVT_SINGLE', 1, 650000, 650000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HUE_OPEN_04_WAIT', 'DDT_HUE_OPEN_04_SOLO', 'THANH_TOAN', 'CHUYEN_KHOAN', 5300000, 'BANK-OPEN-0320', 'CHO_THANH_TOAN', NULL);

-- Dich vu va hanh dong xanh ca nhan hoa theo tinh chat tung tuyen mo ban.
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_SAPA_HERBAL', 'Táº¯m lÃ¡ thuá»‘c Dao Ä‘á» táº¡i Sa Pa', 'KhÃ¡ch', 320000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_DANANG_SHOW', 'VÃ© show KÃ½ á»©c Há»™i An', 'VÃ©', 650000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_DALAT_FARM', 'Workshop hÃ¡i rau vÃ  pha cÃ  phÃª ÄÃ  Láº¡t', 'KhÃ¡ch', 380000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_NINHBINH_BIKE', 'ThuÃª xe Ä‘áº¡p khÃ¡m phÃ¡ Tam Cá»‘c', 'Xe/ngÃ y', 120000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_PHUQUOC_SNORKEL', 'Láº·n ngáº¯m san hÃ´ báº±ng tÃ u riÃªng PhÃº Quá»‘c', 'KhÃ¡ch', 950000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HAGIANG_MOTOR', 'Xe mÃ¡y cÃ³ lÃ¡i báº£n Ä‘á»‹a cung HÃ  Giang', 'KhÃ¡ch/ngÃ y', 700000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HOIAN_LANTERN', 'Lá»›p lÃ m Ä‘Ã¨n lá»“ng Há»™i An', 'KhÃ¡ch', 280000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HALONG_KAYAK', 'ChÃ¨o kayak vá»‹nh Háº¡ Long', 'KhÃ¡ch', 300000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_CANTHO_COOKING', 'Lá»›p náº¥u mÃ³n miá»n TÃ¢y táº¡i Cáº§n ThÆ¡', 'KhÃ¡ch', 360000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_CONDAO_TURTLE', 'Tráº£i nghiá»‡m báº£o tá»“n rÃ¹a biá»ƒn CÃ´n Äáº£o', 'KhÃ¡ch', 520000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_MOCCHAU_TEA', 'Tráº£i nghiá»‡m hÃ¡i chÃ¨ Má»™c ChÃ¢u', 'KhÃ¡ch', 220000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_QUYNHON_CANOE', 'Cano Ká»³ Co - HÃ²n KhÃ´ riÃªng', 'KhÃ¡ch', 680000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_BMT_COFFEE', 'Workshop rang xay cÃ  phÃª BuÃ´n Ma Thuá»™t', 'KhÃ¡ch', 340000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_PULUONG_HOMESTAY', 'NÃ¢ng háº¡ng homestay view ruá»™ng báº­c thang', 'PhÃ²ng/Ä‘Ãªm', 480000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_MUINE_JEEP', 'Jeep riÃªng ngáº¯m bÃ¬nh minh Ä‘á»“i cÃ¡t MÅ©i NÃ©', 'Xe', 750000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HUE_AODAI', 'ThuÃª Ã¡o dÃ i chá»¥p áº£nh Äáº¡i Ná»™i Huáº¿', 'Bá»™', 250000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_REFILL', 'DÃ¹ng tráº¡m tiáº¿p nÆ°á»›c thay chai nhá»±a dÃ¹ng má»™t láº§n', 90);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_REUSABLE_BAG', 'Mang tÃºi váº£i khi mua Ä‘áº·c sáº£n Ä‘á»‹a phÆ°Æ¡ng', 70);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_LOCAL_MEAL', 'Chá»n bá»¯a Äƒn nguyÃªn liá»‡u Ä‘á»‹a phÆ°Æ¡ng theo mÃ¹a', 120);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_PUBLIC_TRANSFER', 'Æ¯u tiÃªn xe ghÃ©p hoáº·c phÆ°Æ¡ng tiá»‡n cÃ´ng cá»™ng trong cháº·ng ngáº¯n', 110);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_CORAL_SAFE', 'KhÃ´ng cháº¡m san hÃ´ vÃ  dÃ¹ng kem chá»‘ng náº¯ng thÃ¢n thiá»‡n biá»ƒn', 160);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_COMMUNITY_BUY', 'Mua sáº£n pháº©m thá»§ cÃ´ng trá»±c tiáº¿p tá»« cá»™ng Ä‘á»“ng báº£n Ä‘á»‹a', 130);

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_OPEN_03', 'DVT_SAPA_HERBAL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DANANG_OPEN_03', 'DVT_DANANG_SHOW');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DALAT_OPEN_03', 'DVT_DALAT_FARM');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_NINHBINH_OPEN_03', 'DVT_NINHBINH_BIKE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PHUQUOC_OPEN_03', 'DVT_PHUQUOC_SNORKEL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUE_OPEN_03', 'DVT_HUE_AODAI');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HAGIANG_OPEN_03', 'DVT_HAGIANG_MOTOR');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HOIAN_OPEN_03', 'DVT_HOIAN_LANTERN');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HALONG_OPEN_03', 'DVT_HALONG_KAYAK');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CANTHO_OPEN_03', 'DVT_CANTHO_COOKING');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_CONDAO_OPEN_03', 'DVT_CONDAO_TURTLE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MOCCHAU_OPEN_03', 'DVT_MOCCHAU_TEA');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_QUYNHON_OPEN_03', 'DVT_QUYNHON_CANOE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BUONMATHUOT_OPEN_03', 'DVT_BMT_COFFEE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PULUONG_OPEN_03', 'DVT_PULUONG_HOMESTAY');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MUINE_OPEN_03', 'DVT_MUINE_JEEP');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_OPEN_04', 'DVT_SAPA_HERBAL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DANANG_OPEN_04', 'DVT_DANANG_SHOW');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PHUQUOC_OPEN_04', 'DVT_PHUQUOC_SNORKEL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUE_OPEN_04', 'DVT_HUE_AODAI');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_SAPA_OPEN_03', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DANANG_OPEN_03', 'HDX_PUBLIC_TRANSFER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DALAT_OPEN_03', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_NINHBINH_OPEN_03', 'HDX_PUBLIC_TRANSFER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PHUQUOC_OPEN_03', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HUE_OPEN_03', 'HDX_REUSABLE_BAG');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HAGIANG_OPEN_03', 'HDX_COMMUNITY_BUY');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HOIAN_OPEN_03', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HALONG_OPEN_03', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CANTHO_OPEN_03', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_CONDAO_OPEN_03', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MOCCHAU_OPEN_03', 'HDX_COMMUNITY_BUY');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_QUYNHON_OPEN_03', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BUONMATHUOT_OPEN_03', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PULUONG_OPEN_03', 'HDX_COMMUNITY_BUY');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MUINE_OPEN_03', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_SAPA_OPEN_04', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DANANG_OPEN_04', 'HDX_PUBLIC_TRANSFER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PHUQUOC_OPEN_04', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HUE_OPEN_04', 'HDX_REUSABLE_BAG');

-- ------------------------------------------------------------
-- 10 TOUR MO BAN CO DINH TRONG NAM 2026 - DAY DU DON, KHACH, HDV VA THANH TOAN
-- Cac tour mau duoi day da co lich trinh va danh gia tu cac dot da ket thuc o tren.
-- Tour dang MO_BAN khong duoc gan danh_gia_khs truc tiep vi chua phat sinh lich su tham gia.
-- ------------------------------------------------------------
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_SAPA_JUL', 'TM_SAPA', '2026-07-16', 4950000, 28, 10, 28, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_DANANG_JUL', 'TM_DANANG', '2026-07-30', 6750000, 32, 12, 32, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_PHUQUOC_AUG', 'TM_PHUQUOC', '2026-08-13', 8150000, 28, 10, 28, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_HUE_AUG', 'TM_HUE', '2026-08-27', 4550000, 26, 8, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_HOIAN_SEP', 'TM_HOIAN', '2026-09-10', 4750000, 28, 10, 28, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_HALONG_SEP', 'TM_HALONG', '2026-09-24', 6150000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_CANTHO_OCT', 'TM_CANTHO', '2026-10-15', 3950000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_MUINE_NOV', 'TM_MUINE', '2026-11-05', 5100000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_SAPA_NOV', 'TM_SAPA', '2026-11-19', 5050000, 28, 10, 28, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_DANANG_DEC', 'TM_DANANG', '2026-12-10', 6900000, 34, 12, 34, 'MO_BAN');

-- Moi dot mo ban co dich vu bo sung va hanh dong xanh phu hop tuyen.
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_SAPA_JUL', 'DVT_SAPA_HERBAL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_DANANG_JUL', 'DVT_DANANG_SHOW');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_PHUQUOC_AUG', 'DVT_PHUQUOC_SNORKEL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_HUE_AUG', 'DVT_HUE_AODAI');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_HOIAN_SEP', 'DVT_HOIAN_LANTERN');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_HALONG_SEP', 'DVT_HALONG_KAYAK');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_CANTHO_OCT', 'DVT_CANTHO_COOKING');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_MUINE_NOV', 'DVT_MUINE_JEEP');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_SAPA_NOV', 'DVT_SAPA_HERBAL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_DANANG_DEC', 'DVT_DANANG_SHOW');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_SAPA_JUL', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_DANANG_JUL', 'HDX_PUBLIC_TRANSFER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_PHUQUOC_AUG', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_HUE_AUG', 'HDX_REUSABLE_BAG');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_HOIAN_SEP', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_HALONG_SEP', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_CANTHO_OCT', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_MUINE_NOV', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_SAPA_NOV', 'HDX_COMMUNITY_BUY');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_DANANG_DEC', 'HDX_PUBLIC_TRANSFER');

-- HDV da chap nhan; lich khoi hanh cach nhau de khong vi pham trung lich.
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_SAPA_JUL_HDV03', 'TTT_26_SAPA_JUL', 'NV_HDV03', '2026-05-18 09:00:00', 'DA_DONG_Y', '2026-05-18 14:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_DANANG_JUL_HDV04', 'TTT_26_DANANG_JUL', 'NV_HDV04', '2026-05-18 09:15:00', 'DA_DONG_Y', '2026-05-18 15:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_PHUQUOC_AUG_HDV09', 'TTT_26_PHUQUOC_AUG', 'NV_HDV09', '2026-05-19 08:00:00', 'DA_DONG_Y', '2026-05-19 11:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_HUE_AUG_HDV06', 'TTT_26_HUE_AUG', 'NV_HDV06', '2026-05-19 08:20:00', 'DA_DONG_Y', '2026-05-19 12:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_HOIAN_SEP_HDV04', 'TTT_26_HOIAN_SEP', 'NV_HDV04', '2026-05-20 08:00:00', 'DA_DONG_Y', '2026-05-20 10:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_HALONG_SEP_HDV05', 'TTT_26_HALONG_SEP', 'NV_HDV05', '2026-05-20 09:00:00', 'DA_DONG_Y', '2026-05-20 13:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_CANTHO_OCT_HDV10', 'TTT_26_CANTHO_OCT', 'NV_HDV10', '2026-05-21 09:00:00', 'DA_DONG_Y', '2026-05-21 13:30:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_MUINE_NOV_HDV05', 'TTT_26_MUINE_NOV', 'NV_HDV05', '2026-05-22 08:00:00', 'DA_DONG_Y', '2026-05-22 11:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_SAPA_NOV_HDV03', 'TTT_26_SAPA_NOV', 'NV_HDV03', '2026-05-22 09:00:00', 'DA_DONG_Y', '2026-05-22 13:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_DANANG_DEC_HDV04', 'TTT_26_DANANG_DEC', 'NV_HDV04', '2026-05-23 09:00:00', 'DA_DONG_Y', '2026-05-23 12:00:00');

-- Tao hai don co thong tin hanh khach, dich vu va giao dich hoan tat cho moi tour 2026.;

-- ------------------------------------------------------------
-- Bá»˜ Dá»® LIá»†U NGHIá»†P Vá»¤ Äáº¦Y Äá»¦ CHO HAI HÆ¯á»šNG DáºªN VIÃŠN Má»šI
-- CÃ¡c tour máº«u Ä‘Æ°á»£c sá»­ dá»¥ng bÃªn dÆ°á»›i Ä‘Ã£ cÃ³ lá»‹ch trÃ¬nh tá»«ng ngÃ y Ä‘áº§y Ä‘á»§.
-- Má»—i HDV cÃ³ má»™t chuyáº¿n Ä‘Ã£ quyáº¿t toÃ¡n vÃ  má»™t chuyáº¿n sáº¯p khá»Ÿi hÃ nh.
-- ------------------------------------------------------------
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_H11_QUYNHON_LS', 'TM_QUYNHON', '2026-05-06', 5650000, 22, 6, 22, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_H12_CANTHO_LS', 'TM_CANTHO', '2026-05-12', 4050000, 24, 6, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_H11_HUE_SKH', 'TM_HUE', '2026-06-18', 4720000, 26, 8, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_H12_CANTHO_SKH', 'TM_CANTHO', '2026-06-25', 4120000, 28, 8, 28, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_H11_QUYNHON_LS', 'DVT_QUYNHON_CANOE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_H12_CANTHO_LS', 'DVT_CANTHO_COOKING');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_H11_HUE_SKH', 'DVT_HUE_AODAI');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_H12_CANTHO_SKH', 'DVT_CANTHO_COOKING');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_H11_QUYNHON_LS', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_H12_CANTHO_LS', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_H11_HUE_SKH', 'HDX_REUSABLE_BAG');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_H12_CANTHO_SKH', 'HDX_LOCAL_MEAL');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_H11_QUYNHON_LS', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', '2026-04-14 09:00:00', 'DA_DONG_Y', '2026-04-14 13:40:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_H12_CANTHO_LS', 'TTT_H12_CANTHO_LS', 'NV_HDV12', '2026-04-20 08:30:00', 'DA_DONG_Y', '2026-04-20 11:20:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_H11_HUE_SKH', 'TTT_H11_HUE_SKH', 'NV_HDV11', '2026-05-20 09:10:00', 'DA_DONG_Y', '2026-05-20 15:10:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_H12_CANTHO_SKH', 'TTT_H12_CANTHO_SKH', 'NV_HDV12', '2026-05-21 08:45:00', 'DA_DONG_Y', '2026-05-21 14:00:00');

-- Táº¡o Ä‘Æ¡n, danh sÃ¡ch hÃ nh khÃ¡ch, dá»‹ch vá»¥ bá»• sung vÃ  giao dá»‹ch Ä‘Ã£ thanh toÃ¡n.;

-- Sau khi Ä‘á»§ Ä‘oÃ n vÃ  Ä‘Ã£ thanh toÃ¡n, cÃ¡c chuyáº¿n tÆ°Æ¡ng lai váº«n á»Ÿ tráº¡ng thÃ¡i má»Ÿ bÃ¡n há»£p lá»‡;
-- mÃ n hÃ¬nh sáº¯p khá»Ÿi hÃ nh lá»c theo ngÃ y khá»Ÿi hÃ nh gáº§n vÃ  phÃ¢n cÃ´ng HDV.
UPDATE tour_thuc_tes SET trang_thai = 'MO_BAN' WHERE ma_tour_thuc_te IN ('TTT_H11_HUE_SKH', 'TTT_H12_CANTHO_SKH');

-- Hai chuyáº¿n lá»‹ch sá»­ chuyá»ƒn sang giai Ä‘oáº¡n váº­n hÃ nh Ä‘á»ƒ ghi nháº­n Ä‘iá»ƒm danh vÃ  hÃ nh Ä‘á»™ng xanh.
UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA' WHERE ma_tour_thuc_te IN ('TTT_H11_QUYNHON_LS', 'TTT_H12_CANTHO_LS');

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
SELECT 'DD_' || SUBSTR(ct.ma_chi_tiet_dat, 6), d.ma_tour_thuc_te, ct.ma_khach_hang, ct.ma_nguoi_dong_hanh, ct.loai_khach,
       CASE d.ma_tour_thuc_te WHEN 'TTT_H11_QUYNHON_LS' THEN 'NV_HDV11' ELSE 'NV_HDV12' END,
       CASE d.ma_tour_thuc_te WHEN 'TTT_H11_QUYNHON_LS' THEN '2026-05-06 07:10:00' ELSE '2026-05-12 05:20:00' END,
       CASE d.ma_tour_thuc_te WHEN 'TTT_H11_QUYNHON_LS' THEN 'Äiá»ƒm Ä‘Ã³n trung tÃ¢m Quy NhÆ¡n' ELSE 'Báº¿n Ninh Kiá»u, Cáº§n ThÆ¡' END,
       'DA_DIEM_DANH'
FROM chi_tiet_dat_tours ct
JOIN don_dat_tours d ON d.ma_dat_tour = ct.ma_dat_tour
WHERE d.ma_tour_thuc_te IN ('TTT_H11_QUYNHON_LS', 'TTT_H12_CANTHO_LS');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H11QN_KH01', 'TTT_H11_QUYNHON_LS', 'KH_01', 'HDX_CORAL_SAFE', 'NV_HDV11', '2026-05-07 10:00:00', 'Gia Ä‘Ã¬nh sá»­ dá»¥ng kem chá»‘ng náº¯ng thÃ¢n thiá»‡n biá»ƒn vÃ  tuÃ¢n thá»§ hÆ°á»›ng dáº«n khi Ä‘i ca nÃ´.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H11QN_KH02', 'TTT_H11_QUYNHON_LS', 'KH_02', 'HDX_CORAL_SAFE', 'NV_HDV11', '2026-05-07 10:15:00', 'NhÃ³m khÃ¡ch khÃ´ng cháº¡m san hÃ´, thu gom váº­t dá»¥ng cÃ¡ nhÃ¢n sau hoáº¡t Ä‘á»™ng biá»ƒn.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H12CT_KH03', 'TTT_H12_CANTHO_LS', 'KH_03', 'HDX_LOCAL_MEAL', 'NV_HDV12', '2026-05-13 11:30:00', 'ÄoÃ n lá»±a chá»n bá»¯a trÆ°a sá»­ dá»¥ng nguyÃªn liá»‡u theo mÃ¹a tá»« nhÃ  vÆ°á»n Ä‘á»‹a phÆ°Æ¡ng.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H12CT_KH04', 'TTT_H12_CANTHO_LS', 'KH_04', 'HDX_LOCAL_MEAL', 'NV_HDV12', '2026-05-13 11:40:00', 'NhÃ³m khÃ¡ch dÃ¹ng bá»¯a táº¡i há»™ dÃ¢n vÃ  mua sáº£n pháº©m Ä‘á»‹a phÆ°Æ¡ng cÃ³ bao bÃ¬ tÃ¡i sá»­ dá»¥ng.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_H11QN_SONG', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'Biá»ƒn cÃ³ sÃ³ng nháº¹ vÃ o Ä‘áº§u giá» chiá»u táº¡i khu vá»±c Ká»³ Co.',
        'Äiá»u chá»‰nh hoáº¡t Ä‘á»™ng ca nÃ´ sang khung giá» an toÃ n vÃ  phá»• biáº¿n láº¡i quy Ä‘á»‹nh Ã¡o phao cho cáº£ Ä‘oÃ n.', 'THAP', 'THOI_TIET', '2026-05-07 12:30:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_H12CT_BEN', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Báº¿n Ä‘Ã³n chá»£ ná»•i thay Ä‘á»•i vá»‹ trÃ­ do má»±c nÆ°á»›c lÃªn sá»›m.',
        'ThÃ´ng bÃ¡o trÆ°á»›c cho Ä‘oÃ n, bá»‘ trÃ­ xe trung chuyá»ƒn ngáº¯n vÃ  kiá»ƒm Ä‘áº¿m Ä‘áº§y Ä‘á»§ khÃ¡ch trÆ°á»›c khi xuá»‘ng thuyá»n.', 'THAP', 'PHUONG_TIEN', '2026-05-13 05:10:00');

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te IN ('TTT_H11_QUYNHON_LS', 'TTT_H12_CANTHO_LS');

-- Chi phÃ­ Ä‘Æ°á»£c HDV kÃª khai vÃ  duyá»‡t trÆ°á»›c khi káº¿ toÃ¡n láº­p quyáº¿t toÃ¡n.
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H11QN_XE', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'Xe Ä‘Æ°a Ä‘Ã³n sÃ¢n bay PhÃ¹ CÃ¡t vÃ  ná»™i thÃ nh', 5400000, 'https://seed.local/hoa-don/quynhon-xe-dua-don.jpg', 'DA_DUYET', '2026-05-09 09:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H11QN_KS', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'KhÃ¡ch sáº¡n Quy NhÆ¡n hai Ä‘Ãªm cho Ä‘oÃ n', 12600000, 'https://seed.local/hoa-don/quynhon-khach-san.jpg', 'DA_DUYET', '2026-05-09 09:20:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H11QN_VE', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'VÃ© tham quan vÃ  báº£o hiá»ƒm hoáº¡t Ä‘á»™ng biá»ƒn', 3280000, 'https://seed.local/hoa-don/quynhon-ve-tham-quan.jpg', 'DA_DUYET', '2026-05-09 09:40:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H12CT_TAU', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Thuyá»n tham quan chá»£ ná»•i CÃ¡i RÄƒng', 3600000, 'https://seed.local/hoa-don/cantho-thuyen.jpg', 'DA_DUYET', '2026-05-15 08:10:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H12CT_KS', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'KhÃ¡ch sáº¡n Cáº§n ThÆ¡ hai Ä‘Ãªm cho Ä‘oÃ n', 8900000, 'https://seed.local/hoa-don/cantho-khach-san.jpg', 'DA_DUYET', '2026-05-15 08:30:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H12CT_AN', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Bá»¯a Äƒn miá»‡t vÆ°á»n vÃ  nguyÃªn liá»‡u lá»›p náº¥u Äƒn', 4300000, 'https://seed.local/hoa-don/cantho-am-thuc.jpg', 'DA_DUYET', '2026-05-15 08:50:00');

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_H11QN_HOANTAT', 'TTT_H11_QUYNHON_LS', 0, 0, 45500000, 0, 'NV_KT01', '2026-05-11 10:00:00', 'DA_QUYET_TOAN',
        'Káº¿ toÃ¡n Ä‘Ã£ Ä‘á»‘i chiáº¿u giao dá»‹ch, hÃ³a Ä‘Æ¡n váº­n hÃ nh vÃ  xÃ¡c nháº­n hoÃ n táº¥t quyáº¿t toÃ¡n chuyáº¿n Quy NhÆ¡n do hÆ°á»›ng dáº«n viÃªn VÃµ Thuá»³ DÆ°Æ¡ng phá»¥ trÃ¡ch.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_H12CT_HOANTAT', 'TTT_H12_CANTHO_LS', 0, 0, 33500000, 0, 'NV_KT01', '2026-05-17 10:30:00', 'DA_QUYET_TOAN',
        'Káº¿ toÃ¡n Ä‘Ã£ kiá»ƒm tra doanh thu, chi phÃ­ vÃ  chá»‘t chuyáº¿n Cáº§n ThÆ¡ do hÆ°á»›ng dáº«n viÃªn Nguyá»…n Quá»‘c Viá»‡t phá»¥ trÃ¡ch.');

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H11QN_KH01', 'KH_01', 'TTT_H11_QUYNHON_LS', 'CTDT_H11QN_A_K', '2026-05-06');
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H11QN_KH02', 'KH_02', 'TTT_H11_QUYNHON_LS', 'CTDT_H11QN_B_K', '2026-05-06');
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H12CT_KH03', 'KH_03', 'TTT_H12_CANTHO_LS', 'CTDT_H12CT_A_K', '2026-05-12');
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H12CT_KH04', 'KH_04', 'TTT_H12_CANTHO_LS', 'CTDT_H12CT_B_K', '2026-05-12');

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H11QN_KH01', 'TTT_H11_QUYNHON_LS', 'KH_01', 5, 'HÆ°á»›ng dáº«n viÃªn Thuá»³ DÆ°Æ¡ng chu Ä‘Ã¡o, nháº¯c an toÃ n biá»ƒn rÃµ rÃ ng vÃ  há»— trá»£ gia Ä‘Ã¬nh cÃ³ tráº» nhá» ráº¥t tá»‘t.', '2026-05-11 19:30:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H11QN_KH02', 'TTT_H11_QUYNHON_LS', 'KH_02', 5, 'Lá»‹ch trÃ¬nh Quy NhÆ¡n há»£p lÃ½, cáº£nh Ä‘áº¹p, Ä‘oÃ n Ä‘Æ°á»£c chÄƒm sÃ³c ká»¹ vÃ  hoáº¡t Ä‘á»™ng báº£o vá»‡ biá»ƒn ráº¥t Ã½ nghÄ©a.', '2026-05-12 20:10:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H12CT_KH03', 'TTT_H12_CANTHO_LS', 'KH_03', 5, 'Anh Quá»‘c Viá»‡t hÆ°á»›ng dáº«n thÃ¢n thiá»‡n, tá»• chá»©c chá»£ ná»•i gá»n gÃ ng vÃ  chuáº©n bá»‹ bá»¯a Äƒn miá»n TÃ¢y ráº¥t ngon.', '2026-05-18 18:20:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H12CT_KH04', 'TTT_H12_CANTHO_LS', 'KH_04', 4, 'Chuyáº¿n Ä‘i chÃ¢n thá»±c, nhiá»u tráº£i nghiá»‡m Ä‘á»‹a phÆ°Æ¡ng; viá»‡c Ä‘á»•i báº¿n Ä‘Æ°á»£c thÃ´ng bÃ¡o nhanh nÃªn cáº£ Ä‘oÃ n váº«n thoáº£i mÃ¡i.', '2026-05-18 20:00:00');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H11_CP_XE', 'TK_HDV11', 'THEM', 'Chi phÃ­ thá»±c táº¿ hÆ°á»›ng dáº«n viÃªn', 'CP_H11QN_XE', '2026-05-09 09:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H12_CP_TAU', 'TK_HDV12', 'THEM', 'Chi phÃ­ thá»±c táº¿ hÆ°á»›ng dáº«n viÃªn', 'CP_H12CT_TAU', '2026-05-15 08:10:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H11_QT', 'TK_KT01', 'THEM', 'Quyáº¿t toÃ¡n tour Ä‘Ã£ hoÃ n thÃ nh', 'QT_H11QN_HOANTAT', '2026-05-11 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H12_QT', 'TK_KT01', 'THEM', 'Quyáº¿t toÃ¡n tour Ä‘Ã£ hoÃ n thÃ nh', 'QT_H12CT_HOANTAT', '2026-05-17 10:30:00');

-- Bá»• sung Ä‘oÃ n khÃ¡ch Ä‘Ã£ xÃ¡c nháº­n cho 10 tour má»Ÿ bÃ¡n cá»‘ Ä‘á»‹nh nÄƒm 2026.
-- Má»—i tour cÃ²n 4-5 chá»— Ä‘á»ƒ phÃ¹ há»£p thá»±c táº¿ bÃ¡n gáº§n Ä‘á»§ nhÆ°ng váº«n nháº­n thÃªm khÃ¡ch láº».;

-- ÄÆ¡n Ä‘Ã£ há»§y: váº«n lÆ°u Ä‘áº§y Ä‘á»§ danh sÃ¡ch khÃ¡ch, dá»‹ch vá»¥, thanh toÃ¡n ban Ä‘áº§u, hoÃ n tiá»n vÃ  yÃªu cáº§u há»— trá»£.;

-- Bá»‘n chuyáº¿n Ä‘Ã£ hoÃ n táº¥t gáº§n Ä‘Ã¢y, cÃ¹ng tour máº«u vá»›i cÃ¡c Ä‘á»£t Ä‘ang bÃ¡n nÄƒm 2026,
-- cung cáº¥p nguá»“n Ä‘Ã¡nh giÃ¡ há»£p lá»‡ cho trang cÃ´ng khai.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_HOIAN_DG', 'TM_HOIAN', '2026-04-27', 4800000, 16, 8, 16, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_CANTHO_DG', 'TM_CANTHO', '2026-05-01', 4050000, 16, 8, 16, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_HALONG_DG', 'TM_HALONG', '2026-05-02', 6200000, 16, 8, 16, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_26_MUINE_DG', 'TM_MUINE', '2026-05-07', 5150000, 16, 8, 16, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_HOIAN_DG', 'DVT_HOIAN_LANTERN');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_CANTHO_DG', 'DVT_CANTHO_COOKING');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_HALONG_DG', 'DVT_HALONG_KAYAK');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_26_MUINE_DG', 'DVT_MUINE_JEEP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_HOIAN_DG', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_CANTHO_DG', 'HDX_LOCAL_MEAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_HALONG_DG', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_26_MUINE_DG', 'HDX_REFILL');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_HOIAN_DG_H11', 'TTT_26_HOIAN_DG', 'NV_HDV11', '2026-04-08 09:00:00', 'DA_DONG_Y', '2026-04-08 14:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_CANTHO_DG_H11', 'TTT_26_CANTHO_DG', 'NV_HDV11', '2026-04-10 09:00:00', 'DA_DONG_Y', '2026-04-10 15:00:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_HALONG_DG_H12', 'TTT_26_HALONG_DG', 'NV_HDV12', '2026-04-11 08:00:00', 'DA_DONG_Y', '2026-04-11 12:30:00');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_26_MUINE_DG_H12', 'TTT_26_MUINE_DG', 'NV_HDV12', '2026-04-15 08:00:00', 'DA_DONG_Y', '2026-04-15 13:00:00');

UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA'
WHERE ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
SELECT 'DD_' || ct.ma_chi_tiet_dat, d.ma_tour_thuc_te, ct.ma_khach_hang, ct.ma_nguoi_dong_hanh, ct.loai_khach,
       CASE d.ma_tour_thuc_te WHEN 'TTT_26_HOIAN_DG' THEN 'NV_HDV11' WHEN 'TTT_26_CANTHO_DG' THEN 'NV_HDV11' ELSE 'NV_HDV12' END,
       CAST(t.ngay_khoi_hanh AS DATETIME) + INTERVAL 7 HOUR,
       CASE d.ma_tour_thuc_te WHEN 'TTT_26_HOIAN_DG' THEN 'Äiá»ƒm Ä‘Ã³n phá»‘ cá»• Há»™i An'
            WHEN 'TTT_26_CANTHO_DG' THEN 'Báº¿n Ninh Kiá»u'
            WHEN 'TTT_26_HALONG_DG' THEN 'Cáº£ng tÃ u du lá»‹ch Háº¡ Long'
            ELSE 'Sáº£nh khÃ¡ch sáº¡n MÅ©i NÃ©' END,
       'DA_DIEM_DANH'
FROM chi_tiet_dat_tours ct
JOIN don_dat_tours d ON d.ma_dat_tour = ct.ma_dat_tour
JOIN tour_thuc_tes t ON t.ma_tour_thuc_te = d.ma_tour_thuc_te
WHERE d.ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGHA_KH01', 'TTT_26_HOIAN_DG', 'KH_01', 'HDX_LOCAL_MEAL', 'NV_HDV11', '2026-04-28 18:00:00', 'KhÃ¡ch sá»­ dá»¥ng bá»¯a tá»‘i nguyÃªn liá»‡u Ä‘á»‹a phÆ°Æ¡ng táº¡i Há»™i An vÃ  háº¡n cháº¿ váº­t dá»¥ng dÃ¹ng má»™t láº§n.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGCT_KH04', 'TTT_26_CANTHO_DG', 'KH_04', 'HDX_LOCAL_MEAL', 'NV_HDV11', '2026-05-02 11:00:00', 'ÄoÃ n chá»n nÃ´ng sáº£n theo mÃ¹a trong lá»›p náº¥u Äƒn táº¡i miá»‡t vÆ°á»n.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGHL_KH07', 'TTT_26_HALONG_DG', 'KH_07', 'HDX_REFILL', 'NV_HDV12', '2026-05-03 09:00:00', 'KhÃ¡ch dÃ¹ng bÃ¬nh nÆ°á»›c cÃ¡ nhÃ¢n vÃ  tiáº¿p nÆ°á»›c trÃªn du thuyá»n thay chai nhá»±a má»›i.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGMN_KH10', 'TTT_26_MUINE_DG', 'KH_10', 'HDX_REFILL', 'NV_HDV12', '2026-05-08 08:30:00', 'NhÃ³m khÃ¡ch dÃ¹ng tráº¡m tiáº¿p nÆ°á»›c trÆ°á»›c hÃ nh trÃ¬nh xe jeep táº¡i BÃ u Tráº¯ng.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGHA_MONCHAY', 'TTT_26_HOIAN_DG', 'NV_HDV11', 'Má»™t khÃ¡ch bÃ¡o cáº§n Ä‘á»•i sang suáº¥t Äƒn chay trong bá»¯a tá»‘i.',
        'HÆ°á»›ng dáº«n viÃªn lÃ m viá»‡c vá»›i nhÃ  hÃ ng vÃ  phá»¥c vá»¥ suáº¥t thay tháº¿ trong vÃ²ng hai mÆ°Æ¡i phÃºt.', 'THAP', 'AN_UONG', '2026-04-28 17:30:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGCT_NUOC', 'TTT_26_CANTHO_DG', 'NV_HDV11', 'Má»±c nÆ°á»›c thay Ä‘á»•i khiáº¿n giá» cáº­p báº¿n miá»‡t vÆ°á»n cháº­m mÆ°á»i phÃºt.',
        'Äiá»u chá»‰nh thá»© tá»± lá»›p náº¥u Äƒn vÃ  bÃ¡o láº¡i giá» táº­p trung cho toÃ n Ä‘oÃ n.', 'THAP', 'PHUONG_TIEN', '2026-05-02 09:20:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGHL_GIO', 'TTT_26_HALONG_DG', 'NV_HDV12', 'GiÃ³ trÃªn vá»‹nh tÄƒng nháº¹ vÃ o buá»•i chiá»u, cáº§n theo dÃµi lá»‹ch chÃ¨o kayak.',
        'RÃºt ngáº¯n thá»i lÆ°á»£ng kayak, yÃªu cáº§u máº·c Ã¡o phao vÃ  giá»¯ nhÃ³m theo hÆ°á»›ng dáº«n viÃªn.', 'THAP', 'THOI_TIET', '2026-05-03 13:00:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGMN_XE', 'TTT_26_MUINE_DG', 'NV_HDV12', 'Má»™t xe jeep Ä‘áº¿n Ä‘iá»ƒm Ä‘Ã³n trá»… mÆ°á»i lÄƒm phÃºt do kiá»ƒm tra lá»‘p an toÃ n.',
        'Bá»• sung nÆ°á»›c mÃ¡t cho khÃ¡ch trong thá»i gian chá» vÃ  Ä‘iá»u chá»‰nh lá»‹ch chá»¥p áº£nh khÃ´ng áº£nh hÆ°á»Ÿng chÆ°Æ¡ng trÃ¬nh.', 'THAP', 'PHUONG_TIEN', '2026-05-08 05:20:00');

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
SELECT 'LST_' || SUBSTR(d.ma_dat_tour, 5), d.ma_khach_hang, d.ma_tour_thuc_te, ct.ma_chi_tiet_dat, t.ngay_khoi_hanh
FROM don_dat_tours d
JOIN chi_tiet_dat_tours ct ON ct.ma_dat_tour = d.ma_dat_tour AND ct.ma_khach_hang = d.ma_khach_hang
JOIN tour_thuc_tes t ON t.ma_tour_thuc_te = d.ma_tour_thuc_te
WHERE d.ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHA_LUUTRU', 'TTT_26_HOIAN_DG', 'NV_HDV11', 'LÆ°u trÃº vÃ  bá»¯a sÃ¡ng Há»™i An cho Ä‘oÃ n', 15400000, 'https://seed.local/hoa-don/dgha-luu-tru.jpg', 'DA_DUYET', '2026-04-30 10:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHA_XE', 'TTT_26_HOIAN_DG', 'NV_HDV11', 'Xe Ä‘Æ°a Ä‘Ã³n vÃ  vÃ© tham quan phá»‘ cá»•', 7600000, 'https://seed.local/hoa-don/dgha-xe-ve.jpg', 'DA_DUYET', '2026-04-30 10:15:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGCT_LUUTRU', 'TTT_26_CANTHO_DG', 'NV_HDV11', 'LÆ°u trÃº Cáº§n ThÆ¡ vÃ  bá»¯a sÃ¡ng cho Ä‘oÃ n', 12100000, 'https://seed.local/hoa-don/dgct-luu-tru.jpg', 'DA_DUYET', '2026-05-04 10:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGCT_THUYEN', 'TTT_26_CANTHO_DG', 'NV_HDV11', 'Thuyá»n chá»£ ná»•i vÃ  xe trung chuyá»ƒn miá»‡t vÆ°á»n', 6300000, 'https://seed.local/hoa-don/dgct-thuyen.jpg', 'DA_DUYET', '2026-05-04 10:20:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHL_TAU', 'TTT_26_HALONG_DG', 'NV_HDV12', 'Du thuyá»n vÃ  phÃ²ng nghá»‰ trÃªn vá»‹nh cho Ä‘oÃ n', 27200000, 'https://seed.local/hoa-don/dghl-du-thuyen.jpg', 'DA_DUYET', '2026-05-05 09:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHL_VE', 'TTT_26_HALONG_DG', 'NV_HDV12', 'VÃ© vá»‹nh vÃ  thiáº¿t bá»‹ an toÃ n kayak', 8200000, 'https://seed.local/hoa-don/dghl-ve.jpg', 'DA_DUYET', '2026-05-05 09:20:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGMN_KS', 'TTT_26_MUINE_DG', 'NV_HDV12', 'KhÃ¡ch sáº¡n ven biá»ƒn MÅ©i NÃ© cho Ä‘oÃ n', 16200000, 'https://seed.local/hoa-don/dgmn-khach-san.jpg', 'DA_DUYET', '2026-05-10 09:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGMN_XE', 'TTT_26_MUINE_DG', 'NV_HDV12', 'Xe Ä‘Æ°a Ä‘Ã³n vÃ  há»— trá»£ lá»‹ch trÃ¬nh Ä‘á»“i cÃ¡t', 7900000, 'https://seed.local/hoa-don/dgmn-xe.jpg', 'DA_DUYET', '2026-05-10 09:20:00');

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGHA_XONG', 'TTT_26_HOIAN_DG', 0, 0, 39000000, 0, 'NV_KT01', '2026-05-01 10:00:00', 'DA_QUYET_TOAN', 'ÄÃ£ Ä‘á»‘i chiáº¿u Ä‘á»§ doanh thu, dá»‹ch vá»¥ vÃ  chi phÃ­ Ä‘oÃ n Há»™i An trÆ°á»›c khi khÃ³a quyáº¿t toÃ¡n.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGCT_XONG', 'TTT_26_CANTHO_DG', 0, 0, 34000000, 0, 'NV_KT01', '2026-05-05 10:00:00', 'DA_QUYET_TOAN', 'ÄÃ£ chá»‘t doanh thu vÃ  chi phÃ­ chuyáº¿n Cáº§n ThÆ¡, hÃ³a Ä‘Æ¡n thá»±c táº¿ Ä‘Ã£ Ä‘Æ°á»£c duyá»‡t.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGHL_XONG', 'TTT_26_HALONG_DG', 0, 0, 55500000, 0, 'NV_KT01', '2026-05-06 10:00:00', 'DA_QUYET_TOAN', 'ÄÃ£ hoÃ n táº¥t quyáº¿t toÃ¡n chuyáº¿n du thuyá»n Háº¡ Long vÃ  lÆ°u hÃ³a Ä‘Æ¡n váº­n hÃ nh.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGMN_XONG', 'TTT_26_MUINE_DG', 0, 0, 48000000, 0, 'NV_KT01', '2026-05-11 10:00:00', 'DA_QUYET_TOAN', 'ÄÃ£ Ä‘á»‘i soÃ¡t thanh toÃ¡n vÃ  chi phÃ­ chuyáº¿n MÅ©i NÃ©, dá»¯ liá»‡u sáºµn sÃ ng phá»¥c vá»¥ bÃ¡o cÃ¡o.');

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHA_01', 'TTT_26_HOIAN_DG', 'KH_01', 5, 'Há»™i An Ä‘áº¹p vÃ  nháº¹ nhÃ ng, lá»›p lÃ m Ä‘Ã¨n lá»“ng thÃº vá»‹, hÆ°á»›ng dáº«n viÃªn há»— trá»£ mÃ³n Äƒn Ä‘á»‹a phÆ°Æ¡ng ráº¥t chu Ä‘Ã¡o.', '2026-05-02 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHA_02', 'TTT_26_HOIAN_DG', 'KH_02', 5, 'Lá»‹ch trÃ¬nh há»£p lÃ½, xe Ä‘Ãºng giá» vÃ  pháº§n tráº£i nghiá»‡m táº¡i TrÃ  Quáº¿ phÃ¹ há»£p cho cáº£ gia Ä‘Ã¬nh.', '2026-05-02 19:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHA_03', 'TTT_26_HOIAN_DG', 'KH_03', 4, 'Dá»‹ch vá»¥ tá»‘t, phá»‘ cá»• ráº¥t Ä‘áº¹p, mong cÃ³ thÃªm thá»i gian tá»± do buá»•i tá»‘i Ä‘á»ƒ dáº¡o Ä‘Ã¨n lá»“ng.', '2026-05-03 09:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGCT_01', 'TTT_26_CANTHO_DG', 'KH_04', 5, 'Chá»£ ná»•i ráº¥t Ä‘Ã¡ng tráº£i nghiá»‡m, hÆ°á»›ng dáº«n viÃªn xá»­ lÃ½ viá»‡c Ä‘á»•i báº¿n nhanh vÃ  bá»¯a Äƒn miá»n TÃ¢y ngon.', '2026-05-06 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGCT_02', 'TTT_26_CANTHO_DG', 'KH_05', 5, 'Lá»›p náº¥u Äƒn gáº§n gÅ©i, nhÃ  vÆ°á»n thÃ¢n thiá»‡n, lá»‹ch trÃ¬nh vá»«a sá»©c cho ngÆ°á»i lá»›n tuá»•i.', '2026-05-06 19:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGCT_03', 'TTT_26_CANTHO_DG', 'KH_06', 4, 'Tour chá»‰n chu vÃ  nhiá»u tráº£i nghiá»‡m tháº­t, giá» xuáº¥t phÃ¡t chá»£ ná»•i hÆ¡i sá»›m nhÆ°ng ráº¥t xá»©ng Ä‘Ã¡ng.', '2026-05-07 08:30:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHL_01', 'TTT_26_HALONG_DG', 'KH_07', 5, 'Du thuyá»n sáº¡ch vÃ  tiá»‡n nghi, hoáº¡t Ä‘á»™ng kayak Ä‘Æ°á»£c hÆ°á»›ng dáº«n an toÃ n, cáº£nh vá»‹nh ráº¥t Ä‘áº¹p.', '2026-05-07 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHL_02', 'TTT_26_HALONG_DG', 'KH_08', 4, 'Chuyáº¿n Ä‘i thÆ° giÃ£n, nhÃ¢n viÃªn nhiá»‡t tÃ¬nh; thá»i tiáº¿t cÃ³ giÃ³ nhÆ°ng lá»‹ch trÃ¬nh Ä‘Æ°á»£c Ä‘iá»u chá»‰nh há»£p lÃ½.', '2026-05-08 08:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHL_03', 'TTT_26_HALONG_DG', 'KH_09', 5, 'Gia Ä‘Ã¬nh hÃ i lÃ²ng vá»›i phÃ²ng nghá»‰ trÃªn tÃ u vÃ  hoáº¡t Ä‘á»™ng tiáº¿p nÆ°á»›c giáº£m chai nhá»±a.', '2026-05-08 09:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGMN_01', 'TTT_26_MUINE_DG', 'KH_10', 5, 'Xe jeep ngáº¯m bÃ¬nh minh ráº¥t Ä‘Ã¡ng nhá»›, lá»‹ch trÃ¬nh gá»n vÃ  hÆ°á»›ng dáº«n viÃªn chÄƒm sÃ³c Ä‘oÃ n tá»‘t.', '2026-05-12 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGMN_02', 'TTT_26_MUINE_DG', 'KH_11', 5, 'Biá»ƒn sáº¡ch, khÃ¡ch sáº¡n thoáº£i mÃ¡i vÃ  thá»i gian chá»¥p áº£nh á»Ÿ Ä‘á»“i cÃ¡t Ä‘Æ°á»£c sáº¯p xáº¿p ráº¥t Ä‘áº¹p.', '2026-05-12 19:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGMN_03', 'TTT_26_MUINE_DG', 'KH_12', 4, 'Tráº£i nghiá»‡m tá»‘t, Ä‘oÃ n Ä‘Æ°á»£c há»— trá»£ ngay khi xe Ä‘áº¿n trá»…; mong cÃ³ thÃªm lá»±a chá»n mÃ³n chay.', '2026-05-13 08:00:00');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_SJ_01', 'TK_KT01', 'CAP_NHAT', 'HoÃ n tiá»n Ä‘Æ¡n há»§y', 'DDT_HUY_SJ_01', '2026-05-17 09:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_PQ_01', 'TK_KT01', 'CAP_NHAT', 'HoÃ n tiá»n Ä‘Æ¡n há»§y', 'DDT_HUY_PQ_01', '2026-05-18 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_HL_01', 'TK_KT01', 'CAP_NHAT', 'HoÃ n tiá»n Ä‘Æ¡n há»§y', 'DDT_HUY_HL_01', '2026-05-19 08:30:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_DD_01', 'TK_KT01', 'CAP_NHAT', 'HoÃ n tiá»n Ä‘Æ¡n há»§y', 'DDT_HUY_DD_01', '2026-05-20 10:15:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGHA', 'TK_KT01', 'THEM', 'Quyáº¿t toÃ¡n tour Ä‘Ã£ Ä‘Ã¡nh giÃ¡', 'QT_DGHA_XONG', '2026-05-01 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGCT', 'TK_KT01', 'THEM', 'Quyáº¿t toÃ¡n tour Ä‘Ã£ Ä‘Ã¡nh giÃ¡', 'QT_DGCT_XONG', '2026-05-05 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGHL', 'TK_KT01', 'THEM', 'Quyáº¿t toÃ¡n tour Ä‘Ã£ Ä‘Ã¡nh giÃ¡', 'QT_DGHL_XONG', '2026-05-06 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGMN', 'TK_KT01', 'THEM', 'Quyáº¿t toÃ¡n tour Ä‘Ã£ Ä‘Ã¡nh giÃ¡', 'QT_DGMN_XONG', '2026-05-11 10:00:00');

-- Voucher bo sung: tao master, vi khach hang, lich su ap dung va dong bo tong tien/giao dich.
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_FAMILY1M', 'OPEN-FAMILY-1M', 'SO_TIEN', 1000000, 'Giáº£m 1.000.000 cho nhÃ³m gia Ä‘Ã¬nh tá»« 4 khÃ¡ch trong giai Ä‘oáº¡n má»Ÿ bÃ¡n', 120, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_SUMMER8', 'OPEN-SUMMER-8', 'PHAN_TRAM', 8, 600000, 'Giáº£m 8% cho tour biá»ƒn, Ä‘áº£o vÃ  miá»n Trung Ä‘áº·t trÆ°á»›c 60 ngÃ y', 150, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 210 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_GREEN600', 'OPEN-GREEN-600', 'SO_TIEN', 600000, 'Giáº£m 600.000 cho khÃ¡ch cam káº¿t tá»‘i thiá»ƒu má»™t hÃ nh Ä‘á»™ng xanh', 100, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_COUPLE500', 'OPEN-COUPLE-500', 'SO_TIEN', 500000, 'Giáº£m 500.000 cho Ä‘Æ¡n hai khÃ¡ch', 90, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 160 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_LOCAL5', 'OPEN-LOCAL-5', 'PHAN_TRAM', 5, 300000, 'Giáº£m 5% cho tour cÃ³ tráº£i nghiá»‡m cá»™ng Ä‘á»“ng Ä‘á»‹a phÆ°Æ¡ng', 110, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_PREMIUM2M', 'OPEN-PREMIUM-2M', 'SO_TIEN', 2000000, 'Giáº£m 2.000.000 cho Ä‘Æ¡n trÃªn 25.000.000 cá»§a khÃ¡ch háº¡ng cao', 40, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');

INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_01', 'VC_OPEN_FAMILY1M', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 6 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_06', 'VC_OPEN_SUMMER8', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 4 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_07', 'VC_OPEN_COUPLE500', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_08', 'VC_OPEN_GREEN600', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_09', 'VC_OPEN_PREMIUM2M', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 4 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_10', 'VC_OPEN_COUPLE500', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_11', 'VC_OPEN_LOCAL5', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 5 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_12', 'VC_OPEN_GREEN600', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 4 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_13', 'VC_OPEN_COUPLE500', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_14', 'VC_OPEN_GREEN600', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_15', 'VC_OPEN_SUMMER8', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_02', 'VC_OPEN_LOCAL5', DATE(NOW()) + INTERVAL 100 DAY, NOW() - INTERVAL 2 DAY, 'CO_HIEU_LUC');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai) VALUES ('KH_03', 'VC_OPEN_FAMILY1M', DATE(NOW()) + INTERVAL 100 DAY, NOW() - INTERVAL 2 DAY, 'CO_HIEU_LUC');

INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_SAPA_OPEN_03_GD1', 'VC_OPEN_FAMILY1M', 1000000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_DANANG_OPEN_03_FAMILY', 'VC_OPEN_SUMMER8', 2184000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_DALAT_OPEN_03_COUPLE', 'VC_OPEN_COUPLE500', 500000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_NINHBINH_OPEN_03_TEAM', 'VC_OPEN_GREEN600', 600000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_PHUQUOC_OPEN_03_FAMILY', 'VC_OPEN_PREMIUM2M', 2000000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_HUE_OPEN_03_COUPLE', 'VC_OPEN_COUPLE500', 500000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_HAGIANG_OPEN_03_TEAM', 'VC_OPEN_LOCAL5', 981000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_HOIAN_OPEN_03_GROUP', 'VC_OPEN_GREEN600', 600000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_HALONG_OPEN_03_COUPLE', 'VC_OPEN_COUPLE500', 500000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_CANTHO_OPEN_03_FAMILY', 'VC_OPEN_GREEN600', 600000);
INSERT INTO dat_tour_uu_dais (ma_dat_tour, ma_voucher, so_tien_uu_dai) VALUES ('DDT_CONDAO_OPEN_03_COUPLE', 'VC_OPEN_SUMMER8', 1425600);

UPDATE don_dat_tours SET tong_tien = 24350000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-FAMILY-1M giáº£m 1.000.000.' WHERE ma_dat_tour = 'DDT_SAPA_OPEN_03_GD1';
UPDATE giao_diches SET so_tien = 24350000 WHERE ma_giao_dich = 'GD_SAPA_OPEN_03_GD1_PAY';
UPDATE don_dat_tours SET tong_tien = 25116000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-SUMMER-8 giáº£m 2.184.000.' WHERE ma_dat_tour = 'DDT_DANANG_OPEN_03_FAMILY';
UPDATE giao_diches SET so_tien = 25116000 WHERE ma_giao_dich = 'GD_DANANG_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 8600000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-COUPLE-500 giáº£m 500.000.' WHERE ma_dat_tour = 'DDT_DALAT_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 8600000 WHERE ma_giao_dich = 'GD_DALAT_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 16300000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-GREEN-600 giáº£m 600.000.' WHERE ma_dat_tour = 'DDT_NINHBINH_OPEN_03_TEAM';
UPDATE giao_diches SET so_tien = 16300000 WHERE ma_giao_dich = 'GD_NINHBINH_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 30600000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-PREMIUM-2M giáº£m 2.000.000.' WHERE ma_dat_tour = 'DDT_PHUQUOC_OPEN_03_FAMILY';
UPDATE giao_diches SET so_tien = 30600000 WHERE ma_giao_dich = 'GD_PHUQUOC_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 9250000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-COUPLE-500 giáº£m 500.000.' WHERE ma_dat_tour = 'DDT_HUE_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 9250000 WHERE ma_giao_dich = 'GD_HUE_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 18639000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-LOCAL-5 giáº£m 981.000.' WHERE ma_dat_tour = 'DDT_HAGIANG_OPEN_03_TEAM';
UPDATE giao_diches SET so_tien = 18639000 WHERE ma_giao_dich = 'GD_HAGIANG_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 18700000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-GREEN-600 giáº£m 600.000.' WHERE ma_dat_tour = 'DDT_HOIAN_OPEN_03_GROUP';
UPDATE giao_diches SET so_tien = 18700000 WHERE ma_giao_dich = 'GD_HOIAN_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 12700000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-COUPLE-500 giáº£m 500.000.' WHERE ma_dat_tour = 'DDT_HALONG_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 12700000 WHERE ma_giao_dich = 'GD_HALONG_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 11550000, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-GREEN-600 giáº£m 600.000.' WHERE ma_dat_tour = 'DDT_CANTHO_OPEN_03_FAMILY';
UPDATE giao_diches SET so_tien = 11550000 WHERE ma_giao_dich = 'GD_CANTHO_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 16394400, ghi_chu = ghi_chu || ' Ãp dá»¥ng voucher OPEN-SUMMER-8 giáº£m 1.425.600.' WHERE ma_dat_tour = 'DDT_CONDAO_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 16394400 WHERE ma_giao_dich = 'GD_CONDAO_OPEN_03_PAY';

-- Tour da hoan thanh bo sung de tang nguon danh gia cho cac tour mau dang mo ban.
-- Cac don duoc chen khi tour con MO_BAN va ngay_dat truoc ngay_khoi_hanh, sau do tour moi chuyen KET_THUC de hop le khi danh gia.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_SAPA_REVIEW_03', 'TM_SAPA', DATE(NOW()) - INTERVAL 12 DAY, 4900000, 26, 8, 26, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_DANANG_REVIEW_03', 'TM_DANANG', DATE(NOW()) - INTERVAL 14 DAY, 6700000, 30, 10, 30, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_PHUQUOC_REVIEW_03', 'TM_PHUQUOC', DATE(NOW()) - INTERVAL 15 DAY, 8200000, 24, 8, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HUE_REVIEW_03', 'TM_HUE', DATE(NOW()) - INTERVAL 10 DAY, 4600000, 24, 8, 24, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_SAPA_REVIEW_03', 'DVT_SAPA_HERBAL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_DANANG_REVIEW_03', 'DVT_DANANG_SHOW');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_PHUQUOC_REVIEW_03', 'DVT_PHUQUOC_SNORKEL');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HUE_REVIEW_03', 'DVT_HUE_AODAI');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_SAPA_REVIEW_03', 'HDX_REFILL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_DANANG_REVIEW_03', 'HDX_PUBLIC_TRANSFER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_PHUQUOC_REVIEW_03', 'HDX_CORAL_SAFE');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HUE_REVIEW_03', 'HDX_REUSABLE_BAG');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_SAPA_REVIEW_03_HDV03', 'TTT_SAPA_REVIEW_03', 'NV_HDV03', NOW() - INTERVAL 35 DAY, 'DA_DONG_Y', NOW() - INTERVAL 34 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_DANANG_REVIEW_03_HDV04', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', NOW() - INTERVAL 36 DAY, 'DA_DONG_Y', NOW() - INTERVAL 35 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_PHUQUOC_REVIEW_03_HDV05', 'TTT_PHUQUOC_REVIEW_03', 'NV_HDV05', NOW() - INTERVAL 37 DAY, 'DA_DONG_Y', NOW() - INTERVAL 36 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_HUE_REVIEW_03_HDV06', 'TTT_HUE_REVIEW_03', 'NV_HDV06', NOW() - INTERVAL 33 DAY, 'DA_DONG_Y', NOW() - INTERVAL 32 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_SAPA_REVIEW_03_' || ma_khach_hang, 'TTT_SAPA_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 32 DAY,
       CASE ma_khach_hang WHEN 'KH_02' THEN 9800000 WHEN 'KH_05' THEN 14700000 ELSE 4900000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 31 DAY, 'KhÃ¡ch Ä‘Ã£ hoÃ n thÃ nh tour Sa Pa, dÃ¹ng lÃ m nguá»“n Ä‘Ã¡nh giÃ¡ cho tour máº«u.', 'HDX_REFILL:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_01','KH_02','KH_03','KH_04','KH_05');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_DANANG_REVIEW_03_' || ma_khach_hang, 'TTT_DANANG_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 35 DAY,
       CASE ma_khach_hang WHEN 'KH_08' THEN 20100000 WHEN 'KH_06' THEN 13400000 WHEN 'KH_10' THEN 13400000 ELSE 6700000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 34 DAY, 'KhÃ¡ch Ä‘Ã£ hoÃ n thÃ nh tour ÄÃ  Náºµng - Há»™i An, dÃ¹ng lÃ m nguá»“n Ä‘Ã¡nh giÃ¡ cho tour máº«u.', 'HDX_PUBLIC_TRANSFER:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_06','KH_07','KH_08','KH_09','KH_10');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_PHUQUOC_REVIEW_03_' || ma_khach_hang, 'TTT_PHUQUOC_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 36 DAY,
       CASE ma_khach_hang WHEN 'KH_14' THEN 24600000 WHEN 'KH_11' THEN 16400000 WHEN 'KH_13' THEN 16400000 ELSE 8200000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 35 DAY, 'KhÃ¡ch Ä‘Ã£ hoÃ n thÃ nh tour PhÃº Quá»‘c, dÃ¹ng lÃ m nguá»“n Ä‘Ã¡nh giÃ¡ cho tour máº«u.', 'HDX_CORAL_SAFE:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_11','KH_12','KH_13','KH_14','KH_15');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_HUE_REVIEW_03_' || ma_khach_hang, 'TTT_HUE_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 28 DAY,
       CASE ma_khach_hang WHEN 'KH_02' THEN 9200000 WHEN 'KH_04' THEN 9200000 WHEN 'KH_05' THEN 13800000 ELSE 4600000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 27 DAY, 'KhÃ¡ch Ä‘Ã£ hoÃ n thÃ nh tour Huáº¿, dÃ¹ng lÃ m nguá»“n Ä‘Ã¡nh giÃ¡ cho tour máº«u.', 'HDX_REUSABLE_BAG:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_01','KH_02','KH_03','KH_04','KH_05');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
SELECT 'CTDT_' || SUBSTR(ma_dat_tour, 5) || '_KH', ma_dat_tour, ma_khach_hang, NULL, 'NGUOI_DAT',
       CASE ma_tour_thuc_te WHEN 'TTT_SAPA_REVIEW_03' THEN 4900000 WHEN 'TTT_DANANG_REVIEW_03' THEN 6700000 WHEN 'TTT_PHUQUOC_REVIEW_03' THEN 8200000 ELSE 4600000 END
FROM don_dat_tours
WHERE ma_dat_tour LIKE 'DDT\_%\_REVIEW\_03\_KH%' ;

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_REVIEW_03_KH02_01', 'DDT_SAPA_REVIEW_03_KH_02', 'LÃª Quá»‘c Thá»‹nh', '001088040101', '0904000101', '1988-07-09', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_REVIEW_03_KH05_01', 'DDT_SAPA_REVIEW_03_KH_05', 'HoÃ ng Gia Báº£o', '001085040102', '0904000102', '1985-06-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_REVIEW_03_KH05_02', 'DDT_SAPA_REVIEW_03_KH_05', 'HoÃ ng Ngá»c Mai', '001089040103', '0904000103', '1989-10-11', 'Ná»¯', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH06_01', 'DDT_DANANG_REVIEW_03_KH_06', 'BÃ¹i Thanh Phong', '048087040104', '0904000104', '1987-01-19', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH08_01', 'DDT_DANANG_REVIEW_03_KH_08', 'ÄoÃ n Thá»‹ Háº¡nh', '048060040105', '0904000105', '1960-07-07', 'Ná»¯', 'NgÆ°á»i cao tuá»•i');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH08_02', 'DDT_DANANG_REVIEW_03_KH_08', 'ÄoÃ n Minh KhÃ´i', '048090040106', '0904000106', '1990-05-21', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH09_01', 'DDT_DANANG_REVIEW_03_KH_09', 'Äáº·ng Minh KhÃ´i', '048086040116', '0904000116', '1986-01-21', 'NAM', 'Äi cÃ´ng tÃ¡c káº¿t há»£p nghá»‰ dÆ°á»¡ng');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH10_01', 'DDT_DANANG_REVIEW_03_KH_10', 'Mai HoÃ ng Long', '048091040107', '0904000107', '1991-04-04', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH11_01', 'DDT_PHUQUOC_REVIEW_03_KH_11', 'Cao Minh Anh', '091082040108', '0904000108', '1982-07-17', 'Ná»¯', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH13_01', 'DDT_PHUQUOC_REVIEW_03_KH_13', 'Nguyá»…n HoÃ i Nam', '091084040109', '0904000109', '1984-06-17', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH14_01', 'DDT_PHUQUOC_REVIEW_03_KH_14', 'LÃ¢m Gia HÃ¢n', '091019040110', '0904000110', '2019-03-15', 'Ná»¯', 'Tráº» em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH14_02', 'DDT_PHUQUOC_REVIEW_03_KH_14', 'LÃ¢m Minh PhÃºc', '091088040111', '0904000111', '1988-05-03', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH02_01', 'DDT_HUE_REVIEW_03_KH_02', 'Nguyá»…n Minh Äá»©c', '075086040112', '0904000112', '1986-03-12', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH04_01', 'DDT_HUE_REVIEW_03_KH_04', 'Tráº§n Thá»‹ Kim LiÃªn', '075060040113', '0904000113', '1960-02-18', 'Ná»¯', 'NgÆ°á»i cao tuá»•i');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH05_01', 'DDT_HUE_REVIEW_03_KH_05', 'HoÃ ng Gia Báº£o', '075085040114', '0904000114', '1985-06-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH05_02', 'DDT_HUE_REVIEW_03_KH_05', 'HoÃ ng Ngá»c Mai', '075089040115', '0904000115', '1989-10-11', 'Ná»¯', NULL);

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_REVIEW_03_KH02_NDH1', 'DDT_SAPA_REVIEW_03_KH_02', NULL, 'NDH_SAPA_REVIEW_03_KH02_01', 'NGUOI_DONG_HANH', 4900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_REVIEW_03_KH05_NDH1', 'DDT_SAPA_REVIEW_03_KH_05', NULL, 'NDH_SAPA_REVIEW_03_KH05_01', 'NGUOI_DONG_HANH', 4900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_REVIEW_03_KH05_NDH2', 'DDT_SAPA_REVIEW_03_KH_05', NULL, 'NDH_SAPA_REVIEW_03_KH05_02', 'NGUOI_DONG_HANH', 4900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_REVIEW_03_KH06_NDH1', 'DDT_DANANG_REVIEW_03_KH_06', NULL, 'NDH_DANANG_REVIEW_03_KH06_01', 'NGUOI_DONG_HANH', 6700000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_REVIEW_03_KH08_NDH1', 'DDT_DANANG_REVIEW_03_KH_08', NULL, 'NDH_DANANG_REVIEW_03_KH08_01', 'NGUOI_DONG_HANH', 6700000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_REVIEW_03_KH08_NDH2', 'DDT_DANANG_REVIEW_03_KH_08', NULL, 'NDH_DANANG_REVIEW_03_KH08_02', 'NGUOI_DONG_HANH', 6700000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_REVIEW_03_KH09_NDH1', 'DDT_DANANG_REVIEW_03_KH_09', NULL, 'NDH_DANANG_REVIEW_03_KH09_01', 'NGUOI_DONG_HANH', 6700000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_REVIEW_03_KH10_NDH1', 'DDT_DANANG_REVIEW_03_KH_10', NULL, 'NDH_DANANG_REVIEW_03_KH10_01', 'NGUOI_DONG_HANH', 6700000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_REVIEW_03_KH11_NDH1', 'DDT_PHUQUOC_REVIEW_03_KH_11', NULL, 'NDH_PHUQUOC_REVIEW_03_KH11_01', 'NGUOI_DONG_HANH', 8200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_REVIEW_03_KH13_NDH1', 'DDT_PHUQUOC_REVIEW_03_KH_13', NULL, 'NDH_PHUQUOC_REVIEW_03_KH13_01', 'NGUOI_DONG_HANH', 8200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_REVIEW_03_KH14_NDH1', 'DDT_PHUQUOC_REVIEW_03_KH_14', NULL, 'NDH_PHUQUOC_REVIEW_03_KH14_01', 'NGUOI_DONG_HANH', 8200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_REVIEW_03_KH14_NDH2', 'DDT_PHUQUOC_REVIEW_03_KH_14', NULL, 'NDH_PHUQUOC_REVIEW_03_KH14_02', 'NGUOI_DONG_HANH', 8200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_REVIEW_03_KH02_NDH1', 'DDT_HUE_REVIEW_03_KH_02', NULL, 'NDH_HUE_REVIEW_03_KH02_01', 'NGUOI_DONG_HANH', 4600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_REVIEW_03_KH04_NDH1', 'DDT_HUE_REVIEW_03_KH_04', NULL, 'NDH_HUE_REVIEW_03_KH04_01', 'NGUOI_DONG_HANH', 4600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_REVIEW_03_KH05_NDH1', 'DDT_HUE_REVIEW_03_KH_05', NULL, 'NDH_HUE_REVIEW_03_KH05_01', 'NGUOI_DONG_HANH', 4600000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_REVIEW_03_KH05_NDH2', 'DDT_HUE_REVIEW_03_KH_05', NULL, 'NDH_HUE_REVIEW_03_KH05_02', 'NGUOI_DONG_HANH', 4600000);

UPDATE don_dat_tours SET tong_tien = 13400000, ghi_chu = ghi_chu || ' Bá»• sung má»™t ngÆ°á»i Ä‘á»“ng hÃ nh Ä‘á»ƒ Ä‘á»§ sá»‘ khÃ¡ch tá»‘i thiá»ƒu.' WHERE ma_dat_tour = 'DDT_DANANG_REVIEW_03_KH_09';

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
SELECT 'GD_' || SUBSTR(ma_dat_tour, 5) || '_PAY', ma_dat_tour, 'THANH_TOAN',
       CASE WHEN ma_khach_hang IN ('KH_02','KH_05','KH_08','KH_11','KH_14') THEN 'THE_QUOC_TE' ELSE 'CHUYEN_KHOAN' END,
       tong_tien, 'BANK-' || SUBSTR(ma_dat_tour, 5), 'THANH_CONG', ngay_dat + INTERVAL 6 HOUR
FROM don_dat_tours
WHERE ma_dat_tour LIKE 'DDT\_%\_REVIEW\_03\_KH%' ;

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te IN ('TTT_SAPA_REVIEW_03','TTT_DANANG_REVIEW_03','TTT_PHUQUOC_REVIEW_03','TTT_HUE_REVIEW_03');

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
SELECT 'LST_' || SUBSTR(ddt.ma_dat_tour, 5), ddt.ma_khach_hang, ddt.ma_tour_thuc_te, ctdt.ma_chi_tiet_dat, ttt.ngay_khoi_hanh
FROM don_dat_tours ddt
JOIN tour_thuc_tes ttt ON ttt.ma_tour_thuc_te = ddt.ma_tour_thuc_te
JOIN chi_tiet_dat_tours ctdt ON ctdt.ma_dat_tour = ddt.ma_dat_tour AND ctdt.ma_khach_hang = ddt.ma_khach_hang
WHERE ddt.ma_dat_tour LIKE 'DDT\_%\_REVIEW\_03\_KH%' ;

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH01', 'TTT_SAPA_REVIEW_03', 'KH_01', 5, 'Lá»‹ch trÃ¬nh Sa Pa vá»«a sá»©c, hÆ°á»›ng dáº«n viÃªn chÄƒm sÃ³c ká»¹ vÃ  xá»­ lÃ½ yÃªu cáº§u Äƒn uá»‘ng ráº¥t chu Ä‘Ã¡o.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH02', 'TTT_SAPA_REVIEW_03', 'KH_02', 5, 'KhÃ¡ch sáº¡n sáº¡ch, xe Ä‘Æ°a Ä‘Ã³n Ä‘Ãºng giá», gia Ä‘Ã¬nh cÃ³ tráº» nhá» váº«n Ä‘i ráº¥t thoáº£i mÃ¡i.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH03', 'TTT_SAPA_REVIEW_03', 'KH_03', 4, 'Cáº£nh Ä‘áº¹p vÃ  tráº£i nghiá»‡m báº£n lÃ ng tá»‘t, nÃªn thÃªm thá»i gian tá»± do á»Ÿ chá»£ Ä‘Ãªm.', NOW() - INTERVAL 6 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH04', 'TTT_SAPA_REVIEW_03', 'KH_04', 5, 'PhÃ²ng táº§ng tháº¥p Ä‘Ãºng yÃªu cáº§u, lá»‹ch trÃ¬nh khÃ´ng quÃ¡ gáº¥p vÃ  HDV há»— trá»£ ráº¥t nhiá»‡t tÃ¬nh.', NOW() - INTERVAL 6 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH05', 'TTT_SAPA_REVIEW_03', 'KH_05', 4, 'Dá»‹ch vá»¥ tá»‘t, bá»¯a Äƒn Ä‘á»‹a phÆ°Æ¡ng ngon, chá»‰ cáº§n cáº£i thiá»‡n thá»i gian chá» cÃ¡p treo.', NOW() - INTERVAL 5 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH06', 'TTT_DANANG_REVIEW_03', 'KH_06', 5, 'Tour ÄÃ  Náºµng - Há»™i An cÃ¢n báº±ng giá»¯a biá»ƒn, di sáº£n vÃ  nghá»‰ ngÆ¡i, xe Ä‘Æ°a Ä‘Ã³n ráº¥t Ä‘Ãºng giá».', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH07', 'TTT_DANANG_REVIEW_03', 'KH_07', 4, 'Phá»‘ cá»• Ä‘áº¹p, show buá»•i tá»‘i Ä‘Ã¡ng xem, nÃªn giáº£m thá»i gian mua sáº¯m á»Ÿ Ä‘iá»ƒm dá»«ng.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH08', 'TTT_DANANG_REVIEW_03', 'KH_08', 5, 'Äi cÃ¹ng ngÆ°á»i lá»›n tuá»•i váº«n ráº¥t á»•n, HDV sáº¯p xáº¿p nhá»‹p tham quan há»£p lÃ½.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH09', 'TTT_DANANG_REVIEW_03', 'KH_09', 5, 'Dá»‹ch vá»¥ xuáº¥t hÃ³a Ä‘Æ¡n rÃµ rÃ ng, lá»‹ch trÃ¬nh chuyÃªn nghiá»‡p vÃ  bá»¯a tá»‘i Há»™i An ngon.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH10', 'TTT_DANANG_REVIEW_03', 'KH_10', 4, 'Äá»™i ngÅ© lÆ°u Ã½ dá»‹ á»©ng háº£i sáº£n tá»‘t, khÃ¡ch sáº¡n á»•n, biá»ƒn hÆ¡i Ä‘Ã´ng vÃ o cuá»‘i tuáº§n.', NOW() - INTERVAL 6 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH11', 'TTT_PHUQUOC_REVIEW_03', 'KH_11', 5, 'Tour PhÃº Quá»‘c thÆ° giÃ£n, Ã­t pháº£i Ä‘i bá»™ nhiá»u vÃ  hoáº¡t Ä‘á»™ng biá»ƒn Ä‘Æ°á»£c hÆ°á»›ng dáº«n an toÃ n.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH12', 'TTT_PHUQUOC_REVIEW_03', 'KH_12', 5, 'Thá»±c Ä‘Æ¡n chay Ä‘Æ°á»£c chuáº©n bá»‹ riÃªng, lá»‹ch trÃ¬nh Ä‘áº£o Ä‘áº¹p vÃ  khÃ´ng quÃ¡ má»‡t.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH13', 'TTT_PHUQUOC_REVIEW_03', 'KH_13', 4, 'KhÃ¡ch sáº¡n yÃªn tÄ©nh, biá»ƒn Ä‘áº¹p, nÃªn thÃ´ng bÃ¡o rÃµ hÆ¡n thá»i tiáº¿t trÆ°á»›c ngÃ y Ä‘i cano.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH14', 'TTT_PHUQUOC_REVIEW_03', 'KH_14', 5, 'Gia Ä‘Ã¬nh cÃ³ tráº» nhá» Ä‘Æ°á»£c há»— trá»£ tá»‘t, hoáº¡t Ä‘á»™ng lÃ m sáº¡ch bÃ£i biá»ƒn ráº¥t Ã½ nghÄ©a.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH15', 'TTT_PHUQUOC_REVIEW_03', 'KH_15', 4, 'Dá»‹ch vá»¥ tá»‘t, hÆ°á»›ng dáº«n viÃªn vui váº», bá»¯a háº£i sáº£n nÃªn cÃ³ thÃªm lá»±a chá»n nháº¹ hÆ¡n.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH01', 'TTT_HUE_REVIEW_03', 'KH_01', 5, 'Tour Huáº¿ nháº¹ nhÃ ng, mÃ³n chay Ä‘Æ°á»£c chuáº©n bá»‹ tá»‘t vÃ  thuyáº¿t minh di sáº£n ráº¥t cuá»‘n hÃºt.', NOW() - INTERVAL 5 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH02', 'TTT_HUE_REVIEW_03', 'KH_02', 5, 'Gia Ä‘Ã¬nh hÃ i lÃ²ng, Äáº¡i Ná»™i vÃ  lÄƒng táº©m Ä‘Æ°á»£c sáº¯p xáº¿p Ä‘Ãºng nhá»‹p, khÃ´ng bá»‹ quÃ¡ táº£i.', NOW() - INTERVAL 5 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH03', 'TTT_HUE_REVIEW_03', 'KH_03', 4, 'Lá»‹ch trÃ¬nh tá»‘t, nÃªn thÃªm má»™t quÃ¡n cÃ  phÃª Ä‘á»‹a phÆ°Æ¡ng vÃ o buá»•i chiá»u.', NOW() - INTERVAL 4 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH04', 'TTT_HUE_REVIEW_03', 'KH_04', 5, 'KhÃ¡ch sáº¡n sáº¯p phÃ²ng Ä‘Ãºng yÃªu cáº§u, HDV kiÃªn nháº«n vÃ  há»— trá»£ ngÆ°á»i lá»›n tuá»•i tá»‘t.', NOW() - INTERVAL 4 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH05', 'TTT_HUE_REVIEW_03', 'KH_05', 5, 'Dá»‹ch vá»¥ chá»‰n chu, Äƒn uá»‘ng ngon vÃ  pháº§n Ã¡o dÃ i chá»¥p áº£nh táº¡o tráº£i nghiá»‡m Ä‘Ã¡ng nhá»›.', NOW() - INTERVAL 3 DAY);

-- Bo sung cac don dat nhieu hanh khach de tao tour gan full va full cho.
-- Moi don co: nguoi dat, danh sach nguoi dong hanh, chi tiet dat tour, dich vu, giao dich thanh toan.;

-- Báº£o Ä‘áº£m má»i tour Ä‘ang má»Ÿ bÃ¡n vÃ  Ä‘Ã£ hoÃ n thÃ nh Ä‘á»u cÃ³ HDV há»£p lá»‡,
-- Ä‘á»“ng thá»i bá»• sung lá»‹ch sá»­ tham gia, chi phÃ­ vÃ  bÃ¡o cÃ¡o sá»± cá»‘ cho cÃ¡c tour HDV Ä‘Ã£ dáº«n.;

-- Bo sung chi phi va quyet toan cho tour da hoan thanh co nhieu don dat, phuc vu luong tai chinh sau tour.
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DN_REVIEW_03_HOTEL', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', 'KhÃ¡ch sáº¡n ÄÃ  Náºµng - Há»™i An 3 Ä‘Ãªm', 42000000, 'https://seed.local/hoa-don/danang-review-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 10 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DN_REVIEW_03_BUS', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', 'Xe du lá»‹ch 29 chá»— trá»n tour', 18500000, 'https://seed.local/hoa-don/danang-review-bus.jpg', 'DA_DUYET', NOW() - INTERVAL 10 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DN_REVIEW_03_TICKET', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', 'VÃ© tham quan vÃ  show Há»™i An', 12600000, 'https://seed.local/hoa-don/danang-review-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 9 DAY);

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_DANANG_REVIEW_03_DONE', 'TTT_DANANG_REVIEW_03', 0, 0, 98000000, 0, 'NV_KT01', NOW() - INTERVAL 7 DAY, 'DA_QUYET_TOAN',
        'Quyáº¿t toÃ¡n tour ÄÃ  Náºµng - Há»™i An Ä‘Ã£ hoÃ n thÃ nh; trigger tá»± tÃ­nh doanh thu, chi phÃ­ vÃ  lá»£i nhuáº­n theo giao dá»‹ch/chi phÃ­ thá»±c táº¿.');

-- ------------------------------------------------------------
-- BO SUNG BSLK: 5 LUONG NGHIEP VU LIEN KET CHAT CHE
-- Bao phu: mo ban, dang dien ra, ket thuc, huy, quyet toan.
-- Moi bo co tour, phan cong, dich vu, hanh dong xanh, don dat,
-- hanh khach, thanh toan, ho tro, diem xanh, chi phi, danh gia/lich su.
-- ------------------------------------------------------------
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_BSLK_SEAT', 'Gháº¿ Æ°u tiÃªn hÃ ng Ä‘áº§u trÃªn xe du lá»‹ch', 'KhÃ¡ch', 180000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_BSLK_WORKSHOP', 'Workshop tráº£i nghiá»‡m vÄƒn hÃ³a Ä‘á»‹a phÆ°Æ¡ng', 'KhÃ¡ch', 320000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_BSLK_HEALTH', 'Bá»™ há»— trá»£ sá»©c khá»e cÃ¡ nhÃ¢n trong tour', 'Bá»™', 150000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_BSLK_SORT', 'PhÃ¢n loáº¡i rÃ¡c táº¡i Ä‘iá»ƒm lÆ°u trÃº vÃ  Ä‘iá»ƒm tham quan', 120);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_BSLK_NOPLASTIC', 'KhÃ´ng sá»­ dá»¥ng tÃºi nhá»±a dÃ¹ng má»™t láº§n trong suá»‘t hÃ nh trÃ¬nh', 140);

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_BSLK_GROUP900', 'BSLK-GROUP-900', 'SO_TIEN', 900000, 'Giáº£m cho nhÃ³m tá»« bá»‘n khÃ¡ch trá»Ÿ lÃªn trong cá»¥m dá»¯ liá»‡u liÃªn káº¿t', 30, 0, DATE(NOW()) - INTERVAL 5 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_BSLK_GREEN12', 'BSLK-GREEN-12', 'PHAN_TRAM', 12, 700000, 'Æ¯u Ä‘Ã£i khÃ¡ch cÃ³ Ä‘iá»ƒm xanh vÃ  chá»n hÃ nh Ä‘á»™ng xanh khi Ä‘áº·t tour', 25, 0, DATE(NOW()) - INTERVAL 5 DAY, DATE(NOW()) + INTERVAL 150 DAY, 'SAN_SANG');

INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_05', 'VC_BSLK_GROUP900', DATE(NOW()) + INTERVAL 90 DAY, NOW() - INTERVAL 2 DAY, 'DA_SU_DUNG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_11', 'VC_BSLK_GREEN12', DATE(NOW()) + INTERVAL 75 DAY, NOW() - INTERVAL 1 DAY, 'CO_HIEU_LUC');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BSLK_OPEN_FAM', 'TM_DALAT', DATE(NOW()) + INTERVAL 420 DAY, 4500000, 18, 6, 18, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BSLK_ACTIVE_QN', 'TM_QUYNHON', DATE(NOW()) - INTERVAL 1 DAY, 5600000, 16, 6, 16, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BSLK_DONE_CT', 'TM_CANTHO', DATE(NOW()) - INTERVAL 12 DAY, 3900000, 20, 8, 20, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BSLK_CANCEL_HG', 'TM_HAGIANG', DATE(NOW()) + INTERVAL 66 DAY, 6400000, 18, 8, 18, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_BSLK_SETTLE_HA', 'TM_HOIAN', DATE(NOW()) - INTERVAL 60 DAY, 4700000, 22, 8, 22, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BSLK_OPEN_FAM', 'DVT_BSLK_WORKSHOP');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BSLK_OPEN_FAM', 'DVT_BSLK_SEAT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BSLK_ACTIVE_QN', 'DVT_BSLK_HEALTH');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BSLK_DONE_CT', 'DVT_BSLK_WORKSHOP');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BSLK_CANCEL_HG', 'DVT_BSLK_HEALTH');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_BSLK_SETTLE_HA', 'DVT_BSLK_SEAT');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BSLK_OPEN_FAM', 'HDX_BSLK_NOPLASTIC');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BSLK_ACTIVE_QN', 'HDX_BSLK_SORT');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BSLK_DONE_CT', 'HDX_BSLK_NOPLASTIC');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BSLK_CANCEL_HG', 'HDX_BSLK_SORT');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_BSLK_SETTLE_HA', 'HDX_BSLK_NOPLASTIC');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_BSLK_OPEN_H11', 'TTT_BSLK_OPEN_FAM', 'NV_HDV11', NOW() - INTERVAL 1 DAY, 'DA_DONG_Y', NOW() - INTERVAL 20 HOUR);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_BSLK_ACTIVE_H12', 'TTT_BSLK_ACTIVE_QN', 'NV_HDV12', NOW() - INTERVAL 10 DAY, 'DA_DONG_Y', NOW() - INTERVAL 9 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_BSLK_DONE_H11', 'TTT_BSLK_DONE_CT', 'NV_HDV11', NOW() - INTERVAL 22 DAY, 'DA_DONG_Y', NOW() - INTERVAL 21 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_BSLK_CANCEL_H12', 'TTT_BSLK_CANCEL_HG', 'NV_HDV12', NOW() - INTERVAL 5 DAY, 'TU_CHOI', NOW() - INTERVAL 4 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_BSLK_SETTLE_H11', 'TTT_BSLK_SETTLE_HA', 'NV_HDV11', NOW() - INTERVAL 70 DAY, 'DA_DONG_Y', NOW() - INTERVAL 69 DAY);

UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA' WHERE ma_tour_thuc_te = 'TTT_BSLK_ACTIVE_QN';
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_BSLK_DONE_CT';
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_BSLK_SETTLE_HA';
UPDATE tour_thuc_tes SET trang_thai = 'HUY' WHERE ma_tour_thuc_te = 'TTT_BSLK_CANCEL_HG';
UPDATE don_dat_tours SET trang_thai = 'DA_XAC_NHAN' WHERE ma_dat_tour = 'DDT_BSLK_REVIEW_A';

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BSLK_ACTIVE_KH06', 'TTT_BSLK_ACTIVE_QN', 'KH_06', NULL, 'NGUOI_DAT', 'NV_HDV12', NOW() - INTERVAL 5 HOUR, 'BÃ£i Ká»³ Co', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BSLK_ACTIVE_NDH1', 'TTT_BSLK_ACTIVE_QN', NULL, 'NDH_BSLK_ACTIVE_A_01', 'NGUOI_DONG_HANH', 'NV_HDV12', NOW() - INTERVAL 5 HOUR, 'BÃ£i Ká»³ Co', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BSLK_ACTIVE_NDH2', 'TTT_BSLK_ACTIVE_QN', NULL, 'NDH_BSLK_ACTIVE_A_02', 'NGUOI_DONG_HANH', 'NV_HDV12', NOW() - INTERVAL 5 HOUR, 'BÃ£i Ká»³ Co', 'CHUA_DIEM_DANH');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_BSLK_ACTIVE_SORT', 'TTT_BSLK_ACTIVE_QN', 'KH_06', 'HDX_BSLK_SORT', 'NV_HDV12', NOW() - INTERVAL 2 HOUR,
        'HDV xÃ¡c nháº­n nhÃ³m khÃ¡ch phÃ¢n loáº¡i rÃ¡c sau bá»¯a trÆ°a táº¡i lÃ ng chÃ i.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_BSLK_ACTIVE_SEA', 'TTT_BSLK_ACTIVE_QN', 'NV_HDV12', 'GiÃ³ biá»ƒn tÄƒng nháº¹ trÆ°á»›c giá» Ä‘i Eo GiÃ³.',
        'HDV Ä‘á»•i thá»© tá»± tham quan, Æ°u tiÃªn Ä‘iá»ƒm trong nhÃ  vÃ  cáº­p nháº­t giá» táº­p trung cho khÃ¡ch.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 90 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_ACTIVE_WATER', 'TTT_BSLK_ACTIVE_QN', 'NV_HDV12', 'NÆ°á»›c Ä‘iá»‡n giáº£i vÃ  tÃºi y táº¿ bá»• sung', 260000, 'https://seed.local/hoa-don/bslk-quynhon-yte.jpg', 'CHO_DUYET', NOW() - INTERVAL 70 MINUTE);

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_BSLK_DONE_KH12', 'KH_12', 'TTT_BSLK_DONE_CT', 'CTDT_BSLK_DONE_A_KH', DATE(NOW()) - INTERVAL 12 DAY);
-- Khong tao danh_gia_khs cho KH_16: du lieu nay danh rieng de quay thao tac gui danh gia moi.
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_BSLK_REVIEW_KH16', 'KH_16', 'TTT_BSLK_DONE_CT', 'CTDT_BSLK_REVIEW_A_KH', DATE(NOW()) - INTERVAL 12 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_BSLK_SETTLE_KH09', 'KH_09', 'TTT_BSLK_SETTLE_HA', 'CTDT_BSLK_SETTLE_A_KH', DATE(NOW()) - INTERVAL 60 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_BSLK_DONE_MEAL', 'TTT_BSLK_DONE_CT', 'NV_HDV11', 'NhÃ  vÆ°á»n Ä‘á»•i thá»±c Ä‘Æ¡n chay sÃ¡t giá» dÃ¹ng bá»¯a.',
        'HDV xÃ¡c nháº­n láº¡i thÃ nh pháº§n mÃ³n Äƒn vá»›i khÃ¡ch vÃ  chuáº©n bá»‹ pháº§n riÃªng khÃ´ng dÃ¹ng nÆ°á»›c máº¯m.', 'THAP', 'AN_UONG', NOW() - INTERVAL 11 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_DONE_BOAT', 'TTT_BSLK_DONE_CT', 'NV_HDV11', 'Thuyá»n nhá» tham quan ráº¡ch phá»¥', 720000, 'https://seed.local/hoa-don/bslk-cantho-thuyen.jpg', 'DA_DUYET', NOW() - INTERVAL 11 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_BSLK_DONE_KH12', 'TTT_BSLK_DONE_CT', 'KH_12', 5, 'Tour Cáº§n ThÆ¡ chuáº©n bá»‹ mÃ³n chay chu Ä‘Ã¡o, lá»›p lÃ m bÃ¡nh dÃ¢n gian ráº¥t vui.', NOW() - INTERVAL 8 DAY);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_SETTLE_HOTEL', 'TTT_BSLK_SETTLE_HA', 'NV_HDV11', 'KhÃ¡ch sáº¡n Há»™i An hai Ä‘Ãªm cho Ä‘oÃ n nhá»', 7800000, 'https://seed.local/hoa-don/bslk-hoian-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 58 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_SETTLE_MEAL', 'TTT_BSLK_SETTLE_HA', 'NV_HDV11', 'Bá»¯a tá»‘i Ä‘á»‹a phÆ°Æ¡ng vÃ  workshop Ä‘Ã¨n lá»“ng', 2350000, 'https://seed.local/hoa-don/bslk-hoian-meal.jpg', 'DA_DUYET', NOW() - INTERVAL 58 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_BSLK_SETTLE_KH09', 'TTT_BSLK_SETTLE_HA', 'KH_09', 5, 'Tour Há»™i An váº­n hÃ nh mÆ°á»£t, hÃ³a Ä‘Æ¡n doanh nghiá»‡p Ä‘Æ°á»£c há»— trá»£ rÃµ rÃ ng.', NOW() - INTERVAL 55 DAY);
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_BSLK_SETTLE_HA', 'TTT_BSLK_SETTLE_HA', 0, 0, 12000000, 0, 'NV_KT01', NOW() - INTERVAL 54 DAY, 'DA_QUYET_TOAN',
        'Quyáº¿t toÃ¡n bá»™ dá»¯ liá»‡u BSLK Há»™i An, doanh thu láº¥y tá»« giao dá»‹ch Ä‘Ã£ thanh toÃ¡n vÃ  chi phÃ­ Ä‘Ã£ duyá»‡t.');

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_BSLK_CANCEL_REFUND', 'DDT_BSLK_CANCEL_A', 'HOAN_TIEN', 'HE_THONG', 12950000, 'BANK-BSLK-REFUND', 'CHO_THANH_TOAN', NULL);

INSERT INTO nhat_ky_doi_diems (ma_nhat_ky_doi_diem, ma_khach_hang, ma_voucher, diem_quy_doi, ngay_quy_doi)
VALUES ('NKDD_BSLK_KH05_GROUP', 'KH_05', 'VC_BSLK_GROUP900', 900, NOW() - INTERVAL 2 DAY);

INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_BSLK_OPEN_SEAT', 'DDT_BSLK_OPEN_B', 'KH_11', 'DICH_VU_THEM', 'KhÃ¡ch cáº§n xÃ¡c nháº­n gháº¿ hÃ ng Ä‘áº§u vÃ  há»— trá»£ lÃªn xuá»‘ng xe do Ä‘au lÆ°ng.', 'CHO_BO_SUNG', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_BSLK_CANCEL_RF', 'DDT_BSLK_CANCEL_A', 'KH_10', 'HOAN_TIEN', 'Tour HÃ  Giang bá»‹ há»§y do Ä‘iá»u kiá»‡n an toÃ n, káº¿ toÃ¡n cáº§n xá»­ lÃ½ hoÃ n tiá»n.', 'CHUA_XU_LY', 'NV_KT01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_BSLK_SETTLE_INV', 'DDT_BSLK_SETTLE_A', 'KH_09', 'HOA_DON', 'KhÃ¡ch yÃªu cáº§u xuáº¥t hÃ³a Ä‘Æ¡n cÃ´ng ty sau khi tour Há»™i An Ä‘Ã£ quyáº¿t toÃ¡n.', 'DA_XU_LY', 'NV_KT01');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_BSLK_OPEN_TOUR', 'TK_MGR01', 'THEM', 'TOURTHUCTE_DIEU_HANH', 'TTT_BSLK_OPEN_FAM', NOW() - INTERVAL 1 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_BSLK_ACTIVE_CP', 'TK_HDV12', 'THEM', 'CHIPHITHUCTE_HDV', 'CP_BSLK_ACTIVE_WATER', NOW() - INTERVAL 65 MINUTE);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_BSLK_SETTLE_QT', 'TK_KT01', 'THEM', 'QUYETTOAN_KETOAN', 'QT_BSLK_SETTLE_HA', NOW() - INTERVAL 54 DAY);

-- ------------------------------------------------------------
-- BO SUNG TMNEW: TOUR MAU MOI VA CAC BO DU LIEU LIEN KET DAY DU
-- Gom tour mau moi, lich trinh du ngay, tour thuc te, don dat nhieu khach,
-- HDV, diem danh, hanh dong xanh, su co, chi phi, quyet toan, ho tro, nhat ky.
-- ------------------------------------------------------------
INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_PHONGNHA', 'Phong Nha - Hang Ä‘á»™ng ká»³ quan vÃ  sÃ´ng Son',
        'HÃ nh trÃ¬nh 3 ngÃ y khÃ¡m phÃ¡ Phong Nha, Ä‘á»™ng ThiÃªn ÄÆ°á»ng, sÃ´ng ChÃ y - hang Tá»‘i vÃ  nhá»‹p sá»‘ng ven sÃ´ng Son. Tour phÃ¹ há»£p cho nhÃ³m báº¡n, gia Ä‘Ã¬nh yÃªu thiÃªn nhiÃªn vÃ  khÃ¡ch muá»‘n káº¿t há»£p tráº£i nghiá»‡m hang Ä‘á»™ng vá»›i nghá»‰ dÆ°á»¡ng nháº¹.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- VÃ© tham quan hang Ä‘á»™ng vÃ  thuyá»n sÃ´ng Son
- LÆ°u trÃº, bá»¯a Äƒn vÃ  hÆ°á»›ng dáº«n viÃªn
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT vÃ  tips', 3, 5200000, 0, 0);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_CAMAU', 'CÃ  Mau - MÅ©i Ä‘áº¥t cuá»‘i trá»i vÃ  rá»«ng ngáº­p máº·n',
        'Tour 4 ngÃ y Ä‘i qua CÃ  Mau, Äáº¥t MÅ©i, rá»«ng U Minh vÃ  cÃ¡c tuyáº¿n sÃ´ng nÆ°á»›c Ä‘áº·c trÆ°ng miá»n cá»±c Nam. Lá»‹ch trÃ¬nh nháº¥n máº¡nh tráº£i nghiá»‡m cá»™ng Ä‘á»“ng, áº©m thá»±c Ä‘á»‹a phÆ°Æ¡ng vÃ  hoáº¡t Ä‘á»™ng báº£o tá»“n há»‡ sinh thÃ¡i ngáº­p máº·n.

Bao gá»“m:
- Xe vÃ  tÃ u tham quan theo chÆ°Æ¡ng trÃ¬nh
- VÃ© vÃ o khu du lá»‹ch Äáº¥t MÅ©i, rá»«ng U Minh
- LÆ°u trÃº, bá»¯a Äƒn vÃ  hÆ°á»›ng dáº«n viÃªn
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Phá»¥ phÃ­ phÃ²ng Ä‘Æ¡n
- VAT vÃ  tips', 4, 6800000, 0, 0);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_BABE', 'Ba Bá»ƒ - Há»“ xanh vÃ  báº£n lÃ ng TÃ y',
        'Chuyáº¿n Ä‘i 2 ngÃ y vá» há»“ Ba Bá»ƒ, Ä‘á»™ng PuÃ´ng vÃ  báº£n PÃ¡c NgÃ²i, dÃ nh cho khÃ¡ch muá»‘n nghá»‰ ngáº¯n ngÃ y trong khÃ´ng gian yÃªn tÄ©nh, gáº§n thiÃªn nhiÃªn vÃ  vÄƒn hÃ³a báº£n Ä‘á»‹a.

Bao gá»“m:
- Xe Ä‘Æ°a Ä‘Ã³n theo chÆ°Æ¡ng trÃ¬nh
- Thuyá»n há»“ Ba Bá»ƒ, vÃ© tham quan
- Homestay, bá»¯a Äƒn Ä‘á»‹a phÆ°Æ¡ng vÃ  hÆ°á»›ng dáº«n viÃªn
KhÃ´ng bao gá»“m:
- Chi phÃ­ cÃ¡ nhÃ¢n
- Äá»“ uá»‘ng ngoÃ i chÆ°Æ¡ng trÃ¬nh
- VAT vÃ  tips', 2, 3400000, 0, 0);

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PN_NEW_01', 'TM_PHONGNHA', 1, 'Äá»“ng Há»›i - Phong Nha - sÃ´ng Son', 'ÄÃ³n khÃ¡ch, di chuyá»ƒn vá» Phong Nha, Ä‘i thuyá»n sÃ´ng Son vÃ  nháº­n phÃ²ng nghá»‰.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÃ¡ sÃ´ng Son, rau rá»«ng, canh chua | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PN_NEW_02', 'TM_PHONGNHA', 2, 'Äá»™ng ThiÃªn ÄÆ°á»ng - sÃ´ng ChÃ y', 'Tham quan Ä‘á»™ng ThiÃªn ÄÆ°á»ng, tráº£i nghiá»‡m tuyáº¿n sÃ´ng ChÃ y vÃ  hoáº¡t Ä‘á»™ng nháº¹ ngoÃ i trá»i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: GÃ  nÆ°á»›ng, xÃ´i náº¿p, rau luá»™c | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PN_NEW_03', 'TM_PHONGNHA', 3, 'LÃ ng Ä‘á»‹a phÆ°Æ¡ng - Äá»“ng Há»›i', 'Gáº·p há»™ dÃ¢n lÃ m sáº£n pháº©m thá»§ cÃ´ng, mua Ä‘áº·c sáº£n vÃ  káº¿t thÃºc chÆ°Æ¡ng trÃ¬nh.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: ChÃ¡o canh Quáº£ng BÃ¬nh, bÃ¡nh lá»c | Chiá»u: TrÃ¡i cÃ¢y nháº¹');

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_01', 'TM_CAMAU', 1, 'CÃ  Mau - chá»£ Ä‘Ãªm - bá» kÃ¨', 'ÄÃ³n khÃ¡ch, nháº­n phÃ²ng, tham quan chá»£ Ä‘Ãªm vÃ  nghe giá»›i thiá»‡u vÄƒn hÃ³a miá»n cá»±c Nam.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Láº©u máº¯m, rau Ä‘á»“ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_02', 'TM_CAMAU', 2, 'Äáº¥t MÅ©i - cá»™t má»‘c tá»a Ä‘á»™', 'Äi tÃ u Ä‘áº¿n Äáº¥t MÅ©i, tham quan rá»«ng ngáº­p máº·n vÃ  Ä‘iá»ƒm cá»±c Nam Tá»• quá»‘c.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: Cua CÃ  Mau, cÃ¡ thÃ²i lÃ²i nÆ°á»›ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_03', 'TM_CAMAU', 3, 'Rá»«ng U Minh - tráº£i nghiá»‡m cá»™ng Ä‘á»“ng', 'Tham quan rá»«ng trÃ m, nghe ká»ƒ chuyá»‡n nghá» gÃ¡c kÃ¨o ong vÃ  dÃ¹ng bá»¯a táº¡i há»™ dÃ¢n.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÃ¡ lÃ³c nÆ°á»›ng trui, máº­t ong rá»«ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_04', 'TM_CAMAU', 4, 'Mua Ä‘áº·c sáº£n - tiá»…n khÃ¡ch', 'Mua quÃ  Ä‘á»‹a phÆ°Æ¡ng, tá»•ng káº¿t hÃ nh trÃ¬nh xanh vÃ  tiá»…n khÃ¡ch ra sÃ¢n bay/báº¿n xe.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: BÃºn nÆ°á»›c lÃ¨o, bÃ¡nh táº±m cay | Chiá»u: TrÃ¡i cÃ¢y nháº¹');

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BB_NEW_01', 'TM_BABE', 1, 'HÃ  Ná»™i - há»“ Ba Bá»ƒ - PÃ¡c NgÃ²i', 'Di chuyá»ƒn lÃªn Ba Bá»ƒ, Ä‘i thuyá»n trÃªn há»“, nháº­n homestay vÃ  Äƒn tá»‘i cÃ¹ng gia Ä‘Ã¬nh Ä‘á»‹a phÆ°Æ¡ng.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: CÃ¡ há»“ nÆ°á»›ng, lá»£n báº£n, rau rá»«ng | Chiá»u: TrÃ¡i cÃ¢y nháº¹');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BB_NEW_02', 'TM_BABE', 2, 'Äá»™ng PuÃ´ng - HÃ  Ná»™i', 'Tham quan Ä‘á»™ng PuÃ´ng, mua Ä‘áº·c sáº£n, Äƒn trÆ°a vÃ  vá» láº¡i HÃ  Ná»™i.', 'SÃ¡ng: Buffet khÃ¡ch sáº¡n | TrÆ°a: XÃ´i ngÅ© sáº¯c, gÃ  Ä‘á»“i | Chiá»u: TrÃ¡i cÃ¢y nháº¹');

INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_TMNEW_CAVE', 'GÃ³i Ä‘Ã¨n Ä‘á»™i Ä‘áº§u vÃ  thiáº¿t bá»‹ hang Ä‘á»™ng', 'KhÃ¡ch', 220000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_TMNEW_BOAT', 'TÃ u riÃªng tham quan tuyáº¿n sÃ´ng nÆ°á»›c', 'Chuyáº¿n', 1800000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_TMNEW_HOMESTAY', 'NÃ¢ng cáº¥p phÃ²ng homestay riÃªng', 'PhÃ²ng/Ä‘Ãªm', 420000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_TMNEW_WATER', 'DÃ¹ng bÃ¬nh nÆ°á»›c cÃ¡ nhÃ¢n vÃ  tráº¡m tiáº¿p nÆ°á»›c cá»§a Ä‘oÃ n', 100);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_TMNEW_LOCAL', 'Æ¯u tiÃªn mua sáº£n pháº©m cá»™ng Ä‘á»“ng Ä‘á»‹a phÆ°Æ¡ng cÃ³ bao bÃ¬ tÃ¡i sá»­ dá»¥ng', 130);

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_TMNEW_1M', 'TMNEW-1M', 'SO_TIEN', 1000000, 'Giáº£m cho Ä‘oÃ n tá»« mÆ°á»i khÃ¡ch trá»Ÿ lÃªn cá»§a tour máº«u má»›i', 20, 0, DATE(NOW()) - INTERVAL 3 DAY, DATE(NOW()) + INTERVAL 210 DAY, 'SAN_SANG');
INSERT INTO khuyen_mai_khs (ma_khach_hang, ma_voucher, ngay_het_han, ngay_nhan, trang_thai)
VALUES ('KH_03', 'VC_TMNEW_1M', DATE(NOW()) + INTERVAL 120 DAY, NOW() - INTERVAL 3 DAY, 'DA_SU_DUNG');

INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_TMNEW_PN_OPEN', 'TM_PHONGNHA', DATE(NOW()) + INTERVAL 520 DAY, 5450000, 24, 8, 24, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_TMNEW_CM_DONE', 'TM_CAMAU', DATE(NOW()) - INTERVAL 105 DAY, 7100000, 22, 8, 22, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_TMNEW_BB_ACTIVE', 'TM_BABE', DATE(NOW()) - INTERVAL 1 DAY, 3600000, 16, 6, 16, 'MO_BAN');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_TMNEW_PN_QT', 'TM_PHONGNHA', DATE(NOW()) - INTERVAL 135 DAY, 5400000, 20, 8, 20, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_TMNEW_PN_OPEN', 'DVT_TMNEW_CAVE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_TMNEW_CM_DONE', 'DVT_TMNEW_BOAT');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_TMNEW_BB_ACTIVE', 'DVT_TMNEW_HOMESTAY');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_TMNEW_PN_QT', 'DVT_TMNEW_CAVE');

INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_TMNEW_PN_OPEN', 'HDX_TMNEW_WATER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_TMNEW_CM_DONE', 'HDX_TMNEW_LOCAL');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_TMNEW_BB_ACTIVE', 'HDX_TMNEW_WATER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_TMNEW_PN_QT', 'HDX_TMNEW_LOCAL');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_TMNEW_PN_OPEN_H11', 'TTT_TMNEW_PN_OPEN', 'NV_HDV11', NOW() - INTERVAL 2 DAY, 'DA_DONG_Y', NOW() - INTERVAL 1 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_TMNEW_CM_DONE_H12', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', NOW() - INTERVAL 125 DAY, 'DA_DONG_Y', NOW() - INTERVAL 124 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_TMNEW_BB_ACTIVE_H11', 'TTT_TMNEW_BB_ACTIVE', 'NV_HDV11', NOW() - INTERVAL 7 DAY, 'DA_DONG_Y', NOW() - INTERVAL 6 DAY);
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_TMNEW_PN_QT_H12', 'TTT_TMNEW_PN_QT', 'NV_HDV12', NOW() - INTERVAL 150 DAY, 'DA_DONG_Y', NOW() - INTERVAL 149 DAY);

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_TMNEW_CM_DONE';
UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA' WHERE ma_tour_thuc_te = 'TTT_TMNEW_BB_ACTIVE';
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_TMNEW_PN_QT';

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_KH08', 'TTT_TMNEW_BB_ACTIVE', 'KH_08', NULL, 'NGUOI_DAT', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Báº¿n thuyá»n há»“ Ba Bá»ƒ', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_NDH01', 'TTT_TMNEW_BB_ACTIVE', NULL, 'NDH_TMN_BB04_01', 'NGUOI_DONG_HANH', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Báº¿n thuyá»n há»“ Ba Bá»ƒ', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_NDH02', 'TTT_TMNEW_BB_ACTIVE', NULL, 'NDH_TMN_BB04_02', 'NGUOI_DONG_HANH', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Báº¿n thuyá»n há»“ Ba Bá»ƒ', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_NDH03', 'TTT_TMNEW_BB_ACTIVE', NULL, 'NDH_TMN_BB04_03', 'NGUOI_DONG_HANH', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Báº¿n thuyá»n há»“ Ba Bá»ƒ', 'CHUA_DIEM_DANH');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_TMN_BB_WATER', 'TTT_TMNEW_BB_ACTIVE', 'KH_08', 'HDX_TMNEW_WATER', 'NV_HDV11', NOW() - INTERVAL 3 HOUR,
        'KhÃ¡ch dÃ¹ng bÃ¬nh nÆ°á»›c cÃ¡ nhÃ¢n vÃ  tiáº¿p nÆ°á»›c táº¡i homestay thay cho chai nhá»±a.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_TMN_BB_RAIN', 'TTT_TMNEW_BB_ACTIVE', 'NV_HDV11', 'MÆ°a nháº¹ lÃ m Ä‘Æ°á»ng tá»« báº¿n thuyá»n vá» báº£n trÆ¡n hÆ¡n dá»± kiáº¿n.',
        'HDV Ä‘á»•i sang Ä‘Æ°á»ng ngáº¯n hÆ¡n, nháº¯c khÃ¡ch Ä‘i cháº­m vÃ  há»— trá»£ ngÆ°á»i lá»›n tuá»•i.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 2 HOUR);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_BB_RAINCOAT', 'TTT_TMNEW_BB_ACTIVE', 'NV_HDV11', 'Ão mÆ°a má»ng vÃ  nÆ°á»›c áº¥m cho Ä‘oÃ n Ba Bá»ƒ', 340000, 'https://seed.local/hoa-don/tmnew-babe-raincoat.jpg', 'CHO_DUYET', NOW() - INTERVAL 90 MINUTE);

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_TMN_CM_KH04', 'KH_04', 'TTT_TMNEW_CM_DONE', 'CTDT_TMN_CM06_KH', DATE(NOW()) - INTERVAL 105 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_TMN_PN_KH02', 'KH_02', 'TTT_TMNEW_PN_QT', 'CTDT_TMN_PN05_KH', DATE(NOW()) - INTERVAL 135 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_TMN_CM_BOAT', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', 'TÃ u tham quan Äáº¥t MÅ©i Ä‘á»•i giá» xuáº¥t báº¿n do thá»§y triá»u.',
        'ThÃ´ng bÃ¡o sá»›m cho khÃ¡ch, Ä‘iá»u chá»‰nh giá» Äƒn trÆ°a vÃ  giá»¯ nguyÃªn Ä‘á»§ Ä‘iá»ƒm tham quan.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 103 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_CM_BOAT', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', 'TÃ u riÃªng tuyáº¿n Äáº¥t MÅ©i vÃ  rá»«ng ngáº­p máº·n', 7800000, 'https://seed.local/hoa-don/tmnew-camau-boat.jpg', 'DA_DUYET', NOW() - INTERVAL 103 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_CM_MEAL', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', 'Bá»¯a Äƒn cá»™ng Ä‘á»“ng táº¡i Äáº¥t MÅ©i', 3600000, 'https://seed.local/hoa-don/tmnew-camau-meal.jpg', 'DA_DUYET', NOW() - INTERVAL 102 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_TMN_CM_KH04', 'TTT_TMNEW_CM_DONE', 'KH_04', 5, 'Tour CÃ  Mau nhiá»u tráº£i nghiá»‡m tháº­t, tÃ u riÃªng giÃºp lá»‹ch trÃ¬nh thoáº£i mÃ¡i vÃ  Ä‘Ãºng giá».', NOW() - INTERVAL 99 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_TMN_PN_CAVE', 'TTT_TMNEW_PN_QT', 'NV_HDV12', 'Má»™t khÃ¡ch hÆ¡i má»‡t khi di chuyá»ƒn trong hang do Ä‘á»™ áº©m cao.',
        'HDV bá»‘ trÃ­ nghá»‰ thÃªm mÆ°á»i phÃºt, kiá»ƒm tra sá»©c khá»e vÃ  Ä‘iá»u chá»‰nh tá»‘c Ä‘á»™ Ä‘oÃ n.', 'THAP', 'Y_TE', NOW() - INTERVAL 134 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_PN_HOTEL', 'TTT_TMNEW_PN_QT', 'NV_HDV12', 'KhÃ¡ch sáº¡n Phong Nha hai Ä‘Ãªm cho Ä‘oÃ n nÄƒm khÃ¡ch', 11200000, 'https://seed.local/hoa-don/tmnew-phongnha-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 133 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_PN_TICKET', 'TTT_TMNEW_PN_QT', 'NV_HDV12', 'VÃ© hang Ä‘á»™ng vÃ  thuyá»n sÃ´ng Son', 5200000, 'https://seed.local/hoa-don/tmnew-phongnha-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 133 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_TMN_PN_KH02', 'TTT_TMNEW_PN_QT', 'KH_02', 4, 'Hang Ä‘á»™ng ráº¥t Ä‘áº¹p, thiáº¿t bá»‹ chuáº©n bá»‹ Ä‘áº§y Ä‘á»§, nÃªn thÃªm thá»i gian nghá»‰ giá»¯a hai Ä‘iá»ƒm.', NOW() - INTERVAL 130 DAY);
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_TMN_PN_DONE', 'TTT_TMNEW_PN_QT', 0, 0, 23500000, 0, 'NV_KT01', NOW() - INTERVAL 129 DAY, 'DA_QUYET_TOAN',
        'Quyáº¿t toÃ¡n tour máº«u má»›i Phong Nha, Ä‘Ã£ cÃ³ Ä‘á»§ doanh thu, chi phÃ­ thá»±c táº¿, lá»‹ch sá»­ tour vÃ  Ä‘Ã¡nh giÃ¡.');

INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TMN_PN10_LIST', 'DDT_TMNEW_PN10', 'KH_03', 'THONG_TIN_HANH_KHACH', 'ÄoÃ n mÆ°á»i khÃ¡ch cáº§n xÃ¡c nháº­n láº¡i danh sÃ¡ch cÄƒn cÆ°á»›c trÆ°á»›c ngÃ y khá»Ÿi hÃ nh.', 'CHUA_XU_LY', 'NV_SALES01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TMN_BB_MEAL', 'DDT_TMNEW_BB04', 'KH_08', 'AN_UONG', 'KhÃ¡ch yÃªu cáº§u thá»±c Ä‘Æ¡n Ã­t muá»‘i cho bá»¯a tá»‘i homestay Ba Bá»ƒ.', 'DA_XU_LY', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TMN_CM_FEEDBACK', 'DDT_TMNEW_CM06', 'KH_04', 'PHAN_HOI_SAU_TOUR', 'KhÃ¡ch gÃ³p Ã½ giá»¯ thÃªm thá»i gian á»Ÿ rá»«ng U Minh cho cÃ¡c Ä‘oÃ n sau.', 'DA_XU_LY', 'NV_MGR01');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_TM_PN', 'TK_MGR01', 'THEM', 'TOURMAU_SANPHAM', 'TM_PHONGNHA', NOW() - INTERVAL 3 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_DDT_PN10', 'TK_SALES01', 'THEM', 'DONDATTOUR_SALES', 'DDT_TMNEW_PN10', NOW() - INTERVAL 3 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_BB_CP', 'TK_HDV11', 'THEM', 'CHIPHITHUCTE_HDV', 'CP_TMN_BB_RAINCOAT', NOW() - INTERVAL 80 MINUTE);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_PN_QT', 'TK_KT01', 'THEM', 'QUYETTOAN_KETOAN', 'QT_TMN_PN_DONE', NOW() - INTERVAL 129 DAY);

-- ------------------------------------------------------------
-- Bá»” SUNG Dá»® LIá»†U NGHIá»†P Vá»¤ THá»°C Táº¾ VÃ€ CHUáº¨N HOÃ Ná»˜I DUNG
-- ------------------------------------------------------------
-- Hai tour Ä‘ang chá» kÃ­ch hoáº¡t, chÆ°a gá»­i yÃªu cáº§u phÃ¢n cÃ´ng cho báº¥t ká»³ hÆ°á»›ng dáº«n viÃªn nÃ o.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CHOKH_CAMAU', 'TM_CAMAU', DATE(NOW()) + INTERVAL 435 DAY, 7100000, 22, 8, 22, 'CHO_KICH_HOAT');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CHOKH_BABE', 'TM_BABE', DATE(NOW()) + INTERVAL 442 DAY, 4680000, 20, 6, 20, 'CHO_KICH_HOAT');

-- ÄÆ¡n Ä‘Ã£ thanh toÃ¡n thÃ nh cÃ´ng nhÆ°ng Ä‘ang chá» nhÃ¢n viÃªn xÃ¡c nháº­n Ä‘á»‘i soÃ¡t.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_XN_TTTC_DALAT', 'TTT_BSLK_OPEN_FAM', 'KH_15', NOW() - INTERVAL 6 HOUR,
        4500000, 'CHO_XAC_NHAN', NOW() + INTERVAL 2 DAY,
        'YÃªu cáº§u xuáº¥t hÃ³a Ä‘Æ¡n Ä‘iá»‡n tá»­ vÃ  há»— trá»£ giá» táº­p trung trá»… 15 phÃºt.', 'HDX_BSLK_NOPLASTIC:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_XN_TTTC_DALAT_KH', 'DDT_XN_TTTC_DALAT', 'KH_15', NULL, 'NGUOI_DAT', 4500000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_XN_TTTC_DALAT', 'DDT_XN_TTTC_DALAT', 'THANH_TOAN', 'CHUYEN_KHOAN', 4500000,
        'NGAN-HANG-XAC-NHAN-001', 'THANH_CONG', NOW() - INTERVAL 5 HOUR);

-- Má»—i ngÃ y lÆ°u timeline trong trÆ°á»ng hoat_dong, má»—i dÃ²ng gá»“m thá»i gian vÃ  hoáº¡t Ä‘á»™ng tÆ°Æ¡ng á»©ng.
UPDATE lich_trinh_tours
SET hoat_dong = CASE MOD(CRC32(ma_lich_trinh_tour), 3)
    WHEN 0 THEN '06:30 - DÃ¹ng bá»¯a sÃ¡ng vÃ  chuáº©n bá»‹ cho lá»‹ch trÃ¬nh trong ngÃ y.'
        || CHAR(10) || '08:00 - ' || TRIM(TRAILING '.' FROM TRIM(mo_ta))
        || CHAR(10) || '11:30 - DÃ¹ng bá»¯a trÆ°a theo thá»±c Ä‘Æ¡n cá»§a chÆ°Æ¡ng trÃ¬nh.'
        || CHAR(10) || '14:00 - KhÃ¡m phÃ¡ cáº£nh quan thiÃªn nhiÃªn vÃ  tÃ¬m hiá»ƒu nÃ©t Ä‘áº·c trÆ°ng cá»§a Ä‘iá»ƒm Ä‘áº¿n.'
        || CHAR(10) || '18:30 - Nghá»‰ ngÆ¡i táº¡i nÆ¡i lÆ°u trÃº hoáº·c Ä‘iá»ƒm dá»«ng chÃ¢n Ä‘Ã£ bá»‘ trÃ­.'
    WHEN 1 THEN '07:00 - Táº­p trung, kiá»ƒm tra hÃ nh lÃ½ vÃ  báº¯t Ä‘áº§u lá»‹ch trÃ¬nh trong ngÃ y.'
        || CHAR(10) || '08:30 - ' || TRIM(TRAILING '.' FROM TRIM(mo_ta))
        || CHAR(10) || '12:00 - DÃ¹ng bá»¯a trÆ°a theo thá»±c Ä‘Æ¡n cá»§a chÆ°Æ¡ng trÃ¬nh.'
        || CHAR(10) || '14:30 - Tráº£i nghiá»‡m cáº£nh quan vÃ  vÄƒn hÃ³a Ä‘á»‹a phÆ°Æ¡ng theo hÃ nh trÃ¬nh.'
        || CHAR(10) || '19:00 - Vá» nÆ¡i lÆ°u trÃº, nghá»‰ ngÆ¡i vÃ  chuáº©n bá»‹ cho ngÃ y tiáº¿p theo.'
    ELSE '06:45 - DÃ¹ng bá»¯a sÃ¡ng vÃ  nghe hÆ°á»›ng dáº«n lá»‹ch trÃ¬nh trong ngÃ y.'
        || CHAR(10) || '09:00 - ' || TRIM(TRAILING '.' FROM TRIM(mo_ta))
        || CHAR(10) || '11:45 - ThÆ°á»Ÿng thá»©c bá»¯a trÆ°a vá»›i mÃ³n Äƒn Ä‘áº·c trÆ°ng Ä‘á»‹a phÆ°Æ¡ng.'
        || CHAR(10) || '15:00 - Tham quan bá»• sung vÃ  tÃ¬m hiá»ƒu cáº£nh quan thiÃªn nhiÃªn táº¡i Ä‘iá»ƒm Ä‘áº¿n.'
        || CHAR(10) || '18:00 - Nháº­n phÃ²ng hoáº·c nghá»‰ ngÆ¡i táº¡i Ä‘iá»ƒm dá»«ng chÃ¢n theo chÆ°Æ¡ng trÃ¬nh.'
    END,
    mo_ta = NULL;

-- Má»—i ngÃ y báº¯t buá»™c cÃ³ nhiá»u má»‘c giá» hoáº¡t Ä‘á»™ng Ä‘Ãºng Ä‘á»‹nh dáº¡ng timeline.;

-- Ghi chÃº cáº¥p Ä‘Æ¡n chá»‰ lÆ°u cÃ¡c yÃªu cáº§u váº­n hÃ nh chung, khÃ´ng gáº¯n thÃ´ng tin riÃªng cá»§a hÃ nh khÃ¡ch.
UPDATE don_dat_tours
SET ghi_chu = CASE MOD(CRC32(ma_dat_tour), 5)
    WHEN 0 THEN NULL
    WHEN 1 THEN 'YÃªu cáº§u in hÃ³a Ä‘Æ¡n Ä‘iá»‡n tá»­ sau khi hoÃ n táº¥t thanh toÃ¡n.'
    WHEN 2 THEN 'Mang theo hÃ nh lÃ½ lá»›n, cáº§n há»— trá»£ sáº¯p xáº¿p khoang chá»©a Ä‘á»“.'
    WHEN 3 THEN 'Há»— trá»£ giá» táº­p trung trá»… 15 phÃºt so vá»›i lá»‹ch Ä‘Ã³n ban Ä‘áº§u.'
    ELSE 'YÃªu cáº§u nháº¯c láº¡i Ä‘iá»ƒm táº­p trung vÃ  sá»‘ Ä‘iá»‡n thoáº¡i Ä‘iá»u phá»‘i trÆ°á»›c ngÃ y khá»Ÿi hÃ nh.'
END;

-- Chuáº©n hoÃ¡ mÃ´ táº£ chuyÃªn mÃ´n cá»§a hÆ°á»›ng dáº«n viÃªn theo kháº£ nÄƒng phá»¥c vá»¥ tour.
UPDATE nang_luc_nhan_viens
SET chuyen_mon = CASE ma_nhan_vien
    WHEN 'NV_HDV01' THEN 'ChuyÃªn thuyáº¿t minh lá»‹ch sá»­ - vÄƒn hÃ³a: CÃ³ kháº£ nÄƒng ká»ƒ chuyá»‡n háº¥p dáº«n vá» di tÃ­ch, lá»‹ch sá»­, phong tá»¥c vÃ  Ä‘á»i sá»‘ng Ä‘á»‹a phÆ°Æ¡ng.'
    WHEN 'NV_HDV02' THEN 'ChuyÃªn chÄƒm sÃ³c khÃ¡ch gia Ä‘Ã¬nh: Biáº¿t cÃ¡ch há»— trá»£ Ä‘oÃ n cÃ³ tráº» em, ngÆ°á»i lá»›n tuá»•i vÃ  khÃ¡ch cáº§n sá»± quan tÃ¢m Ä‘áº·c biá»‡t.'
    WHEN 'NV_HDV03' THEN 'ChuyÃªn thuyáº¿t minh lá»‹ch sá»­ - vÄƒn hÃ³a: Am hiá»ƒu di sáº£n miá»n Trung, vÄƒn hÃ³a ChÄƒm vÃ  Ä‘á»i sá»‘ng Ä‘á»‹a phÆ°Æ¡ng.'
    WHEN 'NV_HDV04' THEN 'ChuyÃªn chÄƒm sÃ³c khÃ¡ch gia Ä‘Ã¬nh: Biáº¿t cÃ¡ch há»— trá»£ Ä‘oÃ n nghá»‰ dÆ°á»¡ng cÃ³ tráº» em, ngÆ°á»i lá»›n tuá»•i vÃ  khÃ¡ch cáº§n sá»± quan tÃ¢m Ä‘áº·c biá»‡t.'
    WHEN 'NV_HDV05' THEN 'ChuyÃªn thuyáº¿t minh lá»‹ch sá»­ - vÄƒn hÃ³a: Am hiá»ƒu kiáº¿n trÃºc, di tÃ­ch vÃ  phá»¥c vá»¥ Ä‘oÃ n tráº£i nghiá»‡m cao cáº¥p.'
    WHEN 'NV_HDV06' THEN 'ChuyÃªn tour há»c sinh - sinh viÃªn: Biáº¿t cÃ¡ch truyá»n Ä‘áº¡t dá»… hiá»ƒu, tá»• chá»©c hoáº¡t Ä‘á»™ng táº­p thá»ƒ vÃ  quáº£n lÃ½ Ä‘oÃ n tráº».'
    WHEN 'NV_HDV07' THEN 'ChuyÃªn dáº«n tour máº¡o hiá»ƒm: CÃ³ kinh nghiá»‡m há»— trá»£ khÃ¡ch trong cÃ¡c hoáº¡t Ä‘á»™ng nhÆ° leo nÃºi, trekking, chÃ¨o thuyá»n vÃ  cáº¯m tráº¡i.'
    WHEN 'NV_HDV08' THEN 'ChuyÃªn chÄƒm sÃ³c Ä‘oÃ n doanh nghiá»‡p: ThÃ nh tháº¡o tá»• chá»©c lá»‹ch trÃ¬nh sá»± kiá»‡n, há»™i há»p vÃ  yÃªu cáº§u dá»‹ch vá»¥ theo Ä‘oÃ n.'
    WHEN 'NV_HDV09' THEN 'ChuyÃªn dáº«n tour sinh thÃ¡i: Am hiá»ƒu thiÃªn nhiÃªn, rá»«ng, biá»ƒn, há»‡ sinh thÃ¡i vÃ  cÃ¡c hoáº¡t Ä‘á»™ng báº£o vá»‡ mÃ´i trÆ°á»ng.'
    WHEN 'NV_HDV10' THEN 'ChuyÃªn dáº«n tour sinh thÃ¡i: Am hiá»ƒu thiÃªn nhiÃªn, sÃ´ng nÆ°á»›c, Ä‘á»i sá»‘ng Ä‘á»‹a phÆ°Æ¡ng vÃ  báº£o vá»‡ mÃ´i trÆ°á»ng.'
    WHEN 'NV_HDV11' THEN 'ChuyÃªn dáº«n tour biá»ƒn Ä‘áº£o vÃ  di sáº£n: CÃ³ kinh nghiá»‡m há»— trá»£ hoáº¡t Ä‘á»™ng biá»ƒn, tham quan vÄƒn hÃ³a vÃ  chÄƒm sÃ³c Ä‘oÃ n gia Ä‘Ã¬nh.'
    WHEN 'NV_HDV12' THEN 'ChuyÃªn dáº«n tour sinh thÃ¡i sÃ´ng nÆ°á»›c: Am hiá»ƒu rá»«ng ngáº­p máº·n, chá»£ ná»•i, Ä‘Æ°á»ng thá»§y vÃ  du lá»‹ch cá»™ng Ä‘á»“ng bá»n vá»¯ng.'
    ELSE chuyen_mon
END;

-- Báº£o Ä‘áº£m má»i tour máº«u cÃ³ lá»‹ch trÃ¬nh Ä‘á»§ tá»« ngÃ y 1 Ä‘áº¿n Ä‘Ãºng thá»i lÆ°á»£ng Ä‘Ã£ cÃ´ng bá»‘.;

-- Kiá»ƒm tra má»™t khÃ¡ch hÃ ng khÃ´ng xuáº¥t hiá»‡n á»Ÿ hai Ä‘Æ¡n thuá»™c cÃ¹ng má»™t tour thá»±c táº¿.;

-- TÃ­nh láº¡i sá»‘ chá»— cÃ²n láº¡i sau toÃ n bá»™ cá»¥m dá»¯ liá»‡u bá»• sung.
UPDATE chi_tiet_dat_tours
SET ma_dat_tour = ma_dat_tour
WHERE ma_chi_tiet_dat LIKE 'CTDT_%';


-- Phuc hoi lai ham kiem tra goc (co ho tro DA_QUYET_TOAN);

-- Cap nhat lai so_danh_gia va danh_gia dong bo voi so luot review thuc te cho tat ca cac tour.
-- Nhung tour chua co ai danh gia se co so_danh_gia = 0, danh_gia = 0
UPDATE tour_maus tm
SET so_danh_gia = (SELECT COUNT(*) FROM tour_thuc_tes ttt JOIN danh_gia_khs dg ON ttt.ma_tour_thuc_te = dg.ma_tour_thuc_te WHERE ttt.ma_tour_mau = tm.ma_tour_mau),
    danh_gia = COALESCE((SELECT ROUND(AVG(dg.so_sao), 2) FROM tour_thuc_tes ttt JOIN danh_gia_khs dg ON ttt.ma_tour_thuc_te = dg.ma_tour_thuc_te WHERE ttt.ma_tour_mau = tm.ma_tour_mau), 0);


-- ============================================================;
