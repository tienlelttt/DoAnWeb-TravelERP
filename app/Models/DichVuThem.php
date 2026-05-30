<?php

namespace App\Models;

class DichVuThem extends BaseModel
{
    protected $table = 'DICHVUTHEM';
    protected $primaryKey = 'MaDichVuThem';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTes()
    {
        return $this->belongsToMany(TourThucTe::class, 'DICHVU_TOURTHUCTE', 'MaDichVuThem', 'MaTourThucTe');
    }
}
