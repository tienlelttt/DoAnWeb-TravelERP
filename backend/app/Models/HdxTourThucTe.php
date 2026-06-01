<?php

namespace App\Models;

class HdxTourThucTe extends BaseModel
{
    protected $table = 'hdx_tour_thuc_tes';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function hanhDongXanh() {
        return $this->belongsTo(HanhDongXanh::class, 'ma_hanh_dong_xanh', 'ma_hanh_dong_xanh'); 
    }
}
