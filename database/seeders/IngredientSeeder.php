<?php
// database/seeders/IngredientSeeder.php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        // component_type defaults: things that attach a separate 3D asset are
        // model-based; things that recolor/retexture the existing cake mesh
        // are material-based.
        $modelBasedCategories = ['shape', 'drip', 'fruit', 'choco', 'sprinkle', 'candle', 'deco'];

        $items = [
            ['section'=>'shape','name'=>'Round 6 inch','emoji'=>'🎂','price'=>350,'unit'=>'base price','desc'=>'Classic 6-inch round cake, serves 8–10 guests.'],
            ['section'=>'shape','name'=>'Round 8 inch','emoji'=>'🎂','price'=>550,'unit'=>'base price','desc'=>'8-inch round cake, serves 12–15 guests.'],
            ['section'=>'shape','name'=>'Round 10 inch','emoji'=>'🎂','price'=>800,'unit'=>'base price','desc'=>'Large 10-inch round, serves 20–25 guests.'],
            ['section'=>'shape','name'=>'Square','emoji'=>'🟫','price'=>650,'unit'=>'base price','desc'=>'8-inch square cake with clean modern edges.'],
            ['section'=>'shape','name'=>'Heart','emoji'=>'❤️','price'=>750,'unit'=>'base price','desc'=>'Heart-shaped cake for weddings and anniversaries.'],
            ['section'=>'shape','name'=>'Two-tier Round','emoji'=>'🎂','price'=>1800,'unit'=>'base price','desc'=>'Two-tier round (6in + 8in stacked). Serves 25–30.'],
            ['section'=>'flavor','name'=>'Vanilla','emoji'=>'🍦','price'=>0,'unit'=>'included','desc'=>'Classic vanilla sponge. Included in base price.'],
            ['section'=>'flavor','name'=>'Chocolate','emoji'=>'🍫','price'=>80,'unit'=>'add-on','desc'=>'Rich dark chocolate sponge with premium Dutch cocoa.'],
            ['section'=>'flavor','name'=>'Red Velvet','emoji'=>'🔴','price'=>100,'unit'=>'add-on','desc'=>'Velvety soft sponge with subtle cocoa and crimson color.'],
            ['section'=>'flavor','name'=>'Strawberry','emoji'=>'🍓','price'=>120,'unit'=>'add-on','desc'=>'Light and fruity sponge with fresh strawberry puree.'],
            ['section'=>'flavor','name'=>'Ube','emoji'=>'🟣','price'=>130,'unit'=>'add-on','desc'=>'Filipino favorite — rich purple yam with a nutty flavor.'],
            ['section'=>'flavor','name'=>'Mocha','emoji'=>'☕','price'=>100,'unit'=>'add-on','desc'=>'Coffee-chocolate sponge using Barako coffee and dark cocoa.'],
            ['section'=>'frosting','name'=>'Smooth Buttercream','emoji'=>'🎨','price'=>0,'unit'=>'included','desc'=>'Silky smooth buttercream finish. Included in base price.'],
            ['section'=>'frosting','name'=>'Textured Buttercream','emoji'=>'🖌️','price'=>150,'unit'=>'add-on','desc'=>'Rustic palette-knife textured finish with organic swoops.'],
            ['section'=>'frosting','name'=>'Fondant Smooth','emoji'=>'⬜','price'=>350,'unit'=>'add-on','desc'=>'Porcelain-smooth rolled fondant. Premium for intricate designs.'],
            ['section'=>'frosting','name'=>'Chocolate Ganache','emoji'=>'🍫','price'=>250,'unit'=>'add-on','desc'=>'Glossy dark chocolate ganache with a mirror-like finish.'],
            ['section'=>'frosting','name'=>'Semi-naked Style','emoji'=>'🎂','price'=>200,'unit'=>'add-on','desc'=>'Minimalist exposed cake look. Rustic and chic.'],
            ['section'=>'drip','name'=>'Chocolate Drip','emoji'=>'🍫','price'=>180,'unit'=>'add-on','desc'=>'Dark chocolate ganache drip cascading down the sides.'],
            ['section'=>'drip','name'=>'White Chocolate Drip','emoji'=>'🤍','price'=>200,'unit'=>'add-on','desc'=>'Soft and creamy white chocolate drip, elegant ivory cascade.'],
            ['section'=>'drip','name'=>'Caramel Drip','emoji'=>'🍯','price'=>180,'unit'=>'add-on','desc'=>'Warm golden caramel drip with a rich buttery sweetness.'],
            ['section'=>'drip','name'=>'Strawberry Drip','emoji'=>'🍓','price'=>200,'unit'=>'add-on','desc'=>'Vibrant strawberry coulis drip in vivid pink-red tones.'],
            ['section'=>'fruit','name'=>'Strawberry','emoji'=>'🍓','price'=>120,'unit'=>'add-on','desc'=>'Fresh whole or halved strawberries on top.'],
            ['section'=>'fruit','name'=>'Blueberry','emoji'=>'🫐','price'=>180,'unit'=>'add-on','desc'=>'Plump fresh blueberries with a slightly tart taste.'],
            ['section'=>'fruit','name'=>'Raspberry','emoji'=>'🫐','price'=>220,'unit'=>'add-on','desc'=>'Fresh raspberries with vibrant sweet-tart balance.'],
            ['section'=>'fruit','name'=>'Cherry','emoji'=>'🍒','price'=>150,'unit'=>'add-on','desc'=>'Dark red fresh cherries with stems intact.'],
            ['section'=>'fruit','name'=>'Mango Slice','emoji'=>'🥭','price'=>100,'unit'=>'add-on','desc'=>'Fresh Philippine Carabao mango slices — sweet and golden.'],
            ['section'=>'choco','name'=>'Chocolate Bar Shard','emoji'=>'🍫','price'=>120,'unit'=>'add-on','desc'=>'Hand-broken shards of premium Belgian dark chocolate.'],
            ['section'=>'choco','name'=>'Ferrero-style Ball','emoji'=>'🟤','price'=>80,'unit'=>'per piece','desc'=>'Hazelnut chocolate truffle with crispy wafer shell.'],
            ['section'=>'choco','name'=>'Chocolate Curls','emoji'=>'🌀','price'=>100,'unit'=>'add-on','desc'=>'Delicate curls shaved from a solid chocolate block.'],
            ['section'=>'choco','name'=>'Kitkat Sticks','emoji'=>'🍬','price'=>90,'unit'=>'per 4 pcs','desc'=>'Full-length KitKat wafer fingers as decoration.'],
            ['section'=>'choco','name'=>'Oreo Cookie','emoji'=>'⚫','price'=>60,'unit'=>'per 3 pcs','desc'=>'Whole or halved Oreo cookies placed on the cake.'],
            ['section'=>'choco','name'=>'Chocolate Plaque','emoji'=>'🟫','price'=>200,'unit'=>'per piece','desc'=>'Custom-molded flat chocolate plaque as centerpiece.'],
            ['section'=>'sprinkle','name'=>'Cylinder Sprinkles','emoji'=>'✨','price'=>50,'unit'=>'add-on','desc'=>'Classic colorful jimmie sprinkles in festive rainbow mix.'],
            ['section'=>'sprinkle','name'=>'Sphere Sprinkles','emoji'=>'🔮','price'=>50,'unit'=>'add-on','desc'=>'Round pearl nonpareil sprinkles for a sparkling look.'],
            ['section'=>'candle','name'=>'Number Candles (0–9)','emoji'=>'🔢','price'=>35,'unit'=>'per candle','desc'=>'Large decorative number candles in gold, silver, and pastel.'],
            ['section'=>'candle','name'=>'Happy Birthday Topper','emoji'=>'🎉','price'=>80,'unit'=>'per piece','desc'=>'Acrylic or gold glitter "Happy Birthday" script topper.'],
            ['section'=>'candle','name'=>'Name Plaque','emoji'=>'📛','price'=>150,'unit'=>'per piece','desc'=>'Custom acrylic name plaque personalized with any name.'],
            ['section'=>'candle','name'=>'Crown Topper','emoji'=>'👑','price'=>120,'unit'=>'per piece','desc'=>'Glitter gold or silver crown topper for royal celebrations.'],
            ['section'=>'candle','name'=>'Heart Topper','emoji'=>'❤️','price'=>100,'unit'=>'per piece','desc'=>'Acrylic heart-shaped topper in red, rose gold, or clear.'],
            ['section'=>'deco','name'=>'Buttercream Swirls','emoji'=>'🌀','price'=>150,'unit'=>'add-on','desc'=>'Rosette-style piped buttercream swirls on top border.'],
            ['section'=>'deco','name'=>'Rosettes','emoji'=>'🌹','price'=>180,'unit'=>'add-on','desc'=>'Classic piped buttercream rosette flowers. Timeless.'],
            ['section'=>'deco','name'=>'Macarons','emoji'=>'🟡','price'=>65,'unit'=>'per piece','desc'=>'French macarons in assorted flavors and pastel colors.'],
            ['section'=>'deco','name'=>'Meringue Drops','emoji'=>'⚪','price'=>120,'unit'=>'add-on','desc'=>'Petite kiss-shaped Swiss meringue drops. Light and airy.'],
            ['section'=>'deco','name'=>'Ribbon Wrap','emoji'=>'🎀','price'=>80,'unit'=>'add-on','desc'=>'Premium satin ribbon wrapped around the base of the tier.'],
            ['section'=>'deco','name'=>'Edible Pearls','emoji'=>'🫧','price'=>100,'unit'=>'add-on','desc'=>'Lustrous edible sugar pearls for elegant shimmer.'],
        ];

        foreach ($items as $item) {
            Ingredient::updateOrCreate(
                ['name' => $item['name'], 'category' => $item['section']],
                [
                    'emoji'           => $item['emoji'],
                    'price'           => $item['price'],
                    'price_unit'      => $item['unit'],
                    'description'     => $item['desc'],
                    'status'          => 'active',
                    'is_active'       => true,
                    'component_type'  => in_array($item['section'], $modelBasedCategories) ? 'model_based' : 'material_based',
                ]
            );
        }
    }
}