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
        $query = TourThucTe::with(['tourMau', 'dichVuThems', 'hanhDongXanhs']);

        if (!empty($trangThai)) {
            $query->where('trang_thai', $trangThai);
        }
        if (!empty($maTourMau)) {
            $query->where('ma_tour_mau', $maTourMau);
        }
        if (!empty($giaTu)) {
            $query->where('gia_hien_hanh', '>=', $giaTu);
        }
        if (!empty($giaDen)) {
            $query->where('gia_hien_hanh', '<=', $giaDen);
        }

        $query->orderBy('ngay_khoi_hanh', 'asc');

        $tours = $query->paginate($perPage);
        return TourThucTeResource::collection($tours)->response()->getData(true);
    }

    public function danhSachCongKhai($giaTu, $giaDen, $thoiLuongMin, $thoiLuongMax, $perPage)
    {
        $query = TourThucTe::with(['tourMau' => function($q) {
            $q->with('lichTrinhTours');
        }, 'dichVuThems', 'hanhDongXanhs'])
        ->where('trang_thai', 'MO_BAN')
        ->where('cho_con_lai', '>', 0)
        ->where('ngay_khoi_hanh', '>', now());

        if (!empty($giaTu)) {
            $query->where('gia_hien_hanh', '>=', $giaTu);
        }
        if (!empty($giaDen)) {
            $query->where('gia_hien_hanh', '<=', $giaDen);
        }
        
        if (!empty($thoiLuongMin) || !empty($thoiLuongMax)) {
            $query->whereHas('tourMau', function($q) use ($thoiLuongMin, $thoiLuongMax) {
                if (!empty($thoiLuongMin)) $q->where('thoi_luong', '>=', $thoiLuongMin);
                if (!empty($thoiLuongMax)) $q->where('thoi_luong', '<=', $thoiLuongMax);
            });
        }

        $query->orderBy('ngay_khoi_hanh', 'asc');

        $tours = $query->paginate($perPage);
        return TourCongKhaiResource::collection($tours)->response()->getData(true);
    }

    public function chiTiet($id)
    {
        $tour = TourThucTe::with(['tourMau', 'dichVuThems', 'hanhDongXanhs'])->find($id);
        if (!$tour) {
            throw AppException::notFound("Không tìm th?y tour th?c t?: {$id}");
        }
        return new TourThucTeResource($tour);
    }

    public function chiTietCongKhai($id)
    {
        $tour = TourThucTe::with(['tourMau.lichTrinhTours', 'dichVuThems', 'hanhDongXanhs'])->find($id);
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

            if ($data['giaHienHanh'] < $tourMau->gia_san) {
                throw AppException::badRequest("Giá hi?n hành không du?c th?p hon giá sàn c?a tour m?u ({$tourMau->gia_san})");
            }

            $trangThai = !empty($data['trangThai']) ? $data['trangThai'] : 'CHO_KICH_HOAT';
            $this->validateTrangThaiTourThucTe($trangThai);
            if ($trangThai === 'MO_BAN') {
                throw AppException::badRequest("Tour m?i ph?i ? tr?ng thái CHO_KICH_HOAT d? phân công và xác nh?n HDV tru?c khi m? bán.");
            }

            $ttt = new TourThucTe();
            $ttt->ma_tour_thuc_te = $this->maTuDongService->taoMaTourThucTe();
            $ttt->ma_tour_mau = $tourMau->ma_tour_mau;
            $ttt->ngay_khoi_hanh = $data['ngayKhoiHanh'];
            $ttt->gia_hien_hanh = $data['giaHienHanh'];
            $ttt->so_khach_toi_da = $data['soKhachToiDa'];
            $ttt->so_khach_toi_thieu = $soKhachToiThieu;
            $ttt->cho_con_lai = $data['soKhachToiDa'];
            $ttt->trang_thai = $trangThai;
            $ttt->save();

            // B? qua D?ch v? thêm & Hành d?ng xanh trong giai do?n 3.1
            
            $ttt->dichVuThems()->sync($data['maDichVuThem'] ?? []);
            $ttt->hanhDongXanhs()->sync($data['maHanhDongXanh'] ?? []);
            
            $ttt->load(['tourMau', 'dichVuThems', 'hanhDongXanhs']);
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
                $ttt->gia_hien_hanh = $data['giaHienHanh'];
            }
            if (isset($data['soKhachToiDa'])) {
                if ($data['soKhachToiDa'] < $ttt->so_khach_toi_thieu) {
                    throw AppException::badRequest("S? khách t?i da không du?c nh? hon s? khách t?i thi?u");
                }
                $ttt->so_khach_toi_da = $data['soKhachToiDa'];
            }
            if (isset($data['soKhachToiThieu'])) {
                if ($data['soKhachToiThieu'] > $ttt->so_khach_toi_da) {
                    throw AppException::badRequest("S? khách t?i thi?u không du?c l?n hon s? khách t?i da");
                }
                $ttt->so_khach_toi_thieu = $data['soKhachToiThieu'];
            }
            if (isset($data['trangThai'])) {
                $this->validateTrangThaiTourThucTe($data['trangThai']);
                // B? qua ki?m tra phân công HDV trong giai do?n này
                $ttt->trang_thai = $data['trangThai'];
            }

            $ttt->save();

            if (array_key_exists('maDichVuThem', $data)) {
                $ttt->dichVuThems()->sync($data['maDichVuThem'] ?? []);
            }
            if (array_key_exists('maHanhDongXanh', $data)) {
                $ttt->hanhDongXanhs()->sync($data['maHanhDongXanh'] ?? []);
            }
            
            $ttt->load(['tourMau', 'dichVuThems', 'hanhDongXanhs']);
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

            if ($ttt->trang_thai !== 'CHO_KICH_HOAT' && $ttt->trang_thai !== 'MO_BAN') {
                throw AppException::badRequest("Ch? có th? xóa tour th?c t? ? tr?ng thái CHO_KICH_HOAT ho?c MO_BAN");
            }

            // Ki?m tra xem có don d?t tour nào không (b? qua cho Giai do?n 3.1 vì DonDatTour thu?c Giai do?n 4, nhung t?m th?i cài d?t ki?m tra co b?n)
            if (DonDatTour::where('ma_tour_thuc_te', $id)->whereNotIn('trang_thai', ['DA_HUY'])->exists()) {
                throw AppException::badRequest("Không th? xóa tour th?c t? dã phát sinh don d?t tour");
            }

            $ttt->trang_thai = 'HUY';
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
            ->where("ma_tour_thuc_te", $maTourThucTe)
            ->orderBy("ngay_danh_gia", "desc")
            ->get();
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


