<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->enum('fulfillment_type', ['delivery', 'pickup'])->default('delivery')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->dropColumn('fulfillment_type');
        });
    }
};