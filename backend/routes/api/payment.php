<?php

use App\Http\Controllers\ThanhToanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'thanh-toan'], function () {
    Route::group(['middleware' => ['auth:api', 'role:KHACHHANG,ADMIN']], function () {
        Route::post('khoi-tao', [ThanhToanController::class, 'khoiTaoThanhToan']);
        Route::post('mock', [ThanhToanController::class, 'thanhToanMock']);
        Route::post('bao-chuyen-khoan', [ThanhToanController::class, 'baoChuyenKhoan']);
        Route::post('{maDatTour}/het-han-qr', [ThanhToanController::class, 'hetHanThanhToanQr']);
        Route::post('{maDatTour}/xac-nhan-chuyen-khoan', [ThanhToanController::class, 'xacNhanDaChuyenKhoan']);
        Route::get('{maDatTour}/ket-qua', [ThanhToanController::class, 'ketQua']);
        Route::post('vnpay/tao-url', [ThanhToanController::class, 'taoThanhToanVnpay']);
    });

    Route::get('vnpay/return', [ThanhToanController::class, 'vnpayReturn']);
    Route::get('vnpay/ipn', [ThanhToanController::class, 'vnpayIpn']);
});
