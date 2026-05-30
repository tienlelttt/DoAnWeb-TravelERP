<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourMauChiTietResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maTourMau' => $this->MaTourMau,
            'tieuDe' => $this->TieuDe,
            'moTa' => $this->MoTa,
            'thoiLuong' => (int) $this->ThoiLuong,
            'giaSan' => (float) $this->GiaSan,
            'danhGia' => $this->DanhGia ? (float) $this->DanhGia : null,
            'soDanhGia' => $this->SoDanhGia ? (int) $this->SoDanhGia : null,
            'lichTrinh' => LichTrinhResource::collection($this->whenLoaded('lichTrinhTours')),
        ];
    }
}
