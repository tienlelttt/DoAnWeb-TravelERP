<?php

namespace App\Services;

use App\Models\TourMau;
use App\Models\LichTrinhTour;
use App\Models\TourThucTe;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TourMauResource;
use App\Http\Resources\TourMauChiTietResource;
use App\Http\Resources\LichTrinhResource;

class TourMauService
{
    protected $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    public function danhSach($tieuDe, $thoiLuongMin, $thoiLuongMax, $perPage)
    {
        $query = TourMau::query();

        if (!empty($tieuDe)) {
            $query->where('tieu_de', 'like', "%{$tieuDe}%");
        }
        if (!empty($thoiLuongMin)) {
            $query->where('thoi_luong', '>=', $thoiLuongMin);
        }
        if (!empty($thoiLuongMax)) {
            $query->where('thoi_luong', '<=', $thoiLuongMax);
        }

        $query->orderBy('ma_tour_mau', 'desc');

        $tours = $query->paginate($perPage);
        return TourMauResource::collection($tours)->response()->getData(true);
    }

    public function chiTiet($id)
    {
        $tour = TourMau::with('lichTrinhTours')->find($id);
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy tour mẫu: {$id}");
        }
        return new TourMauChiTietResource($tour);
    }

    public function taoMoi(array $data)
    {
        return DB::transaction(function () use ($data) {
            $tour = new TourMau();
            $tour->ma_tour_mau = $this->maTuDongService->taoMaTourMau();
            $tour->tieu_de = $data['tieuDe'];
            $tour->mo_ta = $data['moTa'] ?? null;
            $tour->thoi_luong = $data['thoiLuong'];
            $tour->gia_san = $data['giaSan'];
            $tour->danh_gia = null;
            $tour->so_danh_gia = 0;
            $tour->save();

            if (!empty($data['lichTrinh'])) {
                foreach ($data['lichTrinh'] as $ltReq) {
                    $this->validateLichTrinh($tour, $ltReq['ngayThu']);
                    $lt = new LichTrinhTour();
                    $lt->ma_lich_trinh_tour = $this->maTuDongService->taoMaLichTrinhTour();
                    $lt->ma_tour_mau = $tour->ma_tour_mau;
                    $lt->ngay_thu = $ltReq['ngayThu'];
                    $lt->hoat_dong = $ltReq['hoatDong'];
                    $lt->mo_ta = $ltReq['moTa'] ?? null;
                    $lt->thuc_don = $ltReq['thucDon'] ?? null;
                    $lt->save();
                }
            }

            $tour->load('lichTrinhTours');
            return new TourMauChiTietResource($tour);
        });
    }

    public function capNhat($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tour = TourMau::find($id);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour mẫu: {$id}");
            }

            $tour->tieu_de = $data['tieuDe'];
            $tour->mo_ta = $data['moTa'] ?? null;
            $tour->thoi_luong = $data['thoiLuong'];
            $tour->gia_san = $data['giaSan'];
            $tour->save();

            return new TourMauResource($tour);
        });
    }

    public function xoaMem($id)
    {
        return DB::transaction(function () use ($id) {
            $tour = TourMau::find($id);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour mẫu: {$id}");
            }

            if (TourThucTe::where('ma_tour_mau', $id)->exists()) {
                throw AppException::badRequest("Không thể xóa tour mẫu vì đã có tour thực tế liên kết");
            }

            LichTrinhTour::where('ma_tour_mau', $id)->delete();
            $tour->delete();
        });
    }

    public function saoChep($id)
    {
        return DB::transaction(function () use ($id) {
            $goc = TourMau::with('lichTrinhTours')->find($id);
            if (!$goc) {
                throw AppException::notFound("Không tìm thấy tour mẫu: {$id}");
            }

            $banSao = new TourMau();
            $banSao->ma_tour_mau = $this->maTuDongService->taoMaTourMau();
            $banSao->tieu_de = "[Sao chep] " . $goc->tieu_de;
            $banSao->mo_ta = $goc->mo_ta;
            $banSao->thoi_luong = $goc->thoi_luong;
            $banSao->gia_san = $goc->gia_san;
            $banSao->danh_gia = null;
            $banSao->so_danh_gia = 0;
            $banSao->save();

            foreach ($goc->lichTrinhTours as $ltGoc) {
                $ltMoi = new LichTrinhTour();
                $ltMoi->ma_lich_trinh_tour = $this->maTuDongService->taoMaLichTrinhTour();
                $ltMoi->ma_tour_mau = $banSao->ma_tour_mau;
                $ltMoi->ngay_thu = $ltGoc->ngay_thu;
                $ltMoi->hoat_dong = $ltGoc->hoat_dong;
                $ltMoi->mo_ta = $ltGoc->mo_ta;
                $ltMoi->thuc_don = $ltGoc->thuc_don;
                $ltMoi->save();
            }

            $banSao->load('lichTrinhTours');
            return new TourMauChiTietResource($banSao);
        });
    }

    public function themLichTrinh($maTourMau, array $data)
    {
        return DB::transaction(function () use ($maTourMau, $data) {
            $tour = TourMau::find($maTourMau);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour mẫu: {$maTourMau}");
            }

            $this->validateLichTrinh($tour, $data['ngayThu']);

            $lt = new LichTrinhTour();
            $lt->ma_lich_trinh_tour = $this->maTuDongService->taoMaLichTrinhTour();
            $lt->ma_tour_mau = $maTourMau;
            $lt->ngay_thu = $data['ngayThu'];
            $lt->hoat_dong = $data['hoatDong'];
            $lt->mo_ta = $data['moTa'] ?? null;
            $lt->thuc_don = $data['thucDon'] ?? null;
            $lt->save();

            return new LichTrinhResource($lt);
        });
    }

    public function suaLichTrinh($maTourMau, $maLichTrinh, array $data)
    {
        return DB::transaction(function () use ($maTourMau, $maLichTrinh, $data) {
            $tour = TourMau::find($maTourMau);
            if (!$tour) {
                throw AppException::notFound("Không tìm thấy tour mẫu: {$maTourMau}");
            }

            $lt = LichTrinhTour::find($maLichTrinh);
            if (!$lt) {
                throw AppException::notFound("Không tìm thấy lịch trình: {$maLichTrinh}");
            }

            if ($lt->ma_tour_mau !== $maTourMau) {
                throw AppException::badRequest("Lịch trình không thuộc tour mẫu này");
            }

            if (isset($data['ngayThu']) && $data['ngayThu'] != $lt->ngay_thu) {
                if (LichTrinhTour::where('ma_tour_mau', $maTourMau)
                    ->where('ngay_thu', $data['ngayThu'])
                    ->where('ma_lich_trinh_tour', '!=', $maLichTrinh)
                    ->exists()) {
                    throw AppException::badRequest("Ngày thứ {$data['ngayThu']} đã tồn tại trong tour này");
                }
                if ($data['ngayThu'] > $tour->thoi_luong) {
                    throw AppException::badRequest("Ngày thứ không được vượt quá thời lượng tour ({$tour->thoi_luong} ngày)");
                }
                $lt->ngay_thu = $data['ngayThu'];
            }

            if (isset($data['hoatDong'])) $lt->hoat_dong = $data['hoatDong'];
            if (isset($data['moTa'])) $lt->mo_ta = $data['moTa'];
            if (isset($data['thucDon'])) $lt->thuc_don = $data['thucDon'];
            $lt->save();

            return new LichTrinhResource($lt);
        });
    }

    public function xoaLichTrinh($maTourMau, $maLichTrinh)
    {
        return DB::transaction(function () use ($maTourMau, $maLichTrinh) {
            $lt = LichTrinhTour::find($maLichTrinh);
            if (!$lt) {
                throw AppException::notFound("Không tìm thấy lịch trình: {$maLichTrinh}");
            }

            if ($lt->ma_tour_mau !== $maTourMau) {
                throw AppException::badRequest("Lịch trình không thuộc tour mẫu này");
            }

            $lt->delete();
        });
    }

    private function validateLichTrinh(TourMau $tour, $ngayThu)
    {
        if ($ngayThu > $tour->thoi_luong) {
            throw AppException::badRequest("Ngày thứ {$ngayThu} vượt quá thời lượng tour ({$tour->thoi_luong} ngày)");
        }
        if (LichTrinhTour::where('ma_tour_mau', $tour->ma_tour_mau)->where('ngay_thu', $ngayThu)->exists()) {
            throw AppException::badRequest("Ngày thứ {$ngayThu} đã tồn tại trong tour này");
        }
    }
}

