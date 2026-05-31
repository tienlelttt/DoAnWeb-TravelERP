<?php

namespace App\Models;

class PhanCongTour extends BaseModel
{
    protected $table = 'phan_cong_tours';
    protected $primaryKey = 'ma_phan_cong_tour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien'); 
    }
}
