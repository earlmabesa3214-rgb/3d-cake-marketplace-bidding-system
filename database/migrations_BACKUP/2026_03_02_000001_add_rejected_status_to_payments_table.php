<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the status ENUM to include 'rejected'
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','paid','confirmed','rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','paid','confirmed') NOT NULL DEFAULT 'pending'");
    }
};