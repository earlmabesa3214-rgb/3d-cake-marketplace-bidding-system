<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('bids', function (Blueprint $table) {
        $table->id();
        $table->foreignId('baker_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('cake_request_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->integer('estimated_days');
        $table->text('message')->nullable();
        $table->string('status')->default('PENDING');
        $table->timestamps();
        $table->unique(['baker_id', 'cake_request_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('bids');
}
};
