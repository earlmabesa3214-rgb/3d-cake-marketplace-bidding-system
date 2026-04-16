<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->boolean('is_rush')->default(false)->after('fulfillment_type');
            $table->integer('rush_fee')->default(0)->after('is_rush');
        });

        Schema::table('bakers', function (Blueprint $table) {
            $table->boolean('accepts_rush_orders')->default(false)->after('is_available');
            $table->integer('rush_fee')->default(150)->after('accepts_rush_orders');
        });
    }

    public function down(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->dropColumn(['is_rush', 'rush_fee']);
        });
        Schema::table('bakers', function (Blueprint $table) {
            $table->dropColumn(['accepts_rush_orders', 'rush_fee']);
        });
    }
};