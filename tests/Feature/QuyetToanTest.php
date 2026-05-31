<?php

namespace Tests\Feature;

use App\Models\DonDatTour;
use App\Models\QuyetToan;
use App\Models\TaiKhoan;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\VaiTro;
use App\Models\NhanVien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class QuyetToanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(['ma_vai_tro' => 'KETOAN', 'ten_hien_thi' => 'Kế Toán']);

        $this->keToanUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KETOAN',
            'ten_dang_nhap' => 'ketoan_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Ke Toan Test',
            'vai_tro' => 'KETOAN',
            'trang_thai' => 'HOAT_DONG'
        ]);

        NhanVien::create([
            'ma_nhan_vien' => 'NV_01',
            'ma_tai_khoan' => 'TK_KETOAN',
            'loai_nhan_vien' => 'KETOAN',
            'trang_thai_lam_viec' => 'DANG_LAM_VIEC'
        ]);

        $tourMau = TourMau::create([
            'ma_tour_mau' => 'TM_01',
            'tieu_de' => 'Tour Test',
            'thoi_luong' => 3,
            'gia_san' => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            'ma_tour_thuc_te' => 'TT_01',
            'ma_tour_mau' => 'TM_01',
            'ngay_khoi_hanh' => now()->subDays(5),
            'gia_hien_hanh' => 1000000,
            'so_khach_toi_da' => 10,
            'so_khach_toi_thieu' => 5,
            'cho_con_lai' => 10,
            'trang_thai' => 'KET_THUC'
        ]);

        DonDatTour::create([
            'ma_dat_tour' => 'DT_01',
            'ma_tour_thuc_te' => 'TT_01',
            'ma_khach_hang' => 'KH_01',
            'ngay_dat' => now()->subDays(10),
            'tong_tien' => 2000000,
            'trang_thai' => 'HOAN_THANH'
        ]);
    }

    public function testKeToanCoTheLayDanhSachTourCanQuyetToan()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->getJson('/api/ke-toan/tour-can-quyet-toan');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'content' => [
                             '*' => ['maTour', 'tenTour', 'tongDoanhThu']
                         ]
                     ]
                 ]);
    }

    public function testKeToanCoTheTinhToanSoBoLoiNhuan()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->getJson('/api/ke-toan/tinh-toan/TT_01');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'maTour' => 'TT_01',
                     'tongDoanhThu' => 2000000,
                     'trangThai' => 'XEM_TRUOC'
                 ]);
    }

    public function testKeToanCoTheTaoQuyetToanNhap()
    {
        $payload = [
            'giaCamKet' => 1500000,
            'ghiChu' => 'Test ghi chu'
        ];

        $response = $this->actingAs($this->keToanUser, 'api')
                         ->postJson('/api/ke-toan/quyet-toan/TT_01', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'maTour' => 'TT_01',
                     'trangThai' => 'CHUA_QUYET_TOAN',
                     'giaCamKet' => 1500000
                 ]);

        $this->assertDatabaseHas('quyet_toans', [
            'ma_tour_thuc_te' => 'TT_01',
            'trang_thai' => 'CHUA_QUYET_TOAN'
        ]);
    }
}
