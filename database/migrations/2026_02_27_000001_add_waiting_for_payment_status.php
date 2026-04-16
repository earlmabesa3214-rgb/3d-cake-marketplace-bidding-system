<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // baker_orders: add WAITING_FINAL_PAYMENT before DELIVERED
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

        // cake_requests: add WAITING_FINAL_PAYMENT
        DB::statement("ALTER TABLE cake_requests MODIFY COLUMN status ENUM(
            'PENDING',
            'OPEN',
            'BIDDING',
            'ACCEPTED',
            'WAITING_FOR_PAYMENT',
            'IN_PROGRESS',
            'WAITING_FINAL_PAYMENT',
            'COMPLETED',
            'CANCELLED'
        ) NOT NULL DEFAULT 'PENDING'");
    }

    public function down(): void
    {
        DB::statement("UPDATE baker_orders SET status = 'READY' WHERE status = 'WAITING_FINAL_PAYMENT'");
        DB::statement("UPDATE cake_requests SET status = 'IN_PROGRESS' WHERE status = 'WAITING_FINAL_PAYMENT'");

        DB::statement("ALTER TABLE baker_orders MODIFY COLUMN status ENUM(
            'ACCEPTED',
            'WAITING_FOR_PAYMENT',
            'PREPARING',
            'READY',
            'DELIVERED',
            'COMPLETED',
            'CANCELLED'
        ) NOT NULL DEFAULT 'ACCEPTED'");

        DB::statement("ALTER TABLE cake_requests MODIFY COLUMN status ENUM(
            'PENDING',
            'OPEN',
            'BIDDING',
            'ACCEPTED',
            'WAITING_FOR_PAYMENT',
            'IN_PROGRESS',
            'COMPLETED',
            'CANCELLED'
        ) NOT NULL DEFAULT 'PENDING'");
    }
};