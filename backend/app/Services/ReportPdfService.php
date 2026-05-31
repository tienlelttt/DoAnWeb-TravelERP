<?php

namespace App\Services;

use App\Models\QuyetToan;
use App\Models\DonDatTour;
use App\Models\ChiPhiThucTe;
use App\Models\TourThucTe;
use App\Models\GiaoDich;
use App\Exceptions\AppException;
use App\Helpers\SvgChartHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Service xử lý trích xuất dữ liệu và sinh tài liệu báo cáo PDF kèm biểu đồ SVG.
 */
class ReportPdfService
{
    private $validTypes = ['DOANH_THU', 'DON_DAT_TOUR', 'CHI_PHI', 'TOUR', 'GIAO_DICH'];

    public function __construct() {}

    /**
     * Tạo tài liệu PDF từ dữ liệu báo cáo
     */
    public function generatePdf(string $type, array $filters): string
    {
        $type = strtoupper($type);
        if (!in_array($type, $this->validTypes)) {
            throw AppException::badRequest("Loại báo cáo không hợp lệ. Hỗ trợ: " . implode(', ', $this->validTypes));
        }

        $tuNgay = !empty($filters['tuNgay']) ? Carbon::parse($filters['tuNgay'])->startOfDay() : null;
        $denNgay = !empty($filters['denNgay']) ? Carbon::parse($filters['denNgay'])->endOfDay() : null;

        // 1. Lấy dữ liệu mộc từ Database
        $rawRecords = $this->getDataForReport($type, $tuNgay, $denNgay);
        $totalRows = count($rawRecords);

        // 2. Chặn giới hạn hiệu năng bảo vệ hệ thống (> 5000 dòng)
        if ($totalRows > 5000) {
            throw AppException::badRequest("Dữ liệu quá lớn (đạt {$totalRows} dòng, vượt quá giới hạn 5,000 dòng). Vui lòng thu hẹp khoảng thời gian lọc để đảm bảo hiệu năng.");
        }

        // 3. Xử lý khi không có dữ liệu
        $chartSvg = '';
        $chartData = [];
        $chartLabels = [];

        if ($totalRows > 0) {
            // 4. Tổng hợp dữ liệu biểu đồ và lọc lấy TOP 15 lớn nhất
            switch ($type) {
                case 'DOANH_THU':
                    // Grouped Bar: So sánh Doanh thu, Chi phí, Lợi nhuận của từng Tour
                    // Sắp xếp giảm dần theo doanh thu để lấy Top 15
                    usort($rawRecords, function ($a, $b) {
                        return $b['tong_doanh_thu'] <=> $a['tong_doanh_thu'];
                    });
                    $top15 = array_slice($rawRecords, 0, 15);
                    
                    $chartData = [];
                    $chartLabels = [];
                    foreach ($top15 as $item) {
                        $chartLabels[] = $item['tieu_de_tour'] ?: $item['ma_tour_thuc_te'];
                        $chartData[] = [
                            (float) $item['tong_doanh_thu'],
                            (float) $item['tong_chi_phi'],
                            (float) $item['loi_nhuan']
                        ];
                    }
                    $chartSvg = SvgChartHelper::groupedBar($chartData, $chartLabels, ['Doanh thu', 'Chi phí', 'Lợi nhuận']);
                    break;

                case 'DON_DAT_TOUR':
                    // Line: Xu hướng số lượng đơn theo ngày
                    // Gom nhóm số lượng đơn theo ngày khởi tạo
                    $dailyCounts = [];
                    foreach ($rawRecords as $d) {
                        $dateStr = Carbon::parse($d['ngay_dat'])->format('d/m');
                        if (!isset($dailyCounts[$dateStr])) {
                            $dailyCounts[$dateStr] = 0;
                        }
                        $dailyCounts[$dateStr]++;
                    }
                    // Sắp xếp ngày tăng dần để hiển thị biểu đồ đường đúng trình tự thời gian
                    ksort($dailyCounts);
                    // Lấy tối đa 15 mốc thời gian gần nhất
                    if (count($dailyCounts) > 15) {
                        $dailyCounts = array_slice($dailyCounts, -15, 15, true);
                    }
                    
                    $chartLabels = array_keys($dailyCounts);
                    $chartData = array_values($dailyCounts);
                    $chartSvg = SvgChartHelper::line($chartData, $chartLabels, 'Số đơn đặt');
                    break;

                case 'CHI_PHI':
                    // Pie: Tỷ lệ chi phí thực tế phát sinh theo Danh mục
                    $categoryCosts = [];
                    foreach ($rawRecords as $c) {
                        $cat = $c['danh_muc'] ?: 'Khác';
                        if (!isset($categoryCosts[$cat])) {
                            $categoryCosts[$cat] = 0.0;
                        }
                        $categoryCosts[$cat] += (float) $c['thanh_tien'];
                    }
                    // Sắp xếp giảm dần để lấy Top 10 danh mục chi phí cao nhất
                    arsort($categoryCosts);
                    $top15 = array_slice($categoryCosts, 0, 15, true);

                    $chartLabels = array_keys($top15);
                    $chartData = array_values($top15);
                    $chartSvg = SvgChartHelper::pie($chartData, $chartLabels);
                    break;

                case 'TOUR':
                    // Horizontal Bar: So sánh tỷ lệ lấp đầy giữa các tour thực tế
                    // Sắp xếp theo số lượng chỗ đã đặt giảm dần
                    usort($rawRecords, function ($a, $b) {
                        $bookedA = $a['so_khach_toi_da'] - $a['cho_con_lai'];
                        $bookedB = $b['so_khach_toi_da'] - $b['cho_con_lai'];
                        return $bookedB <=> $bookedA;
                    });
                    $top15 = array_slice($rawRecords, 0, 15);

                    $chartLabels = [];
                    $chartData = [];
                    foreach ($top15 as $t) {
                        $chartLabels[] = $t['tieu_de'] ?: $t['ma_tour_thuc_te'];
                        $chartData[] = max(0, $t['so_khach_toi_da'] - $t['cho_con_lai']);
                    }
                    $chartSvg = SvgChartHelper::horizontalBar($chartData, $chartLabels, ' khách');
                    break;

                case 'GIAO_DICH':
                    // Pie: Tỷ lệ sử dụng giữa các Phương thức giao dịch thanh toán
                    $methodVolumes = [];
                    foreach ($rawRecords as $g) {
                        $method = $g['phuong_thuc'] ?: 'Chưa rõ';
                        if (!isset($methodVolumes[$method])) {
                            $methodVolumes[$method] = 0.0;
                        }
                        $methodVolumes[$method] += (float) $g['so_tien'];
                    }
                    // Lọc lấy các phương thức hàng đầu
                    arsort($methodVolumes);

                    $chartLabels = array_keys($methodVolumes);
                    $chartData = array_values($methodVolumes);
                    $chartSvg = SvgChartHelper::pie($chartData, $chartLabels);
                    break;
            }
        }

        // 5. Chuẩn bị tiêu đề và thời gian hiển thị báo cáo
        $title = $this->getReportTitle($type);
        $periodText = ($tuNgay && $denNgay)
            ? 'Từ ngày ' . $tuNgay->format('d/m/Y') . ' đến ngày ' . $denNgay->format('d/m/Y')
            : 'Tất cả thời gian';

        // 6. Kết xuất view Blade sang tài liệu PDF nhị phân qua DomPDF
        $viewName = 'reports.' . strtolower($type);
        $pdf = Pdf::loadView($viewName, [
            'title' => $title,
            'periodText' => $periodText,
            'data' => $rawRecords,
            'chartSvg' => $chartSvg,
            'tuNgay' => $tuNgay,
            'denNgay' => $denNgay
        ]);

        // Trả về luồng nhị phân
        return $pdf->output();
    }

    /**
     * Tiêu đề báo cáo hiển thị trên PDF
     */
    private function getReportTitle(string $type): string
    {
        switch ($type) {
            case 'DOANH_THU': return 'Báo cáo Doanh thu & Quyết toán Tour';
            case 'DON_DAT_TOUR': return 'Báo cáo Chi tiết Đơn đặt Tour';
            case 'CHI_PHI': return 'Báo cáo Phân tích Chi phí Thực tế';
            case 'TOUR': return 'Báo cáo Thống kê Tour Thực tế';
            case 'GIAO_DICH': return 'Báo cáo Chi tiết Giao dịch Thanh toán';
            default: return 'Báo cáo Hệ thống';
        }
    }

    /**
     * Lấy dữ liệu mộc từ DB giống cấu trúc của PowerBiService
     */
    private function getDataForReport(string $type, $tuNgay, $denNgay): array
    {
        $dataRows = [];

        switch ($type) {
            case 'DOANH_THU':
                $query = QuyetToan::with('tourThucTe.tourMau');
                if ($tuNgay) $query->where('ngay_quyet_toan', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_quyet_toan', '<=', $denNgay);
                
                foreach ($query->get() as $qt) {
                    $dataRows[] = [
                        'ma_quyet_toan' => $qt->ma_quyet_toan,
                        'ma_tour_thuc_te' => $qt->ma_tour_thuc_te,
                        'tieu_de_tour' => $qt->tourThucTe?->tourMau?->tieu_de ?? '',
                        'tong_doanh_thu' => (float) $qt->tong_doanh_thu,
                        'tong_chi_phi' => (float) $qt->tong_chi_phi,
                        'loi_nhuan' => (float) $qt->loi_nhuan,
                        'ngay_quyet_toan' => $qt->ngay_quyet_toan,
                        'trang_thai' => $qt->trang_thai
                    ];
                }
                break;
                
            case 'DON_DAT_TOUR':
                $query = DonDatTour::with('tourThucTe.tourMau');
                if ($tuNgay) $query->where('ngay_dat', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_dat', '<=', $denNgay);
                
                foreach ($query->get() as $d) {
                    $dataRows[] = [
                        'ma_dat_tour' => $d->ma_dat_tour,
                        'ma_tour_thuc_te' => $d->ma_tour_thuc_te,
                        'tieu_de_tour' => $d->tourThucTe?->tourMau?->tieu_de ?? '',
                        'ngay_dat' => $d->ngay_dat,
                        'tong_tien' => (float) $d->tong_tien,
                        'trang_thai' => $d->trang_thai
                    ];
                }
                break;
                
            case 'CHI_PHI':
                $query = ChiPhiThucTe::query();
                if ($tuNgay) $query->where('ngay_khai', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_khai', '<=', $denNgay);
                
                foreach ($query->get() as $c) {
                    $dataRows[] = [
                        'ma_chi_phi_thuc_te' => $c->ma_chi_phi_thuc_te,
                        'ma_tour_thuc_te' => $c->ma_tour_thuc_te,
                        'danh_muc' => $c->danh_muc,
                        'thanh_tien' => (float) $c->thanh_tien,
                        'trang_thai_duyet' => $c->trang_thai_duyet,
                        'ngay_khai' => $c->ngay_khai
                    ];
                }
                break;
                
            case 'TOUR':
                $query = TourThucTe::with('tourMau');
                if ($tuNgay) $query->where('ngay_khoi_hanh', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_khoi_hanh', '<=', $denNgay);
                
                foreach ($query->get() as $t) {
                    $dataRows[] = [
                        'ma_tour_thuc_te' => $t->ma_tour_thuc_te,
                        'tieu_de' => $t->tourMau?->tieu_de ?? '',
                        'ngay_khoi_hanh' => $t->ngay_khoi_hanh,
                        'gia_hien_hanh' => (float) $t->gia_hien_hanh,
                        'so_khach_toi_da' => (int) $t->so_khach_toi_da,
                        'cho_con_lai' => (int) $t->cho_con_lai,
                        'trang_thai' => $t->trang_thai
                    ];
                }
                break;
                
            case 'GIAO_DICH':
                $query = GiaoDich::query();
                if ($tuNgay) $query->where('ngay_thanh_toan', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_thanh_toan', '<=', $denNgay);
                
                foreach ($query->get() as $g) {
                    $dataRows[] = [
                        'ma_giao_dich' => $g->ma_giao_dich,
                        'ma_dat_tour' => $g->ma_dat_tour,
                        'loi_giao_dich' => $g->loi_giao_dich,
                        'phuong_thuc' => $g->phuong_thuc,
                        'so_tien' => (float) $g->so_tien,
                        'trang_thai' => $g->trang_thai,
                        'ngay_thanh_toan' => $g->ngay_thanh_toan
                    ];
                }
                break;
        }

        return $dataRows;
    }
}
