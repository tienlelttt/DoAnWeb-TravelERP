<?php

namespace App\Models;

class VaiTro extends BaseModel
{
    protected $table = 'vai_tros';
    protected $primaryKey = 'ma_vai_tro';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

}
