<?php

namespace App\Models;

class Voucher extends BaseModel
{
    protected $table = 'VOUCHER';
    protected $primaryKey = 'MaVoucher';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

}
