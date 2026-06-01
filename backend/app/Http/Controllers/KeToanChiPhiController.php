<?php

namespace App\Http\Controllers;

use App\Models\ChiPhiThucTe;
use App\Services\KeToanChiPhiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeToanChiPhiController extends Controller
{
    protected KeToanChiPhiService $keToanChiPhiService;

    /**
     * Khởi tạo controller với service xử lý nghiệp vụ duyệt chi phí.
     */
    public function __construct(KeToanChiPhiService $keToanChiPhiService)
    {
        $this->keToanChiPhiService = $keToanChiPhiService;
    }

    /**
     * Lấy danh sách chi phí thực tế theo bộ lọc kế toán.
     */
    public function danhSachChiPhi(Request $request): JsonResponse
    {
        $filters = [
            'maTour' => $request->query('maTour'),
            'trangThaiDuyet' => $request->query('trangThaiDuyet'),
        ];

        $data = $this->keToanChiPhiService->danhSachChiPhi($filters);

        return $this->successResponse($data, 'Lấy danh sách chi phí thành công');
    }

    /**
     * Tổng hợp các cảnh báo chi phí để giữ tương thích endpoint frontend cũ.
     */
    public function canhBaoChiPhi(Request $request): JsonResponse
    {
        $query = ChiPhiThucTe::query();

        if ($request->query('maTour')) {
            $query->where('ma_tour_thuc_te', $request->query('maTour'));
        }

        $items = $query->orderBy('ngay_khai', 'desc')
            ->get()
            ->filter(fn ($chiPhi) => empty($chiPhi->hoa_don_anh) || (float) $chiPhi->thanh_tien >= 5000000)
            ->values()
            ->map(function ($chiPhi, int $index) {
                $thanhTien = (float) $chiPhi->thanh_tien;
                $thieuHoaDon = empty($chiPhi->hoa_don_anh);

                return [
                    'maCanhBao' => 'CB_' . $chiPhi->ma_chi_phi_thuc_te . '_' . ($index + 1),
                    'maChiPhi' => $chiPhi->ma_chi_phi_thuc_te,
                    'maTour' => $chiPhi->ma_tour_thuc_te,
                    'loaiCanhBao' => $thieuHoaDon ? 'THIEU_CHUNG_TU' : 'VUOT_DINH_MUC',
                    'mucDo' => $thanhTien >= 10000000 ? 'CAO' : 'TRUNG_BINH',
                    'noiDung' => $thieuHoaDon
                        ? 'Khoản chi phí thiếu ảnh hóa đơn/chứng từ.'
                        : 'Khoản chi phí có giá trị lớn, cần kiểm tra trước khi quyết toán.',
                    'thanhTien' => $thanhTien,
                ];
            });

        $page = (int) $request->query('page', 0) + 1;
        $size = $this->normalizePerPage($request->query('size', 20));
        $total = $items->count();
        $totalPages = (int) ceil($total / $size);
        $pagedItems = $items->slice(($page - 1) * $size, $size)->values();

        return $this->successResponse([
            'content' => $pagedItems,
            'totalPages' => $totalPages,
            'totalElements' => $total,
            'size' => $size,
            'number' => $page - 1,
            'last' => $page >= max(1, $totalPages),
        ], 'Thành công');
    }

    /**
     * Duyệt một khoản chi phí thực tế.
     */
    public function duyetChiPhi(string $maChiPhi): JsonResponse
    {
        $chiPhi = $this->keToanChiPhiService->duyetChiPhi($maChiPhi);

        return $this->successResponse($chiPhi, 'Đã duyệt khoản chi phí');
    }

    /**
     * Từ chối một khoản chi phí thực tế.
     */
    public function tuChoiChiPhi(string $maChiPhi): JsonResponse
    {
        $chiPhi = $this->keToanChiPhiService->tuChoiChiPhi($maChiPhi);

        return $this->successResponse($chiPhi, 'Đã từ chối khoản chi phí');
    }

    /**
     * Yêu cầu HDV bổ sung chứng từ cho khoản chi phí.
     */
    public function yeuCauBoSungChiPhi(string $maChiPhi): JsonResponse
    {
        $chiPhi = $this->keToanChiPhiService->yeuCauBoSungChiPhi($maChiPhi);

        return $this->successResponse($chiPhi, 'Đã yêu cầu bổ sung chứng từ chi phí');
    }
}
