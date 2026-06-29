<?php

namespace App\Models;

// Model lưu thông tin nhân viên.
class NangLucNhanVien extends BaseModel
{
    protected $table = 'nang_luc_nhan_viens';
    protected $primaryKey = 'ma_nang_luc_nhan_vien';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien'); 
    }
}
