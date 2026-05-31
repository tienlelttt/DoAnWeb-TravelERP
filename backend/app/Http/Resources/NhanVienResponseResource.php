<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NhanVienResponseResource extends JsonResource
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
            'maNhanVien' => $this->ma_nhan_vien,
            'maTaiKhoan' => $this->ma_tai_khoan,
            'tenDangNhap' => $this->taiKhoan->ten_dang_nhap ?? null,
            'hoTen' => $this->taiKhoan->ho_ten ?? null,
            'email' => $this->taiKhoan->email ?? null,
            'soDienThoai' => $this->taiKhoan->so_dien_thoai ?? null,
            'maVaiTro' => $this->taiKhoan->vai_tro ?? null,
            'trangThaiTaiKhoan' => $this->taiKhoan->trang_thai ?? null,
            'trangThaiLamViec' => $this->trang_thai_lam_viec,
            'loaiNhanVien' => $this->loai_nhan_vien,
            'ngaySinh' => $this->taiKhoan->ngay_sinh ? (Carbon::parse($this->taiKhoan->ngay_sinh)->format('Y-m-d')) : null,
            'ngayVaoLam' => $this->ngay_vao_lam ? (Carbon::parse($this->ngay_vao_lam)->format('Y-m-d')) : null,
            'cccd' => $this->taiKhoan->cccd ?? null,
        ];
    }
}
