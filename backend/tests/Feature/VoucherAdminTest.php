<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use App\Models\VaiTro;
use App\Models\Voucher;
use App\Models\HoChieuSo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VoucherAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(['ma_vai_tro' => 'KINHDOANH', 'ten_hien_thi' => 'Kinh Doanh']);

        $this->kinhDoanhUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KINHDOANH',
            'ten_dang_nhap' => 'kd_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Kinh Doanh Test',
            'vai_tro' => 'KINHDOANH',
            'trang_thai' => 'HOAT_DONG'
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

        $this->assertDatabaseHas('vouchers', [
            'ma_code' => 'SUMMER2026'
        ]);
    }

    public function testKinhDoanhCoThePhatHanhVoucherChoKhachHang()
    {
        $voucher = Voucher::create([
            'ma_voucher' => 'VC_TEST',
            'ma_code' => 'TESTCODE',
            'loai_uu_dai' => 'PHAN_TRAM',
            'gia_tri_giam' => 10,
            'so_luot_phat_hanh' => 10,
            'so_luot_da_dung' => 0,
            'ngay_hieu_luc' => now(),
            'ngay_het_han' => now()->addDays(30),
            'trang_thai' => 'SAN_SANG'
        ]);

        $payload = [
            'maKhachHang' => 'KH_VIP_01'
        ];

        $response = $this->actingAs($this->kinhDoanhUser, 'api')
                         ->postJson('/api/kinh-doanh/voucher/VC_TEST/phat-hanh', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('khuyen_mai_khs', [
            'ma_khach_hang' => 'KH_VIP_01',
            'ma_voucher' => 'VC_TEST',
            'trang_thai' => 'CO_HIEU_LUC'
        ]);
    }

    public function testKinhDoanhCoTheXemVaThuHoiVoucherDaPhanBo()
    {
        TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KH_VOUCHER',
            'ten_dang_nhap' => 'kh_voucher',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Khách Voucher',
            'vai_tro' => 'KHACHHANG',
            'trang_thai' => 'HOAT_DONG'
        ]);

        HoChieuSo::create([
            'ma_khach_hang' => 'KH_VIP_02',
            'ma_tai_khoan' => 'TK_KH_VOUCHER',
            'hang_thanh_vien' => 'VANG',
            'diem_xanh' => 0,
        ]);

        Voucher::create([
            'ma_voucher' => 'VC_THU_HOI',
            'ma_code' => 'THUHOI',
            'loai_uu_dai' => 'SO_TIEN',
            'gia_tri_giam' => 100000,
            'so_luot_phat_hanh' => 10,
            'so_luot_da_dung' => 0,
            'ngay_hieu_luc' => now(),
            'ngay_het_han' => now()->addDays(30),
            'trang_thai' => 'SAN_SANG'
        ]);

        $this->actingAs($this->kinhDoanhUser, 'api')
            ->postJson('/api/kinh-doanh/voucher/VC_THU_HOI/phat-hanh', [
                'maKhachHang' => 'KH_VIP_02'
            ])->assertStatus(201);

        $this->actingAs($this->kinhDoanhUser, 'api')
            ->getJson('/api/kinh-doanh/voucher/VC_THU_HOI/khach-hang-da-phan-bo')
            ->assertStatus(200)
            ->assertJsonPath('data.0.maKhachHang', 'KH_VIP_02');

        $this->actingAs($this->kinhDoanhUser, 'api')
            ->putJson('/api/kinh-doanh/voucher/VC_THU_HOI/khach-hang/KH_VIP_02/thu-hoi')
            ->assertStatus(200)
            ->assertJsonPath('data.trangThai', 'THU_HOI');
    }
}
