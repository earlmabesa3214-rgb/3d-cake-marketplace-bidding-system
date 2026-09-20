<?php
// database/migrations/2026_09_15_000000_add_component_fields_to_ingredients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
     public function up(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            if (!Schema::hasColumn('ingredients', 'price_unit')) {
                $table->string('price_unit')->nullable()->after('price');
            }
            if (!Schema::hasColumn('ingredients', 'status')) {
                $table->string('status')->default('active')->after('is_active'); // draft | coming_soon | active | inactive
            }
            if (!Schema::hasColumn('ingredients', 'component_type')) {
                $table->string('component_type')->default('material_based')->after('status'); // model_based | material_based
            }
            if (!Schema::hasColumn('ingredients', 'model_path')) {
                $table->string('model_path')->nullable()->after('component_type');
            }
            if (!Schema::hasColumn('ingredients', 'thumbnail_path')) {
                $table->string('thumbnail_path')->nullable()->after('model_path');
            }
            if (!Schema::hasColumn('ingredients', 'placement')) {
                $table->string('placement')->nullable()->after('thumbnail_path');
            }
        });

        // Backfill status from the old is_active flag for any pre-existing rows.
        DB::table('ingredients')->where('is_active', true)->update(['status' => 'active']);
        DB::table('ingredients')->where('is_active', false)->update(['status' => 'inactive']);
    }

    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $drop = array_filter(
                ['price_unit', 'status', 'component_type', 'model_path', 'thumbnail_path', 'placement'],
                fn($col) => Schema::hasColumn('ingredients', $col)
            );
            if ($drop) {
                $table->dropColumn($drop);
            }
        });
    }
};