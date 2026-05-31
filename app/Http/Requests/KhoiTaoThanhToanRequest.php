<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhoiTaoThanhToanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDonDatTour' => 'required_without:maDatTour|string',
            'maDatTour' => 'required_without:maDonDatTour|string',
            'phuongThuc' => 'nullable|string',
            'mock' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'maDonDatTour.required_without' => 'Mã đơn đặt tour không được để trống',
            'maDatTour.required_without' => 'Mã đặt tour không được để trống',
        ];
    }
}
