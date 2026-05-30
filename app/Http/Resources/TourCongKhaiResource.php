<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourCongKhaiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maTourThucTe' => $this->MaTourThucTe,
            'maTourMau' => $this->MaTourMau,
            'tieuDeTour' => $this->tourMau ? $this->tourMau->TieuDe : null,
            'moTa' => $this->tourMau ? $this->tourMau->MoTa : null,
            'ngayKhoiHanh' => \Carbon\Carbon::parse($this->NgayKhoiHanh)->format('Y-m-d'),
            'thoiLuong' => $this->tourMau ? (int) $this->tourMau->ThoiLuong : null,
            'giaHienHanh' => (float) $this->GiaHienHanh,
            'soKhachToiDa' => (int) $this->SoKhachToiDa,
            'choConLai' => (int) $this->ChoConLai,
            'trangThai' => $this->TrangThai,
            'diemDanhGia' => $this->tourMau ? ($this->tourMau->DanhGia ? (float) $this->tourMau->DanhGia : null) : null,
            'soDanhGia' => $this->tourMau ? ($this->tourMau->SoDanhGia ? (int) $this->tourMau->SoDanhGia : null) : null,
            'lichTrinh' => $this->tourMau ? LichTrinhResource::collection($this->tourMau->lichTrinhTours) : [],
            // Skip dichVu and hanhDongXanh for now
            'dichVu' => [],
            'hanhDongXanh' => [],
        ];
    }
}
