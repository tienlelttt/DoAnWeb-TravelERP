<?php

use App\Http\Controllers\Admin\VoucherAdminController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\KinhDoanhCompatController;
use App\Http\Controllers\KinhDoanhController;
use App\Http\Controllers\XuLyHuyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'kinh-doanh', 'middleware' => ['auth:api', 'role:KINHDOANH,KETOAN,ADMIN']], function () {
    Route::get('dat-tour', [KinhDoanhCompatController::class, 'danhSachDonDatTour']);
    Route::get('don-dat-tour', [KinhDoanhCompatController::class, 'danhSachDonDatTour']);
    Route::get('dat-tour/{maDatTour}', [KinhDoanhCompatController::class, 'chiTietDonDatTour']);
    Route::get('don-dat-tour/{maDatTour}', [KinhDoanhCompatController::class, 'chiTietDonDatTour']);
    Route::get('khach-hang', [KinhDoanhCompatController::class, 'timKiemKhachHang']);
    Route::get('khach-hang/{maKhachHang}', [KinhDoanhCompatController::class, 'chiTietKhachHang']);
    Route::get('yeu-cau-ho-tro', [KinhDoanhCompatController::class, 'danhSachYeuCauHoTro']);
});

Route::group(['prefix' => 'kinh-doanh', 'middleware' => ['auth:api', 'role:KINHDOANH,ADMIN']], function () {
    Route::get('danh-gia', [DanhGiaController::class, 'tatCaDanhGia']);
    Route::post('xac-nhan-thanh-toan', [KinhDoanhController::class, 'xacNhanThanhToan']);
    Route::post('duyet-don/{maDon}', [XuLyHuyController::class, 'duyetDonVip']);
    Route::post('xu-ly-huy', [XuLyHuyController::class, 'xuLyHuy']);

    Route::get('voucher', [VoucherAdminController::class, 'danhSach']);
    Route::post('voucher', [VoucherAdminController::class, 'taoVoucher']);
    Route::put('voucher/{maVoucher}', [VoucherAdminController::class, 'capNhatVoucher']);
    Route::put('voucher/{maVoucher}/vo-hieu-hoa', [VoucherAdminController::class, 'voHieuHoaVoucher']);
    Route::post('voucher/{maVoucher}/phat-hanh', [VoucherAdminController::class, 'phatHanh']);
    Route::get('voucher/{maVoucher}/khach-hang-da-phan-bo', [VoucherAdminController::class, 'khachHangDaPhanBo']);
    Route::put('voucher/{maVoucher}/khach-hang/{maKhachHang}/thu-hoi', [VoucherAdminController::class, 'thuHoi']);

    Route::put('dat-tour/{maDatTour}/xac-nhan', [KinhDoanhCompatController::class, 'xacNhanDon']);
    Route::put('dat-tour/{maDatTour}/tu-choi-thanh-toan', [KinhDoanhCompatController::class, 'tuChoiThanhToan']);
    Route::put('yeu-cau-ho-tro/{maYeuCau}', [KinhDoanhCompatController::class, 'capNhatYeuCauHoTro']);
    Route::post('yeu-cau-ho-tro/{maYeuCau}/yeu-cau-hdv-giai-trinh', [KinhDoanhCompatController::class, 'yeuCauHdvGiaiTrinh']);
    Route::post('yeu-cau-ho-tro/{maYeuCau}/yeu-cau-khach-hang-bo-sung', [KinhDoanhCompatController::class, 'yeuCauKhachHangBoSung']);
});

Route::get('huong-dan-vien/su-co', [KinhDoanhCompatController::class, 'suCoCuaHdv'])
    ->middleware(['auth:api', 'role:HDV,ADMIN,KINHDOANH,DIEUHANH,KETOAN,SANPHAM']);
