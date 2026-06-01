<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Models\LoaiPhong;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoaiPhongController extends Controller
{
    /**
     * Lấy danh sách loại phòng để frontend quản trị sản phẩm hiển thị.
     */
    public function danhSach(): JsonResponse
    {
        $data = LoaiPhong::orderBy('ten_loai')
            ->get()
            ->map(fn (LoaiPhong $loaiPhong) => $this->toResponse($loaiPhong));

        return $this->successResponse($data, 'Thành công');
    }

    /**
     * Tạo mới loại phòng và ánh xạ payload camelCase từ frontend sang cột snake_case.
     */
    public function taoMoi(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tenLoai' => 'required|string|max:200',
            'mucPhuThu' => 'nullable|numeric|min:0',
            'trangThai' => 'nullable|string|max:20',
        ]);

        $loaiPhong = LoaiPhong::create([
            'ma_loai_phong' => 'LP_' . strtoupper(substr(Str::uuid()->toString(), 0, 8)),
            'ten_loai' => $data['tenLoai'],
            'muc_phu_thu' => $data['mucPhuThu'] ?? 0,
            'trang_thai' => $data['trangThai'] ?? 'HOAT_DONG',
        ]);

        return $this->successResponse($this->toResponse($loaiPhong), 'Tạo loại phòng thành công', 201);
    }

    /**
     * Cập nhật thông tin loại phòng theo mã loại phòng hiện có.
     */
    public function capNhat(Request $request, string $id): JsonResponse
    {
        $loaiPhong = $this->findLoaiPhong($id);

        $data = $request->validate([
            'tenLoai' => 'required|string|max:200',
            'mucPhuThu' => 'nullable|numeric|min:0',
            'trangThai' => 'nullable|string|max:20',
        ]);

        $loaiPhong->ten_loai = $data['tenLoai'];
        $loaiPhong->muc_phu_thu = $data['mucPhuThu'] ?? 0;
        $loaiPhong->trang_thai = $data['trangThai'] ?? $loaiPhong->trang_thai;
        $loaiPhong->save();

        return $this->successResponse($this->toResponse($loaiPhong), 'Cập nhật loại phòng thành công');
    }

    /**
     * Xóa loại phòng theo contract DELETE hiện tại của frontend.
     */
    public function xoa(string $id): JsonResponse
    {
        $loaiPhong = $this->findLoaiPhong($id);
        $loaiPhong->delete();

        return $this->noContent('Xóa loại phòng thành công');
    }

    /**
     * Tìm loại phòng hoặc trả lỗi 404 thống nhất theo AppException.
     */
    private function findLoaiPhong(string $id): LoaiPhong
    {
        $loaiPhong = LoaiPhong::find($id);
        if (!$loaiPhong) {
            throw AppException::notFound('Không tìm thấy loại phòng');
        }

        return $loaiPhong;
    }

    /**
     * Chuyển dữ liệu model snake_case sang response camelCase mà frontend đang dùng.
     */
    private function toResponse(LoaiPhong $loaiPhong): array
    {
        return [
            'maLoaiPhong' => $loaiPhong->ma_loai_phong,
            'tenLoai' => $loaiPhong->ten_loai,
            'mucPhuThu' => (float) $loaiPhong->muc_phu_thu,
            'trangThai' => $loaiPhong->trang_thai,
        ];
    }
}
