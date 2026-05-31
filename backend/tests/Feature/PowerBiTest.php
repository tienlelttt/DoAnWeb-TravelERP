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

        VaiTro::create(['ma_vai_tro' => 'KETOAN', 'ten_hien_thi' => 'Kế Toán']);

        $this->keToanUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KETOAN',
            'ten_dang_nhap' => 'ketoan_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Ke Toan Test',
            'vai_tro' => 'KETOAN',
            'trang_thai' => 'HOAT_DONG'
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
        $this->assertDatabaseHas('nhat_ky_he_thongs', [
            'ma_tai_khoan' => 'TK_KETOAN',
            'doi_tuong' => 'XUAT_DU_LIEU_POWERBI',
            'hanh_dong' => 'POWER_BI_KET_NOI',
            'ghi_chu' => 'DOANH_THU'
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
