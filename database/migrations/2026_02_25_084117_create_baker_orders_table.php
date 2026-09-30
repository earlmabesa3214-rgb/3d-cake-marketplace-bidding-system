<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baker_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('baker_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('cake_request_id')
                ->constrained('cake_requests')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('bid_id')->nullable();

            $table->decimal('agreed_price', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('delivery_distance_km', 8, 2)->nullable();

            $table->enum('status', [
                'ACCEPTED',
                'WAITING_FOR_PAYMENT',
                'PREPARING',
                'READY',
                'WAITING_FINAL_PAYMENT',
                'OUT_FOR_DELIVERY',
                'DELIVERED',
                'COMPLETED',
                'CANCELLED',
            ])->default('ACCEPTED');

            $table->boolean('payout_frozen')->default(false);
            $table->string('payout_status')->default('PENDING');

            $table->decimal('platform_fee', 10, 2)->default(0);
            $table->decimal('baker_payout', 10, 2)->nullable();

            $table->timestamp('payout_released_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->string('cake_final_photo')->nullable();

            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancel_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baker_orders');
    }
};