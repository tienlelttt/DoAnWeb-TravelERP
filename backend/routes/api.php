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

Route::prefix('dieu-hanh')->group(function () {
    Route::prefix('tour-thuc-te')->group(function () {
        Route::get('/', [TourThucTeController::class, 'danhSach']);
        Route::get('/{id}', [TourThucTeController::class, 'chiTiet']);
        Route::post('/', [TourThucTeController::class, 'taoMoi']);
        Route::put('/{id}', [TourThucTeController::class, 'capNhat']);
        Route::delete('/{id}', [TourThucTeController::class, 'xoa']);
    });
    
    Route::get('danh-gia', [DanhGiaController::class, 'tatCaDanhGia'])->middleware('role:KINHDOANH,ADMIN');
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

Route::group(['prefix' => 'kinh-doanh', 'middleware' => ['auth:api', 'role:KINHDOANH']], function () {
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
});

Route::group(['prefix' => 'ke-toan', 'middleware' => ['auth:api', 'role:KETOAN']], function () {
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
    Route::prefix('tour-mau')->group(function () {
        Route::get('/', [TourMauController::class, 'danhSach']);
        Route::get('/{id}', [TourMauController::class, 'chiTiet']);
        Route::post('/', [TourMauController::class, 'taoMoi']);
        Route::put('/{id}', [TourMauController::class, 'capNhat']);
        Route::delete('/{id}', [TourMauController::class, 'xoa']);
        Route::post('/{id}/sao-chep', [TourMauController::class, 'saoChep']);
        
        // Lich trinh
        Route::post('/{id}/lich-trinh', [TourMauController::class, 'themLichTrinh']);
        Route::put('/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'suaLichTrinh']);
        Route::delete('/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'xoaLichTrinh']);
    });

    Route::prefix('dich-vu-them')->group(function () {
        Route::get('/', [\App\Http\Controllers\DichVuThemController::class, 'danhSach']);
        Route::get('/{id}', [\App\Http\Controllers\DichVuThemController::class, 'chiTiet']);
        Route::post('/', [\App\Http\Controllers\DichVuThemController::class, 'taoMoi']);
        Route::put('/{id}', [\App\Http\Controllers\DichVuThemController::class, 'capNhat']);
        Route::delete('/{id}', [\App\Http\Controllers\DichVuThemController::class, 'xoa']);
    });

    Route::prefix('hanh-dong-xanh')->group(function () {
        Route::get('/', [\App\Http\Controllers\HanhDongXanhController::class, 'danhSach']);
        Route::get('/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'chiTiet']);
        Route::post('/', [\App\Http\Controllers\HanhDongXanhController::class, 'taoMoi']);
        Route::put('/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'capNhat']);
        Route::delete('/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'xoa']);
    });
});

// ==========================================
// Giai doan 5: Phan he dieu hanh & HDV
// ==========================================
Route::group(['prefix' => 'dieu-hanh', 'middleware' => ['auth:api', 'role:DIEUHANH']], function () {
    Route::post('/phan-cong', [\App\Http\Controllers\DieuHanhController::class, 'phanCongTour']);
    Route::post('/phan-cong-tour', [\App\Http\Controllers\DieuHanhController::class, 'phanCongTour']);
    Route::get('/tour-can-phan-cong', [\App\Http\Controllers\DieuHanhController::class, 'tourCanPhanCong']);
    Route::get('/hdv-kha-dung', [\App\Http\Controllers\DieuHanhController::class, 'hdvKhaDung']);
    Route::delete('/phan-cong/{id}', [\App\Http\Controllers\DieuHanhController::class, 'huyPhanCong']);
    Route::get('/tour/{maTour}/doan', [\App\Http\Controllers\DieuHanhVanHanhController::class, 'danhSachDoan']);
    Route::get('/tour/{maTour}/su-co', [\App\Http\Controllers\DieuHanhVanHanhController::class, 'danhSachSuCo']);
    Route::get('/tour/{maTour}/chi-phi', [\App\Http\Controllers\DieuHanhVanHanhController::class, 'chiPhiCuaTour']);
});

Route::group(['prefix' => 'hdv', 'middleware' => ['auth:api', 'role:HDV']], function () {
    Route::post('/phan-cong/{id}/tra-loi', [\App\Http\Controllers\HdvController::class, 'traLoiPhanCong']);
});

Route::group(['prefix' => 'huong-dan-vien', 'middleware' => ['auth:api', 'role:HDV']], function () {
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

// ==========================================
// Giai doan 5: Ke Toan Duyet Chi Phi
// ==========================================
Route::group(['prefix' => 'ke-toan', 'middleware' => ['auth:api', 'role:KETOAN']], function () {
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

Route::group(['prefix' => 'quan-tri', 'middleware' => ['auth:api', 'role:ADMIN', 'audit_log']], function () {
    Route::get('/nhat-ky-he-thong', [\App\Http\Controllers\Admin\NhatKyHeThongController::class, 'danhSach']);
    Route::post('/dang-ky-nhan-vien', [\App\Http\Controllers\QuanTriCompatController::class, 'dangKyNhanVien']);
});
