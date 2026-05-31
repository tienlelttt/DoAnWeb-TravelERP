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
            'MaNhatKyHeThong' => app(\App\Services\MaTuDongService::class)->taoMaNhatKyHeThong(),
            'MaTaiKhoan' => $user->MaTaiKhoan,
            'HanhDong' => 'POWER_BI_KET_NOI',
            'DoiTuong' => 'XUAT_DU_LIEU_POWERBI',
            'GhiChu' => $maKho,
            'ThoiGian' => \Carbon\Carbon::now()
        ]);

        return [
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'serviceName' => env('DB_DATABASE', 'travel_erp'),
            'username' => 'powerbi_readonly',
            'password' => 'powerbi_secret_key',
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

        $tuNgay = !empty($request['tuNgay']) ? Carbon::parse($request['tuNgay'])->startOfDay() : null;
        $denNgay = !empty($request['denNgay']) ? Carbon::parse($request['denNgay'])->endOfDay() : null;

        \App\Models\NhatKyHeThong::create([
            'MaNhatKyHeThong' => app(\App\Services\MaTuDongService::class)->taoMaNhatKyHeThong(),
            'MaTaiKhoan' => $user->MaTaiKhoan,
            'HanhDong' => 'POWER_BI_XUAT_FILE',
            'DoiTuong' => 'XUAT_DU_LIEU_POWERBI',
            'GhiChu' => $maKho . "_" . $request['dinhDang'],
            'ThoiGian' => \Carbon\Carbon::now()
        ]);

        $dataRows = [];
        $headers = [];

        switch ($maKho) {
            case 'DOANH_THU':
                $headers = ['Mã QT', 'Mã Tour TT', 'Tiêu đề Tour', 'Tổng Doanh Thu', 'Tổng Chi Phí', 'Lợi Nhuận', 'Ngày QT', 'Trạng Thái'];
                $query = QuyetToan::with('tourThucTe.tourMau');
                if ($tuNgay) $query->where('NgayQuyetToan', '>=', $tuNgay);
                if ($denNgay) $query->where('NgayQuyetToan', '<=', $denNgay);
                
                foreach ($query->get() as $qt) {
                    $dataRows[] = [
                        $qt->MaQuyetToan,
                        $qt->MaTourThucTe,
                        $qt->tourThucTe?->tourMau?->TieuDe ?? '',
                        $qt->TongDoanhThu,
                        $qt->TongChiPhi,
                        $qt->LoiNhuan,
                        $qt->NgayQuyetToan,
                        $qt->TrangThai
                    ];
                }
                break;
                
            case 'DON_DAT_TOUR':
                $headers = ['Mã Đặt Tour', 'Mã Tour TT', 'Tiêu đề Tour', 'Ngày Đặt', 'Tổng Tiền', 'Trạng Thái'];
                $query = DonDatTour::with('tourThucTe.tourMau');
                if ($tuNgay) $query->where('NgayDat', '>=', $tuNgay);
                if ($denNgay) $query->where('NgayDat', '<=', $denNgay);
                
                foreach ($query->get() as $d) {
                    $dataRows[] = [
                        $d->MaDatTour,
                        $d->MaTourThucTe,
                        $d->tourThucTe?->tourMau?->TieuDe ?? '',
                        $d->NgayDat,
                        $d->TongTien,
                        $d->TrangThai
                    ];
                }
                break;
                
            case 'CHI_PHI':
                $headers = ['Mã Chi Phí', 'Mã Tour TT', 'Danh Mục', 'Thành Tiền', 'Trạng Thái Duyệt', 'Ngày Khai'];
                $query = ChiPhiThucTe::query();
                if ($tuNgay) $query->where('NgayKhai', '>=', $tuNgay);
                if ($denNgay) $query->where('NgayKhai', '<=', $denNgay);
                
                foreach ($query->get() as $c) {
                    $dataRows[] = [
                        $c->MaChiPhiThucTe,
                        $c->MaTourThucTe,
                        $c->DanhMuc,
                        $c->ThanhTien,
                        $c->TrangThaiDuyet,
                        $c->NgayKhai
                    ];
                }
                break;
                
            case 'TOUR':
                $headers = ['Mã Tour TT', 'Tiêu đề', 'Ngày Khởi Hành', 'Giá Hiện Hành', 'Số Khách Tối Đa', 'Chỗ Còn Lại', 'Trạng Thái'];
                $query = TourThucTe::with('tourMau');
                if ($tuNgay) $query->where('NgayKhoiHanh', '>=', $tuNgay);
                if ($denNgay) $query->where('NgayKhoiHanh', '<=', $denNgay);
                
                foreach ($query->get() as $t) {
                    $dataRows[] = [
                        $t->MaTourThucTe,
                        $t->tourMau?->TieuDe ?? '',
                        $t->NgayKhoiHanh,
                        $t->GiaHienHanh,
                        $t->SoKhachToiDa,
                        $t->ChoConLai,
                        $t->TrangThai
                    ];
                }
                break;
                
            case 'GIAO_DICH':
                $headers = ['Mã Giao Dịch', 'Mã Đặt Tour', 'Loại GD', 'Phương Thức', 'Số Tiền', 'Trạng Thái', 'Ngày Thanh Toán'];
                $query = GiaoDich::query();
                if ($tuNgay) $query->where('NgayThanhToan', '>=', $tuNgay);
                if ($denNgay) $query->where('NgayThanhToan', '<=', $denNgay);
                
                foreach ($query->get() as $g) {
                    $dataRows[] = [
                        $g->MaGiaoDich,
                        $g->MaDatTour,
                        $g->LoaiGiaoDich,
                        $g->PhuongThuc,
                        $g->SoTien,
                        $g->TrangThai,
                        $g->NgayThanhToan
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
}
