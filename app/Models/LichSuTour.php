<?php

namespace App\Models;

class LichSuTour extends BaseModel
{
    protected $table = 'LICHSUTOUR';
    protected $primaryKey = 'MaLichSuTour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function chiTietDatTour() {
        return $this->belongsTo(ChiTietDatTour::class, 'MaChiTietDat', 'MaChiTietDat'); 
    }
}
