<?php

namespace App\Models;

class ChiPhiThucTe extends BaseModel
{
    protected $table = 'CHIPHITHUCTE';
    protected $primaryKey = 'MaChiPhiThucTe';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien'); 
    }
}
