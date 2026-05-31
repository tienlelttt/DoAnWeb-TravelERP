<?php

namespace App\Http\Controllers;

use App\Http\Requests\TraLoiPhanCongRequest;
use App\Http\Requests\DiemDanhRequest;
use App\Http\Requests\HanhDongXanhRequest;
use App\Http\Requests\BaoCaoSuCoRequest;
use App\Http\Requests\KhaiBaoChiPhiRequest;
use App\Services\PhanCongTourService;
use App\Services\VanHanhService;
use App\Models\NhanVien;
use App\Exceptions\AppException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HdvController extends Controller
{
    protected PhanCongTourService $phanCongService;
    protected VanHanhService $vanHanhService;

    public function __construct(PhanCongTourService $phanCongService, VanHanhService $vanHanhService)
    {
        $this->phanCongService = $phanCongService;
        $this->vanHanhService = $vanHanhService;
    }

    private function getHdvId(): string
    {
        $user = auth()->user();
        $hdv = NhanVien::where("ma_tai_khoan", $user->ma_tai_khoan)->first();
        if (!$hdv) {
            throw AppException::forbidden("Tài khoản của bạn không được liên kết với hồ sơ nhân viên hướng dẫn");
        }
        return $hdv->ma_nhan_vien;
    }

    public function traLoiPhanCong(string $maPhanCong, TraLoiPhanCongRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $data = $request->validated();
        $phanCong = $this->phanCongService->hdvTraLoiPhanCong($maPhanCong, $data["trangThaiTraLoi"], $maHdv);
        
        return $this->successResponse($phanCong, "Đã phản hồi yêu cầu phân công");
    }

    public function lichTrinhTour(string $maTour): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->layLichTrinh($maTour, $maHdv);
        return $this->successResponse($res, "Thành công");
    }

    public function danhSachDoan(string $maTour): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->layDanhSachKhach($maTour, $maHdv);
        return $this->successResponse($res, "Thành công");
    }

    public function diemDanh(string $maTour, DiemDanhRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->diemDanh($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Điểm danh thành công");
    }

    public function ghiNhanHanhDong(string $maTour, HanhDongXanhRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->ghiNhanHanhDongXanh($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Ghi nhận hành động xanh thành công");
    }

    public function danhSachSuCo(string $maTour): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->layDanhSachSuCo($maTour, $maHdv);
        return $this->successResponse($res, "Thành công");
    }

    public function baoCaoSuCo(string $maTour, BaoCaoSuCoRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->baoCaoSuCo($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Báo cáo sự cố thành công");
    }

    public function capNhatSuCo(string $maSuCo, Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        // Simple validation directly
        $data = $request->validate([
            "moTa" => "nullable|string",
            "giaiPhap" => "nullable|string"
        ]);
        $res = $this->vanHanhService->capNhatSuCo($maSuCo, $maHdv, $data);
        return $this->successResponse($res, "Cập nhật sự cố thành công");
    }

    public function chiPhiCuaTour(string $maTour): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->layDanhSachChiPhi($maTour, $maHdv);
        return $this->successResponse($res, "Thành công");
    }

    public function khaiChiPhi(string $maTour, KhaiBaoChiPhiRequest $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $res = $this->vanHanhService->khaiBaoChiPhi($maTour, $maHdv, $request->validated());
        return $this->successResponse($res, "Khai báo chi phí thành công");
    }

    public function boSungChiPhi(string $maChiPhi, Request $request): JsonResponse
    {
        $maHdv = $this->getHdvId();
        $data = $request->validate([
            "hoaDonAnh" => "required|string"
        ]);
        $res = $this->vanHanhService->boSungChiPhi($maChiPhi, $maHdv, $data);
        return $this->successResponse($res, "Bổ sung chi phí thành công");
    }
}
