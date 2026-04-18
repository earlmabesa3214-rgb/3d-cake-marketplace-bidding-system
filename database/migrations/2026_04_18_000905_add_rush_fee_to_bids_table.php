<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
    {
        Schema::table('bids', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->decimal('rush_fee', 10, 2)->default(0)->after('amount');
        });
    }

public function down(): void
    {
        Schema::table('bids', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('rush_fee');
        });
    }
};
