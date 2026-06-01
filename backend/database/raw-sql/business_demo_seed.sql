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
-- Hai hướng dẫn viên bổ sung phục vụ màn hình lịch sử và lịch sắp khởi hành.
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV11', 'hdv11', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Võ Thuỳ Dương', '048192006811', '1992-06-08', 'thuyduong.hdv@digitaltravel.vn', '0908112211', 'HDV', 'HOAT_DONG');
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV12', 'hdv12', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyễn Quốc Việt', '092189007512', '1989-07-15', 'quocviet.hdv@digitaltravel.vn', '0908223312', 'HDV', 'HOAT_DONG');

INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV11', 'TK_HDV11', 'HDV', '2022-03-14', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV12', 'TK_HDV12', 'HDV', '2021-10-04', 'HOAT_DONG');

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV01', 'NV_HDV01', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa; Sơ cấp cứu cơ bản', 'Tây Bắc, Trekking, Tour xanh', 4.80, 126);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV02', 'NV_HDV02', 'Tiếng Việt, Tiếng Anh, Tiếng Hàn', 'Thẻ HDV quốc tế', 'Biển đảo, di sản miền Trung, gia đình', 4.70, 98);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV03', 'NV_HDV03', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa', 'Miền núi phía Bắc, tour cộng đồng', 4.76, 84);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV04', 'NV_HDV04', 'Tiếng Việt, Tiếng Trung', 'Thẻ HDV nội địa; Sơ cấp cứu cơ bản', 'Di sản miền Trung, ẩm thực địa phương', 4.68, 71);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV05', 'NV_HDV05', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa', 'Biển đảo, nghỉ dưỡng gia đình', 4.72, 79);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV06', 'NV_HDV06', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa', 'Du thuyền, tour cao cấp', 4.74, 68);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV07', 'NV_HDV07', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa; Sơ cấp cứu cơ bản', 'Tâm linh miền Bắc, Tràng An, tour gia đình', 4.69, 63);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV08', 'NV_HDV08', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa', 'Đà Lạt, Mộc Châu, nông trại và trải nghiệm cộng đồng', 4.71, 76);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV09', 'NV_HDV09', 'Tiếng Việt, Tiếng Anh, Tiếng Hàn', 'Thẻ HDV quốc tế; Cứu hộ biển cơ bản', 'Phú Quốc, Côn Đảo, tour biển đảo và gia đình', 4.73, 82);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV10', 'NV_HDV10', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa', 'Tây Nguyên, Cần Thơ, tour văn hóa và ẩm thực địa phương', 4.66, 58);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV11', 'NV_HDV11', 'Tiếng Việt, Tiếng Anh, Tiếng Hàn', 'Thẻ HDV quốc tế; Chứng nhận sơ cấp cứu du lịch', 'Di sản miền Trung, biển Quy Nhơn, trải nghiệm văn hoá địa phương', 4.86, 94);
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NL_HDV12', 'NV_HDV12', 'Tiếng Việt, Tiếng Anh', 'Thẻ HDV nội địa; Chứng nhận an toàn đường thuỷ', 'Miền Tây sông nước, chợ nổi, du lịch cộng đồng bền vững', 4.81, 88);

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_01', 'khach01', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Trần Minh Khoa', '079199000101', '1995-02-14', 'khach01@digitaltravel.vn', '0911000101', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_02', 'khach02', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Phạm Ngọc Linh', '079199000102', '1997-08-20', 'khach02@digitaltravel.vn', '0911000102', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_03', 'khach03', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Lê Thu Hà', '079199000103', '1992-11-03', 'khach03@digitaltravel.vn', '0911000103', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_04', 'khach04', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyễn Bảo Châu', '079199000104', '1989-05-09', 'khach04@digitaltravel.vn', '0911000104', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_05', 'khach05', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Đỗ Quang Huy', '079199000105', '1986-12-25', 'khach05@digitaltravel.vn', '0911000105', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_06', 'khach06', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Bùi Anh Thư', '079199000106', '1999-04-18', 'khach06@digitaltravel.vn', '0911000106', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_07', 'khach07', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Hoàng Việt Anh', '079199000107', '1991-01-16', 'khach07@digitaltravel.vn', '0911000107', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_08', 'khach08', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Vũ Khánh Vy', '079199000108', '1994-09-27', 'khach08@digitaltravel.vn', '0911000108', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_09', 'khach09', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Đặng Gia Hân', '079199000109', '1988-03-30', 'khach09@digitaltravel.vn', '0911000109', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_10', 'khach10', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Mai Phương Nhi', '079199000110', '1996-06-12', 'khach10@digitaltravel.vn', '0911000110', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_11', 'khach11', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Cao Minh Trí', '079199000111', '1984-10-08', 'khach11@digitaltravel.vn', '0911000111', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_12', 'khach12', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Trịnh Mỹ Duyên', '079199000112', '1998-07-07', 'khach12@digitaltravel.vn', '0911000112', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_13', 'khach13', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyễn Đức Long', '079199000113', '1985-09-19', 'khach13@digitaltravel.vn', '0911000113', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_14', 'khach14', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Lâm Tuệ Minh', '079199000114', '1990-02-28', 'khach14@digitaltravel.vn', '0911000114', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_15', 'khach15', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Phan Gia Bảo', '079199000115', '1993-12-02', 'khach15@digitaltravel.vn', '0911000115', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_16', 'khach16', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguyễn Thảo Nguyên', '079199000116', '1994-04-21', 'khach16@digitaltravel.vn', '0911000116', 'KHACHHANG', 'HOAT_DONG');
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_17', 'khach17', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Phạm Minh Anh', '079199000117', '1996-09-12', 'khach17@digitaltravel.vn', '0911000117', 'KHACHHANG', 'HOAT_DONG');
INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KH_18', 'khach18', '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Vũ Hoàng Yến', '079199000118', '1991-03-06', 'khach18@digitaltravel.vn', '0911000118', 'KHACHHANG', 'HOAT_DONG');

INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_01', 'TK_KH_01', NULL, 'Hải sản', 'DONG', 650);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_02', 'TK_KH_02', 'Bệnh hen suyễn nhẹ', NULL, 'BAC', 2400);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_03', 'TK_KH_03', 'Bệnh tim mạch, tránh hoạt động gắng sức và leo dốc dài.', 'Đậu phộng', 'THANH_VIEN', 200);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_04', 'TK_KH_04', 'Đau khớp gối, ưu tiên phòng tầng thấp và lịch trình ít bậc thang.', NULL, 'VANG', 5600);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_05', 'TK_KH_05', 'Không có ghi chú y tế đặc biệt.', NULL, 'KIM_CUONG', 10200);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_06', 'TK_KH_06', 'Dễ say xe, ưu tiên ghế phía trước.', NULL, 'DONG', 850);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_07', 'TK_KH_07', 'Dị ứng khói thuốc, ưu tiên phòng và khu vực ăn uống không hút thuốc.', NULL, 'THANH_VIEN', 120);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_08', 'TK_KH_08', 'Huyết áp cao, cần lịch trình nhẹ và thời gian nghỉ giữa các điểm.', 'Sữa bò', 'DONG', 780);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_09', 'TK_KH_09', 'Tiểu đường type 2, cần bữa ăn đúng giờ và hạn chế đồ ngọt.', NULL, 'BAC', 3100);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_10', 'TK_KH_10', 'Bệnh dạ dày, tránh món quá cay và đồ uống có gas.', 'Hải sản có vỏ', 'VANG', 6200);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_11', 'TK_KH_11', 'Đau lưng, cần lịch trình ít leo dốc và hạn chế ngồi xe quá lâu.', NULL, 'KIM_CUONG', 11800);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_12', 'TK_KH_12', 'Ăn chay trường', NULL, 'BAC', 2800);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_13', 'TK_KH_13', NULL , NULL, 'VANG', 7100);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_14', 'TK_KH_14', NULL, 'Trứng gà', 'DONG', 950);
INSERT INTO ho_chieu_sos (ma_khach_hang, ma_tai_khoan, ghi_chu_y_te, di_ung, hang_thanh_vien, diem_xanh)
VALUES ('KH_15', 'TK_KH_15', NULL, 'Phấn hoa', 'THANH_VIEN', 320);
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
VALUES ('TM_SAPA', 'Sa Pa - Săn mây Fansipan và bản Cát Cát',
        'Khám phá Sa Pa theo cách trọn vẹn nhất cùng hành trình săn mây Fansipan và bản Cát Cát, nơi du khách được chạm vào vẻ đẹp núi rừng Tây Bắc, văn hóa bản địa và nhịp sống bình yên giữa mây trời. Với lịch trình 3 ngày, tour cân bằng giữa tham quan, nghỉ dưỡng và trải nghiệm địa phương, phù hợp cho gia đình, nhóm bạn và du khách yêu thiên nhiên.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Fansipan và bản Cát Cát
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 4500000, 4.70, 86);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_DANANG', 'Đà Nẵng - Di sản miền Trung xanh',
        'Tận hưởng miền Trung năng động cùng hành trình Đà Nẵng, Sơn Trà, Hội An và Mỹ Sơn, nơi biển xanh, di sản và ẩm thực địa phương hòa quyện trong một chuyến đi giàu cảm xúc. Với lịch trình 4 ngày, tour được thiết kế để du khách vừa có thời gian khám phá các biểu tượng nổi bật vừa nghỉ ngơi thoải mái trong không gian thân thiện và an toàn.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Sơn Trà, Hội An và Mỹ Sơn
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 4, 6200000, 4.60, 73);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_DALAT', 'Đà Lạt - Rừng thông và nông trại xanh',
        'Khám phá Đà Lạt theo cách trọn vẹn nhất cùng hành trình Đà Lạt - Rừng thông và nông trại xanh, nơi mỗi điểm dừng không chỉ là một chuyến tham quan mà còn là trải nghiệm đáng nhớ về văn hóa, thiên nhiên và con người bản địa. Với lịch trình 3 ngày, tour được thiết kế hài hòa giữa nghỉ dưỡng, khám phá và các hoạt động trải nghiệm xanh, mang đến cảm giác thư thái nhưng vẫn đầy cảm hứng cho mọi du khách để bạn tận hưởng chuyến đi một cách tiện lợi, an toàn và đáng nhớ cùng Digital Travel.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan nông trại xanh và các điểm trong lịch trình
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 3900000, 4.50, 64);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_NINHBINH', 'Ninh Bình - Tràng An và chùa Bái Đính',
        'Du ngoạn Ninh Bình với hành trình Tràng An, Hoa Lư và chùa Bái Đính, nơi cảnh quan non nước, di sản cố đô và không gian tâm linh tạo nên một chuyến đi nhẹ nhàng nhưng sâu lắng. Lịch trình 2 ngày phù hợp cho du khách muốn đổi gió cuối tuần, trải nghiệm văn hóa miền Bắc và tận hưởng dịch vụ được sắp xếp gọn gàng.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Tràng An, Hoa Lư và chùa Bái Đính
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 2, 2800000, 4.80, 112);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_PHUQUOC', 'Phú Quốc - Biển xanh và hoàng hôn Nam Đảo',
        'Tận hưởng Phú Quốc với hành trình biển xanh, hoàng hôn Nam Đảo và những trải nghiệm nghỉ dưỡng thư thái giữa thiên nhiên đảo ngọc. Trong 4 ngày, du khách được kết hợp tham quan, tắm biển, khám phá đặc sản địa phương và nghỉ ngơi theo nhịp chậm rãi, phù hợp cho gia đình, cặp đôi và nhóm bạn.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Nam Đảo và các điểm trong lịch trình
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 4, 7600000, 4.40, 59);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HUE', 'Huế - Kinh thành và ẩm thực cố đô',
        'Đi qua chiều sâu văn hóa cố đô cùng hành trình Huế - Kinh thành và ẩm thực, nơi du khách được khám phá Đại Nội, lăng tẩm, làng nghề và những hương vị tinh tế của đất kinh kỳ. Lịch trình 3 ngày mang nhịp điệu chậm rãi, giàu chất văn hóa và phù hợp với du khách yêu lịch sử, kiến trúc và ẩm thực địa phương.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Đại Nội, lăng tẩm và làng nghề
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 4100000, 4.65, 91);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HAGIANG', 'Hà Giang - Cung đường đá và chợ phiên',
        'Chạm vào vẻ đẹp hùng vĩ của miền cực Bắc qua cung đường đá Hà Giang, nơi cao nguyên đá, chợ phiên, bản làng và những khúc cua đèo tạo nên một hành trình đầy cảm hứng. Với 4 ngày di chuyển và khám phá, tour phù hợp cho du khách yêu thiên nhiên, văn hóa vùng cao và những trải nghiệm chân thực trên đường.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan cao nguyên đá và các điểm chợ phiên
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 4, 5900000, 4.30, 41);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HALONG', 'Hạ Long - Du thuyền vịnh xanh',
        'Khám phá Hạ Long trên du thuyền giữa vịnh xanh, nơi những dãy núi đá vôi, làn nước êm và khoảnh khắc hoàng hôn tạo nên trải nghiệm nghỉ dưỡng đáng nhớ. Lịch trình 3 ngày kết hợp tham quan, thư giãn trên tàu và khám phá Cát Bà, phù hợp cho du khách muốn tận hưởng một chuyến đi tiện nghi nhưng vẫn gần gũi thiên nhiên.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Vịnh Hạ Long và Cát Bà
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 5600000, 4.55, 67);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_CANTHO', 'Cần Thơ - Chợ nổi và miệt vườn sông nước',
        'Trải nghiệm nhịp sống miền Tây qua hành trình Cần Thơ, chợ nổi Cái Răng và miệt vườn sông nước, nơi du khách được cảm nhận sự mộc mạc, hào sảng và giàu bản sắc của vùng đất phù sa. Lịch trình 3 ngày nhẹ nhàng, nhiều hoạt động đời sống địa phương và phù hợp cho gia đình, nhóm bạn hoặc khách muốn nghỉ ngắn ngày.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan chợ nổi Cái Răng và miệt vườn
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 3500000, 4.75, 88);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_CONDAO', 'Côn Đảo - Biển hoang sơ và ký ức lịch sử',
        'Đến Côn Đảo để cảm nhận vẻ đẹp hoang sơ của biển đảo và chiều sâu lịch sử qua những điểm đến giàu ký ức. Trong 4 ngày, tour kết hợp nghỉ biển, tham quan di tích, trải nghiệm thiên nhiên và hoạt động bảo vệ môi trường, mang đến một chuyến đi yên bình nhưng nhiều dư âm.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Côn Đảo, di tích lịch sử và bãi biển
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 4, 8300000, 4.60, 52);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_MOCCHAU', 'Mộc Châu - Đồi chè và mùa hoa cao nguyên',
        'Tận hưởng Mộc Châu trong sắc xanh của đồi chè, mùa hoa cao nguyên và không khí trong lành của núi rừng Tây Bắc. Lịch trình 2 ngày được thiết kế gọn gàng, dễ đi, phù hợp cho chuyến nghỉ cuối tuần với các điểm tham quan thiên nhiên, nông trại và văn hóa địa phương.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan đồi chè, nông trại và điểm mùa hoa
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 2, 2600000, 4.50, 74);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_QUYNHON', 'Quy Nhơn - Kỳ Co Eo Gió và làng chài',
        'Khám phá Quy Nhơn qua Kỳ Co, Eo Gió và những làng chài ven biển, nơi vẻ đẹp biển xanh, vách đá và ẩm thực miền Trung tạo nên một hành trình đầy năng lượng. Với 3 ngày, tour cân bằng giữa tham quan, nghỉ biển và trải nghiệm đời sống địa phương, phù hợp cho du khách thích biển và những khung cảnh rộng mở.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Kỳ Co, Eo Gió và làng chài
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 5200000, 4.68, 81);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_HOIAN', 'Hội An - Phố cổ và làng rau Trà Quế',
        'Dạo bước qua Hội An với phố cổ, làng rau Trà Quế và những trải nghiệm văn hóa nhẹ nhàng, nơi từng con phố, món ăn và nếp sống địa phương đều mang nét duyên riêng. Lịch trình 3 ngày kết hợp tham quan di sản, trải nghiệm ẩm thực và hoạt động cộng đồng, phù hợp cho du khách yêu sự chậm rãi và tinh tế.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan phố cổ Hội An và làng rau Trà Quế
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 4400000, 4.72, 93);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_BUONMATHUOT', 'Buôn Ma Thuột - Cà phê và thác Dray Nur',
        'Khám phá Buôn Ma Thuột qua hương cà phê, văn hóa Tây Nguyên và vẻ đẹp mạnh mẽ của thác Dray Nur. Trong 3 ngày, tour đưa du khách đến bảo tàng cà phê, Buôn Đôn và các không gian văn hóa bản địa, tạo nên chuyến đi giàu trải nghiệm, gần gũi thiên nhiên và con người địa phương.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan bảo tàng cà phê, Buôn Đôn và thác Dray Nur
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 4000000, 4.65, 80);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_PULUONG', 'Pù Luông - Ruộng bậc thang và bản làng',
        'Trở về nhịp sống an yên của Pù Luông với ruộng bậc thang, bản làng và những cung đường đi bộ nhẹ giữa thung lũng xanh. Lịch trình 2 ngày phù hợp cho du khách muốn tạm rời phố thị, nghỉ tại không gian gần gũi thiên nhiên và trải nghiệm văn hóa cộng đồng một cách vừa sức.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan Pù Luông, bản làng và ruộng bậc thang
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 2, 3200000, 4.63, 76);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_MUINE', 'Mũi Né - Đồi cát và biển xanh Phan Thiết',
        'Tận hưởng Mũi Né với đồi cát, làng chài và biển xanh Phan Thiết, nơi nắng gió miền duyên hải mang đến một chuyến đi rực rỡ và thư thái. Lịch trình 3 ngày kết hợp tham quan, nghỉ biển và thưởng thức đặc sản địa phương, phù hợp cho nhóm bạn, gia đình và những ai yêu không khí biển.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan đồi cát, làng chài Mũi Né và các điểm biển
- Lưu trú và bữa ăn theo lịch trình
- Hướng dẫn viên du lịch
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT
- Tips cho hướng dẫn viên và tài xế', 3, 4700000, 4.42, 69);

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_SAPA_01', 'TM_SAPA', 1, 'Hà Nội - Sa Pa - Cát Cát', 'Di chuyển, nhận phòng, tham quan bản Cát Cát.', 'Sáng: Buffet khách sạn | Trưa: Cơm lam, gà đồi | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_SAPA_02', 'TM_SAPA', 2, 'Fansipan - Chợ đêm Sa Pa', 'Săn mây Fansipan và tự do khám phá thị trấn.', 'Sáng: Buffet khách sạn | Trưa: Lẩu cá tầm | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_SAPA_03', 'TM_SAPA', 3, 'Tả Van - Hà Nội', 'Tham quan Tả Van, ăn trưa và về lại Hà Nội.', 'Sáng: Buffet khách sạn | Trưa: Cơm rang, đặc sản | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_01', 'TM_DANANG', 1, 'Đà Nẵng - Sơn Trà', 'Đón khách, tham quan bán đảo Sơn Trà.', 'Sáng: Buffet khách sạn | Trưa: Hải sản địa phương | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_02', 'TM_DANANG', 2, 'Hội An', 'Tham quan phố cổ, ăn trưa đặc sản.', 'Sáng: Buffet khách sạn | Trưa: Cao lầu, mì Quảng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_03', 'TM_DANANG', 3, 'Bà Nà Hills', 'Tham quan Bà Nà Hills, cầu Vàng.', 'Sáng: Buffet khách sạn | Trưa: Buffet | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DANANG_04', 'TM_DANANG', 4, 'Mua sắm - Tiễn khách', 'Mua sắm đặc sản, tiễn khách ra sân bay.', 'Sáng: Buffet khách sạn | Trưa: Hải sản nhẹ | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DALAT_01', 'TM_DALAT', 1, 'Nông trại hữu cơ', 'Làm quen lịch trình xanh và thu hoạch rau sạch.', 'Sáng: Buffet khách sạn | Trưa: Rau củ cao nguyên | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DALAT_02', 'TM_DALAT', 2, 'Đồi chè Cầu Đất', 'Ngắm bình minh, tham quan xưởng chè.', 'Sáng: Buffet khách sạn | Trưa: Lẩu thả | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_DALAT_03', 'TM_DALAT', 3, 'Làng hoa Vạn Thành', 'Tham quan làng hoa, xe đưa khách về.', 'Sáng: Buffet khách sạn | Trưa: Cơm niêu | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_NB_01', 'TM_NINHBINH', 1, 'Tràng An - Hoa Lư', 'Đi thuyền tham quan Tràng An, thăm cố đô Hoa Lư.', 'Sáng: Buffet khách sạn | Trưa: Dê núi, cơm cháy | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_NB_02', 'TM_NINHBINH', 2, 'Chùa Bái Đính', 'Tham quan chùa Bái Đính, kết thúc chương trình.', 'Sáng: Buffet khách sạn | Trưa: Cơm chay | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HUE_01', 'TM_HUE', 1, 'Kinh thành Huế', 'Tham quan Đại Nội và nghe ca Huế trên sông Hương.', 'Sáng: Buffet khách sạn | Trưa: Bún bò Huế | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HUE_02', 'TM_HUE', 2, 'Lăng tẩm', 'Tham quan lăng Tự Đức, Khải Định.', 'Sáng: Buffet khách sạn | Trưa: Bánh bèo nậm lọc | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HUE_03', 'TM_HUE', 3, 'Chợ Đông Ba', 'Mua sắm đặc sản, tiễn khách ra ga/sân bay.', 'Sáng: Buffet khách sạn | Trưa: Bún thịt nướng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HALONG_01', 'TM_HALONG', 1, 'Hà Nội - Hạ Long - Du thuyền', 'Nhận phòng trên du thuyền và ngắm hoàng hôn trên vịnh.', 'Sáng: Buffet khách sạn | Trưa: Hải sản trên tàu | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CANTHO_01', 'TM_CANTHO', 1, 'Cần Thơ - Bến Ninh Kiều', 'Đón khách và tham quan bến Ninh Kiều buổi tối.', 'Sáng: Buffet khách sạn | Trưa: Lẩu mắm miền Tây | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_01', 'TM_CONDAO', 1, 'Côn Đảo - Bãi Đầm Trầu', 'Nhận phòng, nghỉ biển và hướng dẫn quy tắc bảo vệ môi trường biển.', 'Sáng: Buffet khách sạn | Trưa: Hải sản địa phương | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MOCCHAU_01', 'TM_MOCCHAU', 1, 'Đồi chè trái tim', 'Tham quan đồi chè, cầu kính và nông trại bò sữa.', 'Sáng: Buffet khách sạn | Trưa: Bê chao, rau cải mèo | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_QUYNHON_01', 'TM_QUYNHON', 1, 'Kỳ Co - Eo Gió', 'Đi canoe ra Kỳ Co, tham quan Eo Gió và làng chài Nhơn Lý.', 'Sáng: Buffet khách sạn | Trưa: Bún chả cá Quy Nhơn | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HOIAN_01', 'TM_HOIAN', 1, 'Phố cổ Hội An - Trà Quế', 'Tham quan phố cổ và lớp nấu ăn tại làng rau Trà Quế.', 'Sáng: Buffet khách sạn | Trưa: Cao lầu, bánh vạc | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BMT_01', 'TM_BUONMATHUOT', 1, 'Bảo tàng cà phê - Buôn Đôn', 'Trải nghiệm văn hóa cà phê và không gian Tây Nguyên.', 'Sáng: Buffet khách sạn | Trưa: Gà nướng cơm lam | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PULUONG_01', 'TM_PULUONG', 1, 'Bản Đôn - Ruộng bậc thang', 'Đi bộ nhẹ quanh bản, ngắm hoàng hôn trên thung lũng.', 'Sáng: Buffet khách sạn | Trưa: Vịt Cổ Lũng, rau rừng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MUINE_01', 'TM_MUINE', 1, 'Đồi cát bay - Làng chài Mũi Né', 'Tham quan đồi cát, làng chài và nghỉ biển buổi chiều.', 'Sáng: Buffet khách sạn | Trưa: Lẩu thả Phan Thiết | Chiều: Trái cây nhẹ');

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HALONG_02', 'TM_HALONG', 2, 'Hang Sửng Sốt - đảo Titop', 'Tham quan hang, chèo kayak và ngắm toàn cảnh vịnh từ đỉnh Titop.', 'Sáng: Buffet khách sạn | Trưa: Cơm Việt trên tàu | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HALONG_03', 'TM_HALONG', 3, 'Cát Bà - Hà Nội', 'Trải nghiệm buổi sáng trên vịnh, trả phòng và về lại Hà Nội.', 'Sáng: Buffet khách sạn | Trưa: Bún hải sản | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CANTHO_02', 'TM_CANTHO', 2, 'Chợ nổi Cái Răng - miệt vườn', 'Đi chợ nổi sớm, thăm vườn trái cây và làm bánh dân gian.', 'Sáng: Buffet khách sạn | Trưa: Cá lóc nướng trui | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CANTHO_03', 'TM_CANTHO', 3, 'Nhà cổ Bình Thủy - tiễn khách', 'Tham quan nhà cổ, mua đặc sản và kết thúc chương trình.', 'Sáng: Buffet khách sạn | Trưa: Hủ tiếu Nam Vang | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_02', 'TM_CONDAO', 2, 'Hòn Bảy Cạnh - bảo tồn biển', 'Trải nghiệm biển đảo và nghe giới thiệu về bảo tồn rùa biển.', 'Sáng: Buffet khách sạn | Trưa: Cơm niêu hải sản | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_03', 'TM_CONDAO', 3, 'Di tích Côn Đảo', 'Tham quan các điểm di tích lịch sử và bảo tàng địa phương.', 'Sáng: Buffet khách sạn | Trưa: Bánh xèo hải sản | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CONDAO_04', 'TM_CONDAO', 4, 'Đầm Trầu - tiễn khách', 'Nghỉ biển buổi sáng, mua đặc sản và ra sân bay.', 'Sáng: Buffet khách sạn | Trưa: Cơm đoàn | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MOCCHAU_02', 'TM_MOCCHAU', 2, 'Thác Dải Yếm - kết thúc', 'Tham quan thác, mua đặc sản sữa và về lại điểm đón.', 'Sáng: Buffet khách sạn | Trưa: Lẩu gà đen | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_QUYNHON_02', 'TM_QUYNHON', 2, 'Eo Gió - Tháp Đôi', 'Tham quan Eo Gió, Tháp Đôi và thưởng thức đặc sản địa phương.', 'Sáng: Buffet khách sạn | Trưa: Nem nướng, bánh xèo tôm nhảy | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_QUYNHON_03', 'TM_QUYNHON', 3, 'Làng chài - tiễn khách', 'Trải nghiệm làng chài, mua đặc sản và kết thúc tour.', 'Sáng: Buffet khách sạn | Trưa: Cơm nhà hàng biển | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HOIAN_02', 'TM_HOIAN', 2, 'Mỹ Sơn - rừng dừa Bảy Mẫu', 'Tham quan Mỹ Sơn, đi thuyền thúng và ăn tối phố cổ.', 'Sáng: Buffet khách sạn | Trưa: Mì Quảng, bánh đập | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HOIAN_03', 'TM_HOIAN', 3, 'Trà Quế - tiễn khách', 'Trải nghiệm làng rau, mua quà và kết thúc chương trình.', 'Sáng: Buffet khách sạn | Trưa: Cơm gà Hội An | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BMT_02', 'TM_BUONMATHUOT', 2, 'Thác Dray Nur - Buôn Đôn', 'Tham quan thác, tìm hiểu văn hóa Ê Đê và M''Nông.', 'Cơm lam, thịt nướng');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BMT_03', 'TM_BUONMATHUOT', 3, 'Làng cà phê - tiễn khách', 'Thưởng thức cà phê, mua quà và ra sân bay.', 'Sáng: Buffet khách sạn | Trưa: Bún đỏ Buôn Ma Thuột | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PULUONG_02', 'TM_PULUONG', 2, 'Hiêu - kết thúc', 'Đi bộ nhẹ ra thác Hiêu, ăn trưa và về lại Hà Nội.', 'Sáng: Buffet khách sạn | Trưa: Cơm bản | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MUINE_02', 'TM_MUINE', 2, 'Bàu Trắng - Suối Tiên', 'Ngắm bình minh Bàu Trắng, tham quan Suối Tiên và nghỉ biển.', 'Sáng: Buffet khách sạn | Trưa: Hải sản nướng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_MUINE_03', 'TM_MUINE', 3, 'Phan Thiết - tiễn khách', 'Tham quan lầu Ông Hoàng, mua đặc sản và kết thúc tour.', 'Sáng: Buffet khách sạn | Trưa: Lẩu thả Phan Thiết | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_01', 'TM_HAGIANG', 1, 'Hà Nội - Quản Bạ', 'Di chuyển lên Hà Giang, nhận phòng và tham quan cổng trời Quản Bạ.', 'Sáng: Buffet khách sạn | Trưa: Thắng cố, rau cải mèo | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_02', 'TM_HAGIANG', 2, 'Yên Minh - Đồng Văn', 'Tham quan rừng thông Yên Minh, dinh vua Mèo và phố cổ Đồng Văn.', 'Sáng: Buffet khách sạn | Trưa: Lẩu gà đen | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_03', 'TM_HAGIANG', 3, 'Mã Pì Lèng - Mèo Vạc', 'Đi cung đường Mã Pì Lèng, sông Nho Quế và chợ phiên địa phương.', 'Sáng: Buffet khách sạn | Trưa: Cơm lam, thịt lợn cắp nách | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_HAGIANG_04', 'TM_HAGIANG', 4, 'Mèo Vạc - Hà Nội', 'Mua đặc sản, trả phòng và về lại Hà Nội.', 'Sáng: Buffet khách sạn | Trưa: Phở chua Hà Giang | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_01', 'TM_PHUQUOC', 1, 'Dương Đông - Bãi Trường', 'Đón khách, nhận phòng và ngắm hoàng hôn trên Bãi Trường.', 'Sáng: Buffet khách sạn | Trưa: Gỏi cá trích | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_02', 'TM_PHUQUOC', 2, 'Nam Đảo - Hòn Thơm', 'Tham quan Nam Đảo, trải nghiệm cáp treo và bãi biển Hòn Thơm.', 'Sáng: Buffet khách sạn | Trưa: Hải sản nướng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_03', 'TM_PHUQUOC', 3, 'Rạch Vẹm - vườn tiêu', 'Tham quan Rạch Vẹm, vườn tiêu và cơ sở nước mắm truyền thống.', 'Sáng: Buffet khách sạn | Trưa: Bún quậy | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PHUQUOC_04', 'TM_PHUQUOC', 4, 'Chợ Dương Đông - tiễn khách', 'Mua đặc sản, trả phòng và kết thúc tour.', 'Sáng: Buffet khách sạn | Trưa: Cơm gia đình | Chiều: Trái cây nhẹ');

INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_SINGLE', 'Phụ thu phòng đơn', 'Phòng/đêm', 650000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_AIRPORT', 'Đưa đón sân bay riêng', 'Lượt', 350000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_DINNER', 'Bữa tối đặc sản nâng cấp', 'Suất', 280000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_INSURANCE', 'Bảo hiểm du lịch mở rộng', 'Người', 120000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_PHOTO', 'Gói chụp ảnh hành trình', 'Gói', 900000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_BOTTLE', 'Mang bình nước cá nhân trong tour', 80);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_CLEANUP', 'Tham gia nhặt rác tại điểm tham quan', 150);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_EBILL', 'Đồng ý nhận hóa đơn điện tử', 50);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_TREE', 'Đóng góp trồng cây tại điểm đến', 200);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_LOCAL', 'Sử dụng sản phẩm địa phương thay đồ nhựa dùng một lần', 100);

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
VALUES ('VC_EARLY10', 'EARLY-10', 'PHAN_TRAM', 10, 500000, 'Giảm 10% cho đơn đặt sớm', 100, 0, DATE(NOW()) - INTERVAL 30 DAY, DATE(NOW()) + INTERVAL 120 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_GREEN500', 'GREEN-500', 'SO_TIEN', 500000, 'Đổi điểm xanh lấy voucher 500.000 VND', 50, 0, DATE(NOW()) - INTERVAL 15 DAY, DATE(NOW()) + INTERVAL 90 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_EXPIRED', 'EXPIRED', 'SO_TIEN', 300000, 'Voucher hết hạn để minh họa trạng thái', 10, 0, DATE(NOW()) - INTERVAL 90 DAY, DATE(NOW()) - INTERVAL 10 DAY, 'VO_HIEU_HOA');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_FAMILY700', 'FAMILY-700', 'SO_TIEN', 700000, 'Giảm cho nhóm gia đình từ 3 khách trở lên', 80, 0, DATE(NOW()) - INTERVAL 20 DAY, DATE(NOW()) + INTERVAL 150 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_MEMBER15', 'MEMBER-15', 'PHAN_TRAM', 15, 750000, 'Ưu đãi 15% cho thành viên hạng vàng trở lên', 60, 0, DATE(NOW()) - INTERVAL 10 DAY, DATE(NOW()) + INTERVAL 120 DAY, 'SAN_SANG');

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_DIEMXANH800', 'DIEMXANH-800', 'SO_TIEN', 800000, 'Quy đổi 800 điểm xanh khi đặt tour', 40, 0, DATE(NOW()) - INTERVAL 5 DAY, DATE(NOW()) + INTERVAL 120 DAY, 'SAN_SANG');

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
        NOW() + INTERVAL 1 DAY, 'Chờ khách xác nhận thanh toán', 'HDX_EBILL:1');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_DA_XN', 'TTT_MB', 'KH_02', NOW() - INTERVAL 2 DAY, 14250000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Áp dụng voucher VC_GREEN500: tạm tính 14.750.000, giảm 500.000, tổng sau giảm 14.250.000. Đơn đã thanh toán đủ, trigger sẽ chuyển DA_XAC_NHAN.', 'HDX_EBILL:1');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HET_HAN', 'TTT_MB', 'KH_03', NOW() - INTERVAL 3 DAY, 4800000, 'HET_HAN_GIU_CHO',
        NOW() - INTERVAL 2 DAY, 'Khách không thanh toán trong thời gian giữ chỗ', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CHO_HUY', 'TTT_SDR', 'KH_04', NOW() - INTERVAL 4 DAY, 6500000, 'CHO_HUY',
        NOW() + INTERVAL 1 DAY, 'Khách gửi yêu cầu hủy, đội điều hành xử lý', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_TU_CHOI_HT', 'TTT_SDR', 'KH_05', NOW() - INTERVAL 4 DAY, 6500000, 'TU_CHOI_HOAN_TIEN',
        NOW() + INTERVAL 1 DAY, 'Quá hạn hoàn tiền theo chính sách', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_TT_FAIL', 'TTT_SDR', 'KH_06', NOW() - INTERVAL 1 DAY, 6500000, 'THANH_TOAN_THAT_BAI',
        NOW() + INTERVAL 1 DAY, 'Ngân hàng trả về thất bại', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_DANG_DIEN_RA', 'TTT_DDR', 'KH_01', NOW() - INTERVAL 5 DAY, 8400000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Đơn cho tour đang diễn ra', 'HDX_BOTTLE:1,HDX_CLEANUP:1');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_KET_THUC', 'TTT_KT', 'KH_04', NOW() - INTERVAL 15 DAY, 6000000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Đơn đã hoàn thành tour và đủ điều kiện đánh giá', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HUY', 'TTT_HUY', 'KH_05', NOW() - INTERVAL 7 DAY, 15800000, 'DA_HUY',
        NOW() + INTERVAL 1 DAY, 'Đơn sẽ bị hủy tự động khi tour bị hủy', NULL);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_QUYET_TOAN', 'TTT_QT', 'KH_02', NOW() - INTERVAL 25 DAY, 8300000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Áp dụng voucher VC_EARLY10: tiền tour 8.600.000, dịch vụ 560.000, giảm 860.000, tổng sau giảm 8.300.000. Đơn thuộc tour đã quyết toán.', 'HDX_EBILL:1');

-- Don dat tour 5 nguoi cho tour Da Nang
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_5_PEOPLE', 'TTT_SDR', 'KH_03', NOW() - INTERVAL 3 DAY, 32500000, 'DA_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Đơn đặt 5 người (1 khách, 4 đồng hành).', 'HDX_BOTTLE:1');

-- Nguoi dong hanh
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CHO_XN_01', 'DDT_CHO_XN', 'Trần Gia Bảo', '079299000201', '0922000201', '2014-07-11', 'NAM', 'Trẻ em đi cùng gia đình');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DA_XN_01', 'DDT_DA_XN', 'Phạm Minh Quân', '079299000202', '0922000202', '1994-03-02', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DA_XN_02', 'DDT_DA_XN', 'Phạm Tuệ Nhi', '079299000203', '0922000203', '2018-10-05', 'NU', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DDR_01', 'DDT_DANG_DIEN_RA', 'Trần Mỹ Anh', '079299000204', '0922000204', '1998-01-19', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_KT_01', 'DDT_KET_THUC', 'Nguyễn Minh Tâm', '079299000205', '0922000205', '1988-09-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HUY_01', 'DDT_HUY', 'Đỗ Minh Nhật', '079299000206', '0922000206', '1985-06-06', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_QT_01', 'DDT_QUYET_TOAN', 'Phạm Mai Chi', '079299000207', '0922000207', '1996-04-22', 'NU', NULL);

-- Nguoi dong hanh cho don 5 nguoi
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_01', 'DDT_5_PEOPLE', 'Lê Minh', '079299000301', '0922000301', '1990-01-01', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_02', 'DDT_5_PEOPLE', 'Lê Hoa', '079299000302', '0922000302', '1992-02-02', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_03', 'DDT_5_PEOPLE', 'Lê An', '079299000303', '0922000303', '2015-03-03', 'NAM', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_5P_04', 'DDT_5_PEOPLE', 'Lê Bình', '079299000304', '0922000304', '2018-04-04', 'NAM', 'Trẻ em');

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
VALUES ('DD_DDR_KH_OK', 'TTT_DDR', 'KH_01', NULL, 'NGUOI_DAT', 'NV_HDV01', NOW() - INTERVAL 2 HOUR, 'Quảng trường Lâm Viên', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_DDR_NDH_WAIT', 'TTT_DDR', NULL, 'NDH_DDR_01', 'NGUOI_DONG_HANH', 'NV_HDV01', NOW() - INTERVAL 90 MINUTE, 'Quảng trường Lâm Viên', 'CHUA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_DDR_NDH_ABS', 'TTT_DDR', NULL, 'NDH_DDR_01', 'NGUOI_DONG_HANH', 'NV_HDV01', NOW() - INTERVAL 1 HOUR, 'Nông trại Đà Lạt', 'VANG');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DDR_BOTTLE', 'TTT_DDR', 'KH_01', 'HDX_BOTTLE', 'NV_HDV01', NOW() - INTERVAL 1 HOUR,
        'Ảnh check-in với bình nước cá nhân');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DDR_CLEANUP', 'TTT_DDR', 'KH_01', 'HDX_CLEANUP', 'NV_HDV01', NOW() - INTERVAL 30 MINUTE,
        'HDV xác nhận khách tham gia nhặt rác tại điểm tham quan');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DDR_WEATHER', 'TTT_DDR', 'NV_HDV01', 'Mưa lớn bất ngờ tại điểm tham quan.',
        'Đổi lịch tham quan trong nhà và cấp áo mưa cho khách.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 20 MINUTE);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DDR_MEDICAL', 'TTT_DDR', 'NV_HDV01', 'Khách bị say xe cần theo dõi.',
        'Sắp xếp ghế đầu xe, cấp nước ấm và theo dõi sức khỏe.', 'SOS', 'Y_TE', NOW() - INTERVAL 10 MINUTE);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_APPROVED', 'TTT_DDR', 'NV_HDV01', 'Áo mưa dự phòng', 320000, 'https://seed.local/hoa-don/ao-mua.jpg', 'DA_DUYET', NOW() - INTERVAL 1 HOUR);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_PENDING', 'TTT_DDR', 'NV_HDV01', 'Nước uống bổ sung', 180000, 'https://seed.local/hoa-don/nuoc.jpg', 'CHO_DUYET', NOW() - INTERVAL 30 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_REJECT', 'TTT_DDR', 'NV_HDV01', 'Phụ phí không hợp lệ', 90000, NULL, 'TU_CHOI', NOW() - INTERVAL 20 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DDR_NEED_MORE', 'TTT_DDR', 'NV_HDV01', 'Vé gửi xe', 120000, NULL, 'YEU_CAU_BO_SUNG', NOW() - INTERVAL 10 MINUTE);

UPDATE tour_thuc_tes
SET ngay_khoi_hanh = DATE(NOW()) - INTERVAL 7 DAY,
    trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te = 'TTT_KT';

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_KT_KH04', 'KH_04', 'TTT_KT', 'CTDT_KT_KH', DATE(NOW()) - INTERVAL 7 DAY);

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_KT_KH04', 'TTT_KT', 'KH_04', 5, 'Lịch trình gọn, HDV chăm sóc tốt và giải thích rõ về Tràng An.', NOW() - INTERVAL 2 DAY);

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
VALUES ('CP_QT_HOTEL', 'TTT_QT', 'NV_HDV01', 'Khách sạn Huế 2 đêm', 4800000, 'https://seed.local/hoa-don/hue-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 20 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_QT_BUS', 'TTT_QT', 'NV_HDV01', 'Xe du lịch Huế', 2600000, 'https://seed.local/hoa-don/hue-bus.jpg', 'DA_DUYET', NOW() - INTERVAL 20 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_QT_TICKET', 'TTT_QT', 'NV_HDV01', 'Vé tham quan Đại Nội', 900000, 'https://seed.local/hoa-don/hue-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_HUE_DONE', 'TTT_QT', 0, 0, 11000000, 0, 'NV_KT01', NOW() - INTERVAL 18 DAY, 'DA_QUYET_TOAN',
        'Trigger tính lại tong_doanh_thu, tong_chi_phi, loi_nhuan và chốt tour DA_QUYET_TOAN.');

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
        NOW() + INTERVAL 1 DAY, 'Khách đang giữ chỗ du thuyền Hạ Long.', 'HDX_EBILL:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HALONG_OK', 'TTT_HALONG', 'KH_08', NOW() - INTERVAL 2 DAY, 18600000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Nhóm gia đình đã thanh toán đủ.', 'HDX_EBILL:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HALONG_TRE_EM', 'TTT_HALONG', 'KH_15', NOW() - INTERVAL 6 HOUR, 8970000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Đơn có trẻ em dưới 10 tuổi đi kèm.', 'HDX_EBILL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_CHO_01', 'DDT_HALONG_CHO', 'Hoàng Minh Đức', '079299000208', '0922000208', '1990-02-21', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_OK_01', 'DDT_HALONG_OK', 'Vũ Thanh Sơn', '079299000209', '0922000209', '1962-08-14', 'NAM', 'Người cao tuổi');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_OK_02', 'DDT_HALONG_OK', 'Vũ Minh Anh', '079299000210', '0922000210', '2012-12-01', 'NU', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HALONG_TRE_EM_01', 'DDT_HALONG_TRE_EM', 'Phan Minh Khang', '079299000220', '0922000220',
        DATE_ADD(DATE(NOW()), INTERVAL (-84) MONTH), 'NAM', 'Trẻ em duoi 10 tuoi');

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
        NOW() + INTERVAL 1 DAY, 'Khách cần hóa đơn công ty sau thanh toán.', 'HDX_LOCAL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_01', 'DDT_CANTHO_OK', 'Đặng Minh Tuệ', '079299000211', '0922000211', '1987-05-18', 'NAM', NULL);

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
        NOW() + INTERVAL 1 DAY, 'Khách đi biển đảo, có dị ứng hải sản có vỏ.', 'HDX_CLEANUP:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CONDAO_01', 'DDT_CONDAO_OK', 'Mai Bảo Nam', '079299000212', '0922000212', '1993-11-23', 'NAM', NULL);

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
VALUES ('DD_CONDAO_KH_OK', 'TTT_CONDAO', 'KH_10', NULL, 'NGUOI_DAT', 'NV_HDV02', NOW() - INTERVAL 3 HOUR, 'Sân bay Côn Đảo', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_CONDAO_NDH_OK', 'TTT_CONDAO', NULL, 'NDH_CONDAO_01', 'NGUOI_DONG_HANH', 'NV_HDV02', NOW() - INTERVAL 3 HOUR, 'Sân bay Côn Đảo', 'DA_DIEM_DANH');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_CONDAO_CLEANUP', 'TTT_CONDAO', 'KH_10', 'HDX_CLEANUP', 'NV_HDV02', NOW() - INTERVAL 1 HOUR,
        'Ảnh nhóm khách thu gom rác trên bãi biển');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_CONDAO_TRANSPORT', 'TTT_CONDAO', 'NV_HDV02', 'Xe đưa đón chậm 20 phút do thời tiết.',
        'Thông báo khách, điều xe dự phòng và đổi lịch tham quan nhẹ.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 40 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CONDAO_WATER', 'TTT_CONDAO', 'NV_HDV02', 'Nước uống bổ sung tại bến tàu', 240000, 'https://seed.local/hoa-don/condao-water.jpg', 'CHO_DUYET', NOW() - INTERVAL 35 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CONDAO_TRANSFER', 'TTT_CONDAO', 'NV_HDV02', 'Xe trung chuyển dự phòng', 750000, 'https://seed.local/hoa-don/condao-transfer.jpg', 'DA_DUYET', NOW() - INTERVAL 25 MINUTE);

-- Goi 4: Moc Chau - da ket thuc, co lich su va danh gia tu khach hang.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_MOCCHAU_OK', 'TTT_MOCCHAU', 'KH_11', NOW() - INTERVAL 20 DAY, 6500000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Khách cần lịch trình ít leo dốc.', 'HDX_TREE:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_MOCCHAU_01', 'DDT_MOCCHAU_OK', 'Cao Bảo Ngọc', '079299000213', '0922000213', '1986-02-09', 'NU', NULL);

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
VALUES ('SC_MOCCHAU_TRAIL', 'TTT_MOCCHAU', 'NV_HDV01', 'Đường vào đồi chè ẩm ướt sau mưa.',
        'Chuyển sang lối đi phụ, nhắc khách mang giày chống trơn.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 11 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_MOCCHAU_RAINCOAT', 'TTT_MOCCHAU', 'NV_HDV01', 'Áo mưa mỏng cho khách', 180000, 'https://seed.local/hoa-don/mocchau-raincoat.jpg', 'DA_DUYET', NOW() - INTERVAL 11 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_MOCCHAU_LOCAL', 'TTT_MOCCHAU', 'NV_HDV01', 'Phí xe điện vào nông trại', 300000, 'https://seed.local/hoa-don/mocchau-ev.jpg', 'CHO_DUYET', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_MOCCHAU_KH11', 'TTT_MOCCHAU', 'KH_11', 4, 'Cảnh đẹp, lịch trình hợp lý cho người không muốn đi bộ quá nhiều.', NOW() - INTERVAL 5 DAY);

-- Goi 5: Quy Nhon - tour bi huy, don da thanh toan se sinh ho tro hoan tien.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_QUYNHON_HUY', 'TTT_QUYNHON', 'KH_07', NOW() - INTERVAL 6 DAY, 11350000, 'CHO_HUY',
        NOW() + INTERVAL 1 DAY, 'Tour dự kiến hủy do điều kiện thời tiết biển.', 'HDX_BOTTLE:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_QUYNHON_01', 'DDT_QUYNHON_HUY', 'Hoàng Bảo Trâm', '079299000214', '0922000214', '1992-04-04', 'NU', NULL);

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
        NOW() + INTERVAL 1 DAY, 'Gia đình đang giữ chỗ tour Hội An.', 'HDX_LOCAL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HOIAN_01', 'DDT_HOIAN_CHO', 'Trịnh Bảo Khánh', '079299000215', '0922000215', '1991-10-10', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HOIAN_02', 'DDT_HOIAN_CHO', 'Trịnh Minh An', '079299000216', '0922000216', '2017-05-12', 'NU', 'Trẻ em');

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
        NOW() + INTERVAL 1 DAY, 'Áp dụng voucher VC_FAMILY700: tiền tour 9.200.000, dịch vụ 560.000, giảm 700.000, tổng sau giảm 9.060.000.', 'HDX_LOCAL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HOIAN_VOUCHER_01', 'DDT_HOIAN_VOUCHER', 'Trịnh Hoàng Phúc', '079299000219', '0922000219', '1995-01-24', 'NAM', NULL);

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
        NOW() + INTERVAL 1 DAY, 'Áp dụng voucher VC_MEMBER15: tạm tính 8.440.000, giảm 1.266.000, tổng sau giảm 7.174.000. Khách hạng vàng sử dụng ưu đãi thành viên.', 'HDX_EBILL:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_BUONMATHUOT_01', 'DDT_BUONMATHUOT_OK', 'Nguyễn Hoài Nam', '079299000217', '0922000217', '1984-06-17', 'NAM', NULL);

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
        NOW() + INTERVAL 1 DAY, 'Áp dụng voucher VC_FAMILY700: tạm tính 7.500.000, giảm 700.000, tổng sau giảm 6.800.000. Gia đình đã đi tour Pù Luông.', 'HDX_TREE:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_PULUONG_01', 'DDT_PULUONG_OK', 'Lâm Gia Hân', '079299000218', '0922000218', '2019-03-15', 'NU', 'Trẻ em duoi 6 tuoi');

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
VALUES ('SC_PULUONG_CHILD', 'TTT_PULUONG', 'NV_HDV02', 'Trẻ nhỏ mệt sau chặng đi bộ Bản Đôn.',
        'Rút ngắn cung đi bộ và bố trí xe điện về homestay.', 'THAP', 'Y_TE', NOW() - INTERVAL 17 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_PULUONG_EV', 'TTT_PULUONG', 'NV_HDV02', 'Xe điện hỗ trợ gia đình có trẻ nhỏ', 360000, 'https://seed.local/hoa-don/puluong-ev.jpg', 'DA_DUYET', NOW() - INTERVAL 17 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_PULUONG_SNACK', 'TTT_PULUONG', 'NV_HDV02', 'Đồ ăn nhẹ cho trẻ em', 150000, 'https://seed.local/hoa-don/puluong-snack.jpg', 'DA_DUYET', NOW() - INTERVAL 17 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_PULUONG_KH14', 'TTT_PULUONG', 'KH_14', 5, 'Homestay sạch, HDV chu đáo và lịch trình phù hợp gia đình có trẻ nhỏ.', NOW() - INTERVAL 8 DAY);

-- Goi 9: Mui Ne - mo ban, mot thanh toan that bai can kinh doanh ho tro lai.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_MUINE', 'TM_MUINE', DATE(NOW()) + INTERVAL 190 DAY, 4900000, 26, 10, 26, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_MUINE', 'DVT_AIRPORT');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_MUINE', 'HDX_BOTTLE');
INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan)
VALUES ('PC_MUINE_HDV01', 'TTT_MUINE', 'NV_HDV01', NOW() - INTERVAL 1 DAY, 'DA_DONG_Y');

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_MUINE_FAIL', 'TTT_MUINE', 'KH_15', NOW() - INTERVAL 6 HOUR, 5250000, 'THANH_TOAN_THAT_BAI',
        NOW() + INTERVAL 1 DAY, 'Thanh toán không thành công, cần liên hệ lại khách.', 'HDX_BOTTLE:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_MUINE_DIEMXANH', 'TTT_MUINE', 'KH_05', NOW() - INTERVAL 4 HOUR, 4450000, 'CHO_XAC_NHAN',
        NOW() + INTERVAL 1 DAY, 'Sử dụng 800 điểm xanh lúc đặt tour qua voucher VC_DIEMXANH800: tiền tour 4.900.000, dịch vụ 350.000, giảm 800.000, tổng sau giảm 4.450.000.', 'HDX_BOTTLE:1');

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
VALUES ('YCHT_CHO_BS', 'DDT_CHO_HUY', 'KH_04', 'HUY_TOUR', 'Khách cần bổ sung lý do hủy và xác nhận phí hủy.', 'CHO_BO_SUNG', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_CHO_GT', 'DDT_TT_FAIL', 'KH_06', 'THANH_TOAN', 'Cần giải trình kết quả đối soát với ngân hàng.', 'CHO_GIAI_TRINH', 'NV_SALES01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_DA_XL', 'DDT_DA_XN', 'KH_02', 'DOI_DICH_VU', 'Đã xác nhận dịch vụ đưa đón sân bay riêng.', 'DA_XU_LY', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TU_CHOI', 'DDT_TU_CHOI_HT', 'KH_05', 'HOAN_TIEN', 'Từ chối hoàn tiền do không đạt điều kiện chính sách.', 'TU_CHOI', 'NV_KT01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_CANTHO_INVOICE', 'DDT_CANTHO_OK', 'KH_09', 'HOA_DON', 'Khách yêu cầu xuất hóa đơn công ty cho tour Cần Thơ.', 'CHUA_XU_LY', 'NV_KT01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_HALONG_SERVICE', 'DDT_HALONG_OK', 'KH_08', 'DICH_VU_THEM', 'Xác nhận lại gói chụp ảnh hành trình trên du thuyền.', 'DA_XU_LY', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_HOIAN_MEAL', 'DDT_HOIAN_CHO', 'KH_12', 'AN_UONG', 'Khách cần xác nhận thực đơn chay cho cả gia đình.', 'CHO_BO_SUNG', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_MUINE_PAYMENT', 'DDT_MUINE_FAIL', 'KH_15', 'THANH_TOAN', 'Thanh toán thẻ nội địa thất bại, cần kinh doanh liên hệ hướng dẫn lại.', 'CHUA_XU_LY', 'NV_SALES01');

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
VALUES ('DG_NB_01', 'TTT_KT', 'KH_04', 5, 'Cảnh rất đẹp và HDV nhiệt tình.', NOW() - INTERVAL 2 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HUE_01', 'TTT_QT', 'KH_02', 4, 'Đồ ăn ngon nhưng thời tiết hơi sương mù.', NOW() - INTERVAL 5 DAY);


-- BO SUNG: KHACH HANG DAT TOUR DANG MO BAN (KEM THANH TOAN)

-- Dat tour cho Hoi An
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han)
VALUES ('DDT_HA_NEW', 'TTT_HOIAN', 'KH_09', NOW() - INTERVAL 2 DAY, 11960000, 'DA_XAC_NHAN', NOW());

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HA_NEW_01', 'DDT_HA_NEW', 'Nguyễn Văn Bình', '079299000301', '0922000301', '1995-05-15', 'NAM', NULL);

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
        NOW() - INTERVAL 48 DAY, 'Khách lẻ đã thanh toán đủ tour Sa Pa quá khứ.', 'HDX_CLEANUP:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_02', 'TTT_SAPA_OLD', 'KH_02', NOW() - INTERVAL 50 DAY, 9600000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 48 DAY, 'Cặp đôi đã thanh toán đủ tour Sa Pa.', 'HDX_CLEANUP:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_03', 'TTT_SAPA_OLD', 'KH_03', NOW() - INTERVAL 49 DAY, 15240000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 47 DAY, 'Nhóm 3 khách có thêm bữa tối đặc sản.', 'HDX_CLEANUP:1');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_04', 'TTT_SAPA_OLD', 'KH_04', NOW() - INTERVAL 49 DAY, 5450000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 47 DAY, 'Khách yêu cầu phụ thu phòng đơn.', NULL);
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_SAPA_OLD_05', 'TTT_SAPA_OLD', 'KH_05', NOW() - INTERVAL 48 DAY, 19200000, 'DA_XAC_NHAN',
        NOW() - INTERVAL 46 DAY, 'Gia đình 4 người đã thanh toán đủ.', 'HDX_CLEANUP:1');

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_02_01', 'DDT_SAPA_OLD_02', 'Phạm Quang Hiếu', '079299000401', '0922000401', '1994-09-09', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_03_01', 'DDT_SAPA_OLD_03', 'Lê Bảo Ngọc', '079299000402', '0922000402', '1996-12-11', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_03_02', 'DDT_SAPA_OLD_03', 'Lê Minh Quan', '079299000403', '0922000403', '1992-03-15', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_05_01', 'DDT_SAPA_OLD_05', 'Đỗ Thanh Lâm', '079299000404', '0922000404', '1988-08-08', 'NU', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_05_02', 'DDT_SAPA_OLD_05', 'Đỗ Minh Khôi', '079299000405', '0922000405', '2012-05-20', 'NAM', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OLD_05_03', 'DDT_SAPA_OLD_05', 'Đỗ Gia Hân', '079299000406', '0922000406', '2016-11-02', 'NU', 'Trẻ em');

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
VALUES ('SC_HOIAN_OLD_MEAL', 'TTT_HOIAN_OLD', 'NV_HDV04', 'Một khách báo món chay được phục vụ chậm.',
        'HDV làm việc lại với nhà hàng và đổi món riêng cho khách.', 'THAP', 'AN_UONG', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_MUINE_OLD_WEATHER', 'TTT_MUINE_OLD', 'NV_HDV05', 'Gió mạnh tại đồi cát vào buổi chiều.',
        'Đổi lịch chụp ảnh sáng sớm ngày tiếp theo và cấp nước bổ sung.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_HALONG_OLD_ROUTE', 'TTT_HALONG_OLD', 'NV_HDV06', 'Cảng tàu đổi giờ lên du thuyền 30 phút.',
        'Cập nhật thông tin cho khách và sắp xếp khu chờ riêng.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 19 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_SAPA_OLD_FOG', 'TTT_SAPA_OLD', 'NV_HDV03', 'Sương mù dày tại Fansipan làm giảm tầm nhìn.',
        'Đổi khung giờ tham quan và bổ sung điểm check-in trong nhà.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 34 DAY);
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_SAPA_OLD_MEDICAL', 'TTT_SAPA_OLD', 'NV_HDV03', 'Một khách bị đau chân nhẹ sau chặng đi bộ.',
        'Hỗ trợ băng cố định, sắp xếp xe điện và theo dõi sức khỏe.', 'THAP', 'Y_TE', NOW() - INTERVAL 33 DAY);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HOIAN_OLD_WATER', 'TTT_HOIAN_OLD', 'NV_HDV04', 'Nước uống bổ sung', 210000, 'https://seed.local/hoa-don/hoian-water.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_MUINE_OLD_JEEP', 'TTT_MUINE_OLD', 'NV_HDV05', 'Xe jeep Bàu Trắng phát sinh', 650000, 'https://seed.local/hoa-don/muine-jeep.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HALONG_OLD_LOUNGE', 'TTT_HALONG_OLD', 'NV_HDV06', 'Khu chờ khách tại cảng', 480000, 'https://seed.local/hoa-don/halong-lounge.jpg', 'DA_DUYET', NOW() - INTERVAL 19 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_SAPA_OLD_MEDICAL', 'TTT_SAPA_OLD', 'NV_HDV03', 'Bộ y tế và băng cố định', 260000, 'https://seed.local/hoa-don/sapa-medical.jpg', 'DA_DUYET', NOW() - INTERVAL 33 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_SAPA_OLD_EV', 'TTT_SAPA_OLD', 'NV_HDV03', 'Xe điện hỗ trợ khách', 420000, 'https://seed.local/hoa-don/sapa-ev.jpg', 'DA_DUYET', NOW() - INTERVAL 33 DAY);

-- 5. Them Danh Gia cho cac tour nay
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HA_01', 'TTT_HOIAN_OLD', 'KH_06', 5, 'Trải nghiệm rất tuyệt vời, phố cổ đẹp.', NOW() - INTERVAL 15 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_MN_01', 'TTT_MUINE_OLD', 'KH_07', 4, 'Đồi cát rất rộng và đẹp, tuy nhiên trời hơi nắng.', NOW() - INTERVAL 15 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HL_01', 'TTT_HALONG_OLD', 'KH_08', 5, 'Du thuyền đẹp, đồ ăn ngon, phục vụ chu đáo.', NOW() - INTERVAL 15 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH01', 'TTT_SAPA_OLD', 'KH_01', 5, 'Fansipan nhiều sương nhưng HDV đổi lịch rất linh hoạt.', NOW() - INTERVAL 30 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH02', 'TTT_SAPA_OLD', 'KH_02', 5, 'Khách sạn sạch, bữa ăn địa phương ngon và lịch trình vừa sức.', NOW() - INTERVAL 30 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH03', 'TTT_SAPA_OLD', 'KH_03', 4, 'Cần thêm thời gian tự do ở chợ đêm, còn lại rất ổn.', NOW() - INTERVAL 29 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH04', 'TTT_SAPA_OLD', 'KH_04', 5, 'Phòng đơn được sắp xếp đúng yêu cầu, HDV chăm sóc kỹ.', NOW() - INTERVAL 29 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_SAPA_OLD_KH05', 'TTT_SAPA_OLD', 'KH_05', 4, 'Gia đình hài lòng, trẻ nhỏ được hỗ trợ khi đi bộ.', NOW() - INTERVAL 28 DAY);


-- BỔ SUNG: TOUR THỰC TẾ Ở NHIỀU TRẠNG THÁI, DỮ LIỆU LIÊN QUAN ĐẦY ĐỦ

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
        NOW() + INTERVAL 1 DAY, 'Hai khách giữ chỗ tour Đà Lạt, đã thanh toán cọc một phần.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_DALAT_MB_02_01', 'DDT_DALAT_MB_02_CHO', 'Bùi Minh Ngọc', '079299000501', '0922000501', '1998-02-14', 'NỮ', NULL);
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
        NOW() - INTERVAL 10 DAY, 'Gia đình ba người đi Phú Quốc, thanh toán đủ trước ngày khởi hành.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_PHUQUOC_SDR_02_01', 'DDT_PHUQUOC_SDR_02_OK', 'Hoàng Gia Bảo', '079299000502', '0922000502', '1990-06-06', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_PHUQUOC_SDR_02_02', 'DDT_PHUQUOC_SDR_02_OK', 'Hoàng Minh Châu', '079299000503', '0922000503', '2016-09-09', 'NỮ', 'Trẻ em');
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
VALUES ('DDT_BMT_DDR_02_OK', 'TTT_BUONMATHUOT_DDR_02', 'KH_08', NOW() - INTERVAL 10 DAY, 8680000, 'DA_THANH_TOAN',
        NOW() - INTERVAL 8 DAY, 'Hai khách đang tham gia tour Buôn Ma Thuột.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_BMT_DDR_02_01', 'DDT_BMT_DDR_02_OK', 'Vũ Hải Đăng', '079299000504', '0922000504', '1989-12-12', 'NAM', NULL);
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
VALUES ('DD_BMT_DDR_02_KH_OK', 'TTT_BUONMATHUOT_DDR_02', 'KH_08', NULL, 'NGUOI_DAT', 'NV_HDV10', NOW() - INTERVAL 4 HOUR, 'Bảo tàng Cà phê', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BMT_DDR_02_NDH_OK', 'TTT_BUONMATHUOT_DDR_02', NULL, 'NDH_BMT_DDR_02_01', 'NGUOI_DONG_HANH', 'NV_HDV10', NOW() - INTERVAL 4 HOUR, 'Bảo tàng Cà phê', 'DA_DIEM_DANH');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_BMT_DDR_02_LOCAL', 'TTT_BUONMATHUOT_DDR_02', 'KH_08', 'HDX_LOCAL', 'NV_HDV10', NOW() - INTERVAL 2 HOUR,
        'Khách sử dụng bình nước cá nhân và mua sản phẩm địa phương không dùng túi nhựa.');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_BMT_DDR_02_RAIN', 'TTT_BUONMATHUOT_DDR_02', 'NV_HDV10', 'Mưa lớn khi tham quan thác Dray Nur.',
        'Đổi lịch tham quan trong nhà và phát áo mưa cho khách.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 90 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BMT_DDR_02_RAINCOAT', 'TTT_BUONMATHUOT_DDR_02', 'NV_HDV10', 'Áo mưa và khăn khô', 220000, 'https://seed.local/hoa-don/bmt-ao-mua.jpg', 'CHO_DUYET', NOW() - INTERVAL 80 MINUTE);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_OK', 'TTT_CANTHO_KT_02', 'KH_09', NOW() - INTERVAL 25 DAY, 8500000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 23 DAY, 'Nhóm hai khách đã hoàn thành tour Cần Thơ.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_01', 'DDT_CANTHO_KT_02_OK', 'Đặng Minh Khôi', '079299000505', '0922000505', '1986-01-21', 'NAM', NULL);
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
        NOW() - INTERVAL 22 DAY, 'Khách lẻ đặt tour Cần Thơ, cần thực đơn chay.', 'HDX_EBILL:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_02_KH', 'DDT_CANTHO_KT_02_02', 'KH_12', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_02_PAY', 'DDT_CANTHO_KT_02_02', 'THANH_TOAN', 'VI_DIEN_TU', 3800000, 'BANK-CANTHO-022', 'THANH_CONG', NOW() - INTERVAL 23 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_03', 'TTT_CANTHO_KT_02', 'KH_13', NOW() - INTERVAL 24 DAY, 7600000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 22 DAY, 'Hai khách đi nghỉ cuối tuần, ưu tiên phòng yên tĩnh.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_03_01', 'DDT_CANTHO_KT_02_03', 'Nguyễn Hoài Nam', '079299000508', '0922000508', '1984-06-17', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_03_KH', 'DDT_CANTHO_KT_02_03', 'KH_13', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_03_NDH1', 'DDT_CANTHO_KT_02_03', NULL, 'NDH_CANTHO_KT_02_03_01', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_03_PAY', 'DDT_CANTHO_KT_02_03', 'THANH_TOAN', 'CHUYEN_KHOAN', 7600000, 'BANK-CANTHO-023', 'THANH_CONG', NOW() - INTERVAL 23 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_04', 'TTT_CANTHO_KT_02', 'KH_14', NOW() - INTERVAL 23 DAY, 12300000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 21 DAY, 'Gia đình ba người đặt thêm gói chụp ảnh hành trình.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_04_01', 'DDT_CANTHO_KT_02_04', 'Lâm Gia Hân', '079299000509', '0922000509', '2019-03-15', 'NỮ', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_04_02', 'DDT_CANTHO_KT_02_04', 'Lâm Minh Phúc', '079299000510', '0922000510', '1988-05-03', 'NAM', NULL);
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
        NOW() - INTERVAL 21 DAY, 'Khách lẻ đặt thêm gói ảnh, thanh toán đủ một lần.', 'HDX_EBILL:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CANTHO_KT_02_05_KH', 'DDT_CANTHO_KT_02_05', 'KH_15', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_CANTHO_KT_02_05_PHOTO', 'DDT_CANTHO_KT_02_05', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CANTHO_KT_02_05_PAY', 'DDT_CANTHO_KT_02_05', 'THANH_TOAN', 'CHUYEN_KHOAN', 4700000, 'BANK-CANTHO-025', 'THANH_CONG', NOW() - INTERVAL 22 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_CANTHO_KT_02_06', 'TTT_CANTHO_KT_02', 'KH_06', NOW() - INTERVAL 22 DAY, 7600000, 'CHO_XAC_NHAN',
        NOW() - INTERVAL 20 DAY, 'Hai khách đi tour Cần Thơ, cần xác nhận xe đưa đón.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CANTHO_KT_02_06_01', 'DDT_CANTHO_KT_02_06', 'Bùi Minh An', '079299000511', '0922000511', '1995-10-10', 'NAM', NULL);
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
VALUES ('SC_CANTHO_KT_02_BOAT', 'TTT_CANTHO_KT_02', 'NV_HDV07', 'Thuyền chợ nổi đổi bến đón khách do triều cường.',
        'Thông báo sớm, điều xe trung chuyển và giữ nguyên lịch tham quan.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 13 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CANTHO_KT_02_TRANSFER', 'TTT_CANTHO_KT_02', 'NV_HDV07', 'Xe trung chuyển ra bến phụ', 420000, 'https://seed.local/hoa-don/cantho-transfer.jpg', 'DA_DUYET', NOW() - INTERVAL 13 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH09', 'TTT_CANTHO_KT_02', 'KH_09', 5, 'Lịch trình hợp lý, hướng dẫn viên xử lý đổi bến rất chuyên nghiệp.', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH12', 'TTT_CANTHO_KT_02', 'KH_12', 5, 'Thực đơn chay được chuẩn bị chu đáo, chợ nổi rất thú vị.', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH13', 'TTT_CANTHO_KT_02', 'KH_13', 4, 'Tour nhẹ nhàng, khách sạn yên tĩnh, nên thêm thời gian ở miệt vườn.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH14', 'TTT_CANTHO_KT_02', 'KH_14', 5, 'Gia đình có trẻ nhỏ vẫn đi rất thoải mái, ảnh hành trình đẹp.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH15', 'TTT_CANTHO_KT_02', 'KH_15', 4, 'Dịch vụ tốt, di chuyển đúng giờ, phần ăn sáng có thể đa dạng hơn.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CANTHO_KT_02_KH06', 'TTT_CANTHO_KT_02', 'KH_06', 5, 'Hướng dẫn viên nhiệt tình và hỗ trợ xe đưa đón rất rõ ràng.', NOW() - INTERVAL 8 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HAGIANG_HUY_02_OK', 'TTT_HAGIANG_HUY_02', 'KH_10', NOW() - INTERVAL 9 DAY, 12720000, 'CHO_HUY',
        NOW() - INTERVAL 7 DAY, 'Hai khách đã thanh toán, tour bị hủy do sạt lở đường đèo.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HAGIANG_HUY_02_01', 'DDT_HAGIANG_HUY_02_OK', 'Mai Hoàng Long', '079299000506', '0922000506', '1991-04-04', 'NAM', NULL);
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
        NOW() - INTERVAL 63 DAY, 'Hai khách hoàn thành tour Huế và đã quyết toán.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HUE_QT_02_01', 'DDT_HUE_QT_02_OK', 'Cao Minh Anh', '079299000507', '0922000507', '1982-07-17', 'NỮ', NULL);
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
VALUES ('SC_HUE_QT_02_FOOD', 'TTT_HUE_QT_02', 'NV_HDV09', 'Một khách dị ứng nhẹ với món ăn có tôm.',
        'Đổi suất ăn riêng và ghi chú lại với nhà hàng các bữa sau.', 'THAP', 'AN_UONG', NOW() - INTERVAL 44 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_HOTEL', 'TTT_HUE_QT_02', 'NV_HDV09', 'Khách sạn Huế 2 đêm', 3900000, 'https://seed.local/hoa-don/hue02-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 43 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_MEAL', 'TTT_HUE_QT_02', 'NV_HDV09', 'Suất ăn thay thế cho khách dị ứng', 260000, 'https://seed.local/hoa-don/hue02-meal.jpg', 'DA_DUYET', NOW() - INTERVAL 43 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_TICKET', 'TTT_HUE_QT_02', 'NV_HDV09', 'Vé tham quan Đại Nội', 700000, 'https://seed.local/hoa-don/hue02-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 42 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HUE_QT_02_KH11', 'TTT_HUE_QT_02', 'KH_11', 5, 'Tour Huế chỉn chu, xử lý dị ứng món ăn rất nhanh và chu đáo.', NOW() - INTERVAL 40 DAY);
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_HUE_02_DONE', 'TTT_HUE_QT_02', 0, 0, 8500000, 0, 'NV_KT01', NOW() - INTERVAL 39 DAY, 'DA_QUYET_TOAN',
        'Quyết toán tour Huế bổ sung, doanh thu và chi phí được trigger tính lại.');

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
VALUES ('DDT_SAPA_OPEN_03_GD1', 'TTT_SAPA_OPEN_03', 'KH_01', NOW() - INTERVAL 5 DAY, 25350000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Gia đình 5 khách, yêu cầu 2 phòng gần nhau và suất ăn không hải sản cho người đặt.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_01', 'DDT_SAPA_OPEN_03_GD1', 'Nguyễn Minh Đức', '001086030101', '0903000101', '1986-03-12', 'NAM', 'Chồng người đặt tour');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_02', 'DDT_SAPA_OPEN_03_GD1', 'Nguyễn Bảo An', '001112030102', '0903000102', '2012-08-24', 'Nữ', 'Trẻ em 12 tuổi');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_03', 'DDT_SAPA_OPEN_03_GD1', 'Nguyễn Gia Huy', '001116030103', '0903000103', '2016-11-05', 'NAM', 'Trẻ em 8 tuổi');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_SAPA_OPEN_03_GD1_04', 'DDT_SAPA_OPEN_03_GD1', 'Trần Thị Kim Liên', '001060030104', '0903000104', '1960-02-18', 'Nữ', 'Người cao tuổi, hạn chế leo dốc');
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
VALUES ('DDT_DANANG_OPEN_03_FAMILY', 'TTT_DANANG_OPEN_03', 'KH_06', NOW() - INTERVAL 3 DAY, 27300000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Gia đình bốn khách, cần đưa đón sân bay Đà Nẵng và bàn ăn riêng tối ở Hội An.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_03_01', 'DDT_DANANG_OPEN_03_FAMILY', 'Bùi Thanh Phong', '048087030111', '0903000111', '1987-01-19', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_03_02', 'DDT_DANANG_OPEN_03_FAMILY', 'Bùi An Nhiên', '048014030112', '0903000112', '2014-05-07', 'Nữ', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_03_03', 'DDT_DANANG_OPEN_03_FAMILY', 'Bùi Gia Khang', '048017030113', '0903000113', '2017-09-22', 'NAM', 'Trẻ em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_KH', 'DDT_DANANG_OPEN_03_FAMILY', 'KH_06', NULL, 'NGUOI_DAT', 6750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_NDH1', 'DDT_DANANG_OPEN_03_FAMILY', NULL, 'NDH_DANANG_OPEN_03_01', 'NGUOI_DONG_HANH', 6750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_NDH2', 'DDT_DANANG_OPEN_03_FAMILY', NULL, 'NDH_DANANG_OPEN_03_02', 'NGUOI_DONG_HANH', 6750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_03_NDH3', 'DDT_DANANG_OPEN_03_FAMILY', NULL, 'NDH_DANANG_OPEN_03_03', 'NGUOI_DONG_HANH', 6750000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_DANANG_OPEN_03_DINNER', 'DDT_DANANG_OPEN_03_FAMILY', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_DANANG_OPEN_03_PAY', 'DDT_DANANG_OPEN_03_FAMILY', 'THANH_TOAN', 'CHUYEN_KHOAN', 27300000, 'BANK-OPEN-0302', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_DALAT_OPEN_03_COUPLE', 'TTT_DALAT_OPEN_03', 'KH_07', NOW() - INTERVAL 2 DAY, 9100000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách đi nghỉ dưỡng, đặt đưa đón sân bay Liên Khương.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DALAT_OPEN_03_01', 'DDT_DALAT_OPEN_03_COUPLE', 'Tạ Minh Quân', '026091030114', '0903000114', '1991-03-03', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DALAT_OPEN_03_KH', 'DDT_DALAT_OPEN_03_COUPLE', 'KH_07', NULL, 'NGUOI_DAT', 4350000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DALAT_OPEN_03_NDH1', 'DDT_DALAT_OPEN_03_COUPLE', NULL, 'NDH_DALAT_OPEN_03_01', 'NGUOI_DONG_HANH', 4350000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_DALAT_OPEN_03_AIRPORT', 'DDT_DALAT_OPEN_03_COUPLE', 'DVT_AIRPORT', 1, 400000, 400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_DALAT_OPEN_03_PAY', 'DDT_DALAT_OPEN_03_COUPLE', 'THANH_TOAN', 'VI_DIEN_TU', 9100000, 'BANK-OPEN-0303', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_NINHBINH_OPEN_03_TEAM', 'TTT_NINHBINH_OPEN_03', 'KH_08', NOW() - INTERVAL 2 DAY, 16900000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Nhóm năm khách đi cuối tuần, đặt gói ảnh hành trình.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_01', 'DDT_NINHBINH_OPEN_03_TEAM', 'Đinh Hải Long', '037089030115', '0903000115', '1989-04-12', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_02', 'DDT_NINHBINH_OPEN_03_TEAM', 'Đinh Ngọc Hân', '037092030116', '0903000116', '1992-02-23', 'Nữ', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_03', 'DDT_NINHBINH_OPEN_03_TEAM', 'Trịnh Gia Phúc', '037090030117', '0903000117', '1990-10-08', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_NINHBINH_OPEN_03_04', 'DDT_NINHBINH_OPEN_03_TEAM', 'Trịnh Hoài Thương', '037093030118', '0903000118', '1993-07-16', 'Nữ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_KH', 'DDT_NINHBINH_OPEN_03_TEAM', 'KH_08', NULL, 'NGUOI_DAT', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH1', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_01', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH2', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_02', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH3', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_03', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_NINHBINH_OPEN_03_NDH4', 'DDT_NINHBINH_OPEN_03_TEAM', NULL, 'NDH_NINHBINH_OPEN_03_04', 'NGUOI_DONG_HANH', 3200000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_NINHBINH_OPEN_03_PHOTO', 'DDT_NINHBINH_OPEN_03_TEAM', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_NINHBINH_OPEN_03_PAY', 'DDT_NINHBINH_OPEN_03_TEAM', 'THANH_TOAN', 'CHUYEN_KHOAN', 16900000, 'BANK-OPEN-0304', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_PHUQUOC_OPEN_03_FAMILY', 'TTT_PHUQUOC_OPEN_03', 'KH_09', NOW() - INTERVAL 3 DAY, 32600000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Bốn khách nghỉ biển, cần xuất hóa đơn công ty sau khi thanh toán.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_03_01', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'Võ Nhật Minh', '091087030119', '0903000119', '1987-12-09', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_03_02', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'Võ Mai Chi', '091013030120', '0903000120', '2013-01-29', 'Nữ', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_03_03', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'Võ Khánh An', '091016030121', '0903000121', '2016-06-11', 'NAM', 'Trẻ em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_KH', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'KH_09', NULL, 'NGUOI_DAT', 8150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_NDH1', 'DDT_PHUQUOC_OPEN_03_FAMILY', NULL, 'NDH_PHUQUOC_OPEN_03_01', 'NGUOI_DONG_HANH', 8150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_NDH2', 'DDT_PHUQUOC_OPEN_03_FAMILY', NULL, 'NDH_PHUQUOC_OPEN_03_02', 'NGUOI_DONG_HANH', 8150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_03_NDH3', 'DDT_PHUQUOC_OPEN_03_FAMILY', NULL, 'NDH_PHUQUOC_OPEN_03_03', 'NGUOI_DONG_HANH', 8150000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_PHUQUOC_OPEN_03_PAY', 'DDT_PHUQUOC_OPEN_03_FAMILY', 'THANH_TOAN', 'THE_NOI_DIA', 32600000, 'BANK-OPEN-0305', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HUE_OPEN_03_COUPLE', 'TTT_HUE_OPEN_03', 'KH_10', NOW() - INTERVAL 2 DAY, 9750000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách tham quan di sản, một khách dị ứng hải sản có vỏ.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_OPEN_03_01', 'DDT_HUE_OPEN_03_COUPLE', 'Mai Thanh Bình', '075086030122', '0903000122', '1986-08-18', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_OPEN_03_KH', 'DDT_HUE_OPEN_03_COUPLE', 'KH_10', NULL, 'NGUOI_DAT', 4550000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_OPEN_03_NDH1', 'DDT_HUE_OPEN_03_COUPLE', NULL, 'NDH_HUE_OPEN_03_01', 'NGUOI_DONG_HANH', 4550000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HUE_OPEN_03_SINGLE', 'DDT_HUE_OPEN_03_COUPLE', 'DVT_SINGLE', 1, 650000, 650000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HUE_OPEN_03_PAY', 'DDT_HUE_OPEN_03_COUPLE', 'THANH_TOAN', 'CHUYEN_KHOAN', 9750000, 'BANK-OPEN-0306', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HAGIANG_OPEN_03_TEAM', 'TTT_HAGIANG_OPEN_03', 'KH_11', NOW() - INTERVAL 4 DAY, 19620000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khách yêu thiên nhiên, cần lịch trình ít leo dốc và bảo hiểm bổ sung.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HAGIANG_OPEN_03_01', 'DDT_HAGIANG_OPEN_03_TEAM', 'Cao Minh Khoa', '024084030123', '0903000123', '1984-02-10', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HAGIANG_OPEN_03_02', 'DDT_HAGIANG_OPEN_03_TEAM', 'Cao Ngọc Linh', '024090030124', '0903000124', '1990-05-21', 'Nữ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HAGIANG_OPEN_03_KH', 'DDT_HAGIANG_OPEN_03_TEAM', 'KH_11', NULL, 'NGUOI_DAT', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HAGIANG_OPEN_03_NDH1', 'DDT_HAGIANG_OPEN_03_TEAM', NULL, 'NDH_HAGIANG_OPEN_03_01', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HAGIANG_OPEN_03_NDH2', 'DDT_HAGIANG_OPEN_03_TEAM', NULL, 'NDH_HAGIANG_OPEN_03_02', 'NGUOI_DONG_HANH', 6500000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HAGIANG_OPEN_03_INS', 'DDT_HAGIANG_OPEN_03_TEAM', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HAGIANG_OPEN_03_PAY', 'DDT_HAGIANG_OPEN_03_TEAM', 'THANH_TOAN', 'CHUYEN_KHOAN', 19620000, 'BANK-OPEN-0307', 'THANH_CONG', NOW() - INTERVAL 3 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HOIAN_OPEN_03_GROUP', 'TTT_HOIAN_OPEN_03', 'KH_12', NOW() - INTERVAL 3 DAY, 19300000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Bốn khách ăn chay, đặt thêm bữa tối trải nghiệm món địa phương.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HOIAN_OPEN_03_01', 'DDT_HOIAN_OPEN_03_GROUP', 'Ngô Thanh Nhã', '048092030125', '0903000125', '1992-04-04', 'Nữ', 'Ăn chay');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HOIAN_OPEN_03_02', 'DDT_HOIAN_OPEN_03_GROUP', 'Ngô Minh Triết', '048089030126', '0903000126', '1989-01-15', 'NAM', 'Ăn chay');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HOIAN_OPEN_03_03', 'DDT_HOIAN_OPEN_03_GROUP', 'Lý Hoài An', '048094030127', '0903000127', '1994-09-27', 'Nữ', 'Ăn chay');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_KH', 'DDT_HOIAN_OPEN_03_GROUP', 'KH_12', NULL, 'NGUOI_DAT', 4750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_NDH1', 'DDT_HOIAN_OPEN_03_GROUP', NULL, 'NDH_HOIAN_OPEN_03_01', 'NGUOI_DONG_HANH', 4750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_NDH2', 'DDT_HOIAN_OPEN_03_GROUP', NULL, 'NDH_HOIAN_OPEN_03_02', 'NGUOI_DONG_HANH', 4750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HOIAN_OPEN_03_NDH3', 'DDT_HOIAN_OPEN_03_GROUP', NULL, 'NDH_HOIAN_OPEN_03_03', 'NGUOI_DONG_HANH', 4750000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HOIAN_OPEN_03_DINNER', 'DDT_HOIAN_OPEN_03_GROUP', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HOIAN_OPEN_03_PAY', 'DDT_HOIAN_OPEN_03_GROUP', 'THANH_TOAN', 'VI_DIEN_TU', 19300000, 'BANK-OPEN-0308', 'THANH_CONG', NOW() - INTERVAL 2 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HALONG_OPEN_03_COUPLE', 'TTT_HALONG_OPEN_03', 'KH_13', NOW() - INTERVAL 2 DAY, 13200000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách cần phòng yên tĩnh và gói ảnh trên du thuyền.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HALONG_OPEN_03_01', 'DDT_HALONG_OPEN_03_COUPLE', 'Dương Hoài Nam', '022087030128', '0903000128', '1987-06-06', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HALONG_OPEN_03_KH', 'DDT_HALONG_OPEN_03_COUPLE', 'KH_13', NULL, 'NGUOI_DAT', 6150000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HALONG_OPEN_03_NDH1', 'DDT_HALONG_OPEN_03_COUPLE', NULL, 'NDH_HALONG_OPEN_03_01', 'NGUOI_DONG_HANH', 6150000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HALONG_OPEN_03_PHOTO', 'DDT_HALONG_OPEN_03_COUPLE', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HALONG_OPEN_03_PAY', 'DDT_HALONG_OPEN_03_COUPLE', 'THANH_TOAN', 'THE_QUOC_TE', 13200000, 'BANK-OPEN-0309', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_CANTHO_OPEN_03_FAMILY', 'TTT_CANTHO_OPEN_03', 'KH_14', NOW() - INTERVAL 2 DAY, 12150000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Gia đình ba khách có trẻ nhỏ, cần món không trứng gà.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_CANTHO_OPEN_03_01', 'DDT_CANTHO_OPEN_03_FAMILY', 'Lâm Minh Phúc', '092088030129', '0903000129', '1988-05-03', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_CANTHO_OPEN_03_02', 'DDT_CANTHO_OPEN_03_FAMILY', 'Lâm Gia Hân', '092019030130', '0903000130', '2019-03-15', 'Nữ', 'Trẻ em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CANTHO_OPEN_03_KH', 'DDT_CANTHO_OPEN_03_FAMILY', 'KH_14', NULL, 'NGUOI_DAT', 3950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CANTHO_OPEN_03_NDH1', 'DDT_CANTHO_OPEN_03_FAMILY', NULL, 'NDH_CANTHO_OPEN_03_01', 'NGUOI_DONG_HANH', 3950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CANTHO_OPEN_03_NDH2', 'DDT_CANTHO_OPEN_03_FAMILY', NULL, 'NDH_CANTHO_OPEN_03_02', 'NGUOI_DONG_HANH', 3950000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_CANTHO_OPEN_03_DINNER', 'DDT_CANTHO_OPEN_03_FAMILY', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_CANTHO_OPEN_03_PAY', 'DDT_CANTHO_OPEN_03_FAMILY', 'THANH_TOAN', 'CHUYEN_KHOAN', 12150000, 'BANK-OPEN-0310', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_CONDAO_OPEN_03_COUPLE', 'TTT_CONDAO_OPEN_03', 'KH_15', NOW() - INTERVAL 2 DAY, 17820000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách nghỉ dưỡng biển đảo, đăng ký bảo hiểm và hoạt động làm sạch bãi biển.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_CONDAO_OPEN_03_01', 'DDT_CONDAO_OPEN_03_COUPLE', 'Hồ Minh Quân', '095090030131', '0903000131', '1990-11-20', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CONDAO_OPEN_03_KH', 'DDT_CONDAO_OPEN_03_COUPLE', 'KH_15', NULL, 'NGUOI_DAT', 8850000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_CONDAO_OPEN_03_NDH1', 'DDT_CONDAO_OPEN_03_COUPLE', NULL, 'NDH_CONDAO_OPEN_03_01', 'NGUOI_DONG_HANH', 8850000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_CONDAO_OPEN_03_INS', 'DDT_CONDAO_OPEN_03_COUPLE', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_CONDAO_OPEN_03_PAY', 'DDT_CONDAO_OPEN_03_COUPLE', 'THANH_TOAN', 'VI_DIEN_TU', 17820000, 'BANK-OPEN-0311', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_MOCCHAU_OPEN_03_COUPLE', 'TTT_MOCCHAU_OPEN_03', 'KH_01', NOW() - INTERVAL 1 DAY, 6800000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách đi ngắm mùa hoa, đặt gói ảnh hành trình.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_MOCCHAU_OPEN_03_01', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'Trần Minh Hoàng', '014086030132', '0903000132', '1986-09-09', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MOCCHAU_OPEN_03_KH', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'KH_01', NULL, 'NGUOI_DAT', 2950000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MOCCHAU_OPEN_03_NDH1', 'DDT_MOCCHAU_OPEN_03_COUPLE', NULL, 'NDH_MOCCHAU_OPEN_03_01', 'NGUOI_DONG_HANH', 2950000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_MOCCHAU_OPEN_03_PHOTO', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_MOCCHAU_OPEN_03_PAY', 'DDT_MOCCHAU_OPEN_03_COUPLE', 'THANH_TOAN', 'THE_NOI_DIA', 6800000, 'BANK-OPEN-0312', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_QUYNHON_OPEN_03_TEAM', 'TTT_QUYNHON_OPEN_03', 'KH_02', NOW() - INTERVAL 1 DAY, 17650000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khách đi biển, cần đưa đón sân bay Phù Cát.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_QUYNHON_OPEN_03_01', 'DDT_QUYNHON_OPEN_03_TEAM', 'Lê Hoàng Duy', '052091030133', '0903000133', '1991-02-02', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_QUYNHON_OPEN_03_02', 'DDT_QUYNHON_OPEN_03_TEAM', 'Lê Ngọc Ánh', '052094030134', '0903000134', '1994-08-08', 'Nữ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_QUYNHON_OPEN_03_KH', 'DDT_QUYNHON_OPEN_03_TEAM', 'KH_02', NULL, 'NGUOI_DAT', 5750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_QUYNHON_OPEN_03_NDH1', 'DDT_QUYNHON_OPEN_03_TEAM', NULL, 'NDH_QUYNHON_OPEN_03_01', 'NGUOI_DONG_HANH', 5750000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_QUYNHON_OPEN_03_NDH2', 'DDT_QUYNHON_OPEN_03_TEAM', NULL, 'NDH_QUYNHON_OPEN_03_02', 'NGUOI_DONG_HANH', 5750000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_QUYNHON_OPEN_03_AIRPORT', 'DDT_QUYNHON_OPEN_03_TEAM', 'DVT_AIRPORT', 1, 400000, 400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_QUYNHON_OPEN_03_PAY', 'DDT_QUYNHON_OPEN_03_TEAM', 'THANH_TOAN', 'CHUYEN_KHOAN', 17650000, 'BANK-OPEN-0313', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_BMT_OPEN_03_COUPLE', 'TTT_BUONMATHUOT_OPEN_03', 'KH_03', NOW() - INTERVAL 1 DAY, 8720000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách yêu cà phê, đăng ký bảo hiểm du lịch.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_BMT_OPEN_03_01', 'DDT_BMT_OPEN_03_COUPLE', 'Phan Anh Tuấn', '066090030135', '0903000135', '1990-01-28', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_BMT_OPEN_03_KH', 'DDT_BMT_OPEN_03_COUPLE', 'KH_03', NULL, 'NGUOI_DAT', 4300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_BMT_OPEN_03_NDH1', 'DDT_BMT_OPEN_03_COUPLE', NULL, 'NDH_BMT_OPEN_03_01', 'NGUOI_DONG_HANH', 4300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_BMT_OPEN_03_INS', 'DDT_BMT_OPEN_03_COUPLE', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_BMT_OPEN_03_PAY', 'DDT_BMT_OPEN_03_COUPLE', 'THANH_TOAN', 'VI_DIEN_TU', 8720000, 'BANK-OPEN-0314', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_PULUONG_OPEN_03_FAMILY', 'TTT_PULUONG_OPEN_03', 'KH_04', NOW() - INTERVAL 1 DAY, 14700000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Bốn khách nghỉ dưỡng sinh thái, cần phòng tầng thấp cho người lớn tuổi.', 'HDX_TREE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PULUONG_OPEN_03_01', 'DDT_PULUONG_OPEN_03_FAMILY', 'Vũ Minh Sơn', '038083030136', '0903000136', '1983-03-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PULUONG_OPEN_03_02', 'DDT_PULUONG_OPEN_03_FAMILY', 'Vũ Thảo Vy', '038012030137', '0903000137', '2012-12-12', 'Nữ', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PULUONG_OPEN_03_03', 'DDT_PULUONG_OPEN_03_FAMILY', 'Vũ Hải Đăng', '038015030138', '0903000138', '2015-04-04', 'NAM', 'Trẻ em');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_KH', 'DDT_PULUONG_OPEN_03_FAMILY', 'KH_04', NULL, 'NGUOI_DAT', 3450000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_NDH1', 'DDT_PULUONG_OPEN_03_FAMILY', NULL, 'NDH_PULUONG_OPEN_03_01', 'NGUOI_DONG_HANH', 3450000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_NDH2', 'DDT_PULUONG_OPEN_03_FAMILY', NULL, 'NDH_PULUONG_OPEN_03_02', 'NGUOI_DONG_HANH', 3450000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PULUONG_OPEN_03_NDH3', 'DDT_PULUONG_OPEN_03_FAMILY', NULL, 'NDH_PULUONG_OPEN_03_03', 'NGUOI_DONG_HANH', 3450000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_PULUONG_OPEN_03_PHOTO', 'DDT_PULUONG_OPEN_03_FAMILY', 'DVT_PHOTO', 1, 900000, 900000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_PULUONG_OPEN_03_PAY', 'DDT_PULUONG_OPEN_03_FAMILY', 'THANH_TOAN', 'CHUYEN_KHOAN', 14700000, 'BANK-OPEN-0315', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_MUINE_OPEN_03_TEAM', 'TTT_MUINE_OPEN_03', 'KH_05', NOW() - INTERVAL 1 DAY, 15700000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khách nghỉ dưỡng Mũi Né, cần xe đưa đón từ ga Phan Thiết.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_MUINE_OPEN_03_01', 'DDT_MUINE_OPEN_03_TEAM', 'Đặng Quang Huy', '060088030139', '0903000139', '1988-08-13', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_MUINE_OPEN_03_02', 'DDT_MUINE_OPEN_03_TEAM', 'Đặng Ngọc Trâm', '060091030140', '0903000140', '1991-06-25', 'Nữ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MUINE_OPEN_03_KH', 'DDT_MUINE_OPEN_03_TEAM', 'KH_05', NULL, 'NGUOI_DAT', 5100000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MUINE_OPEN_03_NDH1', 'DDT_MUINE_OPEN_03_TEAM', NULL, 'NDH_MUINE_OPEN_03_01', 'NGUOI_DONG_HANH', 5100000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_MUINE_OPEN_03_NDH2', 'DDT_MUINE_OPEN_03_TEAM', NULL, 'NDH_MUINE_OPEN_03_02', 'NGUOI_DONG_HANH', 5100000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_MUINE_OPEN_03_AIRPORT', 'DDT_MUINE_OPEN_03_TEAM', 'DVT_AIRPORT', 1, 400000, 400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_MUINE_OPEN_03_PAY', 'DDT_MUINE_OPEN_03_TEAM', 'THANH_TOAN', 'THE_QUOC_TE', 15700000, 'BANK-OPEN-0316', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_SAPA_OPEN_04_COUPLE', 'TTT_SAPA_OPEN_04', 'KH_06', NOW() - INTERVAL 1 DAY, 10700000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách đặt phụ thu phòng đơn do lịch ngủ khác nhau.', 'HDX_EBILL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_OPEN_04_01', 'DDT_SAPA_OPEN_04_COUPLE', 'Bùi Minh An', '001095030141', '0903000141', '1995-10-10', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_OPEN_04_KH', 'DDT_SAPA_OPEN_04_COUPLE', 'KH_06', NULL, 'NGUOI_DAT', 5050000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_SAPA_OPEN_04_NDH1', 'DDT_SAPA_OPEN_04_COUPLE', NULL, 'NDH_SAPA_OPEN_04_01', 'NGUOI_DONG_HANH', 5050000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_SAPA_OPEN_04_SINGLE', 'DDT_SAPA_OPEN_04_COUPLE', 'DVT_SINGLE', 1, 600000, 600000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_SAPA_OPEN_04_PAY', 'DDT_SAPA_OPEN_04_COUPLE', 'THANH_TOAN', 'CHUYEN_KHOAN', 10700000, 'BANK-OPEN-0317', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_DANANG_OPEN_04_TEAM', 'TTT_DANANG_OPEN_04', 'KH_07', NOW() - INTERVAL 1 DAY, 21000000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Ba khách đi miền Trung, đặt thêm bữa tối phố cổ.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_04_01', 'DDT_DANANG_OPEN_04_TEAM', 'Tạ Khánh Duy', '048092030142', '0903000142', '1992-12-12', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_OPEN_04_02', 'DDT_DANANG_OPEN_04_TEAM', 'Tạ Hồng Nhung', '048094030143', '0903000143', '1994-03-18', 'Nữ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_04_KH', 'DDT_DANANG_OPEN_04_TEAM', 'KH_07', NULL, 'NGUOI_DAT', 6900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_04_NDH1', 'DDT_DANANG_OPEN_04_TEAM', NULL, 'NDH_DANANG_OPEN_04_01', 'NGUOI_DONG_HANH', 6900000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_DANANG_OPEN_04_NDH2', 'DDT_DANANG_OPEN_04_TEAM', NULL, 'NDH_DANANG_OPEN_04_02', 'NGUOI_DONG_HANH', 6900000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_DANANG_OPEN_04_DINNER', 'DDT_DANANG_OPEN_04_TEAM', 'DVT_DINNER', 1, 300000, 300000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_DANANG_OPEN_04_PAY', 'DDT_DANANG_OPEN_04_TEAM', 'THANH_TOAN', 'VI_DIEN_TU', 21000000, 'BANK-OPEN-0318', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_PHUQUOC_OPEN_04_COUPLE', 'TTT_PHUQUOC_OPEN_04', 'KH_08', NOW() - INTERVAL 1 DAY, 16820000, 'DA_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Hai khách có người cao tuổi, đăng ký bảo hiểm và phòng gần thang máy.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_OPEN_04_01', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'Đoàn Thị Hạnh', '091060030144', '0903000144', '1960-07-07', 'Nữ', 'Người cao tuổi');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_04_KH', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'KH_08', NULL, 'NGUOI_DAT', 8350000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_PHUQUOC_OPEN_04_NDH1', 'DDT_PHUQUOC_OPEN_04_COUPLE', NULL, 'NDH_PHUQUOC_OPEN_04_01', 'NGUOI_DONG_HANH', 8350000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_PHUQUOC_OPEN_04_INS', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'DVT_INSURANCE', 1, 120000, 120000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_PHUQUOC_OPEN_04_PAY', 'DDT_PHUQUOC_OPEN_04_COUPLE', 'THANH_TOAN', 'THE_NOI_DIA', 16820000, 'BANK-OPEN-0319', 'THANH_CONG', NOW() - INTERVAL 1 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh) VALUES ('DDT_HUE_OPEN_04_SOLO', 'TTT_HUE_OPEN_04', 'KH_09', NOW() - INTERVAL 1 DAY, 5300000, 'CHO_XAC_NHAN', NOW() + INTERVAL 2 DAY, 'Khách lẻ cần xuất hóa đơn công ty, giữ chỗ chờ xác nhận chuyển khoản.', 'HDX_LOCAL:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat) VALUES ('CTDT_HUE_OPEN_04_KH', 'DDT_HUE_OPEN_04_SOLO', 'KH_09', NULL, 'NGUOI_DAT', 4650000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien) VALUES ('CTDV_HUE_OPEN_04_SINGLE', 'DDT_HUE_OPEN_04_SOLO', 'DVT_SINGLE', 1, 650000, 650000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan) VALUES ('GD_HUE_OPEN_04_WAIT', 'DDT_HUE_OPEN_04_SOLO', 'THANH_TOAN', 'CHUYEN_KHOAN', 5300000, 'BANK-OPEN-0320', 'CHO_THANH_TOAN', NULL);

-- Dich vu va hanh dong xanh ca nhan hoa theo tinh chat tung tuyen mo ban.
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_SAPA_HERBAL', 'Tắm lá thuốc Dao đỏ tại Sa Pa', 'Khách', 320000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_DANANG_SHOW', 'Vé show Ký ức Hội An', 'Vé', 650000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_DALAT_FARM', 'Workshop hái rau và pha cà phê Đà Lạt', 'Khách', 380000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_NINHBINH_BIKE', 'Thuê xe đạp khám phá Tam Cốc', 'Xe/ngày', 120000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_PHUQUOC_SNORKEL', 'Lặn ngắm san hô bằng tàu riêng Phú Quốc', 'Khách', 950000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HAGIANG_MOTOR', 'Xe máy có lái bản địa cung Hà Giang', 'Khách/ngày', 700000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HOIAN_LANTERN', 'Lớp làm đèn lồng Hội An', 'Khách', 280000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HALONG_KAYAK', 'Chèo kayak vịnh Hạ Long', 'Khách', 300000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_CANTHO_COOKING', 'Lớp nấu món miền Tây tại Cần Thơ', 'Khách', 360000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_CONDAO_TURTLE', 'Trải nghiệm bảo tồn rùa biển Côn Đảo', 'Khách', 520000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_MOCCHAU_TEA', 'Trải nghiệm hái chè Mộc Châu', 'Khách', 220000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_QUYNHON_CANOE', 'Cano Kỳ Co - Hòn Khô riêng', 'Khách', 680000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_BMT_COFFEE', 'Workshop rang xay cà phê Buôn Ma Thuột', 'Khách', 340000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_PULUONG_HOMESTAY', 'Nâng hạng homestay view ruộng bậc thang', 'Phòng/đêm', 480000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_MUINE_JEEP', 'Jeep riêng ngắm bình minh đồi cát Mũi Né', 'Xe', 750000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia) VALUES ('DVT_HUE_AODAI', 'Thuê áo dài chụp ảnh Đại Nội Huế', 'Bộ', 250000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_REFILL', 'Dùng trạm tiếp nước thay chai nhựa dùng một lần', 90);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_REUSABLE_BAG', 'Mang túi vải khi mua đặc sản địa phương', 70);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_LOCAL_MEAL', 'Chọn bữa ăn nguyên liệu địa phương theo mùa', 120);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_PUBLIC_TRANSFER', 'Ưu tiên xe ghép hoặc phương tiện công cộng trong chặng ngắn', 110);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_CORAL_SAFE', 'Không chạm san hô và dùng kem chống nắng thân thiện biển', 160);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong) VALUES ('HDX_COMMUNITY_BUY', 'Mua sản phẩm thủ công trực tiếp từ cộng đồng bản địa', 130);

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
-- BỘ DỮ LIỆU NGHIỆP VỤ ĐẦY ĐỦ CHO HAI HƯỚNG DẪN VIÊN MỚI
-- Các tour mẫu được sử dụng bên dưới đã có lịch trình từng ngày đầy đủ.
-- Mỗi HDV có một chuyến đã quyết toán và một chuyến sắp khởi hành.
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

-- Tạo đơn, danh sách hành khách, dịch vụ bổ sung và giao dịch đã thanh toán.;

-- Sau khi đủ đoàn và đã thanh toán, các chuyến tương lai vẫn ở trạng thái mở bán hợp lệ;
-- màn hình sắp khởi hành lọc theo ngày khởi hành gần và phân công HDV.
UPDATE tour_thuc_tes SET trang_thai = 'MO_BAN' WHERE ma_tour_thuc_te IN ('TTT_H11_HUE_SKH', 'TTT_H12_CANTHO_SKH');

-- Hai chuyến lịch sử chuyển sang giai đoạn vận hành để ghi nhận điểm danh và hành động xanh.
UPDATE tour_thuc_tes SET trang_thai = 'DANG_DIEN_RA' WHERE ma_tour_thuc_te IN ('TTT_H11_QUYNHON_LS', 'TTT_H12_CANTHO_LS');

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
SELECT 'DD_' || SUBSTR(ct.ma_chi_tiet_dat, 6), d.ma_tour_thuc_te, ct.ma_khach_hang, ct.ma_nguoi_dong_hanh, ct.loai_khach,
       CASE d.ma_tour_thuc_te WHEN 'TTT_H11_QUYNHON_LS' THEN 'NV_HDV11' ELSE 'NV_HDV12' END,
       CASE d.ma_tour_thuc_te WHEN 'TTT_H11_QUYNHON_LS' THEN '2026-05-06 07:10:00' ELSE '2026-05-12 05:20:00' END,
       CASE d.ma_tour_thuc_te WHEN 'TTT_H11_QUYNHON_LS' THEN 'Điểm đón trung tâm Quy Nhơn' ELSE 'Bến Ninh Kiều, Cần Thơ' END,
       'DA_DIEM_DANH'
FROM chi_tiet_dat_tours ct
JOIN don_dat_tours d ON d.ma_dat_tour = ct.ma_dat_tour
WHERE d.ma_tour_thuc_te IN ('TTT_H11_QUYNHON_LS', 'TTT_H12_CANTHO_LS');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H11QN_KH01', 'TTT_H11_QUYNHON_LS', 'KH_01', 'HDX_CORAL_SAFE', 'NV_HDV11', '2026-05-07 10:00:00', 'Gia đình sử dụng kem chống nắng thân thiện biển và tuân thủ hướng dẫn khi đi ca nô.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H11QN_KH02', 'TTT_H11_QUYNHON_LS', 'KH_02', 'HDX_CORAL_SAFE', 'NV_HDV11', '2026-05-07 10:15:00', 'Nhóm khách không chạm san hô, thu gom vật dụng cá nhân sau hoạt động biển.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H12CT_KH03', 'TTT_H12_CANTHO_LS', 'KH_03', 'HDX_LOCAL_MEAL', 'NV_HDV12', '2026-05-13 11:30:00', 'Đoàn lựa chọn bữa trưa sử dụng nguyên liệu theo mùa từ nhà vườn địa phương.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_H12CT_KH04', 'TTT_H12_CANTHO_LS', 'KH_04', 'HDX_LOCAL_MEAL', 'NV_HDV12', '2026-05-13 11:40:00', 'Nhóm khách dùng bữa tại hộ dân và mua sản phẩm địa phương có bao bì tái sử dụng.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_H11QN_SONG', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'Biển có sóng nhẹ vào đầu giờ chiều tại khu vực Kỳ Co.',
        'Điều chỉnh hoạt động ca nô sang khung giờ an toàn và phổ biến lại quy định áo phao cho cả đoàn.', 'THAP', 'THOI_TIET', '2026-05-07 12:30:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_H12CT_BEN', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Bến đón chợ nổi thay đổi vị trí do mực nước lên sớm.',
        'Thông báo trước cho đoàn, bố trí xe trung chuyển ngắn và kiểm đếm đầy đủ khách trước khi xuống thuyền.', 'THAP', 'PHUONG_TIEN', '2026-05-13 05:10:00');

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te IN ('TTT_H11_QUYNHON_LS', 'TTT_H12_CANTHO_LS');

-- Chi phí được HDV kê khai và duyệt trước khi kế toán lập quyết toán.
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H11QN_XE', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'Xe đưa đón sân bay Phù Cát và nội thành', 5400000, 'https://seed.local/hoa-don/quynhon-xe-dua-don.jpg', 'DA_DUYET', '2026-05-09 09:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H11QN_KS', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'Khách sạn Quy Nhơn hai đêm cho đoàn', 12600000, 'https://seed.local/hoa-don/quynhon-khach-san.jpg', 'DA_DUYET', '2026-05-09 09:20:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H11QN_VE', 'TTT_H11_QUYNHON_LS', 'NV_HDV11', 'Vé tham quan và bảo hiểm hoạt động biển', 3280000, 'https://seed.local/hoa-don/quynhon-ve-tham-quan.jpg', 'DA_DUYET', '2026-05-09 09:40:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H12CT_TAU', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Thuyền tham quan chợ nổi Cái Răng', 3600000, 'https://seed.local/hoa-don/cantho-thuyen.jpg', 'DA_DUYET', '2026-05-15 08:10:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H12CT_KS', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Khách sạn Cần Thơ hai đêm cho đoàn', 8900000, 'https://seed.local/hoa-don/cantho-khach-san.jpg', 'DA_DUYET', '2026-05-15 08:30:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_H12CT_AN', 'TTT_H12_CANTHO_LS', 'NV_HDV12', 'Bữa ăn miệt vườn và nguyên liệu lớp nấu ăn', 4300000, 'https://seed.local/hoa-don/cantho-am-thuc.jpg', 'DA_DUYET', '2026-05-15 08:50:00');

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_H11QN_HOANTAT', 'TTT_H11_QUYNHON_LS', 0, 0, 45500000, 0, 'NV_KT01', '2026-05-11 10:00:00', 'DA_QUYET_TOAN',
        'Kế toán đã đối chiếu giao dịch, hóa đơn vận hành và xác nhận hoàn tất quyết toán chuyến Quy Nhơn do hướng dẫn viên Võ Thuỳ Dương phụ trách.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_H12CT_HOANTAT', 'TTT_H12_CANTHO_LS', 0, 0, 33500000, 0, 'NV_KT01', '2026-05-17 10:30:00', 'DA_QUYET_TOAN',
        'Kế toán đã kiểm tra doanh thu, chi phí và chốt chuyến Cần Thơ do hướng dẫn viên Nguyễn Quốc Việt phụ trách.');

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H11QN_KH01', 'KH_01', 'TTT_H11_QUYNHON_LS', 'CTDT_H11QN_A_K', '2026-05-06');
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H11QN_KH02', 'KH_02', 'TTT_H11_QUYNHON_LS', 'CTDT_H11QN_B_K', '2026-05-06');
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H12CT_KH03', 'KH_03', 'TTT_H12_CANTHO_LS', 'CTDT_H12CT_A_K', '2026-05-12');
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_H12CT_KH04', 'KH_04', 'TTT_H12_CANTHO_LS', 'CTDT_H12CT_B_K', '2026-05-12');

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H11QN_KH01', 'TTT_H11_QUYNHON_LS', 'KH_01', 5, 'Hướng dẫn viên Thuỳ Dương chu đáo, nhắc an toàn biển rõ ràng và hỗ trợ gia đình có trẻ nhỏ rất tốt.', '2026-05-11 19:30:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H11QN_KH02', 'TTT_H11_QUYNHON_LS', 'KH_02', 5, 'Lịch trình Quy Nhơn hợp lý, cảnh đẹp, đoàn được chăm sóc kỹ và hoạt động bảo vệ biển rất ý nghĩa.', '2026-05-12 20:10:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H12CT_KH03', 'TTT_H12_CANTHO_LS', 'KH_03', 5, 'Anh Quốc Việt hướng dẫn thân thiện, tổ chức chợ nổi gọn gàng và chuẩn bị bữa ăn miền Tây rất ngon.', '2026-05-18 18:20:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_H12CT_KH04', 'TTT_H12_CANTHO_LS', 'KH_04', 4, 'Chuyến đi chân thực, nhiều trải nghiệm địa phương; việc đổi bến được thông báo nhanh nên cả đoàn vẫn thoải mái.', '2026-05-18 20:00:00');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H11_CP_XE', 'TK_HDV11', 'THEM', 'Chi phí thực tế hướng dẫn viên', 'CP_H11QN_XE', '2026-05-09 09:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H12_CP_TAU', 'TK_HDV12', 'THEM', 'Chi phí thực tế hướng dẫn viên', 'CP_H12CT_TAU', '2026-05-15 08:10:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H11_QT', 'TK_KT01', 'THEM', 'Quyết toán tour đã hoàn thành', 'QT_H11QN_HOANTAT', '2026-05-11 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_H12_QT', 'TK_KT01', 'THEM', 'Quyết toán tour đã hoàn thành', 'QT_H12CT_HOANTAT', '2026-05-17 10:30:00');

-- Bổ sung đoàn khách đã xác nhận cho 10 tour mở bán cố định năm 2026.
-- Mỗi tour còn 4-5 chỗ để phù hợp thực tế bán gần đủ nhưng vẫn nhận thêm khách lẻ.;

-- Đơn đã hủy: vẫn lưu đầy đủ danh sách khách, dịch vụ, thanh toán ban đầu, hoàn tiền và yêu cầu hỗ trợ.;

-- Bốn chuyến đã hoàn tất gần đây, cùng tour mẫu với các đợt đang bán năm 2026,
-- cung cấp nguồn đánh giá hợp lệ cho trang công khai.
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
       CASE d.ma_tour_thuc_te WHEN 'TTT_26_HOIAN_DG' THEN 'Điểm đón phố cổ Hội An'
            WHEN 'TTT_26_CANTHO_DG' THEN 'Bến Ninh Kiều'
            WHEN 'TTT_26_HALONG_DG' THEN 'Cảng tàu du lịch Hạ Long'
            ELSE 'Sảnh khách sạn Mũi Né' END,
       'DA_DIEM_DANH'
FROM chi_tiet_dat_tours ct
JOIN don_dat_tours d ON d.ma_dat_tour = ct.ma_dat_tour
JOIN tour_thuc_tes t ON t.ma_tour_thuc_te = d.ma_tour_thuc_te
WHERE d.ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGHA_KH01', 'TTT_26_HOIAN_DG', 'KH_01', 'HDX_LOCAL_MEAL', 'NV_HDV11', '2026-04-28 18:00:00', 'Khách sử dụng bữa tối nguyên liệu địa phương tại Hội An và hạn chế vật dụng dùng một lần.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGCT_KH04', 'TTT_26_CANTHO_DG', 'KH_04', 'HDX_LOCAL_MEAL', 'NV_HDV11', '2026-05-02 11:00:00', 'Đoàn chọn nông sản theo mùa trong lớp nấu ăn tại miệt vườn.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGHL_KH07', 'TTT_26_HALONG_DG', 'KH_07', 'HDX_REFILL', 'NV_HDV12', '2026-05-03 09:00:00', 'Khách dùng bình nước cá nhân và tiếp nước trên du thuyền thay chai nhựa mới.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_DGMN_KH10', 'TTT_26_MUINE_DG', 'KH_10', 'HDX_REFILL', 'NV_HDV12', '2026-05-08 08:30:00', 'Nhóm khách dùng trạm tiếp nước trước hành trình xe jeep tại Bàu Trắng.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGHA_MONCHAY', 'TTT_26_HOIAN_DG', 'NV_HDV11', 'Một khách báo cần đổi sang suất ăn chay trong bữa tối.',
        'Hướng dẫn viên làm việc với nhà hàng và phục vụ suất thay thế trong vòng hai mươi phút.', 'THAP', 'AN_UONG', '2026-04-28 17:30:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGCT_NUOC', 'TTT_26_CANTHO_DG', 'NV_HDV11', 'Mực nước thay đổi khiến giờ cập bến miệt vườn chậm mười phút.',
        'Điều chỉnh thứ tự lớp nấu ăn và báo lại giờ tập trung cho toàn đoàn.', 'THAP', 'PHUONG_TIEN', '2026-05-02 09:20:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGHL_GIO', 'TTT_26_HALONG_DG', 'NV_HDV12', 'Gió trên vịnh tăng nhẹ vào buổi chiều, cần theo dõi lịch chèo kayak.',
        'Rút ngắn thời lượng kayak, yêu cầu mặc áo phao và giữ nhóm theo hướng dẫn viên.', 'THAP', 'THOI_TIET', '2026-05-03 13:00:00');
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_DGMN_XE', 'TTT_26_MUINE_DG', 'NV_HDV12', 'Một xe jeep đến điểm đón trễ mười lăm phút do kiểm tra lốp an toàn.',
        'Bổ sung nước mát cho khách trong thời gian chờ và điều chỉnh lịch chụp ảnh không ảnh hưởng chương trình.', 'THAP', 'PHUONG_TIEN', '2026-05-08 05:20:00');

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC'
WHERE ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
SELECT 'LST_' || SUBSTR(d.ma_dat_tour, 5), d.ma_khach_hang, d.ma_tour_thuc_te, ct.ma_chi_tiet_dat, t.ngay_khoi_hanh
FROM don_dat_tours d
JOIN chi_tiet_dat_tours ct ON ct.ma_dat_tour = d.ma_dat_tour AND ct.ma_khach_hang = d.ma_khach_hang
JOIN tour_thuc_tes t ON t.ma_tour_thuc_te = d.ma_tour_thuc_te
WHERE d.ma_tour_thuc_te IN ('TTT_26_HOIAN_DG', 'TTT_26_CANTHO_DG', 'TTT_26_HALONG_DG', 'TTT_26_MUINE_DG');

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHA_LUUTRU', 'TTT_26_HOIAN_DG', 'NV_HDV11', 'Lưu trú và bữa sáng Hội An cho đoàn', 15400000, 'https://seed.local/hoa-don/dgha-luu-tru.jpg', 'DA_DUYET', '2026-04-30 10:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHA_XE', 'TTT_26_HOIAN_DG', 'NV_HDV11', 'Xe đưa đón và vé tham quan phố cổ', 7600000, 'https://seed.local/hoa-don/dgha-xe-ve.jpg', 'DA_DUYET', '2026-04-30 10:15:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGCT_LUUTRU', 'TTT_26_CANTHO_DG', 'NV_HDV11', 'Lưu trú Cần Thơ và bữa sáng cho đoàn', 12100000, 'https://seed.local/hoa-don/dgct-luu-tru.jpg', 'DA_DUYET', '2026-05-04 10:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGCT_THUYEN', 'TTT_26_CANTHO_DG', 'NV_HDV11', 'Thuyền chợ nổi và xe trung chuyển miệt vườn', 6300000, 'https://seed.local/hoa-don/dgct-thuyen.jpg', 'DA_DUYET', '2026-05-04 10:20:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHL_TAU', 'TTT_26_HALONG_DG', 'NV_HDV12', 'Du thuyền và phòng nghỉ trên vịnh cho đoàn', 27200000, 'https://seed.local/hoa-don/dghl-du-thuyen.jpg', 'DA_DUYET', '2026-05-05 09:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGHL_VE', 'TTT_26_HALONG_DG', 'NV_HDV12', 'Vé vịnh và thiết bị an toàn kayak', 8200000, 'https://seed.local/hoa-don/dghl-ve.jpg', 'DA_DUYET', '2026-05-05 09:20:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGMN_KS', 'TTT_26_MUINE_DG', 'NV_HDV12', 'Khách sạn ven biển Mũi Né cho đoàn', 16200000, 'https://seed.local/hoa-don/dgmn-khach-san.jpg', 'DA_DUYET', '2026-05-10 09:00:00');
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai) VALUES ('CP_DGMN_XE', 'TTT_26_MUINE_DG', 'NV_HDV12', 'Xe đưa đón và hỗ trợ lịch trình đồi cát', 7900000, 'https://seed.local/hoa-don/dgmn-xe.jpg', 'DA_DUYET', '2026-05-10 09:20:00');

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGHA_XONG', 'TTT_26_HOIAN_DG', 0, 0, 39000000, 0, 'NV_KT01', '2026-05-01 10:00:00', 'DA_QUYET_TOAN', 'Đã đối chiếu đủ doanh thu, dịch vụ và chi phí đoàn Hội An trước khi khóa quyết toán.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGCT_XONG', 'TTT_26_CANTHO_DG', 0, 0, 34000000, 0, 'NV_KT01', '2026-05-05 10:00:00', 'DA_QUYET_TOAN', 'Đã chốt doanh thu và chi phí chuyến Cần Thơ, hóa đơn thực tế đã được duyệt.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGHL_XONG', 'TTT_26_HALONG_DG', 0, 0, 55500000, 0, 'NV_KT01', '2026-05-06 10:00:00', 'DA_QUYET_TOAN', 'Đã hoàn tất quyết toán chuyến du thuyền Hạ Long và lưu hóa đơn vận hành.');
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu) VALUES ('QT_DGMN_XONG', 'TTT_26_MUINE_DG', 0, 0, 48000000, 0, 'NV_KT01', '2026-05-11 10:00:00', 'DA_QUYET_TOAN', 'Đã đối soát thanh toán và chi phí chuyến Mũi Né, dữ liệu sẵn sàng phục vụ báo cáo.');

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHA_01', 'TTT_26_HOIAN_DG', 'KH_01', 5, 'Hội An đẹp và nhẹ nhàng, lớp làm đèn lồng thú vị, hướng dẫn viên hỗ trợ món ăn địa phương rất chu đáo.', '2026-05-02 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHA_02', 'TTT_26_HOIAN_DG', 'KH_02', 5, 'Lịch trình hợp lý, xe đúng giờ và phần trải nghiệm tại Trà Quế phù hợp cho cả gia đình.', '2026-05-02 19:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHA_03', 'TTT_26_HOIAN_DG', 'KH_03', 4, 'Dịch vụ tốt, phố cổ rất đẹp, mong có thêm thời gian tự do buổi tối để dạo đèn lồng.', '2026-05-03 09:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGCT_01', 'TTT_26_CANTHO_DG', 'KH_04', 5, 'Chợ nổi rất đáng trải nghiệm, hướng dẫn viên xử lý việc đổi bến nhanh và bữa ăn miền Tây ngon.', '2026-05-06 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGCT_02', 'TTT_26_CANTHO_DG', 'KH_05', 5, 'Lớp nấu ăn gần gũi, nhà vườn thân thiện, lịch trình vừa sức cho người lớn tuổi.', '2026-05-06 19:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGCT_03', 'TTT_26_CANTHO_DG', 'KH_06', 4, 'Tour chỉn chu và nhiều trải nghiệm thật, giờ xuất phát chợ nổi hơi sớm nhưng rất xứng đáng.', '2026-05-07 08:30:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHL_01', 'TTT_26_HALONG_DG', 'KH_07', 5, 'Du thuyền sạch và tiện nghi, hoạt động kayak được hướng dẫn an toàn, cảnh vịnh rất đẹp.', '2026-05-07 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHL_02', 'TTT_26_HALONG_DG', 'KH_08', 4, 'Chuyến đi thư giãn, nhân viên nhiệt tình; thời tiết có gió nhưng lịch trình được điều chỉnh hợp lý.', '2026-05-08 08:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGHL_03', 'TTT_26_HALONG_DG', 'KH_09', 5, 'Gia đình hài lòng với phòng nghỉ trên tàu và hoạt động tiếp nước giảm chai nhựa.', '2026-05-08 09:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGMN_01', 'TTT_26_MUINE_DG', 'KH_10', 5, 'Xe jeep ngắm bình minh rất đáng nhớ, lịch trình gọn và hướng dẫn viên chăm sóc đoàn tốt.', '2026-05-12 18:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGMN_02', 'TTT_26_MUINE_DG', 'KH_11', 5, 'Biển sạch, khách sạn thoải mái và thời gian chụp ảnh ở đồi cát được sắp xếp rất đẹp.', '2026-05-12 19:00:00');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DGMN_03', 'TTT_26_MUINE_DG', 'KH_12', 4, 'Trải nghiệm tốt, đoàn được hỗ trợ ngay khi xe đến trễ; mong có thêm lựa chọn món chay.', '2026-05-13 08:00:00');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_SJ_01', 'TK_KT01', 'CAP_NHAT', 'Hoàn tiền đơn hủy', 'DDT_HUY_SJ_01', '2026-05-17 09:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_PQ_01', 'TK_KT01', 'CAP_NHAT', 'Hoàn tiền đơn hủy', 'DDT_HUY_PQ_01', '2026-05-18 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_HL_01', 'TK_KT01', 'CAP_NHAT', 'Hoàn tiền đơn hủy', 'DDT_HUY_HL_01', '2026-05-19 08:30:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_HUY_DD_01', 'TK_KT01', 'CAP_NHAT', 'Hoàn tiền đơn hủy', 'DDT_HUY_DD_01', '2026-05-20 10:15:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGHA', 'TK_KT01', 'THEM', 'Quyết toán tour đã đánh giá', 'QT_DGHA_XONG', '2026-05-01 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGCT', 'TK_KT01', 'THEM', 'Quyết toán tour đã đánh giá', 'QT_DGCT_XONG', '2026-05-05 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGHL', 'TK_KT01', 'THEM', 'Quyết toán tour đã đánh giá', 'QT_DGHL_XONG', '2026-05-06 10:00:00');
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian) VALUES ('NKHT_QT_DGMN', 'TK_KT01', 'THEM', 'Quyết toán tour đã đánh giá', 'QT_DGMN_XONG', '2026-05-11 10:00:00');

-- Voucher bo sung: tao master, vi khach hang, lich su ap dung va dong bo tong tien/giao dich.
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_FAMILY1M', 'OPEN-FAMILY-1M', 'SO_TIEN', 1000000, 'Giảm 1.000.000 cho nhóm gia đình từ 4 khách trong giai đoạn mở bán', 120, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_SUMMER8', 'OPEN-SUMMER-8', 'PHAN_TRAM', 8, 600000, 'Giảm 8% cho tour biển, đảo và miền Trung đặt trước 60 ngày', 150, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 210 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_GREEN600', 'OPEN-GREEN-600', 'SO_TIEN', 600000, 'Giảm 600.000 cho khách cam kết tối thiểu một hành động xanh', 100, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_COUPLE500', 'OPEN-COUPLE-500', 'SO_TIEN', 500000, 'Giảm 500.000 cho đơn hai khách', 90, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 160 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_LOCAL5', 'OPEN-LOCAL-5', 'PHAN_TRAM', 5, 300000, 'Giảm 5% cho tour có trải nghiệm cộng đồng địa phương', 110, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai) VALUES ('VC_OPEN_PREMIUM2M', 'OPEN-PREMIUM-2M', 'SO_TIEN', 2000000, 'Giảm 2.000.000 cho đơn trên 25.000.000 của khách hạng cao', 40, 0, DATE(NOW()) - INTERVAL 7 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');

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

UPDATE don_dat_tours SET tong_tien = 24350000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-FAMILY-1M giảm 1.000.000.' WHERE ma_dat_tour = 'DDT_SAPA_OPEN_03_GD1';
UPDATE giao_diches SET so_tien = 24350000 WHERE ma_giao_dich = 'GD_SAPA_OPEN_03_GD1_PAY';
UPDATE don_dat_tours SET tong_tien = 25116000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-SUMMER-8 giảm 2.184.000.' WHERE ma_dat_tour = 'DDT_DANANG_OPEN_03_FAMILY';
UPDATE giao_diches SET so_tien = 25116000 WHERE ma_giao_dich = 'GD_DANANG_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 8600000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-COUPLE-500 giảm 500.000.' WHERE ma_dat_tour = 'DDT_DALAT_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 8600000 WHERE ma_giao_dich = 'GD_DALAT_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 16300000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-GREEN-600 giảm 600.000.' WHERE ma_dat_tour = 'DDT_NINHBINH_OPEN_03_TEAM';
UPDATE giao_diches SET so_tien = 16300000 WHERE ma_giao_dich = 'GD_NINHBINH_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 30600000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-PREMIUM-2M giảm 2.000.000.' WHERE ma_dat_tour = 'DDT_PHUQUOC_OPEN_03_FAMILY';
UPDATE giao_diches SET so_tien = 30600000 WHERE ma_giao_dich = 'GD_PHUQUOC_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 9250000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-COUPLE-500 giảm 500.000.' WHERE ma_dat_tour = 'DDT_HUE_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 9250000 WHERE ma_giao_dich = 'GD_HUE_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 18639000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-LOCAL-5 giảm 981.000.' WHERE ma_dat_tour = 'DDT_HAGIANG_OPEN_03_TEAM';
UPDATE giao_diches SET so_tien = 18639000 WHERE ma_giao_dich = 'GD_HAGIANG_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 18700000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-GREEN-600 giảm 600.000.' WHERE ma_dat_tour = 'DDT_HOIAN_OPEN_03_GROUP';
UPDATE giao_diches SET so_tien = 18700000 WHERE ma_giao_dich = 'GD_HOIAN_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 12700000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-COUPLE-500 giảm 500.000.' WHERE ma_dat_tour = 'DDT_HALONG_OPEN_03_COUPLE';
UPDATE giao_diches SET so_tien = 12700000 WHERE ma_giao_dich = 'GD_HALONG_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 11550000, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-GREEN-600 giảm 600.000.' WHERE ma_dat_tour = 'DDT_CANTHO_OPEN_03_FAMILY';
UPDATE giao_diches SET so_tien = 11550000 WHERE ma_giao_dich = 'GD_CANTHO_OPEN_03_PAY';
UPDATE don_dat_tours SET tong_tien = 16394400, ghi_chu = ghi_chu || ' Áp dụng voucher OPEN-SUMMER-8 giảm 1.425.600.' WHERE ma_dat_tour = 'DDT_CONDAO_OPEN_03_COUPLE';
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
       'DA_XAC_NHAN', NOW() - INTERVAL 31 DAY, 'Khách đã hoàn thành tour Sa Pa, dùng làm nguồn đánh giá cho tour mẫu.', 'HDX_REFILL:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_01','KH_02','KH_03','KH_04','KH_05');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_DANANG_REVIEW_03_' || ma_khach_hang, 'TTT_DANANG_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 35 DAY,
       CASE ma_khach_hang WHEN 'KH_08' THEN 20100000 WHEN 'KH_06' THEN 13400000 WHEN 'KH_10' THEN 13400000 ELSE 6700000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 34 DAY, 'Khách đã hoàn thành tour Đà Nẵng - Hội An, dùng làm nguồn đánh giá cho tour mẫu.', 'HDX_PUBLIC_TRANSFER:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_06','KH_07','KH_08','KH_09','KH_10');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_PHUQUOC_REVIEW_03_' || ma_khach_hang, 'TTT_PHUQUOC_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 36 DAY,
       CASE ma_khach_hang WHEN 'KH_14' THEN 24600000 WHEN 'KH_11' THEN 16400000 WHEN 'KH_13' THEN 16400000 ELSE 8200000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 35 DAY, 'Khách đã hoàn thành tour Phú Quốc, dùng làm nguồn đánh giá cho tour mẫu.', 'HDX_CORAL_SAFE:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_11','KH_12','KH_13','KH_14','KH_15');
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
SELECT 'DDT_HUE_REVIEW_03_' || ma_khach_hang, 'TTT_HUE_REVIEW_03', ma_khach_hang, NOW() - INTERVAL 28 DAY,
       CASE ma_khach_hang WHEN 'KH_02' THEN 9200000 WHEN 'KH_04' THEN 9200000 WHEN 'KH_05' THEN 13800000 ELSE 4600000 END,
       'DA_XAC_NHAN', NOW() - INTERVAL 27 DAY, 'Khách đã hoàn thành tour Huế, dùng làm nguồn đánh giá cho tour mẫu.', 'HDX_REUSABLE_BAG:1'
FROM ho_chieu_sos WHERE ma_khach_hang IN ('KH_01','KH_02','KH_03','KH_04','KH_05');

INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
SELECT 'CTDT_' || SUBSTR(ma_dat_tour, 5) || '_KH', ma_dat_tour, ma_khach_hang, NULL, 'NGUOI_DAT',
       CASE ma_tour_thuc_te WHEN 'TTT_SAPA_REVIEW_03' THEN 4900000 WHEN 'TTT_DANANG_REVIEW_03' THEN 6700000 WHEN 'TTT_PHUQUOC_REVIEW_03' THEN 8200000 ELSE 4600000 END
FROM don_dat_tours
WHERE ma_dat_tour LIKE 'DDT\_%\_REVIEW\_03\_KH%' ;

INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_REVIEW_03_KH02_01', 'DDT_SAPA_REVIEW_03_KH_02', 'Lê Quốc Thịnh', '001088040101', '0904000101', '1988-07-09', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_REVIEW_03_KH05_01', 'DDT_SAPA_REVIEW_03_KH_05', 'Hoàng Gia Bảo', '001085040102', '0904000102', '1985-06-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_SAPA_REVIEW_03_KH05_02', 'DDT_SAPA_REVIEW_03_KH_05', 'Hoàng Ngọc Mai', '001089040103', '0904000103', '1989-10-11', 'Nữ', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH06_01', 'DDT_DANANG_REVIEW_03_KH_06', 'Bùi Thanh Phong', '048087040104', '0904000104', '1987-01-19', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH08_01', 'DDT_DANANG_REVIEW_03_KH_08', 'Đoàn Thị Hạnh', '048060040105', '0904000105', '1960-07-07', 'Nữ', 'Người cao tuổi');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH08_02', 'DDT_DANANG_REVIEW_03_KH_08', 'Đoàn Minh Khôi', '048090040106', '0904000106', '1990-05-21', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH09_01', 'DDT_DANANG_REVIEW_03_KH_09', 'Đặng Minh Khôi', '048086040116', '0904000116', '1986-01-21', 'NAM', 'Đi công tác kết hợp nghỉ dưỡng');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_DANANG_REVIEW_03_KH10_01', 'DDT_DANANG_REVIEW_03_KH_10', 'Mai Hoàng Long', '048091040107', '0904000107', '1991-04-04', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH11_01', 'DDT_PHUQUOC_REVIEW_03_KH_11', 'Cao Minh Anh', '091082040108', '0904000108', '1982-07-17', 'Nữ', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH13_01', 'DDT_PHUQUOC_REVIEW_03_KH_13', 'Nguyễn Hoài Nam', '091084040109', '0904000109', '1984-06-17', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH14_01', 'DDT_PHUQUOC_REVIEW_03_KH_14', 'Lâm Gia Hân', '091019040110', '0904000110', '2019-03-15', 'Nữ', 'Trẻ em');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_PHUQUOC_REVIEW_03_KH14_02', 'DDT_PHUQUOC_REVIEW_03_KH_14', 'Lâm Minh Phúc', '091088040111', '0904000111', '1988-05-03', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH02_01', 'DDT_HUE_REVIEW_03_KH_02', 'Nguyễn Minh Đức', '075086040112', '0904000112', '1986-03-12', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH04_01', 'DDT_HUE_REVIEW_03_KH_04', 'Trần Thị Kim Liên', '075060040113', '0904000113', '1960-02-18', 'Nữ', 'Người cao tuổi');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH05_01', 'DDT_HUE_REVIEW_03_KH_05', 'Hoàng Gia Bảo', '075085040114', '0904000114', '1985-06-30', 'NAM', NULL);
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu) VALUES ('NDH_HUE_REVIEW_03_KH05_02', 'DDT_HUE_REVIEW_03_KH_05', 'Hoàng Ngọc Mai', '075089040115', '0904000115', '1989-10-11', 'Nữ', NULL);

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

UPDATE don_dat_tours SET tong_tien = 13400000, ghi_chu = ghi_chu || ' Bổ sung một người đồng hành để đủ số khách tối thiểu.' WHERE ma_dat_tour = 'DDT_DANANG_REVIEW_03_KH_09';

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

INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH01', 'TTT_SAPA_REVIEW_03', 'KH_01', 5, 'Lịch trình Sa Pa vừa sức, hướng dẫn viên chăm sóc kỹ và xử lý yêu cầu ăn uống rất chu đáo.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH02', 'TTT_SAPA_REVIEW_03', 'KH_02', 5, 'Khách sạn sạch, xe đưa đón đúng giờ, gia đình có trẻ nhỏ vẫn đi rất thoải mái.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH03', 'TTT_SAPA_REVIEW_03', 'KH_03', 4, 'Cảnh đẹp và trải nghiệm bản làng tốt, nên thêm thời gian tự do ở chợ đêm.', NOW() - INTERVAL 6 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH04', 'TTT_SAPA_REVIEW_03', 'KH_04', 5, 'Phòng tầng thấp đúng yêu cầu, lịch trình không quá gấp và HDV hỗ trợ rất nhiệt tình.', NOW() - INTERVAL 6 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_SAPA_REVIEW_03_KH05', 'TTT_SAPA_REVIEW_03', 'KH_05', 4, 'Dịch vụ tốt, bữa ăn địa phương ngon, chỉ cần cải thiện thời gian chờ cáp treo.', NOW() - INTERVAL 5 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH06', 'TTT_DANANG_REVIEW_03', 'KH_06', 5, 'Tour Đà Nẵng - Hội An cân bằng giữa biển, di sản và nghỉ ngơi, xe đưa đón rất đúng giờ.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH07', 'TTT_DANANG_REVIEW_03', 'KH_07', 4, 'Phố cổ đẹp, show buổi tối đáng xem, nên giảm thời gian mua sắm ở điểm dừng.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH08', 'TTT_DANANG_REVIEW_03', 'KH_08', 5, 'Đi cùng người lớn tuổi vẫn rất ổn, HDV sắp xếp nhịp tham quan hợp lý.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH09', 'TTT_DANANG_REVIEW_03', 'KH_09', 5, 'Dịch vụ xuất hóa đơn rõ ràng, lịch trình chuyên nghiệp và bữa tối Hội An ngon.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_DANANG_REVIEW_03_KH10', 'TTT_DANANG_REVIEW_03', 'KH_10', 4, 'Đội ngũ lưu ý dị ứng hải sản tốt, khách sạn ổn, biển hơi đông vào cuối tuần.', NOW() - INTERVAL 6 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH11', 'TTT_PHUQUOC_REVIEW_03', 'KH_11', 5, 'Tour Phú Quốc thư giãn, ít phải đi bộ nhiều và hoạt động biển được hướng dẫn an toàn.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH12', 'TTT_PHUQUOC_REVIEW_03', 'KH_12', 5, 'Thực đơn chay được chuẩn bị riêng, lịch trình đảo đẹp và không quá mệt.', NOW() - INTERVAL 9 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH13', 'TTT_PHUQUOC_REVIEW_03', 'KH_13', 4, 'Khách sạn yên tĩnh, biển đẹp, nên thông báo rõ hơn thời tiết trước ngày đi cano.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH14', 'TTT_PHUQUOC_REVIEW_03', 'KH_14', 5, 'Gia đình có trẻ nhỏ được hỗ trợ tốt, hoạt động làm sạch bãi biển rất ý nghĩa.', NOW() - INTERVAL 8 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_PHUQUOC_REVIEW_03_KH15', 'TTT_PHUQUOC_REVIEW_03', 'KH_15', 4, 'Dịch vụ tốt, hướng dẫn viên vui vẻ, bữa hải sản nên có thêm lựa chọn nhẹ hơn.', NOW() - INTERVAL 7 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH01', 'TTT_HUE_REVIEW_03', 'KH_01', 5, 'Tour Huế nhẹ nhàng, món chay được chuẩn bị tốt và thuyết minh di sản rất cuốn hút.', NOW() - INTERVAL 5 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH02', 'TTT_HUE_REVIEW_03', 'KH_02', 5, 'Gia đình hài lòng, Đại Nội và lăng tẩm được sắp xếp đúng nhịp, không bị quá tải.', NOW() - INTERVAL 5 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH03', 'TTT_HUE_REVIEW_03', 'KH_03', 4, 'Lịch trình tốt, nên thêm một quán cà phê địa phương vào buổi chiều.', NOW() - INTERVAL 4 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH04', 'TTT_HUE_REVIEW_03', 'KH_04', 5, 'Khách sạn sắp phòng đúng yêu cầu, HDV kiên nhẫn và hỗ trợ người lớn tuổi tốt.', NOW() - INTERVAL 4 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia) VALUES ('DG_HUE_REVIEW_03_KH05', 'TTT_HUE_REVIEW_03', 'KH_05', 5, 'Dịch vụ chỉn chu, ăn uống ngon và phần áo dài chụp ảnh tạo trải nghiệm đáng nhớ.', NOW() - INTERVAL 3 DAY);

-- Bo sung cac don dat nhieu hanh khach de tao tour gan full va full cho.
-- Moi don co: nguoi dat, danh sach nguoi dong hanh, chi tiet dat tour, dich vu, giao dich thanh toan.;

-- Bảo đảm mọi tour đang mở bán và đã hoàn thành đều có HDV hợp lệ,
-- đồng thời bổ sung lịch sử tham gia, chi phí và báo cáo sự cố cho các tour HDV đã dẫn.;

-- Bo sung chi phi va quyet toan cho tour da hoan thanh co nhieu don dat, phuc vu luong tai chinh sau tour.
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DN_REVIEW_03_HOTEL', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', 'Khách sạn Đà Nẵng - Hội An 3 đêm', 42000000, 'https://seed.local/hoa-don/danang-review-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 10 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DN_REVIEW_03_BUS', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', 'Xe du lịch 29 chỗ trọn tour', 18500000, 'https://seed.local/hoa-don/danang-review-bus.jpg', 'DA_DUYET', NOW() - INTERVAL 10 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_DN_REVIEW_03_TICKET', 'TTT_DANANG_REVIEW_03', 'NV_HDV04', 'Vé tham quan và show Hội An', 12600000, 'https://seed.local/hoa-don/danang-review-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 9 DAY);

INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_DANANG_REVIEW_03_DONE', 'TTT_DANANG_REVIEW_03', 0, 0, 98000000, 0, 'NV_KT01', NOW() - INTERVAL 7 DAY, 'DA_QUYET_TOAN',
        'Quyết toán tour Đà Nẵng - Hội An đã hoàn thành; trigger tự tính doanh thu, chi phí và lợi nhuận theo giao dịch/chi phí thực tế.');

-- ------------------------------------------------------------
-- BO SUNG BSLK: 5 LUONG NGHIEP VU LIEN KET CHAT CHE
-- Bao phu: mo ban, dang dien ra, ket thuc, huy, quyet toan.
-- Moi bo co tour, phan cong, dich vu, hanh dong xanh, don dat,
-- hanh khach, thanh toan, ho tro, diem xanh, chi phi, danh gia/lich su.
-- ------------------------------------------------------------
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_BSLK_SEAT', 'Ghế ưu tiên hàng đầu trên xe du lịch', 'Khách', 180000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_BSLK_WORKSHOP', 'Workshop trải nghiệm văn hóa địa phương', 'Khách', 320000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_BSLK_HEALTH', 'Bộ hỗ trợ sức khỏe cá nhân trong tour', 'Bộ', 150000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_BSLK_SORT', 'Phân loại rác tại điểm lưu trú và điểm tham quan', 120);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_BSLK_NOPLASTIC', 'Không sử dụng túi nhựa dùng một lần trong suốt hành trình', 140);

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_BSLK_GROUP900', 'BSLK-GROUP-900', 'SO_TIEN', 900000, 'Giảm cho nhóm từ bốn khách trở lên trong cụm dữ liệu liên kết', 30, 0, DATE(NOW()) - INTERVAL 5 DAY, DATE(NOW()) + INTERVAL 180 DAY, 'SAN_SANG');
INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, muc_giam_toi_da, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_BSLK_GREEN12', 'BSLK-GREEN-12', 'PHAN_TRAM', 12, 700000, 'Ưu đãi khách có điểm xanh và chọn hành động xanh khi đặt tour', 25, 0, DATE(NOW()) - INTERVAL 5 DAY, DATE(NOW()) + INTERVAL 150 DAY, 'SAN_SANG');

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
VALUES ('DD_BSLK_ACTIVE_KH06', 'TTT_BSLK_ACTIVE_QN', 'KH_06', NULL, 'NGUOI_DAT', 'NV_HDV12', NOW() - INTERVAL 5 HOUR, 'Bãi Kỳ Co', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BSLK_ACTIVE_NDH1', 'TTT_BSLK_ACTIVE_QN', NULL, 'NDH_BSLK_ACTIVE_A_01', 'NGUOI_DONG_HANH', 'NV_HDV12', NOW() - INTERVAL 5 HOUR, 'Bãi Kỳ Co', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_BSLK_ACTIVE_NDH2', 'TTT_BSLK_ACTIVE_QN', NULL, 'NDH_BSLK_ACTIVE_A_02', 'NGUOI_DONG_HANH', 'NV_HDV12', NOW() - INTERVAL 5 HOUR, 'Bãi Kỳ Co', 'CHUA_DIEM_DANH');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_BSLK_ACTIVE_SORT', 'TTT_BSLK_ACTIVE_QN', 'KH_06', 'HDX_BSLK_SORT', 'NV_HDV12', NOW() - INTERVAL 2 HOUR,
        'HDV xác nhận nhóm khách phân loại rác sau bữa trưa tại làng chài.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_BSLK_ACTIVE_SEA', 'TTT_BSLK_ACTIVE_QN', 'NV_HDV12', 'Gió biển tăng nhẹ trước giờ đi Eo Gió.',
        'HDV đổi thứ tự tham quan, ưu tiên điểm trong nhà và cập nhật giờ tập trung cho khách.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 90 MINUTE);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_ACTIVE_WATER', 'TTT_BSLK_ACTIVE_QN', 'NV_HDV12', 'Nước điện giải và túi y tế bổ sung', 260000, 'https://seed.local/hoa-don/bslk-quynhon-yte.jpg', 'CHO_DUYET', NOW() - INTERVAL 70 MINUTE);

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_BSLK_DONE_KH12', 'KH_12', 'TTT_BSLK_DONE_CT', 'CTDT_BSLK_DONE_A_KH', DATE(NOW()) - INTERVAL 12 DAY);
-- Khong tao danh_gia_khs cho KH_16: du lieu nay danh rieng de quay thao tac gui danh gia moi.
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_BSLK_REVIEW_KH16', 'KH_16', 'TTT_BSLK_DONE_CT', 'CTDT_BSLK_REVIEW_A_KH', DATE(NOW()) - INTERVAL 12 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_BSLK_SETTLE_KH09', 'KH_09', 'TTT_BSLK_SETTLE_HA', 'CTDT_BSLK_SETTLE_A_KH', DATE(NOW()) - INTERVAL 60 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_BSLK_DONE_MEAL', 'TTT_BSLK_DONE_CT', 'NV_HDV11', 'Nhà vườn đổi thực đơn chay sát giờ dùng bữa.',
        'HDV xác nhận lại thành phần món ăn với khách và chuẩn bị phần riêng không dùng nước mắm.', 'THAP', 'AN_UONG', NOW() - INTERVAL 11 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_DONE_BOAT', 'TTT_BSLK_DONE_CT', 'NV_HDV11', 'Thuyền nhỏ tham quan rạch phụ', 720000, 'https://seed.local/hoa-don/bslk-cantho-thuyen.jpg', 'DA_DUYET', NOW() - INTERVAL 11 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_BSLK_DONE_KH12', 'TTT_BSLK_DONE_CT', 'KH_12', 5, 'Tour Cần Thơ chuẩn bị món chay chu đáo, lớp làm bánh dân gian rất vui.', NOW() - INTERVAL 8 DAY);

INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_SETTLE_HOTEL', 'TTT_BSLK_SETTLE_HA', 'NV_HDV11', 'Khách sạn Hội An hai đêm cho đoàn nhỏ', 7800000, 'https://seed.local/hoa-don/bslk-hoian-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 58 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_BSLK_SETTLE_MEAL', 'TTT_BSLK_SETTLE_HA', 'NV_HDV11', 'Bữa tối địa phương và workshop đèn lồng', 2350000, 'https://seed.local/hoa-don/bslk-hoian-meal.jpg', 'DA_DUYET', NOW() - INTERVAL 58 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_BSLK_SETTLE_KH09', 'TTT_BSLK_SETTLE_HA', 'KH_09', 5, 'Tour Hội An vận hành mượt, hóa đơn doanh nghiệp được hỗ trợ rõ ràng.', NOW() - INTERVAL 55 DAY);
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_BSLK_SETTLE_HA', 'TTT_BSLK_SETTLE_HA', 0, 0, 12000000, 0, 'NV_KT01', NOW() - INTERVAL 54 DAY, 'DA_QUYET_TOAN',
        'Quyết toán bộ dữ liệu BSLK Hội An, doanh thu lấy từ giao dịch đã thanh toán và chi phí đã duyệt.');

INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_BSLK_CANCEL_REFUND', 'DDT_BSLK_CANCEL_A', 'HOAN_TIEN', 'HE_THONG', 12950000, 'BANK-BSLK-REFUND', 'CHO_THANH_TOAN', NULL);

INSERT INTO nhat_ky_doi_diems (ma_nhat_ky_doi_diem, ma_khach_hang, ma_voucher, diem_quy_doi, ngay_quy_doi)
VALUES ('NKDD_BSLK_KH05_GROUP', 'KH_05', 'VC_BSLK_GROUP900', 900, NOW() - INTERVAL 2 DAY);

INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_BSLK_OPEN_SEAT', 'DDT_BSLK_OPEN_B', 'KH_11', 'DICH_VU_THEM', 'Khách cần xác nhận ghế hàng đầu và hỗ trợ lên xuống xe do đau lưng.', 'CHO_BO_SUNG', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_BSLK_CANCEL_RF', 'DDT_BSLK_CANCEL_A', 'KH_10', 'HOAN_TIEN', 'Tour Hà Giang bị hủy do điều kiện an toàn, kế toán cần xử lý hoàn tiền.', 'CHUA_XU_LY', 'NV_KT01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_BSLK_SETTLE_INV', 'DDT_BSLK_SETTLE_A', 'KH_09', 'HOA_DON', 'Khách yêu cầu xuất hóa đơn công ty sau khi tour Hội An đã quyết toán.', 'DA_XU_LY', 'NV_KT01');

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
VALUES ('TM_PHONGNHA', 'Phong Nha - Hang động kỳ quan và sông Son',
        'Hành trình 3 ngày khám phá Phong Nha, động Thiên Đường, sông Chày - hang Tối và nhịp sống ven sông Son. Tour phù hợp cho nhóm bạn, gia đình yêu thiên nhiên và khách muốn kết hợp trải nghiệm hang động với nghỉ dưỡng nhẹ.

Bao gồm:
- Xe đưa đón theo chương trình
- Vé tham quan hang động và thuyền sông Son
- Lưu trú, bữa ăn và hướng dẫn viên
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT và tips', 3, 5200000, 0, 0);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_CAMAU', 'Cà Mau - Mũi đất cuối trời và rừng ngập mặn',
        'Tour 4 ngày đi qua Cà Mau, Đất Mũi, rừng U Minh và các tuyến sông nước đặc trưng miền cực Nam. Lịch trình nhấn mạnh trải nghiệm cộng đồng, ẩm thực địa phương và hoạt động bảo tồn hệ sinh thái ngập mặn.

Bao gồm:
- Xe và tàu tham quan theo chương trình
- Vé vào khu du lịch Đất Mũi, rừng U Minh
- Lưu trú, bữa ăn và hướng dẫn viên
Không bao gồm:
- Chi phí cá nhân
- Phụ phí phòng đơn
- VAT và tips', 4, 6800000, 0, 0);

INSERT INTO tour_maus (ma_tour_mau, tieu_de, mo_ta, thoi_luong, gia_san, danh_gia, so_danh_gia)
VALUES ('TM_BABE', 'Ba Bể - Hồ xanh và bản làng Tày',
        'Chuyến đi 2 ngày về hồ Ba Bể, động Puông và bản Pác Ngòi, dành cho khách muốn nghỉ ngắn ngày trong không gian yên tĩnh, gần thiên nhiên và văn hóa bản địa.

Bao gồm:
- Xe đưa đón theo chương trình
- Thuyền hồ Ba Bể, vé tham quan
- Homestay, bữa ăn địa phương và hướng dẫn viên
Không bao gồm:
- Chi phí cá nhân
- Đồ uống ngoài chương trình
- VAT và tips', 2, 3400000, 0, 0);

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PN_NEW_01', 'TM_PHONGNHA', 1, 'Đồng Hới - Phong Nha - sông Son', 'Đón khách, di chuyển về Phong Nha, đi thuyền sông Son và nhận phòng nghỉ.', 'Sáng: Buffet khách sạn | Trưa: Cá sông Son, rau rừng, canh chua | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PN_NEW_02', 'TM_PHONGNHA', 2, 'Động Thiên Đường - sông Chày', 'Tham quan động Thiên Đường, trải nghiệm tuyến sông Chày và hoạt động nhẹ ngoài trời.', 'Sáng: Buffet khách sạn | Trưa: Gà nướng, xôi nếp, rau luộc | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_PN_NEW_03', 'TM_PHONGNHA', 3, 'Làng địa phương - Đồng Hới', 'Gặp hộ dân làm sản phẩm thủ công, mua đặc sản và kết thúc chương trình.', 'Sáng: Buffet khách sạn | Trưa: Cháo canh Quảng Bình, bánh lọc | Chiều: Trái cây nhẹ');

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_01', 'TM_CAMAU', 1, 'Cà Mau - chợ đêm - bờ kè', 'Đón khách, nhận phòng, tham quan chợ đêm và nghe giới thiệu văn hóa miền cực Nam.', 'Sáng: Buffet khách sạn | Trưa: Lẩu mắm, rau đồng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_02', 'TM_CAMAU', 2, 'Đất Mũi - cột mốc tọa độ', 'Đi tàu đến Đất Mũi, tham quan rừng ngập mặn và điểm cực Nam Tổ quốc.', 'Sáng: Buffet khách sạn | Trưa: Cua Cà Mau, cá thòi lòi nướng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_03', 'TM_CAMAU', 3, 'Rừng U Minh - trải nghiệm cộng đồng', 'Tham quan rừng tràm, nghe kể chuyện nghề gác kèo ong và dùng bữa tại hộ dân.', 'Sáng: Buffet khách sạn | Trưa: Cá lóc nướng trui, mật ong rừng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_CM_NEW_04', 'TM_CAMAU', 4, 'Mua đặc sản - tiễn khách', 'Mua quà địa phương, tổng kết hành trình xanh và tiễn khách ra sân bay/bến xe.', 'Sáng: Buffet khách sạn | Trưa: Bún nước lèo, bánh tằm cay | Chiều: Trái cây nhẹ');

INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BB_NEW_01', 'TM_BABE', 1, 'Hà Nội - hồ Ba Bể - Pác Ngòi', 'Di chuyển lên Ba Bể, đi thuyền trên hồ, nhận homestay và ăn tối cùng gia đình địa phương.', 'Sáng: Buffet khách sạn | Trưa: Cá hồ nướng, lợn bản, rau rừng | Chiều: Trái cây nhẹ');
INSERT INTO lich_trinh_tours (ma_lich_trinh_tour, ma_tour_mau, ngay_thu, hoat_dong, mo_ta, thuc_don)
VALUES ('LTT_BB_NEW_02', 'TM_BABE', 2, 'Động Puông - Hà Nội', 'Tham quan động Puông, mua đặc sản, ăn trưa và về lại Hà Nội.', 'Sáng: Buffet khách sạn | Trưa: Xôi ngũ sắc, gà đồi | Chiều: Trái cây nhẹ');

INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_TMNEW_CAVE', 'Gói đèn đội đầu và thiết bị hang động', 'Khách', 220000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_TMNEW_BOAT', 'Tàu riêng tham quan tuyến sông nước', 'Chuyến', 1800000);
INSERT INTO dich_vu_thems (ma_dich_vu_them, ten, don_vi_tinh, don_gia)
VALUES ('DVT_TMNEW_HOMESTAY', 'Nâng cấp phòng homestay riêng', 'Phòng/đêm', 420000);

INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_TMNEW_WATER', 'Dùng bình nước cá nhân và trạm tiếp nước của đoàn', 100);
INSERT INTO hanh_dong_xanhs (ma_hanh_dong_xanh, ten_hanh_dong, diem_cong)
VALUES ('HDX_TMNEW_LOCAL', 'Ưu tiên mua sản phẩm cộng đồng địa phương có bao bì tái sử dụng', 130);

INSERT INTO vouchers (ma_voucher, ma_code, loai_uu_dai, gia_tri_giam, dieu_kien_ap_dung, so_luot_phat_hanh, so_luot_da_dung, ngay_hieu_luc, ngay_het_han, trang_thai)
VALUES ('VC_TMNEW_1M', 'TMNEW-1M', 'SO_TIEN', 1000000, 'Giảm cho đoàn từ mười khách trở lên của tour mẫu mới', 20, 0, DATE(NOW()) - INTERVAL 3 DAY, DATE(NOW()) + INTERVAL 210 DAY, 'SAN_SANG');
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
VALUES ('DD_TMN_BB_KH08', 'TTT_TMNEW_BB_ACTIVE', 'KH_08', NULL, 'NGUOI_DAT', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Bến thuyền hồ Ba Bể', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_NDH01', 'TTT_TMNEW_BB_ACTIVE', NULL, 'NDH_TMN_BB04_01', 'NGUOI_DONG_HANH', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Bến thuyền hồ Ba Bể', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_NDH02', 'TTT_TMNEW_BB_ACTIVE', NULL, 'NDH_TMN_BB04_02', 'NGUOI_DONG_HANH', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Bến thuyền hồ Ba Bể', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_TMN_BB_NDH03', 'TTT_TMNEW_BB_ACTIVE', NULL, 'NDH_TMN_BB04_03', 'NGUOI_DONG_HANH', 'NV_HDV11', NOW() - INTERVAL 6 HOUR, 'Bến thuyền hồ Ba Bể', 'CHUA_DIEM_DANH');

INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_TMN_BB_WATER', 'TTT_TMNEW_BB_ACTIVE', 'KH_08', 'HDX_TMNEW_WATER', 'NV_HDV11', NOW() - INTERVAL 3 HOUR,
        'Khách dùng bình nước cá nhân và tiếp nước tại homestay thay cho chai nhựa.');

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_TMN_BB_RAIN', 'TTT_TMNEW_BB_ACTIVE', 'NV_HDV11', 'Mưa nhẹ làm đường từ bến thuyền về bản trơn hơn dự kiến.',
        'HDV đổi sang đường ngắn hơn, nhắc khách đi chậm và hỗ trợ người lớn tuổi.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 2 HOUR);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_BB_RAINCOAT', 'TTT_TMNEW_BB_ACTIVE', 'NV_HDV11', 'Áo mưa mỏng và nước ấm cho đoàn Ba Bể', 340000, 'https://seed.local/hoa-don/tmnew-babe-raincoat.jpg', 'CHO_DUYET', NOW() - INTERVAL 90 MINUTE);

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_TMN_CM_KH04', 'KH_04', 'TTT_TMNEW_CM_DONE', 'CTDT_TMN_CM06_KH', DATE(NOW()) - INTERVAL 105 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_TMN_PN_KH02', 'KH_02', 'TTT_TMNEW_PN_QT', 'CTDT_TMN_PN05_KH', DATE(NOW()) - INTERVAL 135 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_TMN_CM_BOAT', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', 'Tàu tham quan Đất Mũi đổi giờ xuất bến do thủy triều.',
        'Thông báo sớm cho khách, điều chỉnh giờ ăn trưa và giữ nguyên đủ điểm tham quan.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 103 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_CM_BOAT', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', 'Tàu riêng tuyến Đất Mũi và rừng ngập mặn', 7800000, 'https://seed.local/hoa-don/tmnew-camau-boat.jpg', 'DA_DUYET', NOW() - INTERVAL 103 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_CM_MEAL', 'TTT_TMNEW_CM_DONE', 'NV_HDV12', 'Bữa ăn cộng đồng tại Đất Mũi', 3600000, 'https://seed.local/hoa-don/tmnew-camau-meal.jpg', 'DA_DUYET', NOW() - INTERVAL 102 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_TMN_CM_KH04', 'TTT_TMNEW_CM_DONE', 'KH_04', 5, 'Tour Cà Mau nhiều trải nghiệm thật, tàu riêng giúp lịch trình thoải mái và đúng giờ.', NOW() - INTERVAL 99 DAY);

INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_TMN_PN_CAVE', 'TTT_TMNEW_PN_QT', 'NV_HDV12', 'Một khách hơi mệt khi di chuyển trong hang do độ ẩm cao.',
        'HDV bố trí nghỉ thêm mười phút, kiểm tra sức khỏe và điều chỉnh tốc độ đoàn.', 'THAP', 'Y_TE', NOW() - INTERVAL 134 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_PN_HOTEL', 'TTT_TMNEW_PN_QT', 'NV_HDV12', 'Khách sạn Phong Nha hai đêm cho đoàn năm khách', 11200000, 'https://seed.local/hoa-don/tmnew-phongnha-hotel.jpg', 'DA_DUYET', NOW() - INTERVAL 133 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_TMN_PN_TICKET', 'TTT_TMNEW_PN_QT', 'NV_HDV12', 'Vé hang động và thuyền sông Son', 5200000, 'https://seed.local/hoa-don/tmnew-phongnha-ticket.jpg', 'DA_DUYET', NOW() - INTERVAL 133 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_TMN_PN_KH02', 'TTT_TMNEW_PN_QT', 'KH_02', 4, 'Hang động rất đẹp, thiết bị chuẩn bị đầy đủ, nên thêm thời gian nghỉ giữa hai điểm.', NOW() - INTERVAL 130 DAY);
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_TMN_PN_DONE', 'TTT_TMNEW_PN_QT', 0, 0, 23500000, 0, 'NV_KT01', NOW() - INTERVAL 129 DAY, 'DA_QUYET_TOAN',
        'Quyết toán tour mẫu mới Phong Nha, đã có đủ doanh thu, chi phí thực tế, lịch sử tour và đánh giá.');

INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TMN_PN10_LIST', 'DDT_TMNEW_PN10', 'KH_03', 'THONG_TIN_HANH_KHACH', 'Đoàn mười khách cần xác nhận lại danh sách căn cước trước ngày khởi hành.', 'CHUA_XU_LY', 'NV_SALES01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TMN_BB_MEAL', 'DDT_TMNEW_BB04', 'KH_08', 'AN_UONG', 'Khách yêu cầu thực đơn ít muối cho bữa tối homestay Ba Bể.', 'DA_XU_LY', 'NV_MGR01');
INSERT INTO yeu_cau_ho_tros (ma_yeu_cau_ho_tro, ma_dat_tour, ma_khach_hang, loai_yeu_cau, noi_dung, trang_thai, ma_nhan_vien_xu_ly)
VALUES ('YCHT_TMN_CM_FEEDBACK', 'DDT_TMNEW_CM06', 'KH_04', 'PHAN_HOI_SAU_TOUR', 'Khách góp ý giữ thêm thời gian ở rừng U Minh cho các đoàn sau.', 'DA_XU_LY', 'NV_MGR01');

INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_TM_PN', 'TK_MGR01', 'THEM', 'TOURMAU_SANPHAM', 'TM_PHONGNHA', NOW() - INTERVAL 3 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_DDT_PN10', 'TK_SALES01', 'THEM', 'DONDATTOUR_SALES', 'DDT_TMNEW_PN10', NOW() - INTERVAL 3 DAY);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_BB_CP', 'TK_HDV11', 'THEM', 'CHIPHITHUCTE_HDV', 'CP_TMN_BB_RAINCOAT', NOW() - INTERVAL 80 MINUTE);
INSERT INTO nhat_ky_he_thongs (ma_nhat_ky_he_thong, ma_tai_khoan, hanh_dong, doi_tuong, ma_doi_tuong, thoi_gian)
VALUES ('NKHT_TMN_PN_QT', 'TK_KT01', 'THEM', 'QUYETTOAN_KETOAN', 'QT_TMN_PN_DONE', NOW() - INTERVAL 129 DAY);

-- ------------------------------------------------------------
-- BỔ SUNG DỮ LIỆU NGHIỆP VỤ THỰC TẾ VÀ CHUẨN HOÁ NỘI DUNG
-- ------------------------------------------------------------
-- Hai tour đang chờ kích hoạt, chưa gửi yêu cầu phân công cho bất kỳ hướng dẫn viên nào.
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CHOKH_CAMAU', 'TM_CAMAU', DATE(NOW()) + INTERVAL 435 DAY, 7100000, 22, 8, 22, 'CHO_KICH_HOAT');
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_CHOKH_BABE', 'TM_BABE', DATE(NOW()) + INTERVAL 442 DAY, 4680000, 20, 6, 20, 'CHO_KICH_HOAT');

-- Đơn đã thanh toán thành công nhưng đang chờ nhân viên xác nhận đối soát.
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_XN_TTTC_DALAT', 'TTT_BSLK_OPEN_FAM', 'KH_15', NOW() - INTERVAL 6 HOUR,
        4500000, 'CHO_XAC_NHAN', NOW() + INTERVAL 2 DAY,
        'Yêu cầu xuất hóa đơn điện tử và hỗ trợ giờ tập trung trễ 15 phút.', 'HDX_BSLK_NOPLASTIC:1');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_XN_TTTC_DALAT_KH', 'DDT_XN_TTTC_DALAT', 'KH_15', NULL, 'NGUOI_DAT', 4500000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_XN_TTTC_DALAT', 'DDT_XN_TTTC_DALAT', 'THANH_TOAN', 'CHUYEN_KHOAN', 4500000,
        'NGAN-HANG-XAC-NHAN-001', 'THANH_CONG', NOW() - INTERVAL 5 HOUR);

-- Mỗi ngày lưu timeline trong trường hoat_dong, mỗi dòng gồm thời gian và hoạt động tương ứng.
UPDATE lich_trinh_tours
SET hoat_dong = CASE MOD(CRC32(ma_lich_trinh_tour), 3)
    WHEN 0 THEN '06:30 - Dùng bữa sáng và chuẩn bị cho lịch trình trong ngày.'
        || CHAR(10) || '08:00 - ' || TRIM(TRAILING '.' FROM TRIM(mo_ta))
        || CHAR(10) || '11:30 - Dùng bữa trưa theo thực đơn của chương trình.'
        || CHAR(10) || '14:00 - Khám phá cảnh quan thiên nhiên và tìm hiểu nét đặc trưng của điểm đến.'
        || CHAR(10) || '18:30 - Nghỉ ngơi tại nơi lưu trú hoặc điểm dừng chân đã bố trí.'
    WHEN 1 THEN '07:00 - Tập trung, kiểm tra hành lý và bắt đầu lịch trình trong ngày.'
        || CHAR(10) || '08:30 - ' || TRIM(TRAILING '.' FROM TRIM(mo_ta))
        || CHAR(10) || '12:00 - Dùng bữa trưa theo thực đơn của chương trình.'
        || CHAR(10) || '14:30 - Trải nghiệm cảnh quan và văn hóa địa phương theo hành trình.'
        || CHAR(10) || '19:00 - Về nơi lưu trú, nghỉ ngơi và chuẩn bị cho ngày tiếp theo.'
    ELSE '06:45 - Dùng bữa sáng và nghe hướng dẫn lịch trình trong ngày.'
        || CHAR(10) || '09:00 - ' || TRIM(TRAILING '.' FROM TRIM(mo_ta))
        || CHAR(10) || '11:45 - Thưởng thức bữa trưa với món ăn đặc trưng địa phương.'
        || CHAR(10) || '15:00 - Tham quan bổ sung và tìm hiểu cảnh quan thiên nhiên tại điểm đến.'
        || CHAR(10) || '18:00 - Nhận phòng hoặc nghỉ ngơi tại điểm dừng chân theo chương trình.'
    END,
    mo_ta = NULL;

-- Mỗi ngày bắt buộc có nhiều mốc giờ hoạt động đúng định dạng timeline.;

-- Ghi chú cấp đơn chỉ lưu các yêu cầu vận hành chung, không gắn thông tin riêng của hành khách.
UPDATE don_dat_tours
SET ghi_chu = CASE MOD(CRC32(ma_dat_tour), 5)
    WHEN 0 THEN NULL
    WHEN 1 THEN 'Yêu cầu in hóa đơn điện tử sau khi hoàn tất thanh toán.'
    WHEN 2 THEN 'Mang theo hành lý lớn, cần hỗ trợ sắp xếp khoang chứa đồ.'
    WHEN 3 THEN 'Hỗ trợ giờ tập trung trễ 15 phút so với lịch đón ban đầu.'
    ELSE 'Yêu cầu nhắc lại điểm tập trung và số điện thoại điều phối trước ngày khởi hành.'
END;

-- Chuẩn hoá mô tả chuyên môn của hướng dẫn viên theo khả năng phục vụ tour.
UPDATE nang_luc_nhan_viens
SET chuyen_mon = CASE ma_nhan_vien
    WHEN 'NV_HDV01' THEN 'Chuyên thuyết minh lịch sử - văn hóa: Có khả năng kể chuyện hấp dẫn về di tích, lịch sử, phong tục và đời sống địa phương.'
    WHEN 'NV_HDV02' THEN 'Chuyên chăm sóc khách gia đình: Biết cách hỗ trợ đoàn có trẻ em, người lớn tuổi và khách cần sự quan tâm đặc biệt.'
    WHEN 'NV_HDV03' THEN 'Chuyên thuyết minh lịch sử - văn hóa: Am hiểu di sản miền Trung, văn hóa Chăm và đời sống địa phương.'
    WHEN 'NV_HDV04' THEN 'Chuyên chăm sóc khách gia đình: Biết cách hỗ trợ đoàn nghỉ dưỡng có trẻ em, người lớn tuổi và khách cần sự quan tâm đặc biệt.'
    WHEN 'NV_HDV05' THEN 'Chuyên thuyết minh lịch sử - văn hóa: Am hiểu kiến trúc, di tích và phục vụ đoàn trải nghiệm cao cấp.'
    WHEN 'NV_HDV06' THEN 'Chuyên tour học sinh - sinh viên: Biết cách truyền đạt dễ hiểu, tổ chức hoạt động tập thể và quản lý đoàn trẻ.'
    WHEN 'NV_HDV07' THEN 'Chuyên dẫn tour mạo hiểm: Có kinh nghiệm hỗ trợ khách trong các hoạt động như leo núi, trekking, chèo thuyền và cắm trại.'
    WHEN 'NV_HDV08' THEN 'Chuyên chăm sóc đoàn doanh nghiệp: Thành thạo tổ chức lịch trình sự kiện, hội họp và yêu cầu dịch vụ theo đoàn.'
    WHEN 'NV_HDV09' THEN 'Chuyên dẫn tour sinh thái: Am hiểu thiên nhiên, rừng, biển, hệ sinh thái và các hoạt động bảo vệ môi trường.'
    WHEN 'NV_HDV10' THEN 'Chuyên dẫn tour sinh thái: Am hiểu thiên nhiên, sông nước, đời sống địa phương và bảo vệ môi trường.'
    WHEN 'NV_HDV11' THEN 'Chuyên dẫn tour biển đảo và di sản: Có kinh nghiệm hỗ trợ hoạt động biển, tham quan văn hóa và chăm sóc đoàn gia đình.'
    WHEN 'NV_HDV12' THEN 'Chuyên dẫn tour sinh thái sông nước: Am hiểu rừng ngập mặn, chợ nổi, đường thủy và du lịch cộng đồng bền vững.'
    ELSE chuyen_mon
END;

-- Bảo đảm mọi tour mẫu có lịch trình đủ từ ngày 1 đến đúng thời lượng đã công bố.;

-- Kiểm tra một khách hàng không xuất hiện ở hai đơn thuộc cùng một tour thực tế.;

-- ============================================================
-- BỔ SUNG: DỮ LIỆU TOUR QUÁ KHỨ - ĐẢM BẢO >= 2 HÀNH KHÁCH
-- ============================================================

-- ----------------------------------------------------------------
-- A. TOUR QUÁ KHỨ CỦA HDV10 (NV_HDV10 - hdv10) - CHƯA CÓ TOUR LỊCH SỬ
-- Thêm 2 tour đã kết thúc để HDV10 có lịch sử dẫn đoàn
-- ----------------------------------------------------------------

-- A1. Tour Ninh Bình đã kết thúc (HDV10 dẫn 3 khách)
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_NINHBINH_KT_HDV10', 'TM_NINHBINH', DATE(NOW()) - INTERVAL 25 DAY, 3000000, 22, 8, 19, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_NINHBINH_KT_HDV10', 'DVT_DINNER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_NINHBINH_KT_HDV10', 'HDX_BOTTLE');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_NB_KT_HDV10', 'TTT_NINHBINH_KT_HDV10', 'NV_HDV10', NOW() - INTERVAL 40 DAY, 'DA_DONG_Y', NOW() - INTERVAL 39 DAY);

-- Đơn 1: KH_11 + người đồng hành
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_NB_KT_HDV10_01', 'TTT_NINHBINH_KT_HDV10', 'KH_11', NOW() - INTERVAL 35 DAY, 6280000, 'HOAN_THANH', NOW() - INTERVAL 33 DAY, 'Cặp đôi tham quan Ninh Bình.', 'HDX_BOTTLE:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_NB_KT_HDV10_01', 'DDT_NB_KT_HDV10_01', 'Lê Thị Hoa', '079299000601', '0933000601', '1993-04-10', 'NỮ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_NB_KT_HDV10_01_KH', 'DDT_NB_KT_HDV10_01', 'KH_11', NULL, 'NGUOI_DAT', 3000000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_NB_KT_HDV10_01_NDH', 'DDT_NB_KT_HDV10_01', NULL, 'NDH_NB_KT_HDV10_01', 'NGUOI_DONG_HANH', 3000000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_NB_KT_HDV10_01_DIN', 'DDT_NB_KT_HDV10_01', 'DVT_DINNER', 2, 280000, 560000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_NB_KT_HDV10_01_PAY', 'DDT_NB_KT_HDV10_01', 'THANH_TOAN', 'CHUYEN_KHOAN', 6280000, 'BANK-NB-HDV10-01', 'THANH_CONG', NOW() - INTERVAL 34 DAY);

-- Đơn 2: KH_12 (khách lẻ)
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_NB_KT_HDV10_02', 'TTT_NINHBINH_KT_HDV10', 'KH_12', NOW() - INTERVAL 33 DAY, 3280000, 'HOAN_THANH', NOW() - INTERVAL 31 DAY, 'Khách lẻ thăm Tam Cốc.');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_NB_KT_HDV10_02_KH', 'DDT_NB_KT_HDV10_02', 'KH_12', NULL, 'NGUOI_DAT', 3000000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_NB_KT_HDV10_02_DIN', 'DDT_NB_KT_HDV10_02', 'DVT_DINNER', 1, 280000, 280000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_NB_KT_HDV10_02_PAY', 'DDT_NB_KT_HDV10_02', 'THANH_TOAN', 'THE_NOI_DIA', 3280000, 'BANK-NB-HDV10-02', 'THANH_CONG', NOW() - INTERVAL 32 DAY);

-- Lịch sử tour và điểm danh
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_NB_HDV10_KH11', 'KH_11', 'TTT_NINHBINH_KT_HDV10', 'CTDT_NB_KT_HDV10_01_KH', DATE(NOW()) - INTERVAL 25 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_NB_HDV10_KH12', 'KH_12', 'TTT_NINHBINH_KT_HDV10', 'CTDT_NB_KT_HDV10_02_KH', DATE(NOW()) - INTERVAL 25 DAY);

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_NB_HDV10_KH11', 'TTT_NINHBINH_KT_HDV10', 'KH_11', NULL, 'NGUOI_DAT', 'NV_HDV10', NOW() - INTERVAL 25 DAY, 'Cố đô Hoa Lư', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_NB_HDV10_NDH01', 'TTT_NINHBINH_KT_HDV10', NULL, 'NDH_NB_KT_HDV10_01', 'NGUOI_DONG_HANH', 'NV_HDV10', NOW() - INTERVAL 25 DAY, 'Cố đô Hoa Lư', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_NB_HDV10_KH12', 'TTT_NINHBINH_KT_HDV10', 'KH_12', NULL, 'NGUOI_DAT', 'NV_HDV10', NOW() - INTERVAL 25 DAY, 'Cố đô Hoa Lư', 'DA_DIEM_DANH');

-- Chi phí HDV10 cho tour Ninh Bình
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_NB_HDV10_WATER', 'TTT_NINHBINH_KT_HDV10', 'NV_HDV10', 'Nước uống cho đoàn', 180000, 'https://seed.local/hoa-don/nb-water.jpg', 'DA_DUYET', NOW() - INTERVAL 25 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_NB_HDV10_BOAT', 'TTT_NINHBINH_KT_HDV10', 'NV_HDV10', 'Phụ thu thuyền tay Tam Cốc', 360000, 'https://seed.local/hoa-don/nb-boat.jpg', 'DA_DUYET', NOW() - INTERVAL 24 DAY);

-- Sự cố
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_NB_HDV10_RAIN', 'TTT_NINHBINH_KT_HDV10', 'NV_HDV10', 'Mưa nhỏ khi tham quan Tràng An.', 'Chuẩn bị áo mưa, điều chỉnh lịch trình vào điểm trú ẩn.', 'THAP', 'THOI_TIET', NOW() - INTERVAL 25 DAY);

-- Đánh giá
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_NB_HDV10_KH11', 'TTT_NINHBINH_KT_HDV10', 'KH_11', 5, 'HDV nhiệt tình, cảnh thiên nhiên Ninh Bình rất đẹp.', NOW() - INTERVAL 22 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_NB_HDV10_KH12', 'TTT_NINHBINH_KT_HDV10', 'KH_12', 4, 'Tour trọn gói tốt, chỉ tiếc trời hơi âm u.', NOW() - INTERVAL 21 DAY);

-- Quyết toán cho tour Ninh Bình của HDV10
INSERT INTO quyet_toans (ma_quyet_toan, ma_tour_thuc_te, tong_doanh_thu, tong_chi_phi, gia_cam_ket, loi_nhuan, ma_nhan_vien, ngay_quyet_toan, trang_thai, ghi_chu)
VALUES ('QT_NB_HDV10', 'TTT_NINHBINH_KT_HDV10', 9560000, 540000, NULL, 9020000, 'NV_KT01', NOW() - INTERVAL 20 DAY, 'DA_QUYET_TOAN', 'Quyết toán tour Ninh Bình HDV10 hoàn tất.');

UPDATE tour_thuc_tes SET trang_thai = 'DA_QUYET_TOAN' WHERE ma_tour_thuc_te = 'TTT_NINHBINH_KT_HDV10';

-- ----------------------------------------------------------------
-- A2. Tour Hà Giang đã kết thúc (HDV10 dẫn 4 khách) - 2 tháng trước
-- ----------------------------------------------------------------
INSERT INTO tour_thuc_tes (ma_tour_thuc_te, ma_tour_mau, ngay_khoi_hanh, gia_hien_hanh, so_khach_toi_da, so_khach_toi_thieu, cho_con_lai, trang_thai)
VALUES ('TTT_HAGIANG_KT_HDV10', 'TM_HAGIANG', DATE(NOW()) - INTERVAL 65 DAY, 6300000, 18, 8, 14, 'MO_BAN');

INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HAGIANG_KT_HDV10', 'DVT_INSURANCE');
INSERT INTO dich_vu_tour_thuc_tes (ma_tour_thuc_te, ma_dich_vu_them) VALUES ('TTT_HAGIANG_KT_HDV10', 'DVT_DINNER');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HAGIANG_KT_HDV10', 'HDX_CLEANUP');
INSERT INTO hdx_tour_thuc_tes (ma_tour_thuc_te, ma_hanh_dong_xanh) VALUES ('TTT_HAGIANG_KT_HDV10', 'HDX_LOCAL');

INSERT INTO phan_cong_tours (ma_phan_cong_tour, ma_tour_thuc_te, ma_nhan_vien, ngay_phan_cong, trang_thai_chap_nhan, ngay_phan_hoi)
VALUES ('PC_HG_KT_HDV10', 'TTT_HAGIANG_KT_HDV10', 'NV_HDV10', NOW() - INTERVAL 80 DAY, 'DA_DONG_Y', NOW() - INTERVAL 79 DAY);

-- Đơn 1: KH_13 + 1 NDH
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HG_KT_HDV10_01', 'TTT_HAGIANG_KT_HDV10', 'KH_13', NOW() - INTERVAL 75 DAY, 13100000, 'HOAN_THANH', NOW() - INTERVAL 73 DAY, 'Hai người bạn khám phá Hà Giang.', 'HDX_LOCAL:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HG_KT_HDV10_01', 'DDT_HG_KT_HDV10_01', 'Trần Văn Đức', '079299000701', '0944000701', '1991-07-07', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HG_KT_HDV10_01_KH', 'DDT_HG_KT_HDV10_01', 'KH_13', NULL, 'NGUOI_DAT', 6300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HG_KT_HDV10_01_NDH', 'DDT_HG_KT_HDV10_01', NULL, 'NDH_HG_KT_HDV10_01', 'NGUOI_DONG_HANH', 6300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HG_KT_HDV10_01_INS', 'DDT_HG_KT_HDV10_01', 'DVT_INSURANCE', 2, 120000, 240000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HG_KT_HDV10_01_DIN', 'DDT_HG_KT_HDV10_01', 'DVT_DINNER', 2, 280000, 560000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HG_KT_HDV10_01_PAY', 'DDT_HG_KT_HDV10_01', 'THANH_TOAN', 'THE_QUOC_TE', 13100000, 'BANK-HG-HDV10-01', 'THANH_CONG', NOW() - INTERVAL 74 DAY);

-- Đơn 2: KH_14 + 1 NDH
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu, hanh_dong_xanh)
VALUES ('DDT_HG_KT_HDV10_02', 'TTT_HAGIANG_KT_HDV10', 'KH_14', NOW() - INTERVAL 73 DAY, 12760000, 'HOAN_THANH', NOW() - INTERVAL 71 DAY, 'Cặp đôi trẻ khám phá cao nguyên đá.', 'HDX_CLEANUP:1');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HG_KT_HDV10_02', 'DDT_HG_KT_HDV10_02', 'Phạm Thu Hằng', '079299000702', '0944000702', '1995-11-30', 'NỮ', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HG_KT_HDV10_02_KH', 'DDT_HG_KT_HDV10_02', 'KH_14', NULL, 'NGUOI_DAT', 6300000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HG_KT_HDV10_02_NDH', 'DDT_HG_KT_HDV10_02', NULL, 'NDH_HG_KT_HDV10_02', 'NGUOI_DONG_HANH', 6300000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HG_KT_HDV10_02_INS', 'DDT_HG_KT_HDV10_02', 'DVT_INSURANCE', 2, 120000, 240000);
INSERT INTO chi_tiet_dich_vus (ma_chi_tiet_dich_vu, ma_dat_tour, ma_dich_vu_them, so_luong, don_gia, thanh_tien)
VALUES ('CTDV_HG_KT_HDV10_02_DIN', 'DDT_HG_KT_HDV10_02', 'DVT_DINNER', 1, 280000, 280000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HG_KT_HDV10_02_PAY', 'DDT_HG_KT_HDV10_02', 'THANH_TOAN', 'VI_DIEN_TU', 12760000, 'BANK-HG-HDV10-02', 'THANH_CONG', NOW() - INTERVAL 72 DAY);

-- Lịch sử, điểm danh
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HG_HDV10_KH13', 'KH_13', 'TTT_HAGIANG_KT_HDV10', 'CTDT_HG_KT_HDV10_01_KH', DATE(NOW()) - INTERVAL 65 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HG_HDV10_KH14', 'KH_14', 'TTT_HAGIANG_KT_HDV10', 'CTDT_HG_KT_HDV10_02_KH', DATE(NOW()) - INTERVAL 65 DAY);

INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HG_HDV10_KH13', 'TTT_HAGIANG_KT_HDV10', 'KH_13', NULL, 'NGUOI_DAT', 'NV_HDV10', NOW() - INTERVAL 65 DAY, 'Cột cờ Lũng Cú', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HG_HDV10_NDH01', 'TTT_HAGIANG_KT_HDV10', NULL, 'NDH_HG_KT_HDV10_01', 'NGUOI_DONG_HANH', 'NV_HDV10', NOW() - INTERVAL 65 DAY, 'Cột cờ Lũng Cú', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HG_HDV10_KH14', 'TTT_HAGIANG_KT_HDV10', 'KH_14', NULL, 'NGUOI_DAT', 'NV_HDV10', NOW() - INTERVAL 65 DAY, 'Cột cờ Lũng Cú', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HG_HDV10_NDH02', 'TTT_HAGIANG_KT_HDV10', NULL, 'NDH_HG_KT_HDV10_02', 'NGUOI_DONG_HANH', 'NV_HDV10', NOW() - INTERVAL 65 DAY, 'Cột cờ Lũng Cú', 'DA_DIEM_DANH');

-- Hành động xanh
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_HG_KT_HDV10_LOCAL', 'TTT_HAGIANG_KT_HDV10', 'KH_13', 'HDX_LOCAL', 'NV_HDV10', NOW() - INTERVAL 64 DAY, 'Khách mua quà thổ cẩm địa phương, không dùng túi nhựa.');
INSERT INTO hanh_dongs (ma_ghi_nhan_hanh_dong, ma_tour_thuc_te, ma_khach_hang, ma_hanh_dong_xanh, ma_nhan_vien_xac_minh, thoi_gian, minh_chung)
VALUES ('HD_HG_KT_HDV10_CLEANUP', 'TTT_HAGIANG_KT_HDV10', 'KH_14', 'HDX_CLEANUP', 'NV_HDV10', NOW() - INTERVAL 63 DAY, 'Cả đoàn tham gia dọn rác tại Mã Pì Lèng.');

-- Chi phí HDV10
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HG_HDV10_WATER', 'TTT_HAGIANG_KT_HDV10', 'NV_HDV10', 'Nước uống và đồ ăn nhẹ dọc đường', 450000, 'https://seed.local/hoa-don/hg-water.jpg', 'DA_DUYET', NOW() - INTERVAL 64 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HG_HDV10_PORTER', 'TTT_HAGIANG_KT_HDV10', 'NV_HDV10', 'Phí hướng dẫn viên địa phương (porter)', 800000, 'https://seed.local/hoa-don/hg-porter.jpg', 'DA_DUYET', NOW() - INTERVAL 63 DAY);

-- Sự cố
INSERT INTO nhat_ky_su_cos (ma_nhat_ky_su_co, ma_tour_thuc_te, ma_nhan_vien_bao_cao, mo_ta, giai_phap, muc_do, loai_su_co, thoi_gian_bao_cao)
VALUES ('SC_HG_HDV10_TIRE', 'TTT_HAGIANG_KT_HDV10', 'NV_HDV10', 'Xe khách bị nổ lốp tại đèo Mã Pì Lèng.', 'Liên hệ đơn vị vận chuyển sửa chữa, hoàn thành sau 40 phút không ảnh hưởng lịch trình.', 'THAP', 'PHUONG_TIEN', NOW() - INTERVAL 63 DAY);

-- Đánh giá
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HG_HDV10_KH13', 'TTT_HAGIANG_KT_HDV10', 'KH_13', 5, 'Hành trình tuyệt vời! Đường đèo hùng vĩ, HDV chuyên nghiệp.', NOW() - INTERVAL 60 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HG_HDV10_KH14', 'TTT_HAGIANG_KT_HDV10', 'KH_14', 5, 'Cảnh đẹp nhất mình từng thấy. Sẽ đi lại lần nữa.', NOW() - INTERVAL 59 DAY);

UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_HAGIANG_KT_HDV10';

-- ----------------------------------------------------------------
-- B. BỔ SUNG HÀNH KHÁCH THỨ 2 CHO CÁC TOUR QUÁ KHỨ CHỈ CÓ 1 KHÁCH
-- TTT_HOIAN_OLD (NV_HDV04), TTT_MUINE_OLD (NV_HDV05), TTT_HALONG_OLD (NV_HDV06)
-- ----------------------------------------------------------------

-- B1. Thêm khách thứ 2 vào TTT_HOIAN_OLD (hiện chỉ có KH_06)
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_HOIAN_OLD_KH2', 'TTT_HOIAN_OLD', 'KH_15', NOW() - INTERVAL 28 DAY, 5980000, 'DA_XAC_NHAN', NOW() - INTERVAL 25 DAY, 'Khách lẻ thăm Hội An cùng đoàn.');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HOIAN_OLD_KH2', 'DDT_HOIAN_OLD_KH2', 'KH_15', NULL, 'NGUOI_DAT', 5980000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HOIAN_OLD_KH2', 'DDT_HOIAN_OLD_KH2', 'THANH_TOAN', 'VI_DIEN_TU', 5980000, 'BANK-HOIAN-02', 'THANH_CONG', NOW() - INTERVAL 27 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HOIAN_OLD_KH15', 'KH_15', 'TTT_HOIAN_OLD', 'CTDT_HOIAN_OLD_KH2', DATE(NOW()) - INTERVAL 20 DAY);
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HOIAN_OLD_KH15', 'TTT_HOIAN_OLD', 'KH_15', NULL, 'NGUOI_DAT', 'NV_HDV04', NOW() - INTERVAL 20 DAY, 'Phố cổ Hội An', 'DA_DIEM_DANH');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HOIAN_OLD_KH15', 'TTT_HOIAN_OLD', 'KH_15', 5, 'Phố đèn lồng về đêm rất lãng mạn.', NOW() - INTERVAL 15 DAY);

-- B2. Thêm khách thứ 2 vào TTT_MUINE_OLD (hiện chỉ có KH_07)
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_MUINE_OLD_KH2', 'TTT_MUINE_OLD', 'KH_16', NOW() - INTERVAL 28 DAY, 5910000, 'DA_XAC_NHAN', NOW() - INTERVAL 25 DAY, 'Khách ghép đoàn Mũi Né.');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_MUINE_OLD_KH2', 'DDT_MUINE_OLD_KH2', 'KH_16', NULL, 'NGUOI_DAT', 5910000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_MUINE_OLD_KH2', 'DDT_MUINE_OLD_KH2', 'THANH_TOAN', 'THE_NOI_DIA', 5910000, 'BANK-MUINE-02', 'THANH_CONG', NOW() - INTERVAL 27 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_MUINE_OLD_KH16', 'KH_16', 'TTT_MUINE_OLD', 'CTDT_MUINE_OLD_KH2', DATE(NOW()) - INTERVAL 20 DAY);
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_MUINE_OLD_KH16', 'TTT_MUINE_OLD', 'KH_16', NULL, 'NGUOI_DAT', 'NV_HDV05', NOW() - INTERVAL 20 DAY, 'Đồi cát Mũi Né', 'DA_DIEM_DANH');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_MUINE_OLD_KH16', 'TTT_MUINE_OLD', 'KH_16', 4, 'Bình minh đồi cát rất đẹp, HDV thân thiện.', NOW() - INTERVAL 14 DAY);

-- B3. Thêm khách thứ 2 vào TTT_HALONG_OLD (hiện chỉ có KH_08)
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_HALONG_OLD_KH2', 'TTT_HALONG_OLD', 'KH_17', NOW() - INTERVAL 27 DAY, 6790000, 'DA_XAC_NHAN', NOW() - INTERVAL 24 DAY, 'Khách ghép đoàn Hạ Long.');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HALONG_OLD_KH2', 'DDT_HALONG_OLD_KH2', 'KH_17', NULL, 'NGUOI_DAT', 6790000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HALONG_OLD_KH2', 'DDT_HALONG_OLD_KH2', 'THANH_TOAN', 'CHUYEN_KHOAN', 6790000, 'BANK-HALONG-02', 'THANH_CONG', NOW() - INTERVAL 26 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HALONG_OLD_KH17', 'KH_17', 'TTT_HALONG_OLD', 'CTDT_HALONG_OLD_KH2', DATE(NOW()) - INTERVAL 20 DAY);
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HALONG_OLD_KH17', 'TTT_HALONG_OLD', 'KH_17', NULL, 'NGUOI_DAT', 'NV_HDV06', NOW() - INTERVAL 20 DAY, 'Vịnh Hạ Long', 'DA_DIEM_DANH');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HALONG_OLD_KH17', 'TTT_HALONG_OLD', 'KH_17', 5, 'Du thuyền đẳng cấp, phong cảnh tuyệt vời không thể tả.', NOW() - INTERVAL 13 DAY);

-- ----------------------------------------------------------------
-- C. BỔ SUNG HÀNH KHÁCH CHO CÁC TOUR KET_THUC ĐANG THIẾU (0 KHÁCH)
-- TTT_HUE_QT_02 (NV_HDV09), TTT_CANTHO_KT_02 (NV_HDV07)
-- ----------------------------------------------------------------

-- C1. TTT_HUE_QT_02 - HDV09 - thêm 3 khách
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_HUE_QT_02_A', 'TTT_HUE_QT_02', 'KH_01', NOW() - INTERVAL 55 DAY, 4400000, 'HOAN_THANH', NOW() - INTERVAL 53 DAY, 'Khách tham quan cố đô Huế.');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUE_QT_02_A_KH', 'DDT_HUE_QT_02_A', 'KH_01', NULL, 'NGUOI_DAT', 4400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HUE_QT_02_A', 'DDT_HUE_QT_02_A', 'THANH_TOAN', 'CHUYEN_KHOAN', 4400000, 'BANK-HUE02-A', 'THANH_CONG', NOW() - INTERVAL 54 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_HUE_QT_02_B', 'TTT_HUE_QT_02', 'KH_02', NOW() - INTERVAL 54 DAY, 9080000, 'HOAN_THANH', NOW() - INTERVAL 52 DAY, 'Cặp đôi đi Huế dịp lễ.');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_HUE_QT_02_B01', 'DDT_HUE_QT_02_B', 'Trịnh Văn Sơn', '079299000801', '0955000801', '1987-08-15', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUE_QT_02_B_KH', 'DDT_HUE_QT_02_B', 'KH_02', NULL, 'NGUOI_DAT', 4400000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_HUE_QT_02_B_NDH', 'DDT_HUE_QT_02_B', NULL, 'NDH_HUE_QT_02_B01', 'NGUOI_DONG_HANH', 4400000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_HUE_QT_02_B', 'DDT_HUE_QT_02_B', 'THANH_TOAN', 'THE_QUOC_TE', 9080000, 'BANK-HUE02-B', 'THANH_CONG', NOW() - INTERVAL 53 DAY);

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HUE_QT_02_KH01', 'KH_01', 'TTT_HUE_QT_02', 'CTDT_HUE_QT_02_A_KH', DATE(NOW()) - INTERVAL 45 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_HUE_QT_02_KH02', 'KH_02', 'TTT_HUE_QT_02', 'CTDT_HUE_QT_02_B_KH', DATE(NOW()) - INTERVAL 45 DAY);
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HUE_QT_02_KH01', 'TTT_HUE_QT_02', 'KH_01', NULL, 'NGUOI_DAT', 'NV_HDV09', NOW() - INTERVAL 45 DAY, 'Đại Nội Huế', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HUE_QT_02_KH02', 'TTT_HUE_QT_02', 'KH_02', NULL, 'NGUOI_DAT', 'NV_HDV09', NOW() - INTERVAL 45 DAY, 'Đại Nội Huế', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_HUE_QT_02_NDH01', 'TTT_HUE_QT_02', NULL, 'NDH_HUE_QT_02_B01', 'NGUOI_DONG_HANH', 'NV_HDV09', NOW() - INTERVAL 45 DAY, 'Đại Nội Huế', 'DA_DIEM_DANH');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HUE_QT_02_KH01', 'TTT_HUE_QT_02', 'KH_01', 5, 'Cố đô Huế lịch sử và ẩm thực tuyệt vời.', NOW() - INTERVAL 40 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_HUE_QT_02_KH02', 'TTT_HUE_QT_02', 'KH_02', 4, 'Rất hài lòng, chỉ tiếc thời gian tự do hơi ít.', NOW() - INTERVAL 39 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_HUE_QT_02_INCENSE', 'TTT_HUE_QT_02', 'NV_HDV09', 'Phụ thu thăm làng hương Thủy Xuân', 240000, 'https://seed.local/hoa-don/hue-incense.jpg', 'DA_DUYET', NOW() - INTERVAL 44 DAY);
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_HUE_QT_02';

-- C2. TTT_CANTHO_KT_02 - HDV07 - thêm 3 khách
INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_CT_KT_02_A', 'TTT_CANTHO_KT_02', 'KH_03', NOW() - INTERVAL 20 DAY, 3800000, 'HOAN_THANH', NOW() - INTERVAL 18 DAY, 'Khách trải nghiệm sông nước miền Tây.');
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CT_KT_02_A_KH', 'DDT_CT_KT_02_A', 'KH_03', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CT_KT_02_A', 'DDT_CT_KT_02_A', 'THANH_TOAN', 'VI_DIEN_TU', 3800000, 'BANK-CT02-A', 'THANH_CONG', NOW() - INTERVAL 19 DAY);

INSERT INTO don_dat_tours (ma_dat_tour, ma_tour_thuc_te, ma_khach_hang, ngay_dat, tong_tien, trang_thai, thoi_gian_het_han, ghi_chu)
VALUES ('DDT_CT_KT_02_B', 'TTT_CANTHO_KT_02', 'KH_04', NOW() - INTERVAL 18 DAY, 7600000, 'HOAN_THANH', NOW() - INTERVAL 16 DAY, 'Cặp đôi chèo thuyền chợ nổi.');
INSERT INTO ds_nguoi_dong_hanhs (ma_nguoi_dong_hanh, ma_dat_tour, ho_ten, cccd, so_dien_thoai, ngay_sinh, gioi_tinh, ghi_chu)
VALUES ('NDH_CT_KT_02_B01', 'DDT_CT_KT_02_B', 'Lê Minh Nhật', '079299000901', '0966000901', '1994-02-20', 'NAM', NULL);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CT_KT_02_B_KH', 'DDT_CT_KT_02_B', 'KH_04', NULL, 'NGUOI_DAT', 3800000);
INSERT INTO chi_tiet_dat_tours (ma_chi_tiet_dat, ma_dat_tour, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, gia_tai_thoi_diem_dat)
VALUES ('CTDT_CT_KT_02_B_NDH', 'DDT_CT_KT_02_B', NULL, 'NDH_CT_KT_02_B01', 'NGUOI_DONG_HANH', 3800000);
INSERT INTO giao_diches (ma_giao_dich, ma_dat_tour, loai_giao_dich, phuong_thuc, so_tien, ma_gdnh, trang_thai, ngay_thanh_toan)
VALUES ('GD_CT_KT_02_B', 'DDT_CT_KT_02_B', 'THANH_TOAN', 'THE_NOI_DIA', 7600000, 'BANK-CT02-B', 'THANH_CONG', NOW() - INTERVAL 17 DAY);

INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CT_KT_02_KH03', 'KH_03', 'TTT_CANTHO_KT_02', 'CTDT_CT_KT_02_A_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO lich_su_tours (ma_lich_su_tour, ma_khach_hang, ma_tour_thuc_te, ma_chi_tiet_dat, ngay_tham_gia)
VALUES ('LST_CT_KT_02_KH04', 'KH_04', 'TTT_CANTHO_KT_02', 'CTDT_CT_KT_02_B_KH', DATE(NOW()) - INTERVAL 14 DAY);
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_CT_KT_02_KH03', 'TTT_CANTHO_KT_02', 'KH_03', NULL, 'NGUOI_DAT', 'NV_HDV07', NOW() - INTERVAL 14 DAY, 'Chợ nổi Cái Răng', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_CT_KT_02_KH04', 'TTT_CANTHO_KT_02', 'KH_04', NULL, 'NGUOI_DAT', 'NV_HDV07', NOW() - INTERVAL 14 DAY, 'Chợ nổi Cái Răng', 'DA_DIEM_DANH');
INSERT INTO diem_danhs (ma_diem_danh, ma_tour_thuc_te, ma_khach_hang, ma_nguoi_dong_hanh, loai_khach, ma_nhan_vien, thoi_gian, dia_diem, trang_thai)
VALUES ('DD_CT_KT_02_NDH01', 'TTT_CANTHO_KT_02', NULL, 'NDH_CT_KT_02_B01', 'NGUOI_DONG_HANH', 'NV_HDV07', NOW() - INTERVAL 14 DAY, 'Chợ nổi Cái Răng', 'DA_DIEM_DANH');
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CT_KT_02_KH03', 'TTT_CANTHO_KT_02', 'KH_03', 5, 'Chợ nổi Cái Răng sáng sớm thật đặc biệt!', NOW() - INTERVAL 10 DAY);
INSERT INTO danh_gia_khs (ma_danh_gia_khach_hang, ma_tour_thuc_te, ma_khach_hang, so_sao, nhan_xet, ngay_danh_gia)
VALUES ('DG_CT_KT_02_KH04', 'TTT_CANTHO_KT_02', 'KH_04', 4, 'Ẩm thực miền Tây tuyệt hảo, thuyền chèo yên bình.', NOW() - INTERVAL 9 DAY);
INSERT INTO chi_phi_thuc_tes (ma_chi_phi_thuc_te, ma_tour_thuc_te, ma_nhan_vien, danh_muc, thanh_tien, hoa_don_anh, trang_thai_duyet, ngay_khai)
VALUES ('CP_CT_KT_02_BOAT', 'TTT_CANTHO_KT_02', 'NV_HDV07', 'Phụ thu thuyền đặc sản trên sông', 320000, 'https://seed.local/hoa-don/ct-boat.jpg', 'DA_DUYET', NOW() - INTERVAL 13 DAY);
UPDATE tour_thuc_tes SET trang_thai = 'KET_THUC' WHERE ma_tour_thuc_te = 'TTT_CANTHO_KT_02';

-- ----------------------------------------------------------------
-- TÍNH LẠI SỐ CHỖ CÒN LẠI VÀ ĐÁNH GIÁ TOUR MẪU
-- ----------------------------------------------------------------
-- Tính lại số chỗ còn lại sau toàn bộ cụm dữ liệu bổ sung.
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

-- ==========================================
-- TỰ ĐỘNG BỔ SUNG DỮ LIỆU HÀNH KHÁCH 
-- ==========================================

-- ==========================================
-- CẬP NHẬT CHỖ CÒN LẠI DỰA TRÊN NGƯỜI ĐỒNG HÀNH
-- ==========================================
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_26_CANTHO_DG';
UPDATE tour_thuc_tes SET cho_con_lai = 30 WHERE ma_tour_thuc_te = 'TTT_26_CANTHO_OCT';
UPDATE tour_thuc_tes SET cho_con_lai = 34 WHERE ma_tour_thuc_te = 'TTT_26_DANANG_DEC';
UPDATE tour_thuc_tes SET cho_con_lai = 32 WHERE ma_tour_thuc_te = 'TTT_26_DANANG_JUL';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_26_HALONG_DG';
UPDATE tour_thuc_tes SET cho_con_lai = 30 WHERE ma_tour_thuc_te = 'TTT_26_HALONG_SEP';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_26_HOIAN_DG';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_26_HOIAN_SEP';
UPDATE tour_thuc_tes SET cho_con_lai = 26 WHERE ma_tour_thuc_te = 'TTT_26_HUE_AUG';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_26_MUINE_DG';
UPDATE tour_thuc_tes SET cho_con_lai = 30 WHERE ma_tour_thuc_te = 'TTT_26_MUINE_NOV';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_26_PHUQUOC_AUG';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_26_SAPA_JUL';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_26_SAPA_NOV';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_BSLK_ACTIVE_QN';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_BSLK_CANCEL_HG';
UPDATE tour_thuc_tes SET cho_con_lai = 20 WHERE ma_tour_thuc_te = 'TTT_BSLK_DONE_CT';
UPDATE tour_thuc_tes SET cho_con_lai = 17 WHERE ma_tour_thuc_te = 'TTT_BSLK_OPEN_FAM';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_BSLK_SETTLE_HA';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_BUONMATHUOT';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_BUONMATHUOT_DDR_02';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_BUONMATHUOT_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 26 WHERE ma_tour_thuc_te = 'TTT_CANTHO';
UPDATE tour_thuc_tes SET cho_con_lai = 12 WHERE ma_tour_thuc_te = 'TTT_CANTHO_KT_02';
UPDATE tour_thuc_tes SET cho_con_lai = 29 WHERE ma_tour_thuc_te = 'TTT_CANTHO_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 20 WHERE ma_tour_thuc_te = 'TTT_CHOKH_BABE';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_CHOKH_CAMAU';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_CKH';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_CONDAO';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_CONDAO_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_DALAT_MB_02';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_DALAT_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_DANANG_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 31 WHERE ma_tour_thuc_te = 'TTT_DANANG_OPEN_04';
UPDATE tour_thuc_tes SET cho_con_lai = 20 WHERE ma_tour_thuc_te = 'TTT_DANANG_REVIEW_03';
UPDATE tour_thuc_tes SET cho_con_lai = 14 WHERE ma_tour_thuc_te = 'TTT_DDR';
UPDATE tour_thuc_tes SET cho_con_lai = 26 WHERE ma_tour_thuc_te = 'TTT_H11_HUE_SKH';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_H11_QUYNHON_LS';
UPDATE tour_thuc_tes SET cho_con_lai = 24 WHERE ma_tour_thuc_te = 'TTT_H12_CANTHO_LS';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_H12_CANTHO_SKH';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_HAGIANG_HUY_02';
UPDATE tour_thuc_tes SET cho_con_lai = 14 WHERE ma_tour_thuc_te = 'TTT_HAGIANG_KT_HDV10';
UPDATE tour_thuc_tes SET cho_con_lai = 19 WHERE ma_tour_thuc_te = 'TTT_HAGIANG_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 19 WHERE ma_tour_thuc_te = 'TTT_HALONG';
UPDATE tour_thuc_tes SET cho_con_lai = 24 WHERE ma_tour_thuc_te = 'TTT_HALONG_OLD';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_HALONG_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 17 WHERE ma_tour_thuc_te = 'TTT_HOIAN';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_HOIAN_OLD';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_HOIAN_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 26 WHERE ma_tour_thuc_te = 'TTT_HUE_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 27 WHERE ma_tour_thuc_te = 'TTT_HUE_OPEN_04';
UPDATE tour_thuc_tes SET cho_con_lai = 17 WHERE ma_tour_thuc_te = 'TTT_HUE_QT_02';
UPDATE tour_thuc_tes SET cho_con_lai = 15 WHERE ma_tour_thuc_te = 'TTT_HUE_REVIEW_03';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_HUY';
UPDATE tour_thuc_tes SET cho_con_lai = 28 WHERE ma_tour_thuc_te = 'TTT_KT';
UPDATE tour_thuc_tes SET cho_con_lai = 14 WHERE ma_tour_thuc_te = 'TTT_MB';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_MOCCHAU';
UPDATE tour_thuc_tes SET cho_con_lai = 24 WHERE ma_tour_thuc_te = 'TTT_MOCCHAU_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 23 WHERE ma_tour_thuc_te = 'TTT_MUINE';
UPDATE tour_thuc_tes SET cho_con_lai = 24 WHERE ma_tour_thuc_te = 'TTT_MUINE_OLD';
UPDATE tour_thuc_tes SET cho_con_lai = 27 WHERE ma_tour_thuc_te = 'TTT_MUINE_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_NINHBINH_CKH_02';
UPDATE tour_thuc_tes SET cho_con_lai = 19 WHERE ma_tour_thuc_te = 'TTT_NINHBINH_KT_HDV10';
UPDATE tour_thuc_tes SET cho_con_lai = 29 WHERE ma_tour_thuc_te = 'TTT_NINHBINH_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_PHUQUOC_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 24 WHERE ma_tour_thuc_te = 'TTT_PHUQUOC_OPEN_04';
UPDATE tour_thuc_tes SET cho_con_lai = 15 WHERE ma_tour_thuc_te = 'TTT_PHUQUOC_REVIEW_03';
UPDATE tour_thuc_tes SET cho_con_lai = 21 WHERE ma_tour_thuc_te = 'TTT_PHUQUOC_SDR_02';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_PULUONG';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_PULUONG_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 20 WHERE ma_tour_thuc_te = 'TTT_QT';
UPDATE tour_thuc_tes SET cho_con_lai = 20 WHERE ma_tour_thuc_te = 'TTT_QUYNHON';
UPDATE tour_thuc_tes SET cho_con_lai = 23 WHERE ma_tour_thuc_te = 'TTT_QUYNHON_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 13 WHERE ma_tour_thuc_te = 'TTT_SAPA_OLD';
UPDATE tour_thuc_tes SET cho_con_lai = 25 WHERE ma_tour_thuc_te = 'TTT_SAPA_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 26 WHERE ma_tour_thuc_te = 'TTT_SAPA_OPEN_04';
UPDATE tour_thuc_tes SET cho_con_lai = 18 WHERE ma_tour_thuc_te = 'TTT_SAPA_REVIEW_03';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_SDR';
UPDATE tour_thuc_tes SET cho_con_lai = 16 WHERE ma_tour_thuc_te = 'TTT_TMNEW_BB_ACTIVE';
UPDATE tour_thuc_tes SET cho_con_lai = 22 WHERE ma_tour_thuc_te = 'TTT_TMNEW_CM_DONE';
UPDATE tour_thuc_tes SET cho_con_lai = 24 WHERE ma_tour_thuc_te = 'TTT_TMNEW_PN_OPEN';
UPDATE tour_thuc_tes SET cho_con_lai = 20 WHERE ma_tour_thuc_te = 'TTT_TMNEW_PN_QT';

-- ==========================================
-- TỰ ĐỘNG BỔ SUNG ĐỂ TOUR GẦN HẾT CHỖ 
-- ==========================================
UPDATE tour_thuc_tes SET cho_con_lai = 1 WHERE ma_tour_thuc_te = 'TTT_HUE_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 3 WHERE ma_tour_thuc_te = 'TTT_PULUONG_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 3 WHERE ma_tour_thuc_te = 'TTT_26_SAPA_NOV';
UPDATE tour_thuc_tes SET cho_con_lai = 2 WHERE ma_tour_thuc_te = 'TTT_NINHBINH_OPEN_03';
UPDATE tour_thuc_tes SET cho_con_lai = 2 WHERE ma_tour_thuc_te = 'TTT_PHUQUOC_SDR_02';
