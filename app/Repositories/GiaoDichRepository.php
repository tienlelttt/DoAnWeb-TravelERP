<?php

namespace App\Repositories;

use App\Models\GiaoDich;

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
    public function timGiaoDichChoDuyet(string $maDatTour): ?GiaoDich
    {
        return GiaoDich::where('MaDatTour', $maDatTour)
            ->where('TrangThai', 'CHO_THANH_TOAN')
            ->where('MaGDNH', 'like', 'KHXN:%')
            ->first();
    }
}
