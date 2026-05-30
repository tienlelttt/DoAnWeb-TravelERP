<?php

namespace App\Services;

use App\Models\TourThucTe;
use App\Models\TourMau;
use App\Models\DonDatTour;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TourThucTeResource;
use App\Http\Resources\TourCongKhaiResource;

class TourThucTeService
{
    protected $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    public function danhSach($trangThai, $maTourMau, $giaTu, $giaDen, $perPage)
    {
        $query = TourThucTe::with('tourMau');

        if (!empty($trangThai)) {
            $query->where('TrangThai', $trangThai);
        }
        if (!empty($maTourMau)) {
            $query->where('MaTourMau', $maTourMau);
        }
        if (!empty($giaTu)) {
            $query->where('GiaHienHanh', '>=', $giaTu);
        }
        if (!empty($giaDen)) {
            $query->where('GiaHienHanh', '<=', $giaDen);
        }

        $query->orderBy('NgayKhoiHanh', 'asc');

        $tours = $query->paginate($perPage);
        return TourThucTeResource::collection($tours)->response()->getData(true);
    }

    public function danhSachCongKhai($giaTu, $giaDen, $thoiLuongMin, $thoiLuongMax, $perPage)
    {
        $query = TourThucTe::with(['tourMau' => function($q) {
            $q->with('lichTrinhTours');
        }])
        ->where('TrangThai', 'MO_BAN')
        ->where('ChoConLai', '>', 0)
        ->where('NgayKhoiHanh', '>', now());

        if (!empty($giaTu)) {
            $query->where('GiaHienHanh', '>=', $giaTu);
        }
        if (!empty($giaDen)) {
            $query->where('GiaHienHanh', '<=', $giaDen);
        }
        
        if (!empty($thoiLuongMin) || !empty($thoiLuongMax)) {
            $query->whereHas('tourMau', function($q) use ($thoiLuongMin, $thoiLuongMax) {
                if (!empty($thoiLuongMin)) $q->where('ThoiLuong', '>=', $thoiLuongMin);
                if (!empty($thoiLuongMax)) $q->where('ThoiLuong', '<=', $thoiLuongMax);
            });
        }

        $query->orderBy('NgayKhoiHanh', 'asc');

        $tours = $query->paginate($perPage);
        return TourCongKhaiResource::collection($tours)->response()->getData(true);
    }

    public function chiTiet($id)
    {
        $tour = TourThucTe::with('tourMau')->find($id);
        if (!$tour) {
            throw AppException::notFound("Không tìm th?y tour th?c t?: {$id}");
        }
        return new TourThucTeResource($tour);
    }

    public function chiTietCongKhai($id)
    {
        $tour = TourThucTe::with(['tourMau.lichTrinhTours'])->find($id);
        if (!$tour) {
            throw AppException::notFound("Không tìm th?y tour: {$id}");
        }
        return new TourCongKhaiResource($tour);
    }

    public function taoMoi(array $data)
    {
        return DB::transaction(function () use ($data) {
            $tourMau = TourMau::find($data['maTourMau']);
            if (!$tourMau) {
                throw AppException::notFound("Không tìm th?y tour m?u: {$data['maTourMau']}");
            }

            $soKhachToiThieu = $data['soKhachToiThieu'] ?? 1;

            if ($soKhachToiThieu > $data['soKhachToiDa']) {
                throw AppException::badRequest("S? khách t?i thi?u không du?c l?n hon s? khách t?i da");
            }

            if ($data['giaHienHanh'] < $tourMau->GiaSan) {
                throw AppException::badRequest("Giá hi?n hành không du?c th?p hon giá sàn c?a tour m?u ({$tourMau->GiaSan})");
            }

            $trangThai = !empty($data['trangThai']) ? $data['trangThai'] : 'CHO_KICH_HOAT';
            $this->validateTrangThaiTourThucTe($trangThai);
            if ($trangThai === 'MO_BAN') {
                throw AppException::badRequest("Tour m?i ph?i ? tr?ng thái CHO_KICH_HOAT d? phân công và xác nh?n HDV tru?c khi m? bán.");
            }

            $ttt = new TourThucTe();
            $ttt->MaTourThucTe = $this->maTuDongService->taoMaTourThucTe();
            $ttt->MaTourMau = $tourMau->MaTourMau;
            $ttt->NgayKhoiHanh = $data['ngayKhoiHanh'];
            $ttt->GiaHienHanh = $data['giaHienHanh'];
            $ttt->SoKhachToiDa = $data['soKhachToiDa'];
            $ttt->SoKhachToiThieu = $soKhachToiThieu;
            $ttt->ChoConLai = $data['soKhachToiDa'];
            $ttt->TrangThai = $trangThai;
            $ttt->save();

            // B? qua D?ch v? thêm & Hành d?ng xanh trong giai do?n 3.1
            
            $ttt->load('tourMau');
            return new TourThucTeResource($ttt);
        });
    }

    public function capNhat($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $ttt = TourThucTe::find($id);
            if (!$ttt) {
                throw AppException::notFound("Không tìm th?y tour th?c t?: {$id}");
            }

            if (isset($data['giaHienHanh'])) {
                $ttt->GiaHienHanh = $data['giaHienHanh'];
            }
            if (isset($data['soKhachToiDa'])) {
                if ($data['soKhachToiDa'] < $ttt->SoKhachToiThieu) {
                    throw AppException::badRequest("S? khách t?i da không du?c nh? hon s? khách t?i thi?u");
                }
                $ttt->SoKhachToiDa = $data['soKhachToiDa'];
            }
            if (isset($data['soKhachToiThieu'])) {
                if ($data['soKhachToiThieu'] > $ttt->SoKhachToiDa) {
                    throw AppException::badRequest("S? khách t?i thi?u không du?c l?n hon s? khách t?i da");
                }
                $ttt->SoKhachToiThieu = $data['soKhachToiThieu'];
            }
            if (isset($data['trangThai'])) {
                $this->validateTrangThaiTourThucTe($data['trangThai']);
                // B? qua ki?m tra phân công HDV trong giai do?n này
                $ttt->TrangThai = $data['trangThai'];
            }

            $ttt->save();
            
            $ttt->load('tourMau');
            return new TourThucTeResource($ttt);
        });
    }

    public function xoa($id)
    {
        return DB::transaction(function () use ($id) {
            $ttt = TourThucTe::find($id);
            if (!$ttt) {
                throw AppException::notFound("Không tìm th?y tour th?c t?: {$id}");
            }

            if ($ttt->TrangThai !== 'CHO_KICH_HOAT' && $ttt->TrangThai !== 'MO_BAN') {
                throw AppException::badRequest("Ch? có th? xóa tour th?c t? ? tr?ng thái CHO_KICH_HOAT ho?c MO_BAN");
            }

            // Ki?m tra xem có don d?t tour nào không (b? qua cho Giai do?n 3.1 vì DonDatTour thu?c Giai do?n 4, nhung t?m th?i cài d?t ki?m tra co b?n)
            if (DonDatTour::where('MaTourThucTe', $id)->whereNotIn('TrangThai', ['DA_HUY'])->exists()) {
                throw AppException::badRequest("Không th? xóa tour th?c t? dã phát sinh don d?t tour");
            }

            $ttt->TrangThai = 'HUY';
            $ttt->save();
        });
    }

    private function validateTrangThaiTourThucTe($trangThai)
    {
        $validStatuses = ['CHO_KICH_HOAT', 'MO_BAN', 'DANG_DIEN_RA', 'KET_THUC', 'HUY', 'DA_QUYET_TOAN'];
        if (!in_array($trangThai, $validStatuses)) {
            throw AppException::badRequest("Tr?ng thái không h?p l?: {$trangThai}");
        }
    }
public function layDanhGia(string $maTourThucTe)
    {
        return \App\Models\DanhGiaKh::with("khachHang.taiKhoan")
            ->where("MaTourThucTe", $maTourThucTe)
            ->orderBy("NgayDanhGia", "desc")
            ->paginate(10);
    }

    public function layHanhDongXanh(string $maTourThucTe)
    {
        $tour = TourThucTe::find($maTourThucTe);
        if (!$tour) {
            throw AppException::notFound("Kh?ng t?m th?y tour");
        }
        return $tour->hanhDongXanhs()->get();
    }

    public function layDichVuThem(string $maTourThucTe)
    {
        $tour = TourThucTe::find($maTourThucTe);
        if (!$tour) {
            throw AppException::notFound("Kh?ng t?m th?y tour");
        }
        return $tour->dichVuThems()->get();
    }
}


