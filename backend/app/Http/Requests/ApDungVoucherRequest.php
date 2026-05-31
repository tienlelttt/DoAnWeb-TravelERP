<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApDungVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDatTour' => 'required|string|exists:don_dat_tours,ma_dat_tour',
            'maVoucher' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'maDatTour.required' => 'Mã đặt tour không được để trống',
            'maDatTour.exists' => 'Đơn đặt tour không tồn tại',
            'maVoucher.required' => 'Mã voucher không được để trống',
        ];
    }
}
