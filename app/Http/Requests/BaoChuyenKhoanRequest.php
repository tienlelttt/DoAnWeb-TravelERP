<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaoChuyenKhoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDatTour' => 'required|string|exists:DONDATTOUR,MaDatTour',
            'maGDNH' => 'required|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'maDatTour.required' => 'Mã đặt tour không được để trống',
            'maDatTour.exists' => 'Đơn đặt tour không tồn tại',
            'maGDNH.required' => 'Mã giao dịch ngân hàng không được để trống',
            'maGDNH.min' => 'Mã giao dịch ngân hàng phải từ 3 ký tự trở lên',
        ];
    }
}
