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
use App\Models\LichSuTour;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class ThanhToanTest extends TestCase
{
    use DatabaseTransactions;

    protected $tokenKh;
    protected $tokenKd;
    protected $tourThucTe;
    protected $hcs;
    protected $tkKh;
    protected $tkKd;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Tạo tài khoản khách hàng
        $this->tkKh = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_TT_KH',
            'TenDangNhap'  => 'test_tt_khach',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Khách Hàng Thanh Toán',
            'Email'        => 'tt_khach_' . time() . '@test.com',
            'SoDienThoai'  => '0987555666',
            'VaiTro'       => 'KHACHHANG',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1990-01-01',
        ]);

        $this->hcs = HoChieuSo::create([
            'MaKhachHang'   => 'TEST_KH_TT',
            'MaTaiKhoan'    => 'TEST_TK_TT_KH',
            'HangThanhVien' => 'THANH_VIEN',
            'DiemXanh'      => 0,
        ]);

        $this->tokenKh = JWTAuth::fromUser($this->tkKh);

        // 2. Tạo tài khoản Sales (Kinh Doanh)
        $this->tkKd = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_TT_KD',
            'TenDangNhap'  => 'test_tt_sales',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Nhân Viên Sales',
            'Email'        => 'tt_sales_' . time() . '@test.com',
            'SoDienThoai'  => '0987666777',
            'VaiTro'       => 'KINHDOANH',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1985-05-05',
        ]);

        $this->tokenKd = JWTAuth::fromUser($this->tkKd);

        // 3. Tạo Tour Mẫu và Tour Thực Tế
        TourMau::create([
            'MaTourMau' => 'TEST_TM_TT',
            'TieuDe'    => 'Tour Test Thanh Toán',
            'ThoiLuong' => 3,
            'GiaSan'    => 1000000,
        ]);

        $this->tourThucTe = TourThucTe::create([
            'MaTourThucTe'   => 'TEST_TTT_TT',
            'MaTourMau'      => 'TEST_TM_TT',
            'NgayKhoiHanh'   => Carbon::now()->addDays(10)->format('Y-m-d'),
            'GiaHienHanh'    => 2000000,
            'SoKhachToiThieu'=> 2,
            'SoKhachToiDa'   => 20,
            'ChoConLai'      => 10,
            'TrangThai'      => 'MO_BAN',
        ]);
    }

    /**
     * Test Thanh toán trực tuyến Mock thành công
     */
    public function test_thanh_toan_mock_thanh_cong()
    {
        // 1. Tạo đơn đặt tour ở trạng thái CHO_XAC_NHAN
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_TEST_TT1',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);

        // Tạo chi tiết đặt của người đặt để lưu lịch sử tour
        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_TEST_TT1',
            'MaDatTour' => 'DDT_TEST_TT1',
            'MaKhachHang' => 'TEST_KH_TT',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);

        // 2. Khách hàng gọi API thanh toán mock
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/thanh-toan/mock', [
                'maDatTour' => 'DDT_TEST_TT1',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        // 3. Kiểm tra DB
        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DDT_TEST_TT1',
            'TrangThai' => 'DA_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_TEST_TT1',
            'PhuongThuc' => 'MOCK',
            'TrangThai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('LICHSUTOUR', [
            'MaKhachHang' => 'TEST_KH_TT',
            'MaTourThucTe' => 'TEST_TTT_TT',
            'MaChiTietDat' => 'CTD_TEST_TT1',
        ]);
    }

    /**
     * Test Khách báo chuyển khoản thành công
     */
    public function test_bao_chuyen_khoan_thanh_cong()
    {
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_TEST_TT2',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/thanh-toan/bao-chuyen-khoan', [
                'maDatTour' => 'DDT_TEST_TT2',
                'maGDNH' => 'FT2391028',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'CHO_THANH_TOAN');
        $response->assertJsonPath('data.maGDNH', 'KHXN:FT2391028');

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_TEST_TT2',
            'MaGDNH' => 'KHXN:FT2391028',
            'TrangThai' => 'CHO_THANH_TOAN',
        ]);
    }

    /**
     * Test Sales duyệt chuyển khoản thành công (Đồng ý)
     */
    public function test_sales_xac_nhan_thanh_toan_dong_y()
    {
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_TEST_TT3',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_TEST_TT3',
            'MaDatTour' => 'DDT_TEST_TT3',
            'MaKhachHang' => 'TEST_KH_TT',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);

        // Tạo sẵn giao dịch KHXN:
        GiaoDich::create([
            'MaGiaoDich' => 'GD_TEST_TT3',
            'MaDatTour' => 'DDT_TEST_TT3',
            'LoaiGiaoDich' => 'THANH_TOAN',
            'PhuongThuc' => 'CHUYEN_KHOAN',
            'SoTien' => 2000000.0,
            'MaGDNH' => 'KHXN:FT12345',
            'TrangThai' => 'CHO_THANH_TOAN',
        ]);

        // Sales gọi API xác nhận
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT3',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DDT_TEST_TT3',
            'TrangThai' => 'DA_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_TEST_TT3',
            'MaGDNH' => 'FT12345',
            'TrangThai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('LICHSUTOUR', [
            'MaKhachHang' => 'TEST_KH_TT',
            'MaTourThucTe' => 'TEST_TTT_TT',
        ]);
    }

    /**
     * Test Sales từ chối chuyển khoản
     */
    public function test_sales_xac_nhan_thanh_toan_tu_choi()
    {
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_TEST_TT4',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);

        GiaoDich::create([
            'MaGiaoDich' => 'GD_TEST_TT4',
            'MaDatTour' => 'DDT_TEST_TT4',
            'LoaiGiaoDich' => 'THANH_TOAN',
            'PhuongThuc' => 'CHUYEN_KHOAN',
            'SoTien' => 2000000.0,
            'MaGDNH' => 'KHXN:FT12345',
            'TrangThai' => 'CHO_THANH_TOAN',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT4',
                'trangThai' => 'TU_CHOI',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DDT_TEST_TT4',
            'TrangThai' => 'CHO_XAC_NHAN', // Vẫn chờ xác nhận
        ]);

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_TEST_TT4',
            'TrangThai' => 'THAT_BAI',
        ]);
    }

    /**
     * Test chặn phân quyền sai vai trò
     */
    public function test_xac_nhan_thanh_toan_sai_vai_tro()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh) // Gọi bằng token Khách hàng
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT4',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(403);
    }
}
