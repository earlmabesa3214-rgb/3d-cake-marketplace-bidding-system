<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('cake_requests', function (Blueprint $table) {
        $table->decimal('rush_auto_price', 10, 2)->nullable()->after('rush_fee');
    });
}

public function down(): void
{
    Schema::table('cake_requests', function (Blueprint $table) {
        $table->dropColumn('rush_auto_price');
    });
}
};
