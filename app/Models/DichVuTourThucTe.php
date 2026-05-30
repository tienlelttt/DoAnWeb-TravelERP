<?php

namespace App\Models;

class DichVuTourThucTe extends BaseModel
{
    protected $table = 'DICHVU_TOURTHUCTE';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function dichVuThem() {
        return $this->belongsTo(DichVuThem::class, 'MaDichVuThem', 'MaDichVuThem'); 
    }
}
