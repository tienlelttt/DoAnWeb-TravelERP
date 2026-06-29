<?php

namespace App\Repositories;

use App\Models\DonDatTour;

// Repository truy xuất dữ liệu dữ liệu.
class HuyDonRepository
{
    /**
     * Cập nhật trạng thái đơn đặt tour
     *
     * @param DonDatTour $don
     * @param string $trangThai
     * @return void
     */
    // Cập nhật dữ liệu.
    public function capNhatTrangThai(DonDatTour $don, string $trangThai): void
    {
        $don->trang_thai = $trangThai;
        $don->save();
    }
}
