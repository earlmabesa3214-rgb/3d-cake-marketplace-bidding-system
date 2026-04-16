<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baker_orders', function (Blueprint $table) {
            $table->timestamp('cancelled_at')->nullable()->after('completed_at');
            $table->string('cancel_reason')->nullable()->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('baker_orders', function (Blueprint $table) {
            $table->dropColumn(['cancelled_at', 'cancel_reason']);
        });
    }
};