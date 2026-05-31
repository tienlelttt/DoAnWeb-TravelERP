<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangKyNhanVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenDangNhap' => 'required|string|max:100|unique:TAIKHOAN,TenDangNhap',
            'matKhau' => 'required|string|min:6',
            'hoTen' => 'required|string|max:200',
            'email' => 'nullable|email|max:200|unique:TAIKHOAN,Email',
            'soDienThoai' => 'nullable|string|max:20',
            'maVaiTro' => 'required_without:vaiTro|string|exists:VAITRO,MaVaiTro',
            'vaiTro' => 'required_without:maVaiTro|string|exists:VAITRO,MaVaiTro',
        ];
    }

    public function messages(): array
    {
        return [
            'tenDangNhap.required' => 'Tên đăng nhập không được để trống',
            'tenDangNhap.unique' => 'Tên đăng nhập đã tồn tại',
            'matKhau.required' => 'Mật khẩu không được để trống',
            'hoTen.required' => 'Họ tên không được để trống',
            'email.unique' => 'Email đã được sử dụng',
            'maVaiTro.required_without' => 'Vai trò không được để trống',
            'vaiTro.required_without' => 'Vai trò không được để trống',
        ];
    }
}
