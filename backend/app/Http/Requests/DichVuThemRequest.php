<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DichVuThemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'ten' => 'required|string|max:255',
            'donGia' => 'required|numeric|min:0',
            'donViTinh' => 'nullable|string|max:50',
        ];

        // Nếu là PUT (cập nhật), cho phép không gửi các trường
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['ten'] = 'sometimes|required|string|max:255';
            $rules['donGia'] = 'sometimes|required|numeric|min:0';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ten.required' => 'ten: Tên dịch vụ không được để trống',
            'donGia.required' => 'donGia: Đơn giá không được để trống',
            'donGia.numeric' => 'donGia: Đơn giá phải là số',
            'donGia.min' => 'donGia: Đơn giá phải lớn hơn hoặc bằng 0',
        ];
    }
}
