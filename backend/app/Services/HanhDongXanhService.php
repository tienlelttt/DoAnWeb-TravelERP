<?php

namespace App\Services;

use App\Models\HanhDongXanh;
use App\Models\TourThucTe;
use App\Exceptions\AppException;
use App\Http\Resources\HanhDongXanhResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HanhDongXanhService
{
    // UC20 | Nhân viên sản phẩm | Lấy danh sách hành động xanh.
    public function danhSach($maTourThucTe)
    {
        $query = HanhDongXanh::with('tourThucTes'); // Load sẵn quan hệ để DTO lấy maTourThucTe

        if (!empty($maTourThucTe)) {
            $query->whereHas('tourThucTes', function ($q) use ($maTourThucTe) {
                $q->where('tour_thuc_tes.ma_tour_thuc_te', $maTourThucTe);
            });
        }

        return HanhDongXanhResource::collection($query->get());
    }

    // UC20 | Nhân viên sản phẩm | Xem chi tiết hành động xanh.
    public function chiTiet($id)
    {
        $hdx = HanhDongXanh::with('tourThucTes')->find($id);
        if (!$hdx) {
            throw AppException::notFound("Không tìm thấy hành động xanh: {$id}");
        }
        return new HanhDongXanhResource($hdx);
    }

    // UC20 | Nhân viên sản phẩm | Thêm mới hành động xanh.
    public function taoMoi(array $data)
    {
        return DB::transaction(function () use ($data) {
            $hdx = new HanhDongXanh();
            $hdx->ma_hanh_dong_xanh = 'HDX_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            $hdx->ten_hanh_dong = $data['tenHanhDong'];
            $hdx->diem_cong = $data['diemCong'];
            $hdx->save();

            $this->ganTourThucTe($hdx, $data['maTourThucTe'] ?? null);
            
            $hdx->load('tourThucTes');
            return new HanhDongXanhResource($hdx);
        });
    }

    // UC20 | Nhân viên sản phẩm | Cập nhật hành động xanh.
    public function capNhat($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $hdx = HanhDongXanh::find($id);
            if (!$hdx) {
                throw AppException::notFound("Không tìm thấy hành động xanh: {$id}");
            }

            if (isset($data['tenHanhDong'])) {
                $hdx->ten_hanh_dong = $data['tenHanhDong'];
            }
            if (isset($data['diemCong'])) {
                $hdx->diem_cong = $data['diemCong'];
            }
            $hdx->save();

            if (array_key_exists('maTourThucTe', $data)) {
                $this->ganTourThucTe($hdx, $data['maTourThucTe']);
            }

            $hdx->load('tourThucTes');
            return new HanhDongXanhResource($hdx);
        });
    }

    // UC20 | Nhân viên sản phẩm | Xóa hành động xanh.
    public function xoa($id)
    {
        return DB::transaction(function () use ($id) {
            $hdx = HanhDongXanh::find($id);
            if (!$hdx) {
                throw AppException::notFound("Không tìm thấy hành động xanh: {$id}");
            }
            $hdx->tourThucTes()->detach();
            $hdx->delete();
        });
    }

    private function ganTourThucTe(HanhDongXanh $hdx, $maTourThucTe)
    {
        $hdx->tourThucTes()->detach();
        
        if (empty($maTourThucTe)) {
            return;
        }

        $tourThucTe = TourThucTe::find($maTourThucTe);
        if (!$tourThucTe) {
            throw AppException::notFound("Không tìm thấy tour thực tế: {$maTourThucTe}");
        }

        // Gán quan hệ mới
        $hdx->tourThucTes()->attach($maTourThucTe);
    }
}
