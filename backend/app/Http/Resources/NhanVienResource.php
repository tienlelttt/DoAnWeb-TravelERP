<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// Model lưu thông tin nhân viên.
class NhanVienResource extends JsonResource
{
    public function toArray($request)
    {
        $taiKhoan = $this->taiKhoan;

        return [
            'maNhanVien' => $this->ma_nhan_vien,
            'loaiNhanVien' => $this->loai_nhan_vien,
            'trangThaiLamViec' => $this->trang_thai_lam_viec,
            'ngayVaoLam' => $this->ngay_vao_lam,
            'taiKhoan' => $taiKhoan ? [
                'maTaiKhoan' => $taiKhoan->ma_tai_khoan,
                'tenDangNhap' => $taiKhoan->ten_dang_nhap,
                'hoTen' => $taiKhoan->ho_ten,
                'cccd' => $taiKhoan->cccd,
                'ngaySinh' => $taiKhoan->ngay_sinh,
                'email' => $taiKhoan->email,
                'soDienThoai' => $taiKhoan->so_dien_thoai,
                'vaiTro' => $taiKhoan->vai_tro,
                'trangThai' => $taiKhoan->trang_thai,
            ] : null,
            'tenDangNhap' => $taiKhoan->ten_dang_nhap ?? null,
            'hoTen' => $taiKhoan->ho_ten ?? null,
            'cccd' => $taiKhoan->cccd ?? null,
            'ngaySinh' => $taiKhoan->ngay_sinh ?? null,
            'email' => $taiKhoan->email ?? null,
            'soDienThoai' => $taiKhoan->so_dien_thoai ?? null,
            'vaiTro' => $taiKhoan->vai_tro ?? null,
            'trangThai' => $taiKhoan->trang_thai ?? null,
        ];
    }
}
