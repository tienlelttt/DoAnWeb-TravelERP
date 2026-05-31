<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpringPaginationResource;
use App\Services\QuyetToanService;
use Illuminate\Http\Request;

class KeToanHoanTienController extends Controller
{
    public function __construct(
        private QuyetToanService $quyetToanService
    ) {}

    /**
     * Lấy danh sách giao dịch đang chờ kế toán hoàn tiền (UC52)
     */
    public function danhSachChoHoanTien(Request $request)
    {
        $perPage = $request->query('size', 10);
        $list = $this->quyetToanService->danhSachChoHoanTien($perPage);

        // Map data để giống ThanhToanResponse
        $list->getCollection()->transform(function($gd) {
            return (object) [
                'maGiaoDich' => $gd->MaGiaoDich,
                'maDatTour' => $gd->MaDatTour,
                'soTien' => (float) $gd->SoTien,
                'phuongThuc' => $gd->PhuongThuc,
                'loaiGiaoDich' => $gd->LoaiGiaoDich,
                'trangThai' => $gd->TrangThai,
                'ngayThanhToan' => $gd->NgayThanhToan
            ];
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => new SpringPaginationResource($list)
        ]);
    }

    /**
     * Xác nhận đã chuyển khoản hoàn tiền cho khách thành công
     */
    public function xacNhanHoanTien($maGiaoDich)
    {
        $gd = $this->quyetToanService->xacNhanHoanTien($maGiaoDich);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Xác nhận hoàn tiền thành công',
            'data' => (object) [
                'maGiaoDich' => $gd->MaGiaoDich,
                'maDatTour' => $gd->MaDatTour,
                'soTien' => (float) $gd->SoTien,
                'phuongThuc' => $gd->PhuongThuc,
                'loaiGiaoDich' => $gd->LoaiGiaoDich,
                'trangThai' => $gd->TrangThai,
                'ngayThanhToan' => $gd->NgayThanhToan
            ]
        ]);
    }

    /**
     * Từ chối hoàn tiền, đẩy đơn về trạng thái tranh chấp (TU_CHOI_HOAN_TIEN)
     */
    public function tuChoiHoanTien($maGiaoDich)
    {
        $gd = $this->quyetToanService->tuChoiHoanTien($maGiaoDich);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Từ chối hoàn tiền thành công',
            'data' => (object) [
                'maGiaoDich' => $gd->MaGiaoDich,
                'maDatTour' => $gd->MaDatTour,
                'soTien' => (float) $gd->SoTien,
                'phuongThuc' => $gd->PhuongThuc,
                'loaiGiaoDich' => $gd->LoaiGiaoDich,
                'trangThai' => $gd->TrangThai,
                'ngayThanhToan' => $gd->NgayThanhToan
            ]
        ]);
    }
}
