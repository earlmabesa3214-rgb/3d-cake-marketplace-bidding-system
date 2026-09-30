<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    if (!Schema::hasTable('baker_orders')) {
        Schema::create('baker_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baker_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cake_request_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('bid_id')->nullable();
            $table->decimal('agreed_price', 10, 2);
            $table->string('status')->default('ACCEPTED');
            $table->string('payout_status')->default('PENDING');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    // Add FK separately so it works regardless
    if (Schema::hasTable('baker_orders') && Schema::hasTable('bids')) {
        Schema::table('baker_orders', function (Blueprint $table) {
            // Only add if not already there
            if (!Schema::hasColumn('baker_orders', 'bid_id') || 
                !\DB::select("SHOW KEYS FROM baker_orders WHERE Key_name = 'baker_orders_bid_id_foreign'")) {
                $table->foreign('bid_id')->references('id')->on('bids')->onDelete('cascade');
            }
        });
    }
}
};
