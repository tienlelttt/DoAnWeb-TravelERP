<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HoanTienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDatTour' => 'required|string|exists:DONDATTOUR,MaDatTour',
            'trangThai' => 'required|string|in:DONG_Y,TU_CHOI,TC,TB',
        ];
    }

    public function messages(): array
    {
        return [
            'maDatTour.required' => 'Mã đặt tour không được để trống',
            'maDatTour.exists' => 'Đơn đặt tour không tồn tại',
            'trangThai.required' => 'Trạng thái quyết định không được để trống',
            'trangThai.in' => 'Trạng thái quyết định phải là DONG_Y, TC hoặc TU_CHOI, TB',
        ];
    }
}
