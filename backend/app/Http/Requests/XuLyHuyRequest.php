<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XuLyHuyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDatTour' => 'required|string|exists:don_dat_tours,ma_dat_tour',
            'trangThai' => 'required|string|in:DONG_Y,TU_CHOI,TC,TB',
        ];
    }

    public function messages(): array
    {
        return [
            'maDatTour.required' => 'Mã đặt tour không được để trống',
            'maDatTour.exists' => 'Đơn đặt tour không tồn tại',
            'trangThai.required' => 'Trạng thái xử lý không được để trống',
            'trangThai.in' => 'Trạng thái xử lý phải là DONG_Y, TC hoặc TU_CHOI, TB',
        ];
    }
}
