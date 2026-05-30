<?php

namespace App\Models;

class TourMau extends BaseModel
{
    protected $table = 'TOURMAU';
    protected $primaryKey = 'MaTourMau';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function lichTrinhTours()
    {
        return $this->hasMany(LichTrinhTour::class, 'MaTourMau', 'MaTourMau');
    }

    public function tourThucTes()
    {
        return $this->hasMany(TourThucTe::class, 'MaTourMau', 'MaTourMau');
    }
}
