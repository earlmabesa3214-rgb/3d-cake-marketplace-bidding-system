<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Unified wallets table (both customer and baker)
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('balance', 12, 2)->default(0);
            $table->decimal('total_deposited', 12, 2)->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);
            $table->decimal('total_earned', 12, 2)->default(0);
            $table->decimal('total_withdrawn', 12, 2)->default(0);
            $table->string('status')->default('active'); // active | frozen
            $table->timestamps();
        });

        // 2. Every single money movement — full audit trail
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->string('type'); // deposit|escrow_hold|escrow_release|escrow_refund|withdrawal|fee|cashin
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);
            $table->string('reference_code')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('related_order_id')->nullable();
            $table->unsignedBigInteger('related_payment_id')->nullable();
            $table->string('status')->default('completed'); // completed|pending|failed
            $table->timestamps();
        });

        // 3. Escrow holds — replaces payments.escrow_status
        Schema::create('escrow_holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->foreignId('baker_wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('baker_orders')->onDelete('cascade');
            $table->string('payment_type'); // downpayment | final
            $table->decimal('amount', 12, 2);
            $table->decimal('platform_fee_rate', 5, 4)->default(0.0500);
            $table->decimal('platform_fee_amount', 12, 2)->default(0);
            $table->decimal('baker_payout_amount', 12, 2)->default(0);
            $table->string('status')->default('held'); // held|released|refunded|forfeited
            $table->timestamp('held_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });

        // 4. GCash cash-in requests
        Schema::create('cash_in_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('gcash_reference')->nullable();
            $table->string('paymongo_source_id')->nullable();
            $table->string('paymongo_checkout_url')->nullable();
            $table->string('proof_path')->nullable();
            $table->string('method')->default('gcash'); // gcash|maya|paymongo
            $table->string('status')->default('pending'); // pending|approved|rejected|expired
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });

        // 5. Baker withdrawal requests
        Schema::create('wallet_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending|approved|rejected
            $table->string('payment_method'); // gcash|maya
            $table->string('account_name');
            $table->string('account_number');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_withdrawals');
        Schema::dropIfExists('cash_in_requests');
        Schema::dropIfExists('escrow_holds');
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('wallets');
    }
};