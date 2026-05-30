<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DichVuThemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maDichVuThem' => $this->MaDichVuThem,
            'ten' => $this->Ten,
            'donViTinh' => $this->DonViTinh,
            'donGia' => (float) $this->DonGia,
        ];
    }
}
