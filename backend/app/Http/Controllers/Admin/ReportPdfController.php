<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportPdfService;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Controller xử lý yêu cầu xuất báo cáo PDF kèm biểu đồ
 */
class ReportPdfController extends Controller
{
    private const MAX_REPORT_DAYS = 366;

    public function __construct(
        private ReportPdfService $reportPdfService
    ) {}

    /**
     * Xuất báo cáo dạng PDF kèm biểu đồ dựa trên bộ lọc
     */
    public function exportPDF(Request $request, $type)
    {
        // 1. Kiểm tra quyền hạn vai trò (ADMIN hoặc KETOAN)
        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này.'
            ], 401);
        }

        $validRoles = ['ADMIN', 'KETOAN'];
        if (!in_array(strtoupper($user->vai_tro), $validRoles)) {
            return response()->json([
                'status' => 403,
                'success' => false,
                'message' => 'Bạn không có quyền xuất tệp báo cáo này.'
            ], 403);
        }

        // 2. Kiểm tra bộ lọc thời gian bắt buộc và định dạng hợp lệ
        $request->validate([
            'tuNgay' => 'required|date',
            'denNgay' => 'required|date',
        ], [
            'tuNgay.required' => 'Ngày bắt đầu lọc không được để trống.',
            'tuNgay.date' => 'Ngày bắt đầu không đúng định dạng.',
            'denNgay.required' => 'Ngày kết thúc lọc không được để trống.',
            'denNgay.date' => 'Ngày kết thúc không đúng định dạng.',
        ]);

        $tuNgay = Carbon::parse($request->input('tuNgay'));
        $denNgay = Carbon::parse($request->input('denNgay'));

        // 3. Kiểm tra logic ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc
        if ($tuNgay->gt($denNgay)) {
            throw AppException::badRequest("Ngày bắt đầu lọc (tuNgay) phải nhỏ hơn hoặc bằng ngày kết thúc (denNgay).");
        }

        if ($tuNgay->diffInDays($denNgay) + 1 > self::MAX_REPORT_DAYS) {
            throw AppException::badRequest('Khoảng thời gian xuất báo cáo không được vượt quá ' . self::MAX_REPORT_DAYS . ' ngày.');
        }

        // 4. Lấy luồng dữ liệu PDF từ Service
        $pdfData = $this->reportPdfService->generatePdf($type, [
            'tuNgay' => $request->input('tuNgay'),
            'denNgay' => $request->input('denNgay')
        ]);

        // 5. Thiết lập tên file theo chuẩn: {LoaiBaoCao}_{tuNgay}_{denNgay}.pdf
        $filePrefix = $this->getFileNamePrefix($type);
        $filename = "{$filePrefix}_" . $tuNgay->format('Y-m-d') . "_" . $denNgay->format('Y-m-d') . ".pdf";

        // Ghi nhật ký hoạt động hệ thống
        \App\Models\NhatKyHeThong::create([
            'ma_nhat_ky_he_thong' => app(\App\Services\MaTuDongService::class)->taoMaNhatKyHeThong(),
            'ma_tai_khoan' => $user->ma_tai_khoan,
            'hanh_dong' => 'REPORT_PDF_XUAT_FILE',
            'doi_tuong' => 'XUAT_BAO_CAO_PDF',
            'ghi_chu' => $type . "_" . $tuNgay->format('Ymd') . "-" . $denNgay->format('Ymd'),
            'thoi_gian' => Carbon::now()
        ]);

        // 6. Trả về Response stream file PDF
        return response($pdfData)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Map tên loại báo cáo sang tiền tố tên file viết liền không dấu phù hợp
     */
    private function getFileNamePrefix(string $type): string
    {
        switch (strtoupper($type)) {
            case 'DOANH_THU': return 'DoanhThu';
            case 'DON_DAT_TOUR': return 'DonDatTour';
            case 'CHI_PHI': return 'ChiPhi';
            case 'TOUR': return 'ThongKeTour';
            case 'GIAO_DICH': return 'GiaoDich';
            default: return 'BaoCao';
        }
    }
}
