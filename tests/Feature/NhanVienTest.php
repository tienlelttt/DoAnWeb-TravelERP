<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\TaiKhoan;
use App\Models\NhanVien;
use App\Models\NangLucNhanVien;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\PhanCongTour;
use Tymon\JWTAuth\Facades\JWTAuth;

class NhanVienTest extends TestCase
{
    use DatabaseTransactions;

    protected $tokenHdv, $tokenDieuHanh, $tokenKinhDoanh, $tokenKeToan;
    protected $nhanVienHdv, $nhanVienDieuHanh;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Tạo Tài khoản và Nhân viên
        $tkHdv = TaiKhoan::create(['ma_tai_khoan' => 'TK_HDV_01', 'ten_dang_nhap' => 'hdv_01', 'mat_khau' => bcrypt('123456'), 'ho_ten' => 'HDV', 'vai_tro' => 'HDV', 'trang_thai' => 'HOAT_DONG']);
        $tkDieuHanh = TaiKhoan::create(['ma_tai_khoan' => 'TK_DH_01', 'ten_dang_nhap' => 'dh_01', 'mat_khau' => bcrypt('123456'), 'ho_ten' => 'Điều Hành', 'vai_tro' => 'DIEUHANH', 'trang_thai' => 'HOAT_DONG']);
        $tkKinhDoanh = TaiKhoan::create(['ma_tai_khoan' => 'TK_KD_01', 'ten_dang_nhap' => 'kd_01', 'mat_khau' => bcrypt('123456'), 'ho_ten' => 'Kinh Doanh', 'vai_tro' => 'KINHDOANH', 'trang_thai' => 'HOAT_DONG']);
        $tkKeToan = TaiKhoan::create(['ma_tai_khoan' => 'TK_KT_01', 'ten_dang_nhap' => 'kt_01', 'mat_khau' => bcrypt('123456'), 'ho_ten' => 'Kế Toán', 'vai_tro' => 'KETOAN', 'trang_thai' => 'HOAT_DONG']);

        $this->nhanVienHdv = NhanVien::create(['ma_nhan_vien' => 'NV_HDV_01', 'ma_tai_khoan' => 'TK_HDV_01', 'trang_thai_lam_viec' => 'DANG_LAM']);
        $this->nhanVienDieuHanh = NhanVien::create(['ma_nhan_vien' => 'NV_DH_01', 'ma_tai_khoan' => 'TK_DH_01', 'trang_thai_lam_viec' => 'DANG_LAM']);
        NhanVien::create(['ma_nhan_vien' => 'NV_KD_01', 'ma_tai_khoan' => 'TK_KD_01', 'trang_thai_lam_viec' => 'DANG_LAM']);
        NhanVien::create(['ma_nhan_vien' => 'NV_KT_01', 'ma_tai_khoan' => 'TK_KT_01', 'trang_thai_lam_viec' => 'DANG_LAM']);

        // 2. Tạo Năng lực
        NangLucNhanVien::create([
            'ma_nang_luc_nhan_vien' => 'NL_HDV_01',
            'ma_nhan_vien' => 'NV_HDV_01',
            'ngon_ngu' => 'Tiếng Anh',
            'chung_chi' => 'HDV',
            'danh_gia' => 4.8,
            'so_danh_gia' => 150
        ]);

        // 3. Tạo dữ liệu Lịch công tác
        TourMau::create(['ma_tour_mau' => 'TM_NV_TEST', 'tieu_de' => 'Tour NV', 'thoi_luong' => 3, 'gia_san' => 1000]);
        TourThucTe::create(['ma_tour_thuc_te' => 'TTT_NV_TEST', 'ma_tour_mau' => 'TM_NV_TEST', 'ngay_khoi_hanh' => now()->addDays(5)->toDateString(), 'gia_hien_hanh' => 1500, 'so_khach_toi_da' => 20, 'so_khach_toi_thieu' => 5, 'cho_con_lai' => 20, 'trang_thai' => 'MO_BAN']);
        
        PhanCongTour::create([
            'ma_phan_cong_tour' => 'PC_HDV_01',
            'ma_tour_thuc_te' => 'TTT_NV_TEST',
            'ma_nhan_vien' => 'NV_HDV_01',
            'ngay_phan_cong' => now(),
            'trang_thai_chap_nhan' => 'DA_DONG_Y'
        ]);

        PhanCongTour::create([
            'ma_phan_cong_tour' => 'PC_DH_01',
            'ma_tour_thuc_te' => 'TTT_NV_TEST',
            'ma_nhan_vien' => 'NV_DH_01',
            'ngay_phan_cong' => now(),
            'trang_thai_chap_nhan' => 'DA_DONG_Y'
        ]);

        // Lấy Token
        $this->tokenHdv = JWTAuth::fromUser($tkHdv);
        $this->tokenDieuHanh = JWTAuth::fromUser($tkDieuHanh);
        $this->tokenKinhDoanh = JWTAuth::fromUser($tkKinhDoanh);
        $this->tokenKeToan = JWTAuth::fromUser($tkKeToan);
    }

    public function test_tat_ca_nhan_vien_xem_ho_so_thanh_cong()
    {
        $tokens = [$this->tokenHdv, $this->tokenDieuHanh, $this->tokenKinhDoanh, $this->tokenKeToan];
        
        foreach ($tokens as $token) {
            $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/nhan-vien/ho-so');
            $response->assertStatus(200)->assertJsonStructure(['success', 'data' => ['maNhanVien', 'taiKhoan']]);
        }
    }

    public function test_lay_lich_cong_tac_hdv()
    {
        $responseHdv = $this->withHeader('Authorization', "Bearer {$this->tokenHdv}")->getJson('/api/nhan-vien/lich-cong-tac');
        $responseHdv->assertStatus(200);
        $responseHdv->assertJsonFragment(['maPhanCong' => 'PC_HDV_01']);
    }

    public function test_lay_lich_cong_tac_dh()
    {
        $responseDh = $this->withHeader('Authorization', "Bearer {$this->tokenDieuHanh}")->getJson('/api/nhan-vien/lich-cong-tac');
        $responseDh->assertStatus(200);
        $responseDh->assertJsonFragment(['maPhanCong' => 'PC_DH_01']);
    }

    public function test_lay_nang_luc_hdv()
    {
        $responseHdv = $this->withHeader('Authorization', "Bearer {$this->tokenHdv}")->getJson('/api/nhan-vien/nang-luc');
        $responseHdv->assertStatus(200);
        $responseHdv->assertJsonFragment([
            'maNangLuc' => 'NL_HDV_01',
            'ngonNgu' => 'Tiếng Anh',
        ]);
    }

    public function test_lay_nang_luc_dh()
    {
        $responseDh = $this->withHeader('Authorization', "Bearer {$this->tokenDieuHanh}")->getJson('/api/nhan-vien/nang-luc');
        $responseDh->assertStatus(200);
        $responseDh->assertJson(['data' => null]);
    }
}
