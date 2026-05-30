<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

abstract class BaseModel extends Model
{
    /**
     * (C) ĐỊNH DẠNG DATE ISO
     * Chuẩn bị ngày tháng để chuyển đổi sang mảng / JSON theo chuẩn ISO-8601.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        // VD: 2023-10-15T14:30:00+07:00
        return $date->format('Y-m-d\TH:i:sP'); 
    }

    /**
     * Tự động chuyển đổi tất cả các cột sang camelCase khi serialize sang JSON
     * để phù hợp với chuẩn giao tiếp của Frontend React.
     */
    public function toArray()
    {
        $array = parent::toArray();
        $camelArray = [];
        
        foreach ($array as $key => $value) {
            $camelKey = \Illuminate\Support\Str::camel($key);
            $camelArray[$camelKey] = $value;
        }
        
        return $camelArray;
    }
}
