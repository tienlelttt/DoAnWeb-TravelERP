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
    private const TRANG_THAI_DON_DA_THAM_GIA = ['DA_XAC_NHAN', 'DA_THANH_TOAN', 'HOAN_THANH'];

    protected MaTuDongService $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    private function getHoChieuSo(string $maTaiKhoan): HoChieuSo
    {
        $hcs = HoChieuSo::with("taiKhoan")->where("ma_tai_khoan", $maTaiKhoan)->first();
        if (!$hcs) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }
        return $hcs;
    }

    public function layHoSo(string $maTaiKhoan)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        
        return [
            "maKhachHang" => $hcs->ma_khach_hang,
            "hoTen" => $hcs->taiKhoan->ho_ten,
            "email" => $hcs->taiKhoan->email,
            "soDienThoai" => $hcs->taiKhoan->so_dien_thoai,
            "cccd" => $hcs->taiKhoan->cccd,
            "ngaySinh" => $hcs->taiKhoan->ngay_sinh,
            "ghiChuYTe" => $hcs->ghi_chu_y_te,
            "diUng" => $hcs->di_ung,
            "hangThanhVien" => $hcs->hang_thanh_vien,
            "diemXanh" => $hcs->diem_xanh
        ];
    }

    public function capNhatHoSo(string $maTaiKhoan, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);

        DB::transaction(function () use ($hcs, $data) {
            $taiKhoan = $hcs->taiKhoan;

            if (isset($data["cccd"])) {
                $exists = TaiKhoan::where("cccd", $data["cccd"])
                    ->where("ma_tai_khoan", "!=", $taiKhoan->ma_tai_khoan)
                    ->exists();
                if ($exists) {
                    throw AppException::badRequest("cccd đã được sử dụng");
                }
                $taiKhoan->cccd = $data["cccd"];
            }

            if (isset($data["hoTen"])) {
                $taiKhoan->ho_ten = $data["hoTen"];
            }

            if (isset($data["soDienThoai"])) {
                $taiKhoan->so_dien_thoai = $data["soDienThoai"];
            }

            if (isset($data["ngaySinh"])) {
                $taiKhoan->ngay_sinh = $data["ngaySinh"];
            }

            $taiKhoan->save();

            if (isset($data["ghiChuYTe"])) {
                $hcs->ghi_chu_y_te = $data["ghiChuYTe"];
            }

            if (isset($data["diUng"])) {
                $hcs->di_ung = $data["diUng"];
            }

            $hcs->save();
        });

        return $this->layHoSo($maTaiKhoan);
    }

    public function lichSuTour(string $maTaiKhoan, int $size = 15)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        // Lấy các tour đã đặt và đã thanh toán
        return DonDatTour::with(["tourThucTe.tourMau", "chiTietDatTours"])
            ->where("ma_khach_hang", $hcs->ma_khach_hang)
            ->whereIn("trang_thai", self::TRANG_THAI_DON_DA_THAM_GIA)
            ->orderBy("ngay_dat", "desc")
            ->paginate($size);
    }

    public function danhSachDatTour(string $maTaiKhoan, int $size = 15)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        return DonDatTour::with(["tourThucTe.tourMau"])
            ->where("ma_khach_hang", $hcs->ma_khach_hang)
            ->orderBy("ngay_dat", "desc")
            ->paginate($size);
    }

    public function layDanhSachYeuCauHoTro(string $maTaiKhoan, array $filters = [])
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        $query = YeuCauHoTro::with('donDatTour.tourThucTe.tourMau')
            ->where("ma_khach_hang", $hcs->ma_khach_hang);

        if (!empty($filters['loaiYeuCau'])) {
            $query->where('loai_yeu_cau', $filters['loaiYeuCau']);
        }

        if (!empty($filters['trangThai'])) {
            $query->where('trang_thai', $filters['trangThai']);
        }

        $page = max((int) ($filters['page'] ?? 1), 1);
        $size = max(1, min((int) ($filters['size'] ?? 15), 1000));

        return $query->orderBy('created_at', 'desc')->paginate($size, ['*'], 'page', $page);
    }

    public function taoYeuCauHoTro(string $maTaiKhoan, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);

        $maYeuCau = $this->maTuDongService->taoMaYeuCauHoTro();
        $yeuCau = new YeuCauHoTro();
        $yeuCau->ma_yeu_cau_ho_tro = $maYeuCau;
        $yeuCau->ma_dat_tour = $data["maDatTour"] ?? null;
        $yeuCau->ma_khach_hang = $hcs->ma_khach_hang;
        $yeuCau->loai_yeu_cau = $data["loaiYeuCau"]; // TU_VAN, KIEU_NAI, HUY_TOUR, KHAC
        $yeuCau->noi_dung = $data["noiDung"];
        $yeuCau->trang_thai = "CHO_XU_LY";
        $yeuCau->save();

        return $yeuCau;
    }

    public function yeuCauHuyTour(string $maTaiKhoan, string $maDatTour, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        
        $don = DonDatTour::where("ma_dat_tour", $maDatTour)
            ->where("ma_khach_hang", $hcs->ma_khach_hang)
            ->first();

        if (!$don) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour này của bạn");
        }

        if (in_array($don->trang_thai, ["DA_HUY", "CHO_HOAN_TIEN", "DA_HOAN_TIEN"])) {
            throw AppException::badRequest("Đơn đặt tour đã ở trạng thái hủy");
        }

        $maYeuCau = $this->maTuDongService->taoMaYeuCauHoTro();
        $yeuCau = new YeuCauHoTro();
        $yeuCau->ma_yeu_cau_ho_tro = $maYeuCau;
        $yeuCau->ma_dat_tour = $maDatTour;
        $yeuCau->ma_khach_hang = $hcs->ma_khach_hang;
        $yeuCau->loai_yeu_cau = "HUY_TOUR";
        $yeuCau->noi_dung = $data["lyDoHuy"] ?? "Khách hàng yêu cầu hủy tour";
        $yeuCau->trang_thai = "CHO_XU_LY";
        $yeuCau->save();

        return $yeuCau;
    }

    public function yeuCauHoTroCanBoSung(string $maTaiKhoan, int $size = 15)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        return YeuCauHoTro::where("ma_khach_hang", $hcs->ma_khach_hang)
            ->whereIn("trang_thai", ["CHO_BO_SUNG", "YEU_CAU_BO_SUNG", "CAN_BO_SUNG"])
            ->orderBy("updated_at", "desc")
            ->paginate($size);
    }

    public function boSungYeuCauHoTro(string $maTaiKhoan, string $maYeuCau, array $data)
    {
        $hcs = $this->getHoChieuSo($maTaiKhoan);
        
        $yeuCau = YeuCauHoTro::where("ma_yeu_cau_ho_tro", $maYeuCau)
            ->where("ma_khach_hang", $hcs->ma_khach_hang)
            ->first();

        if (!$yeuCau) {
            throw AppException::notFound("Không tìm thấy yêu cầu hỗ trợ này");
        }

        if (!in_array($yeuCau->trang_thai, ["CHO_BO_SUNG", "YEU_CAU_BO_SUNG", "CAN_BO_SUNG"], true)) {
            throw AppException::badRequest("Yêu cầu này không ở trạng thái cần bổ sung thông tin");
        }

        $yeuCau->noi_dung = $yeuCau->noi_dung . "\n\n[KHÁCH HÀNG BỔ SUNG]: " . $data["noiDungBoSung"];
        $yeuCau->trang_thai = "CHUA_XU_LY";
        $yeuCau->save();

        return $yeuCau;
    }
}
