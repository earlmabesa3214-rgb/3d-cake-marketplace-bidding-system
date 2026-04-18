<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {

            if (!Schema::hasColumn('reports', 'reporter_id')) {
                $table->unsignedBigInteger('reporter_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('reports', 'reported_id')) {
                $table->unsignedBigInteger('reported_id')->nullable()->after('reporter_id');
            }

            if (!Schema::hasColumn('reports', 'baker_order_id')) {
                $table->unsignedBigInteger('baker_order_id')->nullable()->after('reported_id');
            }

            if (!Schema::hasColumn('reports', 'reporter_role')) {
                $table->string('reporter_role')->nullable()->after('baker_order_id');
            }

            if (!Schema::hasColumn('reports', 'category')) {
                $table->string('category')->nullable()->after('reporter_role');
            }

            if (!Schema::hasColumn('reports', 'description')) {
                $table->text('description')->nullable()->after('category');
            }

            if (!Schema::hasColumn('reports', 'screenshot_path')) {
                $table->string('screenshot_path')->nullable()->after('description');
            }

            if (!Schema::hasColumn('reports', 'status')) {
                $table->string('status')->default('pending')->after('screenshot_path');
            }

            if (!Schema::hasColumn('reports', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('status');
            }

            if (!Schema::hasColumn('reports', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('admin_note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $columns = [
                'reporter_id', 'reported_id', 'baker_order_id',
                'reporter_role', 'category', 'description',
                'screenshot_path', 'status', 'admin_note', 'reviewed_at',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('reports', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};