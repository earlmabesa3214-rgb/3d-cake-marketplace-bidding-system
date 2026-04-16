<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baker_payment_methods', function (Blueprint $table) {
            // Add missing columns only if they don't already exist
            if (!Schema::hasColumn('baker_payment_methods', 'baker_id')) {
                $table->foreignId('baker_id')->after('id')->constrained('bakers')->onDelete('cascade');
            }
            if (!Schema::hasColumn('baker_payment_methods', 'type')) {
                $table->enum('type', ['gcash', 'maya', 'cash'])->default('gcash')->after('baker_id');
            }
            if (!Schema::hasColumn('baker_payment_methods', 'account_name')) {
                $table->string('account_name')->nullable()->after('type');
            }
            if (!Schema::hasColumn('baker_payment_methods', 'account_number')) {
                $table->string('account_number')->nullable()->after('account_name');
            }
            if (!Schema::hasColumn('baker_payment_methods', 'qr_code_path')) {
                $table->string('qr_code_path')->nullable()->after('account_number');
            }
            if (!Schema::hasColumn('baker_payment_methods', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('qr_code_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('baker_payment_methods', function (Blueprint $table) {
            $table->dropForeign(['baker_id']);
            $table->dropColumn(['baker_id', 'type', 'account_name', 'account_number', 'qr_code_path', 'is_active']);
        });
    }
};