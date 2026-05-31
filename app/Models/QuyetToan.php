<?php

namespace App\Models;

class QuyetToan extends BaseModel
{
    protected $table = 'quyet_toans';
    protected $primaryKey = 'ma_quyet_toan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien'); 
    }
}
