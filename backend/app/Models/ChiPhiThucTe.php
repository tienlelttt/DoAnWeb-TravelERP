<?php

namespace App\Models;

// Model lưu thông tin chi phí thực tế.
class ChiPhiThucTe extends BaseModel
{
    protected $table = 'chi_phi_thuc_tes';
    protected $primaryKey = 'ma_chi_phi_thuc_te';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourThucTe() {
        return $this->belongsTo(TourThucTe::class, 'ma_tour_thuc_te', 'ma_tour_thuc_te'); 
    }

    public function nhanVien() {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'ma_nhan_vien'); 
    }
}
