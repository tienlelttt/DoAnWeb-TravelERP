<?php

namespace App\Models;

class HdxTourThucTe extends BaseModel
{
    protected $table = 'HDX_TOURTHUCTE';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function hanhDongXanh() {
        return $this->belongsTo(HanhDongXanh::class, 'MaHanhDongXanh', 'MaHanhDongXanh'); 
    }
}
