<?php

namespace App\Models;

// Model lưu thông tin đơn đặt tour.
class DonDatTour extends BaseModel
{
    protected $table = 'don_dat_tours';
    protected $primaryKey = 'ma_dat_tour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function chiTietDatTours() {
        return $this->hasMany(ChiTietDatTour::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function chiTietDichVus() {
        return $this->hasMany(ChiTietDichVu::class, 'ma_dat_tour', 'ma_dat_tour');
    }

    public function datTourUuDai() {
        return $this->hasOne(DatTourUuDai::class, 'ma_dat_tour', 'ma_dat_tour');
    }
}
