<?php
// database/seeders/CompletePricingComponentsSeeder.php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class CompletePricingComponentsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Generic "Drip" toggle — the builder's Add-ons > Drip button reads
        // this exact name; flavor (Caramel/Chocolate/etc.) stays a free choice. ──
        Ingredient::updateOrCreate(
            ['name' => 'Drip', 'category' => 'drip'],
            [
                'price' => 180, 'price_two_tier' => 300, 'price_three_tier' => 450,
                'price_unit' => 'add-on', 'description' => 'Drip layer add-on — flavor chosen separately.',
                'status' => 'active', 'is_active' => true, 'component_type' => 'material_based',
            ]
        );

        // ── Round size options — the slider (4"–10") reads these by parsing
        // the digits out of the name below. ──
        $roundSizes = [4=>180, 5=>220, 6=>280, 7=>350, 8=>420, 9=>500, 10=>600];
        foreach ($roundSizes as $inches => $price) {
            Ingredient::updateOrCreate(
                ['name' => "Round {$inches}\"", 'category' => 'shape'],
                [
                    'price' => $price, 'price_unit' => 'base price',
                    'description' => "Round cake, {$inches} inch.",
                    'status' => 'active', 'is_active' => true, 'component_type' => 'material_based',
                ]
            );
        }

        // ── Two/Three-tier variants for Round, Square, Heart — reuses the
        // price_two_tier / price_three_tier columns already on each shape's
        // main row instead of separate rows. ──
        $tierShapeDefaults = [
            'Round'  => ['single' => 350, 'two' => 950,  'three' => 1400],
            'Square' => ['single' => 500, 'two' => 1200, 'three' => 1800],
            'Heart'  => ['single' => 520, 'two' => 1400, 'three' => 2000],
        ];
        foreach ($tierShapeDefaults as $name => $p) {
            Ingredient::where('name', $name)->where('category', 'shape')->update([
                'price_two_tier'   => $p['two'],
                'price_three_tier' => $p['three'],
            ]);
        }

        // ── Character Toppers — each character becomes its own priced row,
        // matching the builder's real per-character pricing (₱350 or ₱500). ──
        $characters = [
            'SpongeBob'=>350,'Squidward'=>350,'Patrick Star'=>350,'Gary'=>350,
            "Squidward's House"=>500,"SpongeBob's House"=>500,"Patrick's House"=>500,
            'Ben 10'=>350,'Ben 10 RV'=>350,'Gwen'=>350,'Lolo Max'=>350,
            'Buttercup'=>350,'Blossom'=>350,'Bubbles'=>350,'Powerpuff House'=>500,
            'Dora'=>350,'Boots'=>350,"Dora's House"=>500,
            'Kuromi'=>350,'My Melody'=>350,'Cinnamoroll'=>350,'Hello Kitty'=>350,
            'Lightning McQueen'=>350,'Sally'=>350,
            'Mickey Mouse'=>350,'Minnie Mouse'=>350,'Mickey Mouse Clubhouse'=>500,
            'Cocomelon'=>350,
        ];
        foreach ($characters as $name => $price) {
            Ingredient::updateOrCreate(
                ['name' => $name, 'category' => 'candle'],
                [
                    'price' => $price, 'price_unit' => 'per character',
                    'description' => "{$name} character topper.",
                    'status' => 'active', 'is_active' => true, 'component_type' => 'model_based',
                ]
            );
        }
    }
}