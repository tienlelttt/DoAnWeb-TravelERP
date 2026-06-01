<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourCongKhaiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maTourThucTe' => $this->ma_tour_thuc_te,
            'maTourMau' => $this->ma_tour_mau,
            'tieuDeTour' => $this->tourMau ? $this->tourMau->tieu_de : null,
            'moTa' => $this->tourMau ? $this->tourMau->mo_ta : null,
            'ngayKhoiHanh' => \Carbon\Carbon::parse($this->ngay_khoi_hanh)->format('Y-m-d'),
            'thoiLuong' => $this->tourMau ? (int) $this->tourMau->thoi_luong : null,
            'giaHienHanh' => (float) $this->gia_hien_hanh,
            'soKhachToiDa' => (int) $this->so_khach_toi_da,
            'choConLai' => (int) $this->cho_con_lai,
            'trangThai' => $this->trang_thai,
            'diemDanhGia' => $this->tourMau ? ($this->tourMau->danh_gia ? (float) $this->tourMau->danh_gia : null) : null,
            'soDanhGia' => $this->tourMau ? ($this->tourMau->so_danh_gia ? (int) $this->tourMau->so_danh_gia : null) : null,
            'lichTrinh' => $this->tourMau ? LichTrinhResource::collection($this->tourMau->lichTrinhTours) : [],
            'dichVu' => DichVuThemResource::collection($this->whenLoaded('dichVuThems')),
            'hanhDongXanh' => HanhDongXanhResource::collection($this->whenLoaded('hanhDongXanhs')),
        ];
    }
}
