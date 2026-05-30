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
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class HdvVanHanhTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(["MaVaiTro" => "HDV", "TenHienThi" => "Hướng Dẫn Viên"]);

        $this->hdvTK = TaiKhoan::create([
            "MaTaiKhoan" => "TK_HDV_002",
            "TenDangNhap" => "hdv_vanhanh",
            "MatKhau" => bcrypt("password"),
            "HoTen" => "HDV Test",
            "VaiTro" => "HDV",
            "TrangThai" => "HOAT_DONG"
        ]);

        $this->hdv = NhanVien::create([
            "MaNhanVien" => "NV_002",
            "MaTaiKhoan" => "TK_HDV_002",
            "LoaiNhanVien" => "HDV",
            "TrangThaiLamViec" => "DANG_LAM"
        ]);

        $this->tourMau = TourMau::create([
            "MaTourMau" => "TM_002",
            "TieuDe" => "Tour Test",
            "ThoiLuong" => 3,
            "GiaSan" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "MaTourThucTe" => "TTT_002",
            "MaTourMau" => "TM_002",
            "NgayKhoiHanh" => Carbon::now()->addDays(1),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "DANG_DIEN_RA"
        ]);

        PhanCongTour::create([
            "MaPhanCongTour" => "PCT_002",
            "MaTourThucTe" => "TTT_002",
            "MaNhanVien" => "NV_002",
            "NgayPhanCong" => Carbon::now(),
            "TrangThaiChapNhan" => "DA_DONG_Y"
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

        $this->assertDatabaseHas("DIEMDANH", [
            "MaTourThucTe" => "TTT_002",
            "MaKhachHang" => "KH_001",
            "TrangThai" => "DA_DIEM_DANH"
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

        $this->assertDatabaseHas("NHATKYSUCO", [
            "MaTourThucTe" => "TTT_002",
            "MucDo" => "SOS",
            "MoTa" => "Khách bị lạc"
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

        $this->assertDatabaseHas("CHIPHITHUCTE", [
            "MaTourThucTe" => "TTT_002",
            "ThanhTien" => 5000000,
            "TrangThaiDuyet" => "CHO_DUYET"
        ]);
    }
}
