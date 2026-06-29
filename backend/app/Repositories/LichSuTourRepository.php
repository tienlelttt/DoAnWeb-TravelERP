<?php

namespace App\Repositories;

use App\Models\LichSuTour;

// Repository truy xuất dữ liệu dữ liệu.
class LichSuTourRepository
{
    /**
     * Tạo mới một bản ghi lịch sử tham gia tour của khách hàng
     *
     * @param array $data
     * @return LichSuTour
     */

    public function taoLichSu(array $data): LichSuTour
    {
        return LichSuTour::create($data);
    }
}
