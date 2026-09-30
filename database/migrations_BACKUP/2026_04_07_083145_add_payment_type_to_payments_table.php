<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('payments', function (Blueprint $table) {
        $table->string('payment_type')->default('downpayment')->after('cake_request_id');
        // values: 'downpayment' or 'final'
    });
}

public function down(): void
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropColumn('payment_type');
    });
}
};
