<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin dữ liệu.
class DangKyRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện request này không
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Quy tắc xác thực dữ liệu đầu vào
     */
    public function rules()
    {
        return [
            'tenDangNhap' => 'required|string|min:4|max:100',
            'matKhau' => 'required|string|min:6',
            'xacNhanMatKhau' => 'required|string',
            'hoTen' => 'required|string|max:200',
            'email' => 'nullable|email',
            'cccd' => 'nullable|string|max:20',
            'ngaySinh' => 'nullable|date',
            'soDienThoai' => 'nullable|string|max:20'
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi bằng tiếng Việt
     */
    public function messages()
    {
        return [
            'tenDangNhap.required' => 'Tên đăng nhập không được để trống',
            'tenDangNhap.min' => 'Tên đăng nhập phải từ 4 đến 100 ký tự',
            'tenDangNhap.max' => 'Tên đăng nhập phải từ 4 đến 100 ký tự',
            'matKhau.required' => 'Mật khẩu không được để trống',
            'matKhau.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'xacNhanMatKhau.required' => 'Xác nhận mật khẩu không được để trống',
            'hoTen.required' => 'Họ tên không được để trống',
            'email.email' => 'email không hợp lệ'
        ];
    }
}
