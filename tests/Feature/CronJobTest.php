<?php

namespace Tests\Feature;

use App\Models\DonDatTour;
use App\Models\TourThucTe;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CronJobTest extends TestCase
{
    use RefreshDatabase;

    public function testCancelExpiredBookingsJob()
    {
        $tourMau = \App\Models\TourMau::create([
            'MaTourMau' => 'TM_01',
            'TieuDe' => 'Tour Test',
            'ThoiLuong' => 3,
            'GiaSan' => 1000000
        ]);

        $tour = TourThucTe::create([
            'MaTourThucTe' => 'TT_CRON',
            'MaTourMau' => 'TM_01',
            'NgayKhoiHanh' => now()->addDays(5),
            'GiaHienHanh' => 1000000,
            'SoKhachToiDa' => 10,
            'SoKhachToiThieu' => 5,
            'ChoConLai' => 5,
            'TrangThai' => 'DANG_NHAN_KHACH'
        ]);

        // Đơn quá hạn (25 tiếng trước)
        DonDatTour::create([
            'MaDatTour' => 'DT_EXPIRED',
            'MaTourThucTe' => 'TT_CRON',
            'MaKhachHang' => 'KH_1',
            'NgayDat' => Carbon::now()->subHours(25),
            'TongTien' => 1000000,
            'TrangThai' => 'CHO_THANH_TOAN'
        ]);

        // Đơn còn hạn (23 tiếng trước)
        DonDatTour::create([
            'MaDatTour' => 'DT_VALID',
            'MaTourThucTe' => 'TT_CRON',
            'MaKhachHang' => 'KH_2',
            'NgayDat' => Carbon::now()->subHours(23),
            'TongTien' => 1000000,
            'TrangThai' => 'CHO_THANH_TOAN'
        ]);

        // Chạy cron job
        Artisan::call('bookings:cancel-expired');

        // Đơn quá hạn phải bị hủy
        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DT_EXPIRED',
            'TrangThai' => 'DA_HUY'
        ]);

        // Đơn còn hạn phải giữ nguyên
        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DT_VALID',
            'TrangThai' => 'CHO_THANH_TOAN'
        ]);
    }

    public function testUpdateDynamicPricingJob()
    {
        $now = Carbon::now();
        
        $tourMau = \App\Models\TourMau::create([
            'MaTourMau' => 'TM_02',
            'TieuDe' => 'Tour Test',
            'ThoiLuong' => 3,
            'GiaSan' => 1000000
        ]);

        // Tour lấp đầy > 80%
        $tourHot = TourThucTe::create([
            'MaTourThucTe' => 'TT_HOT',
            'MaTourMau' => 'TM_02',
            'SoKhachToiDa' => 10,
            'SoKhachToiThieu' => 5,
            'ChoConLai' => 1, // Đã lấp 90%
            'NgayKhoiHanh' => $now->copy()->addDays(10),
            'GiaHienHanh' => 1000000,
            'TrangThai' => 'DANG_NHAN_KHACH'
        ]);

        // Tour ế (lấp < 30%) và sắp khởi hành (<= 7 ngày)
        $tourE = TourThucTe::create([
            'MaTourThucTe' => 'TT_E',
            'MaTourMau' => 'TM_02',
            'SoKhachToiDa' => 10,
            'SoKhachToiThieu' => 5,
            'ChoConLai' => 8, // Lấp 20%
            'NgayKhoiHanh' => $now->copy()->addDays(5),
            'GiaHienHanh' => 1000000,
            'TrangThai' => 'DANG_NHAN_KHACH'
        ]);

        Artisan::call('pricing:update-dynamic');

        // Tour Hot phải tăng giá 5% (1.050.000)
        $this->assertDatabaseHas('TOURTHUCTE', [
            'MaTourThucTe' => 'TT_HOT',
            'GiaHienHanh' => 1050000
        ]);

        // Tour Ế phải giảm giá 10% (900.000)
        $this->assertDatabaseHas('TOURTHUCTE', [
            'MaTourThucTe' => 'TT_E',
            'GiaHienHanh' => 900000
        ]);
    }
}
