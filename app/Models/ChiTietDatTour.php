<?php

namespace App\Models;

class ChiTietDatTour extends BaseModel
{
    protected $table = 'CHITIETDATTOUR';
    protected $primaryKey = 'MaChiTietDat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'MaDatTour', 'MaDatTour'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function nguoiDongHanh() {
        return $this->belongsTo(DsNguoiDongHanh::class, 'MaNguoiDongHanh', 'MaNguoiDongHanh'); 
    }
}
