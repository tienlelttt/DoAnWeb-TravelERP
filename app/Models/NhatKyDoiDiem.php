<?php

namespace App\Models;

class NhatKyDoiDiem extends BaseModel
{
    protected $table = 'NHATKYDOIDIEM';
    protected $primaryKey = 'MaNhatKyDoiDiem';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'MaVoucher', 'MaVoucher'); 
    }
}
