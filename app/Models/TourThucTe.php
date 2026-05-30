<?php

namespace App\Models;

class TourThucTe extends BaseModel
{
    protected $table = 'TOURTHUCTE';
    protected $primaryKey = 'MaTourThucTe';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourMau()
    {
        return $this->belongsTo(TourMau::class, 'MaTourMau', 'MaTourMau');
    }

    public function dichVuThems()
    {
        return $this->belongsToMany(DichVuThem::class, 'DICHVU_TOURTHUCTE', 'MaTourThucTe', 'MaDichVuThem')->withTimestamps();
    }

    public function hanhDongXanhs()
    {
        return $this->belongsToMany(HanhDongXanh::class, 'HDX_TOURTHUCTE', 'MaTourThucTe', 'MaHanhDongXanh')->withTimestamps();
    }
}
