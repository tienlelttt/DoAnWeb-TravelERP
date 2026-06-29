<?php

namespace App\Models;

// Model lưu thông tin dữ liệu.
class LoaiPhong extends BaseModel
{
    protected $table = 'loai_phongs';
    protected $primaryKey = 'ma_loai_phong';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
}
