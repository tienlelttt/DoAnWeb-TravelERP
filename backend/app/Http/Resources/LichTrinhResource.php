<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LichTrinhResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maLichTrinhTour' => $this->ma_lich_trinh_tour,
            'ngayThu' => (int) $this->ngay_thu,
            'hoatDong' => $this->hoat_dong,
            'moTa' => $this->mo_ta,
            'thucDon' => $this->thuc_don,
        ];
    }
}
