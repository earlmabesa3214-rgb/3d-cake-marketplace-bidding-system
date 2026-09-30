<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->timestamp('rush_expires_at')->nullable()->after('rush_auto_price');
        });
    }
    public function down(): void {
        Schema::table('cake_requests', function (Blueprint $table) {
            $table->dropColumn('rush_expires_at');
        });
    }
};