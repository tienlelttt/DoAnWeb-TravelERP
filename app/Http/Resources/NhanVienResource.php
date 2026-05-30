<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NhanVienResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'maNhanVien' => $this->MaNhanVien,
            'loaiNhanVien' => $this->LoaiNhanVien,
            'trangThaiLamViec' => $this->TrangThaiLamViec,
            'taiKhoan' => [
                'hoTen' => $this->taiKhoan->HoTen ?? null,
                'email' => $this->taiKhoan->Email ?? null,
                'soDienThoai' => $this->taiKhoan->SoDienThoai ?? null,
                'vaiTro' => $this->taiKhoan->VaiTro ?? null,
                'trangThai' => $this->taiKhoan->TrangThai ?? null,
            ]
        ];
    }
}
