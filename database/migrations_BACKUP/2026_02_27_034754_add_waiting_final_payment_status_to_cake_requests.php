<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update any existing rows that might have invalid status
        DB::table('cake_requests')
            ->whereNotIn('status', [
                'OPEN',
                'CANCELLED', 
                'IN_PROGRESS',
                'COMPLETED',
                'WAITING_FOR_PAYMENT',
                'WAITING_FINAL_PAYMENT',
            ])
            ->update(['status' => 'OPEN']);
    }

    public function down(): void
    {
        //
    }
};