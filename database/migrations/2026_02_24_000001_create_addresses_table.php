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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('label')->nullable();
            $table->string('house_unit_no')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('zip_code', 10);
            $table->string('landmark')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};