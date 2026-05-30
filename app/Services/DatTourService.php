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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatTourService
{
    const TUOI_TOI_DA_TRE_EM = 11;
    const MA_GD_DA_BAO_CHUYEN_KHOAN = "KHXN:";

    public function datTour($maTaiKhoan, array $data)
    {
        return DB::transaction(function () use ($maTaiKhoan, $data) {
            $khachHang = HoChieuSo::with('taiKhoan')->where('MaTaiKhoan', $maTaiKhoan)->first();
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
            if ($tour->TrangThai !== 'MO_BAN') {
                throw AppException::badRequest("Tour không ở trạng thái 'Mở bán', không thể đặt");
            }
            if ($tour->ChoConLai < $soKhach) {
                throw AppException::badRequest("Tour đã hết chỗ");
            }

            // 2. Tính tiền Khách (Người đặt)
            $tongTienTour = $this->tinhGiaVeTheoNgaySinh($tour->GiaHienHanh, $khachHang->taiKhoan->NgaySinh, $tour->NgayKhoiHanh);
            
            // Tính tiền Đồng hành
            foreach ($dsNguoiDongHanh as $nguoi) {
                $tongTienTour += $this->tinhGiaVeTheoNgaySinh($tour->GiaHienHanh, $nguoi['ngaySinh'] ?? null, $tour->NgayKhoiHanh);
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
                    
                    $thanhTien = $dv->DonGia * $dvReq['soLuong'];
                    $tongTienDichVu += $thanhTien;
                    
                    $dsDichVu[] = [
                        'dichVu' => $dv,
                        'soLuong' => $dvReq['soLuong'],
                        'donGia' => $dv->DonGia,
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
                        $parts[] = $hdx->MaHanhDongXanh . ':' . $sl . ':' . ($hdx->DiemCong ?: 0);
                    }
                }
                $chuoiHanhDongXanh = implode(',', $parts);
            }

            // 5. Tạo Đơn
            $don = new DonDatTour();
            $don->MaDatTour = 'DDT_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            $don->MaTourThucTe = $tour->MaTourThucTe;
            $don->MaKhachHang = $khachHang->MaKhachHang;
            $don->NgayDat = Carbon::now();
            $don->TongTien = $tongTien;
            $don->TrangThai = 'CHO_XAC_NHAN';
            $don->ThoiGianHetHan = Carbon::now()->addDays(2);
            $don->GhiChu = $data['ghiChu'] ?? null;
            $don->HanhDongXanh = $chuoiHanhDongXanh;
            $don->save();

            // 6. Tạo Chi tiết Người đặt
            $ctNguoiDat = new ChiTietDatTour();
            $ctNguoiDat->MaChiTietDat = 'CTDT_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            $ctNguoiDat->MaDatTour = $don->MaDatTour;
            $ctNguoiDat->MaKhachHang = $khachHang->MaKhachHang;
            $ctNguoiDat->LoaiKhach = 'NGUOI_DAT';
            $ctNguoiDat->GiaTaiThoiDiemDat = $this->tinhGiaVeTheoNgaySinh($tour->GiaHienHanh, $khachHang->taiKhoan->NgaySinh, $tour->NgayKhoiHanh);
            $ctNguoiDat->save();

            // 7. Tạo Chi tiết Đồng hành
            foreach ($dsNguoiDongHanh as $nguoiReq) {
                $ndh = new DsNguoiDongHanh();
                $ndh->MaNguoiDongHanh = 'NDH_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
                $ndh->MaDatTour = $don->MaDatTour;
                $ndh->HoTen = $nguoiReq['hoTen'];
                $ndh->Cccd = $nguoiReq['cccd'] ?? null;
                $ndh->SoDienThoai = $nguoiReq['soDienThoai'] ?? null;
                $ndh->NgaySinh = $nguoiReq['ngaySinh'];
                $ndh->GioiTinh = $nguoiReq['gioiTinh'] ?? null;
                $ndh->GhiChu = $nguoiReq['ghiChu'] ?? null;
                $ndh->save();

                $ctNguoiDongHanh = new ChiTietDatTour();
                $ctNguoiDongHanh->MaChiTietDat = 'CTDT_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
                $ctNguoiDongHanh->MaDatTour = $don->MaDatTour;
                $ctNguoiDongHanh->MaNguoiDongHanh = $ndh->MaNguoiDongHanh;
                $ctNguoiDongHanh->LoaiKhach = 'NGUOI_DONG_HANH';
                $ctNguoiDongHanh->GiaTaiThoiDiemDat = $this->tinhGiaVeTheoNgaySinh($tour->GiaHienHanh, $nguoiReq['ngaySinh'], $tour->NgayKhoiHanh);
                $ctNguoiDongHanh->save();
            }

            // 8. Lưu Dịch vụ chi tiết
            foreach ($dsDichVu as $dvItem) {
                $ctdv = new ChiTietDichVu();
                $ctdv->MaChiTietDichVu = 'CTDV_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
                $ctdv->MaDatTour = $don->MaDatTour;
                $ctdv->MaDichVuThem = $dvItem['dichVu']->MaDichVuThem;
                $ctdv->SoLuong = $dvItem['soLuong'];
                $ctdv->DonGia = $dvItem['donGia'];
                $ctdv->ThanhTien = $dvItem['thanhTien'];
                $ctdv->save();
            }

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
        $khachHang = HoChieuSo::with('taiKhoan')->where('MaTaiKhoan', $maTaiKhoan)->first();
        if (!$khachHang) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        $query = DonDatTour::with(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem'])
            ->where('MaKhachHang', $khachHang->MaKhachHang)
            ->orderBy('NgayDat', 'desc');

        return DonDatTourResource::collection($query->paginate($perPage))->response()->getData(true);
    }

    public function chiTietCuaToi($maTaiKhoan, $maDatTour)
    {
        $khachHang = HoChieuSo::with('taiKhoan')->where('MaTaiKhoan', $maTaiKhoan)->first();
        if (!$khachHang) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        $don = DonDatTour::with(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem'])
            ->where('MaKhachHang', $khachHang->MaKhachHang)
            ->where('MaDatTour', $maDatTour)
            ->first();

        if (!$don) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
        }

        return new DonDatTourResource($don);
    }

    public function huyDatTour($maTaiKhoan, $maDatTour)
    {
        return DB::transaction(function () use ($maTaiKhoan, $maDatTour) {
            $khachHang = HoChieuSo::with('taiKhoan')->where('MaTaiKhoan', $maTaiKhoan)->first();
            if (!$khachHang) {
                throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
            }

            $don = DonDatTour::where('MaKhachHang', $khachHang->MaKhachHang)
                ->where('MaDatTour', $maDatTour)
                ->first();

            if (!$don) {
                throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
            }

            if ($don->TrangThai !== 'CHO_XAC_NHAN') {
                throw AppException::badRequest("Chỉ có thể hủy đơn ở trạng thái CHO_XAC_NHAN. Trạng thái hiện tại: " . $don->TrangThai);
            }

            $giaoDich = GiaoDich::where('MaDatTour', $maDatTour)->where('TrangThai', 'CHO_THANH_TOAN')->first();
            if ($giaoDich && str_starts_with($giaoDich->MaGDNH ?? '', self::MA_GD_DA_BAO_CHUYEN_KHOAN)) {
                throw AppException::badRequest("Đơn đã báo chuyển khoản, không thể tự hủy.");
            }

            $don->TrangThai = 'DA_HUY';
            $don->save();
        });
    }
}
