<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('wallet_withdrawals', function (Blueprint $table) {
        $table->string('receipt_path')->nullable()->after('admin_note');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_withdrawals', function (Blueprint $table) {
            //
        });
    }
};
