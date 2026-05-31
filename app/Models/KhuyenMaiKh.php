<?php

namespace App\Models;

class KhuyenMaiKh extends BaseModel
{
    protected $table = 'khuyen_mai_khs';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'ma_voucher', 'ma_voucher'); 
    }
}
