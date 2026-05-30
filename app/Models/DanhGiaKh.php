<?php

namespace App\Models;

class DanhGiaKh extends BaseModel
{
    protected $table = 'DANHGIAKH';
    protected $primaryKey = 'MaDanhGiaKhachHang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }
}
