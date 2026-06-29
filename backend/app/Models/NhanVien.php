<?php

namespace App\Models;

// Model lưu thông tin nhân viên.
class NhanVien extends BaseModel
{
    protected $table = 'nhan_viens';
    protected $primaryKey = 'ma_nhan_vien';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function taiKhoan() {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan'); 
    }

    public function getRouteKeyName()
    {
        return 'ma_nhan_vien';
    }
}
