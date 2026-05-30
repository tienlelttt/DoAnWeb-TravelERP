<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\PhanCongTour;
use App\Models\NangLucNhanVien;
use App\Models\DanhGiaKh;
use App\Models\YeuCauHoTro;
use App\Models\GiaoDich;

class DonDatTourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $ttt = $this->tourThucTe;
        if (!$ttt) return [];

        $ngayTinhTuoi = $ttt->NgayKhoiHanh ? Carbon::parse($ttt->NgayKhoiHanh) : Carbon::now();

        // ── 1. Đếm Trẻ em / Người lớn ────────────────────────────────────────
        $soTreEm    = 0;
        $soNguoiLon = 0;
        foreach ($this->chiTietDatTours as $ct) {
            // Ưu tiên người đồng hành, sau đó mới là khách hàng chính
            if ($ct->nguoiDongHanh) {
                $ngaySinh = $ct->nguoiDongHanh->NgaySinh;
            } elseif ($ct->khachHang && $ct->khachHang->taiKhoan) {
                $ngaySinh = $ct->khachHang->taiKhoan->NgaySinh;
            } else {
                $ngaySinh = null;
            }

            if ($ngaySinh) {
                $tuoi = Carbon::parse($ngaySinh)->diffInYears($ngayTinhTuoi);
                if ($tuoi <= 11) {
                    $soTreEm++;
                } else {
                    $soNguoiLon++;
                }
            } else {
                $soNguoiLon++;
            }
        }

        // ── 2. Hướng dẫn viên (secondary query – giống Java toResponse) ───────
        // Wrap trong try/catch để không làm vỡ response nếu cột chưa migrate
        $phanCong = null;
        $nangLuc  = null;
        try {
            $phanCong = PhanCongTour::where('MaTourThucTe', $ttt->MaTourThucTe)
                ->where('TrangThaiChapNhan', 'DA_DONG_Y')
                ->first();
            $nangLuc = $phanCong
                ? NangLucNhanVien::where('MaNhanVien', $phanCong->MaNhanVien)->first()
                : null;
        } catch (\Throwable $e) {
            // Bảng chưa migrate hoặc cột chưa tồn tại → trả null, không crash
        }

        // ── 3. Khiếu nại ─────────────────────────────────────────────────────
        $trangThaiKhieuNai = null;
        try {
            $khieuNai = YeuCauHoTro::where('MaDatTour', $this->MaDatTour)
                ->where('LoaiYeuCau', 'KHIEU_NAI')
                ->first();
            $trangThaiKhieuNai = $khieuNai ? $khieuNai->TrangThai : null;
        } catch (\Throwable $e) {}

        // ── 4. Đã đánh giá ────────────────────────────────────────────────────
        $daDanhGia = false;
        try {
            $daDanhGia = DanhGiaKh::where('MaKhachHang', $this->MaKhachHang)
                ->where('MaTourThucTe', $ttt->MaTourThucTe)
                ->exists();
        } catch (\Throwable $e) {}

        // ── 5. Giao dịch thanh toán ───────────────────────────────────────────
        $maGiaoDich        = null;
        $phuongThuc        = null;
        $daBaoChuyenKhoan  = false;
        try {
            $giaoDich = GiaoDich::where('MaDatTour', $this->MaDatTour)->first();
            if ($giaoDich) {
                $maGiaoDich       = $giaoDich->MaGiaoDich;
                $phuongThuc       = $giaoDich->PhuongThuc;
                $daBaoChuyenKhoan = str_starts_with($giaoDich->MaGDNH ?? '', 'KHXN:');
            }
        } catch (\Throwable $e) {}

        // ── 6. Parse chuỗi Hành Động Xanh ────────────────────────────────────
        // Java: tinhDiemXanhDuKien(don.getHanhDongXanh())
        $hdxParsed    = [];
        $diemXanhDuKien = 0;
        if (!empty($this->HanhDongXanh)) {
            foreach (explode(',', $this->HanhDongXanh) as $item) {
                if (empty(trim($item))) continue;
                $parts = explode(':', trim($item));
                $soLuong  = isset($parts[1]) ? (int)$parts[1] : 1;
                $diemCong = isset($parts[2]) ? (int)$parts[2] : 0;
                $diemXanhDuKien += $soLuong * $diemCong;
                $hdxParsed[] = [
                    'maHanhDongXanh' => $parts[0],
                    'soLuong'        => $soLuong,
                    'diemCong'       => $diemCong,
                ];
            }
        }

        // ── 7. Map response (giống DonDatTourResponse.builder() Java) ─────────
        return [
            'maDatTour'               => $this->MaDatTour,
            'maTourThucTe'            => $ttt->MaTourThucTe,
            'tieuDeTour'              => $ttt->tourMau ? $ttt->tourMau->TieuDe : null,
            'ngayKhoiHanh'            => $ttt->NgayKhoiHanh
                                            ? Carbon::parse($ttt->NgayKhoiHanh)->format('Y-m-d')
                                            : null,
            'giaHienHanh'             => (float) $ttt->GiaHienHanh,
            'thoiLuong'               => $ttt->tourMau ? (int) $ttt->tourMau->ThoiLuong : null,
            'maKhachHang'             => $this->MaKhachHang,
            'tenKhachHang'            => $this->khachHang && $this->khachHang->taiKhoan
                                            ? $this->khachHang->taiKhoan->HoTen
                                            : null,
            'ngayDat'                 => $this->NgayDat
                                            ? Carbon::parse($this->NgayDat)->format('Y-m-d H:i:s')
                                            : null,
            'tongTien'                => (float) $this->TongTien,
            'tongTienGoc'             => (float) $this->TongTien, // Chưa có voucher
            'soTienUuDai'             => 0,
            'maVoucher'               => null,
            'maCodeVoucher'           => null,
            'diemXanhDuKien'          => $diemXanhDuKien,
            'trangThai'               => $this->TrangThai,
            'daBaoChuyenKhoan'        => $daBaoChuyenKhoan,
            'maGiaoDich'              => $maGiaoDich,
            'phuongThuc'              => $phuongThuc,
            'trangThaiTour'           => $ttt->TrangThai,
            'thoiGianHetHan'          => $this->ThoiGianHetHan
                                            ? Carbon::parse($this->ThoiGianHetHan)->format('Y-m-d H:i:s')
                                            : null,
            'ghiChu'                  => $this->GhiChu,
            'danhSachHanhDongXanh'    => $hdxParsed,
            'soNguoiLon'              => $soNguoiLon,
            'soTreEm'                 => $soTreEm,
            'tenHuongDanVien'         => ($phanCong && $phanCong->nhanVien && $phanCong->nhanVien->taiKhoan)
                                            ? $phanCong->nhanVien->taiKhoan->HoTen
                                            : null,
            'soDienThoaiHuongDanVien' => ($phanCong && $phanCong->nhanVien && $phanCong->nhanVien->taiKhoan)
                                            ? $phanCong->nhanVien->taiKhoan->SoDienThoai
                                            : null,
            'danhGiaHuongDanVien'     => $nangLuc ? (float) $nangLuc->DanhGia : null,
            'soDanhGiaHuongDanVien'   => $nangLuc ? (int) $nangLuc->SoDanhGia : null,
            'daDanhGia'               => $daDanhGia,
            'daKhieuNai'              => $trangThaiKhieuNai !== null,
            'trangThaiKhieuNai'       => $trangThaiKhieuNai,

            // ── Chi tiết hành khách (giống Java toChiTietResponse) ────────────
            'chiTietKhach'   => $this->chiTietDatTours->map(function ($ct) use ($ngayTinhTuoi) {
                // Ưu tiên NguoiDongHanh, sau mới dùng KhachHang
                $ndh     = $ct->nguoiDongHanh;
                $kh      = $ct->khachHang;
                $tkKh    = $kh ? $kh->taiKhoan : null;

                $ngaySinh = $ndh ? $ndh->NgaySinh : ($tkKh ? $tkKh->NgaySinh : null);
                $tuoi     = $ngaySinh
                    ? Carbon::parse($ngaySinh)->diffInYears($ngayTinhTuoi)
                    : null;
                $nhomTuoi = ($tuoi !== null && $tuoi <= 11) ? 'TRE_EM' : 'NGUOI_LON';

                // ghiChuYTe: Java gopGhiChuYTeVaDiUng
                $ghiChuYTe = null;
                if ($kh) {
                    $parts = [];
                    if (!empty($kh->GhiChuYTe)) $parts[] = $kh->GhiChuYTe;
                    if (!empty($kh->DiUng)) {
                        $allergy = trim($kh->DiUng);
                        $parts[] = 'Dị ứng ' . mb_strtolower(mb_substr($allergy, 0, 1)) . mb_substr($allergy, 1);
                    }
                    $ghiChuYTe = implode(' | ', $parts) ?: null;
                } elseif ($ndh) {
                    $ghiChuYTe = $ndh->GhiChu;
                }

                return [
                    'maChiTietDat'     => $ct->MaChiTietDat,
                    'loaiKhach'        => $ct->LoaiKhach,
                    'maKhachHang'      => $ct->MaKhachHang,
                    'maNguoiDongHanh'  => $ct->MaNguoiDongHanh,
                    'hoTen'            => $kh && $tkKh ? $tkKh->HoTen : ($ndh ? $ndh->HoTen : null),
                    'cccd'             => $kh && $tkKh ? $tkKh->Cccd  : ($ndh ? $ndh->Cccd  : null),
                    'soDienThoai'      => $kh && $tkKh ? $tkKh->SoDienThoai : ($ndh ? $ndh->SoDienThoai : null),
                    'ngaySinh'         => $ngaySinh
                                            ? Carbon::parse($ngaySinh)->format('Y-m-d')
                                            : null,
                    'tuoi'             => $tuoi,
                    'nhomTuoi'         => $nhomTuoi,
                    'gioiTinh'         => $ndh ? $ndh->GioiTinh : null,
                    'ghiChu'           => $ndh ? $ndh->GhiChu   : null,
                    'ghiChuYTe'        => $ghiChuYTe,
                    'giaTaiThoiDiemDat' => (float) $ct->GiaTaiThoiDiemDat,
                ];
            }),

            // ── Chi tiết dịch vụ (giống Java toDichVuResponse) ───────────────
            'chiTietDichVu'  => $this->chiTietDichVus->map(function ($cv) {
                return [
                    'maChiTietDichVu' => $cv->MaChiTietDichVu,
                    'maDichVuThem'    => $cv->MaDichVuThem,
                    'tenDichVu'       => $cv->dichVuThem ? $cv->dichVuThem->Ten        : null,
                    'donViTinh'       => $cv->dichVuThem ? $cv->dichVuThem->DonViTinh  : null,
                    'soLuong'         => (int)   $cv->SoLuong,
                    'donGia'          => (float) $cv->DonGia,
                    'thanhTien'       => (float) $cv->ThanhTien,
                ];
            }),
        ];
    }
}
