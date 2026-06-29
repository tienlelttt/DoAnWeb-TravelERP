<?php

namespace App\Repositories;

use App\Models\KhuyenMaiKh;

// Repository truy xuất dữ liệu khuyến mãi.
class KhuyenMaiKHRepository
{
    /**
     * Tìm kiếm bản ghi ví khuyến mãi của khách hàng theo mã khách và mã voucher, kèm khóa dòng
     *
     * @param string $maKhachHang
     * @param string $maVoucher
     * @return KhuyenMaiKh|null
     */
    public function timVoucherTrongViCoKhoa(string $maKhachHang, string $maVoucher): ?KhuyenMaiKh
    {
        return KhuyenMaiKh::lockForUpdate()
            ->where('ma_khach_hang', $maKhachHang)
            ->where('ma_voucher', $maVoucher)
            ->first();
    }

    /**
     * Cập nhật trạng thái ví voucher thành DA_SU_DUNG bằng câu lệnh update an toàn với composite keys
     *
     * @param string $maKhachHang
     * @param string $maVoucher
     * @return void
     */
    // UC52 | Nhân viên kinh doanh | Cập nhật khuyến mãi.
    public function capNhatTrangThaiDaSuDung(string $maKhachHang, string $maVoucher): void
    {
        // Sử dụng query builder với composite key thay vì gọi save() trên model instance để tránh lỗi không có primary key
        KhuyenMaiKh::where('ma_khach_hang', $maKhachHang)
            ->where('ma_voucher', $maVoucher)
            ->update([
                'trang_thai' => 'DA_SU_DUNG',
                'updated_at' => now(),
            ]);
    }

    /**
     * Lấy danh sách ví voucher của khách hàng (phân trang)
     *
     * @param string $maKhachHang
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    // UC52 | Nhân viên kinh doanh | Lấy danh sách khuyến mãi.
    public function danhSachVoucherCuaKhach(string $maKhachHang, int $perPage = 10)
    {
        return KhuyenMaiKh::with(['voucher', 'khachHang.taiKhoan'])
            ->where('ma_khach_hang', $maKhachHang)
            ->paginate($perPage);
    }
}
