<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HanhDongXanhRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "maKhachHang" => "required|string",
            "maHanhDongXanh" => "required|string",
            "minhChung" => "nullable|string"
        ];
    }
}
