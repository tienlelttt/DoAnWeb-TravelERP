<?php

namespace App\Models;

class VaiTro extends BaseModel
{
    protected $table = 'VAITRO';
    protected $primaryKey = 'MaVaiTro';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

}
