<?php

namespace App\Models;

class QuyetToan extends BaseModel
{
    protected $table = 'QUYETTOAN';
    protected $primaryKey = 'MaQuyetToan';
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
