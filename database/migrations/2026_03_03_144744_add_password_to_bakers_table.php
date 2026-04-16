<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('bakers', function (Blueprint $table) {
        if (!Schema::hasColumn('bakers', 'password')) {
            $table->string('password')->nullable()->after('email');
        }
    });
}

public function down(): void
{
    Schema::table('bakers', function (Blueprint $table) {
        $table->dropColumn('password');
    });
}
};
