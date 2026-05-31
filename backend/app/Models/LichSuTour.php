<?php

namespace App\Models;

class LichSuTour extends BaseModel
{
    protected $table = 'lich_su_tours';
    protected $primaryKey = 'ma_lich_su_tour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function chiTietDatTour() {
        return $this->belongsTo(ChiTietDatTour::class, 'ma_chi_tiet_dat', 'ma_chi_tiet_dat'); 
    }
}
