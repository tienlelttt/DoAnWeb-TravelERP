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
            $hcs = HoChieuSo::with('taiKhoan')->where('MaTaiKhoan', $maTaiKhoan)->first();
            if (!$hcs) {
                throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
            }

            $tour = TourThucTe::with('tourMau')->find($data['maTourThucTe']);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour: " . $data['maTourThucTe']);
            }

            if ($tour->TrangThai !== 'KET_THUC' && $tour->TrangThai !== 'DA_QUYET_TOAN') {
                throw AppException::badRequest("Chỉ có thể đánh giá tour đã kết thúc");
            }

            $lichSu = LichSuTour::where('MaKhachHang', $hcs->MaKhachHang)
                ->where('MaTourThucTe', $tour->MaTourThucTe)
                ->first();
            if (!$lichSu) {
                throw AppException::badRequest("Bạn chưa tham gia tour này nên không thể đánh giá");
            }

            $daDanhGia = DanhGiaKh::where('MaKhachHang', $hcs->MaKhachHang)
                ->where('MaTourThucTe', $tour->MaTourThucTe)
                ->exists();
            if ($daDanhGia) {
                throw AppException::badRequest("Bạn đã đánh giá tour này rồi");
            }

            // Khiếu nại chưa xử lý xong: CHUA_XU_LY, CHO_BO_SUNG, CHO_GIAI_TRINH, CHO_DUYET
            $hasComplaint = YeuCauHoTro::where('MaKhachHang', $hcs->MaKhachHang)
                ->whereIn('TrangThai', ['CHUA_XU_LY', 'CHO_BO_SUNG', 'CHO_GIAI_TRINH', 'CHO_DUYET'])
                ->whereHas('donDatTour', function($q) use ($tour) {
                    $q->where('MaTourThucTe', $tour->MaTourThucTe);
                })
                ->exists();

            if ($hasComplaint) {
                throw AppException::badRequest("Khiếu nại của tour này chưa được giải quyết, vui lòng chờ xử lý trước khi đánh giá");
            }

            $dg = new DanhGiaKh();
            $dg->MaDanhGiaKhachHang = 'DG_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            $dg->MaTourThucTe = $tour->MaTourThucTe;
            $dg->MaKhachHang = $hcs->MaKhachHang;
            $dg->SoSao = $data['soSao'];
            $dg->NhanXet = $data['nhanXet'] ?? null;
            $dg->NgayDanhGia = Carbon::now();
            $dg->save();

            $this->capNhatDiemTrungBinhTourMau($tour->MaTourMau);
            
            if (isset($data['soSaoHdv'])) {
                $this->capNhatDiemTrungBinhHdv($tour->MaTourThucTe, $data['soSaoHdv']);
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
            $q->where('MaTourMau', $maTourMau);
        })->count();

        $diemMoi = DanhGiaKh::whereHas('tourThucTe', function($q) use ($maTourMau) {
            $q->where('MaTourMau', $maTourMau);
        })->avg('SoSao');

        $tm->SoDanhGia = $soDanhGia;
        $tm->DanhGia = $diemMoi ? round($diemMoi, 2) : 0;
        $tm->save();
    }

    private function capNhatDiemTrungBinhHdv($maTourThucTe, $soSaoHdv)
    {
        $phanCongs = PhanCongTour::where('MaTourThucTe', $maTourThucTe)
            ->where('TrangThaiChapNhan', 'DA_DONG_Y')
            ->get();
            
        foreach ($phanCongs as $pc) {
            $nl = NangLucNhanVien::where('MaNhanVien', $pc->MaNhanVien)->first();
            if (!$nl) {
                $nl = new NangLucNhanVien();
                $nl->MaNangLucNhanVien = 'NLNV_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
                $nl->MaNhanVien = $pc->MaNhanVien;
                $nl->DanhGia = 0;
                $nl->SoDanhGia = 0;
            }

            $soDanhGia = ($nl->SoDanhGia ?: 0) + 1;
            $diemHienTai = $nl->DanhGia ?: 0;
            $diemMoi = (($diemHienTai * ($soDanhGia - 1)) + $soSaoHdv) / $soDanhGia;
            
            $nl->SoDanhGia = $soDanhGia;
            $nl->DanhGia = round($diemMoi, 2);
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
                $q->where('MaTourMau', $tour->MaTourMau);
            })->orderBy('NgayDanhGia', 'desc');

        return DanhGiaResource::collection($query->paginate($perPage))->response()->getData(true);
    }

    public function tatCaDanhGia($perPage = 10)
    {
        $query = DanhGiaKh::with(['tourThucTe.tourMau', 'khachHang.taiKhoan'])
            ->orderBy('NgayDanhGia', 'desc');

        return DanhGiaResource::collection($query->paginate($perPage))->response()->getData(true);
    }
}
