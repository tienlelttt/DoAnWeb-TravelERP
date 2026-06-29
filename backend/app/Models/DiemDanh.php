<?php

namespace App\Models;

// Model lưu thông tin điểm danh khách hàng.
class DiemDanh extends BaseModel
{
    protected $table = 'diem_danhs';
    protected $primaryKey = 'ma_diem_danh';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function nguoiDongHanh() {
        return $this->belongsTo(DsNguoiDongHanh::class, 'ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien'); 
    }
}
