@extends('layouts.baker')
@section('title', 'My Profile')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* Baker Profile: same cake-atelier ledger language as the rest of the portal. Plus Jakarta Sans only.
   Legacy variable names are aliased inside .profile-page so the included payment-methods partial keeps working. */
.profile-page{
--esp:#24150F;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;--sage-d:#33502F;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
--brown-deep:#24150F;--brown-mid:#7A5E4C;--caramel-light:#D4B06A;--warm-white:#FBF8F2;--border:#D8C8B7;
--text-dark:#24150F;--text-mid:#7A5E4C;--text-muted:#9A897A;--err:#54252C;--success:#5E7F5A;
max-width:1500px;width:100%;margin:0 auto;padding-bottom:3rem;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.profile-page *{box-sizing:border-box;font-family:inherit}
.profile-page svg{flex-shrink:0}
.profile-page a:focus-visible,.profile-page button:focus-visible,.profile-page input:focus-visible,.profile-page select:focus-visible,.profile-page textarea:focus-visible{outline:2px solid var(--gold);outline-offset:2px}
@keyframes pf-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@media(prefers-reduced-motion:reduce){.profile-page *,.profile-page *::before,.profile-page *::after{animation:none!important;transition:none!important}}

.pf-label{font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}

/* ── HEADER ── */
.pf-header{display:flex;align-items:center;gap:1.75rem;flex-wrap:wrap;padding-bottom:1.75rem;animation:pf-fadeUp .6s var(--e) backwards}
.pf-avatar{width:104px;height:104px;flex-shrink:0;background:var(--esp);color:var(--gold-l);outline:1px solid var(--gold-line);outline-offset:4px;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:2rem;font-weight:900;letter-spacing:-.03em}
.pf-avatar img{width:100%;height:100%;object-fit:cover}
.pf-id{flex:1;min-width:220px}
.pf-name{margin:0;font-size:clamp(2.2rem,5vw,3.8rem);font-weight:900;line-height:.98;letter-spacing:-.05em}
.pf-email{margin:.7rem 0 1rem;font-size:.95rem;color:var(--mocha)}
.pf-tags{display:flex;gap:.45rem;flex-wrap:wrap}
.tag{display:inline-flex;align-items:center;gap:.4rem;padding:.3rem .6rem;border:1px solid transparent;border-left-width:2px;font-size:.56rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;white-space:nowrap}
.tag-role{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.tag-shop{background:var(--cream);color:var(--mocha);border-color:var(--beige);border-left-color:var(--taupe)}
.tag-approved{background:#EFF2E8;color:var(--sage-d);border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.tag-pending{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.tag-incomplete{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}

/* ── TABS ── */
.tab-nav{display:flex;gap:0;margin:0 0 2rem;border-bottom:1px solid var(--esp);overflow-x:auto;scrollbar-width:none;animation:pf-fadeUp .6s var(--e) .1s backwards}
.tab-nav::-webkit-scrollbar{display:none}
.tab-btn{display:inline-flex;align-items:center;gap:.5rem;padding:1rem 1.35rem;margin-bottom:-1px;background:none;border:none;border-bottom:3px solid transparent;font-size:.66rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--taupe);white-space:nowrap;cursor:pointer;transition:color .25s,border-color .25s,background .25s}
.tab-btn:hover{color:var(--esp);background:rgba(239,230,215,.5)}
.tab-btn.active{color:var(--esp);border-bottom-color:var(--gold)}
.tab-badge{display:inline-flex;align-items:center;justify-content:center;min-width:17px;height:17px;padding:0 .3rem;background:var(--burg);color:var(--ivory);font-size:.58rem;font-weight:800;letter-spacing:0}
.tab-badge.gold{background:var(--gold);color:var(--esp)}

.tab-panel{display:none}
.tab-panel.active{display:block;animation:pf-fadeUp .5s var(--e) backwards}

/* ── PANELS ── */
.section-card{background:var(--w);border:1px solid var(--beige);border-top:2px solid var(--esp);margin-bottom:1.5rem}
.section-card-header{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding:1.1rem 1.5rem;border-bottom:1px solid var(--line)}
.section-card-title{display:flex;align-items:center;gap:.75rem;font-size:1.1rem;font-weight:900;letter-spacing:-.03em;line-height:1;color:var(--esp)}
.section-card-icon{width:34px;height:34px;display:flex;align-items:center;justify-content:center;background:#F3EAD3;border:1px solid var(--gold-line);color:var(--credit)}
.section-card-body{padding:1.5rem}
.pf-meta{font-size:.74rem;font-weight:600;color:var(--taupe)}

/* ── BUTTONS ── */
.btn-save{display:inline-flex;align-items:center;gap:.6rem;padding:1.05rem 1.7rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);border-radius:0;font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;transition:background .3s,color .3s,border-color .3s}
.btn-save:hover{background:var(--gold);border-color:var(--gold);color:var(--esp)}
.pf-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.55rem .9rem;background:transparent;border:1px solid var(--esp);border-radius:0;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:background .25s,color .25s}
.pf-btn:hover{background:var(--esp);color:var(--gold-l)}
.pf-actions{display:flex;justify-content:flex-end}
.pf-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.62rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--caramel);text-decoration:none;border-bottom:1px solid var(--gold-line);padding-bottom:1px;transition:color .3s,border-color .3s}
.pf-link:hover{color:var(--esp);border-color:var(--esp);text-decoration:none}
.pf-inline-btn{background:none;border:none;padding:0;font-size:inherit;font-weight:700;color:var(--caramel);cursor:pointer;border-bottom:1px solid var(--gold-line)}

/* ── ALERTS ── */
.alert{display:flex;align-items:flex-start;gap:.7rem;padding:.95rem 1.2rem;margin-bottom:1.5rem;font-size:.88rem;line-height:1.55;border:1px solid transparent;border-left-width:2px}
.alert svg{margin-top:3px}
.alert-success{background:#EFF2E8;color:var(--sage-d);border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.alert-error{background:#F6ECEA;color:#3E1A1F;border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}

/* ── COMPLETION ── */
.completion-bar-wrap{background:var(--w);border:1px solid var(--beige);border-top:2px solid var(--esp);padding:1.4rem 1.5rem;margin-bottom:1.5rem}
.completion-bar-header{display:flex;align-items:baseline;justify-content:space-between;gap:1rem;margin-bottom:1rem}
.completion-bar-title{font-size:1.1rem;font-weight:900;letter-spacing:-.03em}
.completion-pct{font-size:1.8rem;font-weight:900;letter-spacing:-.04em;color:var(--credit);font-variant-numeric:tabular-nums}
.completion-track{height:6px;background:var(--cream);margin-bottom:1.1rem;overflow:hidden}
.completion-fill{height:100%;background:var(--gold);transition:width .6s var(--e)}
.completion-chips{display:flex;flex-wrap:wrap;gap:.4rem}
.completion-chip{display:inline-flex;align-items:center;gap:.4rem;padding:.3rem .6rem;border:1px solid transparent;border-left-width:2px;font-size:.6rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
.chip-ok{background:#EFF2E8;color:var(--sage-d);border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.chip-missing{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}

/* ── OVERVIEW BLOCKS ── */
.pf-banner{display:flex;align-items:center;gap:1.25rem;padding:1.5rem;border-bottom:1px solid var(--line);background:rgba(239,230,215,.45)}
.pf-avatar-sm{width:56px;height:56px;background:var(--esp);color:var(--gold-l);display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:1.2rem;font-weight:900;flex-shrink:0}
.pf-avatar-sm img{width:100%;height:100%;object-fit:cover}
.pf-banner-name{font-size:1.15rem;font-weight:900;letter-spacing:-.03em}
.pf-banner-sub{margin-top:.15rem;font-size:.82rem;color:var(--mocha)}
.pf-banner .tag{margin-top:.55rem}
.pf-details{display:grid;grid-template-columns:1fr 1fr}
.pf-detail{padding:1.1rem 1.5rem;border-bottom:1px solid var(--line)}
.pf-detail:nth-child(even){border-left:1px solid var(--line)}
.pf-detail:nth-last-child(-n+2){border-bottom:0}
.pf-detail .pf-label{display:flex;align-items:center;gap:.4rem;margin-bottom:.4rem}
.pf-detail-val{font-size:.92rem;font-weight:700}
.pf-empty{font-size:.85rem;font-style:italic;font-weight:400;color:var(--taupe)}
.pf-shop{display:flex;align-items:center;gap:.9rem;padding:1.25rem 1.5rem;border-bottom:1px solid var(--line);background:rgba(239,230,215,.45)}
.pf-shop svg{color:var(--gold)}
.pf-shop-name{font-size:1.1rem;font-weight:900;letter-spacing:-.03em}
.pf-shop-bio{margin-top:.25rem;max-width:64ch;font-size:.84rem;line-height:1.6;color:var(--mocha)}
.pf-stats{display:grid;grid-template-columns:repeat(3,1fr);border-bottom:1px solid var(--line)}
.pf-stat{padding:1.2rem 1.25rem;text-align:center}
.pf-stat + .pf-stat{border-left:1px solid var(--line)}
.pf-stat svg{color:var(--gold);margin:0 auto .5rem;display:block}
.pf-stat-val{margin-top:.45rem;font-size:1rem;font-weight:900;letter-spacing:-.03em}
.pf-specs{padding:1.25rem 1.5rem}
.pf-specs .pf-label{display:flex;align-items:center;gap:.45rem;margin-bottom:.8rem}
.pf-chips{display:flex;flex-wrap:wrap;gap:.4rem}
.pf-chip{padding:.3rem .7rem;background:var(--cream);border:1px solid var(--beige);font-size:.72rem;font-weight:700;color:var(--mocha)}

/* ── INFO ROWS (documents) ── */
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.info-item{padding:1rem 1.1rem;border:1px solid var(--line);background:var(--ivory)}
.info-label{display:flex;align-items:center;gap:.4rem;margin-bottom:.5rem;font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}
.info-value{font-size:.92rem;font-weight:600;line-height:1.5;color:var(--esp)}
.info-empty{font-size:.85rem;font-style:italic;font-weight:400;color:var(--taupe)}
.doc-grid{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}

/* ── FORMS ── */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.form-group{margin-bottom:1.15rem}
.form-label{display:block;margin-bottom:.5rem;font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}
.form-label .req{color:var(--caramel)}
.form-label .hint{margin-left:.4rem;font-size:.6rem;font-weight:600;letter-spacing:.04em;text-transform:none;color:var(--taupe)}
.form-input{width:100%;padding:.8rem .95rem;background:var(--ivory);border:1px solid var(--beige);border-radius:0;font-size:.9rem;font-weight:500;color:var(--esp);transition:border-color .25s,background .25s}
.form-input::placeholder{color:var(--taupe)}
.form-input:hover{border-color:var(--gold)}
.form-input:focus{outline:none;border-color:var(--gold);background:#fff}
textarea.form-input{resize:vertical;min-height:96px;line-height:1.6}
select.form-input{appearance:none;-webkit-appearance:none;padding-right:2.4rem;cursor:pointer;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237A5E4C' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .95rem center}
.field-error{margin-top:.4rem;font-size:.75rem;font-weight:600;color:var(--burg)}

/* ── FILE UPLOAD (kept for compatibility) ── */
.file-upload-area{position:relative;padding:1rem .75rem;text-align:center;border:1px dashed var(--beige);background:var(--ivory);cursor:pointer;transition:border-color .25s,background .25s}
.file-upload-area:hover{border-color:var(--gold);background:var(--cream)}
.file-upload-area.has-file{border-color:var(--sage);background:#EFF2E8}
.file-upload-area input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.file-name-display{display:none;margin-top:.4rem;font-size:.72rem;font-weight:700;color:var(--sage-d);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}

/* ── SPECIALTIES ── */
.specialties-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem}
.specialty-check{display:flex;align-items:center;gap:.6rem;padding:.65rem .8rem;border:1px solid var(--beige);background:var(--ivory);font-size:.82rem;font-weight:600;color:var(--mocha);cursor:pointer;user-select:none;transition:border-color .2s,background .2s,color .2s}
.specialty-check:hover{border-color:var(--gold);color:var(--esp)}
.specialty-check input{display:none}
.specialty-check.checked{border-color:var(--esp);background:var(--cream);color:var(--esp);font-weight:800}
.check-indicator{width:16px;height:16px;border:1.5px solid currentColor;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.specialty-check.checked .check-indicator{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}

/* ── MAP ── */
#profile-map{height:300px;width:100%;border:1px solid var(--beige)}
.btn-locate{display:inline-flex;align-items:center;gap:.5rem;margin-bottom:.9rem;padding:.65rem 1rem;background:transparent;border:1px solid var(--esp);border-radius:0;font-size:.62rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:background .25s,color .25s}
.btn-locate:hover{background:var(--esp);color:var(--gold-l)}
.map-coords{display:none;align-items:center;gap:.4rem;margin-bottom:.7rem;font-size:.76rem;font-weight:700;color:var(--credit);font-variant-numeric:tabular-nums}
.map-coords.visible{display:flex}
.pf-intro{margin:0 0 1rem;max-width:64ch;font-size:.88rem;line-height:1.7;color:var(--mocha)}

/* ── PORTFOLIO ── */
.portfolio-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.85rem;margin-bottom:1.25rem}
.portfolio-item{position:relative;aspect-ratio:1;overflow:hidden;border:1px solid var(--beige);background:var(--cream)}
.portfolio-item img{width:100%;height:100%;object-fit:cover;transition:opacity .2s}
.portfolio-item:hover img{opacity:.88}
.portfolio-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.5rem;background:var(--ivory);border:1px dashed var(--taupe);color:var(--taupe);cursor:pointer;transition:background .25s,border-color .25s,color .25s}
.portfolio-empty:hover{background:var(--cream);border-color:var(--gold);color:var(--esp)}
.portfolio-empty-label{font-size:.58rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase}
.portfolio-del-btn{position:absolute;top:6px;right:6px;width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:var(--burg);color:var(--ivory);border:none;border-radius:0;cursor:pointer;z-index:5;transition:background .2s}
.portfolio-del-btn:hover{background:#3E1A1F}
.portfolio-new-badge{position:absolute;bottom:6px;left:6px;padding:.22rem .5rem;background:var(--esp);color:var(--gold-l);font-size:.52rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;z-index:5}
.pf-tip{display:flex;align-items:center;gap:.6rem;margin-top:.75rem;padding:.9rem 1rem;background:var(--cream);border-left:2px solid var(--gold);font-size:.8rem;line-height:1.6;color:var(--mocha)}
.pf-tip svg{color:var(--gold)}

/* ── REVIEWS ── */
.pf-stars{display:inline-flex;gap:2px;color:var(--gold)}
.pf-rating{display:flex;gap:2.5rem;align-items:center;flex-wrap:wrap;padding-bottom:1.5rem;margin-bottom:1.25rem;border-bottom:1px solid var(--line)}
.pf-rating-num{font-size:3.4rem;font-weight:900;letter-spacing:-.05em;line-height:1;font-variant-numeric:tabular-nums}
.pf-rating-side{text-align:center;min-width:90px}
.pf-rating-side .pf-stars{margin:.6rem 0 .4rem}
.pf-bars{flex:1;min-width:200px}
.pf-bar-row{display:flex;align-items:center;gap:.7rem;margin-bottom:.45rem}
.pf-bar-row .n{width:12px;text-align:right;font-size:.74rem;font-weight:800;color:var(--mocha)}
.pf-bar-row svg{color:var(--gold)}
.pf-bar-track{flex:1;height:6px;background:var(--cream)}
.pf-bar-fill{height:100%;background:var(--gold)}
.pf-bar-row .c{width:24px;font-size:.72rem;font-weight:700;color:var(--taupe);font-variant-numeric:tabular-nums}
.pf-review{display:flex;align-items:flex-start;gap:1rem;padding:1.25rem 0;border-bottom:1px solid var(--line)}
.pf-review:last-child{border-bottom:0;padding-bottom:0}
.pf-review-avatar{width:40px;height:40px;background:var(--esp);color:var(--gold-l);display:flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:900;flex-shrink:0}
.pf-review-main{flex:1;min-width:0}
.pf-review-top{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.4rem;margin-bottom:.4rem}
.pf-review-name{font-size:.95rem;font-weight:800;letter-spacing:-.02em}
.pf-review-date{font-size:.74rem;color:var(--taupe)}
.pf-review-score{display:flex;align-items:center;gap:.6rem;margin-bottom:.6rem;font-size:.74rem;font-weight:700;color:var(--mocha)}
.pf-comment{padding:.7rem 1rem;background:var(--cream);border-left:2px solid var(--gold);font-size:.86rem;line-height:1.65;color:var(--mocha)}
.pf-nocomment{font-size:.8rem;font-style:italic;color:var(--taupe)}
.pf-emptyblock{text-align:center;padding:3.5rem 1rem}
.pf-emptyblock svg{color:var(--gold);opacity:.75;margin-bottom:1rem}
.pf-emptyblock h3{margin:0 0 .6rem;font-size:clamp(1.4rem,2.6vw,1.9rem);font-weight:900;letter-spacing:-.04em;line-height:1}
.pf-emptyblock p{margin:0 auto;max-width:44ch;font-size:.9rem;color:var(--mocha)}

/* ── AVAILABILITY TOGGLE (kept for compatibility) ── */
.toggle-switch{position:relative;width:44px;height:24px}
.toggle-switch input{opacity:0;width:0;height:0}
.toggle-slider{position:absolute;inset:0;background:var(--beige);transition:.3s;cursor:pointer}
.toggle-slider:before{content:'';position:absolute;width:18px;height:18px;background:#fff;left:3px;bottom:3px;transition:.3s}
input:checked + .toggle-slider{background:var(--sage)}
input:checked + .toggle-slider:before{transform:translateX(20px)}

@media(max-width:900px){.specialties-grid{grid-template-columns:1fr 1fr}}
@media(max-width:768px){
    .info-grid,.form-row,.doc-grid,.pf-details{grid-template-columns:1fr}
    .pf-detail:nth-child(even){border-left:0}
    .pf-detail:nth-last-child(2){border-bottom:1px solid var(--line)}
    .pf-avatar{width:84px;height:84px}
    .tab-btn{padding:.9rem 1rem}
}
@media(max-width:520px){.specialties-grid{grid-template-columns:1fr}.pf-stats{grid-template-columns:1fr}.pf-stat + .pf-stat{border-left:0;border-top:1px solid var(--line)}}
</style>
@endpush

@section('content')

@php
    $bakerRecord  = $baker->baker;
    $missingFields = \App\Http\Middleware\BakerProfileComplete::getMissingFields($baker);
    $totalRequired = 5; // shop, address, lat/lng, docs (2 fields)
    $missingCount  = count($missingFields);
    $doneCount     = max(0, $totalRequired - $missingCount);
    $pct           = round(($doneCount / $totalRequired) * 100);

    // All checkable items for the bar
    $allChecks = [
        'Bakery / Shop Name'      => !empty($bakerRecord?->shop_name),
        'Bakery Address'          => !empty($bakerRecord?->full_address) || !empty($bakerRecord?->address),
        'Map Pin Location'        => !empty($bakerRecord?->latitude) && !empty($bakerRecord?->longitude),
        'Business Documents'      => ($bakerRecord?->seller_type === 'homebased')
                                        ? (!empty($bakerRecord?->gov_id_front) && !empty($bakerRecord?->id_selfie))
                                        : (!empty($bakerRecord?->business_permit) && !empty($bakerRecord?->dti_certificate)),
        'Sanitary / Gov ID'       => ($bakerRecord?->seller_type === 'homebased')
                                        ? true
                                        : !empty($bakerRecord?->sanitary_permit),
    ];
    $totalChecks = count($allChecks);
    $doneChecks  = count(array_filter($allChecks));
    $pct         = round(($doneChecks / $totalChecks) * 100);

    $oldSpecs = old('specialties', is_array($bakerRecord?->specialties) ? $bakerRecord->specialties : []);
    $specialtyOptions = ['Wedding Cakes','Birthday Cakes','Fondant Art','Cupcakes','Macarons','Cheesecakes','Custom Designs','Vegan Cakes','Gluten-Free','Chocolate Cakes','Pastries','Tarts'];

    // ── SVG icon helper (all icons on this page are SVG) ──
    $P = [
        'user'    => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'store'   => '<path d="M3 9l1-5h16l1 5"/><path d="M4 9v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9"/><path d="M9 20v-6h6v6"/>',
        'baker'   => '<path d="M4 21v-6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6"/><path d="M2 21h20"/><path d="M12 9V5"/>',
        'file'    => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'filelines'=> '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/>',
        'clip'    => '<path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1z"/><rect x="5" y="4" width="14" height="18" rx="2"/><line x1="8" y1="11" x2="16" y2="11"/><line x1="8" y1="15" x2="16" y2="15"/>',
        'pin'     => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'star'    => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'card'    => '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
        'wallet'  => '<rect x="2" y="6" width="20" height="13" rx="2"/><path d="M2 10h20"/><circle cx="12" cy="14.5" r="2.2"/>',
        'checkc'  => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'xc'      => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>',
        'check'   => '<polyline points="20 6 9 17 4 12"/>',
        'x'       => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'clock'   => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'alert'   => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'lock'    => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'phone'   => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'cal'     => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'home'    => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
        'building'=> '<rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="7" x2="9.01" y2="7"/><line x1="15" y1="7" x2="15.01" y2="7"/><line x1="9" y1="12" x2="9.01" y2="12"/><line x1="15" y1="12" x2="15.01" y2="12"/><path d="M10 22v-4h4v4"/>',
        'link'    => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
        'edit'    => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>',
        'save'    => '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>',
        'target'  => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        'idcard'  => '<rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="12" r="2"/><line x1="14" y1="10" x2="18" y2="10"/><line x1="14" y1="14" x2="18" y2="14"/>',
        'idback'  => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="6" y1="10" x2="18" y2="10"/><line x1="6" y1="14" x2="14" y2="14"/>',
        'shield'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'camera'  => '<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>',
        'hash'    => '<line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>',
        'arrow'   => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'info'    => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
        'cake'    => '<path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/>',
    ];
    $ic = fn ($k, $s = 16, $sw = 1.8, $fill = 'none') => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="'.$s.'" height="'.$s.'" fill="'.$fill.'" stroke="currentColor" stroke-width="'.$sw.'" stroke-linecap="round" stroke-linejoin="round">'.$P[$k].'</svg>';
    $stars = function ($n) use ($ic) { $o = ''; for ($i = 1; $i <= 5; $i++) { $o .= $ic('star', 15, 1.8, $i <= $n ? 'currentColor' : 'none'); } return '<span class="pf-stars">'.$o.'</span>'; };
@endphp

<div class="profile-page">

@if(session('success'))
<div class="alert alert-success">{!! $ic('checkc') !!} <span>{{ session('success') }}</span></div>
@endif
@if($errors->any())
<div class="alert alert-error">{!! $ic('xc') !!} <span>{{ $errors->first() }}</span></div>
@endif

{{-- ── HEADER ── --}}
<div class="pf-header">
    <div class="pf-avatar">
        @if($baker->profile_photo)
            <img src="{{ Str::startsWith($baker->profile_photo, 'http') ? $baker->profile_photo : Storage::url($baker->profile_photo) }}" alt="Photo">
        @else
            {{ strtoupper(substr($baker->first_name,0,1).substr($baker->last_name,0,1)) }}
        @endif
    </div>
    <div class="pf-id">
        <h1 class="pf-name">{{ $baker->first_name }} {{ $baker->last_name }}</h1>
        <div class="pf-email">{{ $baker->email }}</div>
        <div class="pf-tags">
            <span class="tag tag-role">{!! $ic('baker', 12) !!} Baker</span>
            @if(!empty($bakerRecord?->shop_name))
            <span class="tag tag-shop">{!! $ic('store', 12) !!} {{ $bakerRecord->shop_name }}</span>
            @endif
            @if($bakerRecord?->is_approved)
                <span class="tag tag-approved">{!! $ic('checkc', 12, 2) !!} Approved</span>
            @else
                <span class="tag tag-pending">{!! $ic('clock', 12) !!} Pending Approval</span>
            @endif
            @if($missingCount > 0)
                <span class="tag tag-incomplete">{!! $ic('alert', 12) !!} {{ $missingCount }} incomplete</span>
            @endif
        </div>
    </div>
</div>

<div class="tab-nav" role="tablist">
    <button class="tab-btn active" onclick="switchTab('overview', this)">{!! $ic('user', 14, 2) !!} Overview</button>
    <button class="tab-btn" onclick="switchTab('bakery', this)">
        {!! $ic('store', 14, 2) !!} Bakery Info
        @if(empty($bakerRecord?->shop_name)) <span class="tab-badge">!</span> @endif
    </button>
    <button class="tab-btn" onclick="switchTab('documents', this)">{!! $ic('file', 14, 2) !!} Documents</button>
    <button class="tab-btn" onclick="switchTab('location', this)">
        {!! $ic('pin', 14, 2) !!} Location
        @if(empty($bakerRecord?->latitude)) <span class="tab-badge">!</span> @endif
    </button>
    <button class="tab-btn" onclick="switchTab('portfolio', this)">{!! $ic('baker', 14, 2) !!} Cake Designs</button>
    <button class="tab-btn" onclick="switchTab('reviews', this)">{!! $ic('star', 14, 2) !!} Reviews
        @if($reviews->count() > 0)
            <span class="tab-badge gold">{{ $reviews->count() }}</span>
        @endif
    </button>
    <button class="tab-btn" onclick="switchTab('payments', this)">{!! $ic('card', 14, 2) !!} Payments</button>
</div>

<div class="profile-body">

    {{-- ══ OVERVIEW TAB ══ --}}
    <div class="tab-panel active" id="tab-overview">

        {{-- Completion bar --}}
        <div class="completion-bar-wrap">
            <div class="completion-bar-header">
                <div class="completion-bar-title">Profile Completion — required to bid</div>
                <div class="completion-pct">{{ $pct }}%</div>
            </div>
            <div class="completion-track">
                <div class="completion-fill" style="width: {{ $pct }}%;"></div>
            </div>
            <div class="completion-chips">
                @foreach($allChecks as $label => $done)
                    <span class="completion-chip {{ $done ? 'chip-ok' : 'chip-missing' }}">
                        {!! $done ? $ic('check', 11, 2.75) : $ic('x', 11, 2.75) !!} {{ $label }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Personal Info --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="section-card-icon">{!! $ic('user') !!}</div>
                    Personal Information
                </div>
                <span class="pf-meta">Member since {{ $baker->created_at->format('M Y') }}</span>
            </div>
            <div class="section-card-body" style="padding:0;">

                <div class="pf-banner">
                    <div class="pf-avatar-sm">
                        @if($baker->profile_photo)
                            <img src="{{ Str::startsWith($baker->profile_photo,'http') ? $baker->profile_photo : Storage::url($baker->profile_photo) }}" alt="">
                        @else
                            {{ strtoupper(substr($baker->first_name,0,1).substr($baker->last_name,0,1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="pf-banner-name">{{ $baker->first_name }} {{ $baker->last_name }}</div>
                        <div class="pf-banner-sub">{{ $baker->email }}</div>
                        <span class="tag tag-shop">
                            @if($bakerRecord?->seller_type === 'homebased')
                                {!! $ic('home', 12) !!} Home-Based Baker
                            @else
                                {!! $ic('building', 12) !!} Registered Business
                            @endif
                        </span>
                    </div>
                </div>

                @php
                    $phone = $baker->phone ?? $bakerRecord?->phone;
                    $details = [
                        ['phone', 'Phone', $phone ?: null],
                        ['cal', 'Member Since', $baker->created_at->format('F d, Y')],
                    ];
                @endphp
                <div class="pf-details">
                    @foreach($details as [$iconKey, $lbl, $val])
                    <div class="pf-detail">
                        <div class="pf-label">{!! $ic($iconKey, 12, 2) !!} {{ $lbl }}</div>
                        <div class="pf-detail-val">
                            @if($val) {{ $val }} @else <span class="pf-empty">Not provided</span> @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Bakery Summary --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="section-card-icon">{!! $ic('baker') !!}</div>
                    Bakery Details
                </div>
                <button class="pf-btn" onclick="switchTab('bakery', document.querySelector('[onclick*=bakery]'))">
                    {!! $ic('edit', 12, 2) !!} Edit
                </button>
            </div>
            <div class="section-card-body" style="padding:0;">

                @if(!empty($bakerRecord?->shop_name))
                <div class="pf-shop">
                    {!! $ic('store', 28, 1.5) !!}
                    <div>
                        <div class="pf-shop-name">{{ $bakerRecord->shop_name }}</div>
                        @if($bakerRecord?->bio)
                        <div class="pf-shop-bio">{{ Str::limit($bakerRecord->bio, 120) }}</div>
                        @endif
                    </div>
                </div>
                @endif

                @php
                    $stats = [
                        ['clock', 'Experience', $bakerRecord?->experience_years ?? null],
                        ['wallet', 'Min. Order',  $bakerRecord?->min_order_price ? '₱'.number_format($bakerRecord->min_order_price,0) : null],
                        ['link', 'Online Shop',  $bakerRecord?->social_media ? 'Linked' : null],
                    ];
                @endphp
                <div class="pf-stats">
                    @foreach($stats as [$iconKey, $lbl, $val])
                    <div class="pf-stat">
                        {!! $ic($iconKey, 20, 1.7) !!}
                        <div class="pf-label">{{ $lbl }}</div>
                        @if($val)
                            @if($lbl === 'Online Shop' && $bakerRecord?->social_media)
                                <div class="pf-stat-val"><a href="{{ $bakerRecord->social_media }}" target="_blank" class="pf-link">View {!! $ic('arrow', 12, 2.5) !!}</a></div>
                            @else
                                <div class="pf-stat-val">{{ $val }}</div>
                            @endif
                        @else
                            <div class="pf-empty" style="margin-top:.45rem;">Not set</div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="pf-specs">
                    <div class="pf-label">{!! $ic('baker', 12, 1.8) !!} Specialties</div>
                    @if(!empty($bakerRecord?->specialties))
                        <div class="pf-chips">
                            @foreach((array)$bakerRecord->specialties as $s)
                                <span class="pf-chip">{{ $s }}</span>
                            @endforeach
                        </div>
                    @else
                        <span class="pf-empty">No specialties added yet — <button class="pf-inline-btn" onclick="switchTab('bakery',document.querySelector('[onclick*=bakery]'))">add some</button></span>
                    @endif
                </div>

            </div>
        </div>

    </div>{{-- end overview --}}

    {{-- ══ BAKERY INFO TAB ══ --}}
    <div class="tab-panel" id="tab-bakery">
        <form method="POST" action="{{ route('baker.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="_tab" value="bakery">

            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-title"><div class="section-card-icon">{!! $ic('baker') !!}</div> Bakery Information</div>
                </div>
                <div class="section-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-input" value="{{ old('first_name', $baker->first_name) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-input" value="{{ old('last_name', $baker->last_name) }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone', $baker->phone ?? $bakerRecord?->phone) }}" placeholder="09XXXXXXXXXX" maxlength="12" inputmode="numeric">
                            <div class="field-error" id="phone_err" style="display:none;"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Shop / Brand Name <span class="req">*</span></label>
                            <input type="text" name="shop_name" class="form-input" value="{{ old('shop_name', $bakerRecord?->shop_name) }}" placeholder="Sweet Dreams Bakery" required>
                            @error('shop_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Years of Experience</label>
                            <select name="experience_years" class="form-input">
                                <option value="">Select...</option>
                                @foreach(['less_than_1'=>'Less than 1 year','1-2'=>'1–2 years','3-5'=>'3–5 years','5-10'=>'5–10 years','10+'=>'10+ years'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('experience_years', $bakerRecord?->experience_years) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Min. Order Price (₱)</label>
                            <input type="number" name="min_order_price" class="form-input" min="0" value="{{ old('min_order_price', $bakerRecord?->min_order_price) }}" placeholder="500">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Social Media / Online Shop <span class="hint">(optional)</span></label>
                        <input type="url" name="social_media" class="form-input" value="{{ old('social_media', $bakerRecord?->social_media) }}" placeholder="https://facebook.com/yourbakery">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Bio <span class="hint">(optional)</span></label>
                        <textarea name="bio" class="form-input" placeholder="Tell customers about your baking style…">{{ old('bio', $bakerRecord?->bio) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Specialties</label>
                        <div class="specialties-grid">
                            @foreach($specialtyOptions as $spec)
                            <label class="specialty-check {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}">
                                <input type="checkbox" name="specialties[]" value="{{ $spec }}" {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}>
                                <span class="check-indicator">@if(in_array($spec, $oldSpecs)){!! $ic('check', 11, 3.5) !!}@endif</span>
                                {{ $spec }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="pf-actions">
                <button type="submit" class="btn-save">{!! $ic('save', 15, 2) !!} Save Bakery Info</button>
            </div>
        </form>
    </div>

    {{-- ══ DOCUMENTS TAB ══ --}}
    <div class="tab-panel" id="tab-documents">
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="section-card-icon">{!! $ic('clip') !!}</div>
                    Submitted Documents
                </div>
                <span class="tag tag-pending">{!! $ic('lock', 11, 2) !!} Read-only — contact admin to update</span>
            </div>
            <div class="section-card-body">
                @if(($bakerRecord?->seller_type ?? 'registered') === 'registered')
                    <div class="doc-grid">
                        @foreach([
                            ['DTI/SEC Number',    $bakerRecord?->dti_sec_number,  'hash',      false],
                            ['Business Permit',   $bakerRecord?->business_permit, 'file',      true],
                            ['DTI Certificate',   $bakerRecord?->dti_certificate, 'clip',      true],
                            ['Sanitary Permit',   $bakerRecord?->sanitary_permit, 'shield',    true],
                            ['BIR Certificate',   $bakerRecord?->bir_certificate, 'filelines', true],
                        ] as [$label, $value, $iconKey, $isFile])
                        <div class="info-item">
                            <div class="info-label">{!! $ic($iconKey, 12, 2) !!} {{ $label }}</div>
                            <div class="info-value">
                                @if($value)
                                    @if($isFile)
                                        <a href="{{ Storage::url($value) }}" target="_blank" class="pf-link">{!! $ic('check', 12, 2.5) !!} View File</a>
                                    @else
                                        {{ $value }}
                                    @endif
                                @else
                                    <span class="info-empty">Not submitted</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="doc-grid">
                        @foreach([
                            ['ID Type',         $bakerRecord?->gov_id_type,  'idcard', false],
                            ['Gov\'t ID Front',  $bakerRecord?->gov_id_front, 'idcard', true],
                            ['Gov\'t ID Back',   $bakerRecord?->gov_id_back,  'idback', true],
                            ['Selfie with ID',   $bakerRecord?->id_selfie,    'camera', true],
                            ['Food Safety Cert', $bakerRecord?->food_safety_cert, 'shield', true],
                        ] as [$label, $value, $iconKey, $isFile])
                        <div class="info-item">
                            <div class="info-label">{!! $ic($iconKey, 12, 2) !!} {{ $label }}</div>
                            <div class="info-value">
                                @if($value)
                                    @if($isFile)
                                        <a href="{{ Storage::url($value) }}" target="_blank" class="pf-link">{!! $ic('check', 12, 2.5) !!} View File</a>
                                    @else
                                        {{ $value }}
                                    @endif
                                @else
                                    <span class="info-empty">Not submitted</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ LOCATION TAB ══ --}}
    <div class="tab-panel" id="tab-location">
        <form method="POST" action="{{ route('baker.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="_tab" value="location">

            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-title"><div class="section-card-icon">{!! $ic('pin') !!}</div> Bakery Location</div>
                </div>
                <div class="section-card-body">
                    <p class="pf-intro">Pin your exact bakery location on the map so customers can see how far you are when reviewing your bids.</p>

                    <button type="button" class="btn-locate" onclick="locateMe()">{!! $ic('target', 14, 2) !!} Use My Current Location</button>
                    <div class="map-coords" id="map-coords">{!! $ic('pin', 13, 2) !!} Pinned: <span id="coords-display"></span></div>

                    <div id="profile-map" style="margin-bottom:1.25rem;"></div>

                    <div class="form-group">
                        <label class="form-label">Full Address <span class="req">*</span></label>
                        <input type="text" name="full_address" id="display-address" class="form-input" value="{{ old('full_address', $bakerRecord?->full_address ?? $bakerRecord?->address) }}" placeholder="Auto-fills when you pin the map, or type manually">
                        @error('full_address') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <input type="hidden" name="latitude"  id="input-lat"  value="{{ old('latitude',  $bakerRecord?->latitude) }}">
                    <input type="hidden" name="longitude" id="input-lng"  value="{{ old('longitude', $bakerRecord?->longitude) }}">
                    <input type="hidden" name="address"   id="input-addr" value="{{ old('address',   $bakerRecord?->address) }}">
                </div>
            </div>

            <div class="pf-actions">
                <button type="submit" class="btn-save">{!! $ic('save', 15, 2) !!} Save Location</button>
            </div>
        </form>
    </div>

    {{-- ══ PORTFOLIO TAB ══ --}}
    <div class="tab-panel" id="tab-portfolio">
        <form method="POST" action="{{ route('baker.profile.update') }}" enctype="multipart/form-data" id="portfolio-form">
            @csrf @method('PUT')
            <input type="hidden" name="_tab" value="portfolio">

            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-title"><div class="section-card-icon">{!! $ic('baker') !!}</div> Cake Designs</div>
                    <span class="pf-meta" id="portfolio-count-label"></span>
                </div>
                <div class="section-card-body">
                    @php
                        $portfolio = [];
                        if ($bakerRecord?->portfolio) {
                            $portfolio = is_array($bakerRecord->portfolio)
                                ? $bakerRecord->portfolio
                                : (json_decode($bakerRecord->portfolio, true) ?? []);
                        }
                        $maxPhotos = 5;
                    @endphp

                    <p class="pf-intro">
                        Click an empty slot to add a photo. Use the <strong>remove</strong> button on any photo to delete it. You can have up to <strong>5</strong> designs.
                    </p>

                    {{-- Dynamic grid managed by JS --}}
                    <div class="portfolio-grid" id="portfolio-grid"></div>

                    {{-- Hidden: tracks which existing photos to delete --}}
                    <div id="remove-inputs-container"></div>

                    {{-- Hidden: new file inputs appended by JS --}}
                    <div id="new-file-inputs-container" style="display:none;"></div>

                    <div class="pf-tip">
                        {!! $ic('info', 16, 2) !!} <span>JPG or PNG · Max 5MB each · Slots auto-shift when a photo is removed.</span>
                    </div>
                </div>
            </div>

            <div class="pf-actions">
                <button type="button" class="btn-save" onclick="submitPortfolioForm()">{!! $ic('save', 15, 2) !!} Save Cake Designs</button>
            </div>
        </form>

        {{-- Seed existing portfolio data into JS --}}
        <script>
            window._existingPortfolio = @json($portfolio);
            window._portfolioMax = {{ $maxPhotos }};
            window._storageBase = "{{ Storage::url('') }}";
        </script>
    </div>

    {{-- ══ REVIEWS TAB ══ --}}
    <div class="tab-panel" id="tab-reviews">

        @php
            $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
            $ratingCounts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
            foreach($reviews as $r) { $ratingCounts[(int)$r->rating] = ($ratingCounts[(int)$r->rating] ?? 0) + 1; }
        @endphp

        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="section-card-icon">{!! $ic('star', 16, 1.8, 'currentColor') !!}</div>
                    Customer Reviews
                </div>
                <span class="pf-meta">{{ $reviews->count() }} total review{{ $reviews->count() !== 1 ? 's' : '' }}</span>
            </div>
            <div class="section-card-body">

                @if($reviews->count() === 0)
                    <div class="pf-emptyblock">
                        {!! $ic('cake', 44, 1.3) !!}
                        <h3>No reviews yet</h3>
                        <p>Reviews will appear here once customers complete their orders.</p>
                    </div>
                @else

                    <div class="pf-rating">
                        <div class="pf-rating-side">
                            <div class="pf-rating-num">{{ $avgRating }}</div>
                            {!! $stars(round($avgRating)) !!}
                            <div class="pf-label">out of 5</div>
                        </div>
                        <div class="pf-bars">
                            @foreach([5,4,3,2,1] as $star)
                            @php $count = $ratingCounts[$star]; $barPct = $reviews->count() > 0 ? round(($count/$reviews->count())*100) : 0; @endphp
                            <div class="pf-bar-row">
                                <span class="n">{{ $star }}</span>
                                {!! $ic('star', 12, 1.8, 'currentColor') !!}
                                <div class="pf-bar-track"><div class="pf-bar-fill" style="width:{{ $barPct }}%;"></div></div>
                                <span class="c">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @foreach($reviews as $review)
                    <div class="pf-review">
                        <div class="pf-review-avatar">{{ strtoupper(substr($review->customer?->first_name ?? 'C', 0, 1)) }}</div>
                        <div class="pf-review-main">
                            <div class="pf-review-top">
                                <span class="pf-review-name">
                                    {{ $review->customer ? $review->customer->first_name . ' ' . substr($review->customer->last_name,0,1) . '.' : 'Customer' }}
                                </span>
                                <span class="pf-review-date">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="pf-review-score">
                                {!! $stars((int) $review->rating) !!}
                                <span>{{ $review->rating }}/5</span>
                            </div>
                            @if($review->comment)
                            <div class="pf-comment">"{{ $review->comment }}"</div>
                            @else
                            <div class="pf-nocomment">No written comment.</div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                @endif
            </div>
        </div>
    </div>

    {{-- ══ PAYMENTS TAB ══ --}}
    <div class="tab-panel" id="tab-payments">
        @include('baker.payment-methods.index')
    </div>

</div>{{-- /.profile-body --}}
</div>{{-- /.profile-page --}}

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ── SVG glyphs used by script-rendered UI ──
const SVG_CHECK  = '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
const SVG_X      = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
const SVG_CAMERA = '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>';

// ── TAB SWITCHING ──
function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    if (btn) btn.classList.add('active');

    if (name === 'location'  && !window._mapInitialized) initMap();
    if (name === 'portfolio' && window._portfolioRender)  window._portfolioRender();
}

// Boot portfolio grid on first load
document.addEventListener('DOMContentLoaded', function () {
    if (window._portfolioRender) window._portfolioRender();
});

// ── SPECIALTIES ──
document.querySelectorAll('.specialty-check').forEach(label => {
    label.addEventListener('click', function () {
        const input = this.querySelector('input'), ind = this.querySelector('.check-indicator');
        setTimeout(() => { this.classList.toggle('checked', input.checked); ind.innerHTML = input.checked ? SVG_CHECK : ''; }, 0);
    });
});
// ── FILE UPLOAD ──
function handleFile(input, areaId, nameId) {
    const area = document.getElementById(areaId), nameEl = document.getElementById(nameId);
    if (input.files && input.files[0]) { area.classList.add('has-file'); nameEl.style.display = 'block'; nameEl.textContent = input.files[0].name; }
}
// ── PORTFOLIO MANAGER ──
window._portfolioRender = (function () {
    let existing    = [];
    let newSlots    = {};
    let removedPaths = [];   // ← persistent removal tracker
    let MAX         = 5;
    let booted      = false;

    function boot() {
        existing = (window._existingPortfolio || []).slice();
        MAX      = window._portfolioMax || 5;
        booted   = true;
    }

    function totalCount() { return existing.length + Object.keys(newSlots).length; }
    function emptySlots()  { return MAX - totalCount(); }

    function render() {
        if (!booted) boot();
        const grid   = document.getElementById('portfolio-grid');
        const label  = document.getElementById('portfolio-count-label');
        const nwCont = document.getElementById('new-file-inputs-container');
        if (!grid) return;

        grid.innerHTML  = '';
        nwCont.innerHTML = '';
        // NOTE: do NOT clear rmCont here — we rebuild it from removedPaths array instead
        const rmCont = document.getElementById('remove-inputs-container');
        rmCont.innerHTML = '';
        removedPaths.forEach(function (path) {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'remove_photos[]'; inp.value = path;
            rmCont.appendChild(inp);
        });

        label.textContent = totalCount() + ' / ' + MAX + ' photos';

        // Existing saved photos
        existing.forEach(function (path, i) {
            const div = document.createElement('div');
            div.className = 'portfolio-item';
            div.innerHTML = '<img src="' + window._storageBase + path + '" alt="Design">'
                          + '<button type="button" class="portfolio-del-btn" title="Remove" aria-label="Remove photo">' + SVG_X + '</button>';
            div.querySelector('.portfolio-del-btn').addEventListener('click', function () {
                removedPaths.push(path);   // ← add to persistent tracker
                existing.splice(i, 1);
                render();
            });
            grid.appendChild(div);
        });

        // New pending photos
        Object.keys(newSlots).forEach(function (key) {
            const slot = newSlots[key];
            const div  = document.createElement('div');
            div.className = 'portfolio-item';
            div.innerHTML = '<img src="' + slot.previewURL + '" alt="New">'
                          + '<span class="portfolio-new-badge">New</span>'
                          + '<button type="button" class="portfolio-del-btn" title="Remove" aria-label="Remove photo">' + SVG_X + '</button>';
            div.querySelector('.portfolio-del-btn').addEventListener('click', function () {
                URL.revokeObjectURL(slot.previewURL);
                delete newSlots[key];
                render();
            });
            grid.appendChild(div);

            const inp = document.createElement('input');
            inp.type = 'file'; inp.name = 'new_photos[]'; inp.style.display = 'none';
            nwCont.appendChild(inp);
            try {
                const dt = new DataTransfer();
                dt.items.add(slot.file);
                inp.files = dt.files;
            } catch(e) {
                inp._file = slot.file;
            }
        });

        // Empty add-photo slots
        for (let e = 0; e < emptySlots(); e++) {
            const slotKey = 'slot_' + Date.now() + '_' + e;
            const div = document.createElement('div');
            div.className = 'portfolio-item portfolio-empty';
            div.style.position = 'relative';
            div.innerHTML = '<input type="file" accept=".jpg,.jpeg,.png"'
                          + ' style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;z-index:3;">'
                          + SVG_CAMERA
                          + '<span class="portfolio-empty-label">Add Photo</span>';
            div.querySelector('input[type=file]').addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                if (file.size > 5 * 1024 * 1024) { alert('Max 5MB per photo.'); return; }
                if (totalCount() >= MAX) { alert('Maximum ' + MAX + ' photos reached.'); return; }
                newSlots[slotKey] = { file: file, previewURL: URL.createObjectURL(file) };
                render();
            });
            grid.appendChild(div);
        }
    }

    return render;
})();

// ── PORTFOLIO FORM SUBMIT via FormData ──
function submitPortfolioForm() {
    const form = document.getElementById('portfolio-form');
    const fd   = new FormData();

    fd.append('_token', document.querySelector('input[name="_token"]').value);
    fd.append('_method', 'PUT');
    fd.append('_tab', 'portfolio');

    // Remove inputs — now reliably populated from persistent array
    document.querySelectorAll('#remove-inputs-container input').forEach(inp => {
        fd.append('remove_photos[]', inp.value);
    });

    // New file inputs
    document.querySelectorAll('#new-file-inputs-container input[type=file]').forEach(inp => {
        const file = (inp.files && inp.files[0]) ? inp.files[0] : inp._file;
        if (file) fd.append('new_photos[]', file);
    });

    fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }, redirect: 'follow' })
        .then(() => {
            window.location.href = '{{ route("baker.profile.index") }}?tab=portfolio';
        })
        .catch(() => { form.submit(); });
}

// ── PHONE ──
const phoneInput = document.getElementById('phone');
if (phoneInput) {
    const phoneErr = document.getElementById('phone_err');
    phoneInput.addEventListener('input', function () { this.value = this.value.replace(/\D/g,'').slice(0,12); });
    phoneInput.addEventListener('blur', function () {
        if (this.value.length > 0 && this.value.length !== 12) { phoneErr.textContent = 'Must be exactly 12 digits.'; phoneErr.style.display = 'block'; }
        else { phoneErr.style.display = 'none'; }
    });
}

// ── MAP ──
window._mapInitialized = false;
let _map, _marker;
const _brownIcon = null;
const _pinHtml = '<div style="width:26px;height:26px;background:#24150F;border:3px solid #D4B06A;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.3);"></div>';

function initMap() {
    window._mapInitialized = true;
    const lat = parseFloat(document.getElementById('input-lat').value) || 14.5995;
    const lng = parseFloat(document.getElementById('input-lng').value) || 120.9842;
    const zoom = document.getElementById('input-lat').value ? 15 : 13;

    _map = L.map('profile-map').setView([lat, lng], zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap', maxZoom: 19 }).addTo(_map);

    const icon = L.divIcon({ html: _pinHtml, iconSize:[26,26], iconAnchor:[13,26], className:'' });

    if (document.getElementById('input-lat').value) {
        _marker = L.marker([lat, lng], { icon, draggable: true }).addTo(_map);
        _marker.on('dragend', () => { const p = _marker.getLatLng(); updateCoords(p.lat, p.lng); reverseGeocode(p.lat, p.lng); });
        showCoords(lat, lng);
    }

    _map.on('click', e => {
        if (_marker) _marker.setLatLng([e.latlng.lat, e.latlng.lng]);
        else { _marker = L.marker([e.latlng.lat, e.latlng.lng], { icon, draggable: true }).addTo(_map); _marker.on('dragend', () => { const p = _marker.getLatLng(); updateCoords(p.lat, p.lng); reverseGeocode(p.lat, p.lng); }); }
        updateCoords(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

function updateCoords(lat, lng) {
    document.getElementById('input-lat').value = lat.toFixed(7);
    document.getElementById('input-lng').value = lng.toFixed(7);
    showCoords(lat, lng);
}
function showCoords(lat, lng) {
    const el = document.getElementById('map-coords');
    el.classList.add('visible');
    document.getElementById('coords-display').textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
}
function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(r => r.json())
        .then(d => { if (d?.display_name) { document.getElementById('display-address').value = d.display_name; document.getElementById('input-addr').value = d.display_name; } })
        .catch(() => {});
}
function locateMe() {
    if (!navigator.geolocation) { alert('Geolocation not supported.'); return; }
    navigator.geolocation.getCurrentPosition(p => {
        if (!window._mapInitialized) initMap();
        _map.setView([p.coords.latitude, p.coords.longitude], 16);
        if (_marker) _marker.setLatLng([p.coords.latitude, p.coords.longitude]);
        else { const icon = L.divIcon({ html: _pinHtml, iconSize:[26,26], iconAnchor:[13,26], className:'' }); _marker = L.marker([p.coords.latitude, p.coords.longitude], { icon, draggable:true }).addTo(_map); }
        updateCoords(p.coords.latitude, p.coords.longitude);
        reverseGeocode(p.coords.latitude, p.coords.longitude);
    }, () => alert('Could not get your location.'));
}

// Open to the right tab if redirected with ?tab=
const urlTab = new URLSearchParams(window.location.search).get('tab');
if (urlTab) { const btn = document.querySelector(`[onclick*="${urlTab}"]`); if (btn) switchTab(urlTab, btn); }

// If incomplete_profile flash, open to first missing tab
@if(session('incomplete_profile'))
    @if(empty($bakerRecord?->shop_name))
        switchTab('bakery', document.querySelector('[onclick*="bakery"]'));
    @elseif(empty($bakerRecord?->latitude))
        switchTab('location', document.querySelector('[onclick*="location"]'));
    @else
        switchTab('documents', document.querySelector('[onclick*="documents"]'));
    @endif
@endif
</script>
@endpush