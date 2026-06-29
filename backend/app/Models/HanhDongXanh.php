<?php

namespace App\Models;

// Model lưu thông tin hành động xanh.
class HanhDongXanh extends BaseModel
{
    protected $table = 'hanh_dong_xanhs';
    protected $primaryKey = 'ma_hanh_dong_xanh';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTes()
    {
        return $this->belongsToMany(TourThucTe::class, 'hdx_tour_thuc_tes', 'ma_hanh_dong_xanh', 'ma_tour_thuc_te');
    }
}
