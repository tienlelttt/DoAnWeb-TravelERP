<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaoYeuCauHoTroRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "maDatTour" => "nullable|string",
            "loaiYeuCau" => "required|string|max:100",
            "noiDung" => "required|string|max:255"
        ];
    }
}
