<?php

namespace Tests\Feature;

use App\Models\DonDatTour;
use App\Models\GiaoDich;
use App\Models\TaiKhoan;
use App\Models\TourThucTe;
use App\Models\VaiTro;
use App\Models\ChiTietDatTour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KeToanHoanTienTest extends TestCase
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

        $tourMau = \App\Models\TourMau::create([
            'MaTourMau' => 'TM_01',
            'TieuDe' => 'Tour Test',
            'ThoiLuong' => 3,
            'GiaSan' => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            'MaTourThucTe' => 'TT_01',
            'MaTourMau' => 'TM_01',
            'NgayKhoiHanh' => now()->addDays(5),
            'GiaHienHanh' => 1000000,
            'SoKhachToiDa' => 20,
            'SoKhachToiThieu' => 10,
            'ChoConLai' => 18, // Còn trống 18 chỗ, đã đặt 2 chỗ
            'TrangThai' => 'CHUA_KHOI_HANH'
        ]);

        $this->donDatTour = DonDatTour::create([
            'MaDatTour' => 'DT_01',
            'MaTourThucTe' => 'TT_01',
            'MaKhachHang' => 'KH_01',
            'NgayDat' => now(),
            'TongTien' => 2000000,
            'TrangThai' => 'CHO_HUY'
        ]);

        // Tạo 2 khách hàng trong ChiTietDatTour
        ChiTietDatTour::create(['MaChiTietDat' => 'CT_01', 'MaDatTour' => 'DT_01', 'LoaiKhach' => 'NGUOI_LON', 'GiaTaiThoiDiemDat' => 1000000]);
        ChiTietDatTour::create(['MaChiTietDat' => 'CT_02', 'MaDatTour' => 'DT_01', 'LoaiKhach' => 'NGUOI_LON', 'GiaTaiThoiDiemDat' => 1000000]);

        $this->giaoDich = GiaoDich::create([
            'MaGiaoDich' => 'GD_01',
            'MaDatTour' => 'DT_01',
            'LoaiGiaoDich' => 'HOAN_TIEN',
            'PhuongThuc' => 'CHUYEN_KHOAN',
            'SoTien' => 2000000,
            'NgayThanhToan' => now(),
            'TrangThai' => 'CHO_THANH_TOAN'
        ]);
    }

    public function testKeToanCoTheLayDanhSachChoHoanTien()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->getJson('/api/ke-toan/giao-dich-hoan');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'maGiaoDich' => 'GD_01',
                     'loaiGiaoDich' => 'HOAN_TIEN'
                 ]);
    }

    public function testKeToanCoTheXacNhanHoanTienVaHoanTraChoTrong()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->putJson('/api/ke-toan/giao-dich-hoan/GD_01/xac-nhan');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'trangThai' => 'DA_HOAN_TIEN' // Theo logic code
                 ]);

        // Kiểm tra db: giao dịch thành công
        $this->assertDatabaseHas('GIAODICH', [
            'MaGiaoDich' => 'GD_01',
            'TrangThai' => 'DA_HOAN_TIEN'
        ]);

        // Kiểm tra db: đơn hàng đã hủy
        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DT_01',
            'TrangThai' => 'DA_HUY'
        ]);

        // Kiểm tra chỗ còn lại: 18 + 2 = 20
        $this->assertDatabaseHas('TOURTHUCTE', [
            'MaTourThucTe' => 'TT_01',
            'ChoConLai' => 20
        ]);
    }

    public function testKeToanCoTheTuChoiHoanTien()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->putJson('/api/ke-toan/giao-dich-hoan/GD_01/tu-choi');

        $response->assertStatus(200);

        $this->assertDatabaseHas('GIAODICH', [
            'MaGiaoDich' => 'GD_01',
            'TrangThai' => 'THAT_BAI'
        ]);

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DT_01',
            'TrangThai' => 'TU_CHOI_HOAN_TIEN' // Tranh chấp
        ]);
    }
}
