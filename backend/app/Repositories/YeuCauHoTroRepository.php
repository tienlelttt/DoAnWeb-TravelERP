<?php

namespace App\Repositories;

use App\Models\YeuCauHoTro;

// Repository truy xuất dữ liệu yêu cầu hỗ trợ.
class YeuCauHoTroRepository
{
    /**
     * Tạo mới một bản ghi yêu cầu hỗ trợ (ticket)
     *
     * @param array $data
     * @return YeuCauHoTro
     */
    public function taoYeuCau(array $data): YeuCauHoTro
    {
        return YeuCauHoTro::create($data);
    }

    /**
     * Tìm ticket yêu cầu hủy tour đang chờ duyệt của đơn đặt tour
     *
     * @param string $maDatTour
     * @return YeuCauHoTro|null
     */
    // UC36 | Khách hàng | Hủy yêu cầu hỗ trợ.
    public function timTicketHuyTourChoDuyet(string $maDatTour): ?YeuCauHoTro
    {
        return YeuCauHoTro::where('ma_dat_tour', $maDatTour)
            ->where('loai_yeu_cau', 'HUY_TOUR')
            ->where('trang_thai', 'CHUA_XU_LY')
            ->first();
    }

    /**
     * Tìm ticket yêu cầu hủy tour đã được Sales duyệt để Kế toán hoàn tiền
     *
     * @param string $maDatTour
     * @return YeuCauHoTro|null
     */
    // UC36 | Khách hàng | Hủy yêu cầu hỗ trợ (timTicketHuyTourDaDuyet).
    public function timTicketHuyTourDaDuyet(string $maDatTour): ?YeuCauHoTro
    {
        return YeuCauHoTro::where('ma_dat_tour', $maDatTour)
            ->where('loai_yeu_cau', 'HUY_TOUR')
            ->where('trang_thai', 'DA_XU_LY')
            ->first();
    }
}
