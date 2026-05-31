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
        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);

        return $this->successResponse(new NhanVienResource($nhanVien), "Láº¥y há»“ sÆ¡ nhÃ¢n viÃªn thÃ nh cÃ´ng");
    }

    /**
     * Láº¥y danh sÃ¡ch phÃ¢n cÃ´ng tour cá»§a báº£n thÃ¢n
     *
     * @return JsonResponse
     */
    public function layLichCongTac(): JsonResponse { 
        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);
        $lichCongTac = $this->nhanVienService->layLichCongTac($nhanVien->ma_nhan_vien);

        // Map data Ä‘á»ƒ chuáº©n hÃ³a key vá» camelCase
        $data = $lichCongTac->map(function ($item) {
            return [
                'maPhanCong' => $item->ma_phan_cong_tour,
                'maTourThucTe' => $item->ma_tour_thuc_te,
                'ngayPhanCong' => $item->ngay_phan_cong,
                'ngayPhanHoi' => $item->ngay_phan_hoi,
                'trangThaiChapNhan' => $item->trang_thai_chap_nhan,
                'tourThucTe' => $item->tourThucTe ? [
                    'maTourThucTe' => $item->tourThucTe->ma_tour_thuc_te,
                    'maTourMau' => $item->tourThucTe->ma_tour_mau,
                    'ngayKhoiHanh' => $item->tourThucTe->ngay_khoi_hanh,
                    'trangThai' => $item->tourThucTe->trang_thai,
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
        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);
        $nangLuc = $this->nhanVienService->layNangLuc($nhanVien->ma_nhan_vien);

        if (!$nangLuc) {
            return $this->successResponse(null, "NhÃ¢n viÃªn chÆ°a cÃ³ há»“ sÆ¡ nÄƒng lá»±c");
        }

        $data = [
            'maNangLuc' => $nangLuc->ma_nang_luc_nhan_vien,
            'ngonNgu' => $nangLuc->ngon_ngu,
            'chungChi' => $nangLuc->chung_chi,
            'chuyenMon' => $nangLuc->chuyen_mon,
            'danhGia' => (float) $nangLuc->danh_gia,
            'soDanhGia' => $nangLuc->so_danh_gia,
        ];

        return $this->successResponse($data, "Láº¥y nÄƒng lá»±c nhÃ¢n viÃªn thÃ nh cÃ´ng");
    }
}

