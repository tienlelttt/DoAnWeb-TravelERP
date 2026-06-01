<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\VaiTro;
use App\Models\NhanVien;
use App\Models\TourThucTe;
use App\Models\TourMau;
use App\Models\TaiKhoan;
use App\Models\PhanCongTour;
use App\Models\DonDatTour;
use App\Models\ChiTietDatTour;
use App\Models\HoChieuSo;
use App\Models\NhatKySuCo;
use App\Models\ChiPhiThucTe;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class HdvVanHanhTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(["ma_vai_tro" => "HDV", "ten_hien_thi" => "Hướng Dẫn Viên"]);

        $this->hdvTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_HDV_002",
            "ten_dang_nhap" => "hdv_vanhanh",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "HDV Test",
            "vai_tro" => "HDV",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->hdv = NhanVien::create([
            "ma_nhan_vien" => "NV_002",
            "ma_tai_khoan" => "TK_HDV_002",
            "loai_nhan_vien" => "HDV",
            "trang_thai_lam_viec" => "DANG_LAM"
        ]);

        $this->tourMau = TourMau::create([
            "ma_tour_mau" => "TM_002",
            "tieu_de" => "Tour Test",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_002",
            "ma_tour_mau" => "TM_002",
            "ngay_khoi_hanh" => Carbon::now()->addDays(1),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "DANG_DIEN_RA"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_002",
            "ma_tour_thuc_te" => "TTT_002",
            "ma_nhan_vien" => "NV_002",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);
    }

    public function test_hdv_co_the_diem_danh_khach()
    {
        $token = JWTAuth::fromUser($this->hdvTK);

        $response = $this->postJson("/api/huong-dan-vien/tour/TTT_002/diem-danh", [
            "maKhachHang" => "KH_001",
            "loaiKhach" => "KHACH_CHINH",
            "trangThai" => "DA_DIEM_DANH",
            "diaDiem" => "San bay"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Điểm danh thành công");

        $this->assertDatabaseHas("diem_danhs", [
            "ma_tour_thuc_te" => "TTT_002",
            "ma_khach_hang" => "KH_001",
            "trang_thai" => "DA_DIEM_DANH"
        ]);
    }

    public function test_hdv_co_the_bao_cao_su_co_sos()
    {
        $token = JWTAuth::fromUser($this->hdvTK);

        $response = $this->postJson("/api/huong-dan-vien/tour/TTT_002/su-co", [
            "moTa" => "Khách bị lạc",
            "mucDo" => "SOS",
            "loaiSuCo" => "KHACH_HANG"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Báo cáo sự cố thành công");

        $this->assertDatabaseHas("nhat_ky_su_cos", [
            "ma_tour_thuc_te" => "TTT_002",
            "muc_do" => "SOS",
            "mo_ta" => "Khách bị lạc"
        ]);
    }

    public function test_hdv_co_the_khai_bao_chi_phi()
    {
        $token = JWTAuth::fromUser($this->hdvTK);

        $response = $this->postJson("/api/huong-dan-vien/tour/TTT_002/chi-phi", [
            "danhMuc" => "An uong",
            "thanhTien" => 5000000,
            "hoaDonAnh" => "/uploads/bill1.jpg"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Khai báo chi phí thành công");

        $this->assertDatabaseHas("chi_phi_thuc_tes", [
            "ma_tour_thuc_te" => "TTT_002",
            "thanh_tien" => 5000000,
            "trang_thai_duyet" => "CHO_DUYET"
        ]);
    }

    public function test_hdv_list_su_co_va_chi_phi_co_phan_trang()
    {
        $token = JWTAuth::fromUser($this->hdvTK);

        NhatKySuCo::create([
            'ma_nhat_ky_su_co' => 'SC_PAGE_001',
            'ma_tour_thuc_te' => 'TTT_002',
            'ma_nhan_vien_bao_cao' => 'NV_002',
            'mo_ta' => 'Sự cố test 1',
            'muc_do' => 'THAP',
            'loai_su_co' => 'KHACH_HANG',
            'thoi_gian_bao_cao' => now()->subMinute(),
        ]);

        NhatKySuCo::create([
            'ma_nhat_ky_su_co' => 'SC_PAGE_002',
            'ma_tour_thuc_te' => 'TTT_002',
            'ma_nhan_vien_bao_cao' => 'NV_002',
            'mo_ta' => 'Sự cố test 2',
            'muc_do' => 'SOS',
            'loai_su_co' => 'KHACH_HANG',
            'thoi_gian_bao_cao' => now(),
        ]);

        ChiPhiThucTe::create([
            'ma_chi_phi_thuc_te' => 'CP_PAGE_001',
            'ma_tour_thuc_te' => 'TTT_002',
            'ma_nhan_vien' => 'NV_002',
            'danh_muc' => 'Ăn uống',
            'thanh_tien' => 100000,
            'trang_thai_duyet' => 'CHO_DUYET',
            'ngay_khai' => now()->subMinute(),
        ]);

        ChiPhiThucTe::create([
            'ma_chi_phi_thuc_te' => 'CP_PAGE_002',
            'ma_tour_thuc_te' => 'TTT_002',
            'ma_nhan_vien' => 'NV_002',
            'danh_muc' => 'Di chuyển',
            'thanh_tien' => 200000,
            'trang_thai_duyet' => 'CHO_DUYET',
            'ngay_khai' => now(),
        ]);

        $suCoResponse = $this->getJson('/api/huong-dan-vien/tour/TTT_002/su-co?size=1', [
            'Authorization' => "Bearer $token",
        ]);

        $suCoResponse->assertStatus(200)
            ->assertJsonPath('meta.pagination.perPage', 1)
            ->assertJsonPath('meta.pagination.total', 2)
            ->assertJsonCount(1, 'data');

        $chiPhiResponse = $this->getJson('/api/huong-dan-vien/tour/TTT_002/chi-phi?size=1', [
            'Authorization' => "Bearer $token",
        ]);

        $chiPhiResponse->assertStatus(200)
            ->assertJsonPath('meta.pagination.perPage', 1)
            ->assertJsonPath('meta.pagination.total', 2)
            ->assertJsonCount(1, 'data');
    }

    public function test_hdv_khong_duoc_xem_du_lieu_tour_khong_duoc_phan_cong()
    {
        $token = JWTAuth::fromUser($this->hdvTK);

        TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_KHONG_PHAN_CONG",
            "ma_tour_mau" => "TM_002",
            "ngay_khoi_hanh" => Carbon::now()->addDays(5),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "DANG_DIEN_RA"
        ]);

        $this->getJson('/api/huong-dan-vien/tour/TTT_KHONG_PHAN_CONG/su-co', [
            'Authorization' => "Bearer $token",
        ])->assertStatus(403);

        $this->getJson('/api/huong-dan-vien/tour/TTT_KHONG_PHAN_CONG/chi-phi', [
            'Authorization' => "Bearer $token",
        ])->assertStatus(403);
    }
}
