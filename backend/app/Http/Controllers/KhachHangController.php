<?php

namespace App\Http\Controllers;

use App\Services\KhachHangService;
use App\Http\Requests\CapNhatHoSoRequest;
use App\Http\Requests\TaoYeuCauHoTroRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KhachHangController extends Controller
{
    protected KhachHangService $khachHangService;

    public function __construct(KhachHangService $khachHangService)
    {
        $this->khachHangService = $khachHangService;
    }

    private function getMaTaiKhoan(): string
    {
        return auth()->user()->ma_tai_khoan;
    }

    public function layHoSo(): JsonResponse
    {
        $data = $this->khachHangService->layHoSo($this->getMaTaiKhoan());
        return $this->successResponse($data, "Lấy hồ sơ thành công");
    }

    public function capNhatHoSo(CapNhatHoSoRequest $request): JsonResponse
    {
        $data = $this->khachHangService->capNhatHoSo($this->getMaTaiKhoan(), $request->validated());
        return $this->successResponse($data, "Cập nhật hồ sơ thành công");
    }

    public function danhSachDatTour(Request $request): JsonResponse
    {
        $size = (int) $request->query('size', 15);
        $data = $this->khachHangService->danhSachDatTour($this->getMaTaiKhoan(), $size);
        return $this->successResponse($data, "Thành công");
    }

    public function lichSuTour(Request $request): JsonResponse
    {
        $size = (int) $request->query('size', 15);
        $data = $this->khachHangService->lichSuTour($this->getMaTaiKhoan(), $size);
        return $this->successResponse($data, "Thành công");
    }

    public function layDanhSachYeuCauHoTro(Request $request): JsonResponse
    {
        $filters = $request->only(['loaiYeuCau', 'trangThai', 'page', 'size']);
        $data = $this->khachHangService->layDanhSachYeuCauHoTro($this->getMaTaiKhoan(), $filters);
        return $this->successResponse($data, "Thành công");
    }

    public function taoYeuCauHoTro(TaoYeuCauHoTroRequest $request): JsonResponse
    {
        $data = $this->khachHangService->taoYeuCauHoTro($this->getMaTaiKhoan(), $request->validated());
        return $this->successResponse($data, "Tạo yêu cầu hỗ trợ thành công");
    }

    public function yeuCauHuyTour(string $maDatTour, Request $request): JsonResponse
    {
        $data = $request->validate([
            "lyDoHuy" => "nullable|string"
        ]);
        $res = $this->khachHangService->yeuCauHuyTour($this->getMaTaiKhoan(), $maDatTour, $data);
        return $this->successResponse($res, "Gửi yêu cầu hủy tour thành công");
    }

    public function yeuCauHoTroCanBoSung(Request $request): JsonResponse
    {
        $size = (int) $request->query('size', 15);
        $data = $this->khachHangService->yeuCauHoTroCanBoSung($this->getMaTaiKhoan(), $size);
        return $this->successResponse($data);
    }

    public function boSungYeuCauHoTro(string $maYeuCau, Request $request): JsonResponse
    {
        $data = $request->validate([
            "noiDungBoSung" => "required|string"
        ]);
        
        $res = $this->khachHangService->boSungYeuCauHoTro($this->getMaTaiKhoan(), $maYeuCau, $data);
        return $this->successResponse($res, "Bổ sung thông tin thành công");
    }

    public function danhSachDichVuThem(Request $request, \App\Services\DichVuThemService $dichVuThemService): JsonResponse
    {
        $maTourThucTe = $request->query('maTourThucTe');
        return $this->successResponse($dichVuThemService->danhSach($maTourThucTe), "Thành công");
    }
}
