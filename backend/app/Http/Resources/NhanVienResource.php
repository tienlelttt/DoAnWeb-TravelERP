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
            'maNhanVien'       => $this->ma_nhan_vien,
            'loaiNhanVien'     => $this->loai_nhan_vien,
            'trangThaiLamViec' => $this->trang_thai_lam_viec,
            'ngayVaoLam'       => $this->ngay_vao_lam,
            // Flatten taiKhoan để frontend đọc trực tiếp
            'tenDangNhap'  => $this->taiKhoan->ten_dang_nhap ?? null,
            'hoTen'        => $this->taiKhoan->ho_ten ?? null,
            'cccd'         => $this->taiKhoan->cccd ?? null,
            'ngaySinh'     => $this->taiKhoan->ngay_sinh ?? null,
            'email'        => $this->taiKhoan->email ?? null,
            'soDienThoai'  => $this->taiKhoan->so_dien_thoai ?? null,
            'vaiTro'       => $this->taiKhoan->vai_tro ?? null,
            'trangThai'    => $this->taiKhoan->trang_thai ?? null,
        ];
    }
}
