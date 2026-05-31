<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuyetToanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maQuyetToan' => $this->MaQuyetToan,
            'maTour' => $this->MaTourThucTe,
            'tenTour' => $this->tourThucTe?->tourMau?->TieuDe ?? '',
            'tongDoanhThu' => (float) $this->TongDoanhThu,
            'tongChiPhi' => (float) $this->TongChiPhi,
            'giaCamKet' => $this->GiaCamKet ? (float) $this->GiaCamKet : null,
            'loiNhuan' => (float) $this->LoiNhuan,
            'trangThai' => $this->TrangThai,
            'ghiChu' => $this->GhiChu,
            'hoaDonAnh' => $this->HoaDonAnh,
            'ngayQuyetToan' => $this->NgayQuyetToan,
            'maNhanVien' => $this->MaNhanVien,
            'tenNhanVien' => $this->nhanVien?->taiKhoan?->HoTen ?? ''
        ];
    }
}
