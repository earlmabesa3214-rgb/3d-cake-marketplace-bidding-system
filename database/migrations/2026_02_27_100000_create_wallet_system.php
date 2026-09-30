<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('balance', 12, 2)->default(0);
            $table->decimal('total_deposited', 12, 2)->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);
            $table->decimal('total_earned', 12, 2)->default(0);
            $table->decimal('total_withdrawn', 12, 2)->default(0);

            $table->string('status')->default('active');

            $table->timestamps();
        });

        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->string('type');

            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);

            $table->string('reference_code')->nullable();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('related_order_id')->nullable();
            $table->unsignedBigInteger('related_payment_id')->nullable();

            $table->string('status')->default('completed');

            $table->timestamps();
        });

        Schema::create('cash_in_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('amount', 12, 2);

            $table->string('gcash_reference')->nullable();
            $table->string('paymongo_source_id')->nullable();
            $table->string('paymongo_checkout_url')->nullable();
            $table->string('proof_path')->nullable();

            $table->string('method')->default('gcash');
            $table->string('status')->default('pending');

            $table->timestamp('approved_at')->nullable();

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->text('reject_reason')->nullable();

            $table->timestamps();
        });

        Schema::create('wallet_withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->decimal('amount', 12, 2);

            $table->string('status')->default('pending');

            $table->string('payment_method');
            $table->string('account_name');
            $table->string('account_number');

            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->unsignedBigInteger('processed_by')->nullable();

            $table->text('admin_note')->nullable();

            $table->string('receipt_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_withdrawals');
        Schema::dropIfExists('cash_in_requests');
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('wallets');
    }
};