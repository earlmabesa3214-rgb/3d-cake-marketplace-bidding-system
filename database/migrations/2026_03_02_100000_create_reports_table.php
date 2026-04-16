<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('baker_order_id')->constrained('baker_orders')->onDelete('cascade');
            $table->string('reason');           // stores the category key
            $table->text('details')->nullable();
            $table->string('screenshot')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // One report per user per order
            $table->unique(['reporter_id', 'baker_order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};