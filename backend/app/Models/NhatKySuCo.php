<?php

namespace App\Models;

// Model lưu thông tin sự cố.
class NhatKySuCo extends BaseModel
{
    protected $table = 'nhat_ky_su_cos';
    protected $primaryKey = 'ma_nhat_ky_su_co';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function nhanVienBaoCao() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien_bao_cao', 'ma_nhan_vien_bao_cao'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function nguoiDongHanh() {
        return $this->belongsTo(DsNguoiDongHanh::class, 'ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh'); 
    }
}
