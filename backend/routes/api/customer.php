<?php

use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DatTourController;
use App\Http\Controllers\HuyDonController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'khach-hang', 'middleware' => ['auth:api', 'role:KHACHHANG,ADMIN']], function () {
    Route::post('danh-gia', [DanhGiaController::class, 'guiDanhGia']);

    Route::post('dat-tour', [DatTourController::class, 'datTour']);
    Route::get('don-dat-tour', [DatTourController::class, 'danhSachCuaToi']);
    Route::get('don-dat-tour/{id}', [DatTourController::class, 'chiTietCuaToi']);
    Route::put('don-dat-tour/{id}/huy', [DatTourController::class, 'huyDatTour']);
    Route::post('huy-don', [HuyDonController::class, 'yeuCauHuyDon']);

    Route::post('don-dat-tour/ap-dung-voucher', [VoucherController::class, 'apDungVoucher']);
    Route::get('voucher', [VoucherController::class, 'danhSachVoucher']);
    Route::get('vi-voucher', [VoucherController::class, 'viVoucher']);
    Route::get('voucher-co-the-doi', [VoucherController::class, 'voucherCoTheDoi']);
    Route::post('ap-voucher', [VoucherController::class, 'apVoucher']);
    Route::post('doi-diem', [VoucherController::class, 'doiDiem']);

    Route::get('/ho-so', [KhachHangController::class, 'layHoSo']);
    Route::put('/ho-so', [KhachHangController::class, 'capNhatHoSo']);
    Route::get('/dich-vu-them', [KhachHangController::class, 'danhSachDichVuThem']);
    Route::get('/dat-tour', [KhachHangController::class, 'danhSachDatTour']);
    Route::get('/dat-tour/{maDatTour}', [DatTourController::class, 'chiTietCuaToi']);
    Route::get('/lich-su-tour', [KhachHangController::class, 'lichSuTour']);
    Route::get('/yeu-cau-ho-tro', [KhachHangController::class, 'layDanhSachYeuCauHoTro']);
    Route::post('/yeu-cau-ho-tro', [KhachHangController::class, 'taoYeuCauHoTro']);
    Route::get('/yeu-cau-ho-tro/can-bo-sung', [KhachHangController::class, 'yeuCauHoTroCanBoSung']);
    Route::put('/yeu-cau-ho-tro/{maYeuCau}/bo-sung', [KhachHangController::class, 'boSungYeuCauHoTro']);
    Route::post('/dat-tour/{maDatTour}/huy', [KhachHangController::class, 'yeuCauHuyTour']);
});

Route::group(['middleware' => ['auth:api', 'role:KHACHHANG']], function () {
    Route::post('dat-tour/ap-dung-voucher', [VoucherController::class, 'apDungVoucher']);
});
