<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DanhGiaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maDanhGia' => $this->MaDanhGiaKhachHang,
            'maTourThucTe' => $this->MaTourThucTe,
            'tieuDeTour' => $this->tourThucTe && $this->tourThucTe->tourMau ? $this->tourThucTe->tourMau->TieuDe : null,
            'maKhachHang' => $this->MaKhachHang,
            'hoTenKhachHang' => $this->khachHang && $this->khachHang->taiKhoan ? $this->khachHang->taiKhoan->HoTen : null,
            'soSao' => (int) $this->SoSao,
            'nhanXet' => $this->NhanXet,
            'ngayDanhGia' => $this->NgayDanhGia ? \Carbon\Carbon::parse($this->NgayDanhGia)->format('Y-m-d H:i:s') : null,
        ];
    }
}
