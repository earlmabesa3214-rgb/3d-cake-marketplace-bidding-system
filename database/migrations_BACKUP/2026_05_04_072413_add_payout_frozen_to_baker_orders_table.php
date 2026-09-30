<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddPayoutFrozenToBakerOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('baker_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('baker_orders', 'payout_frozen')) {
                $table->boolean('payout_frozen')->default(false)->after('status');
            }
        });
    }
    public function down()
    {
        Schema::table('baker_orders', function (Blueprint $table) {
            $table->dropColumn('payout_frozen');
        });
    }
}