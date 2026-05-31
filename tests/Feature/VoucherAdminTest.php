<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use App\Models\VaiTro;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VoucherAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(['MaVaiTro' => 'KINHDOANH', 'TenHienThi' => 'Kinh Doanh']);

        $this->kinhDoanhUser = TaiKhoan::create([
            'MaTaiKhoan' => 'TK_KINHDOANH',
            'TenDangNhap' => 'kd_test',
            'MatKhau' => Hash::make('password123'),
            'HoTen' => 'Kinh Doanh Test',
            'VaiTro' => 'KINHDOANH',
            'TrangThai' => 'HOAT_DONG'
        ]);
    }

    public function testKinhDoanhCoTheTaoVoucherMoi()
    {
        $payload = [
            'maCode' => 'SUMMER2026',
            'loaiUuDai' => 'SO_TIEN',
            'giaTriGiam' => 500000,
            'soLuotPhatHanh' => 100,
            'ngayHieuLuc' => now()->toDateString(),
            'ngayHetHan' => now()->addDays(30)->toDateString()
        ];

        $response = $this->actingAs($this->kinhDoanhUser, 'api')
                         ->postJson('/api/kinh-doanh/voucher', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'maCode' => 'SUMMER2026',
                     'giaTriGiam' => 500000
                 ]);

        $this->assertDatabaseHas('VOUCHER', [
            'MaCode' => 'SUMMER2026'
        ]);
    }

    public function testKinhDoanhCoThePhatHanhVoucherChoKhachHang()
    {
        $voucher = Voucher::create([
            'MaVoucher' => 'VC_TEST',
            'MaCode' => 'TESTCODE',
            'LoaiUuDai' => 'PHAN_TRAM',
            'GiaTriGiam' => 10,
            'SoLuotPhatHanh' => 10,
            'SoLuotDaDung' => 0,
            'NgayHieuLuc' => now(),
            'NgayHetHan' => now()->addDays(30),
            'TrangThai' => 'SAN_SANG'
        ]);

        $payload = [
            'maKhachHang' => 'KH_VIP_01'
        ];

        $response = $this->actingAs($this->kinhDoanhUser, 'api')
                         ->postJson('/api/kinh-doanh/voucher/VC_TEST/phat-hanh', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('KHUYENMAI_KH', [
            'MaKhachHang' => 'KH_VIP_01',
            'MaVoucher' => 'VC_TEST',
            'TrangThai' => 'CO_HIEU_LUC'
        ]);
    }
}
