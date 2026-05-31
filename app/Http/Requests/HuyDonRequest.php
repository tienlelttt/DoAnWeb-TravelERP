<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HuyDonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDatTour' => 'required|string|exists:don_dat_tours,ma_dat_tour',
            'lyDo' => 'required|string|min:5|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'maDatTour.required' => 'Mã đặt tour không được để trống',
            'maDatTour.exists' => 'Đơn đặt tour không tồn tại',
            'lyDo.required' => 'Lý do hủy đơn không được để trống',
            'lyDo.min' => 'Lý do hủy đơn phải từ 5 ký tự trở lên',
            'lyDo.max' => 'Lý do hủy đơn tối đa 255 ký tự',
        ];
    }
}
