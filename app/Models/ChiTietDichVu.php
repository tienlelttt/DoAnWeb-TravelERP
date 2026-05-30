<?php

namespace App\Models;

class ChiTietDichVu extends BaseModel
{
    protected $table = 'CHITIETDICHVU';
    protected $primaryKey = 'MaChiTietDichVu';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'MaDatTour', 'MaDatTour'); 
    }

    public function dichVuThem() {
        return $this->belongsTo(DichVuThem::class, 'MaDichVuThem', 'MaDichVuThem'); 
    }
}
