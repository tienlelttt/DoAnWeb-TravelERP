<?php

namespace App\Models;

class NhatKyHeThong extends BaseModel
{
    protected $table = 'nhat_ky_he_thongs';
    protected $primaryKey = 'ma_nhat_ky_he_thong';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function taiKhoan() {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan'); 
    }
}
