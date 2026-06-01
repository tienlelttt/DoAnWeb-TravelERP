<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonDatTour;
use App\Models\HoChieuSo;
use App\Models\NhanVien;
use App\Models\NhatKySuCo;
use App\Http\Resources\DonDatTourResource;
use App\Services\ThanhToanService;
use App\Exceptions\AppException;

class KinhDoanhCompatController extends Controller
{
    protected $thanhToanService;

    public function __construct(ThanhToanService $thanhToanService)
    {
        $this->thanhToanService = $thanhToanService;
    }

    /**
     * Lấy danh sách toàn bộ đơn đặt tour có phân trang và bộ lọc (Dành cho Sales/Kinh doanh)
     * GET /api/kinh-doanh/dat-tour
     * GET /api/kinh-doanh/don-dat-tour
     */
    public function danhSachDonDatTour(Request $request)
    {
        $query = DonDatTour::with([
            'tourThucTe.tourMau',
            'khachHang.taiKhoan',
            'chiTietDatTours.khachHang.taiKhoan',
            'chiTietDatTours.nguoiDongHanh',
            'chiTietDichVus.dichVuThem',
            'datTourUuDai.voucher'
        ]);

        if ($request->query('trangThai')) {
            $query->where('trang_thai', $request->query('trangThai'));
        }

        if ($request->query('maTourThucTe')) {
            $query->where('ma_tour_thuc_te', $request->query('maTourThucTe'));
        }

        $page = (int) $request->query('page', 0) + 1;
        $size = (int) $request->query('size', 200);

        $paginator = $query->orderBy('ngay_dat', 'desc')->paginate($size, ['*'], 'page', $page);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => [
                'content' => DonDatTourResource::collection($paginator->items()),
                'totalPages' => $paginator->lastPage(),
                'totalElements' => $paginator->total(),
                'size' => $paginator->perPage(),
                'number' => $paginator->currentPage() - 1,
                'last' => !$paginator->hasMorePages()
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Lấy chi tiết đơn đặt tour theo alias cũ mà frontend kinh doanh đang gọi.
     * GET /api/kinh-doanh/dat-tour/{maDatTour}
     * GET /api/kinh-doanh/don-dat-tour/{maDatTour}
     */
    public function chiTietDonDatTour(string $maDatTour)
    {
        $donDatTour = DonDatTour::with([
            'tourThucTe.tourMau',
            'khachHang.taiKhoan',
            'chiTietDatTours.khachHang.taiKhoan',
            'chiTietDatTours.nguoiDongHanh',
            'chiTietDichVus.dichVuThem',
            'datTourUuDai.voucher'
        ])->where('ma_dat_tour', $maDatTour)->first();

        if (!$donDatTour) {
            throw AppException::notFound('Không tìm thấy đơn đặt tour: ' . $maDatTour);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => new DonDatTourResource($donDatTour)
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Xác nhận đơn đặt tour
     * PUT /api/kinh-doanh/dat-tour/{maDatTour}/xac-nhan
     */
    public function xacNhanDon(string $maDatTour, Request $request)
    {
        $donDatTour = $this->thanhToanService->xacNhanThanhToan($maDatTour, 'DONG_Y');
        
        $donDatTour->load([
            'tourThucTe.tourMau',
            'khachHang.taiKhoan',
            'chiTietDatTours.khachHang.taiKhoan',
            'chiTietDatTours.nguoiDongHanh',
            'chiTietDichVus.dichVuThem',
            'datTourUuDai.voucher'
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Xác nhận duyệt thanh toán thành công',
            'data' => new DonDatTourResource($donDatTour)
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Từ chối xác nhận thanh toán
     * PUT /api/kinh-doanh/dat-tour/{maDatTour}/tu-choi-thanh-toan
     */
    public function tuChoiThanhToan(string $maDatTour, Request $request)
    {
        $donDatTour = $this->thanhToanService->xacNhanThanhToan($maDatTour, 'TU_CHOI');

        $donDatTour->load([
            'tourThucTe.tourMau',
            'khachHang.taiKhoan',
            'chiTietDatTours.khachHang.taiKhoan',
            'chiTietDatTours.nguoiDongHanh',
            'chiTietDichVus.dichVuThem',
            'datTourUuDai.voucher'
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Từ chối xác nhận thanh toán thành công',
            'data' => new DonDatTourResource($donDatTour)
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Tìm kiếm hồ sơ khách hàng
     * GET /api/kinh-doanh/khach-hang
     */
    public function timKiemKhachHang(Request $request)
    {
        $query = HoChieuSo::with('taiKhoan');

        if ($request->query('hoTen')) {
            $query->whereHas('taiKhoan', function($q) use ($request) {
                $q->where('ho_ten', 'like', '%' . $request->query('hoTen') . '%');
            });
        }

        if ($request->query('email')) {
            $query->whereHas('taiKhoan', function($q) use ($request) {
                $q->where('email', 'like', '%' . $request->query('email') . '%');
            });
        }

        if ($request->query('soDienThoai')) {
            $query->whereHas('taiKhoan', function($q) use ($request) {
                $q->where('so_dien_thoai', 'like', '%' . $request->query('soDienThoai') . '%');
            });
        }

        $page = (int) $request->query('page', 0) + 1;
        $size = (int) $request->query('size', 10);

        $paginator = $query->paginate($size, ['*'], 'page', $page);

        $items = collect($paginator->items())->map(function($hcs) {
            return [
                'maKhachHang' => $hcs->ma_khach_hang,
                'hoTen' => $hcs->taiKhoan->ho_ten,
                'email' => $hcs->taiKhoan->email,
                'soDienThoai' => $hcs->taiKhoan->so_dien_thoai,
                'cccd' => $hcs->taiKhoan->cccd,
                'ngaySinh' => $hcs->taiKhoan->ngay_sinh,
                'ghiChuYTe' => $hcs->ghi_chu_y_te,
                'diUng' => $hcs->di_ung,
                'hangThanhVien' => $hcs->hang_thanh_vien,
                'diemXanh' => $hcs->diem_xanh
            ];
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => [
                'content' => $items,
                'totalPages' => $paginator->lastPage(),
                'totalElements' => $paginator->total(),
                'size' => $paginator->perPage(),
                'number' => $paginator->currentPage() - 1,
                'last' => !$paginator->hasMorePages()
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Xem hồ sơ chi tiết khách hàng
     * GET /api/kinh-doanh/khach-hang/{maKhachHang}
     */
    public function chiTietKhachHang(string $maKhachHang)
    {
        $hcs = HoChieuSo::with('taiKhoan')->where('ma_khach_hang', $maKhachHang)->first();
        
        if (!$hcs) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => [
                'maKhachHang' => $hcs->ma_khach_hang,
                'hoTen' => $hcs->taiKhoan->ho_ten,
                'email' => $hcs->taiKhoan->email,
                'soDienThoai' => $hcs->taiKhoan->so_dien_thoai,
                'cccd' => $hcs->taiKhoan->cccd,
                'ngaySinh' => $hcs->taiKhoan->ngay_sinh,
                'ghiChuYTe' => $hcs->ghi_chu_y_te,
                'diUng' => $hcs->di_ung,
                'hangThanhVien' => $hcs->hang_thanh_vien,
                'diemXanh' => $hcs->diem_xanh
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Xem toàn bộ sự cố của hướng dẫn viên
     * GET /api/huong-dan-vien/su-co
     */
    public function suCoCuaHdv(Request $request)
    {
        $user = auth()->user();
        
        // Nếu là nhân viên văn phòng (ADMIN, KINHDOANH, DIEUHANH, KETOAN, SANPHAM) -> Cho phép xem tất cả sự cố
        if (in_array($user->vai_tro, ['ADMIN', 'KINHDOANH', 'DIEUHANH', 'KETOAN', 'SANPHAM'])) {
            $query = NhatKySuCo::query();
        } else {
            // Nếu là Hướng dẫn viên -> Chỉ xem sự cố của mình
            $hdv = NhanVien::where("ma_tai_khoan", $user->ma_tai_khoan)->first();
            if (!$hdv) {
                throw AppException::forbidden("Tài khoản của bạn không được liên kết với hồ sơ nhân viên hướng dẫn");
            }
            $query = NhatKySuCo::where('ma_nhan_vien_bao_cao', $hdv->ma_nhan_vien);
        }

        if ($request->query('mucDo')) {
            $query->where('muc_do', $request->query('mucDo'));
        }

        $suCos = $query->orderBy('thoi_gian_bao_cao', 'desc')->get();

        $data = $suCos->map(function($sc) {
            return [
                'maNhatKySuCo' => $sc->ma_nhat_ky_su_co,
                'maTour' => $sc->ma_tour_thuc_te,
                'moTa' => $sc->mo_ta,
                'giaiPhap' => $sc->giai_phap,
                'mucDo' => $sc->muc_do,
                'loaiSuCo' => $sc->loai_su_co,
                'maHdvBaoCao' => $sc->ma_nhan_vien_bao_cao,
                'maKhachHang' => $sc->ma_khach_hang,
                'maNguoiDongHanh' => $sc->ma_nguoi_dong_hanh,
                'thoiGianBaoCao' => $sc->thoi_gian_bao_cao
            ];
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => $data
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Lấy danh sách toàn bộ yêu cầu hỗ trợ (Dành cho Sales/Kinh doanh)
     * GET /api/kinh-doanh/yeu-cau-ho-tro
     */
    public function danhSachYeuCauHoTro(Request $request)
    {
        $query = \App\Models\YeuCauHoTro::query();

        if ($request->query('trangThai')) {
            $query->where('trang_thai', $request->query('trangThai'));
        }

        if ($request->query('loaiYeuCau')) {
            $query->where('loai_yeu_cau', $request->query('loaiYeuCau'));
        }

        $page = (int) $request->query('page', 0) + 1;
        $size = (int) $request->query('size', 100);

        $paginator = $query->orderBy('created_at', 'desc')->paginate($size, ['*'], 'page', $page);

        $items = collect($paginator->items())->map(function($yc) {
            return [
                'maYeuCau' => $yc->ma_yeu_cau_ho_tro,
                'maDatTour' => $yc->ma_dat_tour,
                'loaiYeuCau' => $yc->loai_yeu_cau,
                'noiDung' => $yc->noi_dung,
                'trangThai' => $yc->trang_thai,
                'maNhanVienXuLy' => $yc->ma_nhan_vien_xu_ly,
                'soTienHoan' => 0,
                'tiLeHoan' => 0,
                'thoiDiemTao' => $yc->created_at ? $yc->created_at->toDateTimeString() : null
            ];
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => [
                'content' => $items,
                'totalPages' => $paginator->lastPage(),
                'totalElements' => $paginator->total(),
                'size' => $paginator->perPage(),
                'number' => $paginator->currentPage() - 1,
                'last' => !$paginator->hasMorePages()
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Cập nhật / xử lý yêu cầu hỗ trợ
     * PUT /api/kinh-doanh/yeu-cau-ho-tro/{maYeuCau}
     */
    public function capNhatYeuCauHoTro(string $maYeuCau, Request $request)
    {
        $yc = \App\Models\YeuCauHoTro::where('ma_yeu_cau_ho_tro', $maYeuCau)->first();
        if (!$yc) {
            throw AppException::notFound("Không tìm thấy yêu cầu hỗ trợ");
        }

        $yc->trang_thai = $request->input('trangThai', $yc->trang_thai);
        $yc->ma_nhan_vien_xu_ly = $request->input('maNhanVienXuLy', $yc->ma_nhan_vien_xu_ly);
        $yc->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Cập nhật yêu cầu hỗ trợ thành công',
            'data' => [
                'maYeuCau' => $yc->ma_yeu_cau_ho_tro,
                'maDatTour' => $yc->ma_dat_tour,
                'loaiYeuCau' => $yc->loai_yeu_cau,
                'noiDung' => $yc->noi_dung,
                'trangThai' => $yc->trang_thai,
                'maNhanVienXuLy' => $yc->ma_nhan_vien_xu_ly,
                'thoiDiemTao' => $yc->created_at ? $yc->created_at->toDateTimeString() : null
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Yêu cầu HDV giải trình sự cố liên quan đến yêu cầu hỗ trợ
     * POST /api/kinh-doanh/yeu-cau-ho-tro/{maYeuCau}/yeu-cau-hdv-giai-trinh
     */
    public function yeuCauHdvGiaiTrinh(string $maYeuCau, Request $request)
    {
        $yc = \App\Models\YeuCauHoTro::where('ma_yeu_cau_ho_tro', $maYeuCau)->first();
        if (!$yc) {
            throw AppException::notFound("Không tìm thấy yêu cầu hỗ trợ");
        }

        $yc->trang_thai = 'CHO_GIAI_TRINH';
        $yc->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Đã gửi yêu cầu HDV giải trình',
            'data' => [
                'maYeuCau' => $yc->ma_yeu_cau_ho_tro,
                'maDatTour' => $yc->ma_dat_tour,
                'loaiYeuCau' => $yc->loai_yeu_cau,
                'noiDung' => $yc->noi_dung,
                'trangThai' => $yc->trang_thai,
                'maNhanVienXuLy' => $yc->ma_nhan_vien_xu_ly,
                'thoiDiemTao' => $yc->created_at ? $yc->created_at->toDateTimeString() : null
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Yêu cầu khách hàng bổ sung thông tin
     * POST /api/kinh-doanh/yeu-cau-ho-tro/{maYeuCau}/yeu-cau-khach-hang-bo-sung
     */
    public function yeuCauKhachHangBoSung(string $maYeuCau, Request $request)
    {
        $yc = \App\Models\YeuCauHoTro::where('ma_yeu_cau_ho_tro', $maYeuCau)->first();
        if (!$yc) {
            throw AppException::notFound("Không tìm thấy yêu cầu hỗ trợ");
        }

        $yc->trang_thai = 'CHO_BO_SUNG';
        $yc->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Đã yêu cầu khách hàng bổ sung thông tin',
            'data' => [
                'maYeuCau' => $yc->ma_yeu_cau_ho_tro,
                'maDatTour' => $yc->ma_dat_tour,
                'loaiYeuCau' => $yc->loai_yeu_cau,
                'noiDung' => $yc->noi_dung,
                'trangThai' => $yc->trang_thai,
                'maNhanVienXuLy' => $yc->ma_nhan_vien_xu_ly,
                'thoiDiemTao' => $yc->created_at ? $yc->created_at->toDateTimeString() : null
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
