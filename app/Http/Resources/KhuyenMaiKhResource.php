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

        return [
            'maVoucher'       => $vc->MaVoucher,
            'maCode'          => $vc->MaCode,
            'loaiUuDai'       => $vc->LoaiUuDai,
            'giaTriGiam'      => (float) $vc->GiaTriGiam,
            'mucGiamToiDa'    => $vc->MucGiamToiDa ? (float) $vc->MucGiamToiDa : null,
            'dieKienApDung'   => $vc->DieuKienApDung,
            'ngayHieuLuc'     => $vc->NgayHieuLuc ? Carbon::parse($vc->NgayHieuLuc)->format('Y-m-d H:i:s') : null,
            'ngayHetHan'      => $this->NgayHetHan ? Carbon::parse($this->NgayHetHan)->format('Y-m-d H:i:s') : ($vc->NgayHetHan ? Carbon::parse($vc->NgayHetHan)->format('Y-m-d H:i:s') : null),
            'trangThaiVi'     => $this->TrangThai,
            'trangThaiGoc'    => $vc->TrangThai,
        ];
    }
}
