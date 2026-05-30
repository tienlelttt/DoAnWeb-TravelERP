<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class GiaoDichResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maGiaoDich' => $this->MaGiaoDich,
            'maDatTour' => $this->MaDatTour,
            'loaiGiaoDich' => $this->LoaiGiaoDich,
            'phuongThuc' => $this->PhuongThuc,
            'soTien' => (float) $this->SoTien,
            'maGDNH' => $this->MaGDNH,
            'trangThai' => $this->TrangThai,
            'ngayThanhToan' => $this->NgayThanhToan ? Carbon::parse($this->NgayThanhToan)->format('Y-m-d H:i:s') : null,
        ];
    }
}
