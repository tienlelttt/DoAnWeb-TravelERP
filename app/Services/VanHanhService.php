<?php

namespace App\Services;

use App\Models\TourThucTe;
use App\Models\LichTrinhTour;
use App\Models\DonDatTour;
use App\Models\DiemDanh;
use App\Models\HanhDong;
use App\Models\NhatKySuCo;
use App\Models\ChiPhiThucTe;
use App\Models\PhanCongTour;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VanHanhService
{
    protected MaTuDongService $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    /**
     * Kiểm tra xem HDV có quyền tác nghiệp trên Tour thực tế này không
     */
    private function checkQuyenHDV(string $maTourThucTe, string $maNhanVien): TourThucTe
    {
        $phanCong = PhanCongTour::where('MaTourThucTe', $maTourThucTe)
            ->where('MaNhanVien', $maNhanVien)
            ->where('TrangThaiChapNhan', 'DA_DONG_Y')
            ->first();

        if (!$phanCong) {
            throw AppException::forbidden("Bạn không được phân công hoặc chưa đồng ý tham gia tour này");
        }

        $tour = TourThucTe::where('MaTourThucTe', $maTourThucTe)->first();
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy thông tin tour");
        }
        
        return $tour;
    }

    private function kiemTraTourTonTai(string $maTourThucTe): TourThucTe
    {
        $tour = TourThucTe::where('MaTourThucTe', $maTourThucTe)->first();
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy thông tin tour");
        }

        return $tour;
    }

    public function layLichTrinh(string $maTourThucTe, string $maNhanVien)
    {
        $tour = $this->checkQuyenHDV($maTourThucTe, $maNhanVien);
        return LichTrinhTour::where('MaTourMau', $tour->MaTourMau)
            ->orderBy('NgayThu')
            ->get();
    }

    public function layDanhSachKhach(string $maTourThucTe, string $maNhanVien)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        return $this->layDanhSachKhachTheoTour($maTourThucTe);
    }

    public function layDanhSachKhachDieuHanh(string $maTourThucTe)
    {
        $this->kiemTraTourTonTai($maTourThucTe);
        return $this->layDanhSachKhachTheoTour($maTourThucTe);
    }

    private function layDanhSachKhachTheoTour(string $maTourThucTe): array
    {
        $donDatTours = DonDatTour::where('MaTourThucTe', $maTourThucTe)
            ->where('TrangThai', 'DA_THANH_TOAN')
            ->with(['chiTietDatTours.khachHang', 'chiTietDatTours.nguoiDongHanh'])
            ->get();
            
        $danhSach = [];
        foreach ($donDatTours as $don) {
            foreach ($don->chiTietDatTours as $ct) {
                if ($ct->khachHang) {
                    $danhSach[] = [
                        'LoaiKhach' => 'KHACH_CHINH',
                        'MaKhachHang' => $ct->MaKhachHang,
                        'HoTen' => $ct->khachHang->HoTen ?? '',
                        'GhiChu' => $ct->GhiChu
                    ];
                }
                if ($ct->nguoiDongHanh) {
                    $danhSach[] = [
                        'LoaiKhach' => 'NGUOI_DONG_HANH',
                        'MaNguoiDongHanh' => $ct->MaNguoiDongHanh,
                        'HoTen' => $ct->nguoiDongHanh->HoTen ?? '',
                        'GhiChu' => $ct->GhiChu
                    ];
                }
            }
        }
        return $danhSach;
    }

    public function diemDanh(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $tour = $this->checkQuyenHDV($maTourThucTe, $maNhanVien);
        
        // Thường chỉ cho điểm danh khi tour DANG_DIEN_RA, có thể linh động theo design.
        if (!in_array($tour->TrangThai, ['CHO_KICH_HOAT', 'MO_BAN', 'DANG_DIEN_RA'])) {
            throw AppException::badRequest("Trạng thái tour hiện tại không cho phép điểm danh");
        }

        $maDiemDanh = $this->maTuDongService->taoMaDiemDanh();
        $diemDanh = new DiemDanh();
        $diemDanh->MaDiemDanh = $maDiemDanh;
        $diemDanh->MaTourThucTe = $maTourThucTe;
        $diemDanh->MaKhachHang = $data['maKhachHang'] ?? null;
        $diemDanh->MaNguoiDongHanh = $data['maNguoiDongHanh'] ?? null;
        $diemDanh->LoaiKhach = $data['loaiKhach'];
        $diemDanh->MaNhanVien = $maNhanVien;
        $diemDanh->ThoiGian = now();
        $diemDanh->DiaDiem = $data['diaDiem'] ?? null;
        $diemDanh->TrangThai = $data['trangThai']; // DA_DIEM_DANH, VANG
        $diemDanh->save();

        return $diemDanh;
    }

    public function ghiNhanHanhDongXanh(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        $maGhiNhan = $this->maTuDongService->taoMaGhiNhanHanhDong();
        $hanhDong = new HanhDong();
        $hanhDong->MaGhiNhanHanhDong = $maGhiNhan;
        $hanhDong->MaTourThucTe = $maTourThucTe;
        $hanhDong->MaKhachHang = $data['maKhachHang'];
        $hanhDong->MaHanhDongXanh = $data['maHanhDongXanh'];
        $hanhDong->MaNhanVienXacMinh = $maNhanVien;
        $hanhDong->ThoiGian = now();
        $hanhDong->MinhChung = $data['minhChung'] ?? null;
        $hanhDong->save();

        return $hanhDong;
    }

    public function layDanhSachSuCo(string $maTourThucTe, string $maNhanVien)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);
        return NhatKySuCo::where('MaTourThucTe', $maTourThucTe)
            ->where('MaNhanVienBaoCao', $maNhanVien)
            ->orderBy('ThoiGianBaoCao', 'desc')
            ->get();
    }

    public function layDanhSachSuCoDieuHanh(string $maTourThucTe)
    {
        $this->kiemTraTourTonTai($maTourThucTe);

        return NhatKySuCo::where('MaTourThucTe', $maTourThucTe)
            ->orderBy('ThoiGianBaoCao', 'desc')
            ->get();
    }

    public function baoCaoSuCo(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        $maSuCo = $this->maTuDongService->taoMaNhatKySuCo();
        $suCo = new NhatKySuCo();
        $suCo->MaNhatKySuCo = $maSuCo;
        $suCo->MaTourThucTe = $maTourThucTe;
        $suCo->MaNhanVienBaoCao = $maNhanVien;
        $suCo->MaKhachHang = $data['maKhachHang'] ?? null;
        $suCo->MaNguoiDongHanh = $data['maNguoiDongHanh'] ?? null;
        $suCo->MoTa = $data['moTa'];
        $suCo->GiaiPhap = $data['giaiPhap'] ?? null;
        $suCo->MucDo = $data['mucDo']; // THAP, SOS
        $suCo->LoaiSuCo = $data['loaiSuCo']; // Y_TE, THOI_TIET...
        $suCo->ThoiGianBaoCao = now();
        $suCo->save();

        return $suCo;
    }

    public function capNhatSuCo(string $maSuCo, string $maNhanVien, array $data)
    {
        $suCo = NhatKySuCo::where('MaNhatKySuCo', $maSuCo)->where('MaNhanVienBaoCao', $maNhanVien)->first();
        if (!$suCo) {
            throw AppException::notFound("Không tìm thấy sự cố do bạn báo cáo");
        }
        
        $suCo->MoTa = $data['moTa'] ?? $suCo->MoTa;
        $suCo->GiaiPhap = $data['giaiPhap'] ?? $suCo->GiaiPhap;
        $suCo->save();
        return $suCo;
    }

    public function layDanhSachChiPhi(string $maTourThucTe, string $maNhanVien)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);
        return ChiPhiThucTe::where('MaTourThucTe', $maTourThucTe)
            ->where('MaNhanVien', $maNhanVien)
            ->orderBy('NgayKhai', 'desc')
            ->get();
    }

    public function layDanhSachChiPhiDieuHanh(string $maTourThucTe)
    {
        $this->kiemTraTourTonTai($maTourThucTe);

        return ChiPhiThucTe::where('MaTourThucTe', $maTourThucTe)
            ->orderBy('NgayKhai', 'desc')
            ->get();
    }

    public function khaiBaoChiPhi(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        $maChiPhi = $this->maTuDongService->taoMaChiPhiThucTe();
        $chiPhi = new ChiPhiThucTe();
        $chiPhi->MaChiPhiThucTe = $maChiPhi;
        $chiPhi->MaTourThucTe = $maTourThucTe;
        $chiPhi->MaNhanVien = $maNhanVien;
        $chiPhi->DanhMuc = $data['danhMuc'];
        $chiPhi->ThanhTien = $data['thanhTien'];
        $chiPhi->HoaDonAnh = $data['hoaDonAnh'] ?? null;
        $chiPhi->TrangThaiDuyet = 'CHO_DUYET';
        $chiPhi->NgayKhai = now();
        $chiPhi->save();

        return $chiPhi;
    }

    public function boSungChiPhi(string $maChiPhi, string $maNhanVien, array $data)
    {
        $chiPhi = ChiPhiThucTe::where('MaChiPhiThucTe', $maChiPhi)->where('MaNhanVien', $maNhanVien)->first();
        if (!$chiPhi) {
            throw AppException::notFound("Không tìm thấy khoản chi phí này");
        }

        if ($chiPhi->TrangThaiDuyet !== 'YEU_CAU_BO_SUNG') {
            throw AppException::badRequest("Chỉ được bổ sung khi có yêu cầu từ kế toán");
        }

        $chiPhi->HoaDonAnh = $data['hoaDonAnh'] ?? $chiPhi->HoaDonAnh;
        $chiPhi->TrangThaiDuyet = 'CHO_DUYET';
        $chiPhi->save();

        return $chiPhi;
    }
}
