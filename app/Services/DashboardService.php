<?php

namespace App\Services;

use App\Models\DonDatTour;
use App\Models\TaiKhoan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getOverview()
    {
        // 1. Tổng doanh thu (Các đơn đã thanh toán)
        $totalRevenue = DonDatTour::where('trang_thai', 'DA_THANH_TOAN')->sum('tong_tien');

        // 2. Tổng số bookings (đã thanh toán hoặc hoàn thành)
        $totalBookings = DonDatTour::whereIn('trang_thai', ['DA_THANH_TOAN', 'HOAN_THANH'])->count();

        // 3. Tổng số khách hàng (số người trong các booking hợp lệ)
        // Lấy từ bảng ds_nguoi_dong_hanhs liên kết với don_dat_tours hoặc đơn giản là đếm
        $totalCustomers = DB::table('ds_nguoi_dong_hanhs')
            ->join('don_dat_tours', 'ds_nguoi_dong_hanhs.ma_dat_tour', '=', 'don_dat_tours.ma_dat_tour')
            ->whereIn('don_dat_tours.trang_thai', ['DA_THANH_TOAN', 'HOAN_THANH'])
            ->count();
            
        // 4. Tổng số users (nhân viên + khách hàng)
        $totalUsers = TaiKhoan::count();

        return [
            'totalRevenue' => (float) $totalRevenue,
            'totalBookings' => $totalBookings,
            'totalCustomers' => $totalCustomers,
            'totalUsers' => $totalUsers,
        ];
    }

    public function getRevenueChart($year = null)
    {
        $year = $year ?? Carbon::now()->year;

        // Group by tháng trong năm
        $revenues = DonDatTour::where('trang_thai', 'DA_THANH_TOAN')
            ->whereYear('ngay_dat', $year)
            ->select(
                DB::raw('MONTH(ngay_dat) as month'),
                DB::raw('SUM(tong_tien) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Định dạng lại mảng đủ 12 tháng
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = [
                'month' => 'Tháng ' . $i,
                'revenue' => 0
            ];
        }

        foreach ($revenues as $item) {
            $chartData[$item->month - 1]['revenue'] = (float) $item->revenue;
        }

        return $chartData;
    }
}
