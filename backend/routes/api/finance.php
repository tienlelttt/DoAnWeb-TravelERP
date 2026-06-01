<?php

use App\Http\Controllers\HoanTienController;
use App\Http\Controllers\KeToanChiPhiController;
use App\Http\Controllers\KeToanHoanTienController;
use App\Http\Controllers\PowerBiController;
use App\Http\Controllers\QuyetToanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'ke-toan', 'middleware' => ['auth:api', 'role:KETOAN,ADMIN']], function () {
    Route::post('hoan-tien', [HoanTienController::class, 'hoanTien']);

    Route::get('giao-dich-hoan', [KeToanHoanTienController::class, 'danhSachChoHoanTien']);
    Route::put('giao-dich-hoan/{maGiaoDich}/xac-nhan', [KeToanHoanTienController::class, 'xacNhanHoanTien']);
    Route::put('giao-dich-hoan/{maGiaoDich}/tu-choi', [KeToanHoanTienController::class, 'tuChoiHoanTien']);

    Route::get('tour-can-quyet-toan', [QuyetToanController::class, 'tourCanQuyetToan']);
    Route::get('quyet-toan', [QuyetToanController::class, 'danhSach']);
    Route::get('quyet-toan/{maQuyetToan}', [QuyetToanController::class, 'chiTiet']);
    Route::get('tinh-toan/{maTour}', [QuyetToanController::class, 'tinhToan']);
    Route::post('quyet-toan/{maTour}', [QuyetToanController::class, 'taoQuyetToan']);
    Route::put('quyet-toan/{maQuyetToan}/chot', [QuyetToanController::class, 'chotQuyetToan']);
    Route::post('quyet-toan/{maQuyetToan}/yeu-cau-bo-sung', [QuyetToanController::class, 'yeuCauBoSung']);

    Route::prefix('power-bi')->group(function () {
        Route::get('kho-du-lieu', [PowerBiController::class, 'danhSachKhoDuLieu']);
        Route::get('ket-noi', [PowerBiController::class, 'layThongTinKetNoi']);
        Route::post('xuat-du-lieu', [PowerBiController::class, 'xuatDuLieu']);
    });

    Route::get('/chi-phi', [KeToanChiPhiController::class, 'danhSachChiPhi']);
    Route::get('/canh-bao-chi-phi', [KeToanChiPhiController::class, 'canhBaoChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/duyet', [KeToanChiPhiController::class, 'duyetChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/tu-choi', [KeToanChiPhiController::class, 'tuChoiChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/yeu-cau-bo-sung', [KeToanChiPhiController::class, 'yeuCauBoSungChiPhi']);
});
