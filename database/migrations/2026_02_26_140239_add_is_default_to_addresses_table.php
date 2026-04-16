<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // is_default already included in 2026_02_24_000001_create_addresses_table
    }

    public function down(): void
    {
        // Nothing to undo
    }
};