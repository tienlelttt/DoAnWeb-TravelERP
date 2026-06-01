<?php

use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\TourCongKhaiController;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->group(function () {
    Route::get('/tour', [TourCongKhaiController::class, 'danhSachTour']);
    Route::get('/tour/{maTourThucTe}', [TourCongKhaiController::class, 'chiTietTour']);
    Route::get('/tour/{maTourThucTe}/lich-trinh', [TourCongKhaiController::class, 'lichTrinh']);
    Route::get('/tour/{id}/danh-gia', [DanhGiaController::class, 'danhSachDanhGia']);
});

Route::group(['prefix' => 'public/tour'], function () {
    Route::get('/{maTour}/lich-trinh', [TourCongKhaiController::class, 'lichTrinh']);
    Route::get('/{maTour}/hanh-dong-xanh', [TourCongKhaiController::class, 'hanhDongXanh']);
    Route::get('/{maTour}/dich-vu-them', [TourCongKhaiController::class, 'dichVuThem']);
    Route::get('/{maTour}/danh-gia', [TourCongKhaiController::class, 'danhGiaKhachHang']);
});
