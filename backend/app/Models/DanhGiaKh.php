<?php

namespace App\Models;

class DanhGiaKh extends BaseModel
{
    protected $table = 'danh_gia_khs';
    protected $primaryKey = 'ma_danh_gia_khach_hang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }
}
