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
        $tkHdv = TaiKhoan::create(['MaTaiKhoan' => 'TK_HDV_01', 'TenDangNhap' => 'hdv_01', 'MatKhau' => bcrypt('123456'), 'HoTen' => 'HDV', 'VaiTro' => 'HDV', 'TrangThai' => 'HOAT_DONG']);
        $tkDieuHanh = TaiKhoan::create(['MaTaiKhoan' => 'TK_DH_01', 'TenDangNhap' => 'dh_01', 'MatKhau' => bcrypt('123456'), 'HoTen' => 'Điều Hành', 'VaiTro' => 'DIEUHANH', 'TrangThai' => 'HOAT_DONG']);
        $tkKinhDoanh = TaiKhoan::create(['MaTaiKhoan' => 'TK_KD_01', 'TenDangNhap' => 'kd_01', 'MatKhau' => bcrypt('123456'), 'HoTen' => 'Kinh Doanh', 'VaiTro' => 'KINHDOANH', 'TrangThai' => 'HOAT_DONG']);
        $tkKeToan = TaiKhoan::create(['MaTaiKhoan' => 'TK_KT_01', 'TenDangNhap' => 'kt_01', 'MatKhau' => bcrypt('123456'), 'HoTen' => 'Kế Toán', 'VaiTro' => 'KETOAN', 'TrangThai' => 'HOAT_DONG']);

        $this->nhanVienHdv = NhanVien::create(['MaNhanVien' => 'NV_HDV_01', 'MaTaiKhoan' => 'TK_HDV_01', 'TrangThaiLamViec' => 'DANG_LAM']);
        $this->nhanVienDieuHanh = NhanVien::create(['MaNhanVien' => 'NV_DH_01', 'MaTaiKhoan' => 'TK_DH_01', 'TrangThaiLamViec' => 'DANG_LAM']);
        NhanVien::create(['MaNhanVien' => 'NV_KD_01', 'MaTaiKhoan' => 'TK_KD_01', 'TrangThaiLamViec' => 'DANG_LAM']);
        NhanVien::create(['MaNhanVien' => 'NV_KT_01', 'MaTaiKhoan' => 'TK_KT_01', 'TrangThaiLamViec' => 'DANG_LAM']);

        // 2. Tạo Năng lực
        NangLucNhanVien::create([
            'MaNangLucNhanVien' => 'NL_HDV_01',
            'MaNhanVien' => 'NV_HDV_01',
            'NgonNgu' => 'Tiếng Anh',
            'ChungChi' => 'HDV',
            'DanhGia' => 4.8,
            'SoDanhGia' => 150
        ]);

        // 3. Tạo dữ liệu Lịch công tác
        TourMau::create(['MaTourMau' => 'TM_NV_TEST', 'TieuDe' => 'Tour NV', 'ThoiLuong' => 3, 'GiaSan' => 1000]);
        TourThucTe::create(['MaTourThucTe' => 'TTT_NV_TEST', 'MaTourMau' => 'TM_NV_TEST', 'NgayKhoiHanh' => now()->addDays(5)->toDateString(), 'GiaHienHanh' => 1500, 'SoKhachToiDa' => 20, 'SoKhachToiThieu' => 5, 'ChoConLai' => 20, 'TrangThai' => 'MO_BAN']);
        
        PhanCongTour::create([
            'MaPhanCongTour' => 'PC_HDV_01',
            'MaTourThucTe' => 'TTT_NV_TEST',
            'MaNhanVien' => 'NV_HDV_01',
            'NgayPhanCong' => now(),
            'TrangThaiChapNhan' => 'DA_DONG_Y'
        ]);

        PhanCongTour::create([
            'MaPhanCongTour' => 'PC_DH_01',
            'MaTourThucTe' => 'TTT_NV_TEST',
            'MaNhanVien' => 'NV_DH_01',
            'NgayPhanCong' => now(),
            'TrangThaiChapNhan' => 'DA_DONG_Y'
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
