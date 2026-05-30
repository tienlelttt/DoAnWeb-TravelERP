<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourThucTeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maTourThucTe' => $this->MaTourThucTe,
            'maTourMau' => $this->MaTourMau,
            'tieuDeTour' => $this->tourMau ? $this->tourMau->TieuDe : null,
            'ngayKhoiHanh' => \Carbon\Carbon::parse($this->NgayKhoiHanh)->format('Y-m-d'),
            // NgayKetThuc = NgayKhoiHanh + ThoiLuong (của TourMau)
            'ngayKetThuc' => $this->tourMau ? \Carbon\Carbon::parse($this->NgayKhoiHanh)->addDays($this->tourMau->ThoiLuong - 1)->format('Y-m-d') : null,
            'giaHienHanh' => (float) $this->GiaHienHanh,
            'soKhachToiDa' => (int) $this->SoKhachToiDa,
            'soKhachToiThieu' => (int) $this->SoKhachToiThieu,
            'choConLai' => (int) $this->ChoConLai,
            'trangThai' => $this->TrangThai,
            'thoiLuong' => $this->tourMau ? (int) $this->tourMau->ThoiLuong : null,
            'diemDanhGia' => $this->tourMau ? ($this->tourMau->DanhGia ? (float) $this->tourMau->DanhGia : null) : null,
            'soDanhGia' => $this->tourMau ? ($this->tourMau->SoDanhGia ? (int) $this->tourMau->SoDanhGia : null) : null,
            // Skip dichVu and hanhDongXanh for now
            'dichVu' => [],
            'hanhDongXanh' => [],
        ];
    }
}
