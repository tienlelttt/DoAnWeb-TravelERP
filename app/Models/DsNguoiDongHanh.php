<?php

namespace App\Models;

class DsNguoiDongHanh extends BaseModel
{
    protected $table = 'DSNGUOIDONGHANH';
    protected $primaryKey = 'MaNguoiDongHanh';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'MaDatTour', 'MaDatTour'); 
    }
}
