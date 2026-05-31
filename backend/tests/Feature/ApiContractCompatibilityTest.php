<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use App\Models\VaiTro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiContractCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    private TaiKhoan $dieuhanhUser;
    private TaiKhoan $kinhdoanhUser;
    private TaiKhoan $sanphamUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed necessary roles
        VaiTro::create(['ma_vai_tro' => 'ADMIN', 'ten_hien_thi' => 'Quản trị viên']);
        VaiTro::create(['ma_vai_tro' => 'DIEUHANH', 'ten_hien_thi' => 'Nhân viên điều hành']);
        VaiTro::create(['ma_vai_tro' => 'KINHDOANH', 'ten_hien_thi' => 'Nhân viên kinh doanh']);
        VaiTro::create(['ma_vai_tro' => 'SANPHAM', 'ten_hien_thi' => 'Nhân viên sản phẩm']);

        // Create test users for RBAC testing
        $this->dieuhanhUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_DH_TEST',
            'ten_dang_nhap' => 'dieuhanh_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Điều Hành Test',
            'vai_tro' => 'DIEUHANH',
            'trang_thai' => 'HOAT_DONG'
        ]);

        $this->kinhdoanhUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KD_TEST',
            'ten_dang_nhap' => 'kinhdoanh_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Kinh Doanh Test',
            'vai_tro' => 'KINHDOANH',
            'trang_thai' => 'HOAT_DONG'
        ]);

        $this->sanphamUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_SP_TEST',
            'ten_dang_nhap' => 'sanpham_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Sản Phẩm Test',
            'vai_tro' => 'SANPHAM',
            'trang_thai' => 'HOAT_DONG'
        ]);
    }

    public function test_customer_voucher_alias_routes_are_registered(): void
    {
        $this->getJson('/api/khach-hang/vi-voucher')->assertStatus(401);
        $this->getJson('/api/khach-hang/voucher-co-the-doi')->assertStatus(401);
        $this->postJson('/api/khach-hang/ap-voucher', [])->assertStatus(401);
        $this->postJson('/api/khach-hang/doi-diem', [])->assertStatus(401);
    }

    public function test_payment_alias_routes_are_registered(): void
    {
        $this->postJson('/api/thanh-toan/khoi-tao', [])->assertStatus(401);
        $this->postJson('/api/thanh-toan/DDT001/het-han-qr')->assertStatus(401);
        $this->postJson('/api/thanh-toan/DDT001/xac-nhan-chuyen-khoan')->assertStatus(401);
        $this->getJson('/api/thanh-toan/DDT001/ket-qua')->assertStatus(401);
    }

    public function test_admin_alias_routes_are_registered(): void
    {
        $this->getJson('/api/quan-tri/nhat-ky-he-thong')->assertStatus(401);
        $this->postJson('/api/quan-tri/dang-ky-nhan-vien', [])->assertStatus(401);
    }

    public function test_operation_alias_routes_are_registered(): void
    {
        $this->getJson('/api/kinh-doanh/danh-gia')->assertStatus(401);
        $this->postJson('/api/dieu-hanh/phan-cong', [])->assertStatus(401);
        $this->getJson('/api/dieu-hanh/tour/TTT001/doan')->assertStatus(401);
        $this->getJson('/api/dieu-hanh/tour/TTT001/su-co')->assertStatus(401);
        $this->getJson('/api/dieu-hanh/tour/TTT001/chi-phi')->assertStatus(401);

        $this->getJson('/api/kinh-doanh/dat-tour')->assertStatus(401);
        $this->putJson('/api/kinh-doanh/dat-tour/DDT001/xac-nhan')->assertStatus(401);
        $this->putJson('/api/kinh-doanh/dat-tour/DDT001/tu-choi-thanh-toan')->assertStatus(401);
        $this->getJson('/api/kinh-doanh/khach-hang')->assertStatus(401);
        $this->getJson('/api/kinh-doanh/khach-hang/KH001')->assertStatus(401);
        $this->getJson('/api/huong-dan-vien/su-co')->assertStatus(401);
    }

    public function test_rbac_unauthorized_role_returns_403(): void
    {
        // 1. DIEUHANH role attempting to POST /api/san-pham/tour-mau -> 403 Forbidden
        $response1 = $this->actingAs($this->dieuhanhUser, 'api')
                          ->postJson('/api/san-pham/tour-mau', [
                              'tieuDe' => 'Tour Test',
                              'thoiLuong' => 3,
                              'giaSan' => 1000000
                          ]);
        $response1->assertStatus(403);

        // 2. KINHDOANH role attempting to POST /api/dieu-hanh/tour-thuc-te -> 403 Forbidden
        $response2 = $this->actingAs($this->kinhdoanhUser, 'api')
                          ->postJson('/api/dieu-hanh/tour-thuc-te', [
                              'maTourMau' => 'TM001',
                              'ngayKhoiHanh' => '2026-06-01',
                              'giaHienHanh' => 2000000,
                              'soKhachToiDa' => 20,
                              'soKhachToiThieu' => 5
                          ]);
        $response2->assertStatus(403);

        // 3. SANPHAM role attempting to POST /api/dieu-hanh/tour-thuc-te -> 403 Forbidden
        $response3 = $this->actingAs($this->sanphamUser, 'api')
                          ->postJson('/api/dieu-hanh/tour-thuc-te', [
                              'maTourMau' => 'TM001',
                              'ngayKhoiHanh' => '2026-06-01',
                              'giaHienHanh' => 2000000,
                              'soKhachToiDa' => 20,
                              'soKhachToiThieu' => 5
                          ]);
        $response3->assertStatus(403);
    }
}
