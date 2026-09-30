<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Rejection tracking
            $table->string('rejection_reason')->nullable()->after('status');
            $table->text('rejection_note')->nullable()->after('rejection_reason');
            $table->timestamp('rejected_at')->nullable()->after('rejection_note');
            $table->integer('rejection_count')->default(0)->after('rejected_at');

            // Track re-upload
            $table->timestamp('reupload_requested_at')->nullable()->after('rejection_count');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'rejection_reason',
                'rejection_note',
                'rejected_at',
                'rejection_count',
                'reupload_requested_at',
            ]);
        });
    }
};