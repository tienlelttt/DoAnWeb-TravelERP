<?php

namespace App\Models;

class PhanCongTour extends BaseModel
{
    protected $table = 'PHANCONGTOUR';
    protected $primaryKey = 'MaPhanCongTour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien'); 
    }
}
