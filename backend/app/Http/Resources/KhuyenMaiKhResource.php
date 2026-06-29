<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// Model lưu thông tin khuyến mãi.
class KhuyenMaiKhResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $vc = $this->voucher;
        if (!$vc) return [];
        $khachHang = $this->khachHang;
        $taiKhoan = $khachHang?->taiKhoan;

        return [
            'maKhachHang'    => $this->ma_khach_hang,
            'hoTenKhachHang' => $taiKhoan?->ho_ten,
            'emailKhachHang' => $taiKhoan?->email,
            'soDienThoaiKhachHang' => $taiKhoan?->so_dien_thoai,
            'hangThanhVien'  => $khachHang?->hang_thanh_vien,
            'maVoucher'       => $vc->ma_voucher,
            'maCode'          => $vc->ma_code,
            'loaiUuDai'       => $vc->loai_uu_dai,
            'giaTriGiam'      => (float) $vc->gia_tri_giam,
            'mucGiamToiDa'    => $vc->muc_giam_toi_da ? (float) $vc->muc_giam_toi_da : null,
            'diemCanDoi'      => $this->tinhDiemCanDoi($vc),
            'dieuKienApDung'  => $vc->dieu_kien_ap_dung,
            'ngayHieuLuc'     => $vc->ngay_hieu_luc ? Carbon::parse($vc->ngay_hieu_luc)->format('Y-m-d H:i:s') : null,
            'ngayHetHan'      => $this->ngay_het_han ? Carbon::parse($this->ngay_het_han)->format('Y-m-d H:i:s') : ($vc->ngay_het_han ? Carbon::parse($vc->ngay_het_han)->format('Y-m-d H:i:s') : null),
            'ngayNhan'        => $this->ngay_nhan ? Carbon::parse($this->ngay_nhan)->format('Y-m-d H:i:s') : null,
            'trangThai'       => $this->trang_thai,
            'trangThaiVoucher'=> $vc->trang_thai,
            'trangThaiVi'     => $this->trang_thai,
            'trangThaiGoc'    => $vc->trang_thai,
        ];
    }

    private function tinhDiemCanDoi($voucher): int
    {
        if (strtoupper((string) $voucher->loai_uu_dai) === 'SO_TIEN') {
            return (int) ceil((float) $voucher->gia_tri_giam);
        }

        if ($voucher->muc_giam_toi_da !== null) {
            return (int) ceil(((float) $voucher->muc_giam_toi_da * (float) $voucher->gia_tri_giam * 2) / 100);
        }

        return (int) ceil((float) $voucher->gia_tri_giam * 50);
    }
}
