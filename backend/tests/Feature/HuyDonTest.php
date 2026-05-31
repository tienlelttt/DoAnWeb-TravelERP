<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\TaiKhoan;
use App\Models\HoChieuSo;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\DonDatTour;
use App\Models\ChiTietDatTour;
use App\Models\GiaoDich;
use App\Models\YeuCauHoTro;
use App\Models\LichSuTour;
use App\Models\NhanVien;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class HuyDonTest extends TestCase
{
    use DatabaseTransactions;

    protected $tokenKh;
    protected $tokenKd;
    protected $tokenKt;
    protected $tourThucTe;
    protected $hcs;
    protected $tkKh;
    protected $tkKd;
    protected $tkKt;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Tạo tài khoản khách hàng
        $this->tkKh = TaiKhoan::create([
            'ma_tai_khoan'   => 'TEST_TK_HUY_KH',
            'ten_dang_nhap'  => 'test_huy_khach',
            'mat_khau'      => bcrypt('123456'),
            'ho_ten'        => 'Khách Hàng Hủy Đơn',
            'email'        => 'huy_khach_' . time() . '@test.com',
            'so_dien_thoai'  => '0987111222',
            'vai_tro'       => 'KHACHHANG',
            'trang_thai'    => 'HOAT_DONG',
            'ngay_sinh'     => '1990-01-01',
        ]);

        $this->hcs = HoChieuSo::create([
            'ma_khach_hang'   => 'TEST_KH_HUY',
            'ma_tai_khoan'    => 'TEST_TK_HUY_KH',
            'hang_thanh_vien' => 'THANH_VIEN',
            'diem_xanh'      => 0,
        ]);

        $this->tokenKh = JWTAuth::fromUser($this->tkKh);

        // 2. Tạo tài khoản Sales (Kinh Doanh)
        $this->tkKd = TaiKhoan::create([
            'ma_tai_khoan'   => 'TEST_TK_HUY_KD',
            'ten_dang_nhap'  => 'test_huy_sales',
            'mat_khau'      => bcrypt('123456'),
            'ho_ten'        => 'Nhân Viên Sales Hủy',
            'email'        => 'huy_sales_' . time() . '@test.com',
            'so_dien_thoai'  => '0987222333',
            'vai_tro'       => 'KINHDOANH',
            'trang_thai'    => 'HOAT_DONG',
            'ngay_sinh'     => '1985-05-05',
        ]);

        NhanVien::create([
            'ma_nhan_vien' => 'NV_TEST_HUY_KD',
            'ma_tai_khoan' => 'TEST_TK_HUY_KD',
            'trang_thai_lam_viec' => 'DANG_LAM',
        ]);

        $this->tokenKd = JWTAuth::fromUser($this->tkKd);

        // 3. Tạo tài khoản Kế Toán (KeToan)
        $this->tkKt = TaiKhoan::create([
            'ma_tai_khoan'   => 'TEST_TK_HUY_KT',
            'ten_dang_nhap'  => 'test_huy_ketoan',
            'mat_khau'      => bcrypt('123456'),
            'ho_ten'        => 'Nhân Viên Kế Toán',
            'email'        => 'huy_kt_' . time() . '@test.com',
            'so_dien_thoai'  => '0987333444',
            'vai_tro'       => 'KETOAN',
            'trang_thai'    => 'HOAT_DONG',
            'ngay_sinh'     => '1988-08-08',
        ]);

        NhanVien::create([
            'ma_nhan_vien' => 'NV_TEST_HUY_KT',
            'ma_tai_khoan' => 'TEST_TK_HUY_KT',
            'trang_thai_lam_viec' => 'DANG_LAM',
        ]);

        $this->tokenKt = JWTAuth::fromUser($this->tkKt);

        // 4. Tạo Tour Mẫu và Tour Thực Tế
        TourMau::create([
            'ma_tour_mau' => 'TEST_TM_HUY',
            'tieu_de'    => 'Tour Test Hủy Đơn',
            'thoi_luong' => 3,
            'gia_san'    => 1000000,
        ]);

        $this->tourThucTe = TourThucTe::create([
            'ma_tour_thuc_te'   => 'TEST_TTT_HUY',
            'ma_tour_mau'      => 'TEST_TM_HUY',
            'ngay_khoi_hanh'   => Carbon::now()->addDays(10)->format('Y-m-d'), // Cách 10 ngày
            'gia_hien_hanh'    => 2000000,
            'so_khach_toi_thieu'=> 2,
            'so_khach_toi_da'   => 20,
            'cho_con_lai'      => 10,
            'trang_thai'      => 'MO_BAN',
        ]);
    }

    /**
     * Test Sales duyệt đơn đặt tour VIP/Công nợ thành công
     */
    public function test_duyet_don_vip_thanh_cong()
    {
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_HUY_TEST1',
            'ma_tour_thuc_te'  => 'TEST_TTT_HUY',
            'ma_khach_hang'   => 'TEST_KH_HUY',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_HUY_TEST1',
            'ma_dat_tour' => 'DDT_HUY_TEST1',
            'ma_khach_hang' => 'TEST_KH_HUY',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/duyet-don/DDT_HUY_TEST1');

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DDT_HUY_TEST1',
            'trang_thai' => 'DA_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_HUY_TEST1',
            'phuong_thuc' => 'CONG_NO',
            'trang_thai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('lich_su_tours', [
            'ma_khach_hang' => 'TEST_KH_HUY',
            'ma_tour_thuc_te' => 'TEST_TTT_HUY',
        ]);
    }

    /**
     * Test Khách yêu cầu hủy đơn thành công (tính phí hủy bậc thang)
     *   - Hủy trước 10 ngày (nằm trong khoảng 7 - 15 ngày) -> Phí hủy 30% = 600K -> Hoàn tiền 1.4M
     */
    public function test_yeu_cau_huy_don_tinh_phi_bac_thang()
    {
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_HUY_TEST2',
            'ma_tour_thuc_te'  => 'TEST_TTT_HUY',
            'ma_khach_hang'   => 'TEST_KH_HUY',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'DA_XAC_NHAN', // Phải đã xác nhận
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/khach-hang/huy-don', [
                'maDatTour' => 'DDT_HUY_TEST2',
                'lyDo' => 'Có việc đột xuất không đi được',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'CHO_HUY');

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DDT_HUY_TEST2',
            'trang_thai' => 'CHO_HUY',
        ]);

        // Kiểm tra ticket hỗ trợ
        $this->assertDatabaseHas('yeu_cau_ho_tros', [
            'ma_dat_tour' => 'DDT_HUY_TEST2',
            'loai_yeu_cau' => 'HUY_TOUR',
            'trang_thai' => 'CHUA_XU_LY',
        ]);

        // Kiểm tra giao dịch hoàn tiền (chờ xử lý)
        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_HUY_TEST2',
            'loai_giao_dich' => 'HOAN_TIEN',
            'so_tien' => 1400000.0, // Hoàn 1.4M (Trừ 30% phí hủy của 2.0M)
            'trang_thai' => 'CHO_THANH_TOAN',
        ]);
    }

    /**
     * Test Khách yêu cầu hủy đơn thất bại vì sát ngày khởi hành (< 2 ngày)
     */
    public function test_yeu_cau_huy_don_that_bai_sat_ngay()
    {
        // Tạo tour thực tế khởi hành ngày mai (1 ngày nữa)
        $tourSatNgay = TourThucTe::create([
            'ma_tour_thuc_te'   => 'TEST_TTT_SAT',
            'ma_tour_mau'      => 'TEST_TM_HUY',
            'ngay_khoi_hanh'   => Carbon::now()->addDays(1)->format('Y-m-d'),
            'gia_hien_hanh'    => 2000000,
            'so_khach_toi_thieu'=> 2,
            'so_khach_toi_da'   => 20,
            'cho_con_lai'      => 10,
            'trang_thai'      => 'MO_BAN',
        ]);

        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_HUY_TEST3',
            'ma_tour_thuc_te'  => 'TEST_TTT_SAT',
            'ma_khach_hang'   => 'TEST_KH_HUY',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'DA_XAC_NHAN',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/khach-hang/huy-don', [
                'maDatTour' => 'DDT_HUY_TEST3',
                'lyDo' => 'Hủy sát ngày',
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Chỉ được yêu cầu hủy tour tối thiểu 2 ngày trước ngày khởi hành');
    }

    /**
     * Test Sales đồng ý duyệt yêu cầu hủy đơn
     */
    public function test_sales_duyet_huy_don_dong_y()
    {
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_HUY_TEST4',
            'ma_tour_thuc_te'  => 'TEST_TTT_HUY',
            'ma_khach_hang'   => 'TEST_KH_HUY',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_HUY',
        ]);

        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_HUY_TEST4',
            'ma_dat_tour' => 'DDT_HUY_TEST4',
            'ma_khach_hang' => 'TEST_KH_HUY',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        YeuCauHoTro::create([
            'ma_yeu_cau_ho_tro' => 'YCHT_TEST4',
            'ma_dat_tour' => 'DDT_HUY_TEST4',
            'ma_khach_hang' => 'TEST_KH_HUY',
            'loai_yeu_cau' => 'HUY_TOUR',
            'noi_dung' => 'Yêu cầu hủy',
            'trang_thai' => 'CHUA_XU_LY',
        ]);

        LichSuTour::create([
            'ma_lich_su_tour' => 'LST_TEST4',
            'ma_khach_hang' => 'TEST_KH_HUY',
            'ma_tour_thuc_te' => 'TEST_TTT_HUY',
            'ma_chi_tiet_dat' => 'CTD_HUY_TEST4',
        ]);

        // Sales đồng ý
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/xu-ly-huy', [
                'maDatTour' => 'DDT_HUY_TEST4',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(200);

        // Ticket chuyển thành DA_XU_LY
        $this->assertDatabaseHas('yeu_cau_ho_tros', [
            'ma_yeu_cau_ho_tro' => 'YCHT_TEST4',
            'trang_thai' => 'DA_XU_LY',
            'ma_nhan_vien_xu_ly' => 'NV_TEST_HUY_KD',
        ]);

        // Lịch sử tour đã bị xóa
        $this->assertDatabaseMissing('lich_su_tours', [
            'ma_lich_su_tour' => 'LST_TEST4',
        ]);
    }

    /**
     * Test Kế toán duyệt hoàn tiền thành công và hoàn trả lại số chỗ thực tế cho tour
     */
    public function test_ke_toan_hoan_tien_giai_phong_cho()
    {
        // Tour đang có 10 chỗ trống
        $tourHuy = TourThucTe::create([
            'ma_tour_thuc_te'   => 'TEST_TTT_HOAN',
            'ma_tour_mau'      => 'TEST_TM_HUY',
            'ngay_khoi_hanh'   => Carbon::now()->addDays(10)->format('Y-m-d'),
            'gia_hien_hanh'    => 2000000,
            'so_khach_toi_thieu'=> 2,
            'so_khach_toi_da'   => 20,
            'cho_con_lai'      => 10,
            'trang_thai'      => 'MO_BAN',
        ]);

        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_HUY_TEST5',
            'ma_tour_thuc_te'  => 'TEST_TTT_HOAN',
            'ma_khach_hang'   => 'TEST_KH_HUY',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_HUY',
        ]);

        // 2 hành khách trong đơn hàng (2 chỗ)
        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_TEST5_1',
            'ma_dat_tour' => 'DDT_HUY_TEST5',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);
        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_TEST5_2',
            'ma_dat_tour' => 'DDT_HUY_TEST5',
            'loai_khach' => 'NGUOI_DONG_HANH',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        // Giao dịch hoàn tiền đang chờ
        GiaoDich::create([
            'ma_giao_dich' => 'GD_HOAN_5',
            'ma_dat_tour' => 'DDT_HUY_TEST5',
            'loai_giao_dich' => 'HOAN_TIEN',
            'phuong_thuc' => 'CHUYEN_KHOAN',
            'so_tien' => 1400000.0,
            'trang_thai' => 'CHO_THANH_TOAN',
        ]);

        // Ticket hủy tour đã được Sales duyệt (DA_XU_LY)
        YeuCauHoTro::create([
            'ma_yeu_cau_ho_tro' => 'YCHT_TEST5',
            'ma_dat_tour' => 'DDT_HUY_TEST5',
            'ma_khach_hang' => 'TEST_KH_HUY',
            'loai_yeu_cau' => 'HUY_TOUR',
            'noi_dung' => 'Yêu cầu hủy',
            'trang_thai' => 'DA_XU_LY',
        ]);

        // Kế toán hoàn tiền
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKt)
            ->postJson('/api/ke-toan/hoan-tien', [
                'maDatTour' => 'DDT_HUY_TEST5',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_HUY');

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DDT_HUY_TEST5',
            'trang_thai' => 'DA_HUY',
        ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_giao_dich' => 'GD_HOAN_5',
            'trang_thai' => 'DA_HOAN_TIEN',
        ]);

        // Kiểm tra số chỗ còn lại tăng từ 10 lên 12 chỗ
        $this->assertEquals(12, TourThucTe::where('ma_tour_thuc_te', 'TEST_TTT_HOAN')->first()->cho_con_lai);
    }
}
