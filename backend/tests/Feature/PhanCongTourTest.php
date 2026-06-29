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
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class PhanCongTourTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::firstOrCreate(['ma_vai_tro' => "DIEUHANH"], ['ten_hien_thi' => "Điều Hành"]);
        VaiTro::firstOrCreate(['ma_vai_tro' => "HDV"], ['ten_hien_thi' => "Hướng Dẫn Viên"]);

        $this->dieuHanhTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_DH_001",
            "ten_dang_nhap" => "dieuhanh1",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "Điều Hành",
            "vai_tro" => "DIEUHANH",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->hdvTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_HDV_001",
            "ten_dang_nhap" => "hdv1",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "Nguyễn Văn HDV",
            "vai_tro" => "HDV",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->hdv = NhanVien::create([
            "ma_nhan_vien" => "NV_HDV_001",
            "ma_tai_khoan" => "TK_HDV_001",
            "loai_nhan_vien" => "HDV",
            "trang_thai_lam_viec" => "DANG_LAM"
        ]);

        $this->tourMau = TourMau::create([
            "ma_tour_mau" => "TM_001",
            "tieu_de" => "Tour Test",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);
    }

    public function test_dieu_hanh_phan_cong_thanh_cong()
    {
        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_001",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        $token = JWTAuth::fromUser($this->dieuHanhTK);

        $response = $this->postJson("/api/dieu-hanh/phan-cong-tour", [
            "maTourThucTe" => "TTT_001",
            "maNhanVien" => "NV_HDV_001"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Phân công hướng dẫn viên thành công");

        $this->assertDatabaseHas("phan_cong_tours", [
            "ma_tour_thuc_te" => "TTT_001",
            "ma_nhan_vien" => "NV_HDV_001",
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);
    }

    public function test_hdv_khong_duoc_phan_cong_tour_thay_dieu_hanh()
    {
        TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_RBAC_DH",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        $token = JWTAuth::fromUser($this->hdvTK);

        $this->postJson("/api/dieu-hanh/phan-cong-tour", [
            "maTourThucTe" => "TTT_RBAC_DH",
            "maNhanVien" => "NV_HDV_001"
        ], ["Authorization" => "Bearer $token"])->assertStatus(403);

        $this->assertDatabaseMissing("phan_cong_tours", [
            "ma_tour_thuc_te" => "TTT_RBAC_DH",
            "ma_nhan_vien" => "NV_HDV_001"
        ]);
    }

    public function test_hdv_khong_duoc_cap_nhat_nang_luc_nhan_vien()
    {
        $token = JWTAuth::fromUser($this->hdvTK);

        $this->putJson("/api/dieu-hanh/nhan-vien/NV_HDV_001/nang-luc", [
            "ngonNgu" => "Tiếng Anh",
            "chungChi" => "HDV Quốc tế",
            "chuyenMon" => "Leo núi"
        ], ["Authorization" => "Bearer $token"])->assertStatus(403);

        $this->assertDatabaseMissing("nang_luc_nhan_viens", [
            "ma_nhan_vien" => "NV_HDV_001",
            "ngon_ngu" => "Tiếng Anh"
        ]);
    }

    public function test_dieu_hanh_co_the_huy_phan_cong()
    {
        TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_HUY_PC",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_HUY_PC",
            "ma_tour_thuc_te" => "TTT_HUY_PC",
            "ma_nhan_vien" => "NV_HDV_001",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        $token = JWTAuth::fromUser($this->dieuHanhTK);

        $this->deleteJson("/api/dieu-hanh/phan-cong/PCT_HUY_PC", [], [
            "Authorization" => "Bearer $token"
        ])->assertStatus(200)
          ->assertJsonPath("data", null);

        $this->assertDatabaseMissing("phan_cong_tours", [
            "ma_phan_cong_tour" => "PCT_HUY_PC"
        ]);
    }

    public function test_phan_cong_that_bai_do_trung_lich_12_tieng()
    {
        $tour1 = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_001",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_001",
            "ma_tour_thuc_te" => "TTT_001",
            "ma_nhan_vien" => "NV_HDV_001",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);

        $tour2 = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_002",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(13)->addHours(6),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        $token = JWTAuth::fromUser($this->dieuHanhTK);

        $response = $this->postJson("/api/dieu-hanh/phan-cong-tour", [
            "maTourThucTe" => "TTT_002",
            "maNhanVien" => "NV_HDV_001"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(400)
                 ->assertJsonPath("message", "Hướng dẫn viên bị trùng lịch hoặc khoảng cách nghỉ ngơi giữa 2 tour ít hơn 12 tiếng. (Đang cấn lịch với tour TTT_001)");
    }

    public function test_hdv_dong_y_tu_dong_mo_ban_tour()
    {
        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_001",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        $phanCong = PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_001",
            "ma_tour_thuc_te" => "TTT_001",
            "ma_nhan_vien" => "NV_HDV_001",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        $token = JWTAuth::fromUser($this->hdvTK);

        $response = $this->postJson("/api/hdv/phan-cong/PCT_001/tra-loi", [
            "trangThaiTraLoi" => "DA_DONG_Y"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Đã phản hồi yêu cầu phân công");

        $this->assertDatabaseHas("phan_cong_tours", [
            "ma_phan_cong_tour" => "PCT_001",
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);

        $this->assertDatabaseHas("tour_thuc_tes", [
            "ma_tour_thuc_te" => "TTT_001",
            "trang_thai" => "CHO_KICH_HOAT"
        ]);
    }

    public function test_dieu_hanh_lay_nang_luc_nhan_vien()
    {
        $token = JWTAuth::fromUser($this->dieuHanhTK);

        // 1. Lấy năng lực khi chưa có -> trả về null
        $response = $this->getJson("/api/dieu-hanh/nhan-vien/NV_HDV_001/nang-luc", ["Authorization" => "Bearer $token"]);
        $response->assertStatus(200)
                 ->assertJsonPath("data", null);

        // 2. Cập nhật năng lực
        $responseUpdate = $this->putJson("/api/dieu-hanh/nhan-vien/NV_HDV_001/nang-luc", [
            "ngonNgu" => "Tiếng Anh, Tiếng Pháp",
            "chungChi" => "HDV Quốc Tế",
            "chuyenMon" => "Leo núi"
        ], ["Authorization" => "Bearer $token"]);

        $responseUpdate->assertStatus(200)
                       ->assertJsonPath("data.ngonNgu", "Tiếng Anh, Tiếng Pháp");

        // 3. Lấy lại năng lực -> trả về data vừa tạo
        $responseGet = $this->getJson("/api/dieu-hanh/nhan-vien/NV_HDV_001/nang-luc", ["Authorization" => "Bearer $token"]);
        $responseGet->assertStatus(200)
                    ->assertJsonPath("data.ngonNgu", "Tiếng Anh, Tiếng Pháp")
                    ->assertJsonPath("data.chungChi", "HDV Quốc Tế")
                    ->assertJsonPath("data.chuyenMon", "Leo núi");
    }

    public function test_dieu_hanh_lay_lich_cong_tac_nhan_vien()
    {
        $token = JWTAuth::fromUser($this->dieuHanhTK);

        // Tạo một phân công
        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_001",
            "ma_tour_mau" => "TM_001",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_001",
            "ma_tour_thuc_te" => "TTT_001",
            "ma_nhan_vien" => "NV_HDV_001",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        $response = $this->getJson("/api/dieu-hanh/nhan-vien/NV_HDV_001/lich-cong-tac", ["Authorization" => "Bearer $token"]);
        $response->assertStatus(200)
                 ->assertJsonCount(1, "data")
                 ->assertJsonPath("data.0.maPhanCong", "PCT_001");
    }
}
