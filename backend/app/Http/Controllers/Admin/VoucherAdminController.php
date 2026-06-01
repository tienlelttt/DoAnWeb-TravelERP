<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VoucherAdminRequest;
use App\Http\Resources\VoucherAdminResource;
use App\Http\Resources\ContractPaginationResource;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherAdminController extends Controller
{
    public function __construct(
        private VoucherService $voucherService
    ) {}

    /**
     * Lấy danh sách toàn bộ voucher (Dành cho Admin/Kinh doanh)
     */
    public function danhSach(Request $request)
    {
        $perPage = $request->query('size', 10);
        $list = $this->voucherService->danhSachAdmin($perPage);

        $list->getCollection()->transform(function($v) {
            return new VoucherAdminResource($v);
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => new ContractPaginationResource($list)
        ]);
    }

    /**
     * Tạo mới một Voucher (khuyến mãi)
     */
    public function taoVoucher(VoucherAdminRequest $request)
    {
        $voucher = $this->voucherService->taoVoucher($request->validated());

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Tạo voucher thành công',
            'data' => new VoucherAdminResource($voucher)
        ], 201);
    }

    /**
     * Cập nhật thông tin Voucher
     */
    public function capNhatVoucher(VoucherAdminRequest $request, $maVoucher)
    {
        $voucher = $this->voucherService->capNhatVoucher($maVoucher, $request->validated());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Cập nhật voucher thành công',
            'data' => new VoucherAdminResource($voucher)
        ]);
    }

    /**
     * Vô hiệu hóa một Voucher không cho sử dụng tiếp
     */
    public function voHieuHoaVoucher($maVoucher)
    {
        $voucher = $this->voucherService->voHieuHoaVoucher($maVoucher);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Vô hiệu hóa voucher thành công',
            'data' => new VoucherAdminResource($voucher)
        ]);
    }

    /**
     * Phát hành (phân bổ) Voucher trực tiếp vào ví của Khách Hàng (UC54)
     */
    public function phatHanh(Request $request, $maVoucher)
    {
        $request->validate([
            'maKhachHang' => 'required|string'
        ]);

        $km = $this->voucherService->phatHanhVoucher($maVoucher, $request->maKhachHang);

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Phát hành voucher cho khách hàng thành công',
            'data' => new \App\Http\Resources\KhuyenMaiKhResource($km)
        ], 201);
    }

    public function khachHangDaPhanBo($maVoucher)
    {
        $items = \App\Models\KhuyenMaiKh::with(['voucher', 'khachHang.taiKhoan'])
            ->where('ma_voucher', $maVoucher)
            ->orderBy('ngay_nhan', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => \App\Http\Resources\KhuyenMaiKhResource::collection($items)
        ]);
    }

    public function thuHoi(Request $request, $maVoucher, $maKhachHang)
    {
        $khuyenMai = \App\Models\KhuyenMaiKh::with(['voucher', 'khachHang.taiKhoan'])
            ->where('ma_voucher', $maVoucher)
            ->where('ma_khach_hang', $maKhachHang)
            ->first();

        if (!$khuyenMai) {
            throw \App\Exceptions\AppException::notFound('Không tìm thấy voucher đã phân bổ cho khách hàng');
        }

        if ($khuyenMai->trang_thai === 'DA_SU_DUNG') {
            throw \App\Exceptions\AppException::badRequest('Không thể thu hồi voucher đã sử dụng');
        }

        $khuyenMai->trang_thai = 'THU_HOI';
        $khuyenMai->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thu hồi voucher thành công',
            'data' => new \App\Http\Resources\KhuyenMaiKhResource($khuyenMai->fresh(['voucher', 'khachHang.taiKhoan']))
        ]);
    }
}
