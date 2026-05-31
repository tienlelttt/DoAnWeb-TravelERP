<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\ChiPhiThucTe;
use App\Models\DonDatTour;
use App\Models\NhanVien;
use App\Models\QuyetToan;
use App\Models\TourThucTe;
use App\Models\GiaoDich;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuyetToanService
{
    const YEU_CAU_BO_SUNG_MARKER = "[Yêu cầu bổ sung quyết toán";
    const HDV_BO_SUNG_MARKER = "[HDV bổ sung quyết toán";

    public function __construct(
        private MaTuDongService $maTuDongService
    ) {}

    public function tourCanQuyetToan($perPage = 10)
    {
        // Danh sách tour KET_THUC nhưng chưa có trong QUYETTOAN
        $daQuyetToan = QuyetToan::pluck('MaTourThucTe')->toArray();

        $tours = TourThucTe::whereIn('TrangThai', ['KET_THUC', 'DA_QUYET_TOAN'])
            ->whereNotIn('MaTourThucTe', $daQuyetToan)
            ->paginate($perPage);

        // Map data để trả về cấu trúc giống QuyetToanResource (XEM_TRUOC)
        $tours->getCollection()->transform(function ($tour) {
            $doanhThu = $this->tinhDoanhThu($tour->MaTourThucTe);
            $chiPhi = $this->tinhChiPhi($tour->MaTourThucTe);
            
            return (object) [
                'MaQuyetToan' => null,
                'MaTourThucTe' => $tour->MaTourThucTe,
                'tourThucTe' => $tour,
                'TongDoanhThu' => $doanhThu,
                'TongChiPhi' => $chiPhi,
                'GiaCamKet' => null,
                'LoiNhuan' => $doanhThu - $chiPhi,
                'TrangThai' => 'CHUA_QUYET_TOAN',
                'NgayQuyetToan' => $tour->NgayKhoiHanh,
                'GhiChu' => null,
                'HoaDonAnh' => null,
                'MaNhanVien' => null,
                'nhanVien' => null
            ];
        });

        return $tours;
    }

    public function tinhToan($maTour)
    {
        $tour = $this->getKetThucTour($maTour);
        $doanhThu = $this->tinhDoanhThu($maTour);
        $chiPhi = $this->tinhChiPhi($maTour);

        return (object) [
            'MaQuyetToan' => null,
            'MaTourThucTe' => $maTour,
            'tourThucTe' => $tour,
            'TongDoanhThu' => $doanhThu,
            'TongChiPhi' => $chiPhi,
            'GiaCamKet' => null,
            'LoiNhuan' => $doanhThu - $chiPhi,
            'TrangThai' => 'XEM_TRUOC',
            'NgayQuyetToan' => null,
            'GhiChu' => null,
            'HoaDonAnh' => null,
            'MaNhanVien' => null,
            'nhanVien' => null
        ];
    }

    public function taoQuyetToan($maTour, array $req, $maTaiKhoan)
    {
        $this->getKetThucTour($maTour);

        $existing = QuyetToan::where('MaTourThucTe', $maTour)->first();
        if ($existing) {
            if ($existing->TrangThai === 'DA_QUYET_TOAN') {
                throw AppException::badRequest("Quyết toán đã bị chốt, không thể sửa.");
            }
            return $this->capNhatQT($existing, $maTour, $req, $maTaiKhoan);
        }

        $nv = NhanVien::where('MaTaiKhoan', $maTaiKhoan)->first();
        if (!$nv) {
            $nv = NhanVien::whereIn('LoaiNhanVien', ['KETOAN', 'ADMIN'])->first();
            if (!$nv) throw AppException::notFound("Không tìm thấy hồ sơ nhân viên");
        }

        $doanhThu = $this->tinhDoanhThu($maTour);
        $chiPhi = $this->tinhChiPhi($maTour);

        $qt = new QuyetToan();
        $qt->MaQuyetToan = $this->maTuDongService->taoMaQuyetToan();
        $qt->MaTourThucTe = $maTour;
        $qt->MaNhanVien = $nv->MaNhanVien;
        $qt->TongDoanhThu = $doanhThu;
        $qt->TongChiPhi = $chiPhi;
        $qt->GiaCamKet = $req['giaCamKet'] ?? null;
        $qt->LoiNhuan = $doanhThu - $chiPhi;
        $qt->NgayQuyetToan = Carbon::now();
        $qt->TrangThai = 'CHUA_QUYET_TOAN';
        $qt->GhiChu = $req['ghiChu'] ?? null;
        $qt->HoaDonAnh = $req['hoaDonAnh'] ?? null;
        
        $qt->save();

        return $qt;
    }

    public function chotQuyetToan($maQuyetToan)
    {
        $qt = QuyetToan::find($maQuyetToan);
        if (!$qt) throw AppException::notFound("Không tìm thấy quyết toán: " . $maQuyetToan);

        if ($qt->TrangThai !== 'CHUA_QUYET_TOAN') {
            throw AppException::badRequest("Chỉ có thể chốt quyết toán ở trạng thái CHUA_QUYET_TOAN.");
        }

        DB::transaction(function() use ($qt) {
            $qt->TrangThai = 'DA_QUYET_TOAN';
            $qt->save();

            $tour = $qt->tourThucTe;
            $tour->TrangThai = 'DA_QUYET_TOAN';
            $tour->save();
        });

        return $qt;
    }

    public function yeuCauBoSung($maQuyetToan, $noiDung)
    {
        $qt = QuyetToan::find($maQuyetToan);
        if (!$qt) throw AppException::notFound("Không tìm thấy quyết toán: " . $maQuyetToan);

        if ($qt->TrangThai === 'DA_QUYET_TOAN') {
            throw AppException::badRequest("Quyết toán đã bị chốt, không thể yêu cầu bổ sung.");
        }

        $qt->GhiChu = $this->noiGhiChuMoi($qt->GhiChu, self::YEU_CAU_BO_SUNG_MARKER, $noiDung);
        $qt->NgayQuyetToan = Carbon::now();
        $qt->save();

        return $qt;
    }

    public function danhSach($trangThai = null, $perPage = 10)
    {
        $query = QuyetToan::query()->with(['tourThucTe', 'nhanVien.taiKhoan']);
        if ($trangThai) {
            $query->where('TrangThai', $trangThai);
        }
        return $query->paginate($perPage);
    }

    public function chiTiet($maQuyetToan)
    {
        $qt = QuyetToan::with(['tourThucTe', 'nhanVien.taiKhoan'])->find($maQuyetToan);
        if (!$qt) throw AppException::notFound("Không tìm thấy quyết toán: " . $maQuyetToan);
        return $qt;
    }

    // --- HOAN TIEN LOGIC ---

    public function danhSachChoHoanTien($perPage = 10)
    {
        return GiaoDich::where('LoaiGiaoDich', 'HOAN_TIEN')
            ->where('TrangThai', 'CHO_THANH_TOAN')
            ->paginate($perPage);
    }

    public function xacNhanHoanTien($maGiaoDich)
    {
        return DB::transaction(function() use ($maGiaoDich) {
            $gd = GiaoDich::lockForUpdate()->find($maGiaoDich);
            if (!$gd) throw AppException::notFound("Không tìm thấy giao dịch: " . $maGiaoDich);

            if ($gd->LoaiGiaoDich !== 'HOAN_TIEN') throw AppException::badRequest("Giao dịch này không phải hoàn tiền");
            if ($gd->TrangThai === 'DA_HOAN_TIEN') throw AppException::badRequest("Giao dịch này đã được xác nhận hoàn tiền rồi");
            if ($gd->TrangThai !== 'CHO_THANH_TOAN') throw AppException::badRequest("Chỉ có thể xác nhận giao dịch ở trạng thái CHO_THANH_TOAN");

            $don = DonDatTour::lockForUpdate()->find($gd->MaDatTour);
            if ($don->TrangThai !== 'CHO_HUY') throw AppException::badRequest("Chỉ có thể xác nhận hoàn tiền cho đơn ở trạng thái CHO_HUY. Trạng thái hiện tại: " . $don->TrangThai);

            $gd->TrangThai = 'DA_HOAN_TIEN';
            $gd->NgayThanhToan = Carbon::now();
            $gd->save();

            $tour = TourThucTe::lockForUpdate()->find($don->MaTourThucTe);
            $soKhach = DB::table('CHITIETDATTOUR')->where('MaDatTour', $don->MaDatTour)->count();
            $tour->ChoConLai = min($tour->ChoConLai + $soKhach, $tour->SoKhachToiDa);
            $tour->save();

            $don->TrangThai = 'DA_HUY';
            $don->save();

            return $gd;
        });
    }

    public function tuChoiHoanTien($maGiaoDich)
    {
        return DB::transaction(function() use ($maGiaoDich) {
            $gd = GiaoDich::lockForUpdate()->find($maGiaoDich);
            if (!$gd) throw AppException::notFound("Không tìm thấy giao dịch: " . $maGiaoDich);

            if ($gd->LoaiGiaoDich !== 'HOAN_TIEN') throw AppException::badRequest("Giao dịch này không phải hoàn tiền");
            if ($gd->TrangThai !== 'CHO_THANH_TOAN') throw AppException::badRequest("Chỉ có thể từ chối giao dịch hoàn tiền ở trạng thái CHO_THANH_TOAN");

            $don = DonDatTour::lockForUpdate()->find($gd->MaDatTour);
            if ($don->TrangThai !== 'CHO_HUY') throw AppException::badRequest("Chỉ có thể từ chối hoàn tiền cho đơn ở trạng thái CHO_HUY. Trạng thái hiện tại: " . $don->TrangThai);

            $gd->TrangThai = 'THAT_BAI';
            $gd->NgayThanhToan = Carbon::now();
            $gd->save();

            $don->TrangThai = 'TU_CHOI_HOAN_TIEN';
            $don->save();

            return $gd;
        });
    }

    // --- HELPERS ---

    private function capNhatQT(QuyetToan $qt, $maTour, array $req, $maTaiKhoan)
    {
        $doanhThu = $this->tinhDoanhThu($maTour);
        $chiPhi = $this->tinhChiPhi($maTour);

        $qt->TongDoanhThu = $doanhThu;
        $qt->TongChiPhi = $chiPhi;
        if (isset($req['giaCamKet'])) $qt->GiaCamKet = $req['giaCamKet'];
        $qt->LoiNhuan = $doanhThu - $chiPhi;
        $qt->NgayQuyetToan = Carbon::now();
        if (isset($req['ghiChu'])) $qt->GhiChu = $req['ghiChu'];
        if (isset($req['hoaDonAnh'])) $qt->HoaDonAnh = $req['hoaDonAnh'];
        
        $qt->save();
        return $qt;
    }

    private function getKetThucTour($maTour)
    {
        $tour = TourThucTe::find($maTour);
        if (!$tour) throw AppException::notFound("Không tìm thấy tour: " . $maTour);

        if (!in_array($tour->TrangThai, ['KET_THUC', 'DA_QUYET_TOAN'])) {
            throw AppException::badRequest("Tour chưa kết thúc, không thể quyết toán.");
        }
        return $tour;
    }

    private function tinhDoanhThu($maTour)
    {
        return DonDatTour::where('MaTourThucTe', $maTour)
            ->whereIn('TrangThai', ['DA_XAC_NHAN', 'CHO_HUY', 'CHO_HOAN_TIEN', 'TU_CHOI_HOAN_TIEN', 'HOAN_THANH'])
            ->sum('TongTien');
    }

    private function tinhChiPhi($maTour)
    {
        return ChiPhiThucTe::where('MaTourThucTe', $maTour)
            ->where('TrangThaiDuyet', 'DA_DUYET')
            ->sum('ThanhTien');
    }

    private function noiGhiChuMoi($ghiChuHienTai, $marker, $noiDung)
    {
        $phanTruoc = empty($ghiChuHienTai) ? "" : $ghiChuHienTai . "\n\n";
        return $phanTruoc . $marker . " lúc " . Carbon::now()->toDateTimeString() . "]:\n" . trim($noiDung);
    }
}
