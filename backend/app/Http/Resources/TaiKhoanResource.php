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
            'maTaiKhoan' => $this->ma_tai_khoan,
            'tenDangNhap' => $this->ten_dang_nhap,
            'hoTen' => $this->ho_ten,
            'cccd' => $this->cccd,
            'ngaySinh' => $this->ngay_sinh ? $this->ngay_sinh->format('Y-m-d') : null,
            'email' => $this->email,
            'soDienThoai' => $this->so_dien_thoai,
            'vaiTro' => $this->vai_tro,
            'trangThai' => $this->trang_thai,
            'createdAt' => $this->created_at ? $this->created_at->format('Y-m-d\TH:i:s') : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->format('Y-m-d\TH:i:s') : null,
        ];
    }
}
