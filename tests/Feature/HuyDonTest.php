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
            'MaTaiKhoan'   => 'TEST_TK_HUY_KH',
            'TenDangNhap'  => 'test_huy_khach',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Khách Hàng Hủy Đơn',
            'Email'        => 'huy_khach_' . time() . '@test.com',
            'SoDienThoai'  => '0987111222',
            'VaiTro'       => 'KHACHHANG',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1990-01-01',
        ]);

        $this->hcs = HoChieuSo::create([
            'MaKhachHang'   => 'TEST_KH_HUY',
            'MaTaiKhoan'    => 'TEST_TK_HUY_KH',
            'HangThanhVien' => 'THANH_VIEN',
            'DiemXanh'      => 0,
        ]);

        $this->tokenKh = JWTAuth::fromUser($this->tkKh);

        // 2. Tạo tài khoản Sales (Kinh Doanh)
        $this->tkKd = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_HUY_KD',
            'TenDangNhap'  => 'test_huy_sales',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Nhân Viên Sales Hủy',
            'Email'        => 'huy_sales_' . time() . '@test.com',
            'SoDienThoai'  => '0987222333',
            'VaiTro'       => 'KINHDOANH',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1985-05-05',
        ]);

        NhanVien::create([
            'MaNhanVien' => 'NV_TEST_HUY_KD',
            'MaTaiKhoan' => 'TEST_TK_HUY_KD',
            'TrangThaiLamViec' => 'DANG_LAM',
        ]);

        $this->tokenKd = JWTAuth::fromUser($this->tkKd);

        // 3. Tạo tài khoản Kế Toán (KeToan)
        $this->tkKt = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_HUY_KT',
            'TenDangNhap'  => 'test_huy_ketoan',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Nhân Viên Kế Toán',
            'Email'        => 'huy_kt_' . time() . '@test.com',
            'SoDienThoai'  => '0987333444',
            'VaiTro'       => 'KETOAN',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1988-08-08',
        ]);

        NhanVien::create([
            'MaNhanVien' => 'NV_TEST_HUY_KT',
            'MaTaiKhoan' => 'TEST_TK_HUY_KT',
            'TrangThaiLamViec' => 'DANG_LAM',
        ]);

        $this->tokenKt = JWTAuth::fromUser($this->tkKt);

        // 4. Tạo Tour Mẫu và Tour Thực Tế
        TourMau::create([
            'MaTourMau' => 'TEST_TM_HUY',
            'TieuDe'    => 'Tour Test Hủy Đơn',
            'ThoiLuong' => 3,
            'GiaSan'    => 1000000,
        ]);

        $this->tourThucTe = TourThucTe::create([
            'MaTourThucTe'   => 'TEST_TTT_HUY',
            'MaTourMau'      => 'TEST_TM_HUY',
            'NgayKhoiHanh'   => Carbon::now()->addDays(10)->format('Y-m-d'), // Cách 10 ngày
            'GiaHienHanh'    => 2000000,
            'SoKhachToiThieu'=> 2,
            'SoKhachToiDa'   => 20,
            'ChoConLai'      => 10,
            'TrangThai'      => 'MO_BAN',
        ]);
    }

    /**
     * Test Sales duyệt đơn đặt tour VIP/Công nợ thành công
     */
    public function test_duyet_don_vip_thanh_cong()
    {
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_HUY_TEST1',
            'MaTourThucTe'  => 'TEST_TTT_HUY',
            'MaKhachHang'   => 'TEST_KH_HUY',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_HUY_TEST1',
            'MaDatTour' => 'DDT_HUY_TEST1',
            'MaKhachHang' => 'TEST_KH_HUY',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/duyet-don/DDT_HUY_TEST1');

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DDT_HUY_TEST1',
            'TrangThai' => 'DA_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_HUY_TEST1',
            'PhuongThuc' => 'CONG_NO',
            'TrangThai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('LICHSUTOUR', [
            'MaKhachHang' => 'TEST_KH_HUY',
            'MaTourThucTe' => 'TEST_TTT_HUY',
        ]);
    }

    /**
     * Test Khách yêu cầu hủy đơn thành công (tính phí hủy bậc thang)
     *   - Hủy trước 10 ngày (nằm trong khoảng 7 - 15 ngày) -> Phí hủy 30% = 600K -> Hoàn tiền 1.4M
     */
    public function test_yeu_cau_huy_don_tinh_phi_bac_thang()
    {
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_HUY_TEST2',
            'MaTourThucTe'  => 'TEST_TTT_HUY',
            'MaKhachHang'   => 'TEST_KH_HUY',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'DA_XAC_NHAN', // Phải đã xác nhận
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/khach-hang/huy-don', [
                'maDatTour' => 'DDT_HUY_TEST2',
                'lyDo' => 'Có việc đột xuất không đi được',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'CHO_HUY');

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DDT_HUY_TEST2',
            'TrangThai' => 'CHO_HUY',
        ]);

        // Kiểm tra ticket hỗ trợ
        $this->assertDatabaseHas('YEUCAUHOTRO', [
            'MaDatTour' => 'DDT_HUY_TEST2',
            'LoaiYeuCau' => 'HUY_TOUR',
            'TrangThai' => 'CHUA_XU_LY',
        ]);

        // Kiểm tra giao dịch hoàn tiền (chờ xử lý)
        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_HUY_TEST2',
            'LoaiGiaoDich' => 'HOAN_TIEN',
            'SoTien' => 1400000.0, // Hoàn 1.4M (Trừ 30% phí hủy của 2.0M)
            'TrangThai' => 'CHO_THANH_TOAN',
        ]);
    }

    /**
     * Test Khách yêu cầu hủy đơn thất bại vì sát ngày khởi hành (< 2 ngày)
     */
    public function test_yeu_cau_huy_don_that_bai_sat_ngay()
    {
        // Tạo tour thực tế khởi hành ngày mai (1 ngày nữa)
        $tourSatNgay = TourThucTe::create([
            'MaTourThucTe'   => 'TEST_TTT_SAT',
            'MaTourMau'      => 'TEST_TM_HUY',
            'NgayKhoiHanh'   => Carbon::now()->addDays(1)->format('Y-m-d'),
            'GiaHienHanh'    => 2000000,
            'SoKhachToiThieu'=> 2,
            'SoKhachToiDa'   => 20,
            'ChoConLai'      => 10,
            'TrangThai'      => 'MO_BAN',
        ]);

        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_HUY_TEST3',
            'MaTourThucTe'  => 'TEST_TTT_SAT',
            'MaKhachHang'   => 'TEST_KH_HUY',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'DA_XAC_NHAN',
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
            'MaDatTour'     => 'DDT_HUY_TEST4',
            'MaTourThucTe'  => 'TEST_TTT_HUY',
            'MaKhachHang'   => 'TEST_KH_HUY',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_HUY',
        ]);

        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_HUY_TEST4',
            'MaDatTour' => 'DDT_HUY_TEST4',
            'MaKhachHang' => 'TEST_KH_HUY',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);

        YeuCauHoTro::create([
            'MaYeuCauHoTro' => 'YCHT_TEST4',
            'MaDatTour' => 'DDT_HUY_TEST4',
            'MaKhachHang' => 'TEST_KH_HUY',
            'LoaiYeuCau' => 'HUY_TOUR',
            'NoiDung' => 'Yêu cầu hủy',
            'TrangThai' => 'CHUA_XU_LY',
        ]);

        LichSuTour::create([
            'MaLichSuTour' => 'LST_TEST4',
            'MaKhachHang' => 'TEST_KH_HUY',
            'MaTourThucTe' => 'TEST_TTT_HUY',
            'MaChiTietDat' => 'CTD_HUY_TEST4',
        ]);

        // Sales đồng ý
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/xu-ly-huy', [
                'maDatTour' => 'DDT_HUY_TEST4',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(200);

        // Ticket chuyển thành DA_XU_LY
        $this->assertDatabaseHas('YEUCAUHOTRO', [
            'MaYeuCauHoTro' => 'YCHT_TEST4',
            'TrangThai' => 'DA_XU_LY',
            'MaNhanVienXuLy' => 'NV_TEST_HUY_KD',
        ]);

        // Lịch sử tour đã bị xóa
        $this->assertDatabaseMissing('LICHSUTOUR', [
            'MaLichSuTour' => 'LST_TEST4',
        ]);
    }

    /**
     * Test Kế toán duyệt hoàn tiền thành công và hoàn trả lại số chỗ thực tế cho tour
     */
    public function test_ke_toan_hoan_tien_giai_phong_cho()
    {
        // Tour đang có 10 chỗ trống
        $tourHuy = TourThucTe::create([
            'MaTourThucTe'   => 'TEST_TTT_HOAN',
            'MaTourMau'      => 'TEST_TM_HUY',
            'NgayKhoiHanh'   => Carbon::now()->addDays(10)->format('Y-m-d'),
            'GiaHienHanh'    => 2000000,
            'SoKhachToiThieu'=> 2,
            'SoKhachToiDa'   => 20,
            'ChoConLai'      => 10,
            'TrangThai'      => 'MO_BAN',
        ]);

        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_HUY_TEST5',
            'MaTourThucTe'  => 'TEST_TTT_HOAN',
            'MaKhachHang'   => 'TEST_KH_HUY',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_HUY',
        ]);

        // 2 hành khách trong đơn hàng (2 chỗ)
        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_TEST5_1',
            'MaDatTour' => 'DDT_HUY_TEST5',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);
        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_TEST5_2',
            'MaDatTour' => 'DDT_HUY_TEST5',
            'LoaiKhach' => 'NGUOI_DONG_HANH',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);

        // Giao dịch hoàn tiền đang chờ
        GiaoDich::create([
            'MaGiaoDich' => 'GD_HOAN_5',
            'MaDatTour' => 'DDT_HUY_TEST5',
            'LoaiGiaoDich' => 'HOAN_TIEN',
            'PhuongThuc' => 'CHUYEN_KHOAN',
            'SoTien' => 1400000.0,
            'TrangThai' => 'CHO_THANH_TOAN',
        ]);

        // Ticket hủy tour đã được Sales duyệt (DA_XU_LY)
        YeuCauHoTro::create([
            'MaYeuCauHoTro' => 'YCHT_TEST5',
            'MaDatTour' => 'DDT_HUY_TEST5',
            'MaKhachHang' => 'TEST_KH_HUY',
            'LoaiYeuCau' => 'HUY_TOUR',
            'NoiDung' => 'Yêu cầu hủy',
            'TrangThai' => 'DA_XU_LY',
        ]);

        // Kế toán hoàn tiền
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKt)
            ->postJson('/api/ke-toan/hoan-tien', [
                'maDatTour' => 'DDT_HUY_TEST5',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_HUY');

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DDT_HUY_TEST5',
            'TrangThai' => 'DA_HUY',
        ]);

        $this->assertDatabaseHas('GIAODICH', [
            'MaGiaoDich' => 'GD_HOAN_5',
            'TrangThai' => 'DA_HOAN_TIEN',
        ]);

        // Kiểm tra số chỗ còn lại tăng từ 10 lên 12 chỗ
        $this->assertEquals(12, TourThucTe::where('MaTourThucTe', 'TEST_TTT_HOAN')->first()->ChoConLai);
    }
}
