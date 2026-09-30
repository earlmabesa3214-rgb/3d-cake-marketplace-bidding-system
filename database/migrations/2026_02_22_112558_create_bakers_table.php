<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bakers', function (Blueprint $table) {
            $table->id();

            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('total_reviews')->default(0);

            $table->string('name');
            $table->string('shop_name')->nullable();
            $table->string('experience_years')->nullable();
            $table->decimal('min_order_price', 10, 2)->nullable();
            $table->string('social_media')->nullable();

            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();

            $table->text('bio')->nullable();

            $table->string('seller_type')->default('registered');

            $table->string('business_permit')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->text('address')->nullable();

            $table->boolean('is_available')->default(true);
            $table->boolean('accepts_rush_orders')->default(false);
            $table->boolean('accepts_delivery')->nullable();
            $table->boolean('accepts_pickup')->nullable();

            $table->integer('rush_fee')->default(150);

            $table->boolean('is_approved')->default(false);

            $table->string('city')->nullable();

            $table->text('specialties')->nullable();

            $table->string('status')->default('pending');

            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('full_address')->nullable();

            $table->string('dti_sec_number')->nullable();
            $table->string('dti_certificate')->nullable();
            $table->string('sanitary_permit')->nullable();
            $table->string('bir_certificate')->nullable();

            $table->string('gov_id_type')->nullable();
            $table->string('gov_id_front')->nullable();
            $table->string('gov_id_back')->nullable();
            $table->string('id_selfie')->nullable();
            $table->string('food_safety_cert')->nullable();

            $table->json('portfolio')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bakers');
    }
};