<?php

namespace App\Models;

class NangLucNhanVien extends BaseModel
{
    protected $table = 'NANGLUCNHANVIEN';
    protected $primaryKey = 'MaNangLucNhanVien';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien'); 
    }
}
