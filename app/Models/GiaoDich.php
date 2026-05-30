<?php

namespace App\Models;

class GiaoDich extends BaseModel
{
    protected $table = 'GIAODICH';
    protected $primaryKey = 'MaGiaoDich';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'MaDatTour', 'MaDatTour'); 
    }
}
