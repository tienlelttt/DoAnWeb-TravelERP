<?php

namespace App\Models;

// Model lưu thông tin dữ liệu.
class ChiTietDichVu extends BaseModel
{
    protected $table = 'chi_tiet_dich_vus';
    protected $primaryKey = 'ma_chi_tiet_dich_vu';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour'); 
    }

    public function dichVuThem() {
        return $this->belongsTo(DichVuThem::class, 'ma_dich_vu_them', 'ma_dich_vu_them'); 
    }
}
