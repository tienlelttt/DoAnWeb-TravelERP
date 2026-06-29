<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// Model lưu thông tin tour thực tế.
class TourThucTeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maTourThucTe' => $this->ma_tour_thuc_te,
            'maTourMau' => $this->ma_tour_mau,
            'tieuDeTour' => $this->tourMau ? $this->tourMau->tieu_de : null,
            'ngayKhoiHanh' => Carbon::parse($this->ngay_khoi_hanh)->format('Y-m-d'),
            // NgayKetThuc = ngay_khoi_hanh + thoi_luong (của TourMau)
            'ngayKetThuc' => $this->tourMau ? Carbon::parse($this->ngay_khoi_hanh)->addDays($this->tourMau->thoi_luong)->format('Y-m-d') : null,
            'giaHienHanh' => (float) $this->gia_hien_hanh,
            'soKhachToiDa' => (int) $this->so_khach_toi_da,
            'soKhachToiThieu' => (int) $this->so_khach_toi_thieu,
            'choConLai' => (int) $this->cho_con_lai,
            'trangThai' => $this->trang_thai,
            'moTa' => $this->tourMau ? $this->tourMau->mo_ta : null,
            'lichTrinh' => $this->tourMau ? LichTrinhResource::collection($this->tourMau->lichTrinhTours) : [],
            'thoiLuong' => $this->tourMau ? (int) $this->tourMau->thoi_luong : null,
            'diemDanhGia' => $this->tourMau ? ($this->tourMau->danh_gia ? (float) $this->tourMau->danh_gia : null) : null,
            'soDanhGia' => $this->tourMau ? ($this->tourMau->so_danh_gia ? (int) $this->tourMau->so_danh_gia : null) : null,
            'dichVu' => DichVuThemResource::collection($this->whenLoaded('dichVuThems')),
            'hanhDongXanh' => HanhDongXanhResource::collection($this->whenLoaded('hanhDongXanhs')),
        ];
    }
}
