<?php

namespace App\Http\Controllers;

use App\Http\Requests\TraLoiPhanCongRequest;
use App\Http\Requests\DiemDanhRequest;
use App\Http\Requests\HanhDongXanhRequest;
use App\Http\Requests\BaoCaoSuCoRequest;
use App\Http\Requests\KhaiBaoChiPhiRequest;
use App\Services\PhanCongTourService;
use App\Services\VanHanhService;
use App\Models\NhanVien;
use App\Exceptions\AppException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HdvController extends Controller
{
    protected PhanCongTourService $phanCongService;
    protected VanHanhService $vanHanhService;

    public function __construct(PhanCongTourService $phanCongService, VanHanhService $vanHanhService)
    {
        $this->phanCongService = $phanCongService;
        $this->vanHanhService = $vanHanhService;
    }

    private function getHdvId(): string
    {
        $user = auth()->user();
        $hdv = NhanVien::where("ma_tai_khoan", $user->ma_tai_khoan)->first();
        if (!$hdv) {
            throw AppException::forbidden("Tài khoản của bạn không được liên kết với hồ sơ nhân viên hướng dẫn");
        }
        return $hdv->ma_nhan_vien;
    }

    public function traLoiPhanCong(string $maPhanCong, TraLoiPhanCongRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $data = $request->validated();
        $phanCong = $this->phanCongService->hdvTraLoiPhanCong($maPhanCong, $data["trangThaiTraLoi"], $maHdv);
        
        return $this->successResponse($phanCong, "Đã phản hồi yêu cầu phân công");
    }

    public function lichTrinhTour(string $maTour): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->layLichTrinh($maTour, $maHdv);
        return $this->successResponse($res, "Thành công");
    }

    public function danhSachDoan(string $maTour): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->layDanhSachKhach($maTour, $maHdv);
        return $this->successResponse($res, "Thành công");
    }

    public function diemDanh(string $maTour, DiemDanhRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->diemDanh($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Điểm danh thành công");
    }

    public function ghiNhanHanhDong(string $maTour, HanhDongXanhRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->ghiNhanHanhDongXanh($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Ghi nhận hành động xanh thành công");
    }

    public function danhSachSuCo(string $maTour, Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));
        $res = $this->vanHanhService->layDanhSachSuCo($maTour, $maHdv, $perPage);
        return $this->paginatedResponse($res, "Thành công");
    }

    public function baoCaoSuCo(string $maTour, BaoCaoSuCoRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->baoCaoSuCo($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Báo cáo sự cố thành công");
    }

    public function capNhatSuCo(string $maSuCo, Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        // Simple validation directly
        $data = $request->validate([
            "moTa" => "nullable|string",
            "giaiPhap" => "nullable|string"
        ]);
        $res = $this->vanHanhService->capNhatSuCo($maSuCo, $maHdv, $data);
        return $this->successResponse($res, "Cập nhật sự cố thành công");
    }

    public function chiPhiCuaTour(string $maTour, Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));
        $res = $this->vanHanhService->layDanhSachChiPhi($maTour, $maHdv, $perPage);
        return $this->paginatedResponse($res, "Thành công");
    }

    public function khaiChiPhi(string $maTour, KhaiBaoChiPhiRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->khaiBaoChiPhi($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Khai báo chi phí thành công");
    }

    public function boSungChiPhi(string $maChiPhi, Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $data = $request->validate([
            "hoaDonAnh" => "required|string"
        ]);
        $res = $this->vanHanhService->boSungChiPhi($maChiPhi, $maHdv, $data);
        return $this->successResponse($res, "Bổ sung chi phí thành công");
    }

    /**
     * Lấy danh sách tour được phân công của bản thân (Dành cho HDV)
     * GET /api/huong-dan-vien/tour-cua-toi
     */
    public function tourCuaToi(): JsonResponse
    {
        $maHdv = $this->getHdvId();
        
        $phanCongs = \App\Models\PhanCongTour::with(['tourThucTe.tourMau'])
            ->where('ma_nhan_vien', $maHdv)
            ->orderBy('ngay_phan_cong', 'desc')
            ->get();

        $tourCodes = $phanCongs->pluck('ma_tour_thuc_te')->filter()->unique()->values();
        $guestCounts = \App\Models\ChiTietDatTour::query()
            ->join('don_dat_tours', 'chi_tiet_dat_tours.ma_dat_tour', '=', 'don_dat_tours.ma_dat_tour')
            ->whereIn('don_dat_tours.ma_tour_thuc_te', $tourCodes)
            ->whereIn('don_dat_tours.trang_thai', ['DA_XAC_NHAN', 'DA_THANH_TOAN', 'HOAN_THANH'])
            ->selectRaw('don_dat_tours.ma_tour_thuc_te, COUNT(*) as total')
            ->groupBy('don_dat_tours.ma_tour_thuc_te')
            ->pluck('total', 'ma_tour_thuc_te');

        $data = $phanCongs->map(function ($item) use ($guestCounts) {
            $tourThucTe = $item->tourThucTe;
            $tourMau = $tourThucTe ? $tourThucTe->tourMau : null;
            $guestsCount = $tourThucTe ? (int) ($guestCounts[$tourThucTe->ma_tour_thuc_te] ?? 0) : 0;

            return [
                'maPhanCong' => $item->ma_phan_cong_tour,
                'maTourThucTe' => $item->ma_tour_thuc_te,
                'trangThaiChapNhan' => $item->trang_thai_chap_nhan,
                'tenTour' => $tourMau ? $tourMau->tieu_de : ($tourThucTe ? $tourThucTe->ma_tour_thuc_te : 'Tour không tên'),
                'ngayKhoiHanh' => $tourThucTe ? $tourThucTe->ngay_khoi_hanh : null,
                'ngayKetThuc' => $tourThucTe && $tourMau ? \Carbon\Carbon::parse($tourThucTe->ngay_khoi_hanh)->addDays(max((int) $tourMau->thoi_luong - 1, 0))->toDateString() : null,
                'soKhachDaXacNhan' => $guestsCount,
                'trangThaiTour' => $tourThucTe ? $tourThucTe->trang_thai : 'CHO_KICH_HOAT',
                'danhSachHanhKhach' => [] // Sẽ được tải lazy qua layDanhSachDoan
            ];
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    /**
     * Đồng ý phân công tour
     * POST /api/huong-dan-vien/phan-cong/{maPhanCong}/dong-y
     */
    public function dongYPhanCong(string $maPhanCong): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $phanCong = $this->phanCongService->hdvTraLoiPhanCong($maPhanCong, 'DA_DONG_Y', $maHdv);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Đồng ý nhận tour thành công',
            'data' => $phanCong
        ]);
    }

    /**
     * Từ chối phân công tour
     * POST /api/huong-dan-vien/phan-cong/{maPhanCong}/tu-choi
     */
    public function tuChoiPhanCong(string $maPhanCong): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $phanCong = $this->phanCongService->hdvTraLoiPhanCong($maPhanCong, 'TU_CHOI', $maHdv);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Từ chối nhận tour thành công',
            'data' => $phanCong
        ]);
    }

    /**
     * Lấy danh sách yêu cầu giải trình của HDV
     * GET /api/huong-dan-vien/yeu-cau-giai-trinh
     */
    public function danhSachYeuCauGiaiTrinh(Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));
        
        $tourCodes = \App\Models\PhanCongTour::where('ma_nhan_vien', $maHdv)
            ->where('trang_thai_chap_nhan', 'DA_DONG_Y')
            ->pluck('ma_tour_thuc_te');

        $requests = \App\Models\YeuCauHoTro::whereIn('trang_thai', ['CHO_GIAI_TRINH', 'CHO_HDV_GIAI_TRINH'])
            ->whereHas('donDatTour', function ($q) use ($tourCodes) {
                $q->whereIn('ma_tour_thuc_te', $tourCodes);
            })
            ->paginate($perPage);

        $data = $requests->getCollection()->map(function ($yc) {
            return [
                'maYeuCau' => $yc->ma_yeu_cau_ho_tro,
                'maDatTour' => $yc->ma_dat_tour,
                'loaiYeuCau' => $yc->loai_yeu_cau,
                'noiDung' => $yc->noi_dung,
                'trangThai' => $yc->trang_thai,
            ];
        });
        $requests->setCollection($data);

        return $this->paginatedResponse($requests, 'Thành công');
    }

    /**
     * Cập nhật / nộp giải trình cho yêu cầu hỗ trợ
     * PUT /api/huong-dan-vien/yeu-cau-giai-trinh/{maYeuCau}
     */
    public function capNhatGiaiTrinh(string $maYeuCau, Request $request): JsonResponse
    {
        $this->getHdvId();
        
        $request->validate([
            'noiDung' => 'required|string'
        ]);

        $yc = \App\Models\YeuCauHoTro::where('ma_yeu_cau_ho_tro', $maYeuCau)->first();
        if (!$yc) {
            throw AppException::notFound("Không tìm thấy yêu cầu hỗ trợ");
        }

        $yc->noi_dung = $yc->noi_dung . "\n[HDV giải trình: " . $request->input('noiDung') . "]";
        $yc->trang_thai = 'CHUA_XU_LY';
        $yc->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Nộp giải trình thành công',
            'data' => $yc
        ]);
    }

    /**
     * Lấy danh sách quyết toán cần bổ sung thông tin
     * GET /api/huong-dan-vien/quyet-toan/can-bo-sung
     */
    public function quyetToanCanBoSung(Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));
        
        $tourCodes = \App\Models\PhanCongTour::where('ma_nhan_vien', $maHdv)
            ->where('trang_thai_chap_nhan', 'DA_DONG_Y')
            ->pluck('ma_tour_thuc_te');

        $requests = \App\Models\QuyetToan::with('tourThucTe.tourMau')
            ->where('ghi_chu', 'like', '%' . \App\Services\QuyetToanService::YEU_CAU_BO_SUNG_MARKER . '%')
            ->whereIn('ma_tour_thuc_te', $tourCodes)
            ->paginate($perPage);

        $data = $requests->getCollection()->map(function ($qt) {
            return [
                'maQuyetToan' => $qt->ma_quyet_toan,
                'maTour' => $qt->ma_tour_thuc_te,
                'tenTour' => $qt->tourThucTe && $qt->tourThucTe->tourMau ? $qt->tourThucTe->tourMau->tieu_de : $qt->ma_tour_thuc_te,
                'ghiChu' => $qt->ghi_chu,
                'hoaDonAnh' => $qt->hoa_don_anh,
            ];
        });
        $requests->setCollection($data);

        return $this->paginatedResponse($requests, 'Thành công');
    }

    /**
     * Bổ sung quyết toán
     * PUT /api/huong-dan-vien/quyet-toan/{maQuyetToan}/bo-sung
     */
    public function boSungQuyetToan(string $maQuyetToan, Request $request): JsonResponse
    {
        $this->getHdvId();
        
        $request->validate([
            'ghiChu' => 'required|string',
            'hoaDonAnh' => 'nullable|string'
        ]);

        $qt = \App\Models\QuyetToan::where('ma_quyet_toan', $maQuyetToan)->first();
        if (!$qt) {
            throw AppException::notFound("Không tìm thấy quyết toán");
        }

        $qt->ghi_chu = $qt->ghi_chu . "\n[HDV bổ sung quyết toán: " . $request->input('ghiChu') . "]";
        if ($request->input('hoaDonAnh')) {
            $qt->hoa_don_anh = $request->input('hoaDonAnh');
        }
        $qt->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Bổ sung quyết toán thành công',
            'data' => $qt
        ]);
    }

    /**
     * Lấy toàn bộ chi phí thực tế của bản thân
     * GET /api/huong-dan-vien/chi-phi
     */
    public function tatCaChiPhi(Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $perPage = $this->normalizePerPage($request->query('size', $request->query('perPage')));
        
        $chiPhis = \App\Models\ChiPhiThucTe::where('ma_nhan_vien', $maHdv)
            ->orderBy('ngay_khai', 'desc')
            ->paginate($perPage);

        return $this->paginatedResponse($chiPhis, "Thành công");
    }

    /**
     * Lấy danh mục hành động xanh
     * GET /api/huong-dan-vien/hanh-dong-xanh
     */
    public function tatCaHanhDongXanh(Request $request): JsonResponse
    {
        $maTourThucTe = $request->query('maTourThucTe');
        
        if ($maTourThucTe) {
            $tour = \App\Models\TourThucTe::with('hanhDongXanhs')->where('ma_tour_thuc_te', $maTourThucTe)->first();
            $hdxs = $tour ? $tour->hanhDongXanhs : collect();
        } else {
            $hdxs = \App\Models\HanhDongXanh::all();
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => $hdxs
        ]);
    }
}
