<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

// Hủy đơn đặt tour quá hạn 24h
Schedule::command('bookings:cancel-expired')->hourly();

// Cập nhật giá động cho tour
Schedule::command('pricing:update-dynamic')->dailyAt('00:00');
