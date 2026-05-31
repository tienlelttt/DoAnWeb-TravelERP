<?php

namespace App\Services;

use App\Models\DonDatTour;
use App\Models\ChiTietDatTour;
use App\Models\ChiTietDichVu;
use App\Models\DsNguoiDongHanh;
use App\Models\HoChieuSo;
use App\Models\TourThucTe;
use App\Models\DichVuThem;
use App\Models\HanhDongXanh;
use App\Models\LichSuTour;
use App\Models\GiaoDich;
use App\Exceptions\AppException;
use App\Http\Resources\DonDatTourResource;
use App\Services\MaTuDongService;
use App\Services\VoucherService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatTourService
{
    const TUOI_TOI_DA_TRE_EM = 11;
    const MA_GD_DA_BAO_CHUYEN_KHOAN = "KHXN:";

    protected $maTuDongService;
    protected $voucherService;

    public function __construct(MaTuDongService $maTuDongService, VoucherService $voucherService)
    {
        $this->maTuDongService = $maTuDongService;
        $this->voucherService = $voucherService;
    }

    public function datTour($maTaiKhoan, array $data)
    {
        return DB::transaction(function () use ($maTaiKhoan, $data) {
            $khachHang = HoChieuSo::with('taiKhoan')->where('ma_tai_khoan', $maTaiKhoan)->first();
            if (!$khachHang) {
                throw AppException::notFound("Khách hàng chưa có hồ sơ. Vui lòng liên hệ hỗ trợ.");
            }

            $dsNguoiDongHanh = $data['danhSachNguoiDongHanh'] ?? [];
            $soKhach = 1 + count($dsNguoiDongHanh);

            // 1. Khóa row TourThucTe để kiểm tra chỗ (Pessimistic Locking)
            $tour = TourThucTe::lockForUpdate()->find($data['maTourThucTe']);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour thực tế: " . $data['maTourThucTe']);
            }
            if ($tour->trang_thai !== 'MO_BAN') {
                throw AppException::badRequest("Tour không ở trạng thái 'Mở bán', không thể đặt");
            }

            // Kiểm tra biên lợi nhuận (gia_hien_hanh >= gia_san)
            $tour->load('tourMau');
            if ($tour->tourMau && $tour->gia_hien_hanh < $tour->tourMau->gia_san) {
                throw AppException::badRequest("Giá hiện hành của tour thực tế không được thấp hơn giá sàn của tour mẫu");
            }

            if ($tour->cho_con_lai < $soKhach) {
                throw AppException::badRequest("Tour đã hết chỗ");
            }

            // 2. Tính tiền Khách (Người đặt)
            $tongTienTour = $this->tinhGiaVeTheoNgaySinh($tour->gia_hien_hanh, $khachHang->taiKhoan->ngay_sinh, $tour->ngay_khoi_hanh);
            
            // Tính tiền Đồng hành
            foreach ($dsNguoiDongHanh as $nguoi) {
                $tongTienTour += $this->tinhGiaVeTheoNgaySinh($tour->gia_hien_hanh, $nguoi['ngaySinh'] ?? null, $tour->ngay_khoi_hanh);
            }

            // 3. Xử lý Dịch Vụ Thêm
            $dsDichVu = [];
            $tongTienDichVu = 0;
            if (!empty($data['danhSachDichVu'])) {
                foreach ($data['danhSachDichVu'] as $dvReq) {
                    $dv = DichVuThem::find($dvReq['maDichVuThem']);
                    if (!$dv) {
                        throw AppException::notFound("Không tìm thấy dịch vụ thêm: " . $dvReq['maDichVuThem']);
                    }
                    
                    $thanhTien = $dv->don_gia * $dvReq['soLuong'];
                    $tongTienDichVu += $thanhTien;
                    
                    $dsDichVu[] = [
                        'dichVu' => $dv,
                        'soLuong' => $dvReq['soLuong'],
                        'donGia' => $dv->don_gia,
                        'thanhTien' => $thanhTien
                    ];
                }
            }

            $tongTien = $tongTienTour + $tongTienDichVu;

            // 4. Xử lý Hành Động Xanh
            $chuoiHanhDongXanh = '';
            if (!empty($data['danhSachHanhDongXanhChiTiet'])) {
                $parts = [];
                foreach ($data['danhSachHanhDongXanhChiTiet'] as $hdxReq) {
                    $hdx = HanhDongXanh::find($hdxReq['maHanhDongXanh']);
                    if ($hdx) {
                        $sl = $hdxReq['soLuong'] ?? 1;
                        $parts[] = $hdx->ma_hanh_dong_xanh . ':' . $sl . ':' . ($hdx->diem_cong ?: 0);
                    }
                }
                $chuoiHanhDongXanh = implode(',', $parts);
            }

            // 5. Tạo Đơn
            $don = new DonDatTour();
            $don->ma_dat_tour = $this->maTuDongService->taoMaDonDatTour();
            $don->ma_tour_thuc_te = $tour->ma_tour_thuc_te;
            $don->ma_khach_hang = $khachHang->ma_khach_hang;
            $don->ngay_dat = Carbon::now();
            $don->tong_tien = $tongTien;
            $don->trang_thai = 'CHO_XAC_NHAN';
            $don->thoi_gian_het_han = Carbon::now()->addDays(2);
            $don->ghi_chu = $data['ghiChu'] ?? null;
            $don->hanh_dong_xanh = $chuoiHanhDongXanh;
            $don->save();

            // Áp dụng voucher ngay khi đặt tour (nếu có truyền maVoucher)
            if (!empty($data['maVoucher'])) {
                $tienGiam = $this->voucherService->apDungVoucher($data['maVoucher'], $don, $tongTien);
                $don->tong_tien = $tongTien - $tienGiam;
                $don->save();
            }

            // 6. Tạo Chi tiết Người đặt
            $ctNguoiDat = new ChiTietDatTour();
            $ctNguoiDat->ma_chi_tiet_dat = $this->maTuDongService->taoMaChiTietDatTour();
            $ctNguoiDat->ma_dat_tour = $don->ma_dat_tour;
            $ctNguoiDat->ma_khach_hang = $khachHang->ma_khach_hang;
            $ctNguoiDat->loai_khach = 'NGUOI_DAT';
            $ctNguoiDat->gia_tai_thoi_diem_dat = $this->tinhGiaVeTheoNgaySinh($tour->gia_hien_hanh, $khachHang->taiKhoan->ngay_sinh, $tour->ngay_khoi_hanh);
            $ctNguoiDat->save();

            // 7. Tạo Chi tiết Đồng hành
            foreach ($dsNguoiDongHanh as $nguoiReq) {
                $ndh = new DsNguoiDongHanh();
                $ndh->ma_nguoi_dong_hanh = $this->maTuDongService->taoMaNguoiDongHanh();
                $ndh->ma_dat_tour = $don->ma_dat_tour;
                $ndh->ho_ten = $nguoiReq['hoTen'];
                $ndh->cccd = $nguoiReq['cccd'] ?? null;
                $ndh->so_dien_thoai = $nguoiReq['soDienThoai'] ?? null;
                $ndh->ngay_sinh = $nguoiReq['ngaySinh'];
                $ndh->gioi_tinh = $nguoiReq['gioiTinh'] ?? null;
                $ndh->ghi_chu = $nguoiReq['ghiChu'] ?? null;
                $ndh->save();

                $ctNguoiDongHanh = new ChiTietDatTour();
                $ctNguoiDongHanh->ma_chi_tiet_dat = $this->maTuDongService->taoMaChiTietDatTour();
                $ctNguoiDongHanh->ma_dat_tour = $don->ma_dat_tour;
                $ctNguoiDongHanh->ma_nguoi_dong_hanh = $ndh->ma_nguoi_dong_hanh;
                $ctNguoiDongHanh->loai_khach = 'NGUOI_DONG_HANH';
                $ctNguoiDongHanh->gia_tai_thoi_diem_dat = $this->tinhGiaVeTheoNgaySinh($tour->gia_hien_hanh, $nguoiReq['ngaySinh'], $tour->ngay_khoi_hanh);
                $ctNguoiDongHanh->save();
            }

            // 8. Lưu Dịch vụ chi tiết
            foreach ($dsDichVu as $dvItem) {
                $ctdv = new ChiTietDichVu();
                $ctdv->ma_chi_tiet_dich_vu = $this->maTuDongService->taoMaChiTietDichVu();
                $ctdv->ma_dat_tour = $don->ma_dat_tour;
                $ctdv->ma_dich_vu_them = $dvItem['dichVu']->ma_dich_vu_them;
                $ctdv->so_luong = $dvItem['soLuong'];
                $ctdv->don_gia = $dvItem['donGia'];
                $ctdv->thanh_tien = $dvItem['thanhTien'];
                $ctdv->save();
            }

            // 9. Giảm cho_con_lai của TourThucTe
            $tour->cho_con_lai -= $soKhach;
            $tour->save();

            $don->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem']);
            return new DonDatTourResource($don);
        });
    }

    private function tinhGiaVeTheoNgaySinh($giaNguoiLon, $ngaySinh, $ngayKhoiHanh)
    {
        if (!$ngaySinh) return $giaNguoiLon;
        $ngaySinh = Carbon::parse($ngaySinh);
        $ngayKhoiHanh = $ngayKhoiHanh ? Carbon::parse($ngayKhoiHanh) : Carbon::now();
        
        $tuoi = $ngaySinh->diffInYears($ngayKhoiHanh);
        if ($tuoi <= self::TUOI_TOI_DA_TRE_EM) {
            return $giaNguoiLon / 2;
        }
        return $giaNguoiLon;
    }

    public function danhSachCuaToi($maTaiKhoan, $perPage = 10)
    {
        $khachHang = HoChieuSo::with('taiKhoan')->where('ma_tai_khoan', $maTaiKhoan)->first();
        if (!$khachHang) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        $query = DonDatTour::with(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem'])
            ->where('ma_khach_hang', $khachHang->ma_khach_hang)
            ->orderBy('ngay_dat', 'desc');

        return DonDatTourResource::collection($query->paginate($perPage))->response()->getData(true);
    }

    public function chiTietCuaToi($maTaiKhoan, $maDatTour)
    {
        $khachHang = HoChieuSo::with('taiKhoan')->where('ma_tai_khoan', $maTaiKhoan)->first();
        if (!$khachHang) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        $don = DonDatTour::with(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem'])
            ->where('ma_khach_hang', $khachHang->ma_khach_hang)
            ->where('ma_dat_tour', $maDatTour)
            ->first();

        if (!$don) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
        }

        return new DonDatTourResource($don);
    }

    public function huyDatTour($maTaiKhoan, $maDatTour)
    {
        return DB::transaction(function () use ($maTaiKhoan, $maDatTour) {
            $khachHang = HoChieuSo::with('taiKhoan')->where('ma_tai_khoan', $maTaiKhoan)->first();
            if (!$khachHang) {
                throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
            }

            $don = DonDatTour::where('ma_khach_hang', $khachHang->ma_khach_hang)
                ->where('ma_dat_tour', $maDatTour)
                ->first();

            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->trang_thai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Chỉ có thể hủy đơn ở trạng thái CHO_XAC_NHAN. Trạng thái hiện tại: " . $don->trang_thai);
            }

            $giaoDich = GiaoDich::where('ma_dat_tour', $maDatTour)->where('trang_thai', 'CHO_THANH_TOAN')->first();
            if ($giaoDich && str_starts_with($giaoDich->ma_gdnh ?? '', self::MA_GD_DA_BAO_CHUYEN_KHOAN)) {
                throw AppException::badRequest("Đơn đã báo chuyển khoản, không thể tự hủy.");
            }

            $don->trang_thai = 'DA_HUY';
            $don->save();
        });
    }
}
