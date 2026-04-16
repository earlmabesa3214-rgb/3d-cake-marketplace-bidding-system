@extends('layouts.admin')
@section('title', 'Ingredients')

@push('styles')
<style>
:root{
    --gold:#C07828;--gold-dark:#9A5E14;--gold-light:#DC9E48;--gold-soft:#FEF3E2;
    --gold-glow:rgba(192,120,40,.16);--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;
    --rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;
    --t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--bg:#F5F0E8;
    --s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;
    --r:10px;--rl:14px;--rxl:18px;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes slideUp{from{opacity:0;transform:translateY(18px) scale(.97)}to{opacity:1;transform:none}}
@keyframes floatY{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}

.pg{padding:0 0 5rem;}

/* PAGE HERO */
.ing-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem 5rem;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:1rem;}.ing-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.ing-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.ing-hero-left{position:relative;z-index:1;}
.ing-hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.ing-hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.ing-hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.ing-hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.ing-hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}
.ing-hero-right{position:relative;z-index:1;}

/* SEARCH BAR */
.search-bar{display:flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);border-radius:var(--rl);padding:0 .875rem;height:40px;min-width:260px;transition:border-color .18s,background .18s;}
.search-bar:focus-within{background:rgba(255,255,255,.15);border-color:rgba(192,120,40,.5);}
.search-bar svg{color:rgba(255,255,255,.5);flex-shrink:0;}
.search-bar input{border:none;background:none;outline:none;box-shadow:none;-webkit-appearance:none;font-family:'DM Sans',sans-serif;font-size:.8rem;color:#fff;width:100%;}
.search-bar input:focus{outline:none;box-shadow:none;}
.search-bar input::placeholder{color:rgba(255,255,255,.38);}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:.875rem;padding:0 1.75rem;margin-top:-2.875rem;position:relative;z-index:10;}
.stat-card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);padding:1.25rem 1.125rem;box-shadow:0 6px 24px rgba(50,20,0,.12);transition:transform .18s,box-shadow .18s;animation:fadeUp .5s ease both;}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 14px 36px rgba(50,20,0,.14);}
.stat-card:nth-child(1){animation-delay:.05s}.stat-card:nth-child(2){animation-delay:.1s}.stat-card:nth-child(3){animation-delay:.15s}.stat-card:nth-child(4){animation-delay:.2s}
.stat-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:.875rem;}
.stat-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;}
.stat-card:nth-child(1) .stat-icon{background:var(--gold-soft);color:var(--gold);}
.stat-card:nth-child(2) .stat-icon{background:var(--teal-soft);color:var(--teal);}
.stat-card:nth-child(3) .stat-icon{background:#FDEEE4;color:var(--copper);}
.stat-card:nth-child(4) .stat-icon{background:var(--teal-soft);color:var(--teal);}
.stat-lbl{font-size:.75rem;font-weight:700;color:var(--tm);text-transform:uppercase;letter-spacing:.09em;margin-top:.3rem;}
.stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:2.1rem;font-weight:800;letter-spacing:-.04em;color:var(--espresso);line-height:1;}
.stat-delta{font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:20px;}
.stat-delta.muted{background:var(--s3);color:var(--tm);}
.stat-delta.green{background:var(--teal-soft);color:var(--teal);}
.stat-bar{height:3px;border-radius:2px;margin-top:.75rem;background:var(--s3);overflow:hidden;}
.stat-bar-fill{height:100%;border-radius:2px;}
.stat-card:nth-child(1) .stat-bar-fill{background:linear-gradient(90deg,var(--gold),var(--gold-light));}
.stat-card:nth-child(2) .stat-bar-fill{background:linear-gradient(90deg,var(--teal),#48BEB0);}
.stat-card:nth-child(3) .stat-bar-fill{background:linear-gradient(90deg,var(--copper),var(--gold));}
.stat-card:nth-child(4) .stat-bar-fill{background:linear-gradient(90deg,var(--teal),#48BEB0);}

/* TABS */
.tab-wrap{padding:2.5rem 2rem 0;}
.cat-tabs{display:flex;align-items:center;gap:.35rem;flex-wrap:wrap;animation:fadeUp .45s ease .12s both;}
.cat-tab{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .875rem;border-radius:30px;font-size:.75rem;font-weight:600;cursor:pointer;border:1.5px solid var(--bdr-md);background:var(--s);color:var(--tm);transition:all .15s;white-space:nowrap;}
.cat-tab:hover{border-color:rgba(192,120,40,.28);color:var(--gold-dark);background:var(--gold-soft);}
.cat-tab.active{background:linear-gradient(135deg,var(--gold),var(--copper));color:#fff;border-color:transparent;box-shadow:0 2px 8px rgba(192,120,40,.22);}
.cat-tab-cnt{display:inline-flex;align-items:center;justify-content:center;min-width:17px;height:17px;border-radius:50%;padding:0 3px;font-size:.58rem;font-weight:700;font-family:'DM Mono',monospace;background:rgba(255,255,255,.22);}
.cat-tab:not(.active) .cat-tab-cnt{background:var(--s3);color:var(--tm);}

/* CONTENT AREA */
.ing-content{padding:1.375rem 2rem 0;}

/* SECTION */
.cat-section{margin-bottom:2rem;animation:fadeUp .45s ease both;}
.cat-section-head{display:flex;align-items:center;gap:.625rem;margin-bottom:.875rem;padding-bottom:.625rem;border-bottom:1.5px solid var(--bdr);}
.cat-section-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;background:var(--gold-soft);}
.cat-section-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9375rem;font-weight:700;color:var(--espresso);letter-spacing:-.02em;}
.cat-section-desc{font-size:.71rem;color:var(--tm);margin-top:1px;}
.cat-section-badge{margin-left:auto;font-size:.65rem;font-family:'DM Mono',monospace;font-weight:600;padding:.18rem .6rem;border-radius:20px;background:var(--gold-soft);color:var(--gold-dark);border:1px solid rgba(192,120,40,.2);}

/* GRID */
.ing-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(155px,1fr));gap:.75rem;}

/* ING CARD */
.ing-card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rl);overflow:hidden;cursor:pointer;transition:border-color .2s,box-shadow .2s,transform .2s;box-shadow:0 1px 4px rgba(100,60,20,.06);}
.ing-card:hover{border-color:rgba(192,120,40,.28);box-shadow:0 6px 22px var(--gold-glow);transform:translateY(-2px);}
.ing-card:hover .card-vis-inner{animation:floatY 2.2s ease-in-out infinite;}
.card-visual{height:110px;display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--bdr);background:linear-gradient(160deg,var(--s2) 0%,var(--s3) 100%);position:relative;overflow:hidden;}
.card-visual::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(192,120,40,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(192,120,40,.04) 1px,transparent 1px);background-size:15px 15px;}
.card-vis-inner{position:relative;z-index:1;display:flex;align-items:center;justify-content:center;}
.card-ring{width:56px;height:56px;border-radius:50%;border:2px dashed rgba(192,120,40,.25);display:flex;align-items:center;justify-content:center;background:radial-gradient(circle at 35% 35%,rgba(255,255,255,.6),rgba(240,228,210,.3));box-shadow:0 2px 12px rgba(192,120,40,.09);}
.card-emoji{font-size:1.5rem;filter:drop-shadow(0 2px 4px rgba(60,30,5,.18));line-height:1;}
.card-body{padding:.6rem .7rem .7rem;}
.card-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:.73rem;font-weight:700;color:var(--t1);letter-spacing:-.01em;line-height:1.3;margin-bottom:.35rem;}
.card-meta{display:flex;align-items:center;justify-content:space-between;gap:.25rem;}
.card-cat{font-size:.57rem;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--tm);}
.card-price{font-family:'DM Mono',monospace;font-size:.68rem;font-weight:600;color:var(--teal);background:var(--teal-soft);border:1px solid rgba(31,122,108,.16);border-radius:5px;padding:.08rem .35rem;white-space:nowrap;}
.card-price.free{color:var(--tm);background:var(--s3);border-color:var(--bdr);}

/* EMPTY */
.empty-state{text-align:center;padding:3.5rem 2rem;}
.empty-orb{width:52px;height:52px;border-radius:15px;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.18);display:inline-flex;align-items:center;justify-content:center;margin-bottom:.875rem;color:var(--gold);}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:700;color:var(--t1);margin-bottom:.28rem;}
.empty-desc{font-size:.78rem;color:var(--tm);}

/* DETAIL MODAL */
.modal-backdrop{position:fixed;inset:0;background:rgba(28,12,2,.5);backdrop-filter:blur(5px);z-index:1040;display:none;}
.modal-backdrop.show{display:block;animation:fadeIn .18s ease;}
.modal-wrap{position:fixed;inset:0;z-index:1050;display:none;align-items:center;justify-content:center;padding:1rem;}
.modal-wrap.show{display:flex;}
.modal-box{background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--rxl);width:100%;max-width:420px;box-shadow:0 20px 56px rgba(50,20,4,.2);overflow:hidden;position:relative;}
.modal-box.show{animation:slideUp .25s cubic-bezier(.34,1.1,.64,1) both;}
.modal-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--copper),var(--gold-light));}
.modal-3d{height:180px;display:flex;align-items:center;justify-content:center;background:linear-gradient(160deg,#F8F3EB 0%,#EDE5D5 100%);border-bottom:1.5px solid var(--bdr);position:relative;overflow:hidden;}
.modal-3d::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(192,120,40,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(192,120,40,.05) 1px,transparent 1px);background-size:20px 20px;}
.modal-3d-inner{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;gap:.5rem;}
.modal-ring{width:88px;height:88px;border-radius:50%;border:2.5px dashed rgba(192,120,40,.28);display:flex;align-items:center;justify-content:center;background:radial-gradient(circle at 35% 35%,rgba(255,255,255,.7),rgba(240,228,210,.4));box-shadow:0 3px 18px rgba(192,120,40,.1);animation:floatY 3s ease-in-out infinite;}
.modal-emoji{font-size:2.6rem;filter:drop-shadow(0 3px 7px rgba(60,30,5,.2));}
.modal-3d-tag{font-size:.57rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--tm);background:var(--s);border:1px solid var(--bdr);border-radius:5px;padding:.18rem .55rem;}
.modal-content{padding:1.125rem 1.25rem 1.25rem;}
.modal-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:.875rem;gap:.625rem;}
.modal-ing-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.1rem;font-weight:800;letter-spacing:-.03em;color:var(--espresso);line-height:1.1;}
.modal-ing-cat{font-size:.63rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:var(--tm);margin-top:.2rem;}
.modal-close{background:var(--s2);border:1.5px solid var(--bdr);color:var(--tm);cursor:pointer;width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:.9rem;transition:all .15s;flex-shrink:0;line-height:1;}
.modal-close:hover{color:var(--rose);background:var(--rose-soft);}
.modal-price-row{display:flex;align-items:center;gap:.625rem;padding:.75rem .875rem;background:var(--s2);border:1.5px solid var(--bdr);border-radius:var(--r);margin-bottom:.75rem;}
.modal-price-icon{width:34px;height:34px;border-radius:9px;flex-shrink:0;background:var(--teal-soft);color:var(--teal);display:flex;align-items:center;justify-content:center;}
.modal-price-lbl{font-size:.6rem;text-transform:uppercase;letter-spacing:.1em;font-weight:700;color:var(--tm);}
.modal-price-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.25rem;font-weight:800;color:var(--teal);letter-spacing:-.03em;}
.modal-price-val.free{color:var(--tm);font-size:.9375rem;}
.modal-price-unit{font-size:.66rem;color:var(--tm);font-family:'DM Mono',monospace;margin-left:auto;}
.modal-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.75rem;}
.modal-info-tile{padding:.625rem .75rem;background:var(--s2);border:1px solid var(--bdr);border-radius:8px;}
.modal-info-tile-lbl{font-size:.58rem;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:var(--tm);margin-bottom:.18rem;}
.modal-info-tile-val{font-size:.79rem;font-weight:600;color:var(--t2);}
.modal-desc{font-size:.78rem;color:var(--tm);line-height:1.65;padding:.7rem .75rem;background:var(--s2);border:1px solid var(--bdr);border-radius:8px;}

@media(max-width:1024px){.stats-row{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.stats-row{grid-template-columns:1fr 1fr;padding:1rem 1rem 0;}.ing-content{padding:1rem 1rem 0;}.ing-grid{grid-template-columns:repeat(2,1fr);}.tab-wrap{padding:1rem 1rem 0;}}
</style>
@endpush

@section('content')

@php
$allIngredients=[
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
$sections=['shape'=>['label'=>'Cake Shape','desc'=>'Base form and size','emoji'=>'🎂'],'flavor'=>['label'=>'Flavors','desc'=>'Sponge flavor','emoji'=>'🍰'],'frosting'=>['label'=>'Frosting Style','desc'=>'Outer finish and texture','emoji'=>'🎨'],'drip'=>['label'=>'Drips','desc'=>'Decorative drip layer','emoji'=>'💧'],'fruit'=>['label'=>'Fruits','desc'=>'Fresh fruit decorations','emoji'=>'🍓'],'choco'=>['label'=>'Chocolate Decor','desc'=>'Artisan chocolate accents','emoji'=>'🍫'],'sprinkle'=>['label'=>'Sprinkles','desc'=>'Colorful sprinkle toppings','emoji'=>'✨'],'candle'=>['label'=>'Candles & Toppers','desc'=>'Birthday accents','emoji'=>'🕯️'],'deco'=>['label'=>'Decorative Elements','desc'=>'Finishing touches','emoji'=>'🌸']];
$sectionCounts=[];foreach($allIngredients as $ing){$sectionCounts[$ing['section']]=($sectionCounts[$ing['section']]??0)+1;}
$totalCount=count($allIngredients);$totalCats=count($sections);
$avgPrice=round(array_sum(array_column($allIngredients,'price'))/$totalCount);
$freeCount=count(array_filter($allIngredients,fn($i)=>$i['price']===0));
$catLabels=[];foreach($sections as $k=>$sec){$catLabels[$k]=$sec['label'];}
@endphp

<div class="pg">
    <!-- HERO -->
    <div class="ing-hero">
        <div class="ing-hero-left">
            <div class="ing-hero-pill"><span class="ing-hero-dot"></span> Cake Builder</div>
            <div class="ing-hero-title"><em>Cake</em> Components</div>
            <div class="ing-hero-sub">Fixed options — click any ingredient to view details & pricing</div>
        </div>
        <div class="ing-hero-right">
            <div class="search-bar">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="searchInput" placeholder="Search ingredients…" oninput="filterAll()">
            </div>
        </div>
    </div>

  <!-- STATS -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div>
                <span class="stat-delta muted">All items</span>
            </div>
            <div class="stat-val">{{ $totalCount }}</div>
            <div class="stat-lbl">Total Ingredients</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:100%"></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
                <span class="stat-delta muted">Grouped</span>
            </div>
            <div class="stat-val">{{ $totalCats }}</div>
            <div class="stat-lbl">Categories</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ min(100,$totalCats*10) }}%"></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="font-size:1rem;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;">₱</div>
                <span class="stat-delta muted">Per add-on</span>
            </div>
            <div class="stat-val">₱{{ number_format($avgPrice) }}</div>
            <div class="stat-lbl">Average Add-on</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:60%"></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <span class="stat-delta green">No charge</span>
            </div>
            <div class="stat-val">{{ $freeCount }}</div>
            <div class="stat-lbl">Included Free</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ min(100,$freeCount*20) }}%"></div></div>
        </div>
    </div>

    <!-- TABS -->
    <div class="tab-wrap">
        <div class="cat-tabs">
            <div class="cat-tab active" data-cat="all" onclick="switchTab(this)">All <span class="cat-tab-cnt">{{ $totalCount }}</span></div>
            @foreach($sections as $key=>$sec)
            <div class="cat-tab" data-cat="{{ $key }}" onclick="switchTab(this)">{{ $sec['emoji'] }} {{ $sec['label'] }} <span class="cat-tab-cnt">{{ $sectionCounts[$key]??0 }}</span></div>
            @endforeach
        </div>
    </div>

    <!-- SECTIONS -->
    <div class="ing-content">
        @foreach($sections as $secKey=>$sec)
        @php $secIngs=array_filter($allIngredients,fn($i)=>$i['section']===$secKey); @endphp
        <div class="cat-section" data-section="{{ $secKey }}">
            <div class="cat-section-head">
                <div class="cat-section-icon">{{ $sec['emoji'] }}</div>
                <div><div class="cat-section-name">{{ $sec['label'] }}</div><div class="cat-section-desc">{{ $sec['desc'] }}</div></div>
                <span class="cat-section-badge">{{ count($secIngs) }} options</span>
            </div>
            <div class="ing-grid">
                @foreach($secIngs as $ing)
                <div class="ing-card" data-name="{{ strtolower($ing['name']) }}" data-cat="{{ $ing['section'] }}"
                     onclick="openDetail({{ json_encode(['name'=>$ing['name'],'emoji'=>$ing['emoji'],'section'=>$ing['section'],'price'=>$ing['price'],'unit'=>$ing['unit'],'desc'=>$ing['desc']]) }})">
                    <div class="card-visual">
                        <div class="card-vis-inner">
                            <div class="card-ring"><span class="card-emoji">{{ $ing['emoji'] }}</span></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-name">{{ $ing['name'] }}</div>
                        <div class="card-meta">
                            <span class="card-cat">{{ $sec['label'] }}</span>
                            @if($ing['price']===0)<span class="card-price free">Free</span>
                            @else<span class="card-price">₱{{ number_format($ing['price']) }}</span>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div id="noResults" style="display:none;">
            <div class="empty-state">
                <div class="empty-orb"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
                <div class="empty-title">No results found</div>
                <div class="empty-desc">Try a different search term.</div>
            </div>
        </div>
    </div>
</div>

<!-- DETAIL MODAL -->
<div class="modal-backdrop" id="modalBackdrop"></div>
<div class="modal-wrap" id="detailModal">
    <div class="modal-box" id="detailModalBox" onclick="event.stopPropagation()">
        <div class="modal-3d">
            <div class="modal-3d-inner">
                <div class="modal-ring"><span class="modal-emoji" id="mEmoji">🎂</span></div>
                <span class="modal-3d-tag">Ingredient Details</span>
            </div>
        </div>
        <div class="modal-content">
            <div class="modal-top">
                <div><div class="modal-ing-name" id="mName">—</div><div class="modal-ing-cat" id="mCatLabel">—</div></div>
                <button class="modal-close" onclick="closeDetail()">×</button>
            </div>
            <div class="modal-price-row">
                <div class="modal-price-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <div style="flex:1;"><div class="modal-price-lbl">Add-on Price</div><div class="modal-price-val" id="mPrice">—</div></div>
                <span class="modal-price-unit" id="mUnit">—</span>
            </div>
            <div class="modal-info-grid">
                <div class="modal-info-tile"><div class="modal-info-tile-lbl">Category</div><div class="modal-info-tile-val" id="mCatTile">—</div></div>
                <div class="modal-info-tile"><div class="modal-info-tile-lbl">Availability</div><div class="modal-info-tile-val" style="color:var(--teal);">✓ Available</div></div>
            </div>
            <div class="modal-desc" id="mDesc">—</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const catLabels=@json($catLabels);
function switchTab(el){document.querySelectorAll('.cat-tab').forEach(t=>t.classList.remove('active'));el.classList.add('active');const cat=el.dataset.cat;document.querySelectorAll('.cat-section').forEach(sec=>{sec.style.display=(cat==='all'||sec.dataset.section===cat)?'':'none';});document.getElementById('searchInput').value='';document.getElementById('noResults').style.display='none';}
function filterAll(){const q=document.getElementById('searchInput').value.toLowerCase().trim();document.querySelectorAll('.cat-tab').forEach(t=>t.classList.remove('active'));document.querySelector('[data-cat="all"]').classList.add('active');let any=false;document.querySelectorAll('.cat-section').forEach(sec=>{const cards=sec.querySelectorAll('.ing-card');let has=false;cards.forEach(card=>{const match=!q||card.dataset.name.includes(q)||card.dataset.cat.includes(q);card.style.display=match?'':'none';if(match)has=true;});sec.style.display=has?'':'none';if(has)any=true;});document.getElementById('noResults').style.display=any?'none':'block';}
function openDetail(ing){document.getElementById('mEmoji').textContent=ing.emoji;document.getElementById('mName').textContent=ing.name;document.getElementById('mCatLabel').textContent=catLabels[ing.section]||ing.section;document.getElementById('mCatTile').textContent=catLabels[ing.section]||ing.section;document.getElementById('mUnit').textContent=ing.unit;document.getElementById('mDesc').textContent=ing.desc;const priceEl=document.getElementById('mPrice');if(ing.price===0){priceEl.textContent='Included (Free)';priceEl.className='modal-price-val free';}else{priceEl.textContent='₱'+ing.price.toLocaleString();priceEl.className='modal-price-val';}document.getElementById('modalBackdrop').classList.add('show');document.getElementById('detailModal').classList.add('show');document.getElementById('detailModalBox').classList.add('show');document.body.style.overflow='hidden';}
function closeDetail(){document.getElementById('modalBackdrop').classList.remove('show');document.getElementById('detailModal').classList.remove('show');document.getElementById('detailModalBox').classList.remove('show');document.body.style.overflow='';}
document.getElementById('modalBackdrop').addEventListener('click',closeDetail);
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeDetail();});
document.addEventListener('DOMContentLoaded',()=>{document.querySelectorAll('.cat-section').forEach((sec,i)=>{sec.style.animationDelay=`${0.06+i*0.06}s`;});document.querySelectorAll('.ing-card').forEach((card,i)=>{card.style.opacity='0';card.style.transform='translateY(10px)';setTimeout(()=>{card.style.transition='opacity .3s ease, transform .3s cubic-bezier(.22,1,.36,1), border-color .2s, box-shadow .2s, transform .2s';card.style.opacity='1';card.style.transform='';},50+i*12);});});
</script>
@endpush

@endsection