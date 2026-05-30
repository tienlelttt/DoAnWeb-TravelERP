<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LichTrinhResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maLichTrinhTour' => $this->MaLichTrinhTour,
            'ngayThu' => (int) $this->NgayThu,
            'hoatDong' => $this->HoatDong,
            'moTa' => $this->MoTa,
            'thucDon' => $this->ThucDon,
        ];
    }
}
