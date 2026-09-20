<?php
// database/seeders/FixCakeComponentsAccuracySeeder.php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class FixCakeComponentsAccuracySeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Deactivate items that don't exist anywhere in the real 3D builder ──
        // (never deleted — only status flipped, so nothing referencing them breaks)
        $obsolete = [
            'Buttercream Swirls', 'Edible Pearls', 'Macarons', 'Meringue Drops', 'Ribbon Wrap',
            'Crown Topper', 'Happy Birthday Topper', 'Heart Topper', 'Name Plaque',
        ];
        Ingredient::whereIn('name', $obsolete)->update(['status' => 'inactive', 'is_active' => false]);
        // The deco-category "Rosettes" specifically — not the real base-icing Rosettes seeded below
        Ingredient::where('name', 'Rosettes')->where('category', 'deco')->update(['status' => 'inactive', 'is_active' => false]);
        // Ganache isn't an offered Cake Style in the current builder
        Ingredient::where('name', 'Chocolate Ganache')->where('category', '!=', 'filling')->update(['status' => 'inactive', 'is_active' => false]);

        // ── 2. Recategorize rows that were bucketed under the old catch-all "frosting" ──
        Ingredient::whereIn('name', ['Smooth Buttercream', 'Semi-naked Style', 'Fondant Smooth'])
            ->update(['category' => 'cake_style']);
        Ingredient::where('name', 'Textured Buttercream')->update(['category' => 'texture']);

        // ── 3. Add everything the real builder offers that's missing from the catalog ──
        $additions = [
            // Cake Type
            ['name'=>'Sponge Cake','category'=>'cake_type','price'=>0,'unit'=>'included','desc'=>'Classic soft sponge base.'],
            ['name'=>'Chiffon Cake','category'=>'cake_type','price'=>0,'unit'=>'included','desc'=>'Light, airy chiffon base.'],
            ['name'=>'Cheesecake','category'=>'cake_type','price'=>150,'unit'=>'add-on','desc'=>'Rich baked cheesecake base.'],

            // Cake Shape
            ['name'=>'Bundt','category'=>'shape','price'=>480,'unit'=>'base price','desc'=>'Classic ridged bundt cake.'],
            ['name'=>'Number','category'=>'shape','price'=>600,'unit'=>'base price','desc'=>'Numeral-shaped cake, single or double digit.'],

            // Flavors missing from the seeded 6
            ['name'=>'Blueberry','category'=>'flavor','price'=>110,'unit'=>'add-on','desc'=>'Blueberry-infused sponge.'],
            ['name'=>'Mango','category'=>'flavor','price'=>120,'unit'=>'add-on','desc'=>'Fresh Philippine mango sponge.'],
            ['name'=>'Biscoff','category'=>'flavor','price'=>140,'unit'=>'add-on','desc'=>'Caramelized Biscoff-spiced sponge.'],
            ['name'=>'Carrot','category'=>'flavor','price'=>80,'unit'=>'add-on','desc'=>'Classic spiced carrot sponge.'],
            ['name'=>'Banana','category'=>'flavor','price'=>60,'unit'=>'add-on','desc'=>'Moist banana sponge.'],

            // Filling
            ['name'=>'No Filling','category'=>'filling','price'=>0,'unit'=>'included','desc'=>'No filling between layers.'],
            ['name'=>'Vanilla Cream','category'=>'filling','price'=>40,'unit'=>'add-on','desc'=>'Smooth vanilla cream filling.'],
            ['name'=>'Chocolate Ganache','category'=>'filling','price'=>60,'unit'=>'add-on','desc'=>'Rich chocolate ganache filling.'],
            ['name'=>'Cream Cheese','category'=>'filling','price'=>60,'unit'=>'add-on','desc'=>'Tangy cream cheese filling.'],
            ['name'=>'Strawberry','category'=>'filling','price'=>50,'unit'=>'add-on','desc'=>'Fresh strawberry filling.'],
            ['name'=>'Blueberry','category'=>'filling','price'=>50,'unit'=>'add-on','desc'=>'Fresh blueberry filling.'],
            ['name'=>'Biscoff','category'=>'filling','price'=>70,'unit'=>'add-on','desc'=>'Biscoff spread filling.'],

            // Cake Style — Ombre was missing entirely
            ['name'=>'Ombre Style','category'=>'cake_style','price'=>250,'unit'=>'add-on','desc'=>'Graduated two-tone dip-dye finish.'],

            // Frosting / Icing (base icing)
            ['name'=>'Shell Border','category'=>'base_icing','price'=>0,'unit'=>'included','desc'=>'Classic piped shell border, color customizable.'],
            ['name'=>'Sugar Icing','category'=>'base_icing','price'=>150,'unit'=>'add-on','desc'=>'Full sugar icing drape, color customizable.'],
            ['name'=>'Rosettes','category'=>'base_icing','price'=>100,'unit'=>'add-on','desc'=>'Piped rosette base icing, placement customizable.'],

            // Chocolate Decor — pieces missing from the catalog
            ['name'=>'Toblerone Triangle','category'=>'choco','price'=>50,'unit'=>'per piece','desc'=>'Triangular chocolate bar piece, chocolate or white.'],
            ['name'=>'Chocolate Sprinkles','category'=>'choco','price'=>30,'unit'=>'add-on','desc'=>'Fine chocolate sprinkle topping.'],
            ['name'=>'Crushed Peanuts','category'=>'choco','price'=>35,'unit'=>'add-on','desc'=>'Crushed roasted peanut topping.'],

            // Fruits missing from the catalog
            ['name'=>'Kiwi Slice','category'=>'fruit','price'=>30,'unit'=>'per piece','desc'=>'Fresh kiwi slice.'],
            ['name'=>'Peach Slice','category'=>'fruit','price'=>35,'unit'=>'per piece','desc'=>'Fresh peach slice.'],
            ['name'=>'Banana Slice','category'=>'fruit','price'=>35,'unit'=>'per piece','desc'=>'Fresh banana slice.'],

            // Candles & Toppers
            ['name'=>'Character Topper','category'=>'candle','price'=>150,'unit'=>'pick character','desc'=>'Licensed/character-themed cake topper figure.'],
        ];

        foreach ($additions as $item) {
            Ingredient::updateOrCreate(
                ['name' => $item['name'], 'category' => $item['category']],
                [
                    'price'          => $item['price'],
                    'price_unit'     => $item['unit'],
                    'description'    => $item['desc'],
                    'status'         => 'active',
                    'is_active'      => true,
                    'component_type' => 'material_based',
                ]
            );
        }
    }
}