<?php

namespace App\Models;

class DonDatTour extends BaseModel
{
    protected $table = 'DONDATTOUR';
    protected $primaryKey = 'MaDatTour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function chiTietDatTours() {
        return $this->hasMany(ChiTietDatTour::class, 'MaDatTour', 'MaDatTour');
    }

    public function chiTietDichVus() {
        return $this->hasMany(ChiTietDichVu::class, 'MaDatTour', 'MaDatTour');
    }
}
