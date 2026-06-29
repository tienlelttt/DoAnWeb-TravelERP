<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use App\Models\VaiTro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReportPdfTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;
    private $keToanUser;
    private $khachHangUser;

    /**
     * Biên dịch sẵn tất cả Blade templates một lần trước khi chạy toàn bộ
     * test class. Tránh xung đột ghi file .tmp khi Windows giữ lock (code 32).
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        // Dùng đường dẫn tương đối từ thư mục tests/Feature đến artisan
        $artisanPath = realpath(__DIR__ . '/../../artisan');
        if ($artisanPath) {
            shell_exec(PHP_BINARY . ' ' . escapeshellarg($artisanPath) . ' view:cache 2>&1');
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Khởi tạo các vai trò
        VaiTro::firstOrCreate(['ma_vai_tro' => 'ADMIN'], ['ten_hien_thi' => 'Quản Trị Viên']);
        VaiTro::firstOrCreate(['ma_vai_tro' => 'KETOAN'], ['ten_hien_thi' => 'Kế Toán']);
        VaiTro::firstOrCreate(['ma_vai_tro' => 'KHACHHANG'], ['ten_hien_thi' => 'Khách Hàng']);

        // Tạo tài khoản admin
        $this->adminUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_ADMIN_TEST',
            'ten_dang_nhap' => 'admin_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Admin Test',
            'vai_tro' => 'ADMIN',
            'trang_thai' => 'HOAT_DONG'
        ]);

        // Tạo tài khoản kế toán
        $this->keToanUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KETOAN_TEST',
            'ten_dang_nhap' => 'ketoan_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Ke Toan Test',
            'vai_tro' => 'KETOAN',
            'trang_thai' => 'HOAT_DONG'
        ]);

        // Tạo tài khoản khách hàng
        $this->khachHangUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KHACHHANG_TEST',
            'ten_dang_nhap' => 'khachhang_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Khach Hang Test',
            'vai_tro' => 'KHACHHANG',
            'trang_thai' => 'HOAT_DONG'
        ]);
    }

    /**
     * Test quyền hạn: Admin được phép xuất PDF báo cáo.
     */
    public function testAdminCoTheXuatBaoCaoPdf()
    {
        $payload = [
            'tuNgay' => '2025-01-01',
            'denNgay' => '2025-01-31'
        ];

        $response = $this->actingAs($this->adminUser, 'api')
                         ->postJson('/api/admin/report/pdf/DOANH_THU', $payload);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        
        $content = $response->getContent();
        // Kiểm tra xem file có bắt đầu bằng chữ ký PDF chuẩn %PDF không
        $this->assertTrue(strpos($content, '%PDF-') === 0);

        // Kiểm tra xem đã ghi nhật ký hệ thống chưa
        $this->assertDatabaseHas('nhat_ky_he_thongs', [
            'ma_tai_khoan' => 'TK_ADMIN_TEST',
            'hanh_dong' => 'REPORT_PDF_XUAT_FILE',
            'doi_tuong' => 'XUAT_BAO_CAO_PDF',
            'ghi_chu' => 'DOANH_THU_20250101-20250131'
        ]);
    }

    /**
     * Test quyền hạn: Kế toán được phép xuất PDF báo cáo.
     */
    public function testKeToanCoTheXuatBaoCaoPdf()
    {
        $payload = [
            'tuNgay' => '2025-01-01',
            'denNgay' => '2025-01-31'
        ];

        $response = $this->actingAs($this->keToanUser, 'api')
                         ->postJson('/api/admin/report/pdf/DON_DAT_TOUR', $payload);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        
        $content = $response->getContent();
        $this->assertTrue(strpos($content, '%PDF-') === 0);

        $this->assertDatabaseHas('nhat_ky_he_thongs', [
            'ma_tai_khoan' => 'TK_KETOAN_TEST',
            'hanh_dong' => 'REPORT_PDF_XUAT_FILE',
            'doi_tuong' => 'XUAT_BAO_CAO_PDF',
            'ghi_chu' => 'DON_DAT_TOUR_20250101-20250131'
        ]);
    }

    /**
     * Test quyền hạn: Khách hàng bị chặn quyền truy cập.
     */
    public function testKhachHangBiChanXuatBaoCaoPdf()
    {
        $payload = [
            'tuNgay' => '2025-01-01',
            'denNgay' => '2025-01-31'
        ];

        $response = $this->actingAs($this->khachHangUser, 'api')
                         ->postJson('/api/admin/report/pdf/DOANH_THU', $payload);

        $response->assertStatus(403);
    }

    /**
     * Test validation: Lỗi nếu thiếu tham số tuNgay hoặc denNgay.
     */
    public function testXuatPdfLoiKhiThieuNgayFilter()
    {
        // Thiếu denNgay
        $payload = [
            'tuNgay' => '2025-01-01'
        ];

        $response = $this->actingAs($this->adminUser, 'api')
                         ->postJson('/api/admin/report/pdf/DOANH_THU', $payload);

        $response->assertStatus(400);
        $response->assertJsonFragment([
            'success' => false,
            'error' => 'VALIDATION_ERROR'
        ]);
        $this->assertStringContainsString('denNgay', $response->json('message'));
    }

    /**
     * Test validation: Lỗi nếu tuNgay > denNgay.
     */
    public function testXuatPdfLoiKhiTuNgayLonHonDenNgay()
    {
        // tuNgay lớn hơn denNgay
        $payload = [
            'tuNgay' => '2025-02-01',
            'denNgay' => '2025-01-31'
        ];

        $response = $this->actingAs($this->adminUser, 'api')
                         ->postJson('/api/admin/report/pdf/DOANH_THU', $payload);

        $response->assertStatus(400);
        $response->assertJsonFragment([
            'success' => false,
            'message' => 'Ngày bắt đầu lọc (tuNgay) phải nhỏ hơn hoặc bằng ngày kết thúc (denNgay).'
        ]);
    }

    /**
     * Test validation: Lỗi khi truyền loại báo cáo không hợp lệ.
     */
    public function testXuatPdfLoiKhiLoaiBaoCaoKhongHopLe()
    {
        $payload = [
            'tuNgay' => '2025-01-01',
            'denNgay' => '2025-01-31'
        ];

        $response = $this->actingAs($this->adminUser, 'api')
                         ->postJson('/api/admin/report/pdf/BAO_CAO_LINH_TINH', $payload);

        $response->assertStatus(400);
        $this->assertStringContainsString('Loại báo cáo không hợp lệ', $response->json('message'));
    }
}
