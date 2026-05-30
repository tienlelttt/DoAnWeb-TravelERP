<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\TaiKhoan;
use App\Models\HoChieuSo;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\LichSuTour;
use App\Models\YeuCauHoTro;
use App\Models\DonDatTour;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class DanhGiaTest extends TestCase
{
    use DatabaseTransactions;

    protected $token;
    protected $tourMau;
    protected $tourThucTe;
    protected $hcs;
    protected $donDatTour;

    protected function setUp(): void
    {
        parent::setUp();

        // TAIKHOAN: TenDangNhap (NOT NULL), HoTen (NOT NULL), MatKhau (NOT NULL), TrangThai (NOT NULL)
        $tkKh = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_KH_DG',
            'TenDangNhap'  => 'test_kh_dg',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Khách Đánh Giá',
            'Email'        => 'kh_dg_' . time() . '@test.com',
            'SoDienThoai'  => '0987654321',
            'VaiTro'       => 'KHACHHANG',
            'TrangThai'    => 'HOAT_DONG',
        ]);

        // HOCHIEUSO: HangThanhVien (NOT NULL), DiemXanh (NOT NULL)
        $this->hcs = HoChieuSo::create([
            'MaKhachHang'   => 'TEST_KH_DG',
            'MaTaiKhoan'    => 'TEST_TK_KH_DG',
            'HangThanhVien' => 'THANH_VIEN',
            'DiemXanh'      => 0,
        ]);

        $this->token = JWTAuth::fromUser($tkKh);

        // TOURMAU
        $this->tourMau = TourMau::create([
            'MaTourMau' => 'TEST_TM_DG',
            'TieuDe'    => 'Tour Test Đánh Giá',
            'ThoiLuong' => 3,
            'GiaSan'    => 1000000,
        ]);

        // TOURTHUCTE: trạng thái KET_THUC để cho phép đánh giá
        $this->tourThucTe = TourThucTe::create([
            'MaTourThucTe'    => 'TEST_TTT_DG',
            'MaTourMau'       => 'TEST_TM_DG',
            'NgayKhoiHanh'    => Carbon::now()->subDays(5)->format('Y-m-d'),
            'GiaHienHanh'     => 1200000,
            'SoKhachToiThieu' => 2,
            'SoKhachToiDa'    => 20,
            'ChoConLai'       => 10,
            'TrangThai'       => 'KET_THUC',
        ]);

        // DONDATTOUR để phục vụ test khiếu nại
        // NgayDat (NOT NULL), TongTien (NOT NULL), TrangThai (NOT NULL)
        $this->donDatTour = DonDatTour::create([
            'MaDatTour'   => 'TEST_DDT_DG',
            'MaTourThucTe'=> 'TEST_TTT_DG',
            'MaKhachHang' => 'TEST_KH_DG',
            'TongTien'    => 1200000,
            'TrangThai'   => 'DA_XAC_NHAN',
            'NgayDat'     => Carbon::now(),
        ]);
    }

    /** Khách đã tham gia tour (có LichSuTour) -> đánh giá thành công */
    public function test_khach_hang_danh_gia_thanh_cong()
    {
        // LICHSUTOUR cần MaLichSuTour (PK), MaKhachHang (FK), MaTourThucTe (FK)
        LichSuTour::create([
            'MaLichSuTour'  => 'TEST_LST_DG',
            'MaKhachHang'   => 'TEST_KH_DG',
            'MaTourThucTe'  => 'TEST_TTT_DG',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/danh-gia', [
                'maTourThucTe' => 'TEST_TTT_DG',
                'soSao'        => 5,
                'nhanXet'      => 'Tour tuyệt vời quá!',
            ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.soSao', 5);
        $response->assertJsonPath('data.nhanXet', 'Tour tuyệt vời quá!');

        // Điểm trung bình TourMau phải được cập nhật
        $this->assertDatabaseHas('TOURMAU', [
            'MaTourMau' => 'TEST_TM_DG',
            'SoDanhGia' => 1,
        ]);
    }

    /** Tour chưa kết thúc -> không được đánh giá */
    public function test_khong_the_danh_gia_tour_chua_ket_thuc()
    {
        $this->tourThucTe->update(['TrangThai' => 'MO_BAN']);

        LichSuTour::create([
            'MaLichSuTour'  => 'TEST_LST_DG_2',
            'MaKhachHang'   => 'TEST_KH_DG',
            'MaTourThucTe'  => 'TEST_TTT_DG',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/danh-gia', [
                'maTourThucTe' => 'TEST_TTT_DG',
                'soSao'        => 4,
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Chỉ có thể đánh giá tour đã kết thúc');
    }

    /** Chưa tham gia tour -> không được đánh giá */
    public function test_khong_the_danh_gia_neu_chua_tham_gia_tour()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/danh-gia', [
                'maTourThucTe' => 'TEST_TTT_DG',
                'soSao'        => 5,
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Bạn chưa tham gia tour này nên không thể đánh giá');
    }

    /** Còn khiếu nại chưa xử lý -> không được đánh giá */
    public function test_khong_the_danh_gia_neu_co_khieu_nai_chua_xu_ly()
    {
        LichSuTour::create([
            'MaLichSuTour'  => 'TEST_LST_DG_3',
            'MaKhachHang'   => 'TEST_KH_DG',
            'MaTourThucTe'  => 'TEST_TTT_DG',
        ]);

        // TrangThai hợp lệ theo Java entity: CHUA_XU_LY | CHO_BO_SUNG | CHO_GIAI_TRINH | CHO_DUYET | DA_XU_LY | TU_CHOI
        // YEUCAUHOTRO: NoiDung (NOT NULL CLOB), LoaiYeuCau (NOT NULL), TrangThai (NOT NULL), MaKhachHang (FK NOT NULL)
        YeuCauHoTro::create([
            'MaYeuCauHoTro' => 'TEST_YC_DG',
            'MaDatTour'     => 'TEST_DDT_DG',
            'MaKhachHang'   => 'TEST_KH_DG',
            'LoaiYeuCau'    => 'KHIEU_NAI',
            'NoiDung'       => 'Tour quá tệ',
            'TrangThai'     => 'CHUA_XU_LY', // Đúng theo Java entity
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/danh-gia', [
                'maTourThucTe' => 'TEST_TTT_DG',
                'soSao'        => 1,
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Khiếu nại của tour này chưa được giải quyết, vui lòng chờ xử lý trước khi đánh giá');
    }
}
