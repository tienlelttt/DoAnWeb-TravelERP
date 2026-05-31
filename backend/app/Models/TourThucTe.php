<?php

namespace App\Models;

class TourThucTe extends BaseModel
{
    protected $table = 'tour_thuc_tes';
    protected $primaryKey = 'ma_tour_thuc_te';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourMau()
    {
        return $this->belongsTo(TourMau::class, 'ma_tour_mau', 'ma_tour_mau');
    }

    public function dichVuThems()
    {
        return $this->belongsToMany(DichVuThem::class, 'dich_vu_tour_thuc_tes', 'ma_tour_thuc_te', 'ma_dich_vu_them')->withTimestamps();
    }

    public function hanhDongXanhs()
    {
        return $this->belongsToMany(HanhDongXanh::class, 'hdx_tour_thuc_tes', 'ma_tour_thuc_te', 'ma_hanh_dong_xanh')->withTimestamps();
    }
}
