<?php

namespace App\Repositories;

use App\Models\GiaoDich;

// Repository truy xuất dữ liệu dữ liệu.
class GiaoDichRepository
{
    /**
     * Tạo mới một bản ghi giao dịch thanh toán
     *
     * @param array $data
     * @return GiaoDich
     */

    public function taoGiaoDich(array $data): GiaoDich
    {
        return GiaoDich::create($data);
    }

    /**
     * Tìm kiếm giao dịch báo chuyển khoản đang chờ duyệt của đơn hàng (có mã ngân hàng bắt đầu bằng KHXN:)
     *
     * @param string $maDatTour
     * @return GiaoDich|null
     */
    // Phê duyệt dữ liệu.
    public function timGiaoDichChoDuyet(string $maDatTour): ?GiaoDich
    {
        return GiaoDich::where('ma_dat_tour', $maDatTour)
            ->where('trang_thai', 'CHO_THANH_TOAN')
            ->where('ma_gdnh', 'like', 'KHXN:%')
            ->first();
    }
}
