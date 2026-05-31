<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhanCongTourRequest;
use App\Services\PhanCongTourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DieuHanhController extends Controller
{
    protected PhanCongTourService $phanCongService;

    public function __construct(PhanCongTourService $phanCongService)
    {
        $this->phanCongService = $phanCongService;
    }

    /**
     * API Phân công HDV (Dành cho Điều Hành)
     */
    public function phanCongTour(PhanCongTourRequest $request): JsonResponse
    {
        $data = $request->validated();
        $phanCong = $this->phanCongService->phanCongHDV($data["maTourThucTe"], $data["maNhanVien"]);
        
        return $this->successResponse($phanCong, "Phân công hướng dẫn viên thành công");
    }

    /**
     * API Lấy danh sách tour cần phân công
     */
    public function tourCanPhanCong(): JsonResponse
    {
        $data = $this->phanCongService->danhSachTourCanPhanCong();
        return $this->successResponse($data);
    }

    /**
     * API Lấy danh sách HDV khả dụng cho tour
     */
    public function hdvKhaDung(Request $request): JsonResponse
    {
        $request->validate(['maTourThucTe' => 'required|string']);
        $data = $this->phanCongService->danhSachHdvKhaDung($request->maTourThucTe);
        return $this->successResponse($data);
    }

    /**
     * API Huỷ phân công
     */
    public function huyPhanCong(string $maPhanCong): JsonResponse
    {
        $this->phanCongService->huyPhanCong($maPhanCong);
        return $this->noContent("Hủy phân công thành công");
    }

    /**
     * API Lấy năng lực của một nhân viên cụ thể (Dành cho Điều Hành)
     */
    public function layNangLucNhanVien(string $maNhanVien): JsonResponse
    {
        $nangLuc = \App\Models\NangLucNhanVien::where('ma_nhan_vien', $maNhanVien)->first();

        if (!$nangLuc) {
            return $this->successResponse(null, "Nhân viên chưa có hồ sơ năng lực");
        }

        $data = [
            'maNangLuc' => $nangLuc->ma_nang_luc_nhan_vien,
            'maNangLucNhanVien' => $nangLuc->ma_nang_luc_nhan_vien,
            'maNhanVien' => $nangLuc->ma_nhan_vien,
            'ngonNgu' => $nangLuc->ngon_ngu,
            'chungChi' => $nangLuc->chung_chi,
            'chuyenMon' => $nangLuc->chuyen_mon,
            'danhGia' => (float) $nangLuc->danh_gia,
            'soDanhGia' => $nangLuc->so_danh_gia,
        ];

        return $this->successResponse($data, "Lấy năng lực nhân viên thành công");
    }

    /**
     * API Cập nhật năng lực của một nhân viên cụ thể (Dành cho Điều Hành)
     */
    public function capNhatNangLucNhanVien(Request $request, string $maNhanVien): JsonResponse
    {
        $request->validate([
            'ngonNgu' => 'nullable|string',
            'chungChi' => 'nullable|string',
            'chuyenMon' => 'nullable|string',
        ]);

        $nangLuc = \App\Models\NangLucNhanVien::where('ma_nhan_vien', $maNhanVien)->first();

        if (!$nangLuc) {
            $nangLuc = new \App\Models\NangLucNhanVien();
            $nangLuc->ma_nang_luc_nhan_vien = 'NL_' . $maNhanVien;
            $nangLuc->ma_nhan_vien = $maNhanVien;
            $nangLuc->danh_gia = 5.0;
            $nangLuc->so_danh_gia = 0;
        }

        $nangLuc->ngon_ngu = $request->input('ngonNgu');
        $nangLuc->chung_chi = $request->input('chungChi');
        $nangLuc->chuyen_mon = $request->input('chuyenMon');
        $nangLuc->save();

        $data = [
            'maNangLuc' => $nangLuc->ma_nang_luc_nhan_vien,
            'maNangLucNhanVien' => $nangLuc->ma_nang_luc_nhan_vien,
            'maNhanVien' => $nangLuc->ma_nhan_vien,
            'ngonNgu' => $nangLuc->ngon_ngu,
            'chungChi' => $nangLuc->chung_chi,
            'chuyenMon' => $nangLuc->chuyen_mon,
            'danhGia' => (float) $nangLuc->danh_gia,
            'soDanhGia' => $nangLuc->so_danh_gia,
        ];

        return $this->successResponse($data, "Cập nhật năng lực nhân viên thành công");
    }

    /**
     * API Lấy lịch công tác của một nhân viên cụ thể (Dành cho Điều Hành)
     */
    public function layLichCongTacNhanVien(string $maNhanVien): JsonResponse
    {
        $lichCongTac = \App\Models\PhanCongTour::with('tourThucTe')
            ->where('ma_nhan_vien', $maNhanVien)
            ->orderBy('ngay_phan_cong', 'desc')
            ->get();

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

        return $this->successResponse($data, "Lấy lịch công tác thành công");
    }
}
