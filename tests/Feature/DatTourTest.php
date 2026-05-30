<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\TaiKhoan;
use App\Models\HoChieuSo;
use App\Models\TourMau;
use App\Models\TourThucTe;
use App\Models\DichVuThem;
use App\Models\HanhDongXanh;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class DatTourTest extends TestCase
{
    use DatabaseTransactions;

    protected $token;
    protected $tourThucTe;
    protected $dichVuThem;
    protected $hanhDongXanh;
    protected $hcs;
    protected $tkKh;

    protected function setUp(): void
    {
        parent::setUp();

        // TAIKHOAN: TenDangNhap (NOT NULL), HoTen (NOT NULL), MatKhau (NOT NULL), TrangThai (NOT NULL)
        // VaiTro là FK -> bảng VAITRO nên ta cần dùng đúng giá trị tồn tại trong DB
        $this->tkKh = TaiKhoan::create([
            'MaTaiKhoan'   => 'TEST_TK_DATTOUR',
            'TenDangNhap'  => 'test_dat_tour',
            'MatKhau'      => bcrypt('123456'),
            'HoTen'        => 'Người Lớn Test',
            'Email'        => 'dat_tour_' . time() . '@test.com',
            'SoDienThoai'  => '0987111222',
            'VaiTro'       => 'KHACHHANG',
            'TrangThai'    => 'HOAT_DONG',
            'NgaySinh'     => '1990-01-01', // Người lớn
        ]);

        // HOCHIEUSO: MaKhachHang (PK), MaTaiKhoan (NOT NULL, FK), HangThanhVien (NOT NULL), DiemXanh (NOT NULL)
        $this->hcs = HoChieuSo::create([
            'MaKhachHang'   => 'TEST_KH_DT',
            'MaTaiKhoan'    => 'TEST_TK_DATTOUR',
            'HangThanhVien' => 'THANH_VIEN',
            'DiemXanh'      => 0,
        ]);

        $this->token = JWTAuth::fromUser($this->tkKh);

        // TOURMAU: MaTourMau (PK), TieuDe (NOT NULL), ThoiLuong (NOT NULL), GiaSan (NOT NULL)
        TourMau::create([
            'MaTourMau' => 'TEST_TM_DT',
            'TieuDe'    => 'Tour Test Đặt',
            'ThoiLuong' => 3,
            'GiaSan'    => 1000000,
        ]);

        // TOURTHUCTE: MaTourThucTe (PK), MaTourMau (FK NOT NULL), NgayKhoiHanh (NOT NULL),
        //             GiaHienHanh (NOT NULL), SoKhachToiDa (NOT NULL), SoKhachToiThieu (NOT NULL),
        //             ChoConLai (NOT NULL), TrangThai (NOT NULL)
        $this->tourThucTe = TourThucTe::create([
            'MaTourThucTe'   => 'TEST_TTT_DT',
            'MaTourMau'      => 'TEST_TM_DT',
            'NgayKhoiHanh'   => Carbon::now()->addDays(10)->format('Y-m-d'),
            'GiaHienHanh'    => 2000000,
            'SoKhachToiThieu'=> 2,
            'SoKhachToiDa'   => 20,
            'ChoConLai'      => 10,
            'TrangThai'      => 'MO_BAN',
        ]);

        // DICHVUTHEM: MaDichVuThem (PK), Ten (NOT NULL), DonGia (NOT NULL)
        $this->dichVuThem = DichVuThem::create([
            'MaDichVuThem' => 'TEST_DV_DT',
            'Ten'          => 'Bảo hiểm VIP',
            'DonGia'       => 500000,
            'DonViTinh'    => 'Gói',
        ]);

        // HANHDONGXANH: MaHanhDongXanh (PK), TenHanhDong (NOT NULL), DiemCong (NOT NULL)
        $this->hanhDongXanh = HanhDongXanh::create([
            'MaHanhDongXanh' => 'TEST_HDX_DT',
            'TenHanhDong'    => 'Dọn rác',
            'DiemCong'       => 10,
        ]);
    }

    /**
     * Đặt tour thành công:
     *   - Người đặt: 1990 -> người lớn  -> 2,000,000
     *   - Đồng hành: 5 tuổi -> trẻ em   -> 1,000,000 (giảm 50%)
     *   - Dịch vụ: 500,000 x 2 cái      -> 1,000,000
     *   - Tổng kỳ vọng: 4,000,000
     */
    public function test_dat_tour_thanh_cong_co_tre_em()
    {
        $ngayKhoiHanh    = Carbon::parse($this->tourThucTe->NgayKhoiHanh);
        $ngaySinhTreEm   = $ngayKhoiHanh->copy()->subYears(5)->format('Y-m-d');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/dat-tour', [
                'maTourThucTe' => 'TEST_TTT_DT',
                'ghiChu'       => 'Lưu ý đồ ăn chay',
                'danhSachNguoiDongHanh' => [
                    [
                        'hoTen'    => 'Trẻ Em 1',
                        'ngaySinh' => $ngaySinhTreEm,
                        'gioiTinh' => 'NAM',
                    ]
                ],
                'danhSachDichVu' => [
                    [
                        'maDichVuThem' => 'TEST_DV_DT',
                        'soLuong'      => 2,
                    ]
                ],
                'danhSachHanhDongXanhChiTiet' => [
                    [
                        'maHanhDongXanh' => 'TEST_HDX_DT',
                        'soLuong'        => 1,
                    ]
                ],
            ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.tongTien', 4000000.0);
        $response->assertJsonPath('data.soNguoiLon', 1);
        $response->assertJsonPath('data.soTreEm', 1);
        $response->assertJsonPath('data.diemXanhDuKien', 10);

        $maDatTour = $response->json('data.maDatTour');
        $this->assertNotNull($maDatTour);

        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => $maDatTour,
            'TrangThai' => 'CHO_XAC_NHAN',
        ]);

        // 2 chi tiết: người đặt + người đồng hành
        $this->assertDatabaseHas('CHITIETDATTOUR', ['MaDatTour' => $maDatTour, 'LoaiKhach' => 'NGUOI_DAT']);
        $this->assertDatabaseHas('CHITIETDATTOUR', ['MaDatTour' => $maDatTour, 'LoaiKhach' => 'NGUOI_DONG_HANH']);
        // 1 chi tiết dịch vụ
        $this->assertDatabaseHas('CHITIETDICHVU', ['MaDatTour' => $maDatTour, 'MaDichVuThem' => 'TEST_DV_DT']);
    }

    /**
     * Đặt tour thất bại vì số chỗ còn lại < số người đặt
     */
    public function test_dat_tour_that_bai_khi_het_cho()
    {
        // Chỉ còn 1 chỗ, nhưng muốn đặt 2 người (1 + 1 đồng hành)
        $this->tourThucTe->update(['ChoConLai' => 1]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/dat-tour', [
                'maTourThucTe' => 'TEST_TTT_DT',
                'danhSachNguoiDongHanh' => [
                    [
                        'hoTen'    => 'Khách 2',
                        'ngaySinh' => '1990-01-01',
                    ]
                ],
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Tour đã hết chỗ');
    }

    /**
     * Khách tự hủy đơn khi đơn ở trạng thái CHO_XAC_NHAN
     */
    public function test_huy_dat_tour_thanh_cong()
    {
        // 1. Đặt tour
        $resBook = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/dat-tour', [
                'maTourThucTe' => 'TEST_TTT_DT',
            ]);
        $resBook->assertStatus(201);
        $maDatTour = $resBook->json('data.maDatTour');
        $this->assertNotNull($maDatTour);

        // 2. Hủy đơn
        $resHuy = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson('/api/khach-hang/don-dat-tour/' . $maDatTour . '/huy');
        $resHuy->assertStatus(200);

        // 3. Kiểm tra trạng thái trong DB
        $this->assertDatabaseHas('DONDATTOUR', [
            'MaDatTour' => $maDatTour,
            'TrangThai' => 'DA_HUY',
        ]);
    }

    /**
     * Không thể đặt tour không ở trạng thái MO_BAN
     */
    public function test_dat_tour_that_bai_khi_tour_khong_mo_ban()
    {
        $this->tourThucTe->update(['TrangThai' => 'KET_THUC']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/khach-hang/dat-tour', [
                'maTourThucTe' => 'TEST_TTT_DT',
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', "Tour không ở trạng thái 'Mở bán', không thể đặt");
    }
}
