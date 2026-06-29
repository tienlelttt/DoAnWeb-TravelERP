<?php

namespace App\Models;

// Model lưu thông tin đơn đặt tour.
class ChiTietDatTour extends BaseModel
{
    protected $table = 'chi_tiet_dat_tours';
    protected $primaryKey = 'ma_chi_tiet_dat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function nguoiDongHanh() {
        return $this->belongsTo(DsNguoiDongHanh::class, 'ma_nguoi_dong_hanh', 'ma_nguoi_dong_hanh'); 
    }
}
