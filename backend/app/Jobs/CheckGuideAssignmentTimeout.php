<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PhanCongTour;
use Illuminate\Support\Facades\Log;

// Model lưu thông tin điều phối HDV.
class CheckGuideAssignmentTimeout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $maPhanCongTour;

    /**
     * Create a new job instance.
     */
    public function __construct(string $maPhanCongTour)
    {
        $this->maPhanCongTour = $maPhanCongTour;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $phanCong = PhanCongTour::where('ma_phan_cong_tour', $this->maPhanCongTour)->first();
        
        if ($phanCong && $phanCong->trang_thai_chap_nhan === 'CHO_PHAN_HOI') {
            // ??i tr?ng thái thành t? ch?i ho?c h?t h?n (dùng TU_CHOI theo th?ng nh?t ?? không ??i c?u trúc)
            $phanCong->trang_thai_chap_nhan = 'TU_CHOI';
            $phanCong->ngay_phan_hoi = now();
            $phanCong->save();

            // Ghi log ho?c g?i notification ?? c?nh báo ?i?u ph?i
            Log::warning("C?nh báo: HDV (Mã: {$phanCong->ma_nhan_vien}) đã quá h?n 24h xác nh?n phân công cho Tour (Mã: {$phanCong->ma_tour_thuc_te}). H? th?ng đã t? ??ng t? ch?i.");
        }
    }
}
