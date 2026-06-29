<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin phân quyền.
class GanVaiTroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maVaiTro' => 'required|string|exists:vai_tros,ma_vai_tro',
        ];
    }

    public function messages(): array
    {
        return [
            'maVaiTro.required' => 'Mã vai trò không được để trống',
            'maVaiTro.exists' => 'Vai trò không tồn tại',
        ];
    }
}
