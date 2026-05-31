<?php
/**
 * Script thay thế hàng loạt PascalCase → snake_case trong thư mục tests/
 * Chạy: php database/scripts/replace_pascal_case_tests.php
 */

$projectRoot = dirname(__DIR__, 2);
$testsDir = $projectRoot . '/tests';

// Ánh xạ tên bảng
$tableMap = [
    'CHIPHITHUCTE'      => 'chi_phi_thuc_tes',
    'CHITIETDATTOUR'    => 'chi_tiet_dat_tours',
    'CHITIETDICHVU'     => 'chi_tiet_dich_vus',
    'DANHGIAKH'         => 'danh_gia_khs',
    'DATTOUR_UUDAI'     => 'dat_tour_uu_dais',
    'DICHVUTHEM'        => 'dich_vu_thems',
    'DICHVU_TOURTHUCTE' => 'dich_vu_tour_thuc_tes',
    'DIEMDANH'          => 'diem_danhs',
    'DONDATTOUR'        => 'don_dat_tours',
    'DSNGUOIDONGHANH'   => 'ds_nguoi_dong_hanhs',
    'GIAODICH'          => 'giao_diches',
    'HANHDONG'          => 'hanh_dongs',
    'HANHDONGXANH'      => 'hanh_dong_xanhs',
    'HDX_TOURTHUCTE'    => 'hdx_tour_thuc_tes',
    'HOCHIEUSO'         => 'ho_chieu_sos',
    'KHUYENMAI_KH'      => 'khuyen_mai_khs',
    'LICHSUTOUR'        => 'lich_su_tours',
    'LICHTRINHTOUR'     => 'lich_trinh_tours',
    'NANGLUCNHANVIEN'   => 'nang_luc_nhan_viens',
    'NHANVIEN'          => 'nhan_viens',
    'NHATKYDOIDIEM'     => 'nhat_ky_doi_diems',
    'NHATKYHETHONG'     => 'nhat_ky_he_thongs',
    'NHATKYSUCO'        => 'nhat_ky_su_cos',
    'PHANCONGTOUR'      => 'phan_cong_tours',
    'QUYETTOAN'         => 'quyet_toans',
    'TAIKHOAN'          => 'tai_khoans',
    'TOURMAU'           => 'tour_maus',
    'TOURTHUCTE'        => 'tour_thuc_tes',
    'VAITRO'            => 'vai_tros',
    'VOUCHER'           => 'vouchers',
    'YEUCAUHOTRO'       => 'yeu_cau_ho_tros',
];

// Danh sách các cột dạng thô
$rawColumns = [
    'MaDanhGiaKhachHang'  => 'ma_danh_gia_khach_hang',
    'MaGhiNhanHanhDong'   => 'ma_ghi_nhan_hanh_dong',
    'MaNangLucNhanVien'   => 'ma_nang_luc_nhan_vien',
    'MaNhatKyHeThong'     => 'ma_nhat_ky_he_thong',
    'MaNhatKyDoiDiem'     => 'ma_nhat_ky_doi_diem',
    'MaNhatKySuCo'        => 'ma_nhat_ky_su_co',
    'MaNhanVienBaoCao'    => 'ma_nhan_vien_bao_cao',
    'MaNhanVienXacMinh'   => 'ma_nhan_vien_xac_minh',
    'MaNhanVienXuLy'      => 'ma_nhan_vien_xu_ly',
    'MaNguoiDongHanh'     => 'ma_nguoi_dong_hanh',
    'MaPhanCongTour'      => 'ma_phan_cong_tour',
    'MaLichSuTour'        => 'ma_lich_su_tour',
    'MaLichTrinhTour'     => 'ma_lich_trinh_tour',
    'MaHanhDongXanh'      => 'ma_hanh_dong_xanh',
    'MaChiPhiThucTe'      => 'ma_chi_phi_thuc_te',
    'MaChiTietDichVu'     => 'ma_chi_tiet_dich_vu',
    'MaChiTietDat'        => 'ma_chi_tiet_dat',
    'MaTourThucTe'        => 'ma_tour_thuc_te',
    'MaTourMau'           => 'ma_tour_mau',
    'MaYeuCauHoTro'       => 'ma_yeu_cau_ho_tro',
    'MaQuyetToan'         => 'ma_quyet_toan',
    'MaDichVuThem'        => 'ma_dich_vu_them',
    'MaKhachHang'         => 'ma_khach_hang',
    'MaNhanVien'          => 'ma_nhan_vien',
    'MaTaiKhoan'          => 'ma_tai_khoan',
    'MaDatTour'           => 'ma_dat_tour',
    'MaGiaoDich'          => 'ma_giao_dich',
    'MaDiemDanh'          => 'ma_diem_danh',
    'MaVoucher'           => 'ma_voucher',
    'MaVaiTro'            => 'ma_vai_tro',
    'MaCode'              => 'ma_code',
    'MaDoiTuong'          => 'ma_doi_tuong',
    'MaGDNH'              => 'ma_gdnh',
    'TrangThaiChapNhan'   => 'trang_thai_chap_nhan',
    'TrangThaiDuyet'      => 'trang_thai_duyet',
    'TrangThaiLamViec'    => 'trang_thai_lam_viec',
    'TrangThai'           => 'trang_thai',
    'TenDangNhap'         => 'ten_dang_nhap',
    'TenHienThi'          => 'ten_hien_thi',
    'TenHanhDong'         => 'ten_hanh_dong',
    'ThanhTien'           => 'thanh_tien',
    'ThoiGianBaoCao'      => 'thoi_gian_bao_cao',
    'ThoiGianHetHan'      => 'thoi_gian_het_han',
    'ThoiGian'            => 'thoi_gian',
    'ThoiLuong'           => 'thoi_luong',
    'TongDoanhThu'        => 'tong_doanh_thu',
    'TongChiPhi'          => 'tong_chi_phi',
    'TongTien'            => 'tong_tien',
    'NgayKhoiHanh'        => 'ngay_khoi_hanh',
    'NgayDanhGia'         => 'ngay_danh_gia',
    'NgayPhanCong'        => 'ngay_phan_cong',
    'NgayPhanHoi'         => 'ngay_phan_hoi',
    'NgayQuyetToan'       => 'ngay_quyet_toan',
    'NgayThanhToan'       => 'ngay_thanh_toan',
    'NgayHieuLuc'         => 'ngay_hieu_luc',
    'NgayHetHan'          => 'ngay_het_han',
    'NgayApDung'          => 'ngay_ap_dung',
    'NgayThamGia'         => 'ngay_tham_gia',
    'NgayVaoLam'          => 'ngay_vao_lam',
    'NgayQuyDoi'          => 'ngay_quy_doi',
    'NgaySinh'            => 'ngay_sinh',
    'NgayKhai'            => 'ngay_khai',
    'NgayDat'             => 'ngay_dat',
    'NgayNhan'            => 'ngay_nhan',
    'NgayThu'             => 'ngay_thu',
    'SoKhachToiDa'        => 'so_khach_toi_da',
    'SoKhachToiThieu'     => 'so_khach_toi_thieu',
    'SoLuotPhatHanh'      => 'so_luot_phat_hanh',
    'SoLuotDaDung'        => 'so_luot_da_dung',
    'SoTienUuDai'         => 'so_tien_uu_dai',
    'SoDanhGia'           => 'so_danh_gia',
    'SoDienThoai'         => 'so_dien_thoai',
    'SoLuong'             => 'so_luong',
    'SoSao'               => 'so_sao',
    'SoTien'              => 'so_tien',
    'ChoConLai'           => 'cho_con_lai',
    'GiaHienHanh'         => 'gia_hien_hanh',
    'GiaTaiThoiDiemDat'   => 'gia_tai_thoi_diem_dat',
    'GiaCamKet'           => 'gia_cam_ket',
    'GiaSan'              => 'gia_san',
    'GiaTriGiam'          => 'gia_tri_giam',
    'GiaiPhap'            => 'giai_phap',
    'GhiChuYTe'           => 'ghi_chu_y_te',
    'GhiChu'              => 'ghi_chu',
    'HangThanhVien'       => 'hang_thanh_vien',
    'HoaDonAnh'           => 'hoa_don_anh',
    'HoatDong'            => 'hoat_dong',
    'HoTen'               => 'ho_ten',
    'DiemXanh'            => 'diem_xanh',
    'DiemCong'            => 'diem_cong',
    'DiemQuyDoi'          => 'diem_quy_doi',
    'DieuKienApDung'      => 'dieu_kien_ap_dung',
    'DonGia'              => 'don_gia',
    'DonViTinh'           => 'don_vi_tinh',
    'DoiTuong'            => 'doi_tuong',
    'DiaDiem'             => 'dia_diem',
    'DiUng'               => 'di_ung',
    'DanhGia'             => 'danh_gia',
    'DanhMuc'             => 'danh_muc',
    'HanhDongXanh'        => 'hanh_dong_xanh',
    'LoaiGiaoDich'        => 'loai_giao_dich',
    'LoaiKhach'           => 'loai_khach',
    'LoaiNhanVien'        => 'loai_nhan_vien',
    'LoaiSuCo'            => 'loai_su_co',
    'LoaiUuDai'           => 'loai_uu_dai',
    'LoaiYeuCau'          => 'loai_yeu_cau',
    'LoiNhuan'            => 'loi_nhuan',
    'MatKhau'             => 'mat_khau',
    'MinhChung'           => 'minh_chung',
    'MoTa'                => 'mo_ta',
    'MucDo'               => 'muc_do',
    'MucGiamToiDa'        => 'muc_giam_toi_da',
    'NgonNgu'             => 'ngon_ngu',
    'NhanXet'             => 'nhan_xet',
    'NoiDung'             => 'noi_dung',
    'PhuongThuc'          => 'phuong_thuc',
    'TieuDe'              => 'tieu_de',
    'VaiTro'              => 'vai_trro', // Sửa lỗi chính tả
    'ThucDon'             => 'thuc_don',
    'CCCD'                => 'cccd',
    'Email'               => 'email',
    'ChungChi'            => 'chung_chi',
    'ChuyenMon'           => 'chuyen_mon',
    'Ten'                 => 'ten',
];

// Chèn thêm giá trị đúng của VaiTro
$rawColumns['VaiTro'] = 'vai_tro';

// Xây dựng map thay thế đầy đủ (cả nháy đơn và nháy kép)
$finalMap = [];

// 1. Map cho bảng
foreach ($tableMap as $cu => $moi) {
    $finalMap["'$cu'"] = "'$moi'";
    $finalMap["\"$cu\""] = "\"$moi\"";
}

// 2. Map cho cột
foreach ($rawColumns as $cu => $moi) {
    $finalMap["'$cu'"] = "'$moi'";
    $finalMap["\"$cu\""] = "\"$moi\"";
}

// 3. Property access
$propertyMap = [];
foreach ($rawColumns as $cu => $moi) {
    $propertyMap['->' . $cu] = '->' . $moi;
}

$tongFile = 0;
if (is_dir($testsDir)) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($testsDir));
    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') continue;

        $path = $file->getPathname();
        $content = file_get_contents($path);
        $original = $content;

        // Thay thế bảng và cột trong chuỗi
        $content = str_replace(array_keys($finalMap), array_values($finalMap), $content);

        // Thay thế property access
        foreach ($propertyMap as $pascal => $snake) {
            $content = preg_replace(
                '/' . preg_quote($pascal, '/') . '(?!\s*\()/',
                $snake,
                $content
            );
        }

        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "✓ tests/" . basename($path) . "\n";
            $tongFile++;
        }
    }
}

echo "\nHoàn thành! Đã cập nhật $tongFile files trong thư mục tests.\n";
