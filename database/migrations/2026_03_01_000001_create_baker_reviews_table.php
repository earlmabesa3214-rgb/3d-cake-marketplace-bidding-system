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
            $table->foreignId('baker_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('baker_order_id')->nullable()->constrained('baker_orders')->onDelete('set null');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['baker_order_id', 'customer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baker_reviews');
    }
};