<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Model lưu thông tin dịch vụ bổ sung.
class DichVuThemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maDichVuThem' => $this->ma_dich_vu_them,
            'ten' => $this->ten,
            'donViTinh' => $this->don_vi_tinh,
            'donGia' => (float) $this->don_gia,
        ];
    }
}
