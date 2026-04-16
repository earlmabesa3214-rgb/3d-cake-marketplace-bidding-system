<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bakers', function (Blueprint $table) {

            if (!Schema::hasColumn('bakers', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('bakers', 'shop_name')) {
                $table->string('shop_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('bakers', 'phone')) {
                $table->string('phone', 20)->nullable()->after('shop_name');
            }
            if (!Schema::hasColumn('bakers', 'business_permit')) {
                $table->string('business_permit')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('bakers', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('business_permit');
            }
            if (!Schema::hasColumn('bakers', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('bakers', 'address')) {
                $table->text('address')->nullable()->after('longitude');
            }

        });
    }

    public function down(): void
    {
        Schema::table('bakers', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'shop_name', 'phone',
                'business_permit', 'latitude', 'longitude', 'address'
            ]);
        });
    }
};