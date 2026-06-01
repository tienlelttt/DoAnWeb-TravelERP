<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/dang-ky', [AuthController::class, 'dangKy']);
    Route::post('/dang-nhap', [AuthController::class, 'dangNhap']);
    Route::post('/quen-mat-khau', [AuthController::class, 'quenMatKhau']);
    Route::post('/dat-lai-mat-khau', [AuthController::class, 'datLaiMatKhau']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/kiem-tra-mat-khau', [AuthController::class, 'kiemTraMatKhau']);
        Route::post('/doi-mat-khau', [AuthController::class, 'doiMatKhau']);
        Route::post('/dang-xuat', [AuthController::class, 'dangXuat']);
    });
});
