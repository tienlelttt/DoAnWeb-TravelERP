<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin dữ liệu.
class DangNhapRequest extends FormRequest
{
    /**
     * Xác định quyền
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Luật xác thực
     */
    public function rules()
    {
        return [
            'tenDangNhap' => 'required|string',
            'matKhau' => 'required|string'
        ];
    }

    /**
     * Thông báo lỗi
     */
    public function messages()
    {
        return [
            'tenDangNhap.required' => 'Tên đăng nhập không được để trống',
            'matKhau.required' => 'Mật khẩu không được để trống'
        ];
    }
}
