<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\DanhGiaKh;
use App\Models\HanhDongXanh;
use App\Models\DichVuThem;
use Carbon\Carbon;

class TourCongKhaiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tourMau = TourMau::create([
            "MaTourMau" => "TM_CK",
            "TieuDe" => "Tour Công Khai",
            "ThoiLuong" => 3,
            "GiaSan" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "MaTourThucTe" => "TTT_CK",
            "MaTourMau" => "TM_CK",
            "NgayKhoiHanh" => Carbon::now()->addDays(5),
            "GiaHienHanh" => 1500000,
            "SoKhachToiDa" => 20,
            "SoKhachToiThieu" => 10,
            "ChoConLai" => 20,
            "TrangThai" => "MO_BAN"
        ]);

        DanhGiaKh::create([
            "MaDanhGiaKhachHang" => "DG_01",
            "MaTourThucTe" => "TTT_CK",
            "MaKhachHang" => "KH_01",
            "SoSao" => 5,
            "NhanXet" => "Tuyệt vời",
            "NgayDanhGia" => Carbon::now()
        ]);

        $hdx = HanhDongXanh::create([
            "MaHanhDongXanh" => "HDX_01",
            "TenHanhDong" => "Dọn rác",
            "DiemCong" => 10
        ]);

        $this->tourThucTe->hanhDongXanhs()->attach("HDX_01");

        $dichVu = DichVuThem::create([
            "MaDichVuThem" => "DV_01",
            "Ten" => "Thuê lều",
            "DonGia" => 100000
        ]);

        $this->tourThucTe->dichVuThems()->attach("DV_01");
    }

    public function testLayDanhGiaTour()
    {
        $response = $this->getJson("/api/public/tour/TTT_CK/danh-gia");
        $response->dump();

        $response->assertStatus(200)
                 ->assertJsonFragment(["nhanXet" => "Tuyệt vời"]);
    }

    public function testLayHanhDongXanhTour()
    {
        $response = $this->getJson("/api/public/tour/TTT_CK/hanh-dong-xanh");

        $response->assertStatus(200)
                 ->assertJsonFragment(["tenHanhDong" => "Dọn rác"]);
    }

    public function testLayDichVuThemTour()
    {
        $response = $this->getJson("/api/public/tour/TTT_CK/dich-vu-them");

        $response->assertStatus(200)
                 ->assertJsonFragment(["ten" => "Thuê lều"]);
    }
}
