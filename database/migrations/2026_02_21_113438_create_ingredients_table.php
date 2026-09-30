<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('emoji', 10)->nullable();

            $table->string('category');

            $table->decimal('price', 10, 2)->default(0);

            $table->decimal('price_two_tier', 10, 2)->nullable();
            $table->decimal('price_three_tier', 10, 2)->nullable();

            $table->string('price_unit')->nullable();

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->string('status')->default('active');

            $table->string('component_type')->default('material_based');

            $table->string('model_path')->nullable();

            $table->string('thumbnail_path')->nullable();

            $table->string('placement')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};