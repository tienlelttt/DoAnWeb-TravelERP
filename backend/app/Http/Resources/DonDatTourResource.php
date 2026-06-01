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

        $ngayTinhTuoi = $ttt->ngay_khoi_hanh ? Carbon::parse($ttt->ngay_khoi_hanh) : Carbon::now();

        // ── 0. Lấy thông tin Voucher ưu đãi ──────────────────────────────────
        $soTienUuDai = $this->datTourUuDai ? (float) $this->datTourUuDai->so_tien_uu_dai : 0.0;
        $tongTienGoc = (float) $this->tong_tien + $soTienUuDai;
        $maVoucher = $this->datTourUuDai ? $this->datTourUuDai->ma_voucher : null;
        $maCodeVoucher = ($this->datTourUuDai && $this->datTourUuDai->voucher) ? $this->datTourUuDai->voucher->ma_code : null;

        // ── 1. Đếm Trẻ em / Người lớn ────────────────────────────────────────
        $soTreEm    = 0;
        $soNguoiLon = 0;
        foreach ($this->chiTietDatTours as $ct) {
            // Ưu tiên người đồng hành, sau đó mới là khách hàng chính
            if ($ct->nguoiDongHanh) {
                $ngaySinh = $ct->nguoiDongHanh->ngay_sinh;
            } elseif ($ct->khachHang && $ct->khachHang->taiKhoan) {
                $ngaySinh = $ct->khachHang->taiKhoan->ngay_sinh;
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

        // ── 2. Hướng dẫn viên ───────────────────────────────────────────────
        // Wrap trong try/catch để không làm vỡ response nếu bảng phụ chưa sẵn sàng
        $phanCong = null;
        $nangLuc  = null;
        try {
            $phanCong = PhanCongTour::where('ma_tour_thuc_te', $ttt->ma_tour_thuc_te)
                ->where('trang_thai_chap_nhan', 'DA_DONG_Y')
                ->first();
            $nangLuc = $phanCong
                ? NangLucNhanVien::where('ma_nhan_vien', $phanCong->ma_nhan_vien)->first()
                : null;
        } catch (\Throwable $e) {
            // Bảng phụ hoặc cột chưa tồn tại thì trả null, không crash
        }

        // ── 3. Khiếu nại ─────────────────────────────────────────────────────
        $trangThaiKhieuNai = null;
        try {
            $khieuNai = YeuCauHoTro::where('ma_dat_tour', $this->ma_dat_tour)
                ->where('loai_yeu_cau', 'KHIEU_NAI')
                ->first();
            $trangThaiKhieuNai = $khieuNai ? $khieuNai->trang_thai : null;
        } catch (\Throwable $e) {}

        // ── 4. Đã đánh giá ────────────────────────────────────────────────────
        $daDanhGia = false;
        try {
            $daDanhGia = DanhGiaKh::where('ma_khach_hang', $this->ma_khach_hang)
                ->where('ma_tour_thuc_te', $ttt->ma_tour_thuc_te)
                ->exists();
        } catch (\Throwable $e) {}

        // ── 5. Giao dịch thanh toán ───────────────────────────────────────────
        $maGiaoDich        = null;
        $phuongThuc        = null;
        $daBaoChuyenKhoan  = false;
        try {
            $giaoDich = GiaoDich::where('ma_dat_tour', $this->ma_dat_tour)->first();
            if ($giaoDich) {
                $maGiaoDich       = $giaoDich->ma_giao_dich;
                $phuongThuc       = $giaoDich->phuong_thuc;
                $daBaoChuyenKhoan = str_starts_with($giaoDich->ma_gdnh ?? '', 'KHXN:');
            }
        } catch (\Throwable $e) {}

        // ── 6. Parse chuỗi Hành Động Xanh ────────────────────────────────────
        // Tính điểm xanh dự kiến từ chuỗi hành động xanh đã lưu.
        $hdxParsed    = [];
        $diemXanhDuKien = 0;
        if (!empty($this->hanh_dong_xanh)) {
            foreach (explode(',', $this->hanh_dong_xanh) as $item) {
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

        // ── 7. Map response theo contract frontend ───────────────────────────
        return [
            'maDatTour'               => $this->ma_dat_tour,
            'maTourThucTe'            => $ttt->ma_tour_thuc_te,
            'tieuDeTour'              => $ttt->tourMau ? $ttt->tourMau->tieu_de : null,
            'ngayKhoiHanh'            => $ttt->ngay_khoi_hanh
                                            ? Carbon::parse($ttt->ngay_khoi_hanh)->format('Y-m-d')
                                            : null,
            'giaHienHanh'             => (float) $ttt->gia_hien_hanh,
            'thoiLuong'               => $ttt->tourMau ? (int) $ttt->tourMau->thoi_luong : null,
            'maKhachHang'             => $this->ma_khach_hang,
            'tenKhachHang'            => $this->khachHang && $this->khachHang->taiKhoan
                                            ? $this->khachHang->taiKhoan->ho_ten
                                            : null,
            'ngayDat'                 => $this->ngay_dat
                                            ? Carbon::parse($this->ngay_dat)->format('Y-m-d H:i:s')
                                            : null,
            'tongTien'                => (float) $this->tong_tien,
            'tongTienGoc'             => (float) $tongTienGoc,
            'soTienUuDai'             => (float) $soTienUuDai,
            'maVoucher'               => $maVoucher,
            'maCodeVoucher'           => $maCodeVoucher,
            'diemXanhDuKien'          => $diemXanhDuKien,
            'trangThai'               => $this->trang_thai,
            'daBaoChuyenKhoan'        => $daBaoChuyenKhoan,
            'maGiaoDich'              => $maGiaoDich,
            'phuongThuc'              => $phuongThuc,
            'trangThaiTour'           => $ttt->trang_thai,
            'thoiGianHetHan'          => $this->thoi_gian_het_han
                                            ? Carbon::parse($this->thoi_gian_het_han)->format('Y-m-d H:i:s')
                                            : null,
            'ghiChu'                  => $this->ghi_chu,
            'danhSachHanhDongXanh'    => $hdxParsed,
            'soNguoiLon'              => $soNguoiLon,
            'soTreEm'                 => $soTreEm,
            'tenHuongDanVien'         => ($phanCong && $phanCong->nhanVien && $phanCong->nhanVien->taiKhoan)
                                            ? $phanCong->nhanVien->taiKhoan->ho_ten
                                            : null,
            'maHuongDanVien'          => ($phanCong && $phanCong->nhanVien)
                                            ? $phanCong->nhanVien->ma_nhan_vien
                                            : null,
            'soDienThoaiHuongDanVien' => ($phanCong && $phanCong->nhanVien && $phanCong->nhanVien->taiKhoan)
                                            ? $phanCong->nhanVien->taiKhoan->so_dien_thoai
                                            : null,
            'danhGiaHuongDanVien'     => $nangLuc ? (float) $nangLuc->danh_gia : null,
            'soDanhGiaHuongDanVien'   => $nangLuc ? (int) $nangLuc->so_danh_gia : null,
            'daDanhGia'               => $daDanhGia,
            'daKhieuNai'              => $trangThaiKhieuNai !== null,
            'trangThaiKhieuNai'       => $trangThaiKhieuNai,

            // ── Chi tiết hành khách ──────────────────────────────────────────
            'chiTietKhach'   => $this->chiTietDatTours->map(function ($ct) use ($ngayTinhTuoi) {
                // Ưu tiên NguoiDongHanh, sau mới dùng KhachHang
                $ndh     = $ct->nguoiDongHanh;
                $kh      = $ct->khachHang;
                $tkKh    = $kh ? $kh->taiKhoan : null;

                $ngaySinh = $ndh ? $ndh->ngay_sinh : ($tkKh ? $tkKh->ngay_sinh : null);
                $tuoi     = $ngaySinh
                    ? Carbon::parse($ngaySinh)->diffInYears($ngayTinhTuoi)
                    : null;
                $nhomTuoi = ($tuoi !== null && $tuoi <= 11) ? 'TRE_EM' : 'NGUOI_LON';

                // Gộp ghi chú y tế và dị ứng vào một chuỗi hiển thị.
                $ghiChuYTe = null;
                if ($kh) {
                    $parts = [];
                    if (!empty($kh->ghi_chu_y_te)) $parts[] = $kh->ghi_chu_y_te;
                    if (!empty($kh->di_ung)) {
                        $allergy = trim($kh->di_ung);
                        $parts[] = 'Dị ứng ' . mb_strtolower(mb_substr($allergy, 0, 1)) . mb_substr($allergy, 1);
                    }
                    $ghiChuYTe = implode(' | ', $parts) ?: null;
                } elseif ($ndh) {
                    $ghiChuYTe = $ndh->ghi_chu;
                }

                return [
                    'maChiTietDat'     => $ct->ma_chi_tiet_dat,
                    'loaiKhach'        => $ct->loai_khach,
                    'maKhachHang'      => $ct->ma_khach_hang,
                    'maNguoiDongHanh'  => $ct->ma_nguoi_dong_hanh,
                    'hoTen'            => $kh && $tkKh ? $tkKh->ho_ten : ($ndh ? $ndh->ho_ten : null),
                    'cccd'             => $kh && $tkKh ? $tkKh->cccd  : ($ndh ? $ndh->cccd  : null),
                    'soDienThoai'      => $kh && $tkKh ? $tkKh->so_dien_thoai : ($ndh ? $ndh->so_dien_thoai : null),
                    'ngaySinh'         => $ngaySinh
                                            ? Carbon::parse($ngaySinh)->format('Y-m-d')
                                            : null,
                    'tuoi'             => $tuoi,
                    'nhomTuoi'         => $nhomTuoi,
                    'gioiTinh'         => $ndh ? $ndh->gioi_tinh : null,
                    'ghiChu'           => $ndh ? $ndh->ghi_chu   : null,
                    'ghiChuYTe'        => $ghiChuYTe,
                    'giaTaiThoiDiemDat' => (float) $ct->gia_tai_thoi_diem_dat,
                ];
            }),

            // ── Chi tiết dịch vụ ─────────────────────────────────────────────
            'chiTietDichVu'  => $this->chiTietDichVus->map(function ($cv) {
                return [
                    'maChiTietDichVu' => $cv->ma_chi_tiet_dich_vu,
                    'maDichVuThem'    => $cv->ma_dich_vu_them,
                    'tenDichVu'       => $cv->dichVuThem ? $cv->dichVuThem->ten        : null,
                    'donViTinh'       => $cv->dichVuThem ? $cv->dichVuThem->don_vi_tinh  : null,
                    'soLuong'         => (int)   $cv->so_luong,
                    'donGia'          => (float) $cv->don_gia,
                    'thanhTien'       => (float) $cv->thanh_tien,
                ];
            }),
        ];
    }
}
