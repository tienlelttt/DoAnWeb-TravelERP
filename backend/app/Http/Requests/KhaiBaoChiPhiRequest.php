<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhaiBaoChiPhiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "danhMuc" => "required|string",
            "thanhTien" => "required|numeric|min:0",
            "hoaDonAnh" => "nullable|string",
            "ghiChu" => "nullable|string"
        ];
    }
}
