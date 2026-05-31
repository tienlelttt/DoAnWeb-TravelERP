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
        // Danh sách tour KET_THUC nhưng chưa có trong quyet_toans
        $daQuyetToan = QuyetToan::pluck('ma_tour_thuc_te')->toArray();

        $tours = TourThucTe::whereIn('trang_thai', ['KET_THUC', 'DA_QUYET_TOAN'])
            ->whereNotIn('ma_tour_thuc_te', $daQuyetToan)
            ->paginate($perPage);

        // Map data để trả về cấu trúc giống QuyetToanResource (XEM_TRUOC)
        $tours->getCollection()->transform(function ($tour) {
            $doanhThu = $this->tinhDoanhThu($tour->ma_tour_thuc_te);
            $chiPhi = $this->tinhChiPhi($tour->ma_tour_thuc_te);
            
            return (object) [
                'ma_quyet_toan' => null,
                'ma_tour_thuc_te' => $tour->ma_tour_thuc_te,
                'tourThucTe' => $tour,
                'tong_doanh_thu' => $doanhThu,
                'tong_chi_phi' => $chiPhi,
                'gia_cam_ket' => null,
                'loi_nhuan' => $doanhThu - $chiPhi,
                'trang_thai' => 'CHUA_QUYET_TOAN',
                'ngay_quyet_toan' => $tour->ngay_khoi_hanh,
                'ghi_chu' => null,
                'hoa_don_anh' => null,
                'ma_nhan_vien' => null,
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
            'ma_quyet_toan' => null,
            'ma_tour_thuc_te' => $maTour,
            'tourThucTe' => $tour,
            'tong_doanh_thu' => $doanhThu,
            'tong_chi_phi' => $chiPhi,
            'gia_cam_ket' => null,
            'loi_nhuan' => $doanhThu - $chiPhi,
            'trang_thai' => 'XEM_TRUOC',
            'ngay_quyet_toan' => null,
            'ghi_chu' => null,
            'hoa_don_anh' => null,
            'ma_nhan_vien' => null,
            'nhanVien' => null
        ];
    }

    public function taoQuyetToan($maTour, array $req, $maTaiKhoan)
    {
        $this->getKetThucTour($maTour);

        $existing = QuyetToan::where('ma_tour_thuc_te', $maTour)->first();
        if ($existing) {
            if ($existing->trang_thai === 'DA_QUYET_TOAN') {
                throw AppException::badRequest("Quyết toán đã bị chốt, không thể sửa.");
            }
            return $this->capNhatQT($existing, $maTour, $req, $maTaiKhoan);
        }

        $nv = NhanVien::where('ma_tai_khoan', $maTaiKhoan)->first();
        if (!$nv) {
            $nv = NhanVien::whereIn('loai_nhan_vien', ['KETOAN', 'ADMIN'])->first();
            if (!$nv) throw AppException::notFound("Không tìm thấy hồ sơ nhân viên");
        }

        $doanhThu = $this->tinhDoanhThu($maTour);
        $chiPhi = $this->tinhChiPhi($maTour);

        $qt = new QuyetToan();
        $qt->ma_quyet_toan = $this->maTuDongService->taoMaQuyetToan();
        $qt->ma_tour_thuc_te = $maTour;
        $qt->ma_nhan_vien = $nv->ma_nhan_vien;
        $qt->tong_doanh_thu = $doanhThu;
        $qt->tong_chi_phi = $chiPhi;
        $qt->gia_cam_ket = $req['giaCamKet'] ?? null;
        $qt->loi_nhuan = $doanhThu - $chiPhi;
        $qt->ngay_quyet_toan = Carbon::now();
        $qt->trang_thai = 'CHUA_QUYET_TOAN';
        $qt->ghi_chu = $req['ghiChu'] ?? null;
        $qt->hoa_don_anh = $req['hoaDonAnh'] ?? null;
        
        $qt->save();

        return $qt;
    }

    public function chotQuyetToan($maQuyetToan)
    {
        $qt = QuyetToan::find($maQuyetToan);
        if (!$qt) throw AppException::notFound("Không tìm thấy quyết toán: " . $maQuyetToan);

        if ($qt->trang_thai !== 'CHUA_QUYET_TOAN') {
            throw AppException::badRequest("Chỉ có thể chốt quyết toán ở trạng thái CHUA_QUYET_TOAN.");
        }

        DB::transaction(function() use ($qt) {
            $qt->trang_thai = 'DA_QUYET_TOAN';
            $qt->save();

            $tour = $qt->tourThucTe;
            $tour->trang_thai = 'DA_QUYET_TOAN';
            $tour->save();
        });

        return $qt;
    }

    public function yeuCauBoSung($maQuyetToan, $noiDung)
    {
        $qt = QuyetToan::find($maQuyetToan);
        if (!$qt) throw AppException::notFound("Không tìm thấy quyết toán: " . $maQuyetToan);

        if ($qt->trang_thai === 'DA_QUYET_TOAN') {
            throw AppException::badRequest("Quyết toán đã bị chốt, không thể yêu cầu bổ sung.");
        }

        $qt->ghi_chu = $this->noiGhiChuMoi($qt->ghi_chu, self::YEU_CAU_BO_SUNG_MARKER, $noiDung);
        $qt->ngay_quyet_toan = Carbon::now();
        $qt->save();

        return $qt;
    }

    public function danhSach($trangThai = null, $perPage = 10)
    {
        $query = QuyetToan::query()->with(['tourThucTe', 'nhanVien.taiKhoan']);
        if ($trangThai) {
            $query->where('trang_thai', $trangThai);
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
        return GiaoDich::where('loai_giao_dich', 'HOAN_TIEN')
            ->where('trang_thai', 'CHO_THANH_TOAN')
            ->paginate($perPage);
    }

    public function xacNhanHoanTien($maGiaoDich)
    {
        return DB::transaction(function() use ($maGiaoDich) {
            $gd = GiaoDich::lockForUpdate()->find($maGiaoDich);
            if (!$gd) throw AppException::notFound("Không tìm thấy giao dịch: " . $maGiaoDich);

            if ($gd->loai_giao_dich !== 'HOAN_TIEN') throw AppException::badRequest("Giao dịch này không phải hoàn tiền");
            if ($gd->trang_thai === 'DA_HOAN_TIEN') throw AppException::badRequest("Giao dịch này đã được xác nhận hoàn tiền rồi");
            if ($gd->trang_thai !== 'CHO_THANH_TOAN') throw AppException::badRequest("Chỉ có thể xác nhận giao dịch ở trạng thái CHO_THANH_TOAN");

            $don = DonDatTour::lockForUpdate()->find($gd->ma_dat_tour);
            if ($don->trang_thai !== 'CHO_HUY') throw AppException::badRequest("Chỉ có thể xác nhận hoàn tiền cho đơn ở trạng thái CHO_HUY. Trạng thái hiện tại: " . $don->trang_thai);

            $gd->trang_thai = 'DA_HOAN_TIEN';
            $gd->ngay_thanh_toan = Carbon::now();
            $gd->save();

            $tour = TourThucTe::lockForUpdate()->find($don->ma_tour_thuc_te);
            $soKhach = DB::table('chi_tiet_dat_tours')->where('ma_dat_tour', $don->ma_dat_tour)->count();
            $tour->cho_con_lai = min($tour->cho_con_lai + $soKhach, $tour->so_khach_toi_da);
            $tour->save();

            $don->trang_thai = 'DA_HUY';
            $don->save();

            return $gd;
        });
    }

    public function tuChoiHoanTien($maGiaoDich)
    {
        return DB::transaction(function() use ($maGiaoDich) {
            $gd = GiaoDich::lockForUpdate()->find($maGiaoDich);
            if (!$gd) throw AppException::notFound("Không tìm thấy giao dịch: " . $maGiaoDich);

            if ($gd->loai_giao_dich !== 'HOAN_TIEN') throw AppException::badRequest("Giao dịch này không phải hoàn tiền");
            if ($gd->trang_thai !== 'CHO_THANH_TOAN') throw AppException::badRequest("Chỉ có thể từ chối giao dịch hoàn tiền ở trạng thái CHO_THANH_TOAN");

            $don = DonDatTour::lockForUpdate()->find($gd->ma_dat_tour);
            if ($don->trang_thai !== 'CHO_HUY') throw AppException::badRequest("Chỉ có thể từ chối hoàn tiền cho đơn ở trạng thái CHO_HUY. Trạng thái hiện tại: " . $don->trang_thai);

            $gd->trang_thai = 'THAT_BAI';
            $gd->ngay_thanh_toan = Carbon::now();
            $gd->save();

            $don->trang_thai = 'TU_CHOI_HOAN_TIEN';
            $don->save();

            return $gd;
        });
    }

    // --- HELPERS ---

    private function capNhatQT(QuyetToan $qt, $maTour, array $req, $maTaiKhoan)
    {
        $doanhThu = $this->tinhDoanhThu($maTour);
        $chiPhi = $this->tinhChiPhi($maTour);

        $qt->tong_doanh_thu = $doanhThu;
        $qt->tong_chi_phi = $chiPhi;
        if (isset($req['giaCamKet'])) $qt->gia_cam_ket = $req['giaCamKet'];
        $qt->loi_nhuan = $doanhThu - $chiPhi;
        $qt->ngay_quyet_toan = Carbon::now();
        if (isset($req['ghiChu'])) $qt->ghi_chu = $req['ghiChu'];
        if (isset($req['hoaDonAnh'])) $qt->hoa_don_anh = $req['hoaDonAnh'];
        
        $qt->save();
        return $qt;
    }

    private function getKetThucTour($maTour)
    {
        $tour = TourThucTe::find($maTour);
        if (!$tour) throw AppException::notFound("Không tìm thấy tour: " . $maTour);

        if (!in_array($tour->trang_thai, ['KET_THUC', 'DA_QUYET_TOAN'])) {
            throw AppException::badRequest("Tour chưa kết thúc, không thể quyết toán.");
        }
        return $tour;
    }

    private function tinhDoanhThu($maTour)
    {
        return DonDatTour::where('ma_tour_thuc_te', $maTour)
            ->whereIn('trang_thai', ['DA_XAC_NHAN', 'CHO_HUY', 'CHO_HOAN_TIEN', 'TU_CHOI_HOAN_TIEN', 'HOAN_THANH'])
            ->sum('tong_tien');
    }

    private function tinhChiPhi($maTour)
    {
        return ChiPhiThucTe::where('ma_tour_thuc_te', $maTour)
            ->where('trang_thai_duyet', 'DA_DUYET')
            ->sum('thanh_tien');
    }

    private function noiGhiChuMoi($ghiChuHienTai, $marker, $noiDung)
    {
        $phanTruoc = empty($ghiChuHienTai) ? "" : $ghiChuHienTai . "\n\n";
        return $phanTruoc . $marker . " lúc " . Carbon::now()->toDateTimeString() . "]:\n" . trim($noiDung);
    }
}
