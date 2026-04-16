<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// In the migration file
public function up(): void
{
    Schema::table('cake_requests', function (Blueprint $table) {
        $table->string('cake_preview_image')->nullable()->after('reference_image');
    });
}
    public function down(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            //
        });
    }
};
