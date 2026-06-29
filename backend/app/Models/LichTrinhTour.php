<?php

namespace App\Models;

// Model lưu thông tin lịch trình tour.
class LichTrinhTour extends BaseModel
{
    protected $table = 'lich_trinh_tours';
    protected $primaryKey = 'ma_lich_trinh_tour';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function tourMau()
    {
        return $this->belongsTo(TourMau::class, 'ma_tour_mau', 'ma_tour_mau');
    }
}
