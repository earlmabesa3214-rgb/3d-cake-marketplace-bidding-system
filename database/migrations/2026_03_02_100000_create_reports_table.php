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

            $table->foreignId('reporter_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('reported_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('baker_order_id')
                ->constrained('baker_orders')
                ->cascadeOnDelete();

            $table->string('reporter_role')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('screenshot_path')->nullable();

            $table->enum('status', [
                'pending',
                'reviewed',
                'resolved',
                'dismissed',
            ])->default('pending');

            $table->text('admin_notes')->nullable();
            $table->text('admin_note')->nullable();

            $table->boolean('refund_requested')->default(false);
            $table->string('refund_status')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->text('refund_note')->nullable();

            $table->boolean('payment_held')->default(false);

            $table->timestamp('refund_processed_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->unique([
                'reporter_id',
                'baker_order_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};