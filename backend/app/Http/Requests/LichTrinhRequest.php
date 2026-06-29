<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Model lưu thông tin lịch trình tour.
class LichTrinhRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngayThu' => 'required|integer|min:1',
            'hoatDong' => ['required', 'string', 'max:1000', 'regex:/\\s*(?:[01]\\d|2[0-3]):[0-5]\\d\\s*[-–—]\\s*[^\\r\\n]+(?:\\R\\s*(?:[01]\\d|2[0-3]):[0-5]\\d\\s*[-–—]\\s*[^\\r\\n]+)+\\s*/'],
            'moTa' => 'nullable|string',
            'thucDon' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'ngayThu.required' => 'Ngày thứ không được để trống',
            'ngayThu.min' => 'Ngày thứ phải lớn hơn 0',
            'hoatDong.required' => 'Hoạt động không được để trống',
            'hoatDong.max' => 'Timeline hoạt động tối đa 1000 ký tự',
            'hoatDong.regex' => 'Mỗi ngày phải có ít nhất hai hoạt động theo định dạng HH:mm - Nội dung hoạt động',
        ];
    }
}
