<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chi_phi_thuc_tes', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_phi_thuc_tes', 'ghi_chu')) {
                $table->text('ghi_chu')->nullable()->after('hoa_don_anh');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chi_phi_thuc_tes', function (Blueprint $table) {
            if (Schema::hasColumn('chi_phi_thuc_tes', 'ghi_chu')) {
                $table->dropColumn('ghi_chu');
            }
        });
    }
};
