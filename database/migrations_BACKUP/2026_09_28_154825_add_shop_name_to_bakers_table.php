<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('bakers', 'shop_name')) {
            Schema::table('bakers', function (Blueprint $table) {
                $table->string('shop_name', 150)->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('bakers', function (Blueprint $table) {
            $table->dropColumn('shop_name');
        });
    }
};