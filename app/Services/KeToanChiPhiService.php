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
            $query->where("MaTourThucTe", $filters["maTour"]);
        }

        if (!empty($filters["trangThaiDuyet"])) {
            $query->where("TrangThaiDuyet", $filters["trangThaiDuyet"]);
        }

        return $query->orderBy("NgayKhai", "desc")->paginate(15);
    }

    private function setTrangThaiChiPhi(string $maChiPhi, string $trangThaiMoi): ChiPhiThucTe
    {
        $chiPhi = ChiPhiThucTe::where("MaChiPhiThucTe", $maChiPhi)->first();
        
        if (!$chiPhi) {
            throw AppException::notFound("Không tìm thấy thông tin chi phí");
        }

        if ($chiPhi->TrangThaiDuyet === "DA_DUYET") {
            throw AppException::badRequest("Không thể thay đổi trạng thái của khoản chi phí đã được duyệt");
        }

        $chiPhi->TrangThaiDuyet = $trangThaiMoi;
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
