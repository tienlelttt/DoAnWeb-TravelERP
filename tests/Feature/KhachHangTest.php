<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\VaiTro;
use App\Models\TaiKhoan;
use App\Models\HoChieuSo;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\DonDatTour;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class KhachHangTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::create(["MaVaiTro" => "KHACHHANG", "TenHienThi" => "Khách hàng"]);

        $this->khachHangTK = TaiKhoan::create([
            "MaTaiKhoan" => "TK_KH_001",
            "TenDangNhap" => "khachhang1",
            "MatKhau" => bcrypt("password"),
            "HoTen" => "Khách Hàng Test",
            "VaiTro" => "KHACHHANG",
            "TrangThai" => "HOAT_DONG"
        ]);

        $this->hoChieuSo = HoChieuSo::create([
            "MaKhachHang" => "KH_001",
            "MaTaiKhoan" => "TK_KH_001",
            "HangThanhVien" => "THANH_VIEN",
            "DiemXanh" => 0
        ]);

        $this->tourMau = TourMau::create([
            "MaTourMau" => "TM_004",
            "TieuDe" => "Tour Test KH",
            "ThoiLuong" => 3,
            "GiaSan" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "MaTourThucTe" => "TTT_004",
            "MaTourMau" => "TM_004",
            "NgayKhoiHanh" => Carbon::now()->addDays(10),
            "GiaHienHanh" => 1200000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "MO_BAN"
        ]);

        $this->donDatTour = DonDatTour::create([
            "MaDatTour" => "DAT_001",
            "MaTourThucTe" => "TTT_004",
            "MaKhachHang" => "KH_001",
            "NgayDat" => Carbon::now(),
            "TrangThai" => "DA_THANH_TOAN",
            "TongTien" => 1200000
        ]);
    }

    public function test_khach_hang_lay_ho_so()
    {
        $token = JWTAuth::fromUser($this->khachHangTK);

        $response = $this->getJson("/api/khach-hang/ho-so", [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath("data.hoTen", "Khách Hàng Test")
                 ->assertJsonPath("data.hangThanhVien", "THANH_VIEN");
    }

    public function test_khach_hang_cap_nhat_ho_so()
    {
        $token = JWTAuth::fromUser($this->khachHangTK);

        $response = $this->putJson("/api/khach-hang/ho-so", [
            "hoTen" => "Tên Mới",
            "cccd" => "012345678912"
        ], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath("data.hoTen", "Tên Mới")
                 ->assertJsonPath("data.cccd", "012345678912");

        $this->assertDatabaseHas("TAIKHOAN", [
            "MaTaiKhoan" => "TK_KH_001",
            "HoTen" => "Tên Mới",
            "CCCD" => "012345678912"
        ]);
    }

    public function test_khach_hang_lay_lich_su_tour()
    {
        $token = JWTAuth::fromUser($this->khachHangTK);

        $response = $this->getJson("/api/khach-hang/lich-su-tour", [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath("data.data.0.maDatTour", "DAT_001");
    }

    public function test_khach_hang_yeu_cau_huy_tour()
    {
        $token = JWTAuth::fromUser($this->khachHangTK);

        $response = $this->postJson("/api/khach-hang/dat-tour/DAT_001/huy", [
            "lyDoHuy" => "Tôi bận việc gia đình"
        ], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath("message", "Gửi yêu cầu hủy tour thành công");

        $this->assertDatabaseHas("YEUCAUHOTRO", [
            "MaDatTour" => "DAT_001",
            "MaKhachHang" => "KH_001",
            "LoaiYeuCau" => "HUY_TOUR",
            "NoiDung" => "Tôi bận việc gia đình",
            "TrangThai" => "CHO_XU_LY"
        ]);
    }
}
