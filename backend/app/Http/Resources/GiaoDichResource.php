<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// Model lưu thông tin dữ liệu.
class GiaoDichResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'maGiaoDich' => $this->ma_giao_dich,
            'maDatTour' => $this->ma_dat_tour,
            'loaiGiaoDich' => $this->loai_giao_dich,
            'phuongThuc' => $this->phuong_thuc,
            'soTien' => (float) $this->so_tien,
            'maGDNH' => $this->ma_gdnh,
            'trangThai' => $this->trang_thai,
            'ngayThanhToan' => $this->ngay_thanh_toan ? Carbon::parse($this->ngay_thanh_toan)->format('Y-m-d H:i:s') : null,
        ];
    }
}
