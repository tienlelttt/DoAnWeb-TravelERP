<?php

use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DieuHanhController;
use App\Http\Controllers\DieuHanhVanHanhController;
use App\Http\Controllers\HdvController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\TourThucTeController;
use Illuminate\Support\Facades\Route;

Route::prefix('dieu-hanh')->group(function () {
    Route::group(['prefix' => 'tour-thuc-te', 'middleware' => ['auth:api', 'role:SANPHAM,DIEUHANH,KINHDOANH,KETOAN,HDV,ADMIN']], function () {
        Route::get('/', [TourThucTeController::class, 'danhSach']);
        Route::get('/{id}', [TourThucTeController::class, 'chiTiet']);
    });

    Route::group(['prefix' => 'tour-thuc-te', 'middleware' => ['auth:api', 'role:SANPHAM,DIEUHANH,ADMIN']], function () {
        Route::post('/', [TourThucTeController::class, 'taoMoi']);
        Route::put('/{id}', [TourThucTeController::class, 'capNhat']);
        Route::delete('/{id}', [TourThucTeController::class, 'xoa']);
    });

    Route::group(['middleware' => ['auth:api', 'role:DIEUHANH,ADMIN']], function () {
        Route::post('/phan-cong', [DieuHanhController::class, 'phanCongTour']);
        Route::post('/phan-cong-tour', [DieuHanhController::class, 'phanCongTour']);
        Route::get('/tour-can-phan-cong', [DieuHanhController::class, 'tourCanPhanCong']);
        Route::get('/hdv-kha-dung', [DieuHanhController::class, 'hdvKhaDung']);
        Route::delete('/phan-cong/{id}', [DieuHanhController::class, 'huyPhanCong']);
        Route::get('/nhan-vien/{maNhanVien}/nang-luc', [DieuHanhController::class, 'layNangLucNhanVien']);
        Route::put('/nhan-vien/{maNhanVien}/nang-luc', [DieuHanhController::class, 'capNhatNangLucNhanVien']);
        Route::get('/nhan-vien/{maNhanVien}/lich-cong-tac', [DieuHanhController::class, 'layLichCongTacNhanVien']);
        Route::get('/tour/{maTour}/doan', [DieuHanhVanHanhController::class, 'danhSachDoan']);
        Route::get('/tour/{maTour}/su-co', [DieuHanhVanHanhController::class, 'danhSachSuCo']);
        Route::get('/tour/{maTour}/chi-phi', [DieuHanhVanHanhController::class, 'chiPhiCuaTour']);
    });

    Route::get('danh-gia', [DanhGiaController::class, 'tatCaDanhGia'])->middleware(['auth:api', 'role:KINHDOANH,ADMIN']);
});

Route::group(['prefix' => 'hdv', 'middleware' => ['auth:api', 'role:HDV']], function () {
    Route::post('/phan-cong/{id}/tra-loi', [HdvController::class, 'traLoiPhanCong']);
});

Route::group(['prefix' => 'huong-dan-vien', 'middleware' => ['auth:api', 'role:HDV']], function () {
    Route::get('/ho-so', [NhanVienController::class, 'layHoSo']);
    Route::get('/nang-luc', [NhanVienController::class, 'layNangLuc']);
    Route::get('/tour-cua-toi', [HdvController::class, 'tourCuaToi']);

    Route::post('/phan-cong/{maPhanCong}/dong-y', [HdvController::class, 'dongYPhanCong']);
    Route::post('/phan-cong/{maPhanCong}/tu-choi', [HdvController::class, 'tuChoiPhanCong']);

    Route::get('/yeu-cau-giai-trinh', [HdvController::class, 'danhSachYeuCauGiaiTrinh']);
    Route::put('/yeu-cau-giai-trinh/{maYeuCau}', [HdvController::class, 'capNhatGiaiTrinh']);

    Route::get('/quyet-toan/can-bo-sung', [HdvController::class, 'quyetToanCanBoSung']);
    Route::put('/quyet-toan/{maQuyetToan}/bo-sung', [HdvController::class, 'boSungQuyetToan']);

    Route::get('/chi-phi', [HdvController::class, 'tatCaChiPhi']);
    Route::get('/hanh-dong-xanh', [HdvController::class, 'tatCaHanhDongXanh']);

    Route::get('/tour/{maTour}/lich-trinh', [HdvController::class, 'lichTrinhTour']);
    Route::get('/tour/{maTour}/doan', [HdvController::class, 'danhSachDoan']);
    Route::post('/tour/{maTour}/diem-danh', [HdvController::class, 'diemDanh']);
    Route::post('/tour/{maTour}/hanh-dong-xanh', [HdvController::class, 'ghiNhanHanhDong']);
    Route::get('/tour/{maTour}/su-co', [HdvController::class, 'danhSachSuCo']);
    Route::post('/tour/{maTour}/su-co', [HdvController::class, 'baoCaoSuCo']);
    Route::put('/su-co/{maSuCo}', [HdvController::class, 'capNhatSuCo']);
    Route::get('/tour/{maTour}/chi-phi', [HdvController::class, 'chiPhiCuaTour']);
    Route::post('/tour/{maTour}/chi-phi', [HdvController::class, 'khaiChiPhi']);
    Route::put('/chi-phi/{maChiPhi}/bo-sung', [HdvController::class, 'boSungChiPhi']);
    Route::delete('/chi-phi/{maChiPhi}', [HdvController::class, 'huyChiPhi']);
});
