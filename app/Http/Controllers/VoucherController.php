<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApDungVoucherRequest;
use App\Services\VoucherService;
use App\Models\DonDatTour;
use App\Http\Resources\KhuyenMaiKhResource;
use App\Http\Resources\DonDatTourResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * Áp dụng voucher cho một đơn hàng hiện có
     */
    public function apDungVoucher(ApDungVoucherRequest $request)
    {
        $data = $request->validated();
        
        $donDatTour = DonDatTour::where('MaDatTour', $data['maDatTour'])->first();
        // Kiểm tra quyền sở hữu đơn hàng (chỉ khách đặt đơn mới được áp dụng voucher)
        $user = auth()->user();
        
        // Cần load khách hàng từ tài khoản
        $khachHang = \App\Models\HoChieuSo::where('MaTaiKhoan', $user->MaTaiKhoan)->first();
        if (!$khachHang || $donDatTour->MaKhachHang !== $khachHang->MaKhachHang) {
            return $this->errorResponse("Bạn không có quyền thực hiện thao tác này trên đơn hàng này", 403, "FORBIDDEN");
        }

        $result = DB::transaction(function () use ($data, $donDatTour) {
            $tienGiam = $this->voucherService->apDungVoucher($data['maVoucher'], $donDatTour, (float) $donDatTour->TongTien);
            
            // Cập nhật lại tổng tiền đơn hàng sau khi giảm
            $donDatTour->TongTien = (float) $donDatTour->TongTien - $tienGiam;
            $donDatTour->save();

            return $donDatTour;
        });

        // Load các relations để DonDatTourResource hiển thị đầy đủ thông tin
        $result->load(['tourThucTe.tourMau', 'khachHang.taiKhoan', 'chiTietDatTours.khachHang.taiKhoan', 'chiTietDatTours.nguoiDongHanh', 'chiTietDichVus.dichVuThem', 'datTourUuDai.voucher']);

        return $this->successResponse(new DonDatTourResource($result), "Áp dụng voucher thành công");
    }

    /**
     * Lấy danh sách voucher trong ví của khách hàng đang đăng nhập
     */
    public function danhSachVoucher(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->query('per_page', 10);
        
        $paginator = $this->voucherService->layDanhSachVoucherCuaKhach($user->MaTaiKhoan, $perPage);
        
        // Trả về pagination format đúng chuẩn Spring Boot
        return $this->successResponse(
            KhuyenMaiKhResource::collection($paginator)->response()->getData(true),
            "Lấy danh sách voucher thành công"
        );
    }
}
