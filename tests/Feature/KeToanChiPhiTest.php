<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\VaiTro;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use App\Models\TourThucTe;
use App\Models\TourMau;
use App\Models\ChiPhiThucTe;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class KeToanChiPhiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(["ma_vai_tro" => "KETOAN", "ten_hien_thi" => "Kế toán"]);

        $this->keToanTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_KT_001",
            "ten_dang_nhap" => "ketoan1",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "Kế Toán Test",
            "vai_tro" => "KETOAN",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->keToan = NhanVien::create([
            "ma_nhan_vien" => "NV_KT_001",
            "ma_tai_khoan" => "TK_KT_001",
            "loai_nhan_vien" => "KETOAN",
            "trang_thai_lam_viec" => "DANG_LAM"
        ]);

        $this->tourMau = TourMau::create([
            "ma_tour_mau" => "TM_003",
            "tieu_de" => "Tour Test Ke Toan",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_003",
            "ma_tour_mau" => "TM_003",
            "ngay_khoi_hanh" => Carbon::now()->addDays(1),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "DANG_DIEN_RA"
        ]);

        $this->chiPhi = ChiPhiThucTe::create([
            "ma_chi_phi_thuc_te" => "CP_001",
            "ma_tour_thuc_te" => "TTT_003",
            "ma_nhan_vien" => "NV_002",
            "danh_muc" => "An uong",
            "thanh_tien" => 5000000,
            "hoa_don_anh" => "/uploads/bill1.jpg",
            "trang_thai_duyet" => "CHO_DUYET",
            "ngay_khai" => Carbon::now()
        ]);
    }

    public function test_ke_toan_lay_danh_sach_chi_phi()
    {
        $token = JWTAuth::fromUser($this->keToanTK);

        $response = $this->getJson("/api/ke-toan/chi-phi?trangThaiDuyet=CHO_DUYET", [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath("data.data.0.maChiPhiThucTe", "CP_001");
    }

    public function test_ke_toan_duyet_chi_phi()
    {
        $token = JWTAuth::fromUser($this->keToanTK);

        $response = $this->putJson("/api/ke-toan/chi-phi/CP_001/duyet", [], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Đã duyệt khoản chi phí");

        $this->assertDatabaseHas("chi_phi_thuc_tes", [
            "ma_chi_phi_thuc_te" => "CP_001",
            "trang_thai_duyet" => "DA_DUYET"
        ]);
    }

    public function test_ke_toan_tu_choi_chi_phi()
    {
        $token = JWTAuth::fromUser($this->keToanTK);

        $response = $this->putJson("/api/ke-toan/chi-phi/CP_001/tu-choi", [], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas("chi_phi_thuc_tes", [
            "ma_chi_phi_thuc_te" => "CP_001",
            "trang_thai_duyet" => "TU_CHOI"
        ]);
    }

    public function test_ke_toan_yeu_cau_bo_sung_chi_phi()
    {
        $token = JWTAuth::fromUser($this->keToanTK);

        $response = $this->putJson("/api/ke-toan/chi-phi/CP_001/yeu-cau-bo-sung", [], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas("chi_phi_thuc_tes", [
            "ma_chi_phi_thuc_te" => "CP_001",
            "trang_thai_duyet" => "YEU_CAU_BO_SUNG"
        ]);
    }
}
