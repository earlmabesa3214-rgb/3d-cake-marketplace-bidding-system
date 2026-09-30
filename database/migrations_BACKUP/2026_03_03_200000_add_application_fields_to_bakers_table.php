<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('bakers', function (Blueprint $table) {
            // Only add if not already present
            if (!Schema::hasColumn('bakers', 'shop_name'))        $table->string('shop_name')->nullable()->after('name');
            if (!Schema::hasColumn('bakers', 'experience_years')) $table->string('experience_years')->nullable()->after('shop_name');
            if (!Schema::hasColumn('bakers', 'min_order_price'))  $table->decimal('min_order_price', 10, 2)->nullable()->after('experience_years');
            if (!Schema::hasColumn('bakers', 'social_media'))     $table->string('social_media')->nullable()->after('min_order_price');
            if (!Schema::hasColumn('bakers', 'bio'))              $table->text('bio')->nullable()->after('social_media');
            if (!Schema::hasColumn('bakers', 'seller_type'))      $table->string('seller_type')->default('registered')->after('bio');
            if (!Schema::hasColumn('bakers', 'latitude'))         $table->decimal('latitude', 10, 7)->nullable();
            if (!Schema::hasColumn('bakers', 'longitude'))        $table->decimal('longitude', 10, 7)->nullable();
            if (!Schema::hasColumn('bakers', 'full_address'))     $table->string('full_address')->nullable();
            // Registered docs
            if (!Schema::hasColumn('bakers', 'dti_sec_number'))   $table->string('dti_sec_number')->nullable();
            if (!Schema::hasColumn('bakers', 'business_permit'))  $table->string('business_permit')->nullable();
            if (!Schema::hasColumn('bakers', 'dti_certificate'))  $table->string('dti_certificate')->nullable();
            if (!Schema::hasColumn('bakers', 'sanitary_permit'))  $table->string('sanitary_permit')->nullable();
            if (!Schema::hasColumn('bakers', 'bir_certificate'))  $table->string('bir_certificate')->nullable();
            // Home-based docs
            if (!Schema::hasColumn('bakers', 'gov_id_type'))      $table->string('gov_id_type')->nullable();
            if (!Schema::hasColumn('bakers', 'gov_id_front'))     $table->string('gov_id_front')->nullable();
            if (!Schema::hasColumn('bakers', 'gov_id_back'))      $table->string('gov_id_back')->nullable();
            if (!Schema::hasColumn('bakers', 'id_selfie'))        $table->string('id_selfie')->nullable();
            if (!Schema::hasColumn('bakers', 'food_safety_cert')) $table->string('food_safety_cert')->nullable();
            // Portfolio
            if (!Schema::hasColumn('bakers', 'portfolio'))        $table->json('portfolio')->nullable();
        });
    }
    public function down(): void {}
};