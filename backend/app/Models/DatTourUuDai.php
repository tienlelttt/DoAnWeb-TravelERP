<?php

namespace App\Models;

// Model lưu thông tin đơn đặt tour.
class DatTourUuDai extends BaseModel
{
    protected $table = 'dat_tour_uu_dais';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour'); 
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'ma_voucher', 'ma_voucher'); 
    }
}
