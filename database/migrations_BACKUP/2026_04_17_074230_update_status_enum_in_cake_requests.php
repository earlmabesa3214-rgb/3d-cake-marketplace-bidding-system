<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
{
    DB::statement("ALTER TABLE cake_requests MODIFY COLUMN status ENUM('PENDING','OPEN','BIDDING','ACCEPTED','WAITING_FOR_PAYMENT','IN_PROGRESS','WAITING_FINAL_PAYMENT','COMPLETED','CANCELLED','RUSH_MATCHING') NOT NULL DEFAULT 'PENDING'");
}

    public function down(): void
    {
        DB::statement("ALTER TABLE cake_requests MODIFY COLUMN status ENUM('OPEN','BIDDING','ACCEPTED','IN_PROGRESS','COMPLETED','CANCELLED') NOT NULL DEFAULT 'OPEN'");
    }
};