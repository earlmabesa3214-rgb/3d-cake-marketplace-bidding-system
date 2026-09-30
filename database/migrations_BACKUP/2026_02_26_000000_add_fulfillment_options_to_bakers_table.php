<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bakers', function (Blueprint $table) {
            // Nullable on purpose: null = baker hasn't set a preference yet.
            // Profile-completeness check treats "both null/false" as incomplete.
            $table->boolean('accepts_delivery')->nullable()->after('accepts_rush_orders');
            $table->boolean('accepts_pickup')->nullable()->after('accepts_delivery');
        });
    }

    public function down(): void
    {
        Schema::table('bakers', function (Blueprint $table) {
            $table->dropColumn(['accepts_delivery', 'accepts_pickup']);
        });
    }
};