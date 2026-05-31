<?php
// Script tạo tất cả Models snake_case
// Chạy: php database/scripts/write_models.php

$modelDir = __DIR__ . '/../../app/Models/';

$models = [];

// TourMau
$models['TourMau.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: tour_maus – Tour mẫu (template tour) */
class TourMau extends BaseModel
{
    protected $table      = 'tour_maus';
    protected $primaryKey = 'ma_tour_mau';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function lichTrinhTours()
    {
        return $this->hasMany(LichTrinhTour::class, 'ma_tour_mau', 'ma_tour_mau');
    }

    public function tourThucTes()
    {
        return $this->hasMany(TourThucTe::class, 'ma_tour_mau', 'ma_tour_mau');
    }
}
PHP;

// DonDatTour
$models['DonDatTour.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: don_dat_tours – Đơn đặt tour của khách hàng */
class DonDatTour extends BaseModel
{
    protected $table      = 'don_dat_tours';
    protected $primaryKey = 'ma_dat_tour';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }

    public function chiTietDatTours()
    {
        return $this->hasMany(ChiTietDatTour::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function chiTietDichVus()
    {
        return $this->hasMany(ChiTietDichVu::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function datTourUuDai()
    {
        return $this->hasOne(DatTourUuDai::class, 'ma_dat_tour', 'ma_dat_tour');
    }
}
PHP;

// ChiTietDatTour
$models['ChiTietDatTour.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: chi_tiet_dat_tours – Chi tiết hành khách trong đơn đặt tour */
class ChiTietDatTour extends BaseModel
{
    protected $table      = 'chi_tiet_dat_tours';
    protected $primaryKey = 'ma_chi_tiet_dat';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function donDatTour()
    {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }

    public function nguoiDongHanh()
    {
        return $this->belongsTo(DsNguoiDongHanh::class, 'ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh');
    }
}
PHP;

// ChiTietDichVu
$models['ChiTietDichVu.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: chi_tiet_dich_vus – Dịch vụ thêm trong đơn đặt tour */
class ChiTietDichVu extends BaseModel
{
    protected $table      = 'chi_tiet_dich_vus';
    protected $primaryKey = 'ma_chi_tiet_dich_vu';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function donDatTour()
    {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function dichVuThem()
    {
        return $this->belongsTo(DichVuThem::class, 'ma_dich_vu_them', 'ma_dich_vu_them');
    }
}
PHP;

// DanhGiaKh
$models['DanhGiaKh.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: danh_gia_khs – Đánh giá của khách hàng sau tour */
class DanhGiaKh extends BaseModel
{
    protected $table      = 'danh_gia_khs';
    protected $primaryKey = 'ma_danh_gia_khach_hang';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }
}
PHP;

// DatTourUuDai
$models['DatTourUuDai.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: dat_tour_uu_dais – Voucher/ưu đãi áp dụng cho đơn đặt tour */
class DatTourUuDai extends BaseModel
{
    protected $table   = 'dat_tour_uu_dais';
    protected $guarded = [];

    public function donDatTour()
    {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'ma_voucher', 'ma_voucher');
    }
}
PHP;

// DichVuThem
$models['DichVuThem.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: dich_vu_thems – Dịch vụ bổ sung (vé tham quan, bảo hiểm...) */
class DichVuThem extends BaseModel
{
    protected $table      = 'dich_vu_thems';
    protected $primaryKey = 'ma_dich_vu_them';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// DichVuTourThucTe
$models['DichVuTourThucTe.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: dich_vu_tour_thuc_tes – Bảng trung gian dịch vụ - tour thực tế */
class DichVuTourThucTe extends BaseModel
{
    protected $table   = 'dich_vu_tour_thuc_tes';
    protected $guarded = [];
}
PHP;

// DiemDanh
$models['DiemDanh.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: diem_danhs – Điểm danh hành khách trong tour */
class DiemDanh extends BaseModel
{
    protected $table      = 'diem_danhs';
    protected $primaryKey = 'ma_diem_danh';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }

    public function nguoiDongHanh()
    {
        return $this->belongsTo(DsNguoiDongHanh::class, 'ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien');
    }
}
PHP;

// DsNguoiDongHanh
$models['DsNguoiDongHanh.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: ds_nguoi_dong_hanhs – Danh sách người đồng hành (không có tài khoản) */
class DsNguoiDongHanh extends BaseModel
{
    protected $table      = 'ds_nguoi_dong_hanhs';
    protected $primaryKey = 'ma_nguoi_dong_hanh';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// GiaoDich
$models['GiaoDich.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: giao_diches – Giao dịch thanh toán */
class GiaoDich extends BaseModel
{
    protected $table      = 'giao_diches';
    protected $primaryKey = 'ma_giao_dich';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// hanh_dong
$models['hanh_dong.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: hanh_dongs – Ghi nhận hành động xanh của khách hàng trong tour */
class hanh_dong extends BaseModel
{
    protected $table      = 'hanh_dongs';
    protected $primaryKey = 'ma_ghi_nhan_hanh_dong';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }

    public function hanhDongXanh()
    {
        return $this->belongsTo(hanh_dong_xanh::class, 'ma_hanh_dong_xanh', 'ma_hanh_dong_xanh');
    }

    public function nhanVienXacMinh()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien_xac_minh', 'ma_nhan_vien');
    }
}
PHP;

// hanh_dong_xanh
$models['hanh_dong_xanh.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: hanh_dong_xanhs – Danh mục hành động xanh và điểm thưởng */
class hanh_dong_xanh extends BaseModel
{
    protected $table      = 'hanh_dong_xanhs';
    protected $primaryKey = 'ma_hanh_dong_xanh';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// HdxTourThucTe
$models['HdxTourThucTe.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: hdx_tour_thuc_tes – Bảng trung gian hành động xanh - tour thực tế */
class HdxTourThucTe extends BaseModel
{
    protected $table   = 'hdx_tour_thuc_tes';
    protected $guarded = [];
}
PHP;

// HoChieuSo
$models['HoChieuSo.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: ho_chieu_sos – Hồ sơ khách hàng (thông tin sức khỏe, hạng thành viên) */
class HoChieuSo extends BaseModel
{
    protected $table      = 'ho_chieu_sos';
    protected $primaryKey = 'ma_khach_hang';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan');
    }
}
PHP;

// KhuyenMaiKh
$models['KhuyenMaiKh.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: khuyen_mai_khs – Ví voucher của khách hàng */
class KhuyenMaiKh extends BaseModel
{
    protected $table   = 'khuyen_mai_khs';
    protected $guarded = [];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'ma_voucher', 'ma_voucher');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }
}
PHP;

// LichSuTour
$models['LichSuTour.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: lich_su_tours – Lịch sử tham gia tour của khách hàng */
class LichSuTour extends BaseModel
{
    protected $table      = 'lich_su_tours';
    protected $primaryKey = 'ma_lich_su_tour';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function chiTietDatTour()
    {
        return $this->belongsTo(ChiTietDatTour::class, 'ma_chi_tiet_dat', 'ma_chi_tiet_dat');
    }
}
PHP;

// LichTrinhTour
$models['LichTrinhTour.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: lich_trinh_tours – Lịch trình chi tiết theo ngày của tour mẫu */
class LichTrinhTour extends BaseModel
{
    protected $table      = 'lich_trinh_tours';
    protected $primaryKey = 'ma_lich_trinh_tour';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// NangLucNhanVien
$models['NangLucNhanVien.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: nang_luc_nhan_viens – Năng lực và chứng chỉ của nhân viên */
class NangLucNhanVien extends BaseModel
{
    protected $table      = 'nang_luc_nhan_viens';
    protected $primaryKey = 'ma_nang_luc_nhan_vien';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// NhanVien
$models['NhanVien.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: nhan_viens – Thông tin nhân viên hệ thống */
class NhanVien extends BaseModel
{
    protected $table      = 'nhan_viens';
    protected $primaryKey = 'ma_nhan_vien';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan');
    }
}
PHP;

// NhatKyDoiDiem
$models['NhatKyDoiDiem.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: nhat_ky_doi_diems – Lịch sử đổi điểm xanh thành voucher */
class NhatKyDoiDiem extends BaseModel
{
    protected $table      = 'nhat_ky_doi_diems';
    protected $primaryKey = 'ma_nhat_ky_doi_diem';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// NhatKyHeThong
$models['NhatKyHeThong.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: nhat_ky_he_thongs – Nhật ký audit log hệ thống */
class NhatKyHeThong extends BaseModel
{
    protected $table      = 'nhat_ky_he_thongs';
    protected $primaryKey = 'ma_nhat_ky_he_thong';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// NhatKySuCo
$models['NhatKySuCo.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: nhat_ky_su_cos – Nhật ký sự cố phát sinh trong tour */
class NhatKySuCo extends BaseModel
{
    protected $table      = 'nhat_ky_su_cos';
    protected $primaryKey = 'ma_nhat_ky_su_co';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function nhanVienBaoCao()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien_bao_cao', 'ma_nhan_vien');
    }

    public function khachHang()
    {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang');
    }

    public function nguoiDongHanh()
    {
        return $this->belongsTo(DsNguoiDongHanh::class, 'ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh');
    }
}
PHP;

// PhanCongTour
$models['PhanCongTour.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: phan_cong_tours – Phân công hướng dẫn viên cho tour thực tế */
class PhanCongTour extends BaseModel
{
    protected $table      = 'phan_cong_tours';
    protected $primaryKey = 'ma_phan_cong_tour';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien');
    }
}
PHP;

// QuyetToan
$models['QuyetToan.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: quyet_toans – Quyết toán tài chính sau khi tour kết thúc */
class QuyetToan extends BaseModel
{
    protected $table      = 'quyet_toans';
    protected $primaryKey = 'ma_quyet_toan';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];

    public function tourThucTe()
    {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien');
    }
}
PHP;

// vai_tro
$models['vai_tro.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: vai_tros – Danh mục vai trò người dùng */
class vai_tro extends BaseModel
{
    protected $table      = 'vai_tros';
    protected $primaryKey = 'ma_vai_tro';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// Voucher
$models['Voucher.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: vouchers – Mã giảm giá/ưu đãi */
class Voucher extends BaseModel
{
    protected $table      = 'vouchers';
    protected $primaryKey = 'ma_voucher';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// YeuCauHoTro
$models['YeuCauHoTro.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: yeu_cau_ho_tros – Yêu cầu hỗ trợ / khiếu nại của khách hàng */
class YeuCauHoTro extends BaseModel
{
    protected $table      = 'yeu_cau_ho_tros';
    protected $primaryKey = 'ma_yeu_cau_ho_tro';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// ChiPhiThucTe
$models['ChiPhiThucTe.php'] = <<<'PHP'
<?php

namespace App\Models;

/** Bảng: chi_phi_thuc_tes – Chi phí thực tế phát sinh trong tour */
class ChiPhiThucTe extends BaseModel
{
    protected $table      = 'chi_phi_thuc_tes';
    protected $primaryKey = 'ma_chi_phi_thuc_te';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
}
PHP;

// Ghi tất cả files
foreach ($models as $filename => $content) {
    $filePath = $modelDir . $filename;
    file_put_contents($filePath, $content);
    echo "Đã viết: $filename\n";
}

echo "\nHoàn thành! Đã cập nhật " . count($models) . " models.\n";
