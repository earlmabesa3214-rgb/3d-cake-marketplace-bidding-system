<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cake_requests')) {
            Schema::create('cake_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
                $table->json('cake_configuration');
                $table->string('custom_message')->nullable();
                $table->string('reference_image')->nullable();
                $table->decimal('budget_min', 10, 2);
                $table->decimal('budget_max', 10, 2);
                $table->date('delivery_date');
                $table->text('special_instructions')->nullable();
                $table->string('status')->default('OPEN');
                // OPEN | CANCELLED | IN_PROGRESS | COMPLETED
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cake_requests');
    }
};