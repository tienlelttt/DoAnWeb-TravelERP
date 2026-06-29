<?php

namespace App\Repositories;

use App\Models\Voucher;

// Repository truy xuất dữ liệu voucher.
class VoucherRepository
{
    /**
     * Tìm kiếm Voucher đang hoạt động theo mã hoặc code, kèm theo khóa dòng (Pessimistic Locking)
     *
     * @param string $maVoucher
     * @return Voucher|null
     */
    public function timTheoMaHoacCodeCoKhoa(string $maVoucher): ?Voucher
    {
        // Sử dụng lockForUpdate để tránh race condition khi nhiều người cùng dùng chung mã voucher
        return Voucher::lockForUpdate()
            ->where(function ($query) use ($maVoucher) {
                $query->where('ma_voucher', $maVoucher)
                      ->orWhere('ma_code', $maVoucher);
            })
            ->first();
    }

    /**
     * Tăng số lượt đã sử dụng của Voucher gốc lên 1
     *
     * @param Voucher $voucher
     * @return void
     */
    public function tangSoLuotDaDung(Voucher $voucher): void
    {
        $voucher->so_luot_da_dung += 1;
        $voucher->save();
    }
}
