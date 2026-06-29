<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Exceptions\AppException;

/**
 * Dịch vụ tạo mã định danh tự động an toàn (thread-safe).
 * Sử dụng Transaction + FOR UPDATE để tránh trùng lặp khi nhiều request song song.
 */
class MaTuDongService
{
    /**
     * Tạo mã tài khoản theo vai trò
     */

    public function taoMaTaiKhoanTheoVaiTro(string $maVaiTro): string
    {
        $prefix = match ($maVaiTro) {
            'KHACHHANG' => 'TK_KH',
            'HDV'       => 'TK_HDV',
            'SANPHAM'   => 'TK_SP',
            'KINHDOANH' => 'TK_KD',
            'DIEUHANH'  => 'TK_DH',
            'KETOAN'    => 'TK_KT',
            'ADMIN'     => 'TK_AD',
            default     => throw AppException::badRequest("Vai trò không hợp lệ"),
        };

        return $this->taoMa('tai_khoans', 'ma_tai_khoan', $prefix);
    }

    /**
     * Tạo mã hồ sơ khách hàng
     */

    public function taoMaHoChieuSo(): string
    {
        return $this->taoMa('ho_chieu_sos', 'ma_khach_hang', 'KH');
    }

    /**
     * Tạo mã nhân viên
     */

    public function taoMaNhanVien(): string
    {
        return $this->taoMa('nhan_viens', 'ma_nhan_vien', 'NV');
    }

    /**
     * Tạo mã dịch vụ thêm
     */

    public function taoMaDichVuThem(): string
    {
        return $this->taoMa('dich_vu_thems', 'ma_dich_vu_them', 'DV');
    }

    /**
     * Tạo mã tour mẫu
     */
    public function taoMaTourMau(): string
    {
        return $this->taoMa('tour_maus', 'ma_tour_mau', 'TM');
    }

    /**
     * Tạo mã tour thực tế
     */
    public function taoMaTourThucTe(): string
    {
        return $this->taoMa('tour_thuc_tes', 'ma_tour_thuc_te', 'TTT');
    }

    /**
     * Tạo mã lịch trình tour
     */
    public function taoMaLichTrinhTour(): string
    {
        return $this->taoMa('lich_trinh_tours', 'ma_lich_trinh_tour', 'LT');
    }

    /**
     * Tạo danh sách mã lịch trình tour
     */
    public function taoDanhSachMaLichTrinhTour(int $soLuong): array
    {
        return $this->taoNhieuMa('lich_trinh_tours', 'ma_lich_trinh_tour', 'LT', $soLuong);
    }

    /**
     * Tạo mã đơn đặt tour
     */
    public function taoMaDonDatTour(): string
    {
        return $this->taoMa('don_dat_tours', 'ma_dat_tour', 'DDT');
    }

    /**
     * Tạo mã chi tiết đặt tour
     */
    public function taoMaChiTietDatTour(): string
    {
        return $this->taoMa('chi_tiet_dat_tours', 'ma_chi_tiet_dat', 'CTD');
    }

    /**
     * Tạo mã người đồng hành
     */
    public function taoMaNguoiDongHanh(): string
    {
        return $this->taoMa('ds_nguoi_dong_hanhs', 'ma_nguoi_dong_hanh', 'NDH');
    }

    /**
     * Tạo mã chi tiết dịch vụ thêm
     */
    public function taoMaChiTietDichVu(): string
    {
        return $this->taoMa('chi_tiet_dich_vus', 'ma_chi_tiet_dich_vu', 'CTDV');
    }

    /**
     * Tạo mã giao dịch
     */

    public function taoMaGiaoDich(): string
    {
        return $this->taoMa('giao_diches', 'ma_giao_dich', 'GD');
    }

    /**
     * Tạo mã lịch sử tour
     */

    public function taoMaLichSuTour(): string
    {
        return $this->taoMa('lich_su_tours', 'ma_lich_su_tour', 'LST');
    }

    /**
     * Tạo mã yêu cầu hỗ trợ
     */

    public function taoMaYeuCauHoTro(): string
    {
        return $this->taoMa('yeu_cau_ho_tros', 'ma_yeu_cau_ho_tro', 'YCHT');
    }

    /**
     * Tạo mã phân công tour
     */
    // Phân công dữ liệu.
    public function taoMaPhanCongTour(): string
    {
        return $this->taoMa('phan_cong_tours', 'ma_phan_cong_tour', 'PCT');
    }

    /**
     * Tạo mã điểm danh
     */

    public function taoMaDiemDanh(): string
    {
        return $this->taoMa('diem_danhs', 'ma_diem_danh', 'DD');
    }

    /**
     * Tạo mã ghi nhận hành động xanh
     */

    public function taoMaGhiNhanHanhDong(): string
    {
        return $this->taoMa('hanh_dongs', 'ma_ghi_nhan_hanh_dong', 'HDX');
    }

    /**
     * Tạo mã nhật ký sự cố
     */

    public function taoMaNhatKySuCo(): string
    {
        return $this->taoMa('nhat_ky_su_cos', 'ma_nhat_ky_su_co', 'SC');
    }

    /**
     * Tạo mã chi phí thực tế
     */

    public function taoMaChiPhiThucTe(): string
    {
        return $this->taoMa('chi_phi_thuc_tes', 'ma_chi_phi_thuc_te', 'CP');
    }

    /**
     * Tạo mã nhật ký hệ thống
     */

    public function taoMaNhatKyHeThong(): string
    {
        return $this->taoMa('nhat_ky_he_thongs', 'ma_nhat_ky_he_thong', 'NK');
    }

    /**
     * Tạo mã quyết toán
     */

    public function taoMaQuyetToan(): string
    {
        return $this->taoMa('quyet_toans', 'ma_quyet_toan', 'QT');
    }

    /**
     * Tạo mã voucher
     */

    public function taoMaVoucher(): string
    {
        return $this->taoMa('vouchers', 'ma_voucher', 'VC');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Hàm nội bộ
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Tạo 1 mã duy nhất (wrapper của taoNhieuMa)
     */

    private function taoMa(string $tenBang, string $tenCot, string $tienTo): string
    {
        $danhSach = $this->taoNhieuMa($tenBang, $tenCot, $tienTo, 1);
        return $danhSach[0];
    }

    /**
     * Tạo nhiều mã an toàn với Transaction + FOR UPDATE (tránh trùng lặp khi request song song)
     *
     * @param  string $tenBang  Tên bảng snake_case
     * @param  string $tenCot   Tên cột khóa chính snake_case
     * @param  string $tienTo   Tiền tố mã (VD: 'TM', 'TTT')
     * @param  int    $soLuong  Số lượng mã cần tạo
     * @return array            Danh sách mã mới
     */

    private function taoNhieuMa(string $tenBang, string $tenCot, string $tienTo, int $soLuong): array
    {
        if ($soLuong < 1) {
            return [];
        }

        return DB::transaction(function () use ($tenBang, $tenCot, $tienTo, $soLuong) {
            // +1 vì hàm SUBSTRING trong SQL đếm từ 1
            $prefixLen = strlen($tienTo) + 1;

            // Khoá dòng để tránh trùng lặp khi nhiều request chạy song song
            $sql = "SELECT MAX(CAST(SUBSTRING({$tenCot}, ?) AS UNSIGNED)) as max_val
                    FROM {$tenBang}
                    WHERE {$tenCot} LIKE ?
                    FOR UPDATE";

            $result = DB::select($sql, [$prefixLen, $tienTo . '%']);
            $maxVal = $result[0]->max_val ?? 0;

            $danhSachMa = [];
            for ($i = 1; $i <= $soLuong; $i++) {
                // Đệm số 0 để mã có độ dài cố định (VD: TM00001)
                $danhSachMa[] = $tienTo . str_pad($maxVal + $i, 5, '0', STR_PAD_LEFT);
            }

            return $danhSachMa;
        });
    }
}
