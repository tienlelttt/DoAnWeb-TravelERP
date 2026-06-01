<?php

namespace Tests\Feature;

use App\Models\ChiTietDatTour;
use App\Models\DonDatTour;
use App\Models\GiaoDich;
use App\Models\HoChieuSo;
use App\Models\TaiKhoan;
use App\Models\TourMau;
use App\Models\TourThucTe;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
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

        // Tạo tài khoản khách hàng.
        $this->tkKh = TaiKhoan::create([
            'ma_tai_khoan' => 'TEST_TK_TT_KH',
            'ten_dang_nhap' => 'test_tt_khach',
            'mat_khau' => bcrypt('123456'),
            'ho_ten' => 'Khách Hàng Thanh Toán',
            'email' => 'tt_khach_' . time() . '@test.com',
            'so_dien_thoai' => '0987555666',
            'vai_tro' => 'KHACHHANG',
            'trang_thai' => 'HOAT_DONG',
            'ngay_sinh' => '1990-01-01',
        ]);

        $this->hcs = HoChieuSo::create([
            'ma_khach_hang' => 'TEST_KH_TT',
            'ma_tai_khoan' => 'TEST_TK_TT_KH',
            'hang_thanh_vien' => 'THANH_VIEN',
            'diem_xanh' => 0,
        ]);

        $this->tokenKh = JWTAuth::fromUser($this->tkKh);

        // Tạo tài khoản Sales/Kinh doanh.
        $this->tkKd = TaiKhoan::create([
            'ma_tai_khoan' => 'TEST_TK_TT_KD',
            'ten_dang_nhap' => 'test_tt_sales',
            'mat_khau' => bcrypt('123456'),
            'ho_ten' => 'Nhân Viên Sales',
            'email' => 'tt_sales_' . time() . '@test.com',
            'so_dien_thoai' => '0987666777',
            'vai_tro' => 'KINHDOANH',
            'trang_thai' => 'HOAT_DONG',
            'ngay_sinh' => '1985-05-05',
        ]);

        $this->tokenKd = JWTAuth::fromUser($this->tkKd);

        // Tạo tour mẫu và tour thực tế.
        TourMau::create([
            'ma_tour_mau' => 'TEST_TM_TT',
            'tieu_de' => 'Tour Test Thanh Toán',
            'thoi_luong' => 3,
            'gia_san' => 1000000,
        ]);

        $this->tourThucTe = TourThucTe::create([
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_tour_mau' => 'TEST_TM_TT',
            'ngay_khoi_hanh' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'gia_hien_hanh' => 2000000,
            'so_khach_toi_thieu' => 2,
            'so_khach_toi_da' => 20,
            'cho_con_lai' => 10,
            'trang_thai' => 'MO_BAN',
        ]);
    }

    /**
     * Test thanh toán trực tuyến mock thành công.
     */
    public function test_thanh_toan_mock_thanh_cong()
    {
        // Tạo đơn đặt tour ở trạng thái CHO_XAC_NHAN.
        DonDatTour::create([
            'ma_dat_tour' => 'DDT_TEST_TT1',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_khach_hang' => 'TEST_KH_TT',
            'ngay_dat' => Carbon::now(),
            'tong_tien' => 2000000.0,
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        // Tạo chi tiết đặt của người đặt để lưu lịch sử tour.
        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_TEST_TT1',
            'ma_dat_tour' => 'DDT_TEST_TT1',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        // Khách hàng gọi API thanh toán mock.
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/thanh-toan/mock', [
                'maDatTour' => 'DDT_TEST_TT1',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DDT_TEST_TT1',
            'trang_thai' => 'DA_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_TEST_TT1',
            'phuong_thuc' => 'MOCK',
            'trang_thai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('lich_su_tours', [
            'ma_khach_hang' => 'TEST_KH_TT',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_chi_tiet_dat' => 'CTD_TEST_TT1',
        ]);
    }

    /**
     * Test khách báo chuyển khoản thành công.
     */
    public function test_bao_chuyen_khoan_thanh_cong()
    {
        DonDatTour::create([
            'ma_dat_tour' => 'DDT_TEST_TT2',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_khach_hang' => 'TEST_KH_TT',
            'ngay_dat' => Carbon::now(),
            'tong_tien' => 2000000.0,
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/thanh-toan/bao-chuyen-khoan', [
                'maDatTour' => 'DDT_TEST_TT2',
                'maGDNH' => 'FT2391028',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'CHO_THANH_TOAN');
        $response->assertJsonPath('data.maGDNH', 'KHXN:FT2391028');

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_TEST_TT2',
            'ma_gdnh' => 'KHXN:FT2391028',
            'trang_thai' => 'CHO_THANH_TOAN',
        ]);
    }

    /**
     * Test Sales duyệt chuyển khoản thành công khi đồng ý.
     */
    public function test_sales_xac_nhan_thanh_toan_dong_y()
    {
        DonDatTour::create([
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_khach_hang' => 'TEST_KH_TT',
            'ngay_dat' => Carbon::now(),
            'tong_tien' => 2000000.0,
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_TEST_TT3',
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        // Tạo sẵn giao dịch khách đã báo chuyển khoản.
        GiaoDich::create([
            'ma_giao_dich' => 'GD_TEST_TT3',
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'loai_giao_dich' => 'THANH_TOAN',
            'phuong_thuc' => 'CHUYEN_KHOAN',
            'so_tien' => 2000000.0,
            'ma_gdnh' => 'KHXN:FT12345',
            'trang_thai' => 'CHO_THANH_TOAN',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT3',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'trang_thai' => 'DA_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'ma_gdnh' => 'FT12345',
            'trang_thai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('lich_su_tours', [
            'ma_khach_hang' => 'TEST_KH_TT',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
        ]);
    }

    /**
     * Test Sales từ chối chuyển khoản.
     */
    public function test_sales_xac_nhan_thanh_toan_tu_choi()
    {
        DonDatTour::create([
            'ma_dat_tour' => 'DDT_TEST_TT4',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_khach_hang' => 'TEST_KH_TT',
            'ngay_dat' => Carbon::now(),
            'tong_tien' => 2000000.0,
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        GiaoDich::create([
            'ma_giao_dich' => 'GD_TEST_TT4',
            'ma_dat_tour' => 'DDT_TEST_TT4',
            'loai_giao_dich' => 'THANH_TOAN',
            'phuong_thuc' => 'CHUYEN_KHOAN',
            'so_tien' => 2000000.0,
            'ma_gdnh' => 'KHXN:FT12345',
            'trang_thai' => 'CHO_THANH_TOAN',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKd)
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT4',
                'trangThai' => 'TU_CHOI',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DDT_TEST_TT4',
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_TEST_TT4',
            'trang_thai' => 'THAT_BAI',
        ]);
    }

    /**
     * Test chặn phân quyền sai vai trò.
     */
    public function test_xac_nhan_thanh_toan_sai_vai_tro()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT4',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(403);
    }

    /**
     * Test tạo URL thanh toán VNPAY thành công.
     */
    public function testTaoUrlVnpayThanhCong()
    {
        DonDatTour::create([
            'ma_dat_tour' => 'DON_VNPAY_01',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_khach_hang' => 'TEST_KH_TT',
            'ngay_dat' => Carbon::now(),
            'tong_tien' => 3000000.0,
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_VNPAY_01',
            'ma_dat_tour' => 'DON_VNPAY_01',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 3000000.0,
        ]);

        Config::set('vnpay.tmn_code', 'TESTCODE');
        Config::set('vnpay.hash_secret', 'TESTSECRETKEY1234567890123456789');
        Config::set('vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        Config::set('vnpay.return_url', 'http://localhost:3000/return');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->tokenKh,
        ])->postJson('/api/thanh-toan/vnpay/tao-url', [
            'maDatTour' => 'DON_VNPAY_01',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'paymentUrl',
                ],
            ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DON_VNPAY_01',
            'phuong_thuc' => 'VNPAY',
            'trang_thai' => 'CHO_THANH_TOAN',
            'loai_giao_dich' => 'THANH_TOAN',
        ]);
    }

    /**
     * Test callback return VNPAY thành công.
     */
    public function testVnpayReturnThanhCong()
    {
        DonDatTour::create([
            'ma_dat_tour' => 'DON_VNPAY_02',
            'ma_tour_thuc_te' => 'TEST_TTT_TT',
            'ma_khach_hang' => 'TEST_KH_TT',
            'ngay_dat' => Carbon::now(),
            'tong_tien' => 3000000.0,
            'trang_thai' => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_VNPAY_02',
            'ma_dat_tour' => 'DON_VNPAY_02',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 3000000.0,
        ]);

        GiaoDich::create([
            'ma_giao_dich' => 'GD_VNP_02',
            'ma_dat_tour' => 'DON_VNPAY_02',
            'loai_giao_dich' => 'THANH_TOAN',
            'phuong_thuc' => 'VNPAY',
            'so_tien' => 3000000,
            'ma_gdnh' => 'QR_DON_VNPAY_02',
            'trang_thai' => 'CHO_THANH_TOAN',
            'ngay_thanh_toan' => Carbon::now(),
        ]);

        Config::set('vnpay.tmn_code', 'TESTCODE');
        Config::set('vnpay.hash_secret', 'TESTSECRETKEY1234567890123456789');

        $inputData = [
            'vnp_Amount' => 300000000,
            'vnp_BankCode' => 'NCB',
            'vnp_BankTranNo' => 'VNP123456',
            'vnp_CardType' => 'ATM',
            'vnp_OrderInfo' => 'Thanh toan don dat tour DON_VNPAY_02',
            'vnp_PayDate' => date('YmdHis'),
            'vnp_ResponseCode' => '00',
            'vnp_TmnCode' => 'TESTCODE',
            'vnp_TransactionNo' => '12345678',
            'vnp_TransactionStatus' => '00',
            'vnp_TxnRef' => 'GD_VNP_02',
        ];

        ksort($inputData);
        $i = 0;
        $hashData = '';
        foreach ($inputData as $key => $value) {
            if ($i === 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $inputData['vnp_SecureHash'] = hash_hmac('sha512', $hashData, 'TESTSECRETKEY1234567890123456789');

        $response = $this->getJson('/api/thanh-toan/vnpay/return?' . http_build_query($inputData));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_giao_dich' => 'GD_VNP_02',
            'trang_thai' => 'THANH_CONG',
        ]);

        $this->assertDatabaseHas('don_dat_tours', [
            'ma_dat_tour' => 'DON_VNPAY_02',
            'trang_thai' => 'DA_XAC_NHAN',
        ]);
    }

    /**
     * Test callback return VNPAY thất bại khi sai chữ ký.
     */
    public function testVnpayReturnThatBaiSaiChuKy()
    {
        $response = $this->getJson('/api/thanh-toan/vnpay/return?vnp_TxnRef=123&vnp_SecureHash=FAKE');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }
}
