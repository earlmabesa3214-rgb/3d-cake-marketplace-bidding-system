<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'ingredient_ids')) {
            $table->json('ingredient_ids')->nullable()->after('base_price');
        }
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('ingredient_ids');
    });
}
};
