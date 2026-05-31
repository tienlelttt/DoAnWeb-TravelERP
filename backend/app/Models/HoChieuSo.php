<?php

namespace App\Models;

class HoChieuSo extends BaseModel
{
    protected $table = 'ho_chieu_sos';
    protected $primaryKey = 'ma_khach_hang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function taiKhoan() {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan'); 
    }
}
