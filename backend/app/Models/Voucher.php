<?php

namespace App\Models;

// Model lưu thông tin voucher.
class Voucher extends BaseModel
{
    protected $table = 'vouchers';
    protected $primaryKey = 'ma_voucher';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

}
