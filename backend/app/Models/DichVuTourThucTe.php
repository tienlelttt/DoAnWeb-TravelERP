<?php

namespace App\Models;

class DichVuTourThucTe extends BaseModel
{
    protected $table = 'dich_vu_tour_thuc_tes';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function dichVuThem() {
        return $this->belongsTo(DichVuThem::class, 'ma_dich_vu_them', 'ma_dich_vu_them'); 
    }
}
