<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Phân quyền sẽ được xử lý ở Controller/Service
    }

    public function rules(): array
    {
        return [
            'maTourThucTe' => 'required|string',
            'soSao' => 'required|integer|min:1|max:5',
            'nhanXet' => 'nullable|string',
            'soSaoHdv' => 'nullable|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'maTourThucTe.required' => 'maTourThucTe: Mã tour thực tế không được để trống',
            'soSao.required' => 'soSao: Số sao đánh giá không được để trống',
            'soSao.integer' => 'soSao: Số sao phải là một số nguyên',
            'soSao.min' => 'soSao: Số sao tối thiểu là 1',
            'soSao.max' => 'soSao: Số sao tối đa là 5',
            'soSaoHdv.integer' => 'soSaoHdv: Số sao đánh giá HDV phải là một số nguyên',
            'soSaoHdv.min' => 'soSaoHdv: Số sao đánh giá HDV tối thiểu là 1',
            'soSaoHdv.max' => 'soSaoHdv: Số sao đánh giá HDV tối đa là 5',
        ];
    }
}
