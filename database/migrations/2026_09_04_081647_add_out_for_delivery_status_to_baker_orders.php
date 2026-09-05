<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // baker_orders: add OUT_FOR_DELIVERY between READY/WAITING_FINAL_PAYMENT and DELIVERED
        DB::statement("ALTER TABLE baker_orders MODIFY COLUMN status ENUM(
            'ACCEPTED',
            'WAITING_FOR_PAYMENT',
            'PREPARING',
            'READY',
            'WAITING_FINAL_PAYMENT',
            'OUT_FOR_DELIVERY',
            'DELIVERED',
            'COMPLETED',
            'CANCELLED'
        ) NOT NULL DEFAULT 'ACCEPTED'");
    }

    public function down(): void
    {
        // Move any OUT_FOR_DELIVERY rows back to READY before dropping the enum value
        DB::statement("UPDATE baker_orders SET status = 'READY' WHERE status = 'OUT_FOR_DELIVERY'");

        DB::statement("ALTER TABLE baker_orders MODIFY COLUMN status ENUM(
            'ACCEPTED',
            'WAITING_FOR_PAYMENT',
            'PREPARING',
            'READY',
            'WAITING_FINAL_PAYMENT',
            'DELIVERED',
            'COMPLETED',
            'CANCELLED'
        ) NOT NULL DEFAULT 'ACCEPTED'");
    }
};