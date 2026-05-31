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

        // 1. Táº¡o tÃ i khoáº£n khÃ¡ch hÃ ng
        $this->tkKh = TaiKhoan::create([
            'ma_tai_khoan'   => 'TEST_TK_TT_KH',
            'ten_dang_nhap'  => 'test_tt_khach',
            'mat_khau'      => bcrypt('123456'),
            'ho_ten'        => 'KhÃ¡ch HÃ ng Thanh ToÃ¡n',
            'email'        => 'tt_khach_' . time() . '@test.com',
            'so_dien_thoai'  => '0987555666',
            'vai_tro'       => 'KHACHHANG',
            'trang_thai'    => 'HOAT_DONG',
            'ngay_sinh'     => '1990-01-01',
        ]);

        $this->hcs = HoChieuSo::create([
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ma_tai_khoan'    => 'TEST_TK_TT_KH',
            'hang_thanh_vien' => 'THANH_VIEN',
            'diem_xanh'      => 0,
        ]);

        $this->tokenKh = JWTAuth::fromUser($this->tkKh);

        // 2. Táº¡o tÃ i khoáº£n Sales (Kinh Doanh)
        $this->tkKd = TaiKhoan::create([
            'ma_tai_khoan'   => 'TEST_TK_TT_KD',
            'ten_dang_nhap'  => 'test_tt_sales',
            'mat_khau'      => bcrypt('123456'),
            'ho_ten'        => 'NhÃ¢n ViÃªn Sales',
            'email'        => 'tt_sales_' . time() . '@test.com',
            'so_dien_thoai'  => '0987666777',
            'vai_tro'       => 'KINHDOANH',
            'trang_thai'    => 'HOAT_DONG',
            'ngay_sinh'     => '1985-05-05',
        ]);

        $this->tokenKd = JWTAuth::fromUser($this->tkKd);

        // 3. Táº¡o Tour Máº«u vÃ  Tour Thá»±c Táº¿
        TourMau::create([
            'ma_tour_mau' => 'TEST_TM_TT',
            'tieu_de'    => 'Tour Test Thanh ToÃ¡n',
            'thoi_luong' => 3,
            'gia_san'    => 1000000,
        ]);

        $this->tourThucTe = TourThucTe::create([
            'ma_tour_thuc_te'   => 'TEST_TTT_TT',
            'ma_tour_mau'      => 'TEST_TM_TT',
            'ngay_khoi_hanh'   => Carbon::now()->addDays(10)->format('Y-m-d'),
            'gia_hien_hanh'    => 2000000,
            'so_khach_toi_thieu'=> 2,
            'so_khach_toi_da'   => 20,
            'cho_con_lai'      => 10,
            'trang_thai'      => 'MO_BAN',
        ]);
    }

    /**
     * Test Thanh toÃ¡n trá»±c tuyáº¿n Mock thÃ nh cÃ´ng
     */
    public function test_thanh_toan_mock_thanh_cong()
    {
        // 1. Táº¡o Ä‘Æ¡n Ä‘áº·t tour á»Ÿ tráº¡ng thÃ¡i CHO_XAC_NHAN
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_TEST_TT1',
            'ma_tour_thuc_te'  => 'TEST_TTT_TT',
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
        ]);

        // Táº¡o chi tiáº¿t Ä‘áº·t cá»§a ngÆ°á»i Ä‘áº·t Ä‘á»ƒ lÆ°u lá»‹ch sá»­ tour
        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_TEST_TT1',
            'ma_dat_tour' => 'DDT_TEST_TT1',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        // 2. KhÃ¡ch hÃ ng gá»i API thanh toÃ¡n mock
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/thanh-toan/mock', [
                'maDatTour' => 'DDT_TEST_TT1',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        // 3. Kiá»ƒm tra DB
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
     * Test KhÃ¡ch bÃ¡o chuyá»ƒn khoáº£n thÃ nh cÃ´ng
     */
    public function test_bao_chuyen_khoan_thanh_cong()
    {
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_TEST_TT2',
            'ma_tour_thuc_te'  => 'TEST_TTT_TT',
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
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
     * Test Sales duyá»‡t chuyá»ƒn khoáº£n thÃ nh cÃ´ng (Äá»“ng Ã½)
     */
    public function test_sales_xac_nhan_thanh_toan_dong_y()
    {
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_TEST_TT3',
            'ma_tour_thuc_te'  => 'TEST_TTT_TT',
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
        ]);

        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_TEST_TT3',
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 2000000.0,
        ]);

        // Táº¡o sáºµn giao dá»‹ch KHXN:
        GiaoDich::create([
            'ma_giao_dich' => 'GD_TEST_TT3',
            'ma_dat_tour' => 'DDT_TEST_TT3',
            'loai_giao_dich' => 'THANH_TOAN',
            'phuong_thuc' => 'CHUYEN_KHOAN',
            'so_tien' => 2000000.0,
            'ma_gdnh' => 'KHXN:FT12345',
            'trang_thai' => 'CHO_THANH_TOAN',
        ]);

        // Sales gá»i API xÃ¡c nháº­n
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
     * Test Sales tá»« chá»‘i chuyá»ƒn khoáº£n
     */
    public function test_sales_xac_nhan_thanh_toan_tu_choi()
    {
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DDT_TEST_TT4',
            'ma_tour_thuc_te'  => 'TEST_TTT_TT',
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 2000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
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
            'trang_thai' => 'CHO_XAC_NHAN', // Váº«n chá» xÃ¡c nháº­n
        ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DDT_TEST_TT4',
            'trang_thai' => 'THAT_BAI',
        ]);
    }

    /**
     * Test cháº·n phÃ¢n quyá»n sai vai trÃ²
     */
    public function test_xac_nhan_thanh_toan_sai_vai_tro()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh) // Gá»i báº±ng token KhÃ¡ch hÃ ng
            ->postJson('/api/kinh-doanh/xac-nhan-thanh-toan', [
                'maDatTour' => 'DDT_TEST_TT4',
                'trangThai' => 'DONG_Y',
            ]);

        $response->assertStatus(403);
    }
    // ==========================================
    // VNPAY TESTS
    // ==========================================
    public function testTaoUrlVnpayThanhCong()
    {
        // Mock DonDatTour
        $don = DonDatTour::create([
            'ma_dat_tour'     => 'DON_VNPAY_01',
            'ma_tour_thuc_te'  => 'TEST_TTT_TT',
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 3000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
        ]);
        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_VNPAY_01',
            'ma_dat_tour' => 'DON_VNPAY_01',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 3000000.0,
        ]);

        \Illuminate\Support\Facades\Config::set('vnpay.tmn_code', 'TESTCODE');
        \Illuminate\Support\Facades\Config::set('vnpay.hash_secret', 'TESTSECRETKEY1234567890123456789');
        \Illuminate\Support\Facades\Config::set('vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        \Illuminate\Support\Facades\Config::set('vnpay.return_url', 'http://localhost:3000/return');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->tokenKh,
        ])->postJson('/api/thanh-toan/vnpay/tao-url', [
            'maDatTour' => 'DON_VNPAY_01'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'paymentUrl'
                     ]
                 ]);

        $this->assertDatabaseHas('giao_diches', [
            'ma_dat_tour' => 'DON_VNPAY_01',
            'phuong_thuc' => 'VNPAY',
            'trang_thai' => 'CHO_THANH_TOAN',
            'loai_giao_dich' => 'THANH_TOAN'
        ]);
    }

    public function testVnpayReturnThanhCong()
    {
        // Setup DonDatTour
        DonDatTour::create([
            'ma_dat_tour'     => 'DON_VNPAY_02',
            'ma_tour_thuc_te'  => 'TEST_TTT_TT',
            'ma_khach_hang'   => 'TEST_KH_TT',
            'ngay_dat'       => Carbon::now(),
            'tong_tien'      => 3000000.0,
            'trang_thai'     => 'CHO_XAC_NHAN',
        ]);
        ChiTietDatTour::create([
            'ma_chi_tiet_dat' => 'CTD_VNPAY_02',
            'ma_dat_tour' => 'DON_VNPAY_02',
            'ma_khach_hang' => 'TEST_KH_TT',
            'loai_khach' => 'NGUOI_DAT',
            'gia_tai_thoi_diem_dat' => 3000000.0,
        ]);

        // Setup GiaoDich
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

        \Illuminate\Support\Facades\Config::set('vnpay.tmn_code', 'TESTCODE');
        \Illuminate\Support\Facades\Config::set('vnpay.hash_secret', 'TESTSECRETKEY1234567890123456789');

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
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $vnp_SecureHash = hash_hmac('sha512', $hashData, 'TESTSECRETKEY1234567890123456789');
        $inputData['vnp_SecureHash'] = $vnp_SecureHash;

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
            'trang_thai' => 'DA_XAC_NHAN'
        ]);
    }

    public function testVnpayReturnThatBaiSaiChuKy()
    {
        $response = $this->getJson('/api/thanh-toan/vnpay/return?vnp_TxnRef=123&vnp_SecureHash=FAKE');

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                 ]);
    }
}
