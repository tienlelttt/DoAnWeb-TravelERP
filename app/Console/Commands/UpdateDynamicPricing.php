<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourThucTe;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateDynamicPricing extends Command
{
    protected $signature = 'pricing:update-dynamic';
    protected $description = 'Cập nhật giá động cho các tour thực tế sắp khởi hành dựa trên tỷ lệ lấp đầy';

    public function handle()
    {
        $this->info('Đang bắt đầu cập nhật giá động...');
        
        $now = Carbon::now();
        // Chỉ xét các tour sắp khởi hành (trong tương lai) và chưa kết thúc/đã hủy
        $tours = TourThucTe::where('NgayKhoiHanh', '>', $now)
            ->whereIn('TrangThai', ['SAP_KHOI_HANH', 'CHUA_KHOI_HANH', 'DANG_NHAN_KHACH', 'MO_BAN'])
            ->get();

        $count = 0;
        foreach ($tours as $tour) {
            DB::transaction(function () use ($tour, &$count, $now) {
                $lockedTour = TourThucTe::lockForUpdate()->find($tour->MaTourThucTe);
                
                $soKhachToiDa = $lockedTour->SoKhachToiDa;
                $choConLai = $lockedTour->ChoConLai;
                $daDat = $soKhachToiDa - $choConLai;

                if ($soKhachToiDa == 0) return;

                $tyLeLapDay = $daDat / $soKhachToiDa;
                $giaGoc = $lockedTour->GiaHienHanh; // Sử dụng giá hiện hành để tính toán

                $giaMoi = $giaGoc;

                // Logic ví dụ cho Dynamic Pricing
                // 1. Nếu tỷ lệ lấp đầy > 80%, tăng giá 5%
                // 2. Nếu tỷ lệ lấp đầy < 30% và sắp khởi hành (dưới 7 ngày), giảm giá 10%
                
                $daysToStart = Carbon::parse($lockedTour->NgayKhoiHanh)->diffInDays($now);

                if ($tyLeLapDay > 0.8) {
                    $giaMoi = $giaGoc * 1.05; 
                } elseif ($tyLeLapDay < 0.3 && $daysToStart <= 7) {
                    $giaMoi = $giaGoc * 0.90;
                }

                if ($giaMoi != $lockedTour->GiaHienHanh) {
                    $lockedTour->GiaHienHanh = $giaMoi;
                    $lockedTour->save();
                    $count++;
                    $this->info("Tour {$lockedTour->MaTourThucTe} đổi giá: {$giaGoc} -> {$giaMoi}");
                }
            });
        }

        $this->info("Cập nhật giá động hoàn tất. Đã thay đổi giá cho {$count} tour.");
    }
}
