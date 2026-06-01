<?php

namespace App\Services;

use App\Models\QuyetToan;
use App\Models\DonDatTour;
use App\Models\ChiPhiThucTe;
use App\Models\TourThucTe;
use App\Models\GiaoDich;
use App\Exceptions\AppException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Service xử lý logic kết xuất dữ liệu cho Power BI.
 */
class PowerBiService
{
    private const MAX_EXPORT_DAYS = 366;
    private const DEFAULT_EXPORT_DAYS = 31;
    private const MAX_EXPORT_ROWS = 5000;

    private $validKho = ['DOANH_THU', 'DON_DAT_TOUR', 'CHI_PHI', 'TOUR', 'GIAO_DICH'];

    public function __construct() {}

    /**
     * Danh sách các kho dữ liệu hiện có cho phân tích
     */
    public function danhSachKhoDuLieu()
    {
        return [
            [
                'maKho' => 'DOANH_THU',
                'tenKho' => 'Doanh thu & Quyết toán',
                'moTa' => 'Dữ liệu quyết toán tour: tổng doanh thu, chi phí, lợi nhuận theo tour'
            ],
            [
                'maKho' => 'DON_DAT_TOUR',
                'tenKho' => 'Đơn đặt tour',
                'moTa' => 'Chi tiết đơn đặt tour: mã đặt, tour, ngày đặt, tổng tiền, trạng thái'
            ],
            [
                'maKho' => 'CHI_PHI',
                'tenKho' => 'Chi phí thực tế',
                'moTa' => 'Chi phí phát sinh theo tour: danh mục, thành tiền, trạng thái duyệt'
            ],
            [
                'maKho' => 'TOUR',
                'tenKho' => 'Tour thực tế',
                'moTa' => 'Danh sách tour: ngày khởi hành, giá, số khách, trạng thái'
            ],
            [
                'maKho' => 'GIAO_DICH',
                'tenKho' => 'Giao dịch thanh toán',
                'moTa' => 'Giao dịch thanh toán: loại, phương thức, số tiền, trạng thái'
            ]
        ];
    }

    /**
     * Lấy thông tin tài khoản kết nối cho Power BI Desktop
     */
    public function layThongTinKetNoi($maKho, $user)
    {
        $this->validateMaKho($maKho);

        // Ghi nhật ký hệ thống
        \App\Models\NhatKyHeThong::create([
            'ma_nhat_ky_he_thong' => app(\App\Services\MaTuDongService::class)->taoMaNhatKyHeThong(),
            'ma_tai_khoan' => $user->ma_tai_khoan,
            'hanh_dong' => 'POWER_BI_KET_NOI',
            'doi_tuong' => 'XUAT_DU_LIEU_POWERBI',
            'ghi_chu' => $maKho,
            'thoi_gian' => \Carbon\Carbon::now()
        ]);

        return [
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'serviceName' => env('DB_DATABASE', 'travel_erp'),
            'username' => env('POWERBI_READONLY_USERNAME', 'powerbi_readonly'),
            'password' => env('POWERBI_READONLY_PASSWORD', ''),
            'jdbcUrl' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', 3306) . '/' . env('DB_DATABASE', 'travel_erp'),
            'hetHan' => 'Tài khoản read-only cố định, không tự động hết hạn',
            'huongDan' => "1. Mở Power BI Desktop → Get Data → MySQL Database\n2. Server: " . env('DB_HOST') . ":" . env('DB_PORT') . "\n3. Database: " . env('DB_DATABASE') . "\n4. Chọn 'Database' authentication, nhập Username và Password ở trên\n5. Chọn bảng cần phân tích → Load"
        ];
    }

    /**
     * Lấy dữ liệu mộc xuất thành định dạng CSV
     */
    public function xuatDuLieu(array $request, $user)
    {
        $maKho = $request['maKho'];
        $this->validateMaKho($maKho);

        [$tuNgay, $denNgay] = $this->resolveDateRange($request);

        \App\Models\NhatKyHeThong::create([
            'ma_nhat_ky_he_thong' => app(\App\Services\MaTuDongService::class)->taoMaNhatKyHeThong(),
            'ma_tai_khoan' => $user->ma_tai_khoan,
            'hanh_dong' => 'POWER_BI_XUAT_FILE',
            'doi_tuong' => 'XUAT_DU_LIEU_POWERBI',
            'ghi_chu' => $maKho . "_" . $request['dinhDang'],
            'thoi_gian' => \Carbon\Carbon::now()
        ]);

        $dataRows = [];
        $headers = [];

        switch ($maKho) {
            case 'DOANH_THU':
                $headers = ['Mã QT', 'Mã Tour TT', 'Tiêu đề Tour', 'Tổng Doanh Thu', 'Tổng Chi Phí', 'Lợi Nhuận', 'Ngày QT', 'Trạng Thái'];
                $query = QuyetToan::with('tourThucTe.tourMau');
                if ($tuNgay) $query->where('ngay_quyet_toan', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_quyet_toan', '<=', $denNgay);
                
                $this->guardExportSize($query);
                foreach ($query->get() as $qt) {
                    $dataRows[] = [
                        $qt->ma_quyet_toan,
                        $qt->ma_tour_thuc_te,
                        $qt->tourThucTe?->tourMau?->tieu_de ?? '',
                        $qt->tong_doanh_thu,
                        $qt->tong_chi_phi,
                        $qt->loi_nhuan,
                        $qt->ngay_quyet_toan,
                        $qt->trang_thai
                    ];
                }
                break;
                
            case 'DON_DAT_TOUR':
                $headers = ['Mã Đặt Tour', 'Mã Tour TT', 'Tiêu đề Tour', 'Ngày Đặt', 'Tổng Tiền', 'Trạng Thái'];
                $query = DonDatTour::with('tourThucTe.tourMau');
                if ($tuNgay) $query->where('ngay_dat', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_dat', '<=', $denNgay);
                
                $this->guardExportSize($query);
                foreach ($query->get() as $d) {
                    $dataRows[] = [
                        $d->ma_dat_tour,
                        $d->ma_tour_thuc_te,
                        $d->tourThucTe?->tourMau?->tieu_de ?? '',
                        $d->ngay_dat,
                        $d->tong_tien,
                        $d->trang_thai
                    ];
                }
                break;
                
            case 'CHI_PHI':
                $headers = ['Mã Chi Phí', 'Mã Tour TT', 'Danh Mục', 'Thành Tiền', 'Trạng Thái Duyệt', 'Ngày Khai'];
                $query = ChiPhiThucTe::query();
                if ($tuNgay) $query->where('ngay_khai', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_khai', '<=', $denNgay);
                
                $this->guardExportSize($query);
                foreach ($query->get() as $c) {
                    $dataRows[] = [
                        $c->ma_chi_phi_thuc_te,
                        $c->ma_tour_thuc_te,
                        $c->danh_muc,
                        $c->thanh_tien,
                        $c->trang_thai_duyet,
                        $c->ngay_khai
                    ];
                }
                break;
                
            case 'TOUR':
                $headers = ['Mã Tour TT', 'Tiêu đề', 'Ngày Khởi Hành', 'Giá Hiện Hành', 'Số Khách Tối Đa', 'Chỗ Còn Lại', 'Trạng Thái'];
                $query = TourThucTe::with('tourMau');
                if ($tuNgay) $query->where('ngay_khoi_hanh', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_khoi_hanh', '<=', $denNgay);
                
                $this->guardExportSize($query);
                foreach ($query->get() as $t) {
                    $dataRows[] = [
                        $t->ma_tour_thuc_te,
                        $t->tourMau?->tieu_de ?? '',
                        $t->ngay_khoi_hanh,
                        $t->gia_hien_hanh,
                        $t->so_khach_toi_da,
                        $t->cho_con_lai,
                        $t->trang_thai
                    ];
                }
                break;
                
            case 'GIAO_DICH':
                $headers = ['Mã Giao Dịch', 'Mã Đặt Tour', 'Loại GD', 'Phương Thức', 'Số Tiền', 'Trạng Thái', 'Ngày Thanh Toán'];
                $query = GiaoDich::query();
                if ($tuNgay) $query->where('ngay_thanh_toan', '>=', $tuNgay);
                if ($denNgay) $query->where('ngay_thanh_toan', '<=', $denNgay);
                
                $this->guardExportSize($query);
                foreach ($query->get() as $g) {
                    $dataRows[] = [
                        $g->ma_giao_dich,
                        $g->ma_dat_tour,
                        $g->loai_giao_dich,
                        $g->phuong_thuc,
                        $g->so_tien,
                        $g->trang_thai,
                        $g->ngay_thanh_toan
                    ];
                }
                break;
        }

        return $this->generateCsv($headers, $dataRows);
    }

    private function generateCsv($headers, $dataRows)
    {
        $output = fopen('php://temp', 'r+');
        // Ghi BOM UTF-8 để Excel đọc tiếng Việt không bị lỗi font
        fwrite($output, "\xEF\xBB\xBF");
        
        fputcsv($output, $headers);
        foreach ($dataRows as $row) {
            fputcsv($output, $row);
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }

    private function validateMaKho($maKho)
    {
        if (empty($maKho)) {
            throw AppException::badRequest("Mã kho dữ liệu không được trống");
        }
        if (!in_array($maKho, $this->validKho)) {
            throw AppException::badRequest("Mã kho dữ liệu không hợp lệ. Hỗ trợ: " . implode(', ', $this->validKho));
        }
    }

    private function resolveDateRange(array $request): array
    {
        $denNgay = !empty($request['denNgay'])
            ? Carbon::parse($request['denNgay'])->endOfDay()
            : now()->endOfDay();

        $tuNgay = !empty($request['tuNgay'])
            ? Carbon::parse($request['tuNgay'])->startOfDay()
            : $denNgay->copy()->subDays(self::DEFAULT_EXPORT_DAYS - 1)->startOfDay();

        if ($tuNgay->gt($denNgay)) {
            throw AppException::badRequest('Ngày bắt đầu lọc (tuNgay) phải nhỏ hơn hoặc bằng ngày kết thúc (denNgay).');
        }

        if ($tuNgay->diffInDays($denNgay) + 1 > self::MAX_EXPORT_DAYS) {
            throw AppException::badRequest('Khoảng thời gian xuất dữ liệu không được vượt quá ' . self::MAX_EXPORT_DAYS . ' ngày.');
        }

        return [$tuNgay, $denNgay];
    }

    private function guardExportSize($query): void
    {
        $totalRows = (clone $query)->count();

        if ($totalRows > self::MAX_EXPORT_ROWS) {
            throw AppException::badRequest('Dữ liệu quá lớn (' . $totalRows . ' dòng, vượt quá giới hạn ' . self::MAX_EXPORT_ROWS . ' dòng). Vui lòng thu hẹp khoảng thời gian lọc.');
        }
    }
}
