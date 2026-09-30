<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baker_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('baker_order_id')
                ->constrained('baker_orders')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('baker_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating');

            $table->text('comment')->nullable();

            $table->timestamps();

            $table->unique('baker_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baker_reviews');
    }
};