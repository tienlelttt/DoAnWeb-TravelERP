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
            'tenDangNhap' => 'required|string|max:100|unique:tai_khoans,ten_dang_nhap',
            'matKhau' => 'required|string|min:6',
            'hoTen' => 'required|string|max:200',
            'email' => 'nullable|email|max:200|unique:tai_khoans,email',
            'soDienThoai' => 'nullable|string|max:20',
            'maVaiTro' => 'required_without:vaiTro|string|exists:vai_tros,ma_vai_tro',
            'vaiTro' => 'required_without:maVaiTro|string|exists:vai_tros,ma_vai_tro',
        ];
    }

    public function messages(): array
    {
        return [
            'tenDangNhap.required' => 'Tên đăng nhập không được để trống',
            'tenDangNhap.unique' => 'Tên đăng nhập đã tồn tại',
            'matKhau.required' => 'Mật khẩu không được để trống',
            'hoTen.required' => 'Họ tên không được để trống',
            'email.unique' => 'email đã được sử dụng',
            'maVaiTro.required_without' => 'Vai trò không được để trống',
            'vaiTro.required_without' => 'Vai trò không được để trống',
        ];
    }
}
