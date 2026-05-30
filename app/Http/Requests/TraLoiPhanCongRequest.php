<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TraLoiPhanCongRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "trangThaiTraLoi" => "required|string|in:DA_DONG_Y,TU_CHOI",
        ];
    }

    public function messages()
    {
        return [
            "trangThaiTraLoi.required" => "Trạng thái trả lời không được để trống.",
            "trangThaiTraLoi.in" => "Trạng thái trả lời phải là DA_DONG_Y hoặc TU_CHOI.",
        ];
    }
}
