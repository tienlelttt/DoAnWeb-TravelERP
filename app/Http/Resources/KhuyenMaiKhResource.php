<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class KhuyenMaiKhResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $vc = $this->voucher;
        if (!$vc) return [];
        $khachHang = $this->khachHang;
        $taiKhoan = $khachHang?->taiKhoan;

        return [
            'maKhachHang'    => $this->MaKhachHang,
            'hoTenKhachHang' => $taiKhoan?->HoTen,
            'emailKhachHang' => $taiKhoan?->Email,
            'soDienThoaiKhachHang' => $taiKhoan?->SoDienThoai,
            'hangThanhVien'  => $khachHang?->HangThanhVien,
            'maVoucher'       => $vc->MaVoucher,
            'maCode'          => $vc->MaCode,
            'loaiUuDai'       => $vc->LoaiUuDai,
            'giaTriGiam'      => (float) $vc->GiaTriGiam,
            'mucGiamToiDa'    => $vc->MucGiamToiDa ? (float) $vc->MucGiamToiDa : null,
            'diemCanDoi'      => $this->tinhDiemCanDoi($vc),
            'dieuKienApDung'  => $vc->DieuKienApDung,
            'ngayHieuLuc'     => $vc->NgayHieuLuc ? Carbon::parse($vc->NgayHieuLuc)->format('Y-m-d H:i:s') : null,
            'ngayHetHan'      => $this->NgayHetHan ? Carbon::parse($this->NgayHetHan)->format('Y-m-d H:i:s') : ($vc->NgayHetHan ? Carbon::parse($vc->NgayHetHan)->format('Y-m-d H:i:s') : null),
            'ngayNhan'        => $this->NgayNhan ? Carbon::parse($this->NgayNhan)->format('Y-m-d H:i:s') : null,
            'trangThai'       => $this->TrangThai,
            'trangThaiVoucher'=> $vc->TrangThai,
            'trangThaiVi'     => $this->TrangThai,
            'trangThaiGoc'    => $vc->TrangThai,
        ];
    }

    private function tinhDiemCanDoi($voucher): int
    {
        if (strtoupper((string) $voucher->LoaiUuDai) === 'SO_TIEN') {
            return (int) ceil((float) $voucher->GiaTriGiam);
        }

        if ($voucher->MucGiamToiDa !== null) {
            return (int) ceil(((float) $voucher->MucGiamToiDa * (float) $voucher->GiaTriGiam * 2) / 100);
        }

        return (int) ceil((float) $voucher->GiaTriGiam * 50);
    }
}
