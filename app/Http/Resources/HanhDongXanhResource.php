<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HanhDongXanhResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Lấy maTourThucTe đầu tiên nếu có liên kết
        $maTourThucTe = null;
        if ($this->relationLoaded('tourThucTes') && $this->tourThucTes->isNotEmpty()) {
            $maTourThucTe = $this->tourThucTes->first()->ma_tour_thuc_te;
        }

        return [
            'maHanhDongXanh' => $this->ma_hanh_dong_xanh,
            'maTourThucTe' => $maTourThucTe,
            'tenHanhDong' => $this->ten_hanh_dong,
            'diemCong' => (int) $this->diem_cong,
        ];
    }
}
