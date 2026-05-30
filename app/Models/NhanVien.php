<?php

namespace App\Models;

class NhanVien extends BaseModel
{
    protected $table = 'NHANVIEN';
    protected $primaryKey = 'MaNhanVien';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function taiKhoan() {
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan', 'MaTaiKhoan'); 
    }
}
