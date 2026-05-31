<?php

namespace App\Models;

class TourMau extends BaseModel
{
    protected $table = 'tour_maus';
    protected $primaryKey = 'ma_tour_mau';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function lichTrinhTours()
    {
        return $this->hasMany(LichTrinhTour::class, 'ma_tour_mau', 'ma_tour_mau');
    }

    public function tourThucTes()
    {
        return $this->hasMany(TourThucTe::class, 'ma_tour_mau', 'ma_tour_mau');
    }
}
