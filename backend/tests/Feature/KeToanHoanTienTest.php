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

        VaiTro::firstOrCreate(['ma_vai_tro' => 'KETOAN'], ['ten_hien_thi' => 'Kế Toán']);

        $this->keToanUser = TaiKhoan::create([
            'ma_tai_khoan' => 'TK_KETOAN',
            'ten_dang_nhap' => 'ketoan_test',
            'mat_khau' => Hash::make('password123'),
            'ho_ten' => 'Ke Toan Test',
            'vai_tro' => 'KETOAN',
            'trang_thai' => 'HOAT_DONG'
        ]);

        $tourMau = \App\Models\TourMau::create([
            'ma_tour_mau' => 'TM_01',
            'tieu_de' => 'Tour Test',
            'thoi_luong' => 3,
            'gia_san' => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            'ma_tour_thuc_te' => 'TT_01',
            'ma_tour_mau' => 'TM_01',
            'ngay_khoi_hanh' => now()->addDays(5),
            'gia_hien_hanh' => 1000000,
            'so_khach_toi_da' => 20,
            'so_khach_toi_thieu' => 10,
            'cho_con_lai' => 18, // Còn trống 18 chỗ, đã đặt 2 chỗ
            'trang_thai' => 'CHUA_KHOI_HANH'
        ]);

        $this->donDatTour = DonDatTour::create([
            'ma_dat_tour' => 'DT_01',
            'ma_tour_thuc_te' => 'TT_01',
            'ma_khach_hang' => 'KH_01',
            'ngay_dat' => now(),
            'tong_tien' => 2000000,
            'trang_thai' => 'CHO_HUY'
        ]);

        // Tạo 2 khách hàng trong ChiTietDatTour
        ChiTietDatTour::create(['ma_chi_tiet_dat' => 'CT_01', 'ma_dat_tour' => 'DT_01', 'loai_khach' => 'NGUOI_LON', 'gia_tai_thoi_diem_dat' => 1000000]);
        ChiTietDatTour::create(['ma_chi_tiet_dat' => 'CT_02', 'ma_dat_tour' => 'DT_01', 'loai_khach' => 'NGUOI_LON', 'gia_tai_thoi_diem_dat' => 1000000]);

        $this->giaoDich = GiaoDich::create([
            'ma_giao_dich' => 'GD_01',
            'ma_dat_tour' => 'DT_01',
            'loai_giao_dich' => 'HOAN_TIEN',
            'phuong_thuc' => 'CHUYEN_KHOAN',
            'so_tien' => 2000000,
            'ngay_thanh_toan' => now(),
            'trang_thai' => 'CHO_THANH_TOAN'
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
        $this->assertDatabaseHas('giao_diches', [
            'ma_giao_dich' => 'GD_01',
            'trang_thai' => 'DA_HOAN_TIEN'
        ]);

        // Kiểm tra db: đơn hàng đã hủy
        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DT_01',
            'trang_thai' => 'DA_HUY'
        ]);

        // Kiểm tra chỗ còn lại: 18 + 2 = 20
        $this->assertDatabaseHas('tour_thuc_tes', [
            'ma_tour_thuc_te' => 'TT_01',
            'cho_con_lai' => 20
        ]);
    }

    public function testKeToanCoTheTuChoiHoanTien()
    {
        $response = $this->actingAs($this->keToanUser, 'api')
                         ->putJson('/api/ke-toan/giao-dich-hoan/GD_01/tu-choi');

        $response->assertStatus(200);

        $this->assertDatabaseHas('giao_diches', [
            'ma_giao_dich' => 'GD_01',
            'trang_thai' => 'THAT_BAI'
        ]);

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DT_01',
            'trang_thai' => 'TU_CHOI_HOAN_TIEN' // Tranh chấp
        ]);
    }
}
