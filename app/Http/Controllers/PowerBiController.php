<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PowerBiService;

/**
 * Controller trích xuất dữ liệu phân tích (Power BI).
 * Cho phép Kế toán kết nối dữ liệu mộc và xuất ra CSV/Excel
 */
class PowerBiController extends Controller
{
    public function __construct(
        private PowerBiService $powerBiService
    ) {}

    /**
     * Danh sách các kho dữ liệu khả dụng (Doanh thu, Đơn đặt tour, Chi phí,...)
     */
    public function danhSachKhoDuLieu()
    {
        $data = $this->powerBiService->danhSachKhoDuLieu();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    /**
     * Lấy thông tin kết nối DB (Credentials Read-Only) để Power BI Desktop kết nối
     */
    public function layThongTinKetNoi(Request $request)
    {
        $maKho = $request->query('maKho');
        $user = auth('api')->user();

        $data = $this->powerBiService->layThongTinKetNoi($maKho, $user);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thông tin kết nối Power BI',
            'data' => $data
        ]);
    }

    /**
     * Xuất dữ liệu thành file CSV
     */
    public function xuatDuLieu(Request $request)
    {
        $request->validate([
            'maKho' => 'required|string',
            'tuNgay' => 'nullable|date',
            'denNgay' => 'nullable|date',
            'dinhDang' => 'required|string|in:CSV,EXCEL'
        ]);

        $user = auth('api')->user();
        
        $data = $this->powerBiService->xuatDuLieu($request->all(), $user);
        
        $isExcel = strtoupper($request->dinhDang) === 'EXCEL';
        
        $contentType = $isExcel 
            ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' 
            : 'text/csv; charset=UTF-8';
            
        $extension = $isExcel ? '.xlsx' : '.csv';
        $filename = "PowerBI_{$request->maKho}_" . date('Ymd') . $extension;

        return response($data)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
