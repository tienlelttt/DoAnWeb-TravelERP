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
            "ma_tour_mau" => "TM_CK",
            "tieu_de" => "Tour Công Khai",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $this->tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_CK",
            "ma_tour_mau" => "TM_CK",
            "ngay_khoi_hanh" => Carbon::now()->addDays(5),
            "gia_hien_hanh" => 1500000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "MO_BAN"
        ]);

        DanhGiaKh::create([
            "ma_danh_gia_khach_hang" => "DG_01",
            "ma_tour_thuc_te" => "TTT_CK",
            "ma_khach_hang" => "KH_01",
            "so_sao" => 5,
            "nhan_xet" => "Tuyệt vời",
            "ngay_danh_gia" => Carbon::now()
        ]);

        $hdx = HanhDongXanh::create([
            "ma_hanh_dong_xanh" => "HDX_01",
            "ten_hanh_dong" => "Dọn rác",
            "diem_cong" => 10
        ]);

        $this->tourThucTe->hanhDongXanhs()->attach("HDX_01");

        $dichVu = DichVuThem::create([
            "ma_dich_vu_them" => "DV_01",
            "ten" => "Thuê lều",
            "don_gia" => 100000
        ]);

        $this->tourThucTe->dichVuThems()->attach("DV_01");
    }

    public function testLayDanhGiaTour()
    {
        $response = $this->getJson("/api/public/tour/TTT_CK/danh-gia");
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
