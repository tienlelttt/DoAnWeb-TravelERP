<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatHoSoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "hoTen" => "nullable|string|max:200",
            "cccd" => "nullable|string|max:20",
            "soDienThoai" => "nullable|string|max:20",
            "ngaySinh" => "nullable|date",
            "ghiChuYTe" => "nullable|string",
            "diUng" => "nullable|string"
        ];
    }
}
