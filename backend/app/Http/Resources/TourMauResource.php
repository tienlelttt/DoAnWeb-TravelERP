<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourMauResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maTourMau' => $this->ma_tour_mau,
            'tieuDe' => $this->tieu_de,
            'moTa' => $this->mo_ta,
            'thoiLuong' => (int) $this->thoi_luong,
            'giaSan' => (float) $this->gia_san,
            'danhGia' => $this->danh_gia ? (float) $this->danh_gia : null,
            'soDanhGia' => $this->so_danh_gia ? (int) $this->so_danh_gia : null,
        ];
    }
}
