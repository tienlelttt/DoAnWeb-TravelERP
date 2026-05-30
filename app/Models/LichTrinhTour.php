<?php

namespace App\Models;

class LichTrinhTour extends BaseModel
{
    protected $table = 'LICHTRINHTOUR';
    protected $primaryKey = 'MaLichTrinhTour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourMau()
    {
        return $this->belongsTo(TourMau::class, 'MaTourMau', 'MaTourMau');
    }
}
