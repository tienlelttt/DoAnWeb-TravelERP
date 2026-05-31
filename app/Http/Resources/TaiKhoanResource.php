<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaiKhoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'maTaiKhoan' => $this->MaTaiKhoan,
            'tenDangNhap' => $this->TenDangNhap,
            'hoTen' => $this->HoTen,
            'cccd' => $this->CCCD,
            'ngaySinh' => $this->NgaySinh ? $this->NgaySinh->format('Y-m-d') : null,
            'email' => $this->Email,
            'soDienThoai' => $this->SoDienThoai,
            'vaiTro' => $this->VaiTro,
            'trangThai' => $this->TrangThai,
            'createdAt' => $this->created_at ? $this->created_at->format('Y-m-d\TH:i:s') : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->format('Y-m-d\TH:i:s') : null,
        ];
    }
}
