<?php

namespace App\Models;

// Model lưu thông tin dịch vụ bổ sung.
class DichVuThem extends BaseModel
{
    protected $table = 'dich_vu_thems';
    protected $primaryKey = 'ma_dich_vu_them';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTes()
    {
        return $this->belongsToMany(TourThucTe::class, 'dich_vu_tour_thuc_tes', 'ma_dich_vu_them', 'ma_tour_thuc_te');
    }
}
