<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

abstract class BaseModel extends Model
{
    /**
     * (C) ĐỊNH DẠNG DATE ISO
     * Chuẩn bị ngày tháng để chuyển đổi sang mảng / JSON.
     * Ép Laravel trả về chuẩn ISO-8601 để tương thích 100% với Jackson của Spring Boot.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        // VD: 2023-10-15T14:30:00+07:00
        return $date->format('Y-m-d\TH:i:sP'); 
    }
}
