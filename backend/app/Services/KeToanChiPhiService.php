<?php

namespace App\Services;

use App\Models\ChiPhiThucTe;
use App\Exceptions\AppException;

class KeToanChiPhiService
{
    // UC44 | HDV | Lấy danh sách chi phí thực tế.
    public function danhSachChiPhi(array $filters = [])
    {
        $query = ChiPhiThucTe::with(["tourThucTe.tourMau", "nhanVien.taiKhoan"]);

        if (!empty($filters["maTour"])) {
            $query->where("ma_tour_thuc_te", $filters["maTour"]);
        }

        if (!empty($filters["trangThaiDuyet"])) {
            $query->where("trang_thai_duyet", $filters["trangThaiDuyet"]);
        }

        $size = max(1, min((int) ($filters['size'] ?? 15), 1000));
        return $query->orderBy("ngay_khai", "desc")->paginate($size);
    }

    private function setTrangThaiChiPhi(string $maChiPhi, string $trangThaiMoi, ?string $ghiChu = null): ChiPhiThucTe
    {
        $chiPhi = ChiPhiThucTe::where("ma_chi_phi_thuc_te", $maChiPhi)->first();
        
        if (!$chiPhi) {
            throw AppException::notFound("Không tìm thấy thông tin chi phí");
        }

        if ($chiPhi->trang_thai_duyet === "DA_DUYET") {
            throw AppException::badRequest("Không thể thay đổi trạng thái của khoản chi phí đã được duyệt");
        }

        $chiPhi->trang_thai_duyet = $trangThaiMoi;
        
        if ($ghiChu) {
            $prefix = match ($trangThaiMoi) {
                'TU_CHOI' => '[Kế toán từ chối]: ',
                'YEU_CAU_BO_SUNG' => '[Kế toán yêu cầu bổ sung]: ',
                'DA_DUYET' => '[Kế toán duyệt]: ',
                default => '[Kế toán ghi chú]: '
            };
            $chiPhi->ghi_chu = $chiPhi->ghi_chu ? $chiPhi->ghi_chu . "\n\n" . $prefix . $ghiChu : $prefix . $ghiChu;
        }

        $chiPhi->save();

        return $chiPhi;
    }

    // UC44 | HDV | Phê duyệt chi phí thực tế.
    public function duyetChiPhi(string $maChiPhi, ?string $ghiChu = null)
    {
        return $this->setTrangThaiChiPhi($maChiPhi, "DA_DUYET", $ghiChu);
    }

    public function tuChoiChiPhi(string $maChiPhi, ?string $ghiChu = null)
    {
        return $this->setTrangThaiChiPhi($maChiPhi, "TU_CHOI", $ghiChu);
    }

    public function yeuCauBoSungChiPhi(string $maChiPhi, ?string $ghiChu = null)
    {
        return $this->setTrangThaiChiPhi($maChiPhi, "YEU_CAU_BO_SUNG", $ghiChu);
    }
}
