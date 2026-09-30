<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cake_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->nullOnDelete();

            $table->decimal('delivery_lat', 10, 7)->nullable();
            $table->decimal('delivery_lng', 10, 7)->nullable();

            $table->text('delivery_address')->nullable();

            $table->json('cake_configuration');

            $table->string('custom_message')->nullable();

            $table->string('reference_image')->nullable();

            $table->string('cake_preview_image')->nullable();

            $table->decimal('budget_min', 10, 2);
            $table->decimal('budget_max', 10, 2);

            $table->date('delivery_date');

            $table->time('needed_time')->nullable();

            $table->text('special_instructions')->nullable();

            $table->enum('status', [
                'PENDING',
                'OPEN',
                'BIDDING',
                'ACCEPTED',
                'WAITING_FOR_PAYMENT',
                'IN_PROGRESS',
                'WAITING_FINAL_PAYMENT',
                'COMPLETED',
                'CANCELLED',
                'RUSH_MATCHING',
            ])->default('PENDING');

            $table->enum('fulfillment_type', [
                'delivery',
                'pickup',
            ])->default('delivery');

            $table->boolean('is_rush')->default(false);

            $table->integer('rush_fee')->default(0);

            $table->decimal('rush_auto_price', 10, 2)->nullable();

            $table->timestamp('rush_expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cake_requests');
    }
};