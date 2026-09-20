@extends('layouts.admin')
@section('title', 'Cake Builder')

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

.ing-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem 5rem;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:1rem;}
.ing-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.ing-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.ing-hero-left{position:relative;z-index:1;}
.ing-hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.ing-hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.ing-hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.ing-hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.ing-hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}
.ing-hero-right{position:relative;z-index:1;display:flex;align-items:center;gap:.625rem;}

.search-bar{display:flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);border-radius:var(--rl);padding:0 .875rem;height:40px;min-width:240px;transition:border-color .18s,background .18s;}
.search-bar:focus-within{background:rgba(255,255,255,.15);border-color:rgba(192,120,40,.5);}
.search-bar svg{color:rgba(255,255,255,.5);flex-shrink:0;}
.search-bar input{border:none;background:none;outline:none;box-shadow:none;-webkit-appearance:none;font-family:'DM Sans',sans-serif;font-size:.8rem;color:#fff;width:100%;}
.search-bar input:focus{outline:none;box-shadow:none;}
.search-bar input::placeholder{color:rgba(255,255,255,.38);}

.btn-add{display:inline-flex;align-items:center;gap:.4rem;height:40px;padding:0 1rem;border-radius:var(--rl);border:none;background:linear-gradient(135deg,var(--gold),var(--copper));color:#fff;font-size:.8rem;font-weight:700;cursor:pointer;white-space:nowrap;box-shadow:0 4px 14px rgba(192,120,40,.3);transition:transform .15s,box-shadow .15s;}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(192,120,40,.4);}

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
.stat-delta.gold{background:var(--gold-soft);color:var(--gold-dark);}
.stat-bar{height:3px;border-radius:2px;margin-top:.75rem;background:var(--s3);overflow:hidden;}
.stat-bar-fill{height:100%;border-radius:2px;}
.stat-card:nth-child(1) .stat-bar-fill{background:linear-gradient(90deg,var(--gold),var(--gold-light));}
.stat-card:nth-child(2) .stat-bar-fill{background:linear-gradient(90deg,var(--teal),#48BEB0);}
.stat-card:nth-child(3) .stat-bar-fill{background:linear-gradient(90deg,var(--copper),var(--gold));}
.stat-card:nth-child(4) .stat-bar-fill{background:linear-gradient(90deg,var(--teal),#48BEB0);}

.tab-wrap{padding:2.5rem 2rem 0;display:flex;flex-direction:column;gap:.625rem;}
.cat-tabs{display:flex;align-items:center;gap:.35rem;flex-wrap:wrap;animation:fadeUp .45s ease .12s both;}
.cat-tab{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .875rem;border-radius:30px;font-size:.75rem;font-weight:600;cursor:pointer;border:1.5px solid var(--bdr-md);background:var(--s);color:var(--tm);transition:all .15s;white-space:nowrap;}
.cat-tab:hover{border-color:rgba(192,120,40,.28);color:var(--gold-dark);background:var(--gold-soft);}
.cat-tab.active{background:linear-gradient(135deg,var(--gold),var(--copper));color:#fff;border-color:transparent;box-shadow:0 2px 8px rgba(192,120,40,.22);}
.cat-tab-cnt{display:inline-flex;align-items:center;justify-content:center;min-width:17px;height:17px;border-radius:50%;padding:0 3px;font-size:.58rem;font-weight:700;font-family:'DM Mono',monospace;background:rgba(255,255,255,.22);}
.cat-tab:not(.active) .cat-tab-cnt{background:var(--s3);color:var(--tm);}
.status-tabs .cat-tab.active{background:linear-gradient(135deg,var(--teal),#2C9C8A);}

.ing-content{padding:1.375rem 2rem 0;}

.cat-section{margin-bottom:2rem;animation:fadeUp .45s ease both;}
.cat-section-head{display:flex;align-items:center;gap:.625rem;margin-bottom:.875rem;padding-bottom:.625rem;border-bottom:1.5px solid var(--bdr);}
.cat-section-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;background:var(--gold-soft);}
.cat-section-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9375rem;font-weight:700;color:var(--espresso);letter-spacing:-.02em;}
.cat-section-desc{font-size:.71rem;color:var(--tm);margin-top:1px;}
.cat-section-badge{margin-left:auto;font-size:.65rem;font-family:'DM Mono',monospace;font-weight:600;padding:.18rem .6rem;border-radius:20px;background:var(--gold-soft);color:var(--gold-dark);border:1px solid rgba(192,120,40,.2);}

.ing-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(165px,1fr));gap:.75rem;}

.ing-card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rl);overflow:hidden;transition:border-color .2s,box-shadow .2s,transform .2s;box-shadow:0 1px 4px rgba(100,60,20,.06);}
.ing-card:hover{border-color:rgba(192,120,40,.28);box-shadow:0 6px 22px var(--gold-glow);transform:translateY(-2px);}
.ing-card:hover .card-vis-inner{animation:floatY 2.2s ease-in-out infinite;}
.card-visual{height:100px;display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--bdr);background:linear-gradient(160deg,var(--s2) 0%,var(--s3) 100%);position:relative;overflow:hidden;cursor:pointer;}
.card-visual::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(192,120,40,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(192,120,40,.04) 1px,transparent 1px);background-size:15px 15px;}
.card-vis-inner{position:relative;z-index:1;display:flex;align-items:center;justify-content:center;}
.card-ring{width:52px;height:52px;border-radius:50%;border:2px dashed rgba(192,120,40,.25);display:flex;align-items:center;justify-content:center;background:radial-gradient(circle at 35% 35%,rgba(255,255,255,.6),rgba(240,228,210,.3));box-shadow:0 2px 12px rgba(192,120,40,.09);}
.card-emoji{font-size:1.4rem;filter:drop-shadow(0 2px 4px rgba(60,30,5,.18));line-height:1;}
.card-thumb{width:100%;height:100%;object-fit:cover;}
.status-pill{position:absolute;top:.5rem;right:.5rem;z-index:2;font-size:.58rem;font-weight:700;padding:.18rem .5rem;border-radius:20px;display:inline-flex;align-items:center;gap:.25rem;backdrop-filter:blur(4px);}
.status-pill.active{background:rgba(31,122,108,.9);color:#fff;}
.status-pill.coming_soon{background:rgba(192,120,40,.9);color:#fff;}
.status-pill.draft{background:rgba(140,104,64,.85);color:#fff;}
.status-pill.inactive{background:rgba(100,80,64,.65);color:#fff;}
.card-body{padding:.6rem .7rem 0;}
.card-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:.75rem;font-weight:700;color:var(--t1);letter-spacing:-.01em;line-height:1.3;margin-bottom:.35rem;cursor:pointer;}
.card-meta{display:flex;align-items:center;justify-content:space-between;gap:.25rem;}
.card-cat{font-size:.57rem;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--tm);}
.card-price{font-family:'DM Mono',monospace;font-size:.68rem;font-weight:600;color:var(--teal);background:var(--teal-soft);border:1px solid rgba(31,122,108,.16);border-radius:5px;padding:.08rem .35rem;white-space:nowrap;}
.card-price.free{color:var(--tm);background:var(--s3);border-color:var(--bdr);}
.card-actions{display:flex;gap:.35rem;padding:.6rem .7rem .7rem;}
.card-act-btn{flex:1;font-size:.62rem;font-weight:700;padding:.35rem 0;border-radius:6px;border:1.5px solid var(--bdr-md);background:var(--s);color:var(--tm);cursor:pointer;text-align:center;transition:all .15s;}
.card-act-btn:hover{border-color:rgba(192,120,40,.3);color:var(--gold-dark);background:var(--gold-soft);}
.card-act-btn.go:hover{border-color:rgba(31,122,108,.3);color:var(--teal);background:var(--teal-soft);}
.card-act-btn.stop:hover{border-color:rgba(180,56,64,.3);color:var(--rose);background:var(--rose-soft);}

.empty-state{text-align:center;padding:3.5rem 2rem;}
.empty-orb{width:52px;height:52px;border-radius:15px;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.18);display:inline-flex;align-items:center;justify-content:center;margin-bottom:.875rem;color:var(--gold);}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:700;color:var(--t1);margin-bottom:.28rem;}
.empty-desc{font-size:.78rem;color:var(--tm);}

.modal-backdrop{position:fixed;inset:0;background:rgba(28,12,2,.5);backdrop-filter:blur(5px);z-index:1040;display:none;}
.modal-backdrop.show{display:block;animation:fadeIn .18s ease;}
.modal-wrap{position:fixed;inset:0;z-index:1050;display:none;align-items:center;justify-content:center;padding:1rem;overflow-y:auto;}
.modal-wrap.show{display:flex;}
.modal-box{background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--rxl);width:100%;max-width:480px;box-shadow:0 20px 56px rgba(50,20,4,.2);overflow:hidden;position:relative;margin:auto;}
.modal-box.show{animation:slideUp .25s cubic-bezier(.34,1.1,.64,1) both;}
.modal-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--copper),var(--gold-light));z-index:3;}
.modal-head{display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;border-bottom:1.5px solid var(--bdr);background:var(--s2);}
.modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1rem;font-weight:800;color:var(--espresso);}
.modal-close{background:var(--s);border:1.5px solid var(--bdr);color:var(--tm);cursor:pointer;width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:.9rem;transition:all .15s;flex-shrink:0;line-height:1;}
.modal-close:hover{color:var(--rose);background:var(--rose-soft);}
.modal-body{padding:1.125rem 1.25rem;max-height:70vh;overflow-y:auto;}
.f-row{margin-bottom:.875rem;}
.f-row-2{display:grid;grid-template-columns:1fr 1fr;gap:.625rem;}
.f-lbl{display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--tm);margin-bottom:.35rem;}
.f-input,.f-select,.f-textarea{width:100%;border:1.5px solid var(--bdr-md);border-radius:8px;padding:.55rem .7rem;font-size:.82rem;font-family:'DM Sans',sans-serif;color:var(--t1);background:var(--s);transition:border-color .15s;}
.f-input:focus,.f-select:focus,.f-textarea:focus{outline:none;border-color:var(--gold);}
.f-textarea{resize:vertical;min-height:60px;}
.f-hint{font-size:.65rem;color:var(--tm);margin-top:.25rem;}
.modal-foot{display:flex;gap:.625rem;padding:1rem 1.25rem;border-top:1.5px solid var(--bdr);background:var(--s2);}
.btn-cancel{flex:1;padding:.65rem;border-radius:9px;border:1.5px solid var(--bdr-md);background:var(--s);color:var(--tm);font-weight:700;font-size:.8rem;cursor:pointer;}
.btn-save{flex:2;padding:.65rem;border-radius:9px;border:none;background:linear-gradient(135deg,var(--gold),var(--copper));color:#fff;font-weight:700;font-size:.8rem;cursor:pointer;}

@media(max-width:1024px){.stats-row{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.stats-row{grid-template-columns:1fr 1fr;padding:1rem 1rem 0;}.ing-content{padding:1rem 1rem 0;}.ing-grid{grid-template-columns:repeat(2,1fr);}.tab-wrap{padding:1rem 1rem 0;}.f-row-2{grid-template-columns:1fr;}.ing-hero{flex-wrap:wrap;}.search-bar{min-width:0;flex:1;}}
</style>
@endpush

@section('content')

@php
$sections = [
    'cake_type'=>['label'=>'Cake Type','desc'=>'Sponge, chiffon, or cheesecake base','emoji'=>'🍰'],
    'shape'=>['label'=>'Cake Shape','desc'=>'Base form and size','emoji'=>'🎂'],
    'flavor'=>['label'=>'Flavors','desc'=>'Sponge flavor','emoji'=>'🍧'],
    'filling'=>['label'=>'Filling','desc'=>'Between the cake layers','emoji'=>'🥧'],
    'cake_style'=>['label'=>'Cake Style','desc'=>'Overall finish — Smooth BC, Semi-naked, Fondant, Ombre','emoji'=>'🎨'],
    'base_icing'=>['label'=>'Frosting / Icing','desc'=>'Shell Border, Sugar Icing, Rosettes','emoji'=>'🧁'],
    'texture'=>['label'=>'Texture Add-ons','desc'=>'Textured Buttercream, etc.','emoji'=>'🖌️'],
    'drip'=>['label'=>'Drips','desc'=>'Decorative drip layer','emoji'=>'💧'],
    'fruit'=>['label'=>'Fruits','desc'=>'Fresh fruit decorations','emoji'=>'🍓'],
    'choco'=>['label'=>'Chocolate Decor','desc'=>'Artisan chocolate accents','emoji'=>'🍫'],
    'sprinkle'=>['label'=>'Sprinkles','desc'=>'Colorful sprinkle toppings','emoji'=>'✨'],
    'candle'=>['label'=>'Candles & Toppers','desc'=>'Birthday accents','emoji'=>'🕯️'],
    'deco'=>['label'=>'Decorative Elements','desc'=>'Finishing touches','emoji'=>'🌸'],
];
$statusMeta = [
    'draft'        => ['label'=>'Draft','icon'=>'◐'],
    'coming_soon'  => ['label'=>'Coming Soon','icon'=>'✨'],
    'active'       => ['label'=>'Active','icon'=>'●'],
    'inactive'     => ['label'=>'Inactive','icon'=>'○'],
];
$grouped = $ingredients->groupBy('category');
$catLabels = collect($sections)->map(fn($s) => $s['label']);
@endphp

<div class="pg">
    <div class="ing-hero">
        <div class="ing-hero-left">
            <div class="ing-hero-pill"><span class="ing-hero-dot"></span> Cake Builder</div>
            <div class="ing-hero-title"><em>Cake</em> Builder</div>
            <div class="ing-hero-sub">Manage the customization options available to customers.</div>
        </div>
        <div class="ing-hero-right">
            <div class="search-bar">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="searchInput" placeholder="Search components…" oninput="filterAll()">
            </div>
            <button type="button" class="btn-add" onclick="openAdd()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Component
            </button>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div>
                <span class="stat-delta muted">All options</span>
            </div>
            <div class="stat-val">{{ $stats['total'] }}</div>
            <div class="stat-lbl">Total Options</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:100%"></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
                <span class="stat-delta muted">Grouped</span>
            </div>
            <div class="stat-val">{{ $stats['categories'] }}</div>
            <div class="stat-lbl">Categories</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ min(100,$stats['categories']*10) }}%"></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <span class="stat-delta green">Selectable</span>
            </div>
            <div class="stat-val">{{ $stats['active'] }}</div>
            <div class="stat-lbl">Active</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $stats['total']>0 ? min(100, $stats['active']/$stats['total']*100) : 0 }}%"></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">✨</div>
                <span class="stat-delta gold">Preview only</span>
            </div>
            <div class="stat-val">{{ $stats['coming_soon'] }}</div>
            <div class="stat-lbl">Coming Soon</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $stats['total']>0 ? min(100, $stats['coming_soon']/$stats['total']*100) : 0 }}%"></div></div>
        </div>
    </div>

    <div class="tab-wrap">
        <div class="cat-tabs" id="catTabs">
            <div class="cat-tab active" data-cat="all" onclick="switchCatTab(this)">All <span class="cat-tab-cnt">{{ $ingredients->count() }}</span></div>
            @foreach($sections as $key=>$sec)
            <div class="cat-tab" data-cat="{{ $key }}" onclick="switchCatTab(this)">{{ $sec['emoji'] }} {{ $sec['label'] }} <span class="cat-tab-cnt">{{ $categoryCounts[$key] ?? 0 }}</span></div>
            @endforeach
        </div>
        <div class="cat-tabs status-tabs" id="statusTabs">
            <div class="cat-tab active" data-status="all" onclick="switchStatusTab(this)">All Statuses</div>
            @foreach($statusMeta as $key=>$meta)
            <div class="cat-tab" data-status="{{ $key }}" onclick="switchStatusTab(this)">{{ $meta['icon'] }} {{ $meta['label'] }}</div>
            @endforeach
        </div>
    </div>

    <div class="ing-content">
        @foreach($sections as $secKey=>$sec)
        @php $secIngs = $grouped->get($secKey, collect()); @endphp
        <div class="cat-section" data-section="{{ $secKey }}">
            <div class="cat-section-head">
                <div class="cat-section-icon">{{ $sec['emoji'] }}</div>
                <div><div class="cat-section-name">{{ $sec['label'] }}</div><div class="cat-section-desc">{{ $sec['desc'] }}</div></div>
                <span class="cat-section-badge">{{ $secIngs->count() }} options</span>
            </div>
            <div class="ing-grid">
                @foreach($secIngs as $ing)
                @php $meta = $statusMeta[$ing->status] ?? $statusMeta['draft']; @endphp
                <div class="ing-card" data-name="{{ strtolower($ing->name) }}" data-cat="{{ $ing->category }}" data-status="{{ $ing->status }}">
                    <div class="card-visual" onclick='openEdit(@json($ing))'>
                        <span class="status-pill {{ $ing->status }}">{{ $meta['icon'] }} {{ $meta['label'] }}</span>
                        <div class="card-vis-inner">
                            @if($ing->thumbnail_path)
                                <img src="{{ asset('storage/'.$ing->thumbnail_path) }}" class="card-thumb" alt="">
                            @else
                                <div class="card-ring"><span class="card-emoji">{{ $ing->emoji ?? '🎂' }}</span></div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-name" onclick='openEdit(@json($ing))'>{{ $ing->name }}</div>
                        <div class="card-meta">
                            <span class="card-cat">{{ $sec['label'] }}</span>
                            @if((float)$ing->price === 0.0)<span class="card-price free">Free</span>
                            @else<span class="card-price">₱{{ number_format($ing->price) }}</span>@endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <button type="button" class="card-act-btn" onclick='openEdit(@json($ing))'>Edit</button>
                        @if($ing->status === 'active')
                        <button type="button" class="card-act-btn stop" onclick="quickStatus({{ $ing->id }}, 'inactive')">Deactivate</button>
                        @else
                        <button type="button" class="card-act-btn go" onclick="quickStatus({{ $ing->id }}, 'active')">Activate</button>
                        @endif
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
                <div class="empty-desc">Try a different search term or filter.</div>
            </div>
        </div>
    </div>
</div>

<!-- ADD/EDIT MODAL -->
<div class="modal-backdrop" id="modalBackdrop"></div>
<div class="modal-wrap" id="formModal">
    <div class="modal-box" id="formModalBox" onclick="event.stopPropagation()">
        <form id="componentForm" method="POST" enctype="multipart/form-data" action="{{ route('ingredients.store') }}">
            @csrf
            <input type="hidden" name="_method_slot" id="methodSlot">
            <div class="modal-head">
                <div class="modal-title" id="modalTitle">Add Component</div>
                <button type="button" class="modal-close" onclick="closeForm()">×</button>
            </div>
            <div class="modal-body">
                <div class="f-row">
                    <label class="f-lbl">Component Name</label>
                    <input type="text" name="name" id="f_name" class="f-input" required maxlength="255">
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl">Category</label>
                        <select name="category" id="f_category" class="f-select" required>
                            @foreach($sections as $key=>$sec)
                            <option value="{{ $key }}">{{ $sec['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="f-lbl">Status</label>
                        <select name="status" id="f_status" class="f-select" required>
                            @foreach($statusMeta as $key=>$meta)
                            <option value="{{ $key }}">{{ $meta['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                          <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl">Price — Single Tier (₱)</label>
                        <input type="number" name="price" id="f_price" class="f-input" step="0.01" min="0" required>
                    </div>
                    <div>
                        <label class="f-lbl">Price Unit</label>
                        <input type="text" name="price_unit" id="f_price_unit" class="f-input" placeholder="add-on, per piece, included…">
                    </div>
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl">Price — Two-Tier (₱)</label>
                        <input type="number" name="price_two_tier" id="f_price_two_tier" class="f-input" step="0.01" min="0" placeholder="Leave blank to use Single price">
                    </div>
                    <div>
                        <label class="f-lbl">Price — Three-Tier (₱)</label>
                        <input type="number" name="price_three_tier" id="f_price_three_tier" class="f-input" step="0.01" min="0" placeholder="Leave blank to use Single price">
                    </div>
                </div>
                <div class="f-hint" style="margin-top:-.5rem;margin-bottom:.5rem;">Only matters for components whose price changes with cake tier (Cake Style, Frosting/Icing, Texture, Drip, Sprinkles, Choco Curls/Sprinkles, Crushed Peanuts). Leave blank for everything else.</div>
                <div class="f-row">
                    <label class="f-lbl">Description</label>
                    <textarea name="description" id="f_description" class="f-textarea" maxlength="1000"></textarea>
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl">Component Type</label>
                        <select name="component_type" id="f_component_type" class="f-select" required>
                            <option value="model_based">Model-based (uses a GLB asset)</option>
                            <option value="material_based">Material-based (recolors existing mesh)</option>
                        </select>
                    </div>
                    <div>
                        <label class="f-lbl">Placement</label>
                        <select name="placement" id="f_placement" class="f-select">
                            <option value="">— Not applicable —</option>
                            <option value="top_center">Top Center</option>
                            <option value="top_left">Top Left</option>
                            <option value="top_right">Top Right</option>
                            <option value="front_center">Front Center</option>
                            <option value="side_left">Side Left</option>
                            <option value="side_right">Side Right</option>
                            <option value="base">Base</option>
                        </select>
                    </div>
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl">3D Model (.glb)</label>
                        <input type="file" name="model_file" class="f-input" accept=".glb">
                        <div class="f-hint" id="f_model_current"></div>
                    </div>
                    <div>
                        <label class="f-lbl">Thumbnail Image</label>
                        <input type="file" name="thumbnail_file" class="f-input" accept="image/*">
                        <div class="f-hint" id="f_thumb_current"></div>
                    </div>
                </div>
                <div class="f-row">
                    <label class="f-lbl">Icon (emoji fallback, shown if no thumbnail)</label>
                    <input type="text" name="emoji" id="f_emoji" class="f-input" maxlength="10" placeholder="🎂">
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="closeForm()">Cancel</button>
                <button type="submit" class="btn-save" id="formSaveBtn">Save Component</button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden quick-status form -->
<form id="statusForm" method="POST" style="display:none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" id="statusFormValue">
</form>

@push('scripts')
<script>
const storeUrl = "{{ route('ingredients.store') }}";
const statusUrlTemplate = "{{ route('ingredients.status', ['ingredient' => '__ID__']) }}";
const updateUrlTemplate = "{{ route('ingredients.update', ['ingredient' => '__ID__']) }}";

function switchCatTab(el){
    document.querySelectorAll('#catTabs .cat-tab').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
    applyFilters();
}
function switchStatusTab(el){
    document.querySelectorAll('#statusTabs .cat-tab').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
    applyFilters();
}
function filterAll(){ applyFilters(); }

function applyFilters(){
    const q = document.getElementById('searchInput').value.toLowerCase().trim();
    const cat = document.querySelector('#catTabs .cat-tab.active').dataset.cat;
    const status = document.querySelector('#statusTabs .cat-tab.active').dataset.status;
    let anyVisible = false;

    document.querySelectorAll('.cat-section').forEach(sec=>{
        const sectionMatchesCat = (cat === 'all' || sec.dataset.section === cat);
        let hasVisibleCard = false;

        sec.querySelectorAll('.ing-card').forEach(card=>{
            const matchesText = !q || card.dataset.name.includes(q) || card.dataset.cat.includes(q);
            const matchesStatus = (status === 'all' || card.dataset.status === status);
            const visible = sectionMatchesCat && matchesText && matchesStatus;
            card.style.display = visible ? '' : 'none';
            if (visible) hasVisibleCard = true;
        });

        sec.style.display = hasVisibleCard ? '' : 'none';
        if (hasVisibleCard) anyVisible = true;
    });

    document.getElementById('noResults').style.display = anyVisible ? 'none' : 'block';
}

function openAdd(){
    document.getElementById('modalTitle').textContent = 'Add Component';
    document.getElementById('componentForm').action = storeUrl;
    document.getElementById('methodSlot').remove?.();
    document.getElementById('componentForm').querySelectorAll('input[name="_method"]').forEach(el=>el.remove());
       document.getElementById('componentForm').reset();
    document.getElementById('f_price_two_tier').value = '';
    document.getElementById('f_price_three_tier').value = '';
    document.getElementById('f_model_current').textContent = '';
    document.getElementById('f_thumb_current').textContent = '';
    document.getElementById('formSaveBtn').textContent = 'Save Component';
    showForm();
}

function openEdit(ing){
    document.getElementById('modalTitle').textContent = 'Edit Component';
    document.getElementById('componentForm').action = updateUrlTemplate.replace('__ID__', ing.id);
    document.getElementById('componentForm').querySelectorAll('input[name="_method"]').forEach(el=>el.remove());
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden'; methodInput.name = '_method'; methodInput.value = 'PUT';
    document.getElementById('componentForm').appendChild(methodInput);

    document.getElementById('f_name').value = ing.name || '';
    document.getElementById('f_category').value = ing.category || 'shape';
    document.getElementById('f_status').value = ing.status || 'draft';
    document.getElementById('f_price').value = ing.price || 0;
    document.getElementById('f_price_two_tier').value = ing.price_two_tier ?? '';
    document.getElementById('f_price_three_tier').value = ing.price_three_tier ?? '';
    document.getElementById('f_price_unit').value = ing.price_unit || '';
    document.getElementById('f_description').value = ing.description || '';
    document.getElementById('f_component_type').value = ing.component_type || 'material_based';
    document.getElementById('f_placement').value = ing.placement || '';
    document.getElementById('f_emoji').value = ing.emoji || '';
    document.getElementById('f_model_current').textContent = ing.model_path ? ('Current: ' + ing.model_path) : '';
    document.getElementById('f_thumb_current').textContent = ing.thumbnail_path ? ('Current: ' + ing.thumbnail_path) : '';
    document.getElementById('formSaveBtn').textContent = 'Update Component';
    showForm();
}

function showForm(){
    document.getElementById('modalBackdrop').classList.add('show');
    document.getElementById('formModal').classList.add('show');
    document.getElementById('formModalBox').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeForm(){
    document.getElementById('modalBackdrop').classList.remove('show');
    document.getElementById('formModal').classList.remove('show');
    document.getElementById('formModalBox').classList.remove('show');
    document.body.style.overflow = '';
}
document.getElementById('modalBackdrop').addEventListener('click', closeForm);
document.addEventListener('keydown', e=>{ if(e.key==='Escape') closeForm(); });

function quickStatus(id, status){
    const form = document.getElementById('statusForm');
    form.action = statusUrlTemplate.replace('__ID__', id);
    document.getElementById('statusFormValue').value = status;
    form.submit();
}

document.addEventListener('DOMContentLoaded', ()=>{
    document.querySelectorAll('.cat-section').forEach((sec,i)=>{ sec.style.animationDelay = `${0.06+i*0.06}s`; });
});
</script>
@endpush

@endsection