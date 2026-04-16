<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);

            // Stores an array of catalog IDs e.g. ["shape_2","flv_5","fro_1"]
            // MySQL: use json(). SQLite (for local dev): use text() — Laravel handles both.
            $table->json('ingredient_ids')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};