<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Database schema is already created with snake_case columns in
        // 2026_01_01_000000_create_all_tables.php. Keeping this migration as a
        // no-op preserves migration history without renaming columns to
        // themselves, which can fail on a fresh database.
    }

    public function down(): void
    {
        // No-op by design.
    }
};
