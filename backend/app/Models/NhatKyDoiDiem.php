<?php

namespace App\Models;

class NhatKyDoiDiem extends BaseModel
{
    protected $table = 'nhat_ky_doi_diems';
    protected $primaryKey = 'ma_nhat_ky_doi_diem';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'ma_voucher', 'ma_voucher'); 
    }
}
