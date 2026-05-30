<?php

namespace App\Models;

class HanhDong extends BaseModel
{
    protected $table = 'HANHDONG';
    protected $primaryKey = 'MaGhiNhanHanhDong';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function hanhDongXanh() {
        return $this->belongsTo(HanhDongXanh::class, 'MaHanhDongXanh', 'MaHanhDongXanh'); 
    }

    public function nhanVienXacMinh() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienXacMinh', 'MaNhanVienXacMinh'); 
    }
}
