<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\VaiTro;
use App\Models\NhanVien;
use App\Models\TourThucTe;
use App\Models\TourMau;
use App\Models\TaiKhoan;
use App\Models\PhanCongTour;
use App\Models\YeuCauHoTro;
use App\Models\QuyetToan;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class HdvCompatTest extends TestCase
{
    use RefreshDatabase;

    private TaiKhoan $hdvTK;
    private NhanVien $hdv;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(["ma_vai_tro" => "HDV", "ten_hien_thi" => "Hướng Dẫn Viên"]);
        VaiTro::create(["ma_vai_tro" => "KHACHHANG", "ten_hien_thi" => "Khách Hàng"]);

        $this->hdvTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_HDV_COMPAT",
            "ten_dang_nhap" => "hdv_compat",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "HDV Compat",
            "vai_tro" => "HDV",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->hdv = NhanVien::create([
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ma_tai_khoan" => "TK_HDV_COMPAT",
            "loai_nhan_vien" => "HDV",
            "trang_thai_lam_viec" => "DANG_LAM"
        ]);

        $this->token = JWTAuth::fromUser($this->hdvTK);
    }

    public function test_hdv_can_view_profile_and_skills()
    {
        $response1 = $this->getJson("/api/huong-dan-vien/ho-so", ["Authorization" => "Bearer $this->token"]);
        $response1->assertStatus(200);

        $response2 = $this->getJson("/api/huong-dan-vien/nang-luc", ["Authorization" => "Bearer $this->token"]);
        $response2->assertStatus(200);
    }

    public function test_hdv_can_view_assigned_tours()
    {
        $tourMau = TourMau::create([
            "ma_tour_mau" => "TM_COMPAT",
            "tieu_de" => "Tour Compat Title",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_tour_mau" => "TM_COMPAT",
            "ngay_khoi_hanh" => Carbon::now()->addDays(2)->toDateString(),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "MO_BAN"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_COMPAT",
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        $response = $this->getJson("/api/huong-dan-vien/tour-cua-toi", ["Authorization" => "Bearer $this->token"]);
        $response->assertStatus(200)
                 ->assertJsonFragment(["maTourThucTe" => "TTT_COMPAT", "maPhanCong" => "PCT_COMPAT", "tenTour" => "Tour Compat Title"]);
    }

    public function test_hdv_can_accept_and_reject_assignment()
    {
        $tourMau = TourMau::create([
            "ma_tour_mau" => "TM_COMPAT",
            "tieu_de" => "Tour Compat Title",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_tour_mau" => "TM_COMPAT",
            "ngay_khoi_hanh" => Carbon::now()->addDays(2)->toDateString(),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_COMPAT",
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        // Accept
        $response1 = $this->postJson("/api/huong-dan-vien/phan-cong/PCT_COMPAT/dong-y", [], ["Authorization" => "Bearer $this->token"]);
        $response1->assertStatus(200);
        $this->assertDatabaseHas("phan_cong_tours", [
            "ma_phan_cong_tour" => "PCT_COMPAT",
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);
    }
}
