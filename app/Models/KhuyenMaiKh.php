<?php

namespace App\Models;

class KhuyenMaiKh extends BaseModel
{
    protected $table = 'KHUYENMAI_KH';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'MaVoucher', 'MaVoucher'); 
    }
}
