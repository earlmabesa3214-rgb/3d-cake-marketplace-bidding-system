<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('bakers', function (Blueprint $table) {
        $table->boolean('is_available')->default(1)->after('address');
    });
}

public function down(): void
{
    Schema::table('bakers', function (Blueprint $table) {
        $table->dropColumn('is_available');
    });
}
};
