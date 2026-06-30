<?php

use App\Http\Controllers\DichVuThemController;
use App\Http\Controllers\HanhDongXanhController;
use App\Http\Controllers\LoaiPhongController;
use App\Http\Controllers\TourMauController;
use Illuminate\Support\Facades\Route;

Route::prefix('san-pham')->group(function () {
    Route::group(['middleware' => ['auth:api', 'role:SANPHAM,DIEUHANH,KINHDOANH,KETOAN,HDV,ADMIN']], function () {
        Route::get('tour-mau', [TourMauController::class, 'danhSach']);
        Route::get('tour-mau/{id}', [TourMauController::class, 'chiTiet']);
        Route::get('loai-phong', [LoaiPhongController::class, 'danhSach']);
        Route::get('dich-vu-them', [DichVuThemController::class, 'danhSach']);
        Route::get('dich-vu-them/{id}', [DichVuThemController::class, 'chiTiet']);
        Route::get('hanh-dong-xanh', [HanhDongXanhController::class, 'danhSach']);
        Route::get('hanh-dong-xanh/{id}', [HanhDongXanhController::class, 'chiTiet']);
    });

    Route::group(['middleware' => ['auth:api', 'role:SANPHAM,ADMIN']], function () {
        Route::post('tour-mau', [TourMauController::class, 'taoMoi']);
        Route::put('tour-mau/{id}', [TourMauController::class, 'capNhat']);
        Route::delete('tour-mau/{id}', [TourMauController::class, 'xoa']);
        Route::post('tour-mau/{id}/sao-chep', [TourMauController::class, 'saoChep']);

        Route::post('tour-mau/{id}/lich-trinh', [TourMauController::class, 'themLichTrinh']);
        Route::put('tour-mau/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'suaLichTrinh']);
        Route::delete('tour-mau/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'xoaLichTrinh']);

        Route::post('loai-phong', [LoaiPhongController::class, 'taoMoi']);
        Route::put('loai-phong/{id}', [LoaiPhongController::class, 'capNhat']);
        Route::delete('loai-phong/{id}', [LoaiPhongController::class, 'xoa']);

        Route::post('dich-vu-them', [DichVuThemController::class, 'taoMoi']);
        Route::put('dich-vu-them/{id}', [DichVuThemController::class, 'capNhat']);
        Route::delete('dich-vu-them/{id}', [DichVuThemController::class, 'xoa']);
    });

    Route::group(['middleware' => ['auth:api', 'role:SANPHAM,DIEUHANH,ADMIN']], function () {
        Route::post('hanh-dong-xanh', [HanhDongXanhController::class, 'taoMoi']);
        Route::put('hanh-dong-xanh/{id}', [HanhDongXanhController::class, 'capNhat']);
        Route::delete('hanh-dong-xanh/{id}', [HanhDongXanhController::class, 'xoa']);
    });
});
