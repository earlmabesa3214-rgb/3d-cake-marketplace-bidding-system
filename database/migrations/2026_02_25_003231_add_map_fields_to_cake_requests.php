<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('cake_requests', 'delivery_lat')) {
                $table->decimal('delivery_lat', 10, 7)->nullable()->after('address_id');
            }
            if (!Schema::hasColumn('cake_requests', 'delivery_lng')) {
                $table->decimal('delivery_lng', 10, 7)->nullable()->after('delivery_lat');
            }
            if (!Schema::hasColumn('cake_requests', 'delivery_address')) {
                $table->text('delivery_address')->nullable()->after('delivery_lng');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->dropColumn(['delivery_lat', 'delivery_lng', 'delivery_address']);
        });
    }
};