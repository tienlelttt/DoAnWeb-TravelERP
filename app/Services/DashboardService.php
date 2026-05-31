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
        $totalRevenue = DonDatTour::where('TrangThai', 'DA_THANH_TOAN')->sum('TongTien');

        // 2. Tổng số bookings (đã thanh toán hoặc hoàn thành)
        $totalBookings = DonDatTour::whereIn('TrangThai', ['DA_THANH_TOAN', 'HOAN_THANH'])->count();

        // 3. Tổng số khách hàng (số người trong các booking hợp lệ)
        // Lấy từ bảng DSNGUOIDONGHANH liên kết với DONDATTOUR hoặc đơn giản là đếm
        $totalCustomers = DB::table('DSNGUOIDONGHANH')
            ->join('DONDATTOUR', 'DSNGUOIDONGHANH.MaDatTour', '=', 'DONDATTOUR.MaDatTour')
            ->whereIn('DONDATTOUR.TrangThai', ['DA_THANH_TOAN', 'HOAN_THANH'])
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
        $revenues = DonDatTour::where('TrangThai', 'DA_THANH_TOAN')
            ->whereYear('NgayDat', $year)
            ->select(
                DB::raw('MONTH(NgayDat) as month'),
                DB::raw('SUM(TongTien) as revenue')
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
