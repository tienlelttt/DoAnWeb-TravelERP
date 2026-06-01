<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use App\Models\VaiTro;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\DonDatTour;
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
        $this->getJson('/api/quan-tri/nhan-vien')->assertStatus(401);
        $this->getJson('/api/quan-tri/nhan-vien/NV001')->assertStatus(401);
        $this->putJson('/api/quan-tri/nhan-vien/NV001/vai-tro', [])->assertStatus(401);
        $this->putJson('/api/quan-tri/nhan-vien/NV001/mo-khoa', [])->assertStatus(401);
        $this->putJson('/api/quan-tri/nhan-vien/NV001/khoa', [])->assertStatus(401);
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

    public function test_frontend_kinh_doanh_chi_tiet_don_dat_tour_alias(): void
    {
        TourMau::create([
            'ma_tour_mau' => 'TM_KD_ALIAS',
            'tieu_de' => 'Tour KD Alias',
            'thoi_luong' => 3,
            'gia_san' => 1000000,
        ]);

        TourThucTe::create([
            'ma_tour_thuc_te' => 'TTT_KD_ALIAS',
            'ma_tour_mau' => 'TM_KD_ALIAS',
            'ngay_khoi_hanh' => now()->addDays(10),
            'gia_hien_hanh' => 1200000,
            'so_khach_toi_da' => 20,
            'so_khach_toi_thieu' => 10,
            'cho_con_lai' => 20,
            'trang_thai' => 'MO_BAN',
        ]);

        DonDatTour::create([
            'ma_dat_tour' => 'DDT_KD_ALIAS',
            'ma_tour_thuc_te' => 'TTT_KD_ALIAS',
            'ma_khach_hang' => 'KH_KD_ALIAS',
            'ngay_dat' => now(),
            'trang_thai' => 'CHO_XAC_NHAN',
            'tong_tien' => 1200000,
        ]);

        $this->actingAs($this->kinhdoanhUser, 'api')
            ->getJson('/api/kinh-doanh/dat-tour/DDT_KD_ALIAS')
            ->assertStatus(200)
            ->assertJsonPath('data.maDatTour', 'DDT_KD_ALIAS');
    }

    public function test_frontend_san_pham_loai_phong_crud_contract(): void
    {
        $created = $this->actingAs($this->sanphamUser, 'api')
            ->postJson('/api/san-pham/loai-phong', [
                'tenLoai' => 'Phòng đơn',
                'mucPhuThu' => 500000,
                'trangThai' => 'HOAT_DONG',
            ]);

        $created->assertStatus(201)
            ->assertJsonPath('data.tenLoai', 'Phòng đơn');

        $maLoaiPhong = $created->json('data.maLoaiPhong');

        $this->actingAs($this->sanphamUser, 'api')
            ->getJson('/api/san-pham/loai-phong')
            ->assertStatus(200)
            ->assertJsonPath('data.0.maLoaiPhong', $maLoaiPhong);

        $this->actingAs($this->sanphamUser, 'api')
            ->putJson('/api/san-pham/loai-phong/' . $maLoaiPhong, [
                'tenLoai' => 'Phòng đôi',
                'mucPhuThu' => 700000,
                'trangThai' => 'HOAT_DONG',
            ])
            ->assertStatus(200)
            ->assertJsonPath('data.tenLoai', 'Phòng đôi');

        $this->actingAs($this->sanphamUser, 'api')
            ->deleteJson('/api/san-pham/loai-phong/' . $maLoaiPhong)
            ->assertStatus(200);
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
