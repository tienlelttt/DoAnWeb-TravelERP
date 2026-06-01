<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationFreshSeederTest extends TestCase
{
    public function test_migration_fresh_seed_chay_duoc_tu_database_rong(): void
    {
        try {
            Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);

            $this->assertTrue(Schema::hasTable('tai_khoans'));
            $this->assertTrue(Schema::hasTable('tour_thuc_tes'));
            $this->assertTrue(Schema::hasTable('don_dat_tours'));
            $this->assertTrue(Schema::hasTable('giao_diches'));

            $this->assertTrue(Schema::hasColumn('don_dat_tours', 'ma_dat_tour'));
            $this->assertTrue(Schema::hasColumn('don_dat_tours', 'ma_khach_hang'));
            $this->assertTrue(Schema::hasColumn('don_dat_tours', 'trang_thai'));
            $this->assertTrue(Schema::hasColumn('tour_thuc_tes', 'ngay_khoi_hanh'));

            $this->assertDatabaseHas('vai_tros', ['ma_vai_tro' => 'ADMIN']);
            $this->assertDatabaseHas('vai_tros', ['ma_vai_tro' => 'KHACHHANG']);
            $this->assertDatabaseHas('tai_khoans', [
                'ten_dang_nhap' => 'admin',
                'vai_tro' => 'ADMIN',
            ]);
        } finally {
            Artisan::call('migrate:fresh', [
                '--force' => true,
            ]);
        }
    }
}
