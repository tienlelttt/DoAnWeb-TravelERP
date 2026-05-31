<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatTourMauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tieuDe' => 'required|string|max:500',
            'moTa' => 'nullable|string',
            'thoiLuong' => 'required|integer|min:1',
            'giaSan' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'tieuDe.required' => 'Tiêu đề không được để trống',
            'tieuDe.max' => 'Tiêu đề tối đa 500 ký tự',
            'thoiLuong.required' => 'Thời lượng không được để trống',
            'thoiLuong.min' => 'Thời lượng phải ít nhất 1 ngày',
            'giaSan.required' => 'Giá sàn không được để trống',
            'giaSan.min' => 'Giá sàn phải lớn hơn 0',
        ];
    }
}
