<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Services\MaTuDongService;
use Carbon\Carbon;

class TaiKhoanAdminSeeder extends Seeder
{
    public function run(MaTuDongService $maTuDongService, UserService $userService): void
    {
        // 1. Tài khoản seed theo README.md (mật khẩu: password)
        $readmeAccounts = [
            [
                'tenDangNhap' => 'admin',
                'matKhau' => 'password',
                'hoTen' => 'Quản Trị Viên Hệ Thống',
                'email' => 'admin@travelerp.com',
                'soDienThoai' => '0987654321',
                'vaiTro' => 'ADMIN'
            ],
            [
                'tenDangNhap' => 'sanpham01',
                'matKhau' => 'password',
                'hoTen' => 'Nhân Viên Sản Phẩm 01',
                'email' => 'sanpham01@travelerp.com',
                'soDienThoai' => '0987654322',
                'vaiTro' => 'SANPHAM'
            ],
            [
                'tenDangNhap' => 'manager01',
                'matKhau' => 'password',
                'hoTen' => 'Nhân Viên Điều Hành 01',
                'email' => 'dieuhanh01@travelerp.com',
                'soDienThoai' => '0987654323',
                'vaiTro' => 'DIEUHANH'
            ],
            [
                'tenDangNhap' => 'sales01',
                'matKhau' => 'password',
                'hoTen' => 'Nhân Viên Kinh Doanh 01',
                'email' => 'sales01@travelerp.com',
                'soDienThoai' => '0987654324',
                'vaiTro' => 'KINHDOANH'
            ],
            [
                'tenDangNhap' => 'ketoan01',
                'matKhau' => 'password',
                'hoTen' => 'Kế Toán Viên 01',
                'email' => 'ketoan01@travelerp.com',
                'soDienThoai' => '0987654325',
                'vaiTro' => 'KETOAN'
            ],
            [
                'tenDangNhap' => 'hdv01',
                'matKhau' => 'password',
                'hoTen' => 'Hướng Dẫn Viên 01',
                'email' => 'hdv01@travelerp.com',
                'soDienThoai' => '0987654326',
                'vaiTro' => 'HDV'
            ],
            [
                'tenDangNhap' => 'hdv02',
                'matKhau' => 'password',
                'hoTen' => 'Hướng Dẫn Viên 02',
                'email' => 'hdv02@travelerp.com',
                'soDienThoai' => '0987654327',
                'vaiTro' => 'HDV'
            ]
        ];

        foreach ($readmeAccounts as $acc) {
            if (!DB::table('tai_khoans')->where('ten_dang_nhap', $acc['tenDangNhap'])->exists()) {
                $userService->taoNhanVienQuanTri($acc);
            }
        }

        // 2. Tài khoản test phục vụ unit tests (mật khẩu: 123456)
        $testAccounts = [
            [
                'tenDangNhap' => 'admin_test',
                'matKhau' => '123456',
                'hoTen' => 'Quản Trị Viên Test',
                'email' => 'admintest@travelerp.com',
                'soDienThoai' => '0999999991',
                'vaiTro' => 'ADMIN'
            ],
            [
                'tenDangNhap' => 'sanpham_test',
                'matKhau' => '123456',
                'hoTen' => 'Nhân Viên Sản Phẩm Test',
                'email' => 'sanphamtest@travelerp.com',
                'soDienThoai' => '0999999992',
                'vaiTro' => 'SANPHAM'
            ]
        ];

        foreach ($testAccounts as $acc) {
            if (!DB::table('tai_khoans')->where('ten_dang_nhap', $acc['tenDangNhap'])->exists()) {
                $userService->taoNhanVienQuanTri($acc);
            }
        }

        // 3. Seed tài khoản khách hàng mặc định (mật khẩu: password)
        if (!DB::table('tai_khoans')->where('ten_dang_nhap', 'khachhang01')->exists()) {
            $khachHangTK = DB::table('tai_khoans')->insertGetId([
                'ma_tai_khoan' => 'TK_KH_001',
                'ten_dang_nhap' => 'khachhang01',
                'mat_khau' => Hash::make('password'),
                'ho_ten' => 'Nguyễn Hoàng Long',
                'email' => 'longnh@gmail.com',
                'so_dien_thoai' => '0912345678',
                'vai_tro' => 'KHACHHANG',
                'trang_thai' => 'HOAT_DONG',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('ho_chieu_sos')->insert([
                'ma_khach_hang' => 'KH_01',
                'ma_tai_khoan' => 'TK_KH_001',
                'ghi_chu_y_te' => 'Sức khỏe tốt',
                'di_ung' => 'Không dị ứng',
                'hang_thanh_vien' => 'DONG',
                'diem_xanh' => 150,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 4. Seed Dịch vụ thêm (dich_vu_thems)
        $dichVuThems = [
            [
                'ma_dich_vu_them' => 'DV001',
                'ten' => 'Vé Buffet Hải Sản Đêm Trên Du Thuyền',
                'don_vi_tinh' => 'Người',
                'don_gia' => 450000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_dich_vu_them' => 'DV002',
                'ten' => 'Xe Limousine Đưa Đón Sân Bay Hà Nội',
                'don_vi_tinh' => 'Lượt',
                'don_gia' => 250000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_dich_vu_them' => 'DV003',
                'ten' => 'Phụ Thu Phòng Đơn Khách Sạn 4 Sao',
                'don_vi_tinh' => 'Đêm',
                'don_gia' => 500000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('dich_vu_thems')->insertOrIgnore($dichVuThems);

        // 5. Seed Hành động xanh (hanh_dong_xanhs)
        $hanhDongXanhs = [
            [
                'ma_hanh_dong_xanh' => 'HDX001',
                'ten_hanh_dong' => 'Không sử dụng túi nilon suốt hành trình',
                'diem_cong' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_hanh_dong_xanh' => 'HDX002',
                'ten_hanh_dong' => 'Tham gia nhặt rác bảo vệ bãi biển vịnh Hạ Long',
                'diem_cong' => 200,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_hanh_dong_xanh' => 'HDX003',
                'ten_hanh_dong' => 'Sử dụng bình đựng nước cá nhân tái sử dụng',
                'diem_cong' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('hanh_dong_xanhs')->insertOrIgnore($hanhDongXanhs);

        // 6. Seed Tour mẫu (tour_maus)
        $tourMaus = [
            [
                'ma_tour_mau' => 'TM001',
                'tieu_de' => 'Tour Khám Phá Vịnh Hạ Long Huyền Bí',
                'mo_ta' => 'Hành trình 3 ngày 2 đêm trên du thuyền đẳng cấp ngắm nhìn hàng ngàn hòn đảo kỳ vĩ.',
                'thoi_luong' => 3,
                'gia_san' => 2500000,
                'danh_gia' => 4.8,
                'so_danh_gia' => 120,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_tour_mau' => 'TM002',
                'tieu_de' => 'Tour Nghỉ Dưỡng Thiên Đường Đảo Ngọc Phú Quốc',
                'mo_ta' => 'Khám phá nam đảo Phú Quốc, lặn ngắm san hô, tắm biển bãi Sao cát trắng mịn.',
                'thoi_luong' => 4,
                'gia_san' => 4000000,
                'danh_gia' => 4.9,
                'so_danh_gia' => 95,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_tour_mau' => 'TM003',
                'tieu_de' => 'Tour Chinh Phục Đỉnh Fansipan Sapa Sương Mù',
                'mo_ta' => 'Hành trình leo núi hoặc đi cáp treo chinh phục nóc nhà Đông Dương Fansipan huyền thoại.',
                'thoi_luong' => 3,
                'gia_san' => 1800000,
                'danh_gia' => 4.7,
                'so_danh_gia' => 84,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('tour_maus')->insertOrIgnore($tourMaus);

        // 7. Seed Lịch trình chi tiết (lich_trinh_tours)
        $lichTrinhs = [
            [
                'ma_lich_trinh_tour' => 'LT001',
                'ma_tour_mau' => 'TM001',
                'ngay_thu' => 1,
                'hoat_dong' => 'Hà Nội - Hạ Long: Nhận phòng du thuyền, chèo Kayak hang Luồn',
                'mo_ta' => 'Bắt đầu hành trình đón khách từ Hà Nội đến cảng tàu quốc tế Tuần Châu.',
                'thuc_don' => 'Trưa: Buffet hải sản trên du thuyền. Tối: Tiệc nướng BBQ hải sản cao cấp.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_lich_trinh_tour' => 'LT002',
                'ma_tour_mau' => 'TM001',
                'ngay_thu' => 2,
                'hoat_dong' => 'Khám phá hang Sửng Sốt, leo núi Ti Tốp ngắm vịnh',
                'mo_ta' => 'Ghé thăm hang động lớn nhất Vịnh Hạ Long và chinh phục đỉnh Ti Tốp tắm biển.',
                'thuc_don' => 'Sáng: Điểm tâm nhẹ. Trưa: Set menu Việt Nam. Tối: Gala dinner sang trọng.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_lich_trinh_tour' => 'LT003',
                'ma_tour_mau' => 'TM001',
                'ngay_thu' => 3,
                'hoat_dong' => 'Lớp Taichi buổi sáng, thăm làng Ngọc Trai - Hà Nội',
                'mo_ta' => 'Đón bình minh yên bình, tham quan cơ sở nuôi cấy ngọc trai Hạ Long trước khi cập cảng.',
                'thuc_don' => 'Sáng: Buffet sáng nhẹ. Trưa: Bữa trưa gia đình ấm cúng trước khi về.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('lich_trinh_tours')->insertOrIgnore($lichTrinhs);

        // 8. Seed Tour thực tế (tour_thuc_tes)
        $ngayDi1 = Carbon::now()->addDays(7);
        $ngayDi2 = Carbon::now()->addDays(12);

        $tourThucTes = [
            [
                'ma_tour_thuc_te' => 'TTT001',
                'ma_tour_mau' => 'TM001',
                'ngay_khoi_hanh' => $ngayDi1,
                'gia_hien_hanh' => 2900000,
                'so_khach_toi_da' => 25,
                'so_khach_toi_thieu' => 10,
                'cho_con_lai' => 25,
                'trang_thai' => 'CHO_KICH_HOAT',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_tour_thuc_te' => 'TTT002',
                'ma_tour_mau' => 'TM002',
                'ngay_khoi_hanh' => $ngayDi2,
                'gia_hien_hanh' => 4500000,
                'so_khach_toi_da' => 20,
                'so_khach_toi_thieu' => 8,
                'cho_con_lai' => 20,
                'trang_thai' => 'CHO_KICH_HOAT',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('tour_thuc_tes')->insertOrIgnore($tourThucTes);

        // 9. Cấu hình dịch vụ và hành động xanh áp dụng cho Tour thực tế
        $dichVuTourThucTes = [
            ['ma_tour_thuc_te' => 'TTT001', 'ma_dich_vu_them' => 'DV001', 'created_at' => now(), 'updated_at' => now()],
            ['ma_tour_thuc_te' => 'TTT001', 'ma_dich_vu_them' => 'DV002', 'created_at' => now(), 'updated_at' => now()],
            ['ma_tour_thuc_te' => 'TTT002', 'ma_dich_vu_them' => 'DV003', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('dich_vu_tour_thuc_tes')->insertOrIgnore($dichVuTourThucTes);

        $hdxTourThucTes = [
            ['ma_tour_thuc_te' => 'TTT001', 'ma_hanh_dong_xanh' => 'HDX001', 'created_at' => now(), 'updated_at' => now()],
            ['ma_tour_thuc_te' => 'TTT001', 'ma_hanh_dong_xanh' => 'HDX002', 'created_at' => now(), 'updated_at' => now()],
            ['ma_tour_thuc_te' => 'TTT002', 'ma_hanh_dong_xanh' => 'HDX003', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('hdx_tour_thuc_tes')->insertOrIgnore($hdxTourThucTes);

        // 10. Phân công hướng dẫn viên cho Tour thực tế
        $nhanVienHdv = DB::table('nhan_viens')->where('loai_nhan_vien', 'HDV')->first();
        if ($nhanVienHdv) {
            $phanCong = [
                'ma_phan_cong_tour' => 'PCT001',
                'ma_tour_thuc_te' => 'TTT001',
                'ma_nhan_vien' => $nhanVienHdv->ma_nhan_vien,
                'ngay_phan_cong' => now(),
                'trang_thai_chap_nhan' => 'CHO_PHAN_HOI',
                'created_at' => now(),
                'updated_at' => now()
            ];
            DB::table('phan_cong_tours')->insertOrIgnore($phanCong);
        }
    }
}
