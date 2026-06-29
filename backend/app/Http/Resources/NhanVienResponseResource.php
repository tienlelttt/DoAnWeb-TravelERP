<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// Model lưu thông tin nhân viên.
class NhanVienResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'maNhanVien' => $this->ma_nhan_vien,
            'maTaiKhoan' => $this->ma_tai_khoan,
            'tenDangNhap' => $this->taiKhoan->ten_dang_nhap ?? null,
            'hoTen' => $this->taiKhoan->ho_ten ?? null,
            'email' => $this->taiKhoan->email ?? null,
            'soDienThoai' => $this->taiKhoan->so_dien_thoai ?? null,
            'maVaiTro' => $this->taiKhoan->vai_tro ?? null,
            'trangThaiTaiKhoan' => $this->taiKhoan->trang_thai ?? null,
            'trangThaiLamViec' => $this->trang_thai_lam_viec,
            'loaiNhanVien' => $this->loai_nhan_vien,
            'ngaySinh' => $this->taiKhoan->ngay_sinh ? (Carbon::parse($this->taiKhoan->ngay_sinh)->format('Y-m-d')) : null,
            'ngayVaoLam' => $this->ngay_vao_lam ? (Carbon::parse($this->ngay_vao_lam)->format('Y-m-d')) : null,
            'cccd' => $this->taiKhoan->cccd ?? null,
            'tourHistory' => $this->getLichSuTours(),
        ];
    }

    private function getLichSuTours()
    {
        if ($this->loai_nhan_vien !== 'HDV') {
            return [];
        }

        $phanCongs = \App\Models\PhanCongTour::with('tourThucTe.tourMau')
            ->where('ma_nhan_vien', $this->ma_nhan_vien)
            ->where('trang_thai_chap_nhan', 'DA_DONG_Y')
            ->orderBy('ngay_phan_cong', 'desc')
            ->get();

        return $phanCongs->map(function ($pc) {
            $tour = $pc->tourThucTe;
            if (!$tour) return null;
            
            $status = 'upcoming';
            if (in_array($tour->trang_thai, ['KET_THUC', 'DA_QUYET_TOAN', 'HOAN_THANH'])) {
                $status = 'completed';
            } elseif ($tour->trang_thai === 'DA_HUY') {
                $status = 'cancelled';
            }

            // Tính tổng tiền đơn hàng của tour (doanh thu)
            $tongTien = \App\Models\DonDatTour::where('ma_tour_thuc_te', $tour->ma_tour_thuc_te)
                ->whereIn('trang_thai', ['DA_XAC_NHAN', 'HOAN_THANH'])
                ->sum('tong_tien');

            return [
                'tourCode' => $tour->ma_tour_thuc_te,
                'tourName' => $tour->tourMau ? $tour->tourMau->tieu_de : $tour->ma_tour_thuc_te,
                'startDate' => $tour->ngay_khoi_hanh ? \Carbon\Carbon::parse($tour->ngay_khoi_hanh)->format('Y-m-d') : '',
                'status' => $status,
                'amount' => (float) $tongTien,
                'guideName' => $this->taiKhoan->ho_ten ?? null,
            ];
        })->filter()->values()->toArray();
    }
}
