<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop and recreate cleanly
        Schema::dropIfExists('reports');

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('reported_id')->nullable();
            $table->foreignId('baker_order_id')->constrained('baker_orders')->onDelete('cascade');
            $table->string('reporter_role')->nullable();   // 'baker' or 'customer'
            $table->string('category')->nullable();        // replaces 'reason'
            $table->text('description')->nullable();       // replaces 'details'
            $table->string('screenshot_path')->nullable(); // replaces 'screenshot'
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_note')->nullable();        // replaces 'admin_notes'
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['reporter_id', 'baker_order_id']);

            $table->foreign('reported_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};