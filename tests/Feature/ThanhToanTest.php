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
            'MaTaiKhoan'   => 'TEST_TK_TT_KH',
            'TenDangNhap'  => 'test_tt_khach',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'KhÃ¡ch HÃ ng Thanh ToÃ¡n',
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

        // 2. Táº¡o tÃ i khoáº£n Sales (Kinh Doanh)
        $this->tkKd = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_TT_KD',
            'TenDangNhap'  => 'test_tt_sales',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'NhÃ¢n ViÃªn Sales',
            'Email'        => 'tt_sales_' . time() . '@test.com',
            'SoDienThoai'  => '0987666777',
            'VaiTro'       => 'KINHDOANH',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1985-05-05',
        ]);

        $this->tokenKd = JWTAuth::fromUser($this->tkKd);

        // 3. Táº¡o Tour Máº«u vÃ  Tour Thá»±c Táº¿
        TourMau::create([
            'MaTourMau' => 'TEST_TM_TT',
            'TieuDe'    => 'Tour Test Thanh ToÃ¡n',
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
     * Test Thanh toÃ¡n trá»±c tuyáº¿n Mock thÃ nh cÃ´ng
     */
    public function test_thanh_toan_mock_thanh_cong()
    {
        // 1. Táº¡o Ä‘Æ¡n Ä‘áº·t tour á»Ÿ tráº¡ng thÃ¡i CHO_XAC_NHAN
        $don = DonDatTour::create([
            'MaDatTour'     => 'DDT_TEST_TT1',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 2000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);

        // Táº¡o chi tiáº¿t Ä‘áº·t cá»§a ngÆ°á»i Ä‘áº·t Ä‘á»ƒ lÆ°u lá»‹ch sá»­ tour
        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_TEST_TT1',
            'MaDatTour' => 'DDT_TEST_TT1',
            'MaKhachHang' => 'TEST_KH_TT',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 2000000.0,
        ]);

        // 2. KhÃ¡ch hÃ ng gá»i API thanh toÃ¡n mock
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->tokenKh)
            ->postJson('/api/thanh-toan/mock', [
                'maDatTour' => 'DDT_TEST_TT1',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.trangThai', 'DA_XAC_NHAN');

        // 3. Kiá»ƒm tra DB
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
     * Test KhÃ¡ch bÃ¡o chuyá»ƒn khoáº£n thÃ nh cÃ´ng
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
     * Test Sales duyá»‡t chuyá»ƒn khoáº£n thÃ nh cÃ´ng (Äá»“ng Ã½)
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

        // Táº¡o sáºµn giao dá»‹ch KHXN:
        GiaoDich::create([
            'MaGiaoDich' => 'GD_TEST_TT3',
            'MaDatTour' => 'DDT_TEST_TT3',
            'LoaiGiaoDich' => 'THANH_TOAN',
            'PhuongThuc' => 'CHUYEN_KHOAN',
            'SoTien' => 2000000.0,
            'MaGDNH' => 'KHXN:FT12345',
            'TrangThai' => 'CHO_THANH_TOAN',
        ]);

        // Sales gá»i API xÃ¡c nháº­n
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
     * Test Sales tá»« chá»‘i chuyá»ƒn khoáº£n
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
            'TrangThai' => 'CHO_XAC_NHAN', // Váº«n chá» xÃ¡c nháº­n
        ]);

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DDT_TEST_TT4',
            'TrangThai' => 'THAT_BAI',
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
            'MaDatTour'     => 'DON_VNPAY_01',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 3000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);
        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_VNPAY_01',
            'MaDatTour' => 'DON_VNPAY_01',
            'MaKhachHang' => 'TEST_KH_TT',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 3000000.0,
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

        $this->assertDatabaseHas('GIAODICH', [
            'MaDatTour' => 'DON_VNPAY_01',
            'PhuongThuc' => 'VNPAY',
            'TrangThai' => 'CHO_THANH_TOAN',
            'LoaiGiaoDich' => 'THANH_TOAN'
        ]);
    }

    public function testVnpayReturnThanhCong()
    {
        // Setup DonDatTour
        DonDatTour::create([
            'MaDatTour'     => 'DON_VNPAY_02',
            'MaTourThucTe'  => 'TEST_TTT_TT',
            'MaKhachHang'   => 'TEST_KH_TT',
            'NgayDat'       => Carbon::now(),
            'TongTien'      => 3000000.0,
            'TrangThai'     => 'CHO_XAC_NHAN',
        ]);
        ChiTietDatTour::create([
            'MaChiTietDat' => 'CTD_VNPAY_02',
            'MaDatTour' => 'DON_VNPAY_02',
            'MaKhachHang' => 'TEST_KH_TT',
            'LoaiKhach' => 'NGUOI_DAT',
            'GiaTaiThoiDiemDat' => 3000000.0,
        ]);

        // Setup GiaoDich
        GiaoDich::create([
            'MaGiaoDich' => 'GD_VNP_02',
            'MaDatTour' => 'DON_VNPAY_02',
            'LoaiGiaoDich' => 'THANH_TOAN',
            'PhuongThuc' => 'VNPAY',
            'SoTien' => 3000000,
            'MaGDNH' => 'QR_DON_VNPAY_02',
            'TrangThai' => 'CHO_THANH_TOAN',
            'NgayThanhToan' => Carbon::now(),
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

        $this->assertDatabaseHas('GIAODICH', [
            'MaGiaoDich' => 'GD_VNP_02',
            'TrangThai' => 'THANH_CONG',
        ]);
        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => 'DON_VNPAY_02',
            'TrangThai' => 'DA_XAC_NHAN'
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
