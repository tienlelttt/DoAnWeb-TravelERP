-- Ph?m vi    : Vai trò, tài kho?n nhân viên, h? s? nhân viên
-- M?t kh?u m?c ??nh cho t?t c? tài kho?n: password
-- BCrypt(cost=10): $2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK

-- ------------------------------------------------------------
-- 1. vai_tros — Vai trò h? th?ng
-- ------------------------------------------------------------








-- ------------------------------------------------------------
-- 2. tai_khoans — Tài kho?n nhân viên h? th?ng
-- ------------------------------------------------------------


INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_MGR01', 'manager01',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Lê Hoàng Phú', '079099000002', '1990-03-08', 'dieuhanh01@digitaltravel.vn', '0900000002',
        'DIEUHANH', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_SP01', 'sanpham01',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguy?n Tu?n Anh', '079099000099', '1992-06-18', 'sanpham01@digitaltravel.vn', '0900000099',
        'SANPHAM', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_SALES01', 'sales01',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguy?n Hoàng An', '079099000003', '1989-09-21', 'kinhdoanh01@digitaltravel.vn', '0900000003',
        'KINHDOANH', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_KT01', 'ketoan01',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Lê Th? Minh Châu', '079099000004', '1991-12-02', 'ketoan01@digitaltravel.vn', '0900000004',
        'KETOAN', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV01', 'hdv01',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguy?n Hoàng An', '079099000005', '1987-04-15', 'hdv01@digitaltravel.vn', '0900000005',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV02', 'hdv02',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Nguy?n Th? H??ng', '079099000006', '1993-07-27', 'hdv02@digitaltravel.vn', '0900000006',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV03', 'hdv03',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Tr?n Minh Khang', '079099000007', '1991-11-09', 'hdv03@digitaltravel.vn', '0900000007',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV04', 'hdv04',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Ph?m Thu Hà', '079099000008', '1994-02-22', 'hdv04@digitaltravel.vn', '0900000008',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV05', 'hdv05',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Lê Qu?c B?o', '079099000009', '1989-08-30', 'hdv05@digitaltravel.vn', '0900000009',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV06', 'hdv06',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Võ Ng?c Mai', '079099000010', '1995-05-14', 'hdv06@digitaltravel.vn', '0900000010',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV07', 'hdv07',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        '?? H?i Nam', '079099000011', '1988-12-05', 'hdv07@digitaltravel.vn', '0900000011',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV08', 'hdv08',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Bùi Lan Anh', '079099000012', '1992-10-18', 'hdv08@digitaltravel.vn', '0900000012',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV09', 'hdv09',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Hoàng ??c Tín', '079099000013', '1990-04-26', 'hdv09@digitaltravel.vn', '0900000013',
        'HDV', 'HOAT_DONG');

INSERT INTO tai_khoans (ma_tai_khoan, ten_dang_nhap, mat_khau, ho_ten, cccd, ngay_sinh, email, so_dien_thoai, vai_tro, trang_thai)
VALUES ('TK_HDV10', 'hdv10',
        '$2y$10$BBvBS1dGLV8lLRIF47sbfukbnxchs/ZbP6Gdb.JI2H5UZSeHOMmkK',
        'Ngô Thanh Vy', '079099000014', '1996-01-19', 'hdv10@digitaltravel.vn', '0900000014',
        'HDV', 'HOAT_DONG');

-- ------------------------------------------------------------
-- 3. nhan_viens — H? s? nhân viên n?i b?
-- ------------------------------------------------------------

INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_MGR01',    'TK_MGR01',    'DIEUHANH',  '2022-01-15', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_SP01',     'TK_SP01',     'SANPHAM',   '2022-02-01', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_SALES01',  'TK_SALES01',  'KINHDOANH', '2023-03-01', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_KT01',     'TK_KT01',     'KETOAN',    '2023-06-01', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV01',    'TK_HDV01',    'HDV',       '2021-09-15', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV02',    'TK_HDV02',    'HDV',       '2022-05-10', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV03',    'TK_HDV03',    'HDV',       '2022-08-20', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV04',    'TK_HDV04',    'HDV',       '2023-01-10', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV05',    'TK_HDV05',    'HDV',       '2021-12-01', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV06',    'TK_HDV06',    'HDV',       '2023-04-15', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV07',    'TK_HDV07',    'HDV',       '2020-11-25', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV08',    'TK_HDV08',    'HDV',       '2022-09-05', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV09',    'TK_HDV09',    'HDV',       '2021-06-12', 'HOAT_DONG');
INSERT INTO nhan_viens (ma_nhan_vien, ma_tai_khoan, loai_nhan_vien, ngay_vao_lam, trang_thai_lam_viec)
VALUES ('NV_HDV10',    'TK_HDV10',    'HDV',       '2023-07-01', 'HOAT_DONG');

-- ------------------------------------------------------------
-- 4. nang_luc_nhan_viens — ?ánh giá và n?ng l?c
-- ------------------------------------------------------------
INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV01', 'NV_HDV01', 'Ti?ng Anh, Ti?ng Pháp', 'Th? HDV Qu?c t?, S? c?p c?u', 'Chuyên thuy?t minh l?ch s? - v?n hóa: Có kh? n?ng k? chuy?n h?p d?n v? di tích, l?ch s?, phong t?c và ??i s?ng ??a ph??ng.', 4.8, 126);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV02', 'NV_HDV02', 'Ti?ng Anh, Ti?ng Trung', 'Th? HDV Qu?c t?', 'Chuyên ch?m sóc khách gia ?ình: Bi?t cách h? tr? ?oàn có tr? em, ng??i l?n tu?i và khách c?n s? quan tâm ??c bi?t.', 4.5, 89);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV03', 'NV_HDV03', 'Ti?ng Anh, Ti?ng Nh?t', 'Th? HDV Qu?c t?, Nghi?p v? l? hành', 'Chuyên thuy?t minh l?ch s? - v?n hóa: Có kh? n?ng k? chuy?n h?p d?n v? di s?n mi?n Trung, v?n hóa Ch?m và ??i s?ng ??a ph??ng.', 4.7, 102);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV04', 'NV_HDV04', 'Ti?ng Anh, Ti?ng Hàn', 'Th? HDV Qu?c t?, S? c?p c?u', 'Chuyên ch?m sóc khách gia ?ình: Bi?t cách h? tr? ?oàn ngh? d??ng bi?n có tr? em, ng??i l?n tu?i và khách c?n s? quan tâm ??c bi?t.', 4.6, 94);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV05', 'NV_HDV05', 'Ti?ng Anh, Ti?ng ??c', 'Th? HDV Qu?c t?', 'Chuyên thuy?t minh l?ch s? - v?n hóa: Am hi?u ki?n trúc, di tích và bi?t ph?c v? các ?oàn tr?i nghi?m cao c?p.', 4.9, 138);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV06', 'NV_HDV06', 'Ti?ng Anh, Ti?ng Thái', 'Th? HDV N?i ??a, K? n?ng ho?t náo', 'Chuyên tour h?c sinh - sinh viên: Bi?t cách truy?n ??t d? hi?u, t? ch?c ho?t ??ng t?p th? và qu?n lý ?oàn tr?.', 4.4, 76);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV07', 'NV_HDV07', 'Ti?ng Anh, Ti?ng Nga', 'Th? HDV Qu?c t?, C?u h? du l?ch', 'Chuyên d?n tour m?o hi?m: Có kinh nghi?m h? tr? khách trong các ho?t ??ng nh? leo núi, trekking, chèo thuy?n và c?m tr?i.', 4.75, 117);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV08', 'NV_HDV08', 'Ti?ng Anh, Ti?ng Trung', 'Th? HDV Qu?c t?, Nghi?p v? ch?m sóc khách hàng', 'Chuyên ch?m sóc ?oàn doanh nghi?p: Thành th?o t? ch?c l?ch trình MICE, h? tr? s? ki?n và yêu c?u d?ch v? theo ?oàn.', 4.55, 83);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV09', 'NV_HDV09', 'Ti?ng Anh, Ti?ng Pháp', 'Th? HDV Qu?c t?', 'Chuyên d?n tour sinh thái: Am hi?u thiên nhiên, r?ng, c?nh quan Tây Nguyên và các ho?t ??ng b?o v? môi tr??ng.', 4.65, 91);

INSERT INTO nang_luc_nhan_viens (ma_nang_luc_nhan_vien, ma_nhan_vien, ngon_ngu, chung_chi, chuyen_mon, danh_gia, so_danh_gia)
VALUES ('NLNV_HDV10', 'NV_HDV10', 'Ti?ng Anh, Ti?ng Hàn', 'Th? HDV N?i ??a, S? c?p c?u', 'Chuyên d?n tour sinh thái: Am hi?u thiên nhiên, h? sinh thái và tr?i nghi?m c?ng ??ng g?n v?i b?o v? môi tr??ng.', 4.5, 68);


-- ============================================================;