<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VoucherAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maCode' => 'required|string|max:50',
            'loaiUuDai' => 'required|in:PHAN_TRAM,SO_TIEN',
            'giaTriGiam' => 'required|numeric|min:0',
            'mucGiamToiDa' => 'nullable|numeric|min:0',
            'dieuKienApDung' => 'nullable|string|max:1000',
            'soLuotPhatHanh' => 'required|integer|min:1',
            'ngayHieuLuc' => 'required|date',
            'ngayHetHan' => 'required|date|after_or_equal:ngayHieuLuc',
        ];
    }
}
