<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin tour thực tế.
class TaoTourThucTeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maTourMau' => 'required|string',
            'ngayKhoiHanh' => 'required|date|after:today',
            'soKhachToiDa' => 'required|integer|min:1',
            'soKhachToiThieu' => 'nullable|integer|min:1',
            'giaHienHanh' => 'required|numeric|min:0.01',
            'trangThai' => 'nullable|string',
            'maDichVuThem' => 'nullable|array',
            'maDichVuThem.*' => 'string',
            'maHanhDongXanh' => 'nullable|array',
            'maHanhDongXanh.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'maTourMau.required' => 'Mã tour mẫu không được để trống',
            'ngayKhoiHanh.required' => 'Ngày khởi hành không được để trống',
            'ngayKhoiHanh.after' => 'Ngày khởi hành phải ở tương lai',
            'soKhachToiDa.required' => 'Số khách tối đa không được để trống',
            'soKhachToiDa.min' => 'Số khách tối đa phải ít nhất 1',
            'soKhachToiThieu.min' => 'Số khách tối thiểu phải ít nhất 1',
            'giaHienHanh.required' => 'Giá hiện hành không được để trống',
            'giaHienHanh.min' => 'Giá hiện hành phải lớn hơn 0',
        ];
    }
}
