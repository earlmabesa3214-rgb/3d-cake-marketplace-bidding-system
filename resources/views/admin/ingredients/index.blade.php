@extends('layouts.admin')
@section('title', 'Cake Builder')

@push('styles')
<style>
/* Scoped to .bs so nothing leaks into the admin layout. Uses native CSS nesting. */
.bs{
    --espresso:#24150F;--choc:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;
    --caramel:#A96F42;--gold:#B89452;--burgundy:#54252C;--taupe:#9A897A;--beige:#D8C8B7;
    --ok:#4F7A5E;--ok-soft:#E6EFE9;--warn:#A47C34;--warn-soft:#F5EDDB;
    --danger:#8E3B3B;--danger-soft:#F6E7E5;--info:#4F6A7A;--info-soft:#E6ECEF;
    --surface:#FFFDFA;
    font-family:'Plus Jakarta Sans',sans-serif;color:var(--espresso);background:var(--ivory);
    min-height:100%;

    & *,& *::before,& *::after{box-sizing:border-box;font-family:inherit;}
    & button{font:inherit;}
    & :focus-visible{outline:none;box-shadow:0 0 0 3px rgba(184,148,82,.4);}

    /* ---------- Header ---------- */
    & .pg{padding:0 0 5rem;}
    & .ph{display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;padding-bottom:1.5rem;margin-bottom:1.5rem;border-bottom:1px solid var(--beige);position:relative;}
    & .ph::after{content:'';position:absolute;left:0;bottom:-1px;width:72px;height:2px;background:var(--gold);}
    & .crumbs{display:flex;flex-wrap:wrap;gap:.5rem;font-size:.66rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--taupe);margin-bottom:.9rem;}
    & .crumbs .cur{color:var(--caramel);}
    & .ph-title{font-size:1.85rem;font-weight:800;letter-spacing:-.035em;line-height:1.1;margin:0 0 .5rem;}
    & .ph-sub{font-size:.85rem;color:var(--taupe);margin:0;}
    & .ph-actions{display:flex;align-items:center;gap:.625rem;flex-wrap:wrap;}

    & .search-bar{display:flex;align-items:center;gap:.5rem;background:#fff;border:1px solid var(--beige);border-radius:10px;padding:0 .875rem;height:42px;min-width:250px;transition:border-color .15s,box-shadow .15s;}
    & .search-bar:focus-within{border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.22);}
    & .search-bar svg{color:var(--taupe);flex-shrink:0;}
    & .search-bar input{border:none;background:none;outline:none;box-shadow:none;font-size:.82rem;color:var(--espresso);width:100%;}
    & .search-bar input::placeholder{color:var(--taupe);}

    & .btn{display:inline-flex;align-items:center;gap:.45rem;height:42px;padding:0 1.1rem;border-radius:10px;font-size:.78rem;font-weight:800;cursor:pointer;white-space:nowrap;transition:background .15s,border-color .15s,box-shadow .15s,transform .15s;}
    & .btn-add{border:1px solid var(--caramel);background:linear-gradient(135deg,var(--gold),var(--caramel));color:#fff;box-shadow:0 4px 14px rgba(169,111,66,.26);}
    & .btn-add:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(169,111,66,.32);}
    & .btn-trash{border:1px solid var(--beige);background:#fff;color:var(--choc);}
    & .btn-trash:hover{background:var(--cream);border-color:var(--taupe);}
    & .trash-count{min-width:18px;height:18px;padding:0 5px;border-radius:9px;background:var(--burgundy);color:#fff;font-size:.62rem;display:inline-flex;align-items:center;justify-content:center;}

    /* ---------- Stats ---------- */
    & .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem;}
    & .stat-card{background:var(--surface);border:1px solid var(--beige);border-radius:14px;padding:1.15rem 1.15rem 1rem;box-shadow:0 1px 2px rgba(36,21,15,.04);}
    & .stat-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:.9rem;}
    & .stat-icon{width:34px;height:34px;border-radius:9px;background:var(--espresso);color:var(--gold);display:flex;align-items:center;justify-content:center;}
    & .stat-delta{font-size:.62rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:.22rem .55rem;border-radius:20px;background:var(--cream);color:var(--taupe);}
    & .stat-delta.green{background:var(--ok-soft);color:var(--ok);}
    & .stat-delta.gold{background:var(--warn-soft);color:var(--warn);}
    & .stat-val{font-size:2rem;font-weight:800;letter-spacing:-.04em;line-height:1;font-variant-numeric:tabular-nums;}
    & .stat-lbl{font-size:.66rem;font-weight:800;color:var(--taupe);text-transform:uppercase;letter-spacing:.12em;margin-top:.4rem;}
    & .stat-bar{height:3px;border-radius:2px;margin-top:.85rem;background:var(--cream);overflow:hidden;}
    & .stat-bar-fill{height:100%;background:var(--gold);border-radius:2px;}

    /* ---------- Filters ---------- */
    & .tab-wrap{display:flex;flex-direction:column;gap:.6rem;margin-top:1.75rem;margin-bottom:1.75rem;}
    & .cat-tabs{display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;}
    & .cat-tab{display:inline-flex;align-items:center;gap:.4rem;padding:.42rem .85rem;border-radius:30px;font-size:.72rem;font-weight:700;cursor:pointer;border:1px solid var(--beige);background:#fff;color:var(--choc);transition:all .15s;white-space:nowrap;}
    & .cat-tab:hover{border-color:var(--gold);background:var(--cream);}
    & .cat-tab.active{background:var(--espresso);border-color:var(--espresso);color:var(--cream);}
    & .cat-tab-cnt{display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;border-radius:9px;padding:0 5px;font-size:.6rem;font-weight:800;background:var(--cream);color:var(--taupe);font-variant-numeric:tabular-nums;}
    & .cat-tab.active .cat-tab-cnt{background:rgba(255,255,255,.14);color:var(--gold);}
    & .status-tabs .cat-tab.active{background:var(--caramel);border-color:var(--caramel);color:#fff;}

    /* ---------- Sections + cards ---------- */
    & .cat-section{margin-bottom:2.25rem;}
    & .cat-section-head{display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;padding-bottom:.7rem;border-bottom:1px solid var(--beige);}
    & .cat-section-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--cream);color:var(--caramel);}
    & .cat-section-name{font-size:.95rem;font-weight:800;letter-spacing:-.02em;}
    & .cat-section-desc{font-size:.71rem;color:var(--taupe);margin-top:2px;}
    & .cat-section-badge{margin-left:auto;font-size:.62rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;padding:.25rem .65rem;border-radius:20px;background:var(--cream);color:var(--choc);white-space:nowrap;}

    & .ing-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.875rem;}
    & .ing-card{background:var(--surface);border:1px solid var(--beige);border-radius:12px;overflow:hidden;transition:border-color .2s,box-shadow .2s;}
    & .ing-card:hover{border-color:var(--gold);box-shadow:0 8px 24px rgba(36,21,15,.08);}
    & .card-visual{height:96px;display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--beige);background:var(--cream);position:relative;overflow:hidden;cursor:pointer;}
    & .card-ring{width:48px;height:48px;border-radius:50%;border:1px solid var(--beige);display:flex;align-items:center;justify-content:center;background:var(--surface);color:var(--caramel);}
    & .card-thumb{width:100%;height:100%;object-fit:cover;}
    & .status-pill{position:absolute;top:.5rem;right:.5rem;z-index:2;font-size:.58rem;font-weight:800;letter-spacing:.04em;padding:.2rem .55rem;border-radius:20px;display:inline-flex;align-items:center;gap:.3rem;background:rgba(255,253,250,.94);border:1px solid var(--beige);color:var(--choc);}
    & .status-pill::before{content:'';width:6px;height:6px;border-radius:50%;background:var(--taupe);}
    & .status-pill.active::before{background:var(--ok);}
    & .status-pill.coming_soon::before{background:var(--gold);}
    & .status-pill.draft::before{background:var(--info);}
    & .status-pill.inactive::before{background:var(--burgundy);}
    & .card-body{padding:.75rem .8rem 0;}
    & .card-name{font-size:.8rem;font-weight:800;letter-spacing:-.01em;line-height:1.3;margin-bottom:.45rem;cursor:pointer;}
    & .card-meta{display:flex;align-items:center;justify-content:space-between;gap:.3rem;}
    & .card-cat{font-size:.58rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--taupe);}
    & .card-price{font-size:.7rem;font-weight:800;color:var(--choc);background:var(--cream);border-radius:6px;padding:.12rem .45rem;white-space:nowrap;font-variant-numeric:tabular-nums;}
    & .card-price.free{color:var(--taupe);background:transparent;border:1px solid var(--beige);}
    & .card-actions{display:flex;flex-wrap:wrap;gap:.35rem;padding:.75rem .8rem .8rem;}
    & .card-act-btn{flex:1;font-size:.64rem;font-weight:800;padding:.42rem 0;border-radius:7px;border:1px solid var(--beige);background:#fff;color:var(--choc);cursor:pointer;text-align:center;transition:all .15s;}
    & .card-act-btn:hover{border-color:var(--gold);background:var(--cream);}
    & .card-act-btn.go:hover{border-color:var(--ok);color:var(--ok);background:var(--ok-soft);}
    & .card-act-btn.stop:hover{border-color:var(--danger);color:var(--danger);background:var(--danger-soft);}
    & .card-act-btn.del{flex:1 1 100%;color:var(--danger);border-color:rgba(142,59,59,.28);}
    & .card-act-btn.del:hover{border-color:var(--danger);background:var(--danger-soft);}

    & .empty-state{text-align:center;padding:3.5rem 2rem;}
    & .empty-orb{width:52px;height:52px;border-radius:14px;background:var(--cream);display:inline-flex;align-items:center;justify-content:center;margin-bottom:.9rem;color:var(--caramel);}
    & .empty-title{font-size:.92rem;font-weight:800;margin-bottom:.3rem;}
    & .empty-desc{font-size:.78rem;color:var(--taupe);}

    /* ---------- Modals ---------- */
    & .modal-backdrop{position:fixed;inset:0;background:rgba(36,21,15,.55);backdrop-filter:blur(4px);z-index:1040;display:none;opacity:1;}
    & .modal-backdrop.show{display:block;}
    & .modal-wrap{position:fixed;inset:0;z-index:1050;display:none;align-items:center;justify-content:center;padding:1rem;overflow-y:auto;}
    & .modal-wrap.show{display:flex;}
    & .modal-box{background:var(--surface);border:1px solid var(--beige);border-radius:14px;width:100%;max-width:520px;box-shadow:0 24px 60px rgba(36,21,15,.28);overflow:hidden;position:relative;margin:auto;}
    & .modal-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--caramel));z-index:3;}
    & .modal-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1.15rem 1.35rem;border-bottom:1px solid var(--beige);background:var(--cream);}
    & .modal-title{display:flex;align-items:center;gap:.6rem;font-size:1rem;font-weight:800;letter-spacing:-.02em;}
    & .modal-title svg{color:var(--caramel);}
    & .modal-close{background:#fff;border:1px solid var(--beige);color:var(--taupe);cursor:pointer;width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;transition:all .15s;flex-shrink:0;}
    & .modal-close:hover{color:var(--danger);background:var(--danger-soft);}
    & .modal-body{padding:1.25rem 1.35rem;max-height:68vh;overflow-y:auto;}
    & .f-row{margin-bottom:1rem;}
    & .f-row-2{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;}
    & .f-lbl{display:block;font-size:.64rem;font-weight:800;text-transform:uppercase;letter-spacing:.11em;color:var(--choc);margin-bottom:.4rem;}
    & .f-input,& .f-select,& .f-textarea{width:100%;border:1px solid var(--beige);border-radius:9px;padding:.6rem .75rem;font-size:.84rem;color:var(--espresso);background:#fff;transition:border-color .15s,box-shadow .15s;}
    & .f-input,& .f-select{min-height:42px;}
    & .f-input:hover,& .f-select:hover,& .f-textarea:hover{border-color:var(--taupe);}
    & .f-input:focus,& .f-select:focus,& .f-textarea:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.22);}
    & .f-textarea{resize:vertical;min-height:70px;}
    & .f-hint{font-size:.68rem;color:var(--taupe);margin-top:.3rem;line-height:1.5;}
    & .modal-foot{display:flex;gap:.625rem;padding:1rem 1.35rem;border-top:1px solid var(--beige);background:var(--ivory);}
    & .btn-cancel,& .btn-save,& .btn-danger{padding:.7rem;border-radius:10px;font-weight:800;font-size:.8rem;cursor:pointer;transition:all .15s;}
    & .btn-cancel{flex:1;border:1px solid var(--beige);background:#fff;color:var(--choc);}
    & .btn-cancel:hover{background:var(--cream);border-color:var(--taupe);}
    & .btn-save{flex:2;border:1px solid var(--caramel);background:linear-gradient(135deg,var(--gold),var(--caramel));color:#fff;}
    & .btn-danger{flex:1.4;border:1px solid var(--burgundy);background:var(--burgundy);color:#fff;}
    & .btn-danger:hover{background:#6a2f37;}

    & .trash-row{display:flex;align-items:center;gap:.75rem;padding:.75rem 0;border-bottom:1px solid var(--beige);}
    & .trash-row:last-child{border-bottom:none;}
    & .trash-emoji{width:38px;height:38px;border-radius:10px;background:var(--cream);color:var(--caramel);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    & .trash-info{flex:1;min-width:0;}
    & .trash-name{font-size:.82rem;font-weight:800;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    & .trash-meta{font-size:.68rem;color:var(--taupe);margin-top:2px;}
    & .trash-actions{display:flex;gap:.35rem;flex-shrink:0;}
    & .trash-actions .card-act-btn{flex:none;padding:.42rem .75rem;}
    & .confirm-body{text-align:center;padding:1.6rem 1.35rem 1.1rem;}
    & .confirm-icon{width:54px;height:54px;border-radius:50%;background:var(--danger-soft);color:var(--danger);display:inline-flex;align-items:center;justify-content:center;margin-bottom:.8rem;}
    & .confirm-msg{font-size:.85rem;color:var(--choc);line-height:1.55;}
    & #confirmBackdrop{z-index:1060;}
    & #confirmWrap{z-index:1070;}
}
/* ---------- animations ---------- */
@keyframes bs-rise{from{opacity:0;transform:translatey(10px)}to{opacity:1;transform:none}}
@keyframes bs-fade{from{opacity:0}to{opacity:1}}
@keyframes bs-pop{from{opacity:0;transform:translatey(12px) scale(.97)}to{opacity:1;transform:none}}
.bs .tab-wrap{animation:bs-fade .5s .1s ease both;}
.bs .cat-section{animation:bs-rise .5s ease both;}
.bs .ing-content > .cat-section:nth-child(2){animation-delay:.08s;}
.bs .ing-content > .cat-section:nth-child(3){animation-delay:.16s;}
.bs .ing-card{animation:bs-rise .45s .1s ease both;}
.bs .ing-card:nth-child(2){animation-delay:.14s;}
.bs .ing-card:nth-child(3){animation-delay:.18s;}
.bs .ing-card:nth-child(4){animation-delay:.22s;}
.bs .ing-card:nth-child(5){animation-delay:.26s;}
.bs .ing-card:nth-child(6){animation-delay:.30s;}
.bs .ing-card:nth-child(n+7){animation-delay:.34s;}
.bs .modal-backdrop.show{animation:bs-fade .2s ease both;}
.bs .modal-wrap.show .modal-box{animation:bs-pop .28s ease both;}
@media (prefers-reduced-motion:reduce){.bs *{animation:none !important;transition:none !important;}}
@media(max-width:1024px){.bs .stats-row{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){
    .bs .pg{padding:0 0 3rem;}
    .bs .ph-title{font-size:1.5rem;}
    .bs .ph-actions{width:100%;}
    .bs .search-bar{min-width:0;flex:1 1 100%;}
    .bs .stats-row{gap:.625rem;}
    .bs .stat-val{font-size:1.6rem;}
    .bs .ing-grid{grid-template-columns:repeat(2,1fr);}
    .bs .f-row-2{grid-template-columns:1fr;}
    .bs .f-input,.bs .f-select,.bs .f-textarea{font-size:1rem;}
    .bs .trash-row{flex-wrap:wrap;}
}
</style>
@endpush

@section('content')

@php
// same order and names as the customer cake builder
$sections = [
    'shape'      =>['label'=>'Cake Shape',         'desc'=>'round, square, heart, number, bundt (and tier pricing)'],
    'cake_type'  =>['label'=>'Cake Type',          'desc'=>'Sponge, Chiffon, Cheesecake base'],
    'cake_style' =>['label'=>'Cake Style',         'desc'=>'Buttercream, Semi-naked, Fondant, Ombre'],
    'flavor'     =>['label'=>'Flavor & Layers',    'desc'=>'Cake flavors (also used for fillings)'],
    'filling'    =>['label'=>'Filling',            'desc'=>'Between the cake layers'],
    'base_icing' =>['label'=>'Borders & Icing',    'desc'=>'Shell Border, Sugar Icing, Rosettes'],
    'texture'    =>['label'=>'Texture',            'desc'=>'Textured Buttercream'],
    'drip'       =>['label'=>'Drip',               'desc'=>'Drip layer and drip flavors'],
    'fruit'      =>['label'=>'Fruits',             'desc'=>'By piece and by weight (Mango, Kiwi, Peach, Banana)'],
    'choco'      =>['label'=>'Chocolates',         'desc'=>'Ferrero, KitKat, Oreo, Bar Shard, Curls, Plaque, Toblerone, Sprinkles, Peanuts'],
    'sprinkle'   =>['label'=>'Sprinkles',          'desc'=>'Cylinder Mix and Pearl Mix'],
    'candle'     =>['label'=>'Candles & Toppers',  'desc'=>'Number candles and character toppers'],
    'deco'       =>['label'=>'Decorative Elements','desc'=>'Other finishing touches'],
];
$statusMeta = [
    'draft'        => ['label'=>'Draft'],
    'coming_soon'  => ['label'=>'Coming Soon'],
    'active'       => ['label'=>'Active'],
    'inactive'     => ['label'=>'Inactive'],
];
$grouped = $ingredients->groupBy('category');
if ($grouped->get('deco', collect())->isEmpty()) { unset($sections['deco']); }
$catLabels = collect($sections)->map(fn($s) => $s['label']);

// SVG icon bodies (24x24, stroke) per category, replacing the old emoji
$iconBodies = [
    'shape'      => '<rect x="4" y="4" width="16" height="16" rx="3"/>',
    'cake_type'  => '<path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M3 13l9 5 9-5"/>',
    'cake_style' => '<path d="M12 3a9 9 0 1 0 0 18c1.1 0 2-.9 2-2 0-.5-.2-1-.5-1.4-.3-.4-.5-.9-.5-1.4 0-1.1.9-2 2-2H17a4 4 0 0 0 4-4c0-4.4-4-7.2-9-7.2z"/>',
    'flavor'     => '<path d="M8 3h8l-1 6a3 3 0 0 1-6 0L8 3z"/><path d="M12 12v9M8 21h8"/>',
    'filling'    => '<ellipse cx="12" cy="7" rx="8" ry="3"/><path d="M4 7v5c0 1.7 3.6 3 8 3s8-1.3 8-3V7"/><path d="M4 12v5c0 1.7 3.6 3 8 3s8-1.3 8-3v-5"/>',
    'base_icing' => '<path d="M3 9c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/><path d="M3 15c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/>',
    'texture'    => '<rect x="4" y="4" width="16" height="16"/><path d="M4 12h16M12 4v16"/>',
    'drip'       => '<path d="M12 3s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11z"/>',
    'fruit'      => '<circle cx="12" cy="14" r="7"/><path d="M12 7c0-2 1-3.5 3-4"/>',
    'choco'      => '<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M5 9h14M5 15h14M12 3v18"/>',
    'sprinkle'   => '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/>',
    'candle'     => '<rect x="9" y="10" width="6" height="11" rx="1"/><path d="M12 3c1.5 1.5 2 2.7 2 3.7a2 2 0 0 1-4 0c0-1 .5-2.2 2-3.7z"/>',
    'deco'       => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M18.4 5.6l-2.1 2.1M7.7 16.3l-2.1 2.1"/>',
];
$ico = fn($k, $s = 18) => '<svg width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($iconBodies[$k] ?? $iconBodies['deco']).'</svg>';
$trashSvg = '<svg width="%1$s" height="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>';
@endphp

<div class="bs ah-page">
<div class="pg">

<div class="ah-top">
<header class="ah-hero">
    <div class="ah-hero-main">
        <span class="ah-hero-mark"><svg class="ah-ic" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></span>
        <div>
            <div class="ah-eyebrow">BakeSphere &middot; Operations</div>
            <h1 class="ah-title">Cake Builder</h1>
            <p class="ah-subtitle">Manage the customization options available to customers.</p>
        </div>
    </div>
   <div class="ah-side ah-side--actions">
    <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="searchInput" placeholder="Search components…" aria-label="Search components" oninput="filterAll()">
    </div>
    <button type="button" class="btn btn-trash" onclick="openTrash()">
        {!! sprintf($trashSvg, 16) !!} Trash
        @if($trashed->count())<span class="trash-count">{{ $trashed->count() }}</span>@endif
    </button>
    <button type="button" class="btn btn-add" onclick="openAdd()">+ Add Component</button>
</div>
</header>
<section class="ah-ledger" aria-label="Component summary">
    <div class="ah-fig"><div class="ah-fig-lbl">Total Options</div><div class="ah-fig-val">{{ $stats['total'] }}</div><div class="ah-fig-note">All options</div></div>
    <div class="ah-fig ah-fig--caramel"><div class="ah-fig-lbl">Categories</div><div class="ah-fig-val">{{ $stats['categories'] }}</div><div class="ah-fig-note">Grouped</div></div>
    <div class="ah-fig ah-fig--sage"><div class="ah-fig-lbl">Active</div><div class="ah-fig-val">{{ $stats['active'] }}</div><div class="ah-fig-note">Selectable</div></div>
    <div class="ah-fig ah-fig--taupe"><div class="ah-fig-lbl">Coming Soon</div><div class="ah-fig-val">{{ $stats['coming_soon'] }}</div><div class="ah-fig-note">Preview only</div></div>
</section>
</div>
    <div class="tab-wrap">
        <div class="cat-tabs" id="catTabs" role="group" aria-label="Filter by category">
            <button type="button" class="cat-tab active" data-cat="all" onclick="switchCatTab(this)">All <span class="cat-tab-cnt">{{ $ingredients->count() }}</span></button>
            @foreach($sections as $key=>$sec)
            <button type="button" class="cat-tab" data-cat="{{ $key }}" onclick="switchCatTab(this)">{{ $sec['label'] }} <span class="cat-tab-cnt">{{ $categoryCounts[$key] ?? 0 }}</span></button>
            @endforeach
        </div>
        <div class="cat-tabs status-tabs" id="statusTabs" role="group" aria-label="Filter by status">
            <button type="button" class="cat-tab active" data-status="all" onclick="switchStatusTab(this)">All Statuses</button>
            @foreach($statusMeta as $key=>$meta)
            <button type="button" class="cat-tab" data-status="{{ $key }}" onclick="switchStatusTab(this)">{{ $meta['label'] }}</button>
            @endforeach
        </div>
    </div>

    <div class="ing-content">
        @foreach($sections as $secKey=>$sec)
        @php $secIngs = $grouped->get($secKey, collect()); @endphp
        <section class="cat-section" data-section="{{ $secKey }}">
            <div class="cat-section-head">
                <div class="cat-section-icon">{!! $ico($secKey) !!}</div>
                <div><h2 class="cat-section-name">{{ $sec['label'] }}</h2><div class="cat-section-desc">{{ $sec['desc'] }}</div></div>
                <span class="cat-section-badge">{{ $secIngs->count() }} options</span>
            </div>
            <div class="ing-grid">
                @foreach($secIngs as $ing)
                @php $meta = $statusMeta[$ing->status] ?? $statusMeta['draft']; @endphp
                <div class="ing-card" data-name="{{ strtolower($ing->name) }}" data-cat="{{ $ing->category }}" data-status="{{ $ing->status }}">
                    <div class="card-visual" onclick='openEdit(@json($ing))'>
                        <span class="status-pill {{ $ing->status }}">{{ $meta['label'] }}</span>
                        @if($ing->thumbnail_path)
                            <img src="{{ asset('storage/'.$ing->thumbnail_path) }}" class="card-thumb" alt="">
                        @else
                            <div class="card-ring">{!! $ico($secKey, 22) !!}</div>
                        @endif
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
                        <button type="button" class="card-act-btn del" onclick="askDelete({{ $ing->id }}, @js($ing->name))">Delete</button>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach

        <div id="noResults" style="display:none;">
            <div class="empty-state">
                <div class="empty-orb"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
                <div class="empty-title">No results found</div>
                <div class="empty-desc">Try a different search term or filter.</div>
            </div>
        </div>
    </div>
</div>

<!-- ADD/EDIT MODAL -->
<div class="modal-backdrop" id="modalBackdrop"></div>
<div class="modal-wrap" id="formModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-box" id="formModalBox" onclick="event.stopPropagation()">
        <form id="componentForm" method="POST" enctype="multipart/form-data" action="{{ route('ingredients.store') }}">
            @csrf
            <input type="hidden" name="_method_slot" id="methodSlot">
            <div class="modal-head">
                <div class="modal-title" id="modalTitle">Add Component</div>
                <button type="button" class="modal-close" onclick="closeForm()" aria-label="Close"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="modal-body">
                <div class="f-row">
                    <label class="f-lbl" for="f_name">Component Name</label>
                    <input type="text" name="name" id="f_name" class="f-input" required maxlength="255">
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl" for="f_category">Category</label>
                        <select name="category" id="f_category" class="f-select" required>
                            @foreach($sections as $key=>$sec)
                            <option value="{{ $key }}">{{ $sec['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="f-lbl" for="f_status">Status</label>
                        <select name="status" id="f_status" class="f-select" required>
                            @foreach($statusMeta as $key=>$meta)
                            <option value="{{ $key }}">{{ $meta['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl" for="f_price">Price — Single Tier (₱)</label>
                        <input type="number" name="price" id="f_price" class="f-input" step="0.01" min="0" required>
                    </div>
                    <div>
                        <label class="f-lbl" for="f_price_unit">Price Unit</label>
                        <input type="text" name="price_unit" id="f_price_unit" class="f-input" placeholder="add-on, per piece, included…">
                    </div>
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl" for="f_price_two_tier">Price — Two-Tier (₱)</label>
                        <input type="number" name="price_two_tier" id="f_price_two_tier" class="f-input" step="0.01" min="0" placeholder="Leave blank to use Single price">
                    </div>
                    <div>
                        <label class="f-lbl" for="f_price_three_tier">Price — Three-Tier (₱)</label>
                        <input type="number" name="price_three_tier" id="f_price_three_tier" class="f-input" step="0.01" min="0" placeholder="Leave blank to use Single price">
                    </div>
                </div>
                <div class="f-hint" style="margin-top:-.5rem;margin-bottom:1rem;">Only matters for components whose price changes with cake tier (Cake Style, Frosting/Icing, Texture, Drip, Sprinkles, Choco Curls/Sprinkles, Crushed Peanuts). Leave blank for everything else.</div>
                <div class="f-row">
                    <label class="f-lbl" for="f_description">Description</label>
                    <textarea name="description" id="f_description" class="f-textarea" maxlength="1000"></textarea>
                </div>
                <div class="f-row f-row-2">
                    <div>
                        <label class="f-lbl" for="f_component_type">Component Type</label>
                        <select name="component_type" id="f_component_type" class="f-select" required>
                            <option value="model_based">Model-based (uses a GLB asset)</option>
                            <option value="material_based">Material-based (recolors existing mesh)</option>
                        </select>
                    </div>
                    <div>
                        <label class="f-lbl" for="f_placement">Placement</label>
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
                        <label class="f-lbl" for="f_model_file">3D Model (.glb)</label>
                        <input type="file" name="model_file" id="f_model_file" class="f-input" accept=".glb">
                        <div class="f-hint" id="f_model_current"></div>
                    </div>
                    <div>
                        <label class="f-lbl" for="f_thumbnail_file">Thumbnail Image</label>
                        <input type="file" name="thumbnail_file" id="f_thumbnail_file" class="f-input" accept="image/*">
                        <div class="f-hint" id="f_thumb_current"></div>
                    </div>
                </div>
                <div class="f-row">
                    <label class="f-lbl" for="f_emoji">Fallback Icon (optional)</label>
                    <input type="text" name="emoji" id="f_emoji" class="f-input" maxlength="10">
                    <div class="f-hint">Stored with the component. The admin catalog shows a category icon when no thumbnail exists.</div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="closeForm()">Cancel</button>
                <button type="submit" class="btn-save" id="formSaveBtn">Save Component</button>
            </div>
        </form>
    </div>
</div>

<!-- CONFIRM MODAL (used for Move to Trash and Delete Forever) -->
<div class="modal-backdrop" id="confirmBackdrop" onclick="closeConfirm()"></div>
<div class="modal-wrap" id="confirmWrap" role="alertdialog" aria-modal="true" aria-labelledby="confirmTitle" onclick="if(event.target===this)closeConfirm()">
    <div class="modal-box" id="confirmBox" style="max-width:400px;" onclick="event.stopPropagation()">
        <div class="modal-head">
            <div class="modal-title" id="confirmTitle">Confirm</div>
            <button type="button" class="modal-close" onclick="closeConfirm()" aria-label="Close"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="confirm-body">
            <div class="confirm-icon" id="confirmIcon"></div>
            <div class="confirm-msg" id="confirmMsg"></div>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-cancel" onclick="closeConfirm()">Cancel</button>
            <button type="button" class="btn-danger" id="confirmBtn" onclick="document.getElementById('confirmForm').submit()">Delete</button>
        </div>
        <form id="confirmForm" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="_method" id="confirmMethod" value="DELETE">
        </form>
    </div>
</div>

<!-- TRASH MODAL -->
<div class="modal-wrap" id="trashModal" role="dialog" aria-modal="true" aria-labelledby="trashTitle" onclick="if(event.target===this)closeTrash()">
    <div class="modal-box" id="trashModalBox" style="max-width:580px;" onclick="event.stopPropagation()">
        <div class="modal-head">
            <div class="modal-title" id="trashTitle">{!! sprintf($trashSvg, 17) !!} Trash <span style="font-weight:600;color:var(--taupe);font-size:.8rem;">({{ $trashed->count() }})</span></div>
            <button type="button" class="modal-close" onclick="closeTrash()" aria-label="Close"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="modal-body">
            @forelse($trashed as $t)
            <div class="trash-row">
                <div class="trash-emoji">{!! $ico($t->category, 18) !!}</div>
                <div class="trash-info">
                    <div class="trash-name">{{ $t->name }}</div>
                    <div class="trash-meta">{{ $sections[$t->category]['label'] ?? $t->category }} · deleted {{ $t->deleted_at->diffForHumans() }}</div>
                </div>
                <div class="trash-actions">
                    <form method="POST" action="{{ route('ingredients.restore', $t->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="card-act-btn go">Restore</button>
                    </form>
                    <button type="button" class="card-act-btn stop" onclick="askForceDelete({{ $t->id }}, @js($t->name))">Delete forever</button>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-title">Trash is empty</div>
                <div class="empty-desc">Deleted components will show up here so you can restore them.</div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Hidden quick-status form -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<form id="statusForm" method="POST" style="display:none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" id="statusFormValue">
</form>
</div>{{-- /.bs --}}

@push('scripts')
<script>
const storeUrl = "{{ route('ingredients.store') }}";
const statusUrlTemplate = "{{ route('ingredients.status', ['ingredient' => '__ID__']) }}";
const updateUrlTemplate = "{{ route('ingredients.update', ['ingredient' => '__ID__']) }}";
const deleteUrlTemplate = "{{ route('ingredients.destroy', ['ingredient' => '__ID__']) }}";
const forceUrlTemplate  = "{{ route('ingredients.force-delete', ['id' => '__ID__']) }}";

const confirmIcons = {
    trash: '{!! sprintf($trashSvg, 24) !!}',
    warn:  '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
};

function askConfirm(o){
    document.getElementById('confirmTitle').textContent = o.title;
    document.getElementById('confirmMsg').textContent   = o.message;
    document.getElementById('confirmIcon').innerHTML    = confirmIcons[o.icon] || confirmIcons.trash;
    document.getElementById('confirmBtn').textContent   = o.label;
    document.getElementById('confirmMethod').value      = o.method || 'DELETE';
    document.getElementById('confirmForm').action       = o.action;
    document.getElementById('confirmBackdrop').classList.add('show');
    document.getElementById('confirmWrap').classList.add('show');
    document.getElementById('confirmBox').classList.add('show');
}
function closeConfirm(){
    document.getElementById('confirmBackdrop').classList.remove('show');
    document.getElementById('confirmWrap').classList.remove('show');
    document.getElementById('confirmBox').classList.remove('show');
}
function askDelete(id, name){
    askConfirm({
        title: 'Move to Trash?',
        message: '"' + name + '" will be removed from the cake builder. You can restore it later from Trash.',
        label: 'Move to Trash',
        action: deleteUrlTemplate.replace('__ID__', id),
        icon: 'trash'
    });
}
function askForceDelete(id, name){
    askConfirm({
        title: 'Delete permanently?',
        message: '"' + name + '" will be deleted forever. This cannot be undone.',
        label: 'Delete Forever',
        action: forceUrlTemplate.replace('__ID__', id),
        icon: 'warn'
    });
}
function openTrash(){
    document.getElementById('modalBackdrop').classList.add('show');
    document.getElementById('trashModal').classList.add('show');
    document.getElementById('trashModalBox').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeTrash(){
    document.getElementById('modalBackdrop').classList.remove('show');
    document.getElementById('trashModal').classList.remove('show');
    document.getElementById('trashModalBox').classList.remove('show');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    if (document.getElementById('confirmWrap').classList.contains('show')) closeConfirm();
    else closeTrash();
});

function deleteComponent(id, name){
    if (!confirm('Delete "' + name + '"? This cannot be undone.')) return;
    const f = document.getElementById('deleteForm');
    f.action = deleteUrlTemplate.replace('__ID__', id);
    f.submit();
}

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
    document.getElementById('methodSlot')?.remove();
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
</script>
@endpush

@endsection