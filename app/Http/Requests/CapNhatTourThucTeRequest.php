<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatTourThucTeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngayKhoiHanh' => 'nullable|date|after:today',
            'soKhachToiDa' => 'nullable|integer|min:1',
            'soKhachToiThieu' => 'nullable|integer|min:1',
            'giaHienHanh' => 'nullable|numeric|min:0.01',
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
            'ngayKhoiHanh.after' => 'Ngày khởi hành phải ở tương lai',
            'soKhachToiDa.min' => 'Số khách tối đa phải ít nhất 1',
            'soKhachToiThieu.min' => 'Số khách tối thiểu phải ít nhất 1',
            'giaHienHanh.min' => 'Giá hiện hành phải lớn hơn 0',
        ];
    }
}
