<?php
/**
 * Script thay thế hàng loạt PascalCase → snake_case
 * trong tất cả PHP files của thư mục app/
 *
 * Chạy: php database/scripts/replace_pascal_case.php
 */

$projectRoot = dirname(__DIR__, 2);
$appDir = $projectRoot . '/app';

// Ánh xạ PascalCase → snake_case cho TẤT CẢ cột và giá trị string trong code
// Thứ tự QUAN TRỌNG: dài trước ngắn sau để tránh replace nhầm
$columnMap = [
    // Cột đặc biệt (ưu tiên cao)
    "'MaDanhGiaKhachHang'"  => "'ma_danh_gia_khach_hang'",
    "'MaGhiNhanHanhDong'"   => "'ma_ghi_nhan_hanh_dong'",
    "'MaNangLucNhanVien'"   => "'ma_nang_luc_nhan_vien'",
    "'MaNhatKyHeThong'"     => "'ma_nhat_ky_he_thong'",
    "'MaNhatKyDoiDiem'"     => "'ma_nhat_ky_doi_diem'",
    "'MaNhatKySuCo'"        => "'ma_nhat_ky_su_co'",
    "'MaNhanVienBaoCao'"    => "'ma_nhan_vien_bao_cao'",
    "'MaNhanVienXacMinh'"   => "'ma_nhan_vien_xac_minh'",
    "'MaNhanVienXuLy'"      => "'ma_nhan_vien_xu_ly'",
    "'MaNguoiDongHanh'"     => "'ma_nguoi_dong_hanh'",
    "'MaPhanCongTour'"      => "'ma_phan_cong_tour'",
    "'MaLichSuTour'"        => "'ma_lich_su_tour'",
    "'MaLichTrinhTour'"     => "'ma_lich_trinh_tour'",
    "'MaHanhDongXanh'"      => "'ma_hanh_dong_xanh'",
    "'MaChiPhiThucTe'"      => "'ma_chi_phi_thuc_te'",
    "'MaChiTietDichVu'"     => "'ma_chi_tiet_dich_vu'",
    "'MaChiTietDat'"        => "'ma_chi_tiet_dat'",
    "'MaTourThucTe'"        => "'ma_tour_thuc_te'",
    "'MaTourMau'"           => "'ma_tour_mau'",
    "'MaYeuCauHoTro'"       => "'ma_yeu_cau_ho_tro'",
    "'MaQuyetToan'"         => "'ma_quyet_toan'",
    "'MaDichVuThem'"        => "'ma_dich_vu_them'",
    "'MaKhachHang'"         => "'ma_khach_hang'",
    "'MaNhanVien'"          => "'ma_nhan_vien'",
    "'MaTaiKhoan'"          => "'ma_tai_khoan'",
    "'MaDatTour'"           => "'ma_dat_tour'",
    "'MaGiaoDich'"          => "'ma_giao_dich'",
    "'MaDiemDanh'"          => "'ma_diem_danh'",
    "'MaVoucher'"           => "'ma_voucher'",
    "'MaVaiTro'"            => "'ma_vai_tro'",
    "'MaCode'"              => "'ma_code'",
    "'MaDoiTuong'"          => "'ma_doi_tuong'",
    "'MaGDNH'"              => "'ma_gdnh'",

    // Cột thông thường
    "'TrangThaiChapNhan'"   => "'trang_thai_chap_nhan'",
    "'TrangThaiDuyet'"      => "'trang_thai_duyet'",
    "'TrangThaiLamViec'"    => "'trang_thai_lam_viec'",
    "'TrangThai'"           => "'trang_thai'",
    "'TenDangNhap'"         => "'ten_dang_nhap'",
    "'TenHienThi'"          => "'ten_hien_thi'",
    "'TenHanhDong'"         => "'ten_hanh_dong'",
    "'ThanhTien'"           => "'thanh_tien'",
    "'ThoiGianBaoCao'"      => "'thoi_gian_bao_cao'",
    "'ThoiGianHetHan'"      => "'thoi_gian_het_han'",
    "'ThoiGian'"            => "'thoi_gian'",
    "'ThoiLuong'"           => "'thoi_luong'",
    "'TongDoanhThu'"        => "'tong_doanh_thu'",
    "'TongChiPhi'"          => "'tong_chi_phi'",
    "'TongTien'"            => "'tong_tien'",
    "'NgayKhoiHanh'"        => "'ngay_khoi_hanh'",
    "'NgayDanhGia'"         => "'ngay_danh_gia'",
    "'NgayPhanCong'"        => "'ngay_phan_cong'",
    "'NgayPhanHoi'"         => "'ngay_phan_hoi'",
    "'NgayQuyetToan'"       => "'ngay_quyet_toan'",
    "'NgayThanhToan'"       => "'ngay_thanh_toan'",
    "'NgayHieuLuc'"         => "'ngay_hieu_luc'",
    "'NgayHetHan'"          => "'ngay_het_han'",
    "'NgayApDung'"          => "'ngay_ap_dung'",
    "'NgayThamGia'"         => "'ngay_tham_gia'",
    "'NgayVaoLam'"          => "'ngay_vao_lam'",
    "'NgayQuyDoi'"          => "'ngay_quy_doi'",
    "'NgaySinh'"            => "'ngay_sinh'",
    "'NgayKhai'"            => "'ngay_khai'",
    "'NgayDat'"             => "'ngay_dat'",
    "'NgayNhan'"            => "'ngay_nhan'",
    "'NgayThu'"             => "'ngay_thu'",
    "'SoKhachToiDa'"        => "'so_khach_toi_da'",
    "'SoKhachToiThieu'"     => "'so_khach_toi_thieu'",
    "'SoLuotPhatHanh'"      => "'so_luot_phat_hanh'",
    "'SoLuotDaDung'"        => "'so_luot_da_dung'",
    "'SoTienUuDai'"         => "'so_tien_uu_dai'",
    "'SoDanhGia'"           => "'so_danh_gia'",
    "'SoDienThoai'"         => "'so_dien_thoai'",
    "'SoLuong'"             => "'so_luong'",
    "'SoSao'"               => "'so_sao'",
    "'SoTien'"              => "'so_tien'",
    "'ChoConLai'"           => "'cho_con_lai'",
    "'GiaHienHanh'"         => "'gia_hien_hanh'",
    "'GiaTaiThoiDiemDat'"   => "'gia_tai_thoi_diem_dat'",
    "'GiaCamKet'"           => "'gia_cam_ket'",
    "'GiaSan'"              => "'gia_san'",
    "'GiaTriGiam'"          => "'gia_tri_giam'",
    "'GiaiPhap'"            => "'giai_phap'",
    "'GhiChuYTe'"           => "'ghi_chu_y_te'",
    "'GhiChu'"              => "'ghi_chu'",
    "'HangThanhVien'"       => "'hang_thanh_vien'",
    "'HoaDonAnh'"           => "'hoa_don_anh'",
    "'HoaTDong'"            => "'hoat_dong'",
    "'HoatDong'"            => "'hoat_dong'",
    "'HoTen'"               => "'ho_ten'",
    "'DiemXanh'"            => "'diem_xanh'",
    "'DiemCong'"            => "'diem_cong'",
    "'DiemQuyDoi'"          => "'diem_quy_doi'",
    "'DieuKienApDung'"      => "'dieu_kien_ap_dung'",
    "'DonGia'"              => "'don_gia'",
    "'DonViTinh'"           => "'don_vi_tinh'",
    "'DoiTuong'"            => "'doi_tuong'",
    "'DiaDiem'"             => "'dia_diem'",
    "'DiUng'"               => "'di_ung'",
    "'DanhGia'"             => "'danh_gia'",
    "'DanhMuc'"             => "'danh_muc'",
    "'HanhDongXanh'"        => "'hanh_dong_xanh'",
    "'LoaiGiaoDich'"        => "'loai_giao_dich'",
    "'LoaiKhach'"           => "'loai_khach'",
    "'LoaiNhanVien'"        => "'loai_nhan_vien'",
    "'LoaiSuCo'"            => "'loai_su_co'",
    "'LoaiUuDai'"           => "'loai_uu_dai'",
    "'LoaiYeuCau'"          => "'loai_yeu_cau'",
    "'LoiNhuan'"            => "'loi_nhuan'",
    "'MatKhau'"             => "'mat_khau'",
    "'MinhChung'"           => "'minh_chung'",
    "'MoTa'"                => "'mo_ta'",
    "'MucDo'"               => "'muc_do'",
    "'MucGiamToiDa'"        => "'muc_giam_toi_da'",
    "'NgonNgu'"             => "'ngon_ngu'",
    "'NhanXet'"             => "'nhan_xet'",
    "'NoiDung'"             => "'noi_dung'",
    "'PhuongThuc'"          => "'phuong_thuc'",
    "'TieuDe'"              => "'tieu_de'",
    "'VaiTro'"              => "'vai_tro'",
    "'ThucDon'"             => "'thuc_don'",
    "'CCCD'"                => "'cccd'",
    "'Email'"               => "'email'",
    "'ChungChi'"            => "'chung_chi'",
    "'ChuyenMon'"           => "'chuyen_mon'",
    "'Ten'"                 => "'ten'",
];

// Thay thế property access $model->PascalCase → $model->snake_case
// (chỉ khi không phải method call)
$propertyMap = [
    // Khóa chính
    '->MaDanhGiaKhachHang'  => '->ma_danh_gia_khach_hang',
    '->MaGhiNhanHanhDong'   => '->ma_ghi_nhan_hanh_dong',
    '->MaNangLucNhanVien'   => '->ma_nang_luc_nhan_vien',
    '->MaNhatKyHeThong'     => '->ma_nhat_ky_he_thong',
    '->MaNhatKyDoiDiem'     => '->ma_nhat_ky_doi_diem',
    '->MaNhatKySuCo'        => '->ma_nhat_ky_su_co',
    '->MaNhanVienBaoCao'    => '->ma_nhan_vien_bao_cao',
    '->MaNhanVienXacMinh'   => '->ma_nhan_vien_xac_minh',
    '->MaNhanVienXuLy'      => '->ma_nhan_vien_xu_ly',
    '->MaNguoiDongHanh'     => '->ma_nguoi_dong_hanh',
    '->MaPhanCongTour'      => '->ma_phan_cong_tour',
    '->MaLichSuTour'        => '->ma_lich_su_tour',
    '->MaLichTrinhTour'     => '->ma_lich_trinh_tour',
    '->MaHanhDongXanh'      => '->ma_hanh_dong_xanh',
    '->MaChiPhiThucTe'      => '->ma_chi_phi_thuc_te',
    '->MaChiTietDichVu'     => '->ma_chi_tiet_dich_vu',
    '->MaChiTietDat'        => '->ma_chi_tiet_dat',
    '->MaTourThucTe'        => '->ma_tour_thuc_te',
    '->MaTourMau'           => '->ma_tour_mau',
    '->MaYeuCauHoTro'       => '->ma_yeu_cau_ho_tro',
    '->MaQuyetToan'         => '->ma_quyet_toan',
    '->MaDichVuThem'        => '->ma_dich_vu_them',
    '->MaKhachHang'         => '->ma_khach_hang',
    '->MaNhanVien'          => '->ma_nhan_vien',
    '->MaTaiKhoan'          => '->ma_tai_khoan',
    '->MaDatTour'           => '->ma_dat_tour',
    '->MaGiaoDich'          => '->ma_giao_dich',
    '->MaDiemDanh'          => '->ma_diem_danh',
    '->MaVoucher'           => '->ma_voucher',
    '->MaVaiTro'            => '->ma_vai_tro',
    '->MaCode'              => '->ma_code',
    '->MaDoiTuong'          => '->ma_doi_tuong',
    '->MaGDNH'              => '->ma_gdnh',

    // Cột thông thường
    '->TrangThaiChapNhan'   => '->trang_thai_chap_nhan',
    '->TrangThaiDuyet'      => '->trang_thai_duyet',
    '->TrangThaiLamViec'    => '->trang_thai_lam_viec',
    '->TrangThai'           => '->trang_thai',
    '->TenDangNhap'         => '->ten_dang_nhap',
    '->TenHienThi'          => '->ten_hien_thi',
    '->TenHanhDong'         => '->ten_hanh_dong',
    '->ThanhTien'           => '->thanh_tien',
    '->ThoiGianBaoCao'      => '->thoi_gian_bao_cao',
    '->ThoiGianHetHan'      => '->thoi_gian_het_han',
    '->ThoiGian'            => '->thoi_gian',
    '->ThoiLuong'           => '->thoi_luong',
    '->TongDoanhThu'        => '->tong_doanh_thu',
    '->TongChiPhi'          => '->tong_chi_phi',
    '->TongTien'            => '->tong_tien',
    '->NgayKhoiHanh'        => '->ngay_khoi_hanh',
    '->NgayDanhGia'         => '->ngay_danh_gia',
    '->NgayPhanCong'        => '->ngay_phan_cong',
    '->NgayPhanHoi'         => '->ngay_phan_hoi',
    '->NgayQuyetToan'       => '->ngay_quyet_toan',
    '->NgayThanhToan'       => '->ngay_thanh_toan',
    '->NgayHieuLuc'         => '->ngay_hieu_luc',
    '->NgayHetHan'          => '->ngay_het_han',
    '->NgayApDung'          => '->ngay_ap_dung',
    '->NgayThamGia'         => '->ngay_tham_gia',
    '->NgayVaoLam'          => '->ngay_vao_lam',
    '->NgayQuyDoi'          => '->ngay_quy_doi',
    '->NgaySinh'            => '->ngay_sinh',
    '->NgayKhai'            => '->ngay_khai',
    '->NgayDat'             => '->ngay_dat',
    '->NgayNhan'            => '->ngay_nhan',
    '->NgayThu'             => '->ngay_thu',
    '->SoKhachToiDa'        => '->so_khach_toi_da',
    '->SoKhachToiThieu'     => '->so_khach_toi_thieu',
    '->SoLuotPhatHanh'      => '->so_luot_phat_hanh',
    '->SoLuotDaDung'        => '->so_luot_da_dung',
    '->SoTienUuDai'         => '->so_tien_uu_dai',
    '->SoDanhGia'           => '->so_danh_gia',
    '->SoDienThoai'         => '->so_dien_thoai',
    '->SoLuong'             => '->so_luong',
    '->SoSao'               => '->so_sao',
    '->SoTien'              => '->so_tien',
    '->ChoConLai'           => '->cho_con_lai',
    '->GiaHienHanh'         => '->gia_hien_hanh',
    '->GiaTaiThoiDiemDat'   => '->gia_tai_thoi_diem_dat',
    '->GiaCamKet'           => '->gia_cam_ket',
    '->GiaSan'              => '->gia_san',
    '->GiaTriGiam'          => '->gia_tri_giam',
    '->GiaiPhap'            => '->giai_phap',
    '->GhiChuYTe'           => '->ghi_chu_y_te',
    '->GhiChu'              => '->ghi_chu',
    '->HangThanhVien'       => '->hang_thanh_vien',
    '->HoaDonAnh'           => '->hoa_don_anh',
    '->HoatDong'            => '->hoat_dong',
    '->HoTen'               => '->ho_ten',
    '->DiemXanh'            => '->diem_xanh',
    '->DiemCong'            => '->diem_cong',
    '->DiemQuyDoi'          => '->diem_quy_doi',
    '->DieuKienApDung'      => '->dieu_kien_ap_dung',
    '->DonGia'              => '->don_gia',
    '->DonViTinh'           => '->don_vi_tinh',
    '->DoiTuong'            => '->doi_tuong',
    '->DiaDiem'             => '->dia_diem',
    '->DiUng'               => '->di_ung',
    '->DanhGia'             => '->danh_gia',
    '->DanhMuc'             => '->danh_muc',
    '->HanhDongXanh'        => '->hanh_dong_xanh',
    '->LoaiGiaoDich'        => '->loai_giao_dich',
    '->LoaiKhach'           => '->loai_khach',
    '->LoaiNhanVien'        => '->loai_nhan_vien',
    '->LoaiSuCo'            => '->loai_su_co',
    '->LoaiUuDai'           => '->loai_uu_dai',
    '->LoaiYeuCau'          => '->loai_yeu_cau',
    '->LoiNhuan'            => '->loi_nhuan',
    '->MatKhau'             => '->mat_khau',
    '->MinhChung'           => '->minh_chung',
    '->MoTa'                => '->mo_ta',
    '->MucDo'               => '->muc_do',
    '->MucGiamToiDa'        => '->muc_giam_toi_da',
    '->NgonNgu'             => '->ngon_ngu',
    '->NhanXet'             => '->nhan_xet',
    '->NoiDung'             => '->noi_dung',
    '->PhuongThuc'          => '->phuong_thuc',
    '->TieuDe'              => '->tieu_de',
    '->VaiTro'              => '->vai_tro',
    '->ThucDon'             => '->thuc_don',
    '->CCCD'                => '->cccd',
    '->Email'               => '->email',
    '->ChungChi'            => '->chung_chi',
    '->ChuyenMon'           => '->chuyen_mon',
];

// Các thư mục cần xử lý
$dirs = [
    $appDir . '/Services',
    $appDir . '/Http/Controllers',
    $appDir . '/Http/Resources',
    $appDir . '/Http/Middleware',
    $appDir . '/Http/Requests',
    $appDir . '/Console',
];

$tongFile   = 0;
$tongThayThe = 0;

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') continue;

        $content  = file_get_contents($file->getPathname());
        $original = $content;

        // 1. Thay thế trong chuỗi (tên cột trong where, orderBy, ...)
        $content = str_replace(array_keys($columnMap), array_values($columnMap), $content);

        // 2. Thay thế property access ->PascalCase
        //    Chỉ thay thế nếu KHÔNG theo sau bởi dấu ( (tức là method call)
        foreach ($propertyMap as $pascal => $snake) {
            // Dùng lookahead để không thay thế method call
            $content = preg_replace(
                '/' . preg_quote($pascal, '/') . '(?!\s*\()/',
                $snake,
                $content
            );
        }

        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            $demThayThe = substr_count($content, '->') - substr_count($original, '->');
            echo "✓ " . basename($file->getPathname()) . "\n";
            $tongFile++;
        }
    }
}

// Cũng xử lý Seeders
$seederDir = dirname($appDir) . '/database/seeders';
$files = glob($seederDir . '/*.php');
foreach ($files as $filePath) {
    $content  = file_get_contents($filePath);
    $original = $content;
    $content  = str_replace(array_keys($columnMap), array_values($columnMap), $content);
    foreach ($propertyMap as $pascal => $snake) {
        $content = preg_replace(
            '/' . preg_quote($pascal, '/') . '(?!\s*\()/',
            $snake,
            $content
        );
    }
    if ($content !== $original) {
        file_put_contents($filePath, $content);
        echo "✓ seeders/" . basename($filePath) . "\n";
        $tongFile++;
    }
}

echo "\nHoàn thành! Đã cập nhật $tongFile files.\n";
