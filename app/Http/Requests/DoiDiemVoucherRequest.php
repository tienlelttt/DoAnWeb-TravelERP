<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoiDiemVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maVoucher' => 'required|string|exists:VOUCHER,MaVoucher',
        ];
    }

    public function messages(): array
    {
        return [
            'maVoucher.required' => 'Mã voucher không được để trống',
            'maVoucher.exists' => 'Voucher không tồn tại',
        ];
    }
}
