<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Nạp dữ liệu cơ sở cho toàn bộ hệ thống.
     */
    public function run(): void
    {
        $this->call([
            CoreSystemSeeder::class,
            RealDataSeeder::class,
        ]);
    }
}