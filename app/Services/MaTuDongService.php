<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Exceptions\AppException;

class MaTuDongService
{
    /**
     * Tạo mã tài khoản theo vai trò
     */
    public function taoMaTaiKhoanTheoVaiTro(string $maVaiTro): string
    {
        $prefix = match ($maVaiTro) {
            'KHACHHANG' => 'TK_KH',
            'HDV' => 'TK_HDV',
            'SANPHAM' => 'TK_SP',
            'KINHDOANH' => 'TK_KD',
            'DIEUHANH' => 'TK_DH',
            'KETOAN' => 'TK_KT',
            'ADMIN' => 'TK_AD',
            default => throw AppException::badRequest("Vai trò không hợp lệ")
        };

        return $this->taoMa('TAIKHOAN', 'MaTaiKhoan', $prefix);
    }

    /**
     * Tạo mã hồ sơ cho khách hàng
     */
    public function taoMaHoChieuSo(): string
    {
        return $this->taoMa('HOCHIEUSO', 'MaKhachHang', 'KH');
    }

    /**
     * Tạo mã nhân viên
     */
    public function taoMaNhanVien(): string
    {
        return $this->taoMa('NHANVIEN', 'MaNhanVien', 'NV');
    }

    /**
     * Tạo mã dịch vụ thêm
     */
    public function taoMaDichVuThem(): string
    {
        return $this->taoMa('DICHVUTHEM', 'MaDichVuThem', 'DV');
    }

    /**
     * Tạo mã tour mẫu
     */
    public function taoMaTourMau(): string
    {
        return $this->taoMa('TOURMAU', 'MaTourMau', 'TM');
    }

    /**
     * Tạo mã tour thực tế
     */
    public function taoMaTourThucTe(): string
    {
        return $this->taoMa('TOURTHUCTE', 'MaTourThucTe', 'TTT');
    }

    /**
     * Tạo mã lịch trình tour
     */
    public function taoMaLichTrinhTour(): string
    {
        return $this->taoMa('LICHTRINHTOUR', 'MaLichTrinhTour', 'LT');
    }

    /**
     * Tạo danh sách mã lịch trình tour
     */
    public function taoDanhSachMaLichTrinhTour(int $soLuong): array
    {
        return $this->taoNhieuMa('LICHTRINHTOUR', 'MaLichTrinhTour', 'LT', $soLuong);
    }

    /**
     * Tạo mã đơn đặt tour
     */
    public function taoMaDonDatTour(): string
    {
        return $this->taoMa('DONDATTOUR', 'MaDatTour', 'DDT');
    }

    /**
     * Tạo mã chi tiết đặt tour
     */
    public function taoMaChiTietDatTour(): string
    {
        return $this->taoMa('CHITIETDATTOUR', 'MaChiTietDat', 'CTD');
    }

    /**
     * Tạo mã danh sách người đồng hành
     */
    public function taoMaNguoiDongHanh(): string
    {
        return $this->taoMa('DSNGUOIDONGHANH', 'MaNguoiDongHanh', 'NDH');
    }

    /**
     * Tạo mã chi tiết dịch vụ thêm
     */
    public function taoMaChiTietDichVu(): string
    {
        return $this->taoMa('CHITIETDICHVU', 'MaChiTietDichVu', 'CTDV');
    }

    /**
     * Tạo mã giao dịch
     */
    public function taoMaGiaoDich(): string
    {
        return $this->taoMa('GIAODICH', 'MaGiaoDich', 'GD');
    }

    /**
     * Tạo mã lịch sử tour
     */
    public function taoMaLichSuTour(): string
    {
        return $this->taoMa('LICHSUTOUR', 'MaLichSuTour', 'LST');
    }

    /**
     * Tạo mã yêu cầu hỗ trợ
     */
    public function taoMaYeuCauHoTro(): string
    {
        return $this->taoMa('YEUCAUHOTRO', 'MaYeuCauHoTro', 'YCHT');
    }


    /**
     * Hàm dùng chung tạo 1 mã
     */
    private function taoMa(string $tenBang, string $tenCot, string $tienTo): string
    {
        $danhSach = $this->taoNhieuMa($tenBang, $tenCot, $tienTo, 1);
        return $danhSach[0];
    }

    /**
     * Hàm dùng chung tạo nhiều mã an toàn
     */
    private function taoNhieuMa(string $tenBang, string $tenCot, string $tienTo, int $soLuong): array
    {
        if ($soLuong < 1) {
            return [];
        }

        // Đảm bảo an toàn khi tạo mã bằng transaction và lock
        return DB::transaction(function () use ($tenBang, $tenCot, $tienTo, $soLuong) {
            $prefixLen = strlen($tienTo) + 1; // +1 vì hàm SUBSTRING trong SQL tính từ 1
            
            // Tìm số lớn nhất hiện tại, có khoá dòng để tránh trùng lặp khi request song song
            $sql = "SELECT MAX(CAST(SUBSTRING({$tenCot}, ?) AS UNSIGNED)) as max_val 
                    FROM {$tenBang} 
                    WHERE {$tenCot} LIKE ?
                    FOR UPDATE";
                    
            $result = DB::select($sql, [$prefixLen, $tienTo . '%']);
            $maxVal = $result[0]->max_val ?? 0;
            
            $danhSachMa = [];
            for ($i = 1; $i <= $soLuong; $i++) {
                // Đệm thêm số 0 để mã có độ dài cố định (VD: TM00001)
                $danhSachMa[] = $tienTo . str_pad($maxVal + $i, 5, '0', STR_PAD_LEFT);
            }
            
            return $danhSachMa;
        });
    }
}
