<?php

namespace App\Repositories;

use App\Models\PhanCongTour;
use App\Models\TourThucTe;
use App\Exceptions\AppException;
use Carbon\Carbon;

class PhanCongTourRepository
{
    /**
     * Kiểm tra xem HDV có bị trùng lịch hay không (nguyên tắc cách nhau 12 tiếng)
     */
    public function kiemTraTrungLichHDV(string $maNhanVien, Carbon $ngayKhoiHanhMoi, Carbon $ngayKetThucMoi): void
    {
        // Lấy danh sách các tour đã phân công cho HDV mà chưa bị từ chối
        $danhSachPhanCong = PhanCongTour::with(['tourThucTe.tourMau'])
            ->where('ma_nhan_vien', $maNhanVien)
            ->where('trang_thai_chap_nhan', '!=', 'TU_CHOI')
            ->get();

        foreach ($danhSachPhanCong as $phanCong) {
            $tourThucTe = $phanCong->tourThucTe;
            if (!$tourThucTe || !$tourThucTe->tourMau) {
                continue; // Bỏ qua nếu dữ liệu lỗi
            }

            $thoiLuongCu = $tourThucTe->tourMau->thoi_luong; // Số ngày
            $ngayKhoiHanhCu = Carbon::parse($tourThucTe->ngay_khoi_hanh);
            $ngayKetThucCu = $ngayKhoiHanhCu->copy()->addDays($thoiLuongCu);

            // Kiểm tra trùng lặp: Nếu (Bắt đầu mới < Kết thúc cũ + 12h) VÀ (Kết thúc mới + 12h > Bắt đầu cũ) thì trùng
            $ngayKetThucCuCong12h = $ngayKetThucCu->copy()->addHours(12);
            $ngayKetThucMoiCong12h = $ngayKetThucMoi->copy()->addHours(12);

            if ($ngayKhoiHanhMoi < $ngayKetThucCuCong12h && $ngayKetThucMoiCong12h > $ngayKhoiHanhCu) {
                throw AppException::badRequest("Hướng dẫn viên bị trùng lịch hoặc khoảng cách nghỉ ngơi giữa 2 tour ít hơn 12 tiếng. (Đang cấn lịch với tour " . $tourThucTe->ma_tour_thuc_te . ")");
            }
        }
    }

    /**
     * Đếm số lượng HDV đã chấp nhận công tác cho 1 tour
     */
    public function kiemTraSoLuongHDVDongY(string $maTourThucTe): int
    {
        return PhanCongTour::where('ma_tour_thuc_te', $maTourThucTe)
            ->where('trang_thai_chap_nhan', 'DA_DONG_Y')
            ->count();
    }
}
