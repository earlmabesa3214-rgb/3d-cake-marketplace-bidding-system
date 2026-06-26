<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddRefundFieldsToReportsTable extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'refund_requested')) {
                $table->boolean('refund_requested')->default(false)->after('admin_note');
            }
            if (!Schema::hasColumn('reports', 'refund_status')) {
                // null = not requested, 'pending', 'approved', 'rejected', 'on_hold'
                $table->string('refund_status')->nullable()->after('refund_requested');
            }
            if (!Schema::hasColumn('reports', 'refund_amount')) {
                $table->decimal('refund_amount', 10, 2)->nullable()->after('refund_status');
            }
            if (!Schema::hasColumn('reports', 'refund_note')) {
                $table->text('refund_note')->nullable()->after('refund_amount');
            }
            if (!Schema::hasColumn('reports', 'payment_held')) {
                // admin can freeze the baker's payout
                $table->boolean('payment_held')->default(false)->after('refund_note');
            }
            if (!Schema::hasColumn('reports', 'refund_processed_at')) {
                $table->timestamp('refund_processed_at')->nullable()->after('payment_held');
            }
        });
    }
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'refund_requested', 'refund_status', 'refund_amount',
                'refund_note', 'payment_held', 'refund_processed_at',
            ]);
        });
    }
}