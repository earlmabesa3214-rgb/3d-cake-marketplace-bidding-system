<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add escrow columns to payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->string('escrow_status')->default('pending')->after('status');
            // pending | held | released | refunded
            $table->string('platform_reference')->nullable()->after('escrow_status');
            $table->timestamp('held_at')->nullable()->after('platform_reference');
            $table->timestamp('released_at')->nullable()->after('held_at');
            $table->timestamp('refunded_at')->nullable()->after('released_at');
        });

        // 2. Add payout columns to baker_orders
        Schema::table('baker_orders', function (Blueprint $table) {
            $table->decimal('platform_fee', 10, 2)->default(0)->after('payout_status');
            $table->decimal('baker_payout', 10, 2)->nullable()->after('platform_fee');
            $table->timestamp('payout_released_at')->nullable()->after('baker_payout');
        });

        // 3. Create baker_wallets table
        Schema::create('baker_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baker_id')->unique()->constrained('users')->onDelete('cascade');
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('total_earned', 10, 2)->default(0);
            $table->decimal('total_withdrawn', 10, 2)->default(0);
            $table->timestamps();
        });

        // 4. Create withdrawal_requests table
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baker_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            // pending | approved | rejected
            $table->string('payment_method');
            // gcash | maya | bank
            $table->string('account_name');
            $table->string('account_number');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('admin_note')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 5. Add platform payment settings to a config table (or use .env)
        // We'll use a simple platform_accounts table
        Schema::create('platform_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // gcash | maya
            $table->string('account_name');
            $table->string('account_number');
            $table->string('qr_code_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['escrow_status','platform_reference','held_at','released_at','refunded_at']);
        });
        Schema::table('baker_orders', function (Blueprint $table) {
            $table->dropColumn(['platform_fee','baker_payout','payout_released_at']);
        });
        Schema::dropIfExists('platform_accounts');
        Schema::dropIfExists('withdrawal_requests');
        Schema::dropIfExists('baker_wallets');
    }
};