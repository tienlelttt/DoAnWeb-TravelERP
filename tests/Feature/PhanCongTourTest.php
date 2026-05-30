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

        VaiTro::create(["MaVaiTro" => "DIEUHANH", "TenHienThi" => "Điều Hành"]);
        VaiTro::create(["MaVaiTro" => "HDV", "TenHienThi" => "Hướng Dẫn Viên"]);

        $this->dieuHanhTK = TaiKhoan::create([
            "MaTaiKhoan" => "TK_DH_001",
            "TenDangNhap" => "dieuhanh1",
            "MatKhau" => bcrypt("password"),
            "HoTen" => "Điều Hành",
            "VaiTro" => "DIEUHANH",
            "TrangThai" => "HOAT_DONG"
        ]);

        $this->hdvTK = TaiKhoan::create([
            "MaTaiKhoan" => "TK_HDV_001",
            "TenDangNhap" => "hdv1",
            "MatKhau" => bcrypt("password"),
            "HoTen" => "Nguyễn Văn HDV",
            "VaiTro" => "HDV",
            "TrangThai" => "HOAT_DONG"
        ]);

        $this->hdv = NhanVien::create([
            "MaNhanVien" => "NV_HDV_001",
            "MaTaiKhoan" => "TK_HDV_001",
            "LoaiNhanVien" => "HDV",
            "TrangThaiLamViec" => "DANG_LAM"
        ]);

        $this->tourMau = TourMau::create([
            "MaTourMau" => "TM_001",
            "TieuDe" => "Tour Test",
            "ThoiLuong" => 3,
            "GiaSan" => 1000000
        ]);
    }

    public function test_dieu_hanh_phan_cong_thanh_cong()
    {
        $tourThucTe = TourThucTe::create([
            "MaTourThucTe" => "TTT_001",
            "MaTourMau" => "TM_001",
            "NgayKhoiHanh" => Carbon::now()->addDays(10),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "CHO_KICH_HOAT"
        ]);

        $token = JWTAuth::fromUser($this->dieuHanhTK);

        $response = $this->postJson("/api/dieu-hanh/phan-cong-tour", [
            "maTourThucTe" => "TTT_001",
            "maNhanVien" => "NV_HDV_001"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Phân công hướng dẫn viên thành công");

        $this->assertDatabaseHas("PHANCONGTOUR", [
            "MaTourThucTe" => "TTT_001",
            "MaNhanVien" => "NV_HDV_001",
            "TrangThaiChapNhan" => "CHO_PHAN_HOI"
        ]);
    }

    public function test_phan_cong_that_bai_do_trung_lich_12_tieng()
    {
        $tour1 = TourThucTe::create([
            "MaTourThucTe" => "TTT_001",
            "MaTourMau" => "TM_001",
            "NgayKhoiHanh" => Carbon::now()->addDays(10),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "CHO_KICH_HOAT"
        ]);

        PhanCongTour::create([
            "MaPhanCongTour" => "PCT_001",
            "MaTourThucTe" => "TTT_001",
            "MaNhanVien" => "NV_HDV_001",
            "NgayPhanCong" => Carbon::now(),
            "TrangThaiChapNhan" => "DA_DONG_Y"
        ]);

        $tour2 = TourThucTe::create([
            "MaTourThucTe" => "TTT_002",
            "MaTourMau" => "TM_001",
            "NgayKhoiHanh" => Carbon::now()->addDays(13)->addHours(6),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "CHO_KICH_HOAT"
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
            "MaTourThucTe" => "TTT_001",
            "MaTourMau" => "TM_001",
            "NgayKhoiHanh" => Carbon::now()->addDays(10),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "CHO_KICH_HOAT"
        ]);

        $phanCong = PhanCongTour::create([
            "MaPhanCongTour" => "PCT_001",
            "MaTourThucTe" => "TTT_001",
            "MaNhanVien" => "NV_HDV_001",
            "NgayPhanCong" => Carbon::now(),
            "TrangThaiChapNhan" => "CHO_PHAN_HOI"
        ]);

        $token = JWTAuth::fromUser($this->hdvTK);

        $response = $this->postJson("/api/hdv/phan-cong/PCT_001/tra-loi", [
            "trangThaiTraLoi" => "DA_DONG_Y"
        ], ["Authorization" => "Bearer $token"]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Đã phản hồi yêu cầu phân công");

        $this->assertDatabaseHas("PHANCONGTOUR", [
            "MaPhanCongTour" => "PCT_001",
            "TrangThaiChapNhan" => "DA_DONG_Y"
        ]);

        $this->assertDatabaseHas("TOURTHUCTE", [
            "MaTourThucTe" => "TTT_001",
            "TrangThai" => "MO_BAN"
        ]);
    }
}
