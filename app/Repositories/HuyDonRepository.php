<?php

namespace App\Repositories;

use App\Models\DonDatTour;

class HuyDonRepository
{
    /**
     * Cập nhật trạng thái đơn đặt tour
     *
     * @param DonDatTour $don
     * @param string $trangThai
     * @return void
     */
    public function capNhatTrangThai(DonDatTour $don, string $trangThai): void
    {
        $don->TrangThai = $trangThai;
        $don->save();
    }
}
