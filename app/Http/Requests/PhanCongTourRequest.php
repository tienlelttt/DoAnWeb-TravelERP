<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhanCongTourRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "maTourThucTe" => "required|string",
            "maNhanVien" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "maTourThucTe.required" => "Mã tour thực tế không được để trống.",
            "maNhanVien.required" => "Mã nhân viên hướng dẫn không được để trống.",
        ];
    }
}
