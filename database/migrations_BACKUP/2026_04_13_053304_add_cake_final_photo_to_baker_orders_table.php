<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('baker_orders', function (Blueprint $table) {
        $table->string('cake_final_photo')->nullable()->after('completed_at');
    });
}
public function down(): void
{
    Schema::table('baker_orders', function (Blueprint $table) {
        $table->dropColumn('cake_final_photo');
    });
}
};
