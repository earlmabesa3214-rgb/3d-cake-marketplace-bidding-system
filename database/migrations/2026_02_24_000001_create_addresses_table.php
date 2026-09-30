<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

         $table->foreignId('user_id')
    ->nullable()
    ->constrained('users')
    ->cascadeOnDelete();

            $table->string('label')->nullable();

            $table->string('house_unit_no')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();

            $table->string('city');
            $table->string('province');
            $table->string('zip_code', 10);

            $table->string('landmark')->nullable();

            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};