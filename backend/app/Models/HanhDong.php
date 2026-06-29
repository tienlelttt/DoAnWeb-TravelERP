<?php

namespace App\Models;

// Model lưu thông tin dữ liệu.
class HanhDong extends BaseModel
{
    protected $table = 'hanh_dongs';
    protected $primaryKey = 'ma_ghi_nhan_hanh_dong';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function hanhDongXanh() {
        return $this->belongsTo(HanhDongXanh::class, 'ma_hanh_dong_xanh', 'ma_hanh_dong_xanh'); 
    }

    public function nhanVienXacMinh() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien_xac_minh', 'ma_nhan_vien_xac_minh'); 
    }
}
