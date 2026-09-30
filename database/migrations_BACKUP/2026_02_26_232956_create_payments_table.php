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
            $table->unsignedBigInteger('cake_request_id')->nullable();
            $table->unsignedBigInteger('bid_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('agreed_price', 10, 2)->nullable();
            $table->string('paymongo_source_id')->nullable();
            $table->string('paymongo_checkout_url')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('cake_request_id')->references('id')->on('cake_requests')->nullOnDelete();
            $table->foreign('bid_id')->references('id')->on('bids')->nullOnDelete();
            $table->foreign('customer_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};