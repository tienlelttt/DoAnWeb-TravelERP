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

        VaiTro::create(["ma_vai_tro" => "KHACHHANG", "ten_hien_thi" => "Khách hàng"]);

        $this->khachHangTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_KH_001",
            "ten_dang_nhap" => "khachhang1",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "Khách Hàng Test",
            "vai_tro" => "KHACHHANG",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->hoChieuSo = HoChieuSo::create([
            "ma_khach_hang" => "KH_001",
            "ma_tai_khoan" => "TK_KH_001",
            "hang_thanh_vien" => "THANH_VIEN",
            "diem_xanh" => 0
        ]);

        $this->tourMau = TourMau::create([
            "ma_tour_mau" => "TM_004",
            "tieu_de" => "Tour Test KH",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_004",
            "ma_tour_mau" => "TM_004",
            "ngay_khoi_hanh" => Carbon::now()->addDays(10),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "MO_BAN"
        ]);

        $this->donDatTour = DonDatTour::create([
            "ma_dat_tour" => "DAT_001",
            "ma_tour_thuc_te" => "TTT_004",
            "ma_khach_hang" => "KH_001",
            "ngay_dat" => Carbon::now(),
            "trang_thai" => "DA_THANH_TOAN",
            "tong_tien" => 1200000
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

        $this->assertDatabaseHas("tai_khoans", [
            "ma_tai_khoan" => "TK_KH_001",
            "ho_ten" => "Tên Mới",
            "cccd" => "012345678912"
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

        $this->assertDatabaseHas("yeu_cau_ho_tros", [
            "ma_dat_tour" => "DAT_001",
            "ma_khach_hang" => "KH_001",
            "loai_yeu_cau" => "HUY_TOUR",
            "noi_dung" => "Tôi bận việc gia đình",
            "trang_thai" => "CHO_XU_LY"
        ]);
    }
}
