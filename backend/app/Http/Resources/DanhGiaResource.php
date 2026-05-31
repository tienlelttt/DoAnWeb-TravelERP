<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DanhGiaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maDanhGia' => $this->ma_danh_gia_khach_hang,
            'maTourThucTe' => $this->ma_tour_thuc_te,
            'tieuDeTour' => $this->tourThucTe && $this->tourThucTe->tourMau ? $this->tourThucTe->tourMau->tieu_de : null,
            'maKhachHang' => $this->ma_khach_hang,
            'hoTenKhachHang' => $this->khachHang && $this->khachHang->taiKhoan ? $this->khachHang->taiKhoan->ho_ten : null,
            'soSao' => (int) $this->so_sao,
            'nhanXet' => $this->nhan_xet,
            'ngayDanhGia' => $this->ngay_danh_gia ? \Carbon\Carbon::parse($this->ngay_danh_gia)->format('Y-m-d H:i:s') : null,
        ];
    }
}
