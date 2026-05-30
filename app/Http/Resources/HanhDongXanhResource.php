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
            $maTourThucTe = $this->tourThucTes->first()->MaTourThucTe;
        }

        return [
            'maHanhDongXanh' => $this->MaHanhDongXanh,
            'maTourThucTe' => $maTourThucTe,
            'tenHanhDong' => $this->TenHanhDong,
            'diemCong' => (int) $this->DiemCong,
        ];
    }
}
