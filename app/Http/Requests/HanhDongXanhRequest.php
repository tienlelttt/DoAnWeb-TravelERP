<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HanhDongXanhRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'tenHanhDong' => 'required|string|max:255',
            'diemCong' => 'required|integer|min:0',
            'maTourThucTe' => 'nullable|string',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['tenHanhDong'] = 'sometimes|required|string|max:255';
            $rules['diemCong'] = 'sometimes|required|integer|min:0';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tenHanhDong.required' => 'tenHanhDong: Tên hành động xanh không được để trống',
            'diemCong.required' => 'diemCong: Điểm cộng không được để trống',
            'diemCong.integer' => 'diemCong: Điểm cộng phải là số nguyên',
            'diemCong.min' => 'diemCong: Điểm cộng phải lớn hơn hoặc bằng 0',
        ];
    }
}
