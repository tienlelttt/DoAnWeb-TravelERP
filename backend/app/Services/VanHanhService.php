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
    private const TRANG_THAI_DON_DA_XAC_NHAN = ['DA_XAC_NHAN', 'DA_THANH_TOAN', 'HOAN_THANH'];

    protected MaTuDongService $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    /**
     * Kiểm tra xem HDV có quyền tác nghiệp trên Tour thực tế này không
     */
    private function checkQuyenHDV(string $maTourThucTe, string $maNhanVien, bool $allowPending = false): TourThucTe
    {
        $query = PhanCongTour::where('ma_tour_thuc_te', $maTourThucTe)
            ->where('ma_nhan_vien', $maNhanVien);

        if (!$allowPending) {
            $query->where('trang_thai_chap_nhan', 'DA_DONG_Y');
        } else {
            $query->whereIn('trang_thai_chap_nhan', ['DA_DONG_Y', 'CHO_PHAN_HOI']);
        }

        $phanCong = $query->first();

        if (!$phanCong) {
            throw AppException::forbidden("Bạn không được phân công hoặc chưa đồng ý tham gia tour này");
        }

        $tour = TourThucTe::where('ma_tour_thuc_te', $maTourThucTe)->first();
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy thông tin tour");
        }
        
        return $tour;
    }

    private function kiemTraTourTonTai(string $maTourThucTe): TourThucTe
    {
        $tour = TourThucTe::where('ma_tour_thuc_te', $maTourThucTe)->first();
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy thông tin tour");
        }

        return $tour;
    }

    public function layLichTrinh(string $maTourThucTe, string $maNhanVien)
    {
        $tour = $this->checkQuyenHDV($maTourThucTe, $maNhanVien, true);
        return LichTrinhTour::where('ma_tour_mau', $tour->ma_tour_mau)
            ->orderBy('ngay_thu')
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
        $donDatTours = DonDatTour::where('ma_tour_thuc_te', $maTourThucTe)
            ->whereIn('trang_thai', self::TRANG_THAI_DON_DA_XAC_NHAN)
            ->with([
                'chiTietDatTours.khachHang.taiKhoan',
                'chiTietDatTours.nguoiDongHanh',
            ])
            ->get();

        // Lấy trạng thái điểm danh mới nhất của tour
        $diemDanhMap = \App\Models\DiemDanh::where('ma_tour_thuc_te', $maTourThucTe)
            ->orderBy('thoi_gian', 'desc')
            ->get()
            ->keyBy(function ($dd) {
                return $dd->ma_khach_hang ?? $dd->ma_nguoi_dong_hanh;
            });

        $danhSach = [];
        foreach ($donDatTours as $don) {
            foreach ($don->chiTietDatTours as $ct) {
                if ($ct->khachHang) {
                    $kh = $ct->khachHang;
                    $tk = $kh->taiKhoan;
                    $dd = $diemDanhMap[$kh->ma_khach_hang] ?? null;
                    $danhSach[] = [
                        'maDatTour'       => $ct->ma_dat_tour,
                        'maKhachHang'     => $kh->ma_khach_hang,
                        'maNguoiDongHanh' => null,
                        'loaiKhach'       => $ct->loai_khach ?? 'NGUOI_DAT',
                        'hoTenKhachHang'  => $tk->ho_ten ?? $kh->ho_ten ?? '',
                        'soDienThoai'     => $tk->so_dien_thoai ?? '',
                        'hangThanhVien'   => $kh->hang_thanh_vien ?? 'THANH_VIEN',
                        'diemXanh'        => $kh->diem_xanh ?? 0,
                        'ghiChuYTe'       => $kh->ghi_chu_y_te ?? null,
                        'diUng'           => $kh->di_ung ?? null,
                        'trangThai'       => $dd ? $dd->trang_thai : 'CHUA_DIEM_DANH',
                    ];
                }
                if ($ct->nguoiDongHanh) {
                    $ndh = $ct->nguoiDongHanh;
                    $dd = $diemDanhMap[$ndh->ma_nguoi_dong_hanh] ?? null;
                    $danhSach[] = [
                        'maDatTour'       => $ct->ma_dat_tour,
                        'maKhachHang'     => null,
                        'maNguoiDongHanh' => $ndh->ma_nguoi_dong_hanh,
                        'loaiKhach'       => 'NGUOI_DONG_HANH',
                        'hoTenKhachHang'  => $ndh->ho_ten ?? '',
                        'soDienThoai'     => $ndh->so_dien_thoai ?? '',
                        'hangThanhVien'   => 'THANH_VIEN',
                        'diemXanh'        => 0,
                        'ghiChuYTe'       => $ndh->ghi_chu ?? null,
                        'diUng'           => null,
                        'trangThai'       => $dd ? $dd->trang_thai : 'CHUA_DIEM_DANH',
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
        if (!in_array($tour->trang_thai, ['CHO_KICH_HOAT', 'MO_BAN', 'DANG_DIEN_RA'])) {
            throw AppException::badRequest("Trạng thái tour hiện tại không cho phép điểm danh");
        }

        $maDiemDanh = $this->maTuDongService->taoMaDiemDanh();
        $diemDanh = new DiemDanh();
        $diemDanh->ma_diem_danh = $maDiemDanh;
        $diemDanh->ma_tour_thuc_te = $maTourThucTe;
        $diemDanh->ma_khach_hang = $data['maKhachHang'] ?? null;
        $diemDanh->ma_nguoi_dong_hanh = $data['maNguoiDongHanh'] ?? null;
        $diemDanh->loai_khach = $data['loaiKhach'];
        $diemDanh->ma_nhan_vien = $maNhanVien;
        $diemDanh->thoi_gian = now();
        $diemDanh->dia_diem = $data['diaDiem'] ?? null;
        $diemDanh->trang_thai = $data['trangThai']; // DA_DIEM_DANH, VANG
        $diemDanh->save();

        return $diemDanh;
    }

    public function ghiNhanHanhDongXanh(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        $exists = HanhDong::where('ma_tour_thuc_te', $maTourThucTe)
            ->where('ma_khach_hang', $data['maKhachHang'])
            ->where('ma_hanh_dong_xanh', $data['maHanhDongXanh'])
            ->exists();

        if ($exists) {
            throw AppException::badRequest("Khách hàng này đã được xác nhận điểm cho hành động xanh này rồi!");
        }

        $maGhiNhan = $this->maTuDongService->taoMaGhiNhanHanhDong();
        $hanhDong = new HanhDong();
        $hanhDong->ma_ghi_nhan_hanh_dong = $maGhiNhan;
        $hanhDong->ma_tour_thuc_te = $maTourThucTe;
        $hanhDong->ma_khach_hang = $data['maKhachHang'];
        $hanhDong->ma_hanh_dong_xanh = $data['maHanhDongXanh'];
        $hanhDong->ma_nhan_vien_xac_minh = $maNhanVien;
        $hanhDong->thoi_gian = now();
        $hanhDong->minh_chung = $data['minhChung'] ?? null;
        $hanhDong->save();

        return $hanhDong;
    }

    public function layDanhSachSuCo(string $maTourThucTe, string $maNhanVien, int $perPage = 15)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);
        return NhatKySuCo::where('ma_tour_thuc_te', $maTourThucTe)
            ->where('ma_nhan_vien_bao_cao', $maNhanVien)
            ->orderBy('thoi_gian_bao_cao', 'desc')
            ->paginate($perPage);
    }

    public function layDanhSachSuCoDieuHanh(string $maTourThucTe, int $perPage = 15)
    {
        $this->kiemTraTourTonTai($maTourThucTe);

        return NhatKySuCo::where('ma_tour_thuc_te', $maTourThucTe)
            ->orderBy('thoi_gian_bao_cao', 'desc')
            ->paginate($perPage);
    }

    public function baoCaoSuCo(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        $maSuCo = $this->maTuDongService->taoMaNhatKySuCo();
        $suCo = new NhatKySuCo();
        $suCo->ma_nhat_ky_su_co = $maSuCo;
        $suCo->ma_tour_thuc_te = $maTourThucTe;
        $suCo->ma_nhan_vien_bao_cao = $maNhanVien;
        $suCo->ma_khach_hang = $data['maKhachHang'] ?? null;
        $suCo->ma_nguoi_dong_hanh = $data['maNguoiDongHanh'] ?? null;
        $suCo->mo_ta = $data['moTa'];
        $suCo->giai_phap = $data['giaiPhap'] ?? null;
        $suCo->muc_do = $data['mucDo']; // THAP, SOS
        $suCo->loai_su_co = $data['loaiSuCo']; // Y_TE, THOI_TIET...
        $suCo->thoi_gian_bao_cao = now();
        $suCo->save();

        return $suCo;
    }

    public function capNhatSuCo(string $maSuCo, string $maNhanVien, array $data)
    {
        $suCo = NhatKySuCo::where('ma_nhat_ky_su_co', $maSuCo)->where('ma_nhan_vien_bao_cao', $maNhanVien)->first();
        if (!$suCo) {
            throw AppException::notFound("Không tìm thấy sự cố do bạn báo cáo");
        }
        
        $suCo->mo_ta = $data['moTa'] ?? $suCo->mo_ta;
        $suCo->giai_phap = $data['giaiPhap'] ?? $suCo->giai_phap;
        $suCo->save();
        return $suCo;
    }

    public function layDanhSachChiPhi(string $maTourThucTe, string $maNhanVien, int $perPage = 15)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);
        return ChiPhiThucTe::where('ma_tour_thuc_te', $maTourThucTe)
            ->where('ma_nhan_vien', $maNhanVien)
            ->orderBy('ngay_khai', 'desc')
            ->paginate($perPage);
    }

    public function layDanhSachChiPhiDieuHanh(string $maTourThucTe, int $perPage = 15)
    {
        $this->kiemTraTourTonTai($maTourThucTe);

        return ChiPhiThucTe::where('ma_tour_thuc_te', $maTourThucTe)
            ->orderBy('ngay_khai', 'desc')
            ->paginate($perPage);
    }

    public function khaiBaoChiPhi(string $maTourThucTe, string $maNhanVien, array $data)
    {
        $this->checkQuyenHDV($maTourThucTe, $maNhanVien);

        $maChiPhi = $this->maTuDongService->taoMaChiPhiThucTe();
        $chiPhi = new ChiPhiThucTe();
        $chiPhi->ma_chi_phi_thuc_te = $maChiPhi;
        $chiPhi->ma_tour_thuc_te = $maTourThucTe;
        $chiPhi->ma_nhan_vien = $maNhanVien;
        $chiPhi->danh_muc = $data['danhMuc'];
        $chiPhi->thanh_tien = $data['thanhTien'];
        $chiPhi->hoa_don_anh = $data['hoaDonAnh'] ?? null;
        $chiPhi->ghi_chu = $data['ghiChu'] ?? null;
        $chiPhi->trang_thai_duyet = 'CHO_DUYET';
        $chiPhi->ngay_khai = now();
        $chiPhi->ngay_khai = now();
        $chiPhi->save();

        return $chiPhi;
    }

    public function boSungChiPhi(string $maChiPhi, string $maNhanVien, array $data)
    {
        $chiPhi = ChiPhiThucTe::where('ma_chi_phi_thuc_te', $maChiPhi)->where('ma_nhan_vien', $maNhanVien)->first();
        if (!$chiPhi) {
            throw AppException::notFound("Không tìm thấy khoản chi phí này");
        }

        if ($chiPhi->trang_thai_duyet !== 'YEU_CAU_BO_SUNG') {
            throw AppException::badRequest("Chỉ được bổ sung khi có yêu cầu từ kế toán");
        }

        $chiPhi->hoa_don_anh = $data['hoaDonAnh'] ?? $chiPhi->hoa_don_anh;
        $chiPhi->trang_thai_duyet = 'CHO_DUYET';
        $chiPhi->save();

        return $chiPhi;
    }

    public function huyChiPhi(string $maChiPhi, string $maHdv)
    {
        $chiPhi = ChiPhiThucTe::where('ma_chi_phi_thuc_te', $maChiPhi)
            ->where('ma_nhan_vien', $maHdv)
            ->first();

        if (!$chiPhi) {
            throw AppException::notFound("Không tìm thấy chi phí này");
        }
        
        if ($chiPhi->trang_thai_duyet !== 'CHO_DUYET') {
            throw AppException::badRequest("Chỉ được hủy các chi phí đang chờ duyệt");
        }

        $chiPhi->delete();
    }
}
