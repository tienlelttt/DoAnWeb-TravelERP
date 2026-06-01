<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiemDanhRequest extends FormRequest
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
            "loaiKhach" => "required|string|in:KHACH_CHINH,NGUOI_DONG_HANH",
            "diaDiem" => "nullable|string",
            "trangThai" => "required|string|in:DA_DIEM_DANH,VANG,CHUA_DIEM_DANH",
            "ghiChu" => "nullable|string"
        ];
    }
}
