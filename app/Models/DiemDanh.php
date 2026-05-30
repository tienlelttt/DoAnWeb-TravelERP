<?php

namespace App\Models;

class DiemDanh extends BaseModel
{
    protected $table = 'DIEMDANH';
    protected $primaryKey = 'MaDiemDanh';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function nguoiDongHanh() {
        return $this->belongsTo(DsNguoiDongHanh::class, 'MaNguoiDongHanh', 'MaNguoiDongHanh'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien'); 
    }
}
