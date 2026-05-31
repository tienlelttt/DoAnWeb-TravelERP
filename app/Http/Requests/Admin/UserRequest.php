<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware sẽ lo việc kiểm tra quyền ADMIN
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Khi Update, id nằm trong route (userId hoặc tai_khoan)
        $userId = $this->route('user'); 

        $rules = [
            'hoTen' => 'required|string|max:200',
            'cccd' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('TAIKHOAN', 'CCCD')->ignore($userId, 'MaTaiKhoan')
            ],
            'ngaySinh' => 'nullable|date',
            'email' => [
                'nullable',
                'email',
                'max:200',
                Rule::unique('TAIKHOAN', 'Email')->ignore($userId, 'MaTaiKhoan')
            ],
            'soDienThoai' => 'nullable|string|max:20',
            'vaiTro' => 'required|string|exists:VAITRO,MaVaiTro',
            'trangThai' => 'required|string|in:HOAT_DONG,KHOA',
        ];

        if ($this->isMethod('post')) {
            $rules['tenDangNhap'] = 'required|string|max:100|unique:TAIKHOAN,TenDangNhap';
            $rules['matKhau'] = 'required|string|min:6';
        } else {
            // Cập nhật, tenDangNhap có thể không đổi
            $rules['tenDangNhap'] = [
                'required',
                'string',
                'max:100',
                Rule::unique('TAIKHOAN', 'TenDangNhap')->ignore($userId, 'MaTaiKhoan')
            ];
            // Mật khẩu có thể không truyền khi update
            $rules['matKhau'] = 'nullable|string|min:6';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tenDangNhap.required' => 'Tên đăng nhập không được để trống.',
            'tenDangNhap.unique' => 'Tên đăng nhập đã tồn tại.',
            'matKhau.required' => 'Mật khẩu không được để trống.',
            'matKhau.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'hoTen.required' => 'Họ tên không được để trống.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'cccd.unique' => 'CCCD đã tồn tại trong hệ thống.',
            'vaiTro.required' => 'Vai trò không được để trống.',
            'vaiTro.exists' => 'Vai trò không hợp lệ.',
            'trangThai.required' => 'Trạng thái không được để trống.',
            'trangThai.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
