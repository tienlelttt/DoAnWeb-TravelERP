<?php

namespace App\Services;

use App\Models\HoChieuSo;
use App\Models\TaiKhoan;
use App\Models\DonDatTour;
use App\Models\YeuCauHoTro;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KhachHangService
{
    protected MaTuDongService $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    private function getHoChieuSo(string $maTaiKhoan): HoChieuSo
    {
        $hcs = HoChieuSo::with("taiKhoan")->where("MaTaiKhoan", $maTaiKhoan)->first();
        if (!$hcs) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }
        return $hcs;
    }

    public function layHoSo(string $maTaiKhoan)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        
        return [
            "maKhachHang" => $hcs->MaKhachHang,
            "hoTen" => $hcs->taiKhoan->HoTen,
            "email" => $hcs->taiKhoan->Email,
            "soDienThoai" => $hcs->taiKhoan->SoDienThoai,
            "cccd" => $hcs->taiKhoan->CCCD,
            "ngaySinh" => $hcs->taiKhoan->NgaySinh,
            "ghiChuYTe" => $hcs->GhiChuYTe,
            "diUng" => $hcs->DiUng,
            "hangThanhVien" => $hcs->HangThanhVien,
            "diemXanh" => $hcs->DiemXanh
        ];
    }

    public function capNhatHoSo(string $maTaiKhoan, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);

        DB::transaction(function () use ($hcs, $data) {
            $taiKhoan = $hcs->taiKhoan;

            if (isset($data["cccd"])) {
                $exists = TaiKhoan::where("CCCD", $data["cccd"])
                    ->where("MaTaiKhoan", "!=", $taiKhoan->MaTaiKhoan)
                    ->exists();
                if ($exists) {
                    throw AppException::badRequest("CCCD đã được sử dụng");
                }
                $taiKhoan->CCCD = $data["cccd"];
            }

            if (isset($data["hoTen"])) {
                $taiKhoan->HoTen = $data["hoTen"];
            }

            if (isset($data["soDienThoai"])) {
                $taiKhoan->SoDienThoai = $data["soDienThoai"];
            }

            if (isset($data["ngaySinh"])) {
                $taiKhoan->NgaySinh = $data["ngaySinh"];
            }

            $taiKhoan->save();

            if (isset($data["ghiChuYTe"])) {
                $hcs->GhiChuYTe = $data["ghiChuYTe"];
            }

            if (isset($data["diUng"])) {
                $hcs->DiUng = $data["diUng"];
            }

            $hcs->save();
        });

        return $this->layHoSo($maTaiKhoan);
    }

    public function lichSuTour(string $maTaiKhoan)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        // Lấy các tour đã đặt và đã thanh toán
        return DonDatTour::with(["tourThucTe.tourMau", "chiTietDatTours"])
            ->where("MaKhachHang", $hcs->MaKhachHang)
            ->where("TrangThai", "DA_THANH_TOAN")
            ->orderBy("NgayDat", "desc")
            ->paginate(15);
    }

    public function danhSachDatTour(string $maTaiKhoan)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        return DonDatTour::with(["tourThucTe.tourMau"])
            ->where("MaKhachHang", $hcs->MaKhachHang)
            ->orderBy("NgayDat", "desc")
            ->paginate(15);
    }

    public function taoYeuCauHoTro(string $maTaiKhoan, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);

        $maYeuCau = $this->maTuDongService->taoMaYeuCauHoTro();
        $yeuCau = new YeuCauHoTro();
        $yeuCau->MaYeuCauHoTro = $maYeuCau;
        $yeuCau->MaDatTour = $data["maDatTour"] ?? null;
        $yeuCau->MaKhachHang = $hcs->MaKhachHang;
        $yeuCau->LoaiYeuCau = $data["loaiYeuCau"]; // TU_VAN, KIEU_NAI, HUY_TOUR, KHAC
        $yeuCau->NoiDung = $data["noiDung"];
        $yeuCau->TrangThai = "CHO_XU_LY";
        $yeuCau->save();

        return $yeuCau;
    }

    public function yeuCauHuyTour(string $maTaiKhoan, string $maDatTour, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        
        $don = DonDatTour::where("MaDatTour", $maDatTour)
            ->where("MaKhachHang", $hcs->MaKhachHang)
            ->first();

        if (!$don) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour này của bạn");
        }

        if (in_array($don->TrangThai, ["DA_HUY", "CHO_HOAN_TIEN", "DA_HOAN_TIEN"])) {
            throw AppException::badRequest("Đơn đặt tour đã ở trạng thái hủy");
        }

        $maYeuCau = $this->maTuDongService->taoMaYeuCauHoTro();
        $yeuCau = new YeuCauHoTro();
        $yeuCau->MaYeuCauHoTro = $maYeuCau;
        $yeuCau->MaDatTour = $maDatTour;
        $yeuCau->MaKhachHang = $hcs->MaKhachHang;
        $yeuCau->LoaiYeuCau = "HUY_TOUR";
        $yeuCau->NoiDung = $data["lyDoHuy"] ?? "Khách hàng yêu cầu hủy tour";
        $yeuCau->TrangThai = "CHO_XU_LY";
        $yeuCau->save();

        return $yeuCau;
    }
}
