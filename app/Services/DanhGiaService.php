<?php

namespace App\Services;

use App\Models\DanhGiaKh;
use App\Models\HoChieuSo;
use App\Models\LichSuTour;
use App\Models\TourThucTe;
use App\Models\TourMau;
use App\Models\YeuCauHoTro;
use App\Models\PhanCongTour;
use App\Models\NangLucNhanVien;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\DanhGiaResource;

class DanhGiaService
{
    public function guiDanhGia($maTaiKhoan, array $data)
    {
        return DB::transaction(function () use ($maTaiKhoan, $data) {
            $hcs = HoChieuSo::with('taiKhoan')->where('ma_tai_khoan', $maTaiKhoan)->first();
            if (!$hcs) {
                throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
            }

            $tour = TourThucTe::with('tourMau')->find($data['maTourThucTe']);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour: " . $data['maTourThucTe']);
            }

            if ($tour->trang_thai !== 'KET_THUC' && $tour->trang_thai !== 'DA_QUYET_TOAN') {
                throw AppException::badRequest("Chỉ có thể đánh giá tour đã kết thúc");
            }

            $lichSu = LichSuTour::where('ma_khach_hang', $hcs->ma_khach_hang)
                ->where('ma_tour_thuc_te', $tour->ma_tour_thuc_te)
                ->first();
            if (!$lichSu) {
                throw AppException::badRequest("Bạn chưa tham gia tour này nên không thể đánh giá");
            }

            $daDanhGia = DanhGiaKh::where('ma_khach_hang', $hcs->ma_khach_hang)
                ->where('ma_tour_thuc_te', $tour->ma_tour_thuc_te)
                ->exists();
            if ($daDanhGia) {
                throw AppException::badRequest("Bạn đã đánh giá tour này rồi");
            }

            // Khiếu nại chưa xử lý xong: CHUA_XU_LY, CHO_BO_SUNG, CHO_GIAI_TRINH, CHO_DUYET
            $hasComplaint = YeuCauHoTro::where('ma_khach_hang', $hcs->ma_khach_hang)
                ->whereIn('trang_thai', ['CHUA_XU_LY', 'CHO_BO_SUNG', 'CHO_GIAI_TRINH', 'CHO_DUYET'])
                ->whereHas('donDatTour', function($q) use ($tour) {
                    $q->where('ma_tour_thuc_te', $tour->ma_tour_thuc_te);
                })
                ->exists();

            if ($hasComplaint) {
                throw AppException::badRequest("Khiếu nại của tour này chưa được giải quyết, vui lòng chờ xử lý trước khi đánh giá");
            }

            $dg = new DanhGiaKh();
            $dg->ma_danh_gia_khach_hang = 'DG_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            $dg->ma_tour_thuc_te = $tour->ma_tour_thuc_te;
            $dg->ma_khach_hang = $hcs->ma_khach_hang;
            $dg->so_sao = $data['soSao'];
            $dg->nhan_xet = $data['nhanXet'] ?? null;
            $dg->ngay_danh_gia = Carbon::now();
            $dg->save();

            $this->capNhatDiemTrungBinhTourMau($tour->ma_tour_mau);
            
            if (isset($data['soSaoHdv'])) {
                $this->capNhatDiemTrungBinhHdv($tour->ma_tour_thuc_te, $data['soSaoHdv']);
            }

            $dg->load(['tourThucTe.tourMau', 'khachHang.taiKhoan']);
            return new DanhGiaResource($dg);
        });
    }

    private function capNhatDiemTrungBinhTourMau($maTourMau)
    {
        $tm = TourMau::find($maTourMau);
        if (!$tm) return;

        $soDanhGia = DanhGiaKh::whereHas('tourThucTe', function($q) use ($maTourMau) {
            $q->where('ma_tour_mau', $maTourMau);
        })->count();

        $diemMoi = DanhGiaKh::whereHas('tourThucTe', function($q) use ($maTourMau) {
            $q->where('ma_tour_mau', $maTourMau);
        })->avg('so_sao');

        $tm->so_danh_gia = $soDanhGia;
        $tm->danh_gia = $diemMoi ? round($diemMoi, 2) : 0;
        $tm->save();
    }

    private function capNhatDiemTrungBinhHdv($maTourThucTe, $soSaoHdv)
    {
        $phanCongs = PhanCongTour::where('ma_tour_thuc_te', $maTourThucTe)
            ->where('trang_thai_chap_nhan', 'DA_DONG_Y')
            ->get();
            
        foreach ($phanCongs as $pc) {
            $nl = NangLucNhanVien::where('ma_nhan_vien', $pc->ma_nhan_vien)->first();
            if (!$nl) {
                $nl = new NangLucNhanVien();
                $nl->ma_nang_luc_nhan_vien = 'NLNV_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
                $nl->ma_nhan_vien = $pc->ma_nhan_vien;
                $nl->danh_gia = 0;
                $nl->so_danh_gia = 0;
            }

            $soDanhGia = ($nl->so_danh_gia ?: 0) + 1;
            $diemHienTai = $nl->danh_gia ?: 0;
            $diemMoi = (($diemHienTai * ($soDanhGia - 1)) + $soSaoHdv) / $soDanhGia;
            
            $nl->so_danh_gia = $soDanhGia;
            $nl->danh_gia = round($diemMoi, 2);
            $nl->save();
        }
    }

    public function danhSachDanhGia($maTourThucTe, $perPage = 10)
    {
        $tour = TourThucTe::find($maTourThucTe);
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy tour: " . $maTourThucTe);
        }

        $query = DanhGiaKh::with(['tourThucTe.tourMau', 'khachHang.taiKhoan'])
            ->whereHas('tourThucTe', function($q) use ($tour) {
                $q->where('ma_tour_mau', $tour->ma_tour_mau);
            })->orderBy('ngay_danh_gia', 'desc');

        return DanhGiaResource::collection($query->paginate($perPage))->response()->getData(true);
    }

    public function tatCaDanhGia($perPage = 10)
    {
        $query = DanhGiaKh::with(['tourThucTe.tourMau', 'khachHang.taiKhoan'])
            ->orderBy('ngay_danh_gia', 'desc');

        return DanhGiaResource::collection($query->paginate($perPage))->response()->getData(true);
    }
}
