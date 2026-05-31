<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SqlFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taiKhoanPath = 'C:\\Users\\asus\\Downloads\\PTTK\\Digital-Travel_ERP\\Backend\\src\\main\\resources\\db\\Data_tai_khoan.sql';
        $khoiTaoPath = 'C:\\Users\\asus\\Downloads\\PTTK\\Digital-Travel_ERP\\Backend\\src\\main\\resources\\db\\data_khoi_tao.sql';

        if (!file_exists($taiKhoanPath) || !file_exists($khoiTaoPath)) {
            $this->command->error("Một trong hai file SQL không tồn tại!");
            return;
        }

        $this->command->info("Đang đọc dữ liệu từ các file SQL...");
        $taiKhoanSql = file_get_contents($taiKhoanPath);
        $khoiTaoSql = file_get_contents($khoiTaoPath);

        // Hàm dọn dẹp các cú pháp Oracle đặc thù sang MySQL
        $cleanOracleSyntax = function ($sql) {
            // 1. Loại bỏ UTF-8 BOM
            $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql);

            // 2. Chuyển đổi các khoảng cách thời gian Oracle sang MySQL
            $sql = preg_replace('/NUMTODSINTERVAL\s*\(\s*([^,]+)\s*,\s*\'DAY\'\s*\)/i', 'INTERVAL $1 DAY', $sql);
            $sql = preg_replace('/TRUNC\s*\(\s*SYSDATE\s*\)\s*-\s*(\d+)/i', 'DATE(NOW()) - INTERVAL $1 DAY', $sql);
            $sql = preg_replace('/TRUNC\s*\(\s*SYSDATE\s*\)\s*\+\s*(\d+)/i', 'DATE(NOW()) + INTERVAL $1 DAY', $sql);

            // 3. Loại bỏ ESCAPE '\' gây lỗi parse chuỗi trong MySQL
            $sql = preg_replace('/ESCAPE\s*\'\\\\\'/i', '', $sql);

            // 4. Chuyển đổi các hàm Oracle đặc thù sang MySQL
            $sql = str_replace('NVL(', 'COALESCE(', $sql);
            $sql = str_replace('CHR(10)', 'CHAR(10)', $sql);
            $sql = str_replace('CHR(', 'CHAR(', $sql);
            $sql = str_replace('ORA_HASH(', 'CRC32(', $sql);
            $sql = str_replace('TRUNC(SYSDATE)', 'DATE(NOW())', $sql);
            $sql = str_replace('SYSTIMESTAMP', 'NOW()', $sql);
            $sql = str_replace('SYSDATE', 'NOW()', $sql);
            $sql = str_replace('AS TIMESTAMP', 'AS DATETIME', $sql);

            // 5. Thay thế đầu băm mật khẩu từ $2a$ sang $2y$ để tương thích với Laravel BcryptHasher
            $sql = str_replace('$2a$', '$2y$', $sql);

            return $sql;
        };

        $taiKhoanSql = $cleanOracleSyntax($taiKhoanSql);
        $khoiTaoSql = $cleanOracleSyntax($khoiTaoSql);

        // 1. Định nghĩa map chuyển đổi bảng (PascalCase -> snake_case)
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

        // 2. Định nghĩa map chuyển đổi cột (PascalCase -> snake_case)
        $columnMap = [
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
            'ThucDon'             => 'thuc_don',
            'CCCD'                => 'cccd',
            'GioiTinh'            => 'gioi_tinh',
            'Email'               => 'email',
            'ChungChi'            => 'chung_chi',
            'ChuyenMon'           => 'chuyen_mon',
            'Ten'                 => 'ten',
            'HanhDong'            => 'hanh_dong',
        ];

        $columnMap['VaiTro'] = 'vai_role_temp';

        // Gộp hai map chuyển đổi
        $allReplacements = array_merge($tableMap, $columnMap);

        // Sắp xếp các từ cần thay thế theo chiều dài giảm dần
        uksort($allReplacements, function ($a, $b) {
            return strlen($b) <=> strlen($a);
        });

        // Hàm thay thế các từ trùng khớp
        $replaceFunc = function ($sql) use ($allReplacements) {
            foreach ($allReplacements as $pascal => $snake) {
                // Khớp chính xác từ boundary
                $sql = preg_replace('/\b' . preg_quote($pascal, '/') . '\b/', $snake, $sql);
            }
            // Thay vai_role_temp thành vai_tro thực sự
            $sql = preg_replace('/\b' . 'vai_role_temp' . '\b/', 'vai_tro', $sql);
            return $sql;
        };

        $this->command->info("Đang chuyển đổi cú pháp SQL sang snake_case...");
        $convertedTaiKhoanSql = $replaceFunc($taiKhoanSql);
        $convertedKhoiTaoSql = $replaceFunc($khoiTaoSql);

        // Chuyển đổi RTRIM(TRIM(mo_ta), '.') sang cú pháp TRIM(TRAILING '.' FROM TRIM(mo_ta)) của MySQL
        $convertedKhoiTaoSql = preg_replace('/RTRIM\s*\(\s*TRIM\s*\(\s*mo_ta\s*\)\s*,\s*\'\.\'\s*\)/i', "TRIM(TRAILING '.' FROM TRIM(mo_ta))", $convertedKhoiTaoSql);

        $this->command->info("Bắt đầu dọn dẹp và nạp dữ liệu vào Database...");

        // Tắt ràng buộc khoá ngoại trước khi dọn dẹp và seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("SET sql_mode = 'PIPES_AS_CONCAT';");

        // Danh sách tất cả các bảng cần làm sạch dữ liệu
        $tablesToTruncate = array_values($tableMap);
        foreach ($tablesToTruncate as $table) {
            DB::table($table)->truncate();
        }
        $this->command->info("Đã làm sạch toàn bộ bảng trong database.");

        // Hàm thực thi các block SQL theo đúng thứ tự
        $executeSqlBlocks = function ($sql, $fileName) {
            // Split các statement bằng ký tự '/' trên một dòng trống duy nhất (hỗ trợ CRLF và LF)
            $blocks = preg_split('/^\s*\/[\s\r\n]*$/m', $sql);

            foreach ($blocks as $block) {
                $block = trim($block);
                if (empty($block)) {
                    continue;
                }

                // Kiểm tra xem block có chứa định nghĩa thủ tục PL/SQL
                $pos = -1;
                if (preg_match('/\b(DECLARE|CREATE\s+OR\s+REPLACE\s+(FUNCTION|PROCEDURE|TRIGGER))\b/i', $block, $matches, PREG_OFFSET_CAPTURE)) {
                    $pos = $matches[0][1];
                }

                if ($pos !== -1) {
                    // Phần SQL chuẩn trước thủ tục
                    $standardSql = trim(substr($block, 0, $pos));
                    if (!empty($standardSql)) {
                        DB::unprepared($standardSql);
                    }

                    // Nhận diện thủ tục PL/SQL
                    $plsqlBlock = substr($block, $pos);
                    $this->command->info("Bỏ qua block thủ tục Oracle PL/SQL trong file {$fileName}.");

                    // Nếu block này là block chứa 'them_don_tmnew', chạy logic seed native tương ứng
                    if (stripos($plsqlBlock, 'them_don_tmnew') !== false) {
                        $this->command->info("Đang sinh dữ liệu nghiệp vụ bằng logic PHP native tương ứng...");
                        $this->seedNativeTmnewOrders();
                    }
                } else {
                    // Block hoàn toàn là SQL chuẩn
                    DB::unprepared($block);
                }
            }
        };

        // Nạp file 1: Data_tai_khoan.sql
        $this->command->info("Đang nạp file tài khoản...");
        $executeSqlBlocks($convertedTaiKhoanSql, 'Data_tai_khoan.sql');

        // Nạp file 2: data_khoi_tao.sql
        $this->command->info("Đang nạp file khởi tạo dữ liệu nghiệp vụ du lịch...");
        $executeSqlBlocks($convertedKhoiTaoSql, 'data_khoi_tao.sql');

        // Bật lại ràng buộc khoá ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("Seed dữ liệu hoàn thành thành công và an toàn!");
    }

    /**
     * Sinh dữ liệu tour thực tế và các đơn đặt hàng tương ứng bằng PHP native
     */
    private function seedNativeTmnewOrders(): void
    {
        // 1. DDT_TMNEW_PN10
        $this->themDonTmnew(
            'PN10',
            'TTT_TMNEW_PN_OPEN',
            'KH_03',
            5450000,
            10,
            'DVT_TMNEW_CAVE',
            10,
            220000,
            'VC_TMNEW_1M',
            1000000,
            'NOW() - INTERVAL 3 DAY',
            'CHUYEN_KHOAN',
            'Đoàn mười khách đặt tour Phong Nha, cần đủ thiết bị hang động và xác nhận danh sách căn cước trước ngày đi.',
            'HDX_TMNEW_WATER:10',
            501
        );

        // 2. DDT_TMNEW_CM06
        $this->themDonTmnew(
            'CM06',
            'TTT_TMNEW_CM_DONE',
            'KH_04',
            7100000,
            6,
            'DVT_TMNEW_BOAT',
            1,
            1800000,
            null,
            0,
            'NOW() - INTERVAL 120 DAY',
            'THE_QUOC_TE',
            'Đoàn sáu khách đã hoàn thành tour Cà Mau, thuê tàu riêng để tham quan tuyến rừng ngập mặn.',
            'HDX_TMNEW_LOCAL:6',
            502
        );

        // 3. DDT_TMNEW_BB04
        $this->themDonTmnew(
            'BB04',
            'TTT_TMNEW_BB_ACTIVE',
            'KH_08',
            3600000,
            4,
            'DVT_TMNEW_HOMESTAY',
            2,
            420000,
            null,
            0,
            'NOW() - INTERVAL 5 DAY',
            'VI_DIEN_TU',
            'Bốn khách đang tham gia tour Ba Bể, nâng cấp hai phòng homestay riêng và cần thực đơn ít muối.',
            'HDX_TMNEW_WATER:4',
            503
        );

        // 4. DDT_TMNEW_PN05
        $this->themDonTmnew(
            'PN05',
            'TTT_TMNEW_PN_QT',
            'KH_02',
            5400000,
            5,
            'DVT_TMNEW_CAVE',
            5,
            220000,
            null,
            0,
            'NOW() - INTERVAL 145 DAY',
            'CHUYEN_KHOAN',
            'Năm khách đã đi tour Phong Nha, đầy đủ thiết bị hang động và đã thanh toán trước khởi hành.',
            'HDX_TMNEW_LOCAL:5',
            504
        );
    }

    /**
     * Nạp chi tiết một đơn hàng hoàn chỉnh
     */
    private function themDonTmnew(
        string $p_MaGon,
        string $p_MaTour,
        string $p_MaKhachHang,
        float $p_GiaTour,
        int $p_SoKhach,
        string $p_MaDichVu,
        int $p_SoLuongDV,
        float $p_DonGiaDV,
        ?string $p_MaVoucher,
        float $p_TienUuDai,
        string $p_NgayDat,
        string $p_PhuongThuc,
        string $p_GhiChu,
        string $p_HanhDong,
        int $p_Seed
    ): void {
        $v_MaDatTour = 'DDT_TMNEW_' . $p_MaGon;
        $v_TongTien = $p_SoKhach * $p_GiaTour + $p_SoLuongDV * $p_DonGiaDV - $p_TienUuDai;

        // Chèn don_dat_tours
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

        // Chèn chi_tiet_dat_tours cho người đặt
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

        // Vòng lặp thêm hành khách đồng hành
        for ($i = 1; $i <= $p_SoKhach - 1; $i++) {
            $v_Ndh = 'NDH_TMN_' . $p_MaGon . '_' . str_pad((string)$i, 2, '0', STR_PAD_LEFT);

            $modVal = ($p_Seed + $i) % 12;
            switch ($modVal) {
                case 0:  $hoTen = 'Nguyễn An Nhiên'; break;
                case 1:  $hoTen = 'Trần Hải Đăng'; break;
                case 2:  $hoTen = 'Lê Bảo Châu'; break;
                case 3:  $hoTen = 'Phạm Minh Quân'; break;
                case 4:  $hoTen = 'Võ Thanh Hà'; break;
                case 5:  $hoTen = 'Đặng Tuấn Kiệt'; break;
                case 6:  $hoTen = 'Bùi Ngọc Mai'; break;
                case 7:  $hoTen = 'Hoàng Gia Phúc'; break;
                case 8:  $hoTen = 'Cao Thùy Linh'; break;
                case 9:  $hoTen = 'Mai Quốc Huy'; break;
                case 10: $hoTen = 'Đỗ Khánh Vy'; break;
                default: $hoTen = 'Lâm Minh Khoa'; break;
            }

            $cccd = '0888' . str_pad((string)($p_Seed * 100 + $i), 8, '0', STR_PAD_LEFT);
            $sdt = '0944' . str_pad((string)($p_Seed * 100 + $i), 6, '0', STR_PAD_LEFT);

            $monthsToSubtract = 12 * (18 + ($p_Seed + $i) % 35);
            $ngaySinh = date('Y-m-d', strtotime("-{$monthsToSubtract} months"));
            $gioiTinh = ($i % 2 === 0) ? 'NỮ' : 'NAM';

            if ($i === 1) {
                $ghiChuNdh = 'Người thân đi cùng người đặt tour';
            } elseif ($i === $p_SoKhach - 1) {
                $ghiChuNdh = 'Có ghi chú cần hỗ trợ ăn uống và giờ nghỉ';
            } else {
                $ghiChuNdh = 'Thành viên trong đoàn đã cung cấp đủ thông tin cá nhân';
            }

            // Chèn vào ds_nguoi_dong_hanhs
            DB::table('ds_nguoi_dong_hanhs')->insert([
                'ma_nguoi_dong_hanh' => $v_Ndh,
                'ma_dat_tour'        => $v_MaDatTour,
                'ho_ten'             => $hoTen,
                'cccd'               => $cccd,
                'so_dien_thoai'      => $sdt,
                'ngay_sinh'          => $ngaySinh,
                'gioi_tinh'          => $gioiTinh,
                'ghi_chu'            => $ghiChuNdh,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Chèn vào chi_tiet_dat_tours
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

        // Chèn chi_tiet_dich_vus
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

        // Chèn dat_tour_uu_dais
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

        // Chèn giao_diches
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
