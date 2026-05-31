<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuyetToanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maQuyetToan' => $this->ma_quyet_toan,
            'maTour' => $this->ma_tour_thuc_te,
            'tenTour' => $this->tourThucTe?->tourMau?->tieu_de ?? '',
            'tongDoanhThu' => (float) $this->tong_doanh_thu,
            'tongChiPhi' => (float) $this->tong_chi_phi,
            'giaCamKet' => $this->gia_cam_ket ? (float) $this->gia_cam_ket : null,
            'loiNhuan' => (float) $this->loi_nhuan,
            'trangThai' => $this->trang_thai,
            'ghiChu' => $this->ghi_chu,
            'hoaDonAnh' => $this->hoa_don_anh,
            'ngayQuyetToan' => $this->ngay_quyet_toan,
            'maNhanVien' => $this->ma_nhan_vien,
            'tenNhanVien' => $this->nhanVien?->taiKhoan?->ho_ten ?? ''
        ];
    }
}
