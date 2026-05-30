<?php

namespace App\Http\Controllers;

use App\Services\TourThucTeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TourCongKhaiController extends Controller
{
    use ApiResponse;

    protected $tourThucTeService;

    public function __construct(TourThucTeService $tourThucTeService)
    {
        $this->tourThucTeService = $tourThucTeService;
    }

    public function danhSachTour(Request $request)
    {
        $giaTu = $request->query('giaTu');
        $giaDen = $request->query('giaDen');
        $thoiLuongMin = $request->query('thoiLuongMin');
        $thoiLuongMax = $request->query('thoiLuongMax');
        $size = $request->query('size', 10);

        return $this->ok("Thành công", 
            $this->tourThucTeService->danhSachCongKhai($giaTu, $giaDen, $thoiLuongMin, $thoiLuongMax, $size)
        );
    }

    public function chiTietTour($maTourThucTe)
    {
        return $this->ok("Thành công", 
            $this->tourThucTeService->chiTietCongKhai($maTourThucTe)
        );
    }
}
