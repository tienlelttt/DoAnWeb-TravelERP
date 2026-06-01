<?php

namespace App\Services;

use App\Models\ChiPhiThucTe;
use App\Exceptions\AppException;

class KeToanChiPhiService
{
    public function danhSachChiPhi(array $filters = [])
    {
        $query = ChiPhiThucTe::with(["tourThucTe", "nhanVien"]);

        if (!empty($filters["maTour"])) {
            $query->where("ma_tour_thuc_te", $filters["maTour"]);
        }

        if (!empty($filters["trangThaiDuyet"])) {
            $query->where("trang_thai_duyet", $filters["trangThaiDuyet"]);
        }

        $size = max(1, min((int) ($filters['size'] ?? 15), 1000));
        return $query->orderBy("ngay_khai", "desc")->paginate($size);
    }

    private function setTrangThaiChiPhi(string $maChiPhi, string $trangThaiMoi): ChiPhiThucTe
    {
        $chiPhi = ChiPhiThucTe::where("ma_chi_phi_thuc_te", $maChiPhi)->first();
        
        if (!$chiPhi) {
            throw AppException::notFound("Không tìm thấy thông tin chi phí");
        }

        if ($chiPhi->trang_thai_duyet === "DA_DUYET") {
            throw AppException::badRequest("Không thể thay đổi trạng thái của khoản chi phí đã được duyệt");
        }

        $chiPhi->trang_thai_duyet = $trangThaiMoi;
        $chiPhi->save();

        return $chiPhi;
    }

    public function duyetChiPhi(string $maChiPhi)
    {
        return $this->setTrangThaiChiPhi($maChiPhi, "DA_DUYET");
    }

    public function tuChoiChiPhi(string $maChiPhi)
    {
        return $this->setTrangThaiChiPhi($maChiPhi, "TU_CHOI");
    }

    public function yeuCauBoSungChiPhi(string $maChiPhi)
    {
        return $this->setTrangThaiChiPhi($maChiPhi, "YEU_CAU_BO_SUNG");
    }
}
