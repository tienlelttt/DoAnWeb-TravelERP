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
    public function danhSach($maTourThucTe)
    {
        $query = HanhDongXanh::with('tourThucTes'); // Load sẵn quan hệ để DTO lấy maTourThucTe

        if (!empty($maTourThucTe)) {
            $query->whereHas('tourThucTes', function ($q) use ($maTourThucTe) {
                $q->where('TOURTHUCTE.MaTourThucTe', $maTourThucTe);
            });
        }

        return HanhDongXanhResource::collection($query->get());
    }

    public function chiTiet($id)
    {
        $hdx = HanhDongXanh::with('tourThucTes')->find($id);
        if (!$hdx) {
            throw AppException::notFound("Không tìm thấy hành động xanh: {$id}");
        }
        return new HanhDongXanhResource($hdx);
    }

    public function taoMoi(array $data)
    {
        return DB::transaction(function () use ($data) {
            $hdx = new HanhDongXanh();
            // Tao ma hanh dong xanh ngan gon tu UUID.
            $hdx->MaHanhDongXanh = 'HDX_' . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            $hdx->TenHanhDong = $data['tenHanhDong'];
            $hdx->DiemCong = $data['diemCong'];
            $hdx->save();

            $this->ganTourThucTe($hdx, $data['maTourThucTe'] ?? null);
            
            $hdx->load('tourThucTes');
            return new HanhDongXanhResource($hdx);
        });
    }

    public function capNhat($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $hdx = HanhDongXanh::find($id);
            if (!$hdx) {
                throw AppException::notFound("Không tìm thấy hành động xanh: {$id}");
            }

            if (isset($data['tenHanhDong'])) {
                $hdx->TenHanhDong = $data['tenHanhDong'];
            }
            if (isset($data['diemCong'])) {
                $hdx->DiemCong = $data['diemCong'];
            }
            $hdx->save();

            if (array_key_exists('maTourThucTe', $data)) {
                $this->ganTourThucTe($hdx, $data['maTourThucTe']);
            }

            $hdx->load('tourThucTes');
            return new HanhDongXanhResource($hdx);
        });
    }

    public function xoa($id)
    {
        return DB::transaction(function () use ($id) {
            $hdx = HanhDongXanh::find($id);
            if (!$hdx) {
                throw AppException::notFound("Không tìm thấy hành động xanh: {$id}");
            }
            // Xóa quan hệ trước
            $hdx->tourThucTes()->detach();
            $hdx->delete();
        });
    }

    private function ganTourThucTe(HanhDongXanh $hdx, $maTourThucTe)
    {
        // Xóa hết quan hệ cũ
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
