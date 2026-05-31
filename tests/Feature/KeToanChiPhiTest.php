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

        VaiTro::create(["MaVaiTro" => "KETOAN", "TenHienThi" => "Kế toán"]);

        $this->keToanTK = TaiKhoan::create([
            "MaTaiKhoan" => "TK_KT_001",
            "TenDangNhap" => "ketoan1",
            "MatKhau" => bcrypt("password"),
            "HoTen" => "Kế Toán Test",
            "VaiTro" => "KETOAN",
            "TrangThai" => "HOAT_DONG"
        ]);

        $this->keToan = NhanVien::create([
            "MaNhanVien" => "NV_KT_001",
            "MaTaiKhoan" => "TK_KT_001",
            "LoaiNhanVien" => "KETOAN",
            "TrangThaiLamViec" => "DANG_LAM"
        ]);

        $this->tourMau = TourMau::create([
            "MaTourMau" => "TM_003",
            "TieuDe" => "Tour Test Ke Toan",
            "ThoiLuong" => 3,
            "GiaSan" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "MaTourThucTe" => "TTT_003",
            "MaTourMau" => "TM_003",
            "NgayKhoiHanh" => Carbon::now()->addDays(1),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "DANG_DIEN_RA"
        ]);

        $this->chiPhi = ChiPhiThucTe::create([
            "MaChiPhiThucTe" => "CP_001",
            "MaTourThucTe" => "TTT_003",
            "MaNhanVien" => "NV_002",
            "DanhMuc" => "An uong",
            "ThanhTien" => 5000000,
            "HoaDonAnh" => "/uploads/bill1.jpg",
            "TrangThaiDuyet" => "CHO_DUYET",
            "NgayKhai" => Carbon::now()
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

        $this->assertDatabaseHas("CHIPHITHUCTE", [
            "MaChiPhiThucTe" => "CP_001",
            "TrangThaiDuyet" => "DA_DUYET"
        ]);
    }

    public function test_ke_toan_tu_choi_chi_phi()
    {
        $token = JWTAuth::fromUser($this->keToanTK);

        $response = $this->putJson("/api/ke-toan/chi-phi/CP_001/tu-choi", [], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas("CHIPHITHUCTE", [
            "MaChiPhiThucTe" => "CP_001",
            "TrangThaiDuyet" => "TU_CHOI"
        ]);
    }

    public function test_ke_toan_yeu_cau_bo_sung_chi_phi()
    {
        $token = JWTAuth::fromUser($this->keToanTK);

        $response = $this->putJson("/api/ke-toan/chi-phi/CP_001/yeu-cau-bo-sung", [], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas("CHIPHITHUCTE", [
            "MaChiPhiThucTe" => "CP_001",
            "TrangThaiDuyet" => "YEU_CAU_BO_SUNG"
        ]);
    }
}
