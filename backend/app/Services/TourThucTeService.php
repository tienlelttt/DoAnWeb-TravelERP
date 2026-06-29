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
            throw AppException::notFound("Không tìm thấy tour thực tế: {$id}");
        }
        return new TourThucTeResource($tour);
    }

    public function chiTietCongKhai($id)
    {
        $tour = TourThucTe::with(['tourMau.lichTrinhTours', 'dichVuThems', 'hanhDongXanhs'])->find($id);
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

            if ($data['giaHienHanh'] < $tourMau->gia_san) {
                throw AppException::badRequest("Giá hiện hành không được thấp hơn giá sàn của tour mẫu ({$tourMau->gia_san})");
            }

            $trangThai = !empty($data['trangThai']) ? $data['trangThai'] : 'CHO_KICH_HOAT';
            $this->validateTrangThaiTourThucTe($trangThai);
            if ($trangThai === 'MO_BAN') {
                throw AppException::badRequest("Tour mới phải ở trạng thái CHO_KICH_HOAT để phân công và xác nhận HDV trước khi mở bán.");
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

            // Bỏ qua Dịch vụ thêm & Hành động xanh trong giai đoạn 3.1
            
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
                throw AppException::notFound("Không tìm thấy tour thực tế: {$id}");
            }

            if (isset($data['giaHienHanh'])) {
                $ttt->gia_hien_hanh = $data['giaHienHanh'];
            }
            if (isset($data['soKhachToiDa'])) {
                if ($data['soKhachToiDa'] < $ttt->so_khach_toi_thieu) {
                    throw AppException::badRequest("Số khách tối đa không được nhỏ hơn số khách tối thiểu");
                }
                $ttt->so_khach_toi_da = $data['soKhachToiDa'];
            }
            if (isset($data['soKhachToiThieu'])) {
                if ($data['soKhachToiThieu'] > $ttt->so_khach_toi_da) {
                    throw AppException::badRequest("Số khách tối thiểu không được lớn hơn số khách tối đa");
                }
                $ttt->so_khach_toi_thieu = $data['soKhachToiThieu'];
            }
            if (isset($data['trangThai'])) {
                $this->validateTrangThaiTourThucTe($data['trangThai']);
                // Bỏ qua kiểm tra phân công HDV trong giai đoạn này
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

        public function xoa($id, $lyDoHuy = null)
    {
        return DB::transaction(function () use ($id, $lyDoHuy) {
            $ttt = TourThucTe::find($id);
            if (!$ttt) {
                throw AppException::notFound("Không tìm thấy tour thực tế: {$id}");
            }

            if ($ttt->trang_thai !== 'CHO_KICH_HOAT' && $ttt->trang_thai !== 'MO_BAN') {
                throw AppException::badRequest("Chỉ có thể xóa/hủy tour thực tế ở trạng thái CHO_KICH_HOAT hoặc MO_BAN");
            }

            $dons = \App\Models\DonDatTour::where('ma_tour_thuc_te', $id)->whereNotIn('trang_thai', ['DA_HUY', 'TU_CHOI_HOAN_TIEN', 'DA_HOAN_TIEN', 'CHO_HOAN_TIEN'])->get();
            $tuDong = app(\App\Services\MaTuDongService::class);
            $user = auth()->user();
            $maNhanVien = null;
            if ($user && $user->vai_tro !== 'KHACHHANG') {
                $nv = \App\Models\NhanVien::where('ma_tai_khoan', $user->ma_tai_khoan)->first();
                $maNhanVien = $nv ? $nv->ma_nhan_vien : null;
            }

            foreach ($dons as $don) {
                if ($don->trang_thai === 'CHO_XAC_NHAN' || $don->trang_thai === 'DA_XAC_NHAN') {
                    $giaoDich = \App\Models\GiaoDich::where('ma_dat_tour', $don->ma_dat_tour)->where('loai_giao_dich', 'THANH_TOAN')->where('trang_thai', 'THANH_CONG')->first();
                    if ($giaoDich) {
                        $maGiaoDich = $tuDong->taoMaGiaoDich();
                        \App\Models\GiaoDich::create(['ma_giao_dich' => $maGiaoDich, 'ma_dat_tour' => $don->ma_dat_tour, 'loai_giao_dich' => 'HOAN_TIEN', 'phuong_thuc' => 'CHUYEN_KHOAN', 'so_tien' => $don->tong_tien, 'ma_gdnh' => null, 'trang_thai' => 'CHO_THANH_TOAN', 'ngay_thanh_toan' => null]);
                        $don->trang_thai = 'CHO_HUY';
                    } else {
                        $don->trang_thai = 'DA_HUY';
                    }
                    $maYeuCau = $tuDong->taoMaYeuCauHoTro();
                    $lyDo = $lyDoHuy ? $lyDoHuy : "Hệ thống tự động hủy tour.";
                    \App\Models\YeuCauHoTro::create(['ma_yeu_cau_ho_tro' => $maYeuCau, 'ma_dat_tour' => $don->ma_dat_tour, 'ma_khach_hang' => $don->ma_khach_hang, 'loai_yeu_cau' => 'HUY_TOUR', 'noi_dung' => "Tour thực tế bị hủy bởi quản trị. Lý do: {$lyDo}", 'trang_thai' => 'DA_XU_LY', 'ma_nhan_vien_xu_ly' => $maNhanVien]);
                } else {
                    $don->trang_thai = 'DA_HUY';
                }
                $don->save();
            }

            // Giai phong HDV (neu co)
            \App\Models\PhanCongTour::where('ma_tour_thuc_te', $id)->delete();

            $ttt->trang_thai = 'HUY';
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
            throw AppException::notFound("Không tìm thấy tour");
        }
        return $tour->hanhDongXanhs()->get();
    }

    public function layDichVuThem(string $maTourThucTe)
    {
        $tour = TourThucTe::find($maTourThucTe);
        if (!$tour) {
            throw AppException::notFound("Không tìm thấy tour");
        }
        return $tour->dichVuThems()->get();
    }
}


