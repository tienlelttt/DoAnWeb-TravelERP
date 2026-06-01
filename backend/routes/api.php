<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourCongKhaiController;
use App\Http\Controllers\TourMauController;
use App\Http\Controllers\TourThucTeController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DatTourController;

Route::prefix('auth')->group(function () {
    Route::post('/dang-ky', [AuthController::class, 'dangKy']);
    Route::post('/dang-nhap', [AuthController::class, 'dangNhap']);
    Route::post('/quen-mat-khau', [AuthController::class, 'quenMatKhau']);
    Route::post('/dat-lai-mat-khau', [AuthController::class, 'datLaiMatKhau']);
    
    Route::middleware('auth:api')->group(function () {
        Route::post('/kiem-tra-mat-khau', [AuthController::class, 'kiemTraMatKhau']);
        Route::post('/doi-mat-khau', [AuthController::class, 'doiMatKhau']);
        Route::post('/dang-xuat', [AuthController::class, 'dangXuat']);
    });
});

// UC25 & UC26: API Cong Khai (Khong can dang nhap)
Route::prefix('public')->group(function () {
    Route::get('/tour', [TourCongKhaiController::class, 'danhSachTour']);
    Route::get('/tour/{maTourThucTe}', [TourCongKhaiController::class, 'chiTietTour']);
    Route::get('/tour/{id}/danh-gia', [DanhGiaController::class, 'danhSachDanhGia']);
});



Route::group(['prefix' => 'khach-hang', 'middleware' => ['auth:api', 'role:KHACHHANG,ADMIN']], function () {
    Route::post('danh-gia', [DanhGiaController::class, 'guiDanhGia']);
    
    // Đặt Tour
    Route::post('dat-tour', [DatTourController::class, 'datTour']);
    Route::get('don-dat-tour', [DatTourController::class, 'danhSachCuaToi']);
    Route::get('don-dat-tour/{id}', [DatTourController::class, 'chiTietCuaToi']);
    Route::put('don-dat-tour/{id}/huy', [DatTourController::class, 'huyDatTour']);
    Route::post('huy-don', [\App\Http\Controllers\HuyDonController::class, 'yeuCauHuyDon']);
    
    // Voucher
    Route::post('don-dat-tour/ap-dung-voucher', [\App\Http\Controllers\VoucherController::class, 'apDungVoucher']);
    Route::get('voucher', [\App\Http\Controllers\VoucherController::class, 'danhSachVoucher']);
    Route::get('vi-voucher', [\App\Http\Controllers\VoucherController::class, 'viVoucher']);
    Route::get('voucher-co-the-doi', [\App\Http\Controllers\VoucherController::class, 'voucherCoTheDoi']);
    Route::post('ap-voucher', [\App\Http\Controllers\VoucherController::class, 'apVoucher']);
    Route::post('doi-diem', [\App\Http\Controllers\VoucherController::class, 'doiDiem']);
});

// Hỗ trợ route alias
Route::group(['middleware' => ['auth:api', 'role:KHACHHANG']], function () {
    Route::post('dat-tour/ap-dung-voucher', [\App\Http\Controllers\VoucherController::class, 'apDungVoucher']);
});

// UC: CAc API liAn quan den Thanh Toan (Task 4.3)
Route::group(['prefix' => 'thanh-toan'], function () {
    Route::group(['middleware' => ['auth:api', 'role:KHACHHANG,ADMIN']], function () {
        Route::post('khoi-tao', [\App\Http\Controllers\ThanhToanController::class, 'khoiTaoThanhToan']);
        Route::post('mock', [\App\Http\Controllers\ThanhToanController::class, 'thanhToanMock']);
        Route::post('bao-chuyen-khoan', [\App\Http\Controllers\ThanhToanController::class, 'baoChuyenKhoan']);
        Route::post('{maDatTour}/het-han-qr', [\App\Http\Controllers\ThanhToanController::class, 'hetHanThanhToanQr']);
        Route::post('{maDatTour}/xac-nhan-chuyen-khoan', [\App\Http\Controllers\ThanhToanController::class, 'xacNhanDaChuyenKhoan']);
        Route::get('{maDatTour}/ket-qua', [\App\Http\Controllers\ThanhToanController::class, 'ketQua']);
        Route::post('vnpay/tao-url', [\App\Http\Controllers\ThanhToanController::class, 'taoThanhToanVnpay']);
    });
    Route::get('vnpay/return', [\App\Http\Controllers\ThanhToanController::class, 'vnpayReturn']);
    Route::get('vnpay/ipn', [\App\Http\Controllers\ThanhToanController::class, 'vnpayIpn']);
});

Route::group(['prefix' => 'kinh-doanh', 'middleware' => ['auth:api', 'role:KINHDOANH,ADMIN']], function () {
    Route::get('danh-gia', [DanhGiaController::class, 'tatCaDanhGia']);
    Route::post('xac-nhan-thanh-toan', [\App\Http\Controllers\KinhDoanhController::class, 'xacNhanThanhToan']);
    Route::post('duyet-don/{maDon}', [\App\Http\Controllers\XuLyHuyController::class, 'duyetDonVip']);
    Route::post('xu-ly-huy', [\App\Http\Controllers\XuLyHuyController::class, 'xuLyHuy']);

    // Quản trị Voucher
    Route::get('voucher', [\App\Http\Controllers\Admin\VoucherAdminController::class, 'danhSach']);
    Route::post('voucher', [\App\Http\Controllers\Admin\VoucherAdminController::class, 'taoVoucher']);
    Route::put('voucher/{maVoucher}', [\App\Http\Controllers\Admin\VoucherAdminController::class, 'capNhatVoucher']);
    Route::put('voucher/{maVoucher}/vo-hieu-hoa', [\App\Http\Controllers\Admin\VoucherAdminController::class, 'voHieuHoaVoucher']);
    Route::post('voucher/{maVoucher}/phat-hanh', [\App\Http\Controllers\Admin\VoucherAdminController::class, 'phatHanh']);

    // Đơn đặt tour (Kinh doanh)
    Route::get('dat-tour', [\App\Http\Controllers\KinhDoanhCompatController::class, 'danhSachDonDatTour']);
    Route::get('don-dat-tour', [\App\Http\Controllers\KinhDoanhCompatController::class, 'danhSachDonDatTour']);
    Route::put('dat-tour/{maDatTour}/xac-nhan', [\App\Http\Controllers\KinhDoanhCompatController::class, 'xacNhanDon']);
    Route::put('dat-tour/{maDatTour}/tu-choi-thanh-toan', [\App\Http\Controllers\KinhDoanhCompatController::class, 'tuChoiThanhToan']);

    // Khách hàng (Kinh doanh)
    Route::get('khach-hang', [\App\Http\Controllers\KinhDoanhCompatController::class, 'timKiemKhachHang']);
    Route::get('khach-hang/{maKhachHang}', [\App\Http\Controllers\KinhDoanhCompatController::class, 'chiTietKhachHang']);

    // Yêu cầu hỗ trợ (Complaints)
    Route::get('yeu-cau-ho-tro', [\App\Http\Controllers\KinhDoanhCompatController::class, 'danhSachYeuCauHoTro']);
    Route::put('yeu-cau-ho-tro/{maYeuCau}', [\App\Http\Controllers\KinhDoanhCompatController::class, 'capNhatYeuCauHoTro']);
    Route::post('yeu-cau-ho-tro/{maYeuCau}/yeu-cau-hdv-giai-trinh', [\App\Http\Controllers\KinhDoanhCompatController::class, 'yeuCauHdvGiaiTrinh']);
    Route::post('yeu-cau-ho-tro/{maYeuCau}/yeu-cau-khach-hang-bo-sung', [\App\Http\Controllers\KinhDoanhCompatController::class, 'yeuCauKhachHangBoSung']);
});

// Kinh doanh - Read-only routes cho KETOAN (xem đơn hàng)
Route::group(['prefix' => 'kinh-doanh', 'middleware' => ['auth:api', 'role:KETOAN,ADMIN']], function () {
    Route::get('dat-tour', [\App\Http\Controllers\KinhDoanhCompatController::class, 'danhSachDonDatTour']);
    Route::get('don-dat-tour', [\App\Http\Controllers\KinhDoanhCompatController::class, 'danhSachDonDatTour']);
    Route::get('khach-hang', [\App\Http\Controllers\KinhDoanhCompatController::class, 'timKiemKhachHang']);
    Route::get('khach-hang/{maKhachHang}', [\App\Http\Controllers\KinhDoanhCompatController::class, 'chiTietKhachHang']);
    Route::get('yeu-cau-ho-tro', [\App\Http\Controllers\KinhDoanhCompatController::class, 'danhSachYeuCauHoTro']);
});

Route::group(['prefix' => 'ke-toan', 'middleware' => ['auth:api', 'role:KETOAN,ADMIN']], function () {
    Route::post('hoan-tien', [\App\Http\Controllers\HoanTienController::class, 'hoanTien']);
    
    // Quản lý hoàn tiền
    Route::get('giao-dich-hoan', [\App\Http\Controllers\KeToanHoanTienController::class, 'danhSachChoHoanTien']);
    Route::put('giao-dich-hoan/{maGiaoDich}/xac-nhan', [\App\Http\Controllers\KeToanHoanTienController::class, 'xacNhanHoanTien']);
    Route::put('giao-dich-hoan/{maGiaoDich}/tu-choi', [\App\Http\Controllers\KeToanHoanTienController::class, 'tuChoiHoanTien']);

    // Quyết toán Tour
    Route::get('tour-can-quyet-toan', [\App\Http\Controllers\QuyetToanController::class, 'tourCanQuyetToan']);
    Route::get('quyet-toan', [\App\Http\Controllers\QuyetToanController::class, 'danhSach']);
    Route::get('quyet-toan/{maQuyetToan}', [\App\Http\Controllers\QuyetToanController::class, 'chiTiet']);
    Route::get('tinh-toan/{maTour}', [\App\Http\Controllers\QuyetToanController::class, 'tinhToan']);
    Route::post('quyet-toan/{maTour}', [\App\Http\Controllers\QuyetToanController::class, 'taoQuyetToan']);
    Route::put('quyet-toan/{maQuyetToan}/chot', [\App\Http\Controllers\QuyetToanController::class, 'chotQuyetToan']);
    Route::post('quyet-toan/{maQuyetToan}/yeu-cau-bo-sung', [\App\Http\Controllers\QuyetToanController::class, 'yeuCauBoSung']);

    // Tích hợp Power BI
    Route::prefix('power-bi')->group(function () {
        Route::get('kho-du-lieu', [\App\Http\Controllers\PowerBiController::class, 'danhSachKhoDuLieu']);
        Route::get('ket-noi', [\App\Http\Controllers\PowerBiController::class, 'layThongTinKetNoi']);
        Route::post('xuat-du-lieu', [\App\Http\Controllers\PowerBiController::class, 'xuatDuLieu']);
    });
});

Route::prefix('san-pham')->group(function () {
    // Nhóm GET (Read-Only) của Sản Phẩm (Tất cả nhân viên nội bộ)
    Route::group(['middleware' => ['auth:api', 'role:SANPHAM,DIEUHANH,KINHDOANH,KETOAN,HDV,ADMIN']], function () {
        Route::get('tour-mau', [TourMauController::class, 'danhSach']);
        Route::get('tour-mau/{id}', [TourMauController::class, 'chiTiet']);
        Route::get('dich-vu-them', [\App\Http\Controllers\DichVuThemController::class, 'danhSach']);
        Route::get('dich-vu-them/{id}', [\App\Http\Controllers\DichVuThemController::class, 'chiTiet']);
        Route::get('hanh-dong-xanh', [\App\Http\Controllers\HanhDongXanhController::class, 'danhSach']);
        Route::get('hanh-dong-xanh/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'chiTiet']);
    });

    // Nhóm WRITE (POST, PUT, DELETE) của Sản Phẩm (SANPHAM, ADMIN)
    Route::group(['middleware' => ['auth:api', 'role:SANPHAM,ADMIN']], function () {
        Route::post('tour-mau', [TourMauController::class, 'taoMoi']);
        Route::put('tour-mau/{id}', [TourMauController::class, 'capNhat']);
        Route::delete('tour-mau/{id}', [TourMauController::class, 'xoa']);
        Route::post('tour-mau/{id}/sao-chep', [TourMauController::class, 'saoChep']);
        
        Route::post('tour-mau/{id}/lich-trinh', [TourMauController::class, 'themLichTrinh']);
        Route::put('tour-mau/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'suaLichTrinh']);
        Route::delete('tour-mau/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'xoaLichTrinh']);

        Route::post('dich-vu-them', [\App\Http\Controllers\DichVuThemController::class, 'taoMoi']);
        Route::put('dich-vu-them/{id}', [\App\Http\Controllers\DichVuThemController::class, 'capNhat']);
        Route::delete('dich-vu-them/{id}', [\App\Http\Controllers\DichVuThemController::class, 'xoa']);

        Route::post('hanh-dong-xanh', [\App\Http\Controllers\HanhDongXanhController::class, 'taoMoi']);
        Route::put('hanh-dong-xanh/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'capNhat']);
        Route::delete('hanh-dong-xanh/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'xoa']);
    });
});

// ==========================================
// Phân hệ Điều hành & HDV
// ==========================================
Route::prefix('dieu-hanh')->group(function () {
    // Nhóm GET (Read-Only) của Tour thực tế (Tất cả nhân viên nội bộ)
    Route::group(['prefix' => 'tour-thuc-te', 'middleware' => ['auth:api', 'role:SANPHAM,DIEUHANH,KINHDOANH,KETOAN,HDV,ADMIN']], function () {
        Route::get('/', [TourThucTeController::class, 'danhSach']);
        Route::get('/{id}', [TourThucTeController::class, 'chiTiet']);
    });

    // Nhóm WRITE (POST, PUT, DELETE) của Tour thực tế (DIEUHANH, ADMIN)
    Route::group(['prefix' => 'tour-thuc-te', 'middleware' => ['auth:api', 'role:DIEUHANH,ADMIN']], function () {
        Route::post('/', [TourThucTeController::class, 'taoMoi']);
        Route::put('/{id}', [TourThucTeController::class, 'capNhat']);
        Route::delete('/{id}', [TourThucTeController::class, 'xoa']);
    });

    // Các route Điều hành khác (DIEUHANH, ADMIN)
    Route::group(['middleware' => ['auth:api', 'role:DIEUHANH,ADMIN']], function () {
        Route::post('/phan-cong', [\App\Http\Controllers\DieuHanhController::class, 'phanCongTour']);
        Route::post('/phan-cong-tour', [\App\Http\Controllers\DieuHanhController::class, 'phanCongTour']);
        Route::get('/tour-can-phan-cong', [\App\Http\Controllers\DieuHanhController::class, 'tourCanPhanCong']);
        Route::get('/hdv-kha-dung', [\App\Http\Controllers\DieuHanhController::class, 'hdvKhaDung']);
        Route::delete('/phan-cong/{id}', [\App\Http\Controllers\DieuHanhController::class, 'huyPhanCong']);
        Route::get('/nhan-vien/{maNhanVien}/nang-luc', [\App\Http\Controllers\DieuHanhController::class, 'layNangLucNhanVien']);
        Route::put('/nhan-vien/{maNhanVien}/nang-luc', [\App\Http\Controllers\DieuHanhController::class, 'capNhatNangLucNhanVien']);
        Route::get('/nhan-vien/{maNhanVien}/lich-cong-tac', [\App\Http\Controllers\DieuHanhController::class, 'layLichCongTacNhanVien']);
        Route::get('/tour/{maTour}/doan', [\App\Http\Controllers\DieuHanhVanHanhController::class, 'danhSachDoan']);
        Route::get('/tour/{maTour}/su-co', [\App\Http\Controllers\DieuHanhVanHanhController::class, 'danhSachSuCo']);
        Route::get('/tour/{maTour}/chi-phi', [\App\Http\Controllers\DieuHanhVanHanhController::class, 'chiPhiCuaTour']);
    });

    // Route đánh giá của phân hệ Điều hành (Đã có sẵn KINHDOANH, ADMIN từ trước)
    Route::get('danh-gia', [DanhGiaController::class, 'tatCaDanhGia'])->middleware(['auth:api', 'role:KINHDOANH,ADMIN']);
});

Route::group(['prefix' => 'hdv', 'middleware' => ['auth:api', 'role:HDV']], function () {
    Route::post('/phan-cong/{id}/tra-loi', [\App\Http\Controllers\HdvController::class, 'traLoiPhanCong']);
});

Route::group(['prefix' => 'huong-dan-vien', 'middleware' => ['auth:api', 'role:HDV']], function () {
    Route::get('/ho-so', [\App\Http\Controllers\NhanVienController::class, 'layHoSo']);
    Route::get('/nang-luc', [\App\Http\Controllers\NhanVienController::class, 'layNangLuc']);
    Route::get('/tour-cua-toi', [\App\Http\Controllers\HdvController::class, 'tourCuaToi']);
    
    Route::post('/phan-cong/{maPhanCong}/dong-y', [\App\Http\Controllers\HdvController::class, 'dongYPhanCong']);
    Route::post('/phan-cong/{maPhanCong}/tu-choi', [\App\Http\Controllers\HdvController::class, 'tuChoiPhanCong']);
    
    Route::get('/yeu-cau-giai-trinh', [\App\Http\Controllers\HdvController::class, 'danhSachYeuCauGiaiTrinh']);
    Route::put('/yeu-cau-giai-trinh/{maYeuCau}', [\App\Http\Controllers\HdvController::class, 'capNhatGiaiTrinh']);
    
    Route::get('/quyet-toan/can-bo-sung', [\App\Http\Controllers\HdvController::class, 'quyetToanCanBoSung']);
    Route::put('/quyet-toan/{maQuyetToan}/bo-sung', [\App\Http\Controllers\HdvController::class, 'boSungQuyetToan']);

    Route::get('/chi-phi', [\App\Http\Controllers\HdvController::class, 'tatCaChiPhi']);
    Route::get('/hanh-dong-xanh', [\App\Http\Controllers\HdvController::class, 'tatCaHanhDongXanh']);

    Route::get('/tour/{maTour}/lich-trinh', [\App\Http\Controllers\HdvController::class, 'lichTrinhTour']);
    Route::get('/tour/{maTour}/doan', [\App\Http\Controllers\HdvController::class, 'danhSachDoan']);
    Route::post('/tour/{maTour}/diem-danh', [\App\Http\Controllers\HdvController::class, 'diemDanh']);
    Route::post('/tour/{maTour}/hanh-dong-xanh', [\App\Http\Controllers\HdvController::class, 'ghiNhanHanhDong']);
    Route::get('/tour/{maTour}/su-co', [\App\Http\Controllers\HdvController::class, 'danhSachSuCo']);
    Route::post('/tour/{maTour}/su-co', [\App\Http\Controllers\HdvController::class, 'baoCaoSuCo']);
    Route::put('/su-co/{maSuCo}', [\App\Http\Controllers\HdvController::class, 'capNhatSuCo']);
    Route::get('/tour/{maTour}/chi-phi', [\App\Http\Controllers\HdvController::class, 'chiPhiCuaTour']);
    Route::post('/tour/{maTour}/chi-phi', [\App\Http\Controllers\HdvController::class, 'khaiChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/bo-sung', [\App\Http\Controllers\HdvController::class, 'boSungChiPhi']);
});

Route::get('huong-dan-vien/su-co', [\App\Http\Controllers\KinhDoanhCompatController::class, 'suCoCuaHdv'])->middleware(['auth:api', 'role:HDV,ADMIN,KINHDOANH,DIEUHANH,KETOAN,SANPHAM']);

// ==========================================
// Giai doan 5: Ke Toan Duyet Chi Phi
// ==========================================
Route::group(['prefix' => 'ke-toan', 'middleware' => ['auth:api', 'role:KETOAN,ADMIN']], function () {
    Route::get('/chi-phi', [\App\Http\Controllers\KeToanChiPhiController::class, 'danhSachChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/duyet', [\App\Http\Controllers\KeToanChiPhiController::class, 'duyetChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/tu-choi', [\App\Http\Controllers\KeToanChiPhiController::class, 'tuChoiChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/yeu-cau-bo-sung', [\App\Http\Controllers\KeToanChiPhiController::class, 'yeuCauBoSungChiPhi']);
});

// ==========================================
// Giai doan 4 (Tech Debt): API Khach Hang tu phuc vu
// ==========================================
Route::group(['prefix' => 'khach-hang', 'middleware' => ['auth:api', 'role:KHACHHANG,ADMIN']], function () {
    Route::get('/ho-so', [\App\Http\Controllers\KhachHangController::class, 'layHoSo']);
    Route::put('/ho-so', [\App\Http\Controllers\KhachHangController::class, 'capNhatHoSo']);
    Route::get('/dat-tour', [\App\Http\Controllers\KhachHangController::class, 'danhSachDatTour']);
    Route::get('/lich-su-tour', [\App\Http\Controllers\KhachHangController::class, 'lichSuTour']);
    
    // Yêu cầu hỗ trợ
    Route::get('/yeu-cau-ho-tro', [\App\Http\Controllers\KhachHangController::class, 'layDanhSachYeuCauHoTro']);
    Route::post('/yeu-cau-ho-tro', [\App\Http\Controllers\KhachHangController::class, 'taoYeuCauHoTro']);
    Route::get('/yeu-cau-ho-tro/can-bo-sung', [\App\Http\Controllers\KhachHangController::class, 'yeuCauHoTroCanBoSung']);
    Route::put('/yeu-cau-ho-tro/{maYeuCau}/bo-sung', [\App\Http\Controllers\KhachHangController::class, 'boSungYeuCauHoTro']);
    
    Route::post('/dat-tour/{maDatTour}/huy', [\App\Http\Controllers\KhachHangController::class, 'yeuCauHuyTour']);
});

// ==========================================
// Giai doan 3 (Tech Debt): Tour Cong Khai API
// ==========================================
Route::group(['prefix' => 'public/tour'], function () {
    Route::get('/{maTour}/hanh-dong-xanh', [\App\Http\Controllers\TourCongKhaiController::class, 'hanhDongXanh']);
    Route::get('/{maTour}/dich-vu-them', [\App\Http\Controllers\TourCongKhaiController::class, 'dichVuThem']);
    Route::get('/{maTour}/danh-gia', [\App\Http\Controllers\TourCongKhaiController::class, 'danhGiaKhachHang']);
});

// UC: Quan ly Nhan su (NhanVienController)
Route::group(['prefix' => 'nhan-vien', 'middleware' => ['auth:api', 'role:KINHDOANH,DIEUHANH,HDV,KETOAN']], function () {
    Route::get('/ho-so', [\App\Http\Controllers\NhanVienController::class, 'layHoSo']);
    Route::get('/lich-cong-tac', [\App\Http\Controllers\NhanVienController::class, 'layLichCongTac']);
    Route::get('/nang-luc', [\App\Http\Controllers\NhanVienController::class, 'layNangLuc']);
});

// ==========================================
// Giai doan 6: Admin & Báo cáo
// ==========================================
Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'role:ADMIN', 'audit_log']], function () {
    // Dashboard
    Route::get('/dashboard/overview', [\App\Http\Controllers\Admin\DashboardController::class, 'overview']);
    Route::get('/dashboard/revenue-chart', [\App\Http\Controllers\Admin\DashboardController::class, 'revenueChart']);

    // Quan ly User (TaiKhoan)
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store']);
    Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show']);
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy']);
    
    // Nhat ky he thong
    Route::get('/nhat-ky-he-thong', [\App\Http\Controllers\Admin\NhatKyHeThongController::class, 'danhSach']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'role:ADMIN,KETOAN']], function () {
    Route::post('/report/pdf/{type}', [\App\Http\Controllers\Admin\ReportPdfController::class, 'exportPDF']);
});

Route::group(['prefix' => 'quan-tri', 'middleware' => ['auth:api', 'role:ADMIN,DIEUHANH,KINHDOANH,KETOAN,SANPHAM', 'audit_log']], function () {
    // Compatibility routes for Staff Management (accountsService) - Read Only
    Route::get('/nhan-vien', [\App\Http\Controllers\QuanTriCompatController::class, 'danhSachNhanVien']);
    Route::get('/nhan-vien/{nhanVien}', [\App\Http\Controllers\QuanTriCompatController::class, 'chiTietNhanVien']);
});

Route::group(['prefix' => 'quan-tri', 'middleware' => ['auth:api', 'role:ADMIN', 'audit_log']], function () {
    Route::get('/nhat-ky-he-thong', [\App\Http\Controllers\Admin\NhatKyHeThongController::class, 'danhSach']);
    Route::post('/dang-ky-nhan-vien', [\App\Http\Controllers\QuanTriCompatController::class, 'dangKyNhanVien']);
    Route::put('/nhan-vien/{nhanVien}/vai-tro', [\App\Http\Controllers\QuanTriCompatController::class, 'ganVaiTro']);
    Route::put('/nhan-vien/{nhanVien}/mo-khoa', [\App\Http\Controllers\QuanTriCompatController::class, 'moKhoaTaiKhoan']);
    Route::put('/nhan-vien/{nhanVien}/khoa', [\App\Http\Controllers\QuanTriCompatController::class, 'khoaTaiKhoan']);
});
