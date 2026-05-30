<?php

namespace App\Http\Controllers;

use App\Services\NhanVienService;
use App\Http\Resources\NhanVienResource;
use Illuminate\Http\JsonResponse;

class NhanVienController extends Controller
{
    protected NhanVienService $nhanVienService;

    public function __construct(NhanVienService $nhanVienService)
    {
        $this->nhanVienService = $nhanVienService;
    }

    /**
     * Láº¥y há»“ sÆ¡ nhÃ¢n viÃªn Ä‘ang Ä‘Äƒng nháº­p
     *
     * @return JsonResponse
     */
    public function layHoSo(): JsonResponse
    {
        $maTaiKhoan = auth()->user()->MaTaiKhoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);

        return $this->successResponse(new NhanVienResource($nhanVien), "Láº¥y há»“ sÆ¡ nhÃ¢n viÃªn thÃ nh cÃ´ng");
    }

    /**
     * Láº¥y danh sÃ¡ch phÃ¢n cÃ´ng tour cá»§a báº£n thÃ¢n
     *
     * @return JsonResponse
     */
    public function layLichCongTac(): JsonResponse { 
        $maTaiKhoan = auth()->user()->MaTaiKhoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);
        $lichCongTac = $this->nhanVienService->layLichCongTac($nhanVien->MaNhanVien);

        // Map data Ä‘á»ƒ chuáº©n hÃ³a key vá» camelCase
        $data = $lichCongTac->map(function ($item) {
            return [
                'maPhanCong' => $item->MaPhanCongTour,
                'maTourThucTe' => $item->MaTourThucTe,
                'ngayPhanCong' => $item->NgayPhanCong,
                'ngayPhanHoi' => $item->NgayPhanHoi,
                'trangThaiChapNhan' => $item->TrangThaiChapNhan,
                'tourThucTe' => $item->tourThucTe ? [
                    'maTourThucTe' => $item->tourThucTe->MaTourThucTe,
                    'maTourMau' => $item->tourThucTe->MaTourMau,
                    'ngayKhoiHanh' => $item->tourThucTe->NgayKhoiHanh,
                    'trangThai' => $item->tourThucTe->TrangThai,
                ] : null
            ];
        });

        return $this->successResponse($data, "Láº¥y lá»‹ch cÃ´ng tÃ¡c thÃ nh cÃ´ng");
    }

    /**
     * Láº¥y thÃ´ng tin nÄƒng lá»±c cá»§a báº£n thÃ¢n
     *
     * @return JsonResponse
     */
    public function layNangLuc(): JsonResponse
    {
        $maTaiKhoan = auth()->user()->MaTaiKhoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);
        $nangLuc = $this->nhanVienService->layNangLuc($nhanVien->MaNhanVien);

        if (!$nangLuc) {
            return $this->successResponse(null, "NhÃ¢n viÃªn chÆ°a cÃ³ há»“ sÆ¡ nÄƒng lá»±c");
        }

        $data = [
            'maNangLuc' => $nangLuc->MaNangLucNhanVien,
            'ngonNgu' => $nangLuc->NgonNgu,
            'chungChi' => $nangLuc->ChungChi,
            'chuyenMon' => $nangLuc->ChuyenMon,
            'danhGia' => (float) $nangLuc->DanhGia,
            'soDanhGia' => $nangLuc->SoDanhGia,
        ];

        return $this->successResponse($data, "Láº¥y nÄƒng lá»±c nhÃ¢n viÃªn thÃ nh cÃ´ng");
    }
}

