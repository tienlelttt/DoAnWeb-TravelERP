<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Model lưu thông tin tài khoản người dùng.
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
     * Lấy danh sách các quy tắc xác thực cho request.
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
                Rule::unique('tai_khoans', 'cccd')->ignore($userId, 'ma_tai_khoan')
            ],
            'ngaySinh' => 'nullable|date',
            'email' => [
                'nullable',
                'email',
                'max:200',
                Rule::unique('tai_khoans', 'email')->ignore($userId, 'ma_tai_khoan')
            ],
            'soDienThoai' => 'nullable|string|max:20',
            'vaiTro' => 'required|string|exists:vai_tros,ma_vai_tro',
            'trangThai' => 'required|string|in:HOAT_DONG,KHOA',
        ];

        if ($this->isMethod('post')) {
            $rules['tenDangNhap'] = 'required|string|max:100|unique:tai_khoans,ten_dang_nhap';
            $rules['matKhau'] = 'required|string|min:6';
        } else {
            $rules['tenDangNhap'] = [
                'required',
                'string',
                'max:100',
                Rule::unique('tai_khoans', 'ten_dang_nhap')->ignore($userId, 'ma_tai_khoan')
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
            'email.unique' => 'email đã tồn tại trong hệ thống.',
            'cccd.unique' => 'cccd đã tồn tại trong hệ thống.',
            'vaiTro.required' => 'Vai trò không được để trống.',
            'vaiTro.exists' => 'Vai trò không hợp lệ.',
            'trangThai.required' => 'Trạng thái không được để trống.',
            'trangThai.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
