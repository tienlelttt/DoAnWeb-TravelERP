<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\TourMau;
use App\Models\TourThucTe;

class TourCongKhaiTest extends TestCase
{
    // Dùng DatabaseTransactions để sau khi test xong sẽ tự động Rollback, không làm rác Database thật
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Tạo dữ liệu giả lập cho Test
        $tm1 = new TourMau();
        $tm1->MaTourMau = 'TEST_TM1';
        $tm1->TieuDe = 'Tour Phú Quốc 3 Ngày';
        $tm1->ThoiLuong = 3;
        $tm1->GiaSan = 1500000;
        $tm1->save();

        $tm2 = new TourMau();
        $tm2->MaTourMau = 'TEST_TM2';
        $tm2->TieuDe = 'Tour Châu Âu 10 Ngày';
        $tm2->ThoiLuong = 10;
        $tm2->GiaSan = 35000000;
        $tm2->save();

        // Tour Thực Tế 1 (Phù hợp lọc giá rẻ, thời lượng ngắn)
        $ttt1 = new TourThucTe();
        $ttt1->MaTourThucTe = 'TEST_TTT1';
        $ttt1->MaTourMau = 'TEST_TM1';
        $ttt1->NgayKhoiHanh = now()->addDays(5);
        $ttt1->GiaHienHanh = 2000000;
        $ttt1->SoKhachToiDa = 20;
        $ttt1->SoKhachToiThieu = 5;
        $ttt1->ChoConLai = 20;
        $ttt1->TrangThai = 'MO_BAN';
        $ttt1->save();

        // Tour Thực Tế 2 (Giá cao, thời lượng dài)
        $ttt2 = new TourThucTe();
        $ttt2->MaTourThucTe = 'TEST_TTT2';
        $ttt2->MaTourMau = 'TEST_TM2';
        $ttt2->NgayKhoiHanh = now()->addDays(15);
        $ttt2->GiaHienHanh = 40000000;
        $ttt2->SoKhachToiDa = 30;
        $ttt2->SoKhachToiThieu = 10;
        $ttt2->ChoConLai = 30;
        $ttt2->TrangThai = 'MO_BAN';
        $ttt2->save();
        
        // Tour Thực Tế 3 (Tour đã hết chỗ -> Sẽ KHÔNG hiện ở Public API)
        $ttt3 = new TourThucTe();
        $ttt3->MaTourThucTe = 'TEST_TTT3';
        $ttt3->MaTourMau = 'TEST_TM1';
        $ttt3->NgayKhoiHanh = now()->addDays(7);
        $ttt3->GiaHienHanh = 2000000;
        $ttt3->SoKhachToiDa = 20;
        $ttt3->SoKhachToiThieu = 5;
        $ttt3->ChoConLai = 0; // Hết chỗ
        $ttt3->TrangThai = 'MO_BAN';
        $ttt3->save();
    }

    public function test_api_tra_ve_danh_sach_tour_thanh_cong_khong_co_tour_het_cho()
    {
        $response = $this->getJson('/api/public/tour');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status', 'success', 'message', 'data' => [
                'data' => [
                    '*' => ['maTourThucTe', 'ngayKhoiHanh', 'giaHienHanh', 'tieuDeTour', 'thoiLuong']
                ]
            ]
        ]);
        
        // Chắc chắn rẳng TEST_TTT3 (hết chỗ) không có trong kết quả
        $response->assertJsonMissing(['maTourThucTe' => 'TEST_TTT3']);
    }

    public function test_api_loc_tour_theo_gia_thanh_cong()
    {
        // Lọc tour có giá từ 1.000.000 đến 5.000.000 (Chỉ nên ra TEST_TTT1)
        $response = $this->getJson('/api/public/tour?giaTu=1000000&giaDen=5000000');

        $response->assertStatus(200);
        $responseData = $response->json('data.data');
        
        // Kiểm tra trong danh sách trả về phải có TEST_TTT1
        $this->assertTrue(collect($responseData)->contains('maTourThucTe', 'TEST_TTT1'));
        // Phải không có TEST_TTT2 (vì giá là 40 triệu > 5 triệu)
        $this->assertFalse(collect($responseData)->contains('maTourThucTe', 'TEST_TTT2'));
    }

    public function test_api_loc_tour_theo_thoi_luong_thanh_cong()
    {
        // Lọc tour có thời lượng >= 5 ngày (Chỉ nên ra TEST_TTT2)
        $response = $this->getJson('/api/public/tour?thoiLuongMin=5');

        $response->assertStatus(200);
        $responseData = $response->json('data.data');
        
        $this->assertTrue(collect($responseData)->contains('maTourThucTe', 'TEST_TTT2'));
        $this->assertFalse(collect($responseData)->contains('maTourThucTe', 'TEST_TTT1')); // Thời lượng 3 < 5
    }
}
