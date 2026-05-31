<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use App\Models\VaiTro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PowerBiTest extends TestCase
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
    }

    public function testKeToanCoTheLayDanhSachKhoDuLieu()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->getJson('/api/ke-toan/power-bi/kho-du-lieu');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['maKho', 'tenKho', 'moTa']
                     ]
                 ]);
    }

    public function testKeToanCoTheLayThongTinKetNoi()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->getJson('/api/ke-toan/power-bi/ket-noi?maKho=DOANH_THU');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'host', 'port', 'serviceName', 'username', 'password', 'jdbcUrl', 'hetHan', 'huongDan'
                     ]
                 ]);
                 
        // Kiểm tra audit log
        $this->assertDatabaseHas('NHATKYHETHONG', [
            'MaTaiKhoan' => 'TK_KETOAN',
            'DoiTuong' => 'XUAT_DU_LIEU_POWERBI',
            'HanhDong' => 'POWER_BI_KET_NOI',
            'GhiChu' => 'DOANH_THU'
        ]);
    }

    public function testKeToanCoTheXuatDuLieuCsv()
    {
        $payload = [
            'maKho' => 'TOUR',
            'dinhDang' => 'CSV'
        ];

        $response = $this->actingAs($this->keToanUser, 'api')
                         ->postJson('/api/ke-toan/power-bi/xuat-du-lieu', $payload);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        
        $content = $response->getContent();
        // Kiểm tra có chứa BOM UTF-8 không
        $this->assertTrue(strpos($content, "\xEF\xBB\xBF") === 0);
    }
}
