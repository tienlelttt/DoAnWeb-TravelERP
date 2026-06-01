<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaoCaoSuCoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "maKhachHang" => "nullable|string",
            "maNguoiDongHanh" => "nullable|string",
            "moTa" => "required|string",
            "giaiPhap" => "nullable|string",
            "mucDo" => "required|string|in:THAP,SOS",
            "loaiSuCo" => "required|string|in:Y_TE,THOI_TIET,PHUONG_TIEN,AN_UONG,KHACH_HANG,DICH_VU,KHAC"
        ];
    }
}
