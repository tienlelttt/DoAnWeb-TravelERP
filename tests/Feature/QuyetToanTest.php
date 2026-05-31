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

        VaiTro::create(['MaVaiTro' => 'KETOAN', 'TenHienThi' => 'Kế Toán']);

        $this->keToanUser = TaiKhoan::create([
            'MaTaiKhoan' => 'TK_KETOAN',
            'TenDangNhap' => 'ketoan_test',
            'MatKhau' => Hash::make('password123'),
            'HoTen' => 'Ke Toan Test',
            'VaiTro' => 'KETOAN',
            'TrangThai' => 'HOAT_DONG'
        ]);

        NhanVien::create([
            'MaNhanVien' => 'NV_01',
            'MaTaiKhoan' => 'TK_KETOAN',
            'LoaiNhanVien' => 'KETOAN',
            'TrangThaiLamViec' => 'DANG_LAM_VIEC'
        ]);

        $tourMau = TourMau::create([
            'MaTourMau' => 'TM_01',
            'TieuDe' => 'Tour Test',
            'ThoiLuong' => 3,
            'GiaSan' => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            'MaTourThucTe' => 'TT_01',
            'MaTourMau' => 'TM_01',
            'NgayKhoiHanh' => now()->subDays(5),
            'GiaHienHanh' => 1000000,
            'SoKhachToiDa' => 10,
            'SoKhachToiThieu' => 5,
            'ChoConLai' => 10,
            'TrangThai' => 'KET_THUC'
        ]);

        DonDatTour::create([
            'MaDatTour' => 'DT_01',
            'MaTourThucTe' => 'TT_01',
            'MaKhachHang' => 'KH_01',
            'NgayDat' => now()->subDays(10),
            'TongTien' => 2000000,
            'TrangThai' => 'HOAN_THANH'
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

        $this->assertDatabaseHas('QUYETTOAN', [
            'MaTourThucTe' => 'TT_01',
            'TrangThai' => 'CHUA_QUYET_TOAN'
        ]);
    }
}
