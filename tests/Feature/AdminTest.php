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
        VaiTro::create(['MaVaiTro' => 'ADMIN', 'TenHienThi' => 'Quản trị viên']);
        VaiTro::create(['MaVaiTro' => 'KHACHHANG', 'TenHienThi' => 'Khách Hàng']);

        // Tạo admin user
        $this->adminUser = TaiKhoan::create([
            'MaTaiKhoan' => 'TK_ADMIN',
            'TenDangNhap' => 'admin_test',
            'MatKhau' => Hash::make('password123'),
            'HoTen' => 'Admin Test',
            'VaiTro' => 'ADMIN',
            'TrangThai' => 'HOAT_DONG'
        ]);

        // Tạo normal user
        $this->normalUser = TaiKhoan::create([
            'MaTaiKhoan' => 'TK_USER',
            'TenDangNhap' => 'user_test',
            'MatKhau' => Hash::make('password123'),
            'HoTen' => 'User Test',
            'VaiTro' => 'KHACHHANG',
            'TrangThai' => 'HOAT_DONG'
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
        $this->assertDatabaseHas('NHATKYHETHONG', [
            'MaTaiKhoan' => 'TK_ADMIN',
            'DoiTuong' => 'users',
            'HanhDong' => 'POST users'
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
