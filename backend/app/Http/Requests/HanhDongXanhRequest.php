<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin hành động xanh.
class HanhDongXanhRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "tenHanhDong" => "required|string|max:255",
            "diemCong" => "required|integer|min:0",
            "maTourThucTe" => "nullable|string"
        ];
    }
}
