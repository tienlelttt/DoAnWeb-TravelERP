<?php

namespace App\Models;

class NhatKyHeThong extends BaseModel
{
    protected $table = 'NHATKYHETHONG';
    protected $primaryKey = 'MaNhatKyHeThong';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function taiKhoan() {
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan', 'MaTaiKhoan'); 
    }
}
