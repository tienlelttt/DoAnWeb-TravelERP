<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

// Module quản lý dữ liệu.
class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function overview()
    {
        $data = $this->dashboardService->getOverview();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Lấy dữ liệu tổng quan thành công',
            'data' => $data
        ]);
    }

    public function revenueChart(Request $request)
    {
        $year = $request->input('year');
        $data = $this->dashboardService->getRevenueChart($year);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Lấy dữ liệu biểu đồ doanh thu thành công',
            'data' => $data
        ]);
    }
}
