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
            'ma_tai_khoan'   => 'TEST_TK_KH_DG',
            'ten_dang_nhap'  => 'test_kh_dg',
            'mat_khau'      => bcrypt('123456'),
            'ho_ten'        => 'Khách Đánh Giá',
            'email'        => 'kh_dg_' . time() . '@test.com',
            'so_dien_thoai'  => '0987654321',
            'vai_tro'       => 'KHACHHANG',
            'trang_thai'    => 'HOAT_DONG',
        ]);

        // HOCHIEUSO: HangThanhVien (NOT NULL), DiemXanh (NOT NULL)
        $this->hcs = HoChieuSo::create([
            'ma_khach_hang'   => 'TEST_KH_DG',
            'ma_tai_khoan'    => 'TEST_TK_KH_DG',
            'hang_thanh_vien' => 'THANH_VIEN',
            'diem_xanh'      => 0,
        ]);

        $this->token = JWTAuth::fromUser($tkKh);

        // TOURMAU
        $this->tourMau = TourMau::create([
            'ma_tour_mau' => 'TEST_TM_DG',
            'tieu_de'    => 'Tour Test Đánh Giá',
            'thoi_luong' => 3,
            'gia_san'    => 1000000,
        ]);

        // TOURTHUCTE: trạng thái KET_THUC để cho phép đánh giá
        $this->tourThucTe = TourThucTe::create([
            'ma_tour_thuc_te'    => 'TEST_TTT_DG',
            'ma_tour_mau'       => 'TEST_TM_DG',
            'ngay_khoi_hanh'    => Carbon::now()->subDays(5)->format('Y-m-d'),
            'gia_hien_hanh'     => 1200000,
            'so_khach_toi_thieu' => 2,
            'so_khach_toi_da'    => 20,
            'cho_con_lai'       => 10,
            'trang_thai'       => 'KET_THUC',
        ]);

        // DONDATTOUR để phục vụ test khiếu nại
        // NgayDat (NOT NULL), TongTien (NOT NULL), TrangThai (NOT NULL)
        $this->donDatTour = DonDatTour::create([
            'ma_dat_tour'   => 'TEST_DDT_DG',
            'ma_tour_thuc_te'=> 'TEST_TTT_DG',
            'ma_khach_hang' => 'TEST_KH_DG',
            'tong_tien'    => 1200000,
            'trang_thai'   => 'DA_XAC_NHAN',
            'ngay_dat'     => Carbon::now(),
        ]);
    }

    /** Khách đã tham gia tour (có LichSuTour) -> đánh giá thành công */
    public function test_khach_hang_danh_gia_thanh_cong()
    {
        // LICHSUTOUR cần MaLichSuTour (PK), MaKhachHang (FK), MaTourThucTe (FK)
        LichSuTour::create([
            'ma_lich_su_tour'  => 'TEST_LST_DG',
            'ma_khach_hang'   => 'TEST_KH_DG',
            'ma_tour_thuc_te'  => 'TEST_TTT_DG',
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
        $this->assertDatabaseHas('tour_maus', [
            'ma_tour_mau' => 'TEST_TM_DG',
            'so_danh_gia' => 1,
        ]);
    }

    /** Tour chưa kết thúc -> không được đánh giá */
    public function test_khong_the_danh_gia_tour_chua_ket_thuc()
    {
        $this->tourThucTe->update(['trang_thai' => 'MO_BAN']);

        LichSuTour::create([
            'ma_lich_su_tour'  => 'TEST_LST_DG_2',
            'ma_khach_hang'   => 'TEST_KH_DG',
            'ma_tour_thuc_te'  => 'TEST_TTT_DG',
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
            'ma_lich_su_tour'  => 'TEST_LST_DG_3',
            'ma_khach_hang'   => 'TEST_KH_DG',
            'ma_tour_thuc_te'  => 'TEST_TTT_DG',
        ]);

        // TrangThai hop le: CHUA_XU_LY | CHO_BO_SUNG | CHO_GIAI_TRINH | CHO_DUYET | DA_XU_LY | TU_CHOI
        // YEUCAUHOTRO: NoiDung (NOT NULL CLOB), LoaiYeuCau (NOT NULL), TrangThai (NOT NULL), MaKhachHang (FK NOT NULL)
        YeuCauHoTro::create([
            'ma_yeu_cau_ho_tro' => 'TEST_YC_DG',
            'ma_dat_tour'     => 'TEST_DDT_DG',
            'ma_khach_hang'   => 'TEST_KH_DG',
            'loai_yeu_cau'    => 'KHIEU_NAI',
            'noi_dung'       => 'Tour quá tệ',
            'trang_thai'     => 'CHUA_XU_LY',
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
