<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin quyết toán tour.
class QuyetToanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'giaCamKet' => 'nullable|numeric|min:0',
            'ghiChu' => 'nullable|string|max:1000',
            'hoaDonAnh' => 'nullable|string|max:1000',
            'noiDung' => 'nullable|string|max:1000' // Cho truong hop Yeu cau bo sung
        ];
    }
}
