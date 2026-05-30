<?php

namespace App\Models;

class HoChieuSo extends BaseModel
{
    protected $table = 'HOCHIEUSO';
    protected $primaryKey = 'MaKhachHang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function taiKhoan() {
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan', 'MaTaiKhoan'); 
    }
}
