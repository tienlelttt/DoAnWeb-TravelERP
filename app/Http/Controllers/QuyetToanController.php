<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\QuyetToanRequest;
use App\Http\Resources\QuyetToanResource;
use App\Http\Resources\SpringPaginationResource;
use App\Services\QuyetToanService;
use Illuminate\Http\Request;

class QuyetToanController extends Controller
{
    public function __construct(
        private QuyetToanService $quyetToanService
    ) {}

    /**
     * Lấy danh sách tour đã kết thúc nhưng chưa quyết toán (UC47)
     */
    public function tourCanQuyetToan(Request $request)
    {
        $perPage = $request->query('size', 10);
        $tours = $this->quyetToanService->tourCanQuyetToan($perPage);

        $tours->getCollection()->transform(function($tour) {
            return new QuyetToanResource($tour);
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => new SpringPaginationResource($tours)
        ]);
    }

    /**
     * Tính toán sơ bộ lợi nhuận (UC48 - Xem trước, không lưu)
     */
    public function tinhToan($maTour)
    {
        $data = $this->quyetToanService->tinhToan($maTour);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Tính toán sơ bộ thành công',
            'data' => new QuyetToanResource($data)
        ]);
    }

    /**
     * Tạo bản nháp quyết toán cho Tour (UC49)
     */
    public function taoQuyetToan(QuyetToanRequest $request, $maTour)
    {
        $user = auth('api')->user();
        $data = $this->quyetToanService->taoQuyetToan($maTour, $request->validated(), $user->MaTaiKhoan);

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Tạo bản nháp quyết toán thành công',
            'data' => new QuyetToanResource($data)
        ], 201);
    }

    /**
     * Chốt sổ quyết toán, chuyển trạng thái sang DA_QUYET_TOAN (UC50)
     */
    public function chotQuyetToan($maQuyetToan)
    {
        $data = $this->quyetToanService->chotQuyetToan($maQuyetToan);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Chốt quyết toán thành công',
            'data' => new QuyetToanResource($data)
        ]);
    }

    /**
     * Yêu cầu Hướng Dẫn Viên bổ sung chứng từ, hóa đơn
     */
    public function yeuCauBoSung(QuyetToanRequest $request, $maQuyetToan)
    {
        $data = $this->quyetToanService->yeuCauBoSung($maQuyetToan, $request->noiDung);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Đã gửi yêu cầu bổ sung',
            'data' => new QuyetToanResource($data)
        ]);
    }

    /**
     * Xem danh sách các quyết toán (UC51)
     */
    public function danhSach(Request $request)
    {
        $trangThai = $request->query('trangThai');
        $perPage = $request->query('size', 10);

        $list = $this->quyetToanService->danhSach($trangThai, $perPage);
        $list->getCollection()->transform(function($qt) {
            return new QuyetToanResource($qt);
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => new SpringPaginationResource($list)
        ]);
    }

    /**
     * Xem chi tiết một quyết toán
     */
    public function chiTiet($maQuyetToan)
    {
        $data = $this->quyetToanService->chiTiet($maQuyetToan);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => new QuyetToanResource($data)
        ]);
    }
}
