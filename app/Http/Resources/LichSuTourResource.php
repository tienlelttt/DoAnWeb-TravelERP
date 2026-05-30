<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class LichSuTourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maLichSuTour' => $this->MaLichSuTour,
            'maKhachHang' => $this->MaKhachHang,
            'maTourThucTe' => $this->MaTourThucTe,
            'maChiTietDat' => $this->MaChiTietDat,
            'ngayThamGia' => $this->NgayThamGia ? Carbon::parse($this->NgayThamGia)->format('Y-m-d H:i:s') : null,
        ];
    }
}
