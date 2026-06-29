<?php

namespace App\Models;

// Model lưu thông tin dữ liệu.
class GiaoDich extends BaseModel
{
    protected $table = 'giao_diches';
    protected $primaryKey = 'ma_giao_dich';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour'); 
    }
}
