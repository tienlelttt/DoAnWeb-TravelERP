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
            $query->where('TieuDe', 'like', "%{$tieuDe}%");
        }
        if (!empty($thoiLuongMin)) {
            $query->where('ThoiLuong', '>=', $thoiLuongMin);
        }
        if (!empty($thoiLuongMax)) {
            $query->where('ThoiLuong', '<=', $thoiLuongMax);
        }

        $query->orderBy('MaTourMau', 'desc');

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
            $tour->MaTourMau = $this->maTuDongService->taoMaTourMau();
            $tour->TieuDe = $data['tieuDe'];
            $tour->MoTa = $data['moTa'] ?? null;
            $tour->ThoiLuong = $data['thoiLuong'];
            $tour->GiaSan = $data['giaSan'];
            $tour->DanhGia = null;
            $tour->SoDanhGia = 0;
            $tour->save();

            if (!empty($data['lichTrinh'])) {
                foreach ($data['lichTrinh'] as $ltReq) {
                    $this->validateLichTrinh($tour, $ltReq['ngayThu']);
                    $lt = new LichTrinhTour();
                    $lt->MaLichTrinhTour = $this->maTuDongService->taoMaLichTrinhTour();
                    $lt->MaTourMau = $tour->MaTourMau;
                    $lt->NgayThu = $ltReq['ngayThu'];
                    $lt->HoatDong = $ltReq['hoatDong'];
                    $lt->MoTa = $ltReq['moTa'] ?? null;
                    $lt->ThucDon = $ltReq['thucDon'] ?? null;
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

            $tour->TieuDe = $data['tieuDe'];
            $tour->MoTa = $data['moTa'] ?? null;
            $tour->ThoiLuong = $data['thoiLuong'];
            $tour->GiaSan = $data['giaSan'];
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

            if (TourThucTe::where('MaTourMau', $id)->exists()) {
                throw AppException::badRequest("Không thể xóa tour mẫu vì đã có tour thực tế liên kết");
            }

            LichTrinhTour::where('MaTourMau', $id)->delete();
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
            $banSao->MaTourMau = $this->maTuDongService->taoMaTourMau();
            $banSao->TieuDe = "[Sao chep] " . $goc->TieuDe;
            $banSao->MoTa = $goc->MoTa;
            $banSao->ThoiLuong = $goc->ThoiLuong;
            $banSao->GiaSan = $goc->GiaSan;
            $banSao->DanhGia = null;
            $banSao->SoDanhGia = 0;
            $banSao->save();

            foreach ($goc->lichTrinhTours as $ltGoc) {
                $ltMoi = new LichTrinhTour();
                $ltMoi->MaLichTrinhTour = $this->maTuDongService->taoMaLichTrinhTour();
                $ltMoi->MaTourMau = $banSao->MaTourMau;
                $ltMoi->NgayThu = $ltGoc->NgayThu;
                $ltMoi->HoatDong = $ltGoc->HoatDong;
                $ltMoi->MoTa = $ltGoc->MoTa;
                $ltMoi->ThucDon = $ltGoc->ThucDon;
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
            $lt->MaLichTrinhTour = $this->maTuDongService->taoMaLichTrinhTour();
            $lt->MaTourMau = $maTourMau;
            $lt->NgayThu = $data['ngayThu'];
            $lt->HoatDong = $data['hoatDong'];
            $lt->MoTa = $data['moTa'] ?? null;
            $lt->ThucDon = $data['thucDon'] ?? null;
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

            if ($lt->MaTourMau !== $maTourMau) {
                throw AppException::badRequest("Lịch trình không thuộc tour mẫu này");
            }

            if (isset($data['ngayThu']) && $data['ngayThu'] != $lt->NgayThu) {
                if (LichTrinhTour::where('MaTourMau', $maTourMau)
                    ->where('NgayThu', $data['ngayThu'])
                    ->where('MaLichTrinhTour', '!=', $maLichTrinh)
                    ->exists()) {
                    throw AppException::badRequest("Ngày thứ {$data['ngayThu']} đã tồn tại trong tour này");
                }
                if ($data['ngayThu'] > $tour->ThoiLuong) {
                    throw AppException::badRequest("Ngày thứ không được vượt quá thời lượng tour ({$tour->ThoiLuong} ngày)");
                }
                $lt->NgayThu = $data['ngayThu'];
            }

            if (isset($data['hoatDong'])) $lt->HoatDong = $data['hoatDong'];
            if (isset($data['moTa'])) $lt->MoTa = $data['moTa'];
            if (isset($data['thucDon'])) $lt->ThucDon = $data['thucDon'];
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

            if ($lt->MaTourMau !== $maTourMau) {
                throw AppException::badRequest("Lịch trình không thuộc tour mẫu này");
            }

            $lt->delete();
        });
    }

    private function validateLichTrinh(TourMau $tour, $ngayThu)
    {
        if ($ngayThu > $tour->ThoiLuong) {
            throw AppException::badRequest("Ngày thứ {$ngayThu} vượt quá thời lượng tour ({$tour->ThoiLuong} ngày)");
        }
        if (LichTrinhTour::where('MaTourMau', $tour->MaTourMau)->where('NgayThu', $ngayThu)->exists()) {
            throw AppException::badRequest("Ngày thứ {$ngayThu} đã tồn tại trong tour này");
        }
    }
}

