<?php

namespace App\Services;

use App\Models\DichVuThem;
use App\Models\TourThucTe;
use App\Exceptions\AppException;
use App\Http\Resources\DichVuThemResource;
use Illuminate\Support\Facades\DB;

class DichVuThemService
{
    protected $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    public function danhSach($maTourThucTe)
    {
        $query = DichVuThem::query();

        if (!empty($maTourThucTe)) {
            $query->whereHas('tourThucTes', function ($q) use ($maTourThucTe) {
                $q->where('TOURTHUCTE.MaTourThucTe', $maTourThucTe);
            });
        }

        return DichVuThemResource::collection($query->get());
    }

    public function chiTiet($id)
    {
        $dv = DichVuThem::find($id);
        if (!$dv) {
            throw AppException::notFound("Không tìm thấy dịch vụ: {$id}");
        }
        return new DichVuThemResource($dv);
    }

    public function taoMoi(array $data)
    {
        return DB::transaction(function () use ($data) {
            $dv = new DichVuThem();
            $dv->MaDichVuThem = $this->maTuDongService->taoMaDichVuThem();
            $dv->Ten = $data['ten'];
            $dv->DonGia = $data['donGia'];
            $dv->DonViTinh = $data['donViTinh'] ?? null;
            $dv->save();

            return new DichVuThemResource($dv);
        });
    }

    public function capNhat($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $dv = DichVuThem::find($id);
            if (!$dv) {
                throw AppException::notFound("Không tìm thấy dịch vụ: {$id}");
            }

            if (isset($data['ten'])) {
                $dv->Ten = $data['ten'];
            }
            if (isset($data['donGia'])) {
                $dv->DonGia = $data['donGia'];
            }
            if (isset($data['donViTinh'])) {
                $dv->DonViTinh = $data['donViTinh'];
            }
            $dv->save();

            return new DichVuThemResource($dv);
        });
    }

    public function xoa($id)
    {
        return DB::transaction(function () use ($id) {
            $dv = DichVuThem::find($id);
            if (!$dv) {
                throw AppException::notFound("Không tìm thấy dịch vụ: {$id}");
            }
            $dv->delete();
        });
    }
}
