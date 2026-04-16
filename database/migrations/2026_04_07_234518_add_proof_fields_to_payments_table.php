<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('customer_id');
            }
            if (!Schema::hasColumn('payments', 'proof_of_payment_path')) {
                $table->string('proof_of_payment_path')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('payments', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('proof_of_payment_path');
            }
            if (!Schema::hasColumn('payments', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('payments', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('confirmed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $columns = ['payment_method', 'proof_of_payment_path', 'paid_at', 'confirmed_at', 'rejected_at'];
            $existing = array_filter($columns, fn($col) => Schema::hasColumn('payments', $col));
            
            if (!empty($existing)) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};