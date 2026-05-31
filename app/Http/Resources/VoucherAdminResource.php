<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class VoucherAdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $soLuotDaPhanBo = \App\Models\KhuyenMaiKh::where('MaVoucher', $this->MaVoucher)->count();
        
        $trangThai = 'HIEU_LUC';
        if ($this->NgayHetHan && Carbon::parse($this->NgayHetHan)->isBefore(Carbon::now())) {
            $trangThai = 'HET_HAN';
        } elseif ($this->TrangThai === 'VO_HIEU_HOA') {
            $trangThai = 'VO_HIEU_HOA';
        } elseif ($this->SoLuotDaDung >= $this->SoLuotPhatHanh) {
            $trangThai = 'HET_LUOT';
        }

        return [
            'maVoucher' => $this->MaVoucher,
            'maCode' => $this->MaCode,
            'loaiUuDai' => $this->LoaiUuDai,
            'giaTriGiam' => (float) $this->GiaTriGiam,
            'mucGiamToiDa' => $this->MucGiamToiDa ? (float) $this->MucGiamToiDa : null,
            'diemCanDoi' => 0, // Dành cho KH nếu có cơ chế đổi điểm
            'dieuKienApDung' => $this->DieuKienApDung,
            'soLuotPhatHanh' => (int) $this->SoLuotPhatHanh,
            'soLuotDaDung' => (int) $this->SoLuotDaDung,
            'soLuotDaPhanBo' => $soLuotDaPhanBo,
            'ngayHieuLuc' => $this->NgayHieuLuc,
            'ngayHetHan' => $this->NgayHetHan,
            'trangThai' => $trangThai
        ];
    }
}
