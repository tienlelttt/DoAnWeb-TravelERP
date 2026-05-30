<?php

namespace App\Models;

class HanhDongXanh extends BaseModel
{
    protected $table = 'HANHDONGXANH';
    protected $primaryKey = 'MaHanhDongXanh';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTes()
    {
        return $this->belongsToMany(TourThucTe::class, 'HDX_TOURTHUCTE', 'MaHanhDongXanh', 'MaTourThucTe');
    }
}
