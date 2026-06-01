<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yeu_cau_ho_tros', function (Blueprint $table) {
            $table->text('noi_dung')->change();
        });
    }

    public function down(): void
    {
        Schema::table('yeu_cau_ho_tros', function (Blueprint $table) {
            $table->string('noi_dung', 255)->change();
        });
    }
};
