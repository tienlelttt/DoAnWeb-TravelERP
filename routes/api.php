<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/dang-ky', [AuthController::class, 'dangKy']);
    Route::post('/dang-nhap', [AuthController::class, 'dangNhap']);
    
    // Các route cần đăng nhập (có token)
    Route::middleware('auth:api')->group(function () {
        Route::post('/doi-mat-khau', [AuthController::class, 'doiMatKhau']);
        Route::post('/dang-xuat', [AuthController::class, 'dangXuat']);
    });
});

use App\Http\Controllers\TourCongKhaiController;
use App\Http\Controllers\TourMauController;
use App\Http\Controllers\TourThucTeController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DatTourController;

// ── UC25 & UC26: API Công Khai (Không cần đăng nhập)
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

Route::group(['prefix' => 'khach-hang', 'middleware' => ['auth:api', 'role:KHACHHANG']], function () {
    Route::post('danh-gia', [DanhGiaController::class, 'guiDanhGia']);
    
    // Đặt Tour
    Route::post('dat-tour', [DatTourController::class, 'datTour']);
    Route::get('don-dat-tour', [DatTourController::class, 'danhSachCuaToi']);
    Route::get('don-dat-tour/{id}', [DatTourController::class, 'chiTietCuaToi']);
    Route::put('don-dat-tour/{id}/huy', [DatTourController::class, 'huyDatTour']);
});

Route::prefix('san-pham')->group(function () {
    Route::prefix('tour-mau')->group(function () {
        Route::get('/', [TourMauController::class, 'danhSach']);
        Route::get('/{id}', [TourMauController::class, 'chiTiet']);
        Route::post('/', [TourMauController::class, 'taoMoi']);
        Route::put('/{id}', [TourMauController::class, 'capNhat']);
        Route::delete('/{id}', [TourMauController::class, 'xoa']);
        Route::post('/{id}/sao-chep', [TourMauController::class, 'saoChep']);
        
        // Lịch trình
        Route::post('/{id}/lich-trinh', [TourMauController::class, 'themLichTrinh']);
        Route::put('/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'suaLichTrinh']);
        Route::delete('/{id}/lich-trinh/{maLichTrinh}', [TourMauController::class, 'xoaLichTrinh']);
    });

    // Dịch vụ thêm
    Route::prefix('dich-vu-them')->group(function () {
        Route::get('/', [\App\Http\Controllers\DichVuThemController::class, 'danhSach']);
        Route::get('/{id}', [\App\Http\Controllers\DichVuThemController::class, 'chiTiet']);
        Route::post('/', [\App\Http\Controllers\DichVuThemController::class, 'taoMoi']);
        Route::put('/{id}', [\App\Http\Controllers\DichVuThemController::class, 'capNhat']);
        Route::delete('/{id}', [\App\Http\Controllers\DichVuThemController::class, 'xoa']);
    });

    // Hành động xanh
    Route::prefix('hanh-dong-xanh')->group(function () {
        Route::get('/', [\App\Http\Controllers\HanhDongXanhController::class, 'danhSach']);
        Route::get('/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'chiTiet']);
        Route::post('/', [\App\Http\Controllers\HanhDongXanhController::class, 'taoMoi']);
        Route::put('/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'capNhat']);
        Route::delete('/{id}', [\App\Http\Controllers\HanhDongXanhController::class, 'xoa']);
    });
});
