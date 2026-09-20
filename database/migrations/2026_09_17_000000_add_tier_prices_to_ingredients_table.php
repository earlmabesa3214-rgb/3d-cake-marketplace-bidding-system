<?php
// database/migrations/2026_09_17_000000_add_tier_prices_to_ingredients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            if (!Schema::hasColumn('ingredients', 'price_two_tier')) {
                $table->decimal('price_two_tier', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('ingredients', 'price_three_tier')) {
                $table->decimal('price_three_tier', 10, 2)->nullable()->after('price_two_tier');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $drop = array_filter(['price_two_tier', 'price_three_tier'], fn($c) => Schema::hasColumn('ingredients', $c));
            if ($drop) $table->dropColumn($drop);
        });
    }
};