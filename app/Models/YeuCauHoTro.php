<?php

namespace App\Models;

class YeuCauHoTro extends BaseModel
{
    protected $table = 'YEUCAUHOTRO';
    protected $primaryKey = 'MaYeuCauHoTro';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'MaDatTour', 'MaDatTour'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function nhanVienXuLy() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienXuLy', 'MaNhanVienXuLy'); 
    }
}
