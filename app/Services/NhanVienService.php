<?php

namespace App\Services;

use App\Models\NhanVien;
use App\Models\PhanCongTour;
use App\Models\NangLucNhanVien;
use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\Collection;

class NhanVienService
{
    /**
     * Lấy hồ sơ nhân viên dựa trên mã tài khoản đang đăng nhập
     *
     * @param string $maTaiKhoan
     * @return NhanVien
     */
    public function layHoSoNhanVien(string $maTaiKhoan): NhanVien
    {
        $nhanVien = NhanVien::with('taiKhoan')->where('MaTaiKhoan', $maTaiKhoan)->first();

        if (!$nhanVien) {
            throw AppException::notFound("Không tìm thấy hồ sơ nhân viên cho tài khoản này.");
        }

        return $nhanVien;
    }

    /**
     * Lấy lịch công tác của nhân viên (Danh sách các tour được phân công)
     *
     * @param string $maNhanVien
     * @return Collection
     */
    public function layLichCongTac(string $maNhanVien): Collection
    {
        return PhanCongTour::with('tourThucTe')
            ->where('MaNhanVien', $maNhanVien)
            ->orderBy('NgayPhanCong', 'desc')
            ->get();
    }

    /**
     * Lấy năng lực của nhân viên
     *
     * @param string $maNhanVien
     * @return NangLucNhanVien|null
     */
    public function layNangLuc(string $maNhanVien): ?NangLucNhanVien
    {
        return NangLucNhanVien::where('MaNhanVien', $maNhanVien)->first();
    }
}
