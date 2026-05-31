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
            'ma_tour_mau' => 'TM_01',
            'tieu_de' => 'Tour Test',
            'thoi_luong' => 3,
            'gia_san' => 1000000
        ]);

        $tour = TourThucTe::create([
            'ma_tour_thuc_te' => 'TT_CRON',
            'ma_tour_mau' => 'TM_01',
            'ngay_khoi_hanh' => now()->addDays(5),
            'gia_hien_hanh' => 1000000,
            'so_khach_toi_da' => 10,
            'so_khach_toi_thieu' => 5,
            'cho_con_lai' => 5,
            'trang_thai' => 'DANG_NHAN_KHACH'
        ]);

        // Đơn quá hạn (25 tiếng trước)
        DonDatTour::create([
            'ma_dat_tour' => 'DT_EXPIRED',
            'ma_tour_thuc_te' => 'TT_CRON',
            'ma_khach_hang' => 'KH_1',
            'ngay_dat' => Carbon::now()->subHours(25),
            'tong_tien' => 1000000,
            'trang_thai' => 'CHO_THANH_TOAN'
        ]);

        // Đơn còn hạn (23 tiếng trước)
        DonDatTour::create([
            'ma_dat_tour' => 'DT_VALID',
            'ma_tour_thuc_te' => 'TT_CRON',
            'ma_khach_hang' => 'KH_2',
            'ngay_dat' => Carbon::now()->subHours(23),
            'tong_tien' => 1000000,
            'trang_thai' => 'CHO_THANH_TOAN'
        ]);

        // Chạy cron job
        Artisan::call('bookings:cancel-expired');

        // Đơn quá hạn phải bị hủy
        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DT_EXPIRED',
            'trang_thai' => 'DA_HUY'
        ]);

        // Đơn còn hạn phải giữ nguyên
        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DT_VALID',
            'trang_thai' => 'CHO_THANH_TOAN'
        ]);
    }

    public function testUpdateDynamicPricingJob()
    {
        $now = Carbon::now();
        
        $tourMau = \App\Models\TourMau::create([
            'ma_tour_mau' => 'TM_02',
            'tieu_de' => 'Tour Test',
            'thoi_luong' => 3,
            'gia_san' => 1000000
        ]);

        // Tour lấp đầy > 80%
        $tourHot = TourThucTe::create([
            'ma_tour_thuc_te' => 'TT_HOT',
            'ma_tour_mau' => 'TM_02',
            'so_khach_toi_da' => 10,
            'so_khach_toi_thieu' => 5,
            'cho_con_lai' => 1, // Đã lấp 90%
            'ngay_khoi_hanh' => $now->copy()->addDays(10),
            'gia_hien_hanh' => 1000000,
            'trang_thai' => 'DANG_NHAN_KHACH'
        ]);

        // Tour ế (lấp < 30%) và sắp khởi hành (<= 7 ngày)
        $tourE = TourThucTe::create([
            'ma_tour_thuc_te' => 'TT_E',
            'ma_tour_mau' => 'TM_02',
            'so_khach_toi_da' => 10,
            'so_khach_toi_thieu' => 5,
            'cho_con_lai' => 8, // Lấp 20%
            'ngay_khoi_hanh' => $now->copy()->addDays(5),
            'gia_hien_hanh' => 1000000,
            'trang_thai' => 'DANG_NHAN_KHACH'
        ]);

        Artisan::call('pricing:update-dynamic');

        // Tour Hot phải tăng giá 5% (1.050.000)
        $this->assertDatabaseHas('tour_thuc_tes', [
            'ma_tour_thuc_te' => 'TT_HOT',
            'gia_hien_hanh' => 1050000
        ]);

        // Tour Ế phải giảm giá 10% (900.000)
        $this->assertDatabaseHas('tour_thuc_tes', [
            'ma_tour_thuc_te' => 'TT_E',
            'gia_hien_hanh' => 900000
        ]);
    }
}
