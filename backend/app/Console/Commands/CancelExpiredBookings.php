<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DonDatTour;
use App\Models\TourThucTe;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hủy các đơn đặt tour quá hạn thanh toán (24 giờ)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Đang quét các đơn đặt tour quá hạn...');
        
        $expiredTime = Carbon::now()->subHours(24);

        $expiredBookings = DonDatTour::where('trang_thai', 'CHO_THANH_TOAN')
            ->where('ngay_dat', '<=', $expiredTime)
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('Không có đơn nào quá hạn.');
            return;
        }

        $count = 0;
        foreach ($expiredBookings as $don) {
            DB::transaction(function () use ($don, &$count) {
                // Lock đơn
                $lockedDon = DonDatTour::lockForUpdate()->find($don->ma_dat_tour);
                
                if ($lockedDon->trang_thai !== 'CHO_THANH_TOAN') {
                    return; // Đã được xử lý bởi tiến trình khác
                }

                $lockedDon->trang_thai = 'DA_HUY';
                $lockedDon->save();

                // Hoàn lại chỗ cho tour
                $tour = TourThucTe::lockForUpdate()->find($lockedDon->ma_tour_thuc_te);
                if ($tour) {
                    $soKhach = DB::table('chi_tiet_dat_tours')->where('ma_dat_tour', $lockedDon->ma_dat_tour)->count();
                    $tour->cho_con_lai = min($tour->cho_con_lai + $soKhach, $tour->so_khach_toi_da);
                    $tour->save();
                }

                // Ghi log (nếu có AuditLog) có thể thực hiện ở đây

                $count++;
            });
        }

        $this->info("Đã hủy thành công {$count} đơn đặt tour quá hạn.");
    }
}
