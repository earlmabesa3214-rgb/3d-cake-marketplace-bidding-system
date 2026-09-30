<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baker_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baker_id')->constrained('bakers')->onDelete('cascade');
            $table->enum('type', ['gcash', 'maya', 'cash']);
            $table->string('account_name', 100)->nullable();
            $table->string('account_number', 20)->nullable();
            $table->string('qr_code_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baker_payment_methods');
    }
};