<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin tour mẫu.
class TaoTourMauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tieuDe' => 'required|string|max:500',
            'moTa' => 'nullable|string',
            'thoiLuong' => 'required|integer|min:1',
            'giaSan' => 'required|numeric|min:0.01',
            
            'lichTrinh' => 'nullable|array',
            'lichTrinh.*.ngayThu' => 'required|integer|min:1',
            'lichTrinh.*.hoatDong' => ['required', 'string', 'max:1000', 'regex:/\\s*(?:[01]\\d|2[0-3]):[0-5]\\d\\s*[-–—]\\s*[^\\r\\n]+(?:\\R\\s*(?:[01]\\d|2[0-3]):[0-5]\\d\\s*[-–—]\\s*[^\\r\\n]+)+\\s*/'],
            'lichTrinh.*.moTa' => 'nullable|string',
            'lichTrinh.*.thucDon' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'tieuDe.required' => 'Tiêu đề không được để trống',
            'tieuDe.max' => 'Tiêu đề tối đa 500 ký tự',
            'thoiLuong.required' => 'Thời lượng không được để trống',
            'thoiLuong.min' => 'Thời lượng phải ít nhất 1 ngày',
            'giaSan.required' => 'Giá sàn không được để trống',
            'giaSan.min' => 'Giá sàn phải lớn hơn 0',
            'lichTrinh.*.ngayThu.required' => 'Ngày thứ không được để trống',
            'lichTrinh.*.ngayThu.min' => 'Ngày thứ phải lớn hơn 0',
            'lichTrinh.*.hoatDong.required' => 'Hoạt động không được để trống',
            'lichTrinh.*.hoatDong.max' => 'Timeline hoạt động tối đa 1000 ký tự',
            'lichTrinh.*.hoatDong.regex' => 'Mỗi ngày phải có ít nhất hai hoạt động theo định dạng HH:mm - Nội dung hoạt động',
        ];
    }
}
