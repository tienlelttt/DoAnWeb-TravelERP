<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NhatKyHeThongController;
use App\Http\Controllers\Admin\ReportPdfController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\QuanTriCompatController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'role:ADMIN', 'audit_log']], function () {
    Route::get('/dashboard/overview', [DashboardController::class, 'overview']);
    Route::get('/dashboard/revenue-chart', [DashboardController::class, 'revenueChart']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/nhat-ky-he-thong', [NhatKyHeThongController::class, 'danhSach']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'role:ADMIN,KETOAN']], function () {
    Route::post('/report/pdf/{type}', [ReportPdfController::class, 'exportPDF']);
});

Route::group(['prefix' => 'quan-tri', 'middleware' => ['auth:api', 'role:ADMIN,DIEUHANH,KINHDOANH,KETOAN,SANPHAM', 'audit_log']], function () {
    Route::get('/nhan-vien', [QuanTriCompatController::class, 'danhSachNhanVien']);
    Route::get('/nhan-vien/{nhanVien}', [QuanTriCompatController::class, 'chiTietNhanVien']);
});

Route::group(['prefix' => 'quan-tri', 'middleware' => ['auth:api', 'role:ADMIN', 'audit_log']], function () {
    Route::get('/nhat-ky-he-thong', [NhatKyHeThongController::class, 'danhSach']);
    Route::post('/dang-ky-nhan-vien', [QuanTriCompatController::class, 'dangKyNhanVien']);
    Route::put('/nhan-vien/{nhanVien}/vai-tro', [QuanTriCompatController::class, 'ganVaiTro']);
    Route::put('/nhan-vien/{nhanVien}/mo-khoa', [QuanTriCompatController::class, 'moKhoaTaiKhoan']);
    Route::put('/nhan-vien/{nhanVien}/khoa', [QuanTriCompatController::class, 'khoaTaiKhoan']);
});
