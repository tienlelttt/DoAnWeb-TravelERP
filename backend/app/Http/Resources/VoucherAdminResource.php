<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// Model lưu thông tin voucher.
class VoucherAdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $soLuotDaPhanBo = \App\Models\KhuyenMaiKh::where('ma_voucher', $this->ma_voucher)->where('trang_thai', '!=', 'THU_HOI')->count();
        
        $trangThai = 'HIEU_LUC';
        if ($this->ngay_het_han && Carbon::parse($this->ngay_het_han)->isBefore(Carbon::now())) {
            $trangThai = 'HET_HAN';
        } elseif ($this->trang_thai === 'VO_HIEU_HOA') {
            $trangThai = 'VO_HIEU_HOA';
        } elseif ($this->so_luot_da_dung >= $this->so_luot_phat_hanh) {
            $trangThai = 'HET_LUOT';
        }

        return [
            'maVoucher' => $this->ma_voucher,
            'maCode' => $this->ma_code,
            'loaiUuDai' => $this->loai_uu_dai,
            'giaTriGiam' => (float) $this->gia_tri_giam,
            'mucGiamToiDa' => $this->muc_giam_toi_da ? (float) $this->muc_giam_toi_da : null,
            'diemCanDoi' => $this->tinhDiemCanDoi(),
            'dieuKienApDung' => $this->dieu_kien_ap_dung,
            'soLuotPhatHanh' => (int) $this->so_luot_phat_hanh,
            'soLuotDaDung' => (int) $this->so_luot_da_dung,
            'soLuotDaPhanBo' => $soLuotDaPhanBo,
            'ngayHieuLuc' => $this->ngay_hieu_luc,
            'ngayHetHan' => $this->ngay_het_han,
            'trangThai' => $trangThai
        ];
    }

    private function tinhDiemCanDoi(): int
    {
        if (strtoupper((string) $this->loai_uu_dai) === 'SO_TIEN') {
            return (int) ceil((float) $this->gia_tri_giam);
        }

        if ($this->muc_giam_toi_da !== null) {
            return (int) ceil(((float) $this->muc_giam_toi_da * (float) $this->gia_tri_giam * 2) / 100);
        }

        return (int) ceil((float) $this->gia_tri_giam * 50);
    }
}
