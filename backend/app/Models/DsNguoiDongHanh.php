<?php

namespace App\Models;

// Model lưu thông tin dữ liệu.
class DsNguoiDongHanh extends BaseModel
{
    protected $table = 'ds_nguoi_dong_hanhs';
    protected $primaryKey = 'ma_nguoi_dong_hanh';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour'); 
    }
}
