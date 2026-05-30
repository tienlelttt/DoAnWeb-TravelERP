<?php

namespace App\Models;

class DatTourUuDai extends BaseModel
{
    protected $table = 'DATTOUR_UUDAI';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'MaDatTour', 'MaDatTour'); 
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'MaVoucher', 'MaVoucher'); 
    }
}
