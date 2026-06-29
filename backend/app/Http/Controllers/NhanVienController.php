<?php

namespace App\Http\Controllers;

use App\Http\Resources\NhanVienResource;
use App\Services\NhanVienService;
use Illuminate\Http\JsonResponse;

// Module quản lý nhân viên.
class NhanVienController extends Controller
{
    protected NhanVienService $nhanVienService;

    /**
     * Khởi tạo controller với service hồ sơ nhân viên.
     */
    public function __construct(NhanVienService $nhanVienService)
    {
        $this->nhanVienService = $nhanVienService;
    }

    /**
     * Lấy hồ sơ nhân viên đang đăng nhập.
     */
    public function layHoSo(): JsonResponse
    {
        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);

        return $this->successResponse(new NhanVienResource($nhanVien), 'Lấy hồ sơ nhân viên thành công');
    }

    /**
     * Lấy danh sách phân công tour của nhân viên đang đăng nhập.
     */
    public function layLichCongTac(): JsonResponse
    {
        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);
        $lichCongTac = $this->nhanVienService->layLichCongTac($nhanVien->ma_nhan_vien);

        // Chuẩn hóa dữ liệu lịch công tác sang camelCase theo contract frontend.
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
                ] : null,
            ];
        });

        return $this->successResponse($data, 'Lấy lịch công tác thành công');
    }

    /**
     * Lấy thông tin năng lực của nhân viên đang đăng nhập.
     */
    public function layNangLuc(): JsonResponse
    {
        $maTaiKhoan = auth()->user()->ma_tai_khoan;
        $nhanVien = $this->nhanVienService->layHoSoNhanVien($maTaiKhoan);
        $nangLuc = $this->nhanVienService->layNangLuc($nhanVien->ma_nhan_vien);

        if (!$nangLuc) {
            return $this->successResponse(null, 'Nhân viên chưa có hồ sơ năng lực');
        }

        $data = [
            'maNangLuc' => $nangLuc->ma_nang_luc_nhan_vien,
            'ngonNgu' => $nangLuc->ngon_ngu,
            'chungChi' => $nangLuc->chung_chi,
            'chuyenMon' => $nangLuc->chuyen_mon,
            'danhGia' => (float) $nangLuc->danh_gia,
            'soDanhGia' => $nangLuc->so_danh_gia,
        ];

        return $this->successResponse($data, 'Lấy năng lực nhân viên thành công');
    }
}
