<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cake_request_id')
                ->nullable()
                ->constrained('cake_requests')
                ->nullOnDelete();

            $table->string('payment_type')
                ->default('downpayment');

            $table->foreignId('bid_id')
                ->nullable()
                ->constrained('bids')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('payment_method')->nullable();
            $table->string('proof_of_payment_path')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('agreed_price', 10, 2)->nullable();

            $table->string('paymongo_source_id')->nullable();
            $table->string('paymongo_checkout_url')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'confirmed',
                'rejected',
            ])->default('pending');

            $table->string('escrow_status')->default('pending');
            $table->string('platform_reference')->nullable();

            $table->timestamp('held_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->string('rejection_reason')->nullable();
            $table->text('rejection_note')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->unsignedInteger('rejection_count')->default(0);

            $table->timestamp('reupload_requested_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};