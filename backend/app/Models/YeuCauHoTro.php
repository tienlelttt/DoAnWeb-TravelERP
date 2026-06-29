<?php

namespace App\Models;

// Model lưu thông tin yêu cầu hỗ trợ.
class YeuCauHoTro extends BaseModel
{
    protected $table = 'yeu_cau_ho_tros';
    protected $primaryKey = 'ma_yeu_cau_ho_tro';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function donDatTour() {
        return $this->belongsTo(DonDatTour::class, 'ma_dat_tour', 'ma_dat_tour'); 
    }

    public function khachHang() {
        return $this->belongsTo(HoChieuSo::class, 'ma_khach_hang', 'ma_khach_hang'); 
    }

    public function nhanVienXuLy() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien_xu_ly', 'ma_nhan_vien_xu_ly'); 
    }
}
