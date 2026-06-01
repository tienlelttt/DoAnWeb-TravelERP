<?php

use App\Http\Controllers\NhanVienController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'nhan-vien', 'middleware' => ['auth:api', 'role:KINHDOANH,DIEUHANH,HDV,KETOAN']], function () {
    Route::get('/ho-so', [NhanVienController::class, 'layHoSo']);
    Route::get('/lich-cong-tac', [NhanVienController::class, 'layLichCongTac']);
    Route::get('/nang-luc', [NhanVienController::class, 'layNangLuc']);
});
