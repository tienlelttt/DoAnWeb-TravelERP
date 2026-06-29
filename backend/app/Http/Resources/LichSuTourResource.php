<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// Model lưu thông tin dữ liệu.
class LichSuTourResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'maLichSuTour' => $this->ma_lich_su_tour,
            'maKhachHang' => $this->ma_khach_hang,
            'maTourThucTe' => $this->ma_tour_thuc_te,
            'maChiTietDat' => $this->ma_chi_tiet_dat,
            'ngayThamGia' => $this->ngay_tham_gia ? Carbon::parse($this->ngay_tham_gia)->format('Y-m-d H:i:s') : null,
        ];
    }
}
