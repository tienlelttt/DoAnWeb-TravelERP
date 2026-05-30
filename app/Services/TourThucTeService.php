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
            throw AppException::notFound("Không tìm thấy tour thực tế: {$id}");
        }
        return new TourThucTeResource($tour);
    }

    public function chiTietCongKhai($id)
    {
        $tour = TourThucTe::with(['tourMau.lichTrinhTours'])->find($id);
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy tour: {$id}");
        }
        return new TourCongKhaiResource($tour);
    }

    public function taoMoi(array $data)
    {
        return DB::transaction(function () use ($data) {
            $tourMau = TourMau::find($data['maTourMau']);
            if (!$tourMau) {
                throw AppException::notFound("Không tìm thấy tour mẫu: {$data['maTourMau']}");
            }

            $soKhachToiThieu = $data['soKhachToiThieu'] ?? 1;

            if ($soKhachToiThieu > $data['soKhachToiDa']) {
                throw AppException::badRequest("Số khách tối thiểu không được lớn hơn số khách tối đa");
            }

            if ($data['giaHienHanh'] < $tourMau->GiaSan) {
                throw AppException::badRequest("Giá hiện hành không được thấp hơn giá sàn của tour mẫu ({$tourMau->GiaSan})");
            }

            $trangThai = !empty($data['trangThai']) ? $data['trangThai'] : 'CHO_KICH_HOAT';
            $this->validateTrangThaiTourThucTe($trangThai);
            if ($trangThai === 'MO_BAN') {
                throw AppException::badRequest("Tour mới phải ở trạng thái CHO_KICH_HOAT để phân công và xác nhận HDV trước khi mở bán.");
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

            // Bỏ qua Dịch vụ thêm & Hành động xanh trong giai đoạn 3.1
            
            $ttt->load('tourMau');
            return new TourThucTeResource($ttt);
        });
    }

    public function capNhat($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $ttt = TourThucTe::find($id);
            if (!$ttt) {
                throw AppException::notFound("Không tìm thấy tour thực tế: {$id}");
            }

            if (isset($data['giaHienHanh'])) {
                $ttt->GiaHienHanh = $data['giaHienHanh'];
            }
            if (isset($data['soKhachToiDa'])) {
                if ($data['soKhachToiDa'] < $ttt->SoKhachToiThieu) {
                    throw AppException::badRequest("Số khách tối đa không được nhỏ hơn số khách tối thiểu");
                }
                $ttt->SoKhachToiDa = $data['soKhachToiDa'];
            }
            if (isset($data['soKhachToiThieu'])) {
                if ($data['soKhachToiThieu'] > $ttt->SoKhachToiDa) {
                    throw AppException::badRequest("Số khách tối thiểu không được lớn hơn số khách tối đa");
                }
                $ttt->SoKhachToiThieu = $data['soKhachToiThieu'];
            }
            if (isset($data['trangThai'])) {
                $this->validateTrangThaiTourThucTe($data['trangThai']);
                // Bỏ qua kiểm tra phân công HDV trong giai đoạn này
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
                throw AppException::notFound("Không tìm thấy tour thực tế: {$id}");
            }

            if ($ttt->TrangThai !== 'CHO_KICH_HOAT' && $ttt->TrangThai !== 'MO_BAN') {
                throw AppException::badRequest("Chỉ có thể xóa tour thực tế ở trạng thái CHO_KICH_HOAT hoặc MO_BAN");
            }

            // Kiểm tra xem có đơn đặt tour nào không (bỏ qua cho Giai đoạn 3.1 vì DonDatTour thuộc Giai đoạn 4, nhưng tạm thời cài đặt kiểm tra cơ bản)
            if (DonDatTour::where('MaTourThucTe', $id)->whereNotIn('TrangThai', ['DA_HUY'])->exists()) {
                throw AppException::badRequest("Không thể xóa tour thực tế đã phát sinh đơn đặt tour");
            }

            $ttt->TrangThai = 'HUY';
            $ttt->save();
        });
    }

    private function validateTrangThaiTourThucTe($trangThai)
    {
        $validStatuses = ['CHO_KICH_HOAT', 'MO_BAN', 'DANG_DIEN_RA', 'KET_THUC', 'HUY', 'DA_QUYET_TOAN'];
        if (!in_array($trangThai, $validStatuses)) {
            throw AppException::badRequest("Trạng thái không hợp lệ: {$trangThai}");
        }
    }
}

