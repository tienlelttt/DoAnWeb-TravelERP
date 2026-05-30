<?php

namespace App\Models;

class NhatKySuCo extends BaseModel
{
    protected $table = 'NHATKYSUCO';
    protected $primaryKey = 'MaNhatKySuCo';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'MaTourThucTe', 'MaTourThucTe'); 
    }

    public function nhanVienBaoCao() {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienBaoCao', 'MaNhanVienBaoCao'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'MaKhachHang', 'MaKhachHang'); 
    }

    public function nguoiDongHanh() {
        return $this->belongsTo(DsNguoiDongHanh::class, 'MaNguoiDongHanh', 'MaNguoiDongHanh'); 
    }
}
