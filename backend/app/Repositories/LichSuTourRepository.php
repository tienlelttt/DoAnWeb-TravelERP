<?php

namespace App\Repositories;

use App\Models\LichSuTour;

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
