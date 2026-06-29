<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin đơn đặt tour.
class DatTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maTourThucTe' => 'required|string|exists:tour_thuc_tes,ma_tour_thuc_te',
            'ghiChu' => 'nullable|string',
            'maVoucher' => 'nullable|string',
            
            // Người đồng hành
            'danhSachNguoiDongHanh' => 'nullable|array',
            'danhSachNguoiDongHanh.*.hoTen' => 'required|string',
            'danhSachNguoiDongHanh.*.cccd' => 'nullable|string',
            'danhSachNguoiDongHanh.*.soDienThoai' => 'nullable|string',
            'danhSachNguoiDongHanh.*.ngaySinh' => 'required|date',
            'danhSachNguoiDongHanh.*.gioiTinh' => 'nullable|string',
            'danhSachNguoiDongHanh.*.ghiChu' => 'nullable|string',

            // Dịch vụ thêm
            'danhSachDichVu' => 'nullable|array',
            'danhSachDichVu.*.maDichVuThem' => 'required|string',
            'danhSachDichVu.*.soLuong' => 'required|integer|min:1',

            // Hành động xanh chi tiết
            'danhSachHanhDongXanhChiTiet' => 'nullable|array',
            'danhSachHanhDongXanhChiTiet.*.maHanhDongXanh' => 'required|string',
            'danhSachHanhDongXanhChiTiet.*.soLuong' => 'nullable|integer|min:1',

            // Hành động xanh dạng rút gọn
            'danhSachHanhDongXanh' => 'nullable|array',
            'danhSachHanhDongXanh.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'maTourThucTe.required' => 'Mã tour thực tế không được để trống',
            'danhSachNguoiDongHanh.*.hoTen.required' => 'Họ tên người đồng hành không được để trống',
            'danhSachNguoiDongHanh.*.ngaySinh.required' => 'Ngày sinh người đồng hành không được để trống',
            'danhSachNguoiDongHanh.*.ngaySinh.date' => 'Ngày sinh người đồng hành không đúng định dạng',
            'danhSachDichVu.*.maDichVuThem.required' => 'Mã dịch vụ thêm không được để trống',
            'danhSachDichVu.*.soLuong.required' => 'Số lượng dịch vụ không được để trống',
            'danhSachDichVu.*.soLuong.min' => 'Số lượng dịch vụ phải lớn hơn 0',
        ];
    }
}
