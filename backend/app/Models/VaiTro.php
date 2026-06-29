<?php

namespace App\Models;

// Model lưu thông tin phân quyền.
class VaiTro extends BaseModel
{
    protected $table = 'vai_tros';
    protected $primaryKey = 'ma_vai_tro';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

}
