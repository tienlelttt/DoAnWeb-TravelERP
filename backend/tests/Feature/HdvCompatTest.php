<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\VaiTro;
use App\Models\NhanVien;
use App\Models\TourThucTe;
use App\Models\TourMau;
use App\Models\TaiKhoan;
use App\Models\PhanCongTour;
use App\Models\YeuCauHoTro;
use App\Models\QuyetToan;
use App\Models\DonDatTour;
use App\Models\ChiTietDatTour;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class HdvCompatTest extends TestCase
{
    use RefreshDatabase;

    private TaiKhoan $hdvTK;
    private NhanVien $hdv;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        VaiTro::firstOrCreate(['ma_vai_tro' => "HDV"], ['ten_hien_thi' => "Hướng Dẫn Viên"]);
        VaiTro::firstOrCreate(['ma_vai_tro' => "KHACHHANG"], ['ten_hien_thi' => "Khách Hàng"]);

        $this->hdvTK = TaiKhoan::create([
            "ma_tai_khoan" => "TK_HDV_COMPAT",
            "ten_dang_nhap" => "hdv_compat",
            "mat_khau" => bcrypt("password"),
            "ho_ten" => "HDV Compat",
            "vai_tro" => "HDV",
            "trang_thai" => "HOAT_DONG"
        ]);

        $this->hdv = NhanVien::create([
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ma_tai_khoan" => "TK_HDV_COMPAT",
            "loai_nhan_vien" => "HDV",
            "trang_thai_lam_viec" => "DANG_LAM"
        ]);

        $this->token = JWTAuth::fromUser($this->hdvTK);
    }

    public function test_hdv_can_view_profile_and_skills()
    {
        $response1 = $this->getJson("/api/huong-dan-vien/ho-so", ["Authorization" => "Bearer $this->token"]);
        $response1->assertStatus(200);

        $response2 = $this->getJson("/api/huong-dan-vien/nang-luc", ["Authorization" => "Bearer $this->token"]);
        $response2->assertStatus(200);
    }

    public function test_hdv_can_view_assigned_tours()
    {
        $tourMau = TourMau::create([
            "ma_tour_mau" => "TM_COMPAT",
            "tieu_de" => "Tour Compat Title",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_tour_mau" => "TM_COMPAT",
            "ngay_khoi_hanh" => Carbon::now()->addDays(2)->toDateString(),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "MO_BAN"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_COMPAT",
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        $response = $this->getJson("/api/huong-dan-vien/tour-cua-toi", ["Authorization" => "Bearer $this->token"]);
        $response->assertStatus(200)
                 ->assertJsonFragment(["maTourThucTe" => "TTT_COMPAT", "maPhanCong" => "PCT_COMPAT", "tenTour" => "Tour Compat Title"]);
    }

    public function test_hdv_assigned_tours_dem_khach_da_thanh_toan()
    {
        TourMau::create([
            "ma_tour_mau" => "TM_COUNT",
            "tieu_de" => "Tour Count",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_COUNT",
            "ma_tour_mau" => "TM_COUNT",
            "ngay_khoi_hanh" => Carbon::now()->addDays(2)->toDateString(),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 18,
            "trang_thai" => "MO_BAN"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_COUNT",
            "ma_tour_thuc_te" => "TTT_COUNT",
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);

        DonDatTour::create([
            "ma_dat_tour" => "DDT_COUNT",
            "ma_tour_thuc_te" => "TTT_COUNT",
            "ma_khach_hang" => "KH_COUNT",
            "ngay_dat" => Carbon::now(),
            "trang_thai" => "DA_THANH_TOAN",
            "tong_tien" => 2400000
        ]);

        ChiTietDatTour::create([
            "ma_chi_tiet_dat" => "CT_COUNT_1",
            "ma_dat_tour" => "DDT_COUNT",
            "ma_khach_hang" => "KH_COUNT",
            "loai_khach" => "NGUOI_DAT",
            "gia_tai_thoi_diem_dat" => 1200000
        ]);

        ChiTietDatTour::create([
            "ma_chi_tiet_dat" => "CT_COUNT_2",
            "ma_dat_tour" => "DDT_COUNT",
            "ma_nguoi_dong_hanh" => "NDH_COUNT",
            "loai_khach" => "NGUOI_DONG_HANH",
            "gia_tai_thoi_diem_dat" => 1200000
        ]);

        $response = $this->getJson("/api/huong-dan-vien/tour-cua-toi", ["Authorization" => "Bearer $this->token"]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "maTourThucTe" => "TTT_COUNT",
                "soKhachDaXacNhan" => 2,
            ]);
    }

    public function test_hdv_list_giai_trinh_va_quyet_toan_can_bo_sung_co_phan_trang()
    {
        TourMau::create([
            "ma_tour_mau" => "TM_PAGE",
            "tieu_de" => "Tour Page",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_PAGE",
            "ma_tour_mau" => "TM_PAGE",
            "ngay_khoi_hanh" => Carbon::now()->addDays(2)->toDateString(),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 18,
            "trang_thai" => "MO_BAN"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_PAGE",
            "ma_tour_thuc_te" => "TTT_PAGE",
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);

        DonDatTour::create([
            "ma_dat_tour" => "DDT_PAGE",
            "ma_tour_thuc_te" => "TTT_PAGE",
            "ma_khach_hang" => "KH_PAGE",
            "ngay_dat" => Carbon::now(),
            "trang_thai" => "DA_THANH_TOAN",
            "tong_tien" => 2400000
        ]);

        YeuCauHoTro::create([
            'ma_yeu_cau_ho_tro' => 'YCHT_PAGE_1',
            'ma_dat_tour' => 'DDT_PAGE',
            'ma_khach_hang' => 'KH_PAGE',
            'loai_yeu_cau' => 'KHIEU_NAI',
            'noi_dung' => 'Cần HDV giải trình 1',
            'trang_thai' => 'CHO_HDV_GIAI_TRINH',
        ]);

        YeuCauHoTro::create([
            'ma_yeu_cau_ho_tro' => 'YCHT_PAGE_2',
            'ma_dat_tour' => 'DDT_PAGE',
            'ma_khach_hang' => 'KH_PAGE',
            'loai_yeu_cau' => 'KHIEU_NAI',
            'noi_dung' => 'Cần HDV giải trình 2',
            'trang_thai' => 'CHO_HDV_GIAI_TRINH',
        ]);

        QuyetToan::create([
            'ma_quyet_toan' => 'QT_PAGE_1',
            'ma_tour_thuc_te' => 'TTT_PAGE',
            'tong_doanh_thu' => 2400000,
            'tong_chi_phi' => 500000,
            'loi_nhuan' => 1900000,
            'ma_nhan_vien' => 'NV_HDV_COMPAT',
            'ngay_quyet_toan' => now(),
            'trang_thai' => 'NHAP',
            'ghi_chu' => \App\Services\QuyetToanService::YEU_CAU_BO_SUNG_MARKER . ' lần 1',
        ]);

        QuyetToan::create([
            'ma_quyet_toan' => 'QT_PAGE_2',
            'ma_tour_thuc_te' => 'TTT_PAGE',
            'tong_doanh_thu' => 2400000,
            'tong_chi_phi' => 600000,
            'loi_nhuan' => 1800000,
            'ma_nhan_vien' => 'NV_HDV_COMPAT',
            'ngay_quyet_toan' => now(),
            'trang_thai' => 'NHAP',
            'ghi_chu' => \App\Services\QuyetToanService::YEU_CAU_BO_SUNG_MARKER . ' lần 2',
        ]);

        $giaiTrinhResponse = $this->getJson('/api/huong-dan-vien/yeu-cau-giai-trinh?size=1', [
            "Authorization" => "Bearer $this->token"
        ]);

        $giaiTrinhResponse->assertStatus(200)
            ->assertJsonPath('meta.pagination.perPage', 1)
            ->assertJsonPath('meta.pagination.total', 2)
            ->assertJsonCount(1, 'data');

        $quyetToanResponse = $this->getJson('/api/huong-dan-vien/quyet-toan/can-bo-sung?size=1', [
            "Authorization" => "Bearer $this->token"
        ]);

        $quyetToanResponse->assertStatus(200)
            ->assertJsonPath('meta.pagination.perPage', 1)
            ->assertJsonPath('meta.pagination.total', 2)
            ->assertJsonCount(1, 'data');
    }

    public function test_hdv_can_accept_and_reject_assignment()
    {
        $tourMau = TourMau::create([
            "ma_tour_mau" => "TM_COMPAT",
            "tieu_de" => "Tour Compat Title",
            "thoi_luong" => 3,
            "gia_san" => 1000000
        ]);

        $tourThucTe = TourThucTe::create([
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_tour_mau" => "TM_COMPAT",
            "ngay_khoi_hanh" => Carbon::now()->addDays(2)->toDateString(),
            "gia_hien_hanh" => 1200000,
            "so_khach_toi_da" => 20,
            "so_khach_toi_thieu" => 10,
            "cho_con_lai" => 20,
            "trang_thai" => "CHO_KICH_HOAT"
        ]);

        PhanCongTour::create([
            "ma_phan_cong_tour" => "PCT_COMPAT",
            "ma_tour_thuc_te" => "TTT_COMPAT",
            "ma_nhan_vien" => "NV_HDV_COMPAT",
            "ngay_phan_cong" => Carbon::now(),
            "trang_thai_chap_nhan" => "CHO_PHAN_HOI"
        ]);

        // Accept
        $response1 = $this->postJson("/api/huong-dan-vien/phan-cong/PCT_COMPAT/dong-y", [], ["Authorization" => "Bearer $this->token"]);
        $response1->assertStatus(200);
        $this->assertDatabaseHas("phan_cong_tours", [
            "ma_phan_cong_tour" => "PCT_COMPAT",
            "trang_thai_chap_nhan" => "DA_DONG_Y"
        ]);
    }
}
