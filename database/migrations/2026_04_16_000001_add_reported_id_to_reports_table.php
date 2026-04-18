<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Only add if it doesn't exist yet
            if (!Schema::hasColumn('reports', 'reported_id')) {
                $table->unsignedBigInteger('reported_id')->nullable()->after('reporter_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            if (Schema::hasColumn('reports', 'reported_id')) {
                $table->dropColumn('reported_id');
            }
        });
    }
};