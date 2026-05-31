<?php

namespace Tests\Feature;

use App\Models\NhatKyHeThong;
use App\Models\TaiKhoan;
use App\Models\VaiTro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo roles
        VaiTro::create(['ma_vai_tro' => 'ADMIN', 'ten_hien_thi' => 'Quản trị viên']);
        VaiTro::create(['ma_vai_tro' => 'KHACHHANG', 'ten_hien_thi' => 'Khách Hàng']);

        // Tạo admin user
        $this->adminUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_ADMIN',
            'ten_dang_nhap' => 'admin_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Admin Test',
            'vai_tro' => 'ADMIN',
            'trang_thai' => 'HOAT_DONG'
        ]);

        // Tạo normal user
        $this->normalUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_USER',
            'ten_dang_nhap' => 'user_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'User Test',
            'vai_tro' => 'KHACHHANG',
            'trang_thai' => 'HOAT_DONG'
        ]);
    }

    public function testRbacTuChoiNguoiDungKhongPhaiAdmin()
    {
        // Normal user gọi API của admin
        $response = $this->actingAs($this->normalUser, 'api')
                         ->getJson('/api/admin/users');

        $response->assertStatus(403)
                 ->assertJsonFragment(['message' => 'Bạn không có quyền truy cập tài nguyên này']);
    }

    public function testAdminCoTheLayDanhSachUser()
    {
        $response = $this->actingAs($this->adminUser, 'api')
                         ->getJson('/api/admin/users');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'content' => [
                             '*' => ['maTaiKhoan', 'tenDangNhap', 'vaiTro']
                         ],
                         'totalElements'
                     ]
                 ]);
    }

    public function testAuditLogDuocGhiSauKhiTaoUser()
    {
        $payload = [
            'tenDangNhap' => 'new_admin',
            'matKhau' => 'password123',
            'hoTen' => 'New Admin',
            'email' => 'newadmin@test.com',
            'vaiTro' => 'ADMIN',
            'trangThai' => 'HOAT_DONG'
        ];

        $response = $this->actingAs($this->adminUser, 'api')
                         ->postJson('/api/admin/users', $payload);

        $response->assertStatus(201);

        // Kiểm tra database xem Audit Log có được lưu không
        $this->assertDatabaseHas('nhat_ky_he_thongs', [
            'ma_tai_khoan' => 'TK_ADMIN',
            'doi_tuong' => 'users',
            'hanh_dong' => 'POST users'
        ]);
    }

    public function testDashboardOverviewTraVeDataCungCauTruc()
    {
        $response = $this->actingAs($this->adminUser, 'api')
                         ->getJson('/api/admin/dashboard/overview');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'totalRevenue',
                         'totalBookings',
                         'totalCustomers',
                         'totalUsers'
                     ]
                 ]);
    }
}
