<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApDungVoucherRequest;
use App\Http\Requests\DoiDiemVoucherRequest;
use App\Http\Resources\DonDatTourResource;
use App\Http\Resources\KhuyenMaiKhResource;
use App\Http\Resources\ContractPaginationResource;
use App\Http\Resources\VoucherAdminResource;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherService $voucherService
    ) {}

    public function apDungVoucher(ApDungVoucherRequest $request)
    {
        $donDatTour = $this->voucherService->apDungVoucherChoDon(
            auth()->user()->MaTaiKhoan,
            $request->validated()
        );

        return $this->successResponse(new DonDatTourResource($donDatTour), 'Áp dụng voucher thành công');
    }

    public function apVoucher(ApDungVoucherRequest $request)
    {
        $voucher = $this->voucherService->apVoucherTheoContract(
            auth()->user()->MaTaiKhoan,
            $request->validated()
        );

        return $this->successResponse(new VoucherAdminResource($voucher), 'Áp dụng voucher thành công');
    }

    public function danhSachVoucher(Request $request)
    {
        $perPage = (int) $request->query('per_page', $request->query('size', 10));
        $paginator = $this->voucherService->layDanhSachVoucherCuaKhach(auth()->user()->MaTaiKhoan, $perPage);

        return $this->successResponse(
            KhuyenMaiKhResource::collection($paginator)->response()->getData(true),
            'Lấy danh sách voucher thành công'
        );
    }

    public function viVoucher(Request $request)
    {
        return $this->danhSachVoucher($request);
    }

    public function voucherCoTheDoi(Request $request)
    {
        $perPage = (int) $request->query('size', $request->query('per_page', 20));
        $paginator = $this->voucherService->danhSachCoTheDoi($perPage);

        $paginator->getCollection()->transform(function ($voucher) {
            return new VoucherAdminResource($voucher);
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Lấy danh sách voucher có thể đổi thành công',
            'data' => new ContractPaginationResource($paginator),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function doiDiem(DoiDiemVoucherRequest $request)
    {
        $khuyenMaiKh = $this->voucherService->doiDiem(
            auth()->user()->MaTaiKhoan,
            $request->validated()['maVoucher']
        );

        return $this->successResponse(new KhuyenMaiKhResource($khuyenMaiKh), 'Đổi điểm lấy voucher thành công');
    }
}
