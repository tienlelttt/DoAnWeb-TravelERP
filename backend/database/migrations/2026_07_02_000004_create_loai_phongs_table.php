<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('loai_phongs')) {
            return;
        }

        Schema::create('loai_phongs', function (Blueprint $table) {
            $table->string('ma_loai_phong', 50)->primary();
            $table->string('ten_loai', 200);
            $table->decimal('muc_phu_thu', 18, 2)->default(0);
            $table->string('trang_thai', 20)->default('HOAT_DONG');
            $table->timestamps();

            $table->index('trang_thai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loai_phongs');
    }
};
