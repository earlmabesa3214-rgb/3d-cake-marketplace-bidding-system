<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baker_wallets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('baker_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('total_earned', 10, 2)->default(0);
            $table->decimal('total_withdrawn', 10, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('baker_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->string('status')->default('pending');

            $table->string('payment_method');
            $table->string('account_name');
            $table->string('account_number');

            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->text('admin_note')->nullable();

            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('platform_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('qr_code_path')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create('escrow_holds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->foreignId('baker_wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->constrained('baker_orders')
                ->cascadeOnDelete();

            $table->string('payment_type');

            $table->decimal('amount', 12, 2);

            $table->decimal('platform_fee_rate', 5, 4)
                ->default(0.0500);

            $table->decimal('platform_fee_amount', 12, 2)
                ->default(0);

            $table->decimal('baker_payout_amount', 12, 2)
                ->default(0);

            $table->string('status')->default('held');

            $table->timestamp('held_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_holds');
        Schema::dropIfExists('platform_accounts');
        Schema::dropIfExists('withdrawal_requests');
        Schema::dropIfExists('baker_wallets');
    }
};