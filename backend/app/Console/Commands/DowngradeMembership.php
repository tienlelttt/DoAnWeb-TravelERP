<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HoChieuSo;
use Carbon\Carbon;

// Model lưu thông tin dữ liệu.
class DowngradeMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:downgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'H? b?c h?ng và ?i?m xanh c?a thành viên n?u không có ho?t ??ng trong 6 tháng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // L?y các h? s? có ngày c?p nh?t cu?i cùng quá 6 tháng (không có giao d?ch/hành ??ng xanh)
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $hoChieuSos = HoChieuSo::where('updated_at', '<=', $sixMonthsAgo)->get();

        $count = 0;
        foreach ($hoChieuSos as $hcs) {
            $hangHienTai = $hcs->hang_thanh_vien;
            $diemHienTai = $hcs->diem_xanh;

            switch ($hangHienTai) {
                case 'KIM_CUONG':
                    $hcs->hang_thanh_vien = 'VANG';
                    // KIM_CUONG >= 5000, VANG >= 2000. Tr? ?i?m v? max c?a VANG.
                    $hcs->diem_xanh = min($diemHienTai, 4999);
                    break;
                case 'VANG':
                    $hcs->hang_thanh_vien = 'BAC';
                    // VANG >= 2000, BAC >= 1000
                    $hcs->diem_xanh = min($diemHienTai, 1999);
                    break;
                case 'BAC':
                    $hcs->hang_thanh_vien = 'DONG';
                    // BAC >= 1000, DONG >= 500
                    $hcs->diem_xanh = min($diemHienTai, 999);
                    break;
                case 'DONG':
                    $hcs->hang_thanh_vien = 'THANH_VIEN';
                    // DONG >= 500
                    $hcs->diem_xanh = min($diemHienTai, 499);
                    break;
                default:
                    // THANH_VIEN không h? c?p n?a
                    continue 2;
            }

            // ?? tránh vi?c vòng l?p h? h?ng liên t?c n?u ngày update quá c? mà command ch?y l?i,
            // ta l?u c?p nh?t timestamps
            $hcs->save();
            $count++;
        }

        $this->info("Quá trình quét và h? h?ng hoàn t?t. Đã x? lý $count h? s?.");
    }
}
