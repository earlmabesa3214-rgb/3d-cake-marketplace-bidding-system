@extends('layouts.customer')
@section('title', 'Request This Cake')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
/* Request This Cake: luxury cake-atelier brief. Plus Jakarta Sans only. */
.rq-page{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
/* aliases used by the time-slot script */
--border:#D8C8B7;--text-dark:#24150F;--text-muted:#9A897A;--red:#54252C;
max-width:1500px;width:100%;margin:1vh auto 4vh;padding:0 clamp(.85rem,2.5vw,2rem) 2rem;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif;overflow-x:hidden}
.rq-page *,.rq-page *::before,.rq-page *::after{box-sizing:border-box;font-family:inherit}
.rq-page a:focus-visible,.rq-page button:focus-visible,.rq-page input:focus-visible,.rq-page textarea:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes rq-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes rq-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes spin{to{transform:rotate(360deg)}}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important}}

/* header */
.rq-page .page-heading{position:relative;margin:0 0 2.25rem;padding-bottom:1.75rem;animation:rq-fadeUp .6s var(--e) backwards}
.page-heading::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.page-heading::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:rq-line .9s var(--e) .3s backwards}
.page-heading h1{font-size:clamp(2rem,5vw,3.8rem);font-weight:900;line-height:.98;letter-spacing:-.05em;margin:0}
.page-heading p{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* layout */
.request-layout{display:grid;grid-template-columns:minmax(0,1fr) 410px;gap:3rem;align-items:start}
.request-layout>div{min-width:0}
@media(max-width:1000px){.request-layout{grid-template-columns:1fr;gap:2.5rem}.sidebar-col{order:-1}.submit-card{position:static!important}}

/* sections (was cards) */
.rq-page .card{background:transparent;border:0;border-top:1px solid var(--esp);margin-bottom:3rem;animation:rq-fadeUp .6s var(--e) backwards}
.request-layout>div:first-child>.card:nth-of-type(1){animation-delay:.15s}
.request-layout>div:first-child>.card:nth-of-type(2){animation-delay:.3s}
.rq-page .card:last-child{margin-bottom:0}
.card-header{display:flex;align-items:center;gap:.6rem;padding:1.25rem 0 1rem;border-bottom:1px solid var(--line)}
.card-header h3{font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;margin:0}

/* design spec */
.config-chips-row{display:flex;flex-wrap:wrap;gap:.5rem;padding:1.4rem 0 1.2rem;border-bottom:1px solid var(--line)}
.chip{display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .8rem;background:var(--w);color:var(--esp);border:1px solid var(--beige);border-left:2px solid var(--gold);font-size:.74rem;font-weight:800;letter-spacing:.02em}
.chip-key{font-size:.56rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe);padding-right:.45rem;border-right:1px solid var(--beige)}
.config-details{display:grid;grid-template-columns:repeat(4,1fr);border-bottom:1px solid var(--line)}
.config-item{padding:1.1rem 1rem 1.1rem 0}
.config-item+.config-item{padding-left:1.25rem;border-left:1px solid var(--line)}
.config-label{font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);margin-bottom:.4rem}
.config-value{font-size:.95rem;font-weight:800;letter-spacing:-.01em}
@media(max-width:600px){.config-details{grid-template-columns:1fr 1fr}.config-item:nth-child(3){padding-left:0;border-left:0}}
.spec-group{padding:1.3rem 0 .5rem;border-bottom:1px solid var(--line)}
.spec-group:last-child{border-bottom:0}
.spec-group-title{font-size:.58rem;font-weight:800;letter-spacing:.26em;text-transform:uppercase;color:var(--caramel);margin-bottom:.4rem}
.spec-row{display:flex;justify-content:space-between;gap:1.25rem;padding:.65rem 0;border-top:1px solid var(--line);font-size:.86rem}
.spec-row:first-of-type{border-top:0}
.spec-row-label{color:var(--mocha);font-weight:600;flex-shrink:0}
.spec-row-value{font-weight:800;text-align:right;line-height:1.45}
.addon-pills{display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.25rem}
.addon-pill{padding:.28rem .6rem;background:#F3EAD3;color:#7A5A15;border:1px solid var(--gold-line);border-left:2px solid var(--gold);font-size:.66rem;font-weight:800;letter-spacing:.06em}
.rq-page .form-section.addons-block{padding:1rem 0;border-bottom:1px solid var(--line)}

.price-banner{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:1.6rem 1.75rem;color:var(--ivory);position:relative;
background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),radial-gradient(ellipse 90% 70% at 100% 0,rgba(184,148,82,.22),transparent 62%),linear-gradient(160deg,#2B1A12,#24150F 60%,#1B0F09)}
.price-banner::after{content:"";position:absolute;left:1.75rem;right:1.75rem;bottom:0;height:2px;background:linear-gradient(90deg,var(--gold),transparent)}
.price-banner-label{font-size:.6rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--gold)}
.price-banner-sub{font-size:.72rem;color:var(--beige);margin-top:.3rem}
.price-banner-amount{font-size:clamp(2rem,4vw,2.8rem);font-weight:900;letter-spacing:-.05em;line-height:1;font-variant-numeric:tabular-nums}
.price-banner-amount .peso,.sum-total .amount .peso{font-size:.7em;font-weight:700;margin-right:.08em;opacity:.85;vertical-align:.08em}
.empty-state{padding:3rem 1rem;text-align:center;color:var(--mocha);font-size:.9rem}
.empty-state a{color:var(--caramel);font-weight:800;text-decoration:none}

/* form parts */
.form-section{padding:1.5rem 0;border-bottom:1px solid var(--line)}
.form-section:last-child{border-bottom:0}
.section-heading{display:flex;align-items:center;gap:.6rem;font-size:.7rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;margin-bottom:1.2rem}
.section-heading svg{color:var(--gold)}
.form-group{display:flex;flex-direction:column;gap:.45rem;margin-bottom:1.1rem}
.form-group:last-child{margin-bottom:0}
.rq-page label{font-size:.6rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--mocha)}
.form-control{width:100%;padding:.85rem 1rem;background:var(--w);border:1px solid var(--beige);border-radius:0;font-size:.9rem;font-weight:500;color:var(--esp);transition:border-color .25s,box-shadow .25s,background .25s}
.form-control::placeholder{color:var(--taupe)}
.form-control:hover{border-color:var(--taupe)}
.form-control:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.2);background:#fff}
.form-control.is-invalid{border-color:var(--burg)}
.invalid-feedback{font-size:.74rem;font-weight:700;color:var(--burg)}
textarea.form-control{resize:vertical;min-height:90px}
input[type=file].form-control{padding:.65rem .8rem;font-size:.8rem}
.hint{font-size:.72rem;color:var(--taupe);line-height:1.5}
.date-time-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
@media(max-width:520px){.date-time-grid{grid-template-columns:1fr}}

/* rush banner (script toggles display) */
.rush-banner{display:none;align-items:flex-start;gap:.9rem;margin-top:1.1rem;padding:1.1rem 1.25rem;color:var(--ivory);border-left:2px solid var(--gold);
background:radial-gradient(ellipse 90% 90% at 100% 0,rgba(184,148,82,.2),transparent 62%),linear-gradient(160deg,#2B1A12,#1B0F09)}
.rush-banner svg{flex-shrink:0;stroke:var(--gold-l)}
.rush-title{font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--gold-l)}
.rush-sub{font-size:.76rem;color:var(--beige);margin-top:.3rem;line-height:1.55}
.rush-tags{margin-top:.7rem;display:flex;gap:.45rem;flex-wrap:wrap}
.rush-tag{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .6rem;border:1px solid var(--gold-line);color:var(--gold-l);font-size:.66rem;font-weight:800;letter-spacing:.06em}

/* time picker */
#time-display{cursor:pointer;display:flex;align-items:center;justify-content:space-between;user-select:none}
#time-dropdown{display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;background:var(--w);border:1px solid var(--gold);z-index:500;box-shadow:0 14px 34px rgba(36,21,15,.18)}
#time-slots{display:grid;grid-template-columns:repeat(4,1fr);gap:3px;padding:6px;max-height:230px;overflow-y:auto}
@media(max-width:520px){#time-slots{grid-template-columns:repeat(3,1fr)}}

/* map */
.map-search-wrap{position:relative;margin-bottom:.6rem}
.map-search-icon{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);pointer-events:none;z-index:1;display:flex}
#map-search{padding-left:2.4rem}
#delivery-map{display:block;width:100%;height:280px;border:1px solid var(--beige);margin-bottom:.6rem;z-index:1}
.map-instruction{display:flex;align-items:center;gap:.5rem;padding:.65rem .9rem;margin-bottom:.6rem;background:var(--cream);border-left:2px solid var(--gold);font-size:.74rem;color:var(--mocha);line-height:1.45}
.selected-address-display{display:none;align-items:flex-start;gap:.55rem;padding:.75rem .9rem;background:#F3EAD3;border:1px solid var(--gold-line);border-left:2px solid var(--gold);font-size:.8rem;font-weight:600;color:var(--credit);line-height:1.5}
.selected-address-display.visible{display:flex}
.selected-address-display svg{stroke:var(--credit);flex-shrink:0;margin-top:.15rem}
.selected-address-display .addr-text{flex:1}
.leaflet-container{font-family:'Plus Jakarta Sans',sans-serif!important}

/* sidebar */
.submit-card{position:sticky;top:5rem;border:1px solid var(--esp);background:var(--w);animation:rq-fadeUp .6s var(--e) .25s backwards}
.submit-top{position:relative;padding:1.6rem 1.5rem 1.4rem;color:var(--ivory);
background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),radial-gradient(ellipse 90% 70% at 100% 0,rgba(184,148,82,.2),transparent 62%),linear-gradient(160deg,#2B1A12,#24150F 60%,#1B0F09)}
.submit-top::after{content:"";position:absolute;left:1.5rem;right:1.5rem;bottom:0;height:2px;background:linear-gradient(90deg,var(--gold),transparent)}
.submit-top-label{font-size:.6rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem}
.submit-top h3{font-size:1.25rem;font-weight:900;letter-spacing:-.03em;margin:0}
.submit-body{padding:1.1rem 1.5rem 1.3rem}
.sum-row{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:.6rem 0;border-bottom:1px solid var(--line);font-size:.8rem}
.sum-row:last-of-type{border-bottom:0}
.sum-row .key{font-size:.74rem;color:var(--mocha)}
.sum-row .val{font-weight:800;text-align:right;max-width:58%;font-size:.78rem}
.sum-total{display:flex;justify-content:space-between;align-items:baseline;margin-top:.6rem;padding-top:1rem;border-top:1px solid var(--esp)}
.sum-total .lbl{font-size:.6rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}
.sum-total .amount{font-size:1.9rem;font-weight:900;letter-spacing:-.05em;color:var(--credit);font-variant-numeric:tabular-nums}
.sidebar-form-section{padding:1.25rem 1.5rem;border-top:1px solid var(--line)}
.sidebar-section-heading{display:flex;align-items:center;gap:.55rem;font-size:.66rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;margin-bottom:1rem}
.sidebar-section-heading svg{color:var(--gold)}
.budget-row{display:grid;grid-template-columns:1fr 20px 1fr;gap:.5rem;align-items:end}
.budget-sep{text-align:center;color:var(--taupe);padding-bottom:.9rem}

.btn-submit{display:flex;align-items:center;justify-content:center;gap:.6rem;width:100%;padding:1.05rem;margin-top:.25rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:background .3s,color .3s,transform .3s var(--e),box-shadow .3s}
.btn-submit:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);box-shadow:0 16px 34px rgba(184,148,82,.4)}
.btn-submit:active{transform:none}
.btn-ghost{display:flex;align-items:center;justify-content:center;gap:.4rem;width:100%;padding:.85rem;margin-top:.6rem;background:transparent;color:var(--mocha);border:1px solid var(--beige);font-size:.66rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;cursor:pointer;transition:.3s}
.btn-ghost:hover{border-color:var(--esp);color:var(--esp);text-decoration:none}

/* submit modal */
.submit-modal-backdrop{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(27,15,9,.62);backdrop-filter:blur(4px);opacity:0;pointer-events:none;transition:opacity .25s ease}
.submit-modal-backdrop.is-open{opacity:1;pointer-events:all}
.submit-modal{width:100%;max-width:560px;max-height:92vh;overflow-y:auto;background:var(--ivory);color:var(--esp);border:1px solid var(--esp);box-shadow:inset 0 0 0 5px var(--ivory),inset 0 0 0 6px var(--gold-line),0 30px 70px rgba(0,0,0,.35);transform:translateY(14px);transition:transform .35s var(--e)}
.submit-modal-backdrop.is-open .submit-modal{transform:none}
.smodal-header{flex-direction:row;align-items:center;gap:1rem;margin:.4rem .4rem 0;padding:1.4rem 1.5rem;color:var(--ivory);
background:radial-gradient(ellipse 90% 90% at 100% 0,rgba(184,148,82,.22),transparent 62%),linear-gradient(160deg,#2B1A12,#1B0F09)}
.smodal-header-icon{width:48px;height:48px;flex-shrink:0;display:grid;place-items:center;border:1px solid var(--gold-line);box-shadow:inset 0 0 0 3px #24150F,inset 0 0 0 4px var(--gold-line)}
.smodal-header-icon svg{stroke:var(--gold-l)}
.smodal-title{font-size:1.05rem;font-weight:900;letter-spacing:-.02em;margin-bottom:.25rem}
.smodal-subtitle{font-size:.76rem;color:var(--beige);line-height:1.5}
.smodal-body{padding:1.25rem 1.5rem .75rem}
.smodal-note{align-items:flex-start;gap:.6rem;padding:.8rem 1rem;margin-bottom:1rem;background:var(--cream);border-left:2px solid var(--gold);font-size:.78rem;color:var(--mocha);line-height:1.55}
.smodal-note strong{color:var(--esp)}
.smodal-note svg{flex-shrink:0;margin-top:2px;stroke:var(--gold)}
.smodal-summary{display:grid;grid-template-columns:1fr 1fr;border:1px solid var(--line);background:var(--w)}
.smodal-sum-row{display:flex;flex-direction:column;gap:.2rem;padding:.7rem .95rem;border-bottom:1px solid var(--line);border-right:1px solid var(--line)}
.smodal-sum-row:nth-child(even){border-right:0}
.smodal-sum-row.full-width{grid-column:1/-1;flex-direction:row;justify-content:space-between;align-items:center;border-right:0}
.smodal-sum-key{font-size:.56rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--taupe)}
.smodal-sum-val{font-size:.8rem;font-weight:800}
.smodal-sum-val.price{font-size:1.05rem;font-weight:900;letter-spacing:-.03em;color:var(--credit)}
.smodal-footer{display:flex;gap:.6rem;padding:.75rem 1.5rem 1.6rem}
.smodal-btn-cancel{flex:1;padding:1rem;background:transparent;color:var(--mocha);border:1px solid var(--beige);font-size:.66rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;transition:.3s}
.smodal-btn-cancel:hover{border-color:var(--esp);color:var(--esp)}
.smodal-btn-confirm{flex:2;display:flex;align-items:center;justify-content:center;gap:.5rem;padding:1rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;transition:background .3s,color .3s,transform .3s var(--e)}
.smodal-btn-confirm:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px)}
.smodal-btn-confirm:disabled{opacity:.6;cursor:not-allowed;transform:none}
/* validation modal */
.vmodal-list{list-style:none;margin:0;padding:0;border:1px solid var(--line);background:var(--w)}
.vmodal-list li{display:flex;align-items:flex-start;gap:.7rem;padding:.8rem 1rem;border-bottom:1px solid var(--line);font-size:.84rem;font-weight:600;line-height:1.5}
.vmodal-list li:last-child{border-bottom:0}
.vmodal-list li::before{content:"";flex-shrink:0;width:6px;height:6px;margin-top:.5rem;background:var(--burg)}
.vmodal-list li span{color:var(--mocha);font-weight:500;display:block;font-size:.76rem}
.form-control.is-invalid,#time-display.is-invalid{border-color:var(--burg);box-shadow:0 0 0 3px rgba(84,37,44,.15)}
#delivery-map.is-invalid{border-color:var(--burg)}
/* customization layout */
.custom-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start}
.custom-grid .form-group{margin-bottom:0}
@media(max-width:700px){.custom-grid{grid-template-columns:1fr}}

/* equal-height columns: sidebar stays sticky but the page ends flush */
.request-layout{align-items:stretch}
.sidebar-col{display:flex;flex-direction:column}
.submit-card{align-self:flex-start;width:100%}
.request-layout>div:first-child>.card:last-child{border-bottom:1px solid var(--esp)}
.request-layout>div:first-child>.card:last-child .form-section:last-child{padding-bottom:1.75rem}
@media(max-width:1000px){.submit-card{align-self:stretch}}
</style>
@endpush

@section('content')

@php
    $cakeTypeLabel   = $config['cakeType'] ?? null;

    // Minimum lead time by tier: Single = 1 day, Two-tier = 2 days, Three-tier = 3 days
    $tierName    = $config['tier'] ?? 'Single';
    $minLeadDays = match ($tierName) {
        'Three-tier' => 3,
        'Two-tier'   => 2,
        default      => 1,
    };
    $minDate = now('Asia/Manila')->addDays($minLeadDays)->format('Y-m-d');
    $fillingLabel    = (!empty($config['filling']) && $config['filling'] !== 'No Filling') ? $config['filling'] : null;
    $shapeLabel      = $config['shapeLabel'] ?? $config['shape'] ?? null;
    $flavorLabel     = $config['flavor'] ?? null;

    $frostingLabel = null;
    if (!empty($config['frosting'])) {
        $frostingLabel = $config['frosting'];
    } elseif (!empty($config['frostings']) && is_array($config['frostings'])) {
        $frostingLabel = implode(' + ', $config['frostings']);
    }

    // Build an accurate, human-readable add-on list straight from the cake
    // builder's saved config — counts, flavors, and orientations included,
    // instead of just dumping raw addon keys.
    $addonDetails = [];
    if (!empty($config['hasDrip'])) {
        $addonDetails[] = trim(($config['dripFlavor'] ?? '') . ' Drip');
    }
    if (!empty($config['hasIcing'])) {
        $addonDetails[] = 'Sugar Icing' . (!empty($config['icingColorName']) ? ' (' . $config['icingColorName'] . ')' : '');
    }
    if (!empty($config['ferreroCount'])) {
        $addonDetails[] = 'Ferrero ×' . $config['ferreroCount'];
    }
    if (!empty($config['kitkatCount'])) {
        $addonDetails[] = 'KitKat ×' . $config['kitkatCount'] . (!empty($config['kitkatOrientation']) ? ' (' . ucfirst($config['kitkatOrientation']) . ')' : '');
    }
    if (!empty($config['oreoCount'])) {
        $addonDetails[] = 'Oreo ×' . $config['oreoCount'] . (!empty($config['oreoOrientation']) ? ' (' . ucfirst($config['oreoOrientation']) . ')' : '');
    }

    $coveredAddonNames = ['Drip', 'Sugar Icing', 'Ferrero-style Ball', 'Kitkat Sticks', 'Oreo Cookie'];
    if (!empty($config['addons']) && is_array($config['addons'])) {
        foreach ($config['addons'] as $addonName) {
            if (is_string($addonName) && !in_array($addonName, $coveredAddonNames)) {
                $addonDetails[] = $addonName;
            }
        }
    }
@endphp

@php
    $summary   = $config['baker_summary'] ?? [];
    $heroName  = $config['cake_label'] ?? trim(($flavorLabel ?? 'Custom') . ' ' . ($shapeLabel ?? 'Cake'));
    $heroTags  = $config['hero_tags'] ?? [];
    $groupRows = fn($title) => collect($summary)->firstWhere('title', $title)['rows'] ?? [];
    $fmtRows   = fn($rows) => collect($rows)->map(fn($r) => $r[0] . ': ' . $r[1])->implode(' · ');
    $modalFrosting = $fmtRows($groupRows('Frosting'));
    $modalDeco     = $fmtRows($groupRows('Decorations'));
    $modalFlavor   = $fmtRows($groupRows('Flavor & Layers'));
    if (!empty($summary)) {
        // the modal below reads these; point them at the accurate values
        $fillingLabel = null;
        $addonDetails = $modalDeco ? [$modalDeco] : [];
    }
@endphp

<div class="rq-page">

<div class="page-heading">
    <h1>Review and Submit Request</h1>
    <p>Confirm your cake details and choose how you'd like to receive it</p>
</div>

<form method="POST" action="{{ route('customer.cake-requests.store') }}" enctype="multipart/form-data" id="requestForm">
@csrf
<input type="hidden" name="fulfillment_type"      id="fulfillment_type_input"  value="delivery">
<input type="hidden" name="is_rush"               id="is_rush_input"           value="0">
<input type="hidden" name="delivery_lat"          id="delivery_lat"            value="">
<input type="hidden" name="delivery_lng"          id="delivery_lng"            value="">
<input type="hidden" name="delivery_address"      id="delivery_address_hidden" value="">
<input type="hidden" name="cake_preview_temp_key" value="{{ $tempKey ?? '' }}">
<input type="hidden" name="cake_configuration"    value="{{ json_encode($config) }}">


<div class="request-layout">

    {{-- LEFT COLUMN --}}
    <div>
{{-- no-config guard (the design card was removed; the sidebar shows the summary) --}}
@if(empty($config))
<div class="card">
    <div class="empty-state">
        No configuration found. <a href="{{ route('customer.cake-builder.index') }}">Go to Cake Builder →</a>
    </div>
</div>
@endif

{{-- CUSTOMIZATION --}}
<div class="card">
    <div class="card-header">
        <h3>Customization</h3>
    </div>
    <div class="form-section">
        <div class="form-group">
            <label>Message on Cake</label>
            <input type="text" name="custom_message" class="form-control"
                   value="{{ old('custom_message') }}"
                   placeholder='"Happy Birthday, Maria!"'>
        </div>

        <div class="custom-grid">
            <div class="form-group">
                <label>Reference Image <span style="font-weight:500;text-transform:none;letter-spacing:0;font-size:0.68rem;color:var(--taupe);">(optional)</span></label>
                <input type="file" name="reference_image"
                       class="form-control @error('reference_image') is-invalid @enderror"
                       accept="image/*">

                @error('reference_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Special Instructions</label>
                <textarea name="special_instructions" class="form-control" rows="4"
                          placeholder="Birthday cake but I want it like this..">{{ old('special_instructions') }}</textarea>
            </div>
        </div>
    </div>
</div>

        {{-- DATE + MAP --}}
        <div class="card">

            {{-- DATE --}}
            <div class="form-section">
                <div class="section-heading">
                    <span style="display:flex;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg></span>
                    <span><span id="date-heading-text">When do you need the</span> cake ready?</span>
                </div>
                <div class="form-group">
                    <div class="date-time-grid">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="delivery_date">Pick a Date *</label>
                            <input type="date" id="delivery_date" name="delivery_date"
                                   class="form-control @error('delivery_date') is-invalid @enderror"
                                   value="{{ old('delivery_date') }}"
                                   min="{{ $minDate }}"
                                   onchange="checkRush(this.value)" required>
                                                       <p class="hint" style="margin-top:0.3rem;">
                                {{ $tierName }} cakes need at least {{ $minLeadDays }} {{ \Illuminate\Support\Str::plural('day', $minLeadDays) }} notice
                                (earliest: {{ \Carbon\Carbon::parse($minDate)->format('M j, Y') }}).
                            </p>
                            @error('delivery_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="needed_time">Time Needed *</label>
                            <input type="hidden" id="needed_time" name="needed_time" value="{{ old('needed_time') }}" required>
                            <div id="time-picker-wrap" style="position:relative;">
                                <div id="time-display" class="form-control" onclick="toggleTimePicker()">
                                    <span id="time-display-text" style="color:var(--text-muted);">Pick a date first</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#B89452" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div id="time-dropdown">
                                    <div id="time-slots"></div>
                                </div>
                            </div>
                            <p class="hint" id="time-hint" style="margin-top:0.3rem;"></p>
                            @error('needed_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div id="rush-banner" class="rush-banner">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <div style="flex:1;">
                            <div class="rush-title">Rush Order — Bakers Compete for You!</div>
                            <div class="rush-sub">Nearby rush bakers will submit their prices (including rush fee).</div>
                            <div class="rush-tags">
                                <span class="rush-tag"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg> Needed: <span id="rush-needed-time">—</span></span>
                                <span class="rush-tag"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> By: <span id="rush-needed-clock">—</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAP --}}
            <div class="form-section" id="delivery-section">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Preferred delivery location (if delivery is chosen later) *</label>
                    <div class="map-search-wrap">
                        <span class="map-search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9A897A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></span>
                        <input type="text" id="map-search" class="form-control"
                               placeholder="Search for your street, barangay, or landmark…"
                               autocomplete="off">
                    </div>
                    <div class="map-instruction">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#B89452" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M20 10c0 6-8 13-8 13s-8-7-8-13a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>Search or <strong>click the map</strong> to drop a pin. Drag to fine-tune.</span>
                    </div>
                    <div id="delivery-map"></div>
                    <div class="selected-address-display" id="address-display">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <div class="addr-text" id="address-text">—</div>
                    </div>
                    @error('delivery_address')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                    @error('delivery_lat')<div class="invalid-feedback" style="display:block;">Please drop a pin to set your delivery location.</div>@enderror
                </div>
            </div>

        </div>
    </div>

    {{-- RIGHT: STICKY SUMMARY + BUDGET + CUSTOMIZATION --}}
    <div class="sidebar-col">
        <div class="submit-card">

            {{-- ORDER SUMMARY --}}
            <div class="submit-top">
                <div class="submit-top-label">Order Summary</div>
                <h3>Review before submitting</h3>
            </div>
            <div class="submit-body">
                @if(!empty($summary))
                <div style="max-height:min(52vh,460px);overflow-y:auto;padding-right:.25rem;">
                    @foreach($summary as $group)
                        @if(!empty($group['rows']))
                        <div class="spec-group" style="padding:.6rem 0 .2rem;">
                            <div class="spec-group-title">{{ $group['title'] }}</div>
                            @foreach($group['rows'] as $row)
                            <div class="sum-row">
                                <span class="key">{{ $row[0] }}</span>
                                <span class="val" style="max-width:62%;">{{ $row[1] }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
                @if(empty($summary))
                @if($cakeTypeLabel)
                <div class="sum-row">
                    <span class="key">Type</span>
                    <span class="val">{{ $cakeTypeLabel }}</span>
                </div>
                @endif
                <div class="sum-row">
                    <span class="key">Shape</span>
                    <span class="val">{{ $shapeLabel ?? '—' }}</span>
                </div>
                <div class="sum-row">
                    <span class="key">Flavour</span>
                    <span class="val">{{ $flavorLabel ?? '—' }}</span>
                </div>
                @if($fillingLabel)
                <div class="sum-row">
                    <span class="key">Filling</span>
                    <span class="val">{{ $fillingLabel }}</span>
                </div>
                @endif
                <div class="sum-row">
                    <span class="key">Frosting</span>
                    <span class="val">{{ $frostingLabel ?? '—' }}</span>
                </div>
                @if(count($addonDetails))
                <div class="sum-row" style="flex-direction:column; align-items:flex-start; gap:0.35rem;">
                    <span class="key">Add-ons</span>
                    <div class="addon-pills">
                        @foreach($addonDetails as $addonDetail)
                        <span class="addon-pill">{{ $addonDetail }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif
                <div class="sum-total">
                    <span class="lbl">Est. Total</span>
                    <span class="amount"><span class="peso">₱</span>{{ number_format($config['total'] ?? 0, 0) }}</span>
                </div>
            </div>

            {{-- BUDGET --}}
            <div class="sidebar-form-section">
                <div class="sidebar-section-heading"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v2"/><path d="M12 16v2"/><path d="M9 9.5A2.5 2.5 0 0 1 14.5 12a2.5 2.5 0 0 1-5 1"/></svg> Budget Range *</div>
                <div class="budget-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Min (₱)</label>
                        <input type="number" name="budget_min" id="budget_min"
                               class="form-control @error('budget_min') is-invalid @enderror"
                               value="{{ old('budget_min', $config['total'] ?? '') }}"
                               placeholder="500" min="1" required>
                        @error('budget_min')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="budget-sep">–</div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Max (₱)</label>
                        <input type="number" name="budget_max" id="budget_max"
                               class="form-control @error('budget_max') is-invalid @enderror"
                               value="{{ old('budget_max', isset($config['total']) ? round($config['total'] * 1.3) : '') }}"
                               placeholder="1500" min="1" required>
                        @error('budget_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            {{-- SUBMIT --}}
            <div class="sidebar-form-section">
                <button type="button" class="btn-submit" id="submit-btn" onclick="openSubmitModal()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Submit to Bakers
                </button>
                <a href="{{ route('customer.cake-builder.index') }}" class="btn-ghost">← Edit Design</a>
            </div>

        </div>{{-- /.submit-card --}}
    </div>{{-- /.sidebar-col --}}

</div>{{-- /.request-layout --}}
</form>



{{-- SUBMIT CONFIRMATION MODAL --}}
<div class="submit-modal-backdrop" id="submitModal" role="dialog" aria-modal="true" aria-label="Confirm request submission">
    <div class="submit-modal">

        <div class="smodal-header" id="smodal-header-normal" style="display:flex;">
            <div class="smodal-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div>
            <div>
                <div class="smodal-title">Submit Your Request?</div>
                <div class="smodal-subtitle">Your order will be posted to available bakers who will send you their best offers.</div>
            </div>
        </div>
        <div class="smodal-header" id="smodal-header-rush" style="display:none;">
            <div class="smodal-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
            <div>
                <div class="smodal-title">Rush Order — Submit?</div>
                <div class="smodal-subtitle">The nearest available baker will be auto-matched and assigned instantly.</div>
            </div>
        </div>

        <div class="smodal-body">

            <div class="smodal-note" id="smodal-note-normal" style="display:flex;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 9.4 7.55 4.24"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg>
                <span>You'll choose <strong>delivery or pickup</strong> when you accept a baker's bid — no need to decide now!</span>
            </div>

            <div class="smodal-note" id="smodal-note-rush" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <span>Nearby rush bakers will be notified. Each submits their own price + rush fee. You have <strong>60 seconds</strong> to pick the best offer.</span>
            </div>

            <div class="smodal-summary">
                <div class="smodal-sum-row">
                    <span class="smodal-sum-key">Cake</span>
                    <span class="smodal-sum-val">{{ !empty($summary) ? $heroName : (($flavorLabel ?? '—') . ' · ' . ($shapeLabel ?? '—')) }}</span>
                </div>
                <div class="smodal-sum-row">
                    <span class="smodal-sum-key">Frosting</span>
                    <span class="smodal-sum-val" style="font-size:.72rem;">{{ !empty($summary) ? $modalFrosting : ($frostingLabel ?? '—') }}</span>
                </div>
                @if($fillingLabel)
                <div class="smodal-sum-row full-width">
                    <span class="smodal-sum-key">Filling</span>
                    <span class="smodal-sum-val">{{ $fillingLabel }}</span>
                </div>
                @endif
                @if(count($addonDetails))
                <div class="smodal-sum-row full-width">
                    <span class="smodal-sum-key">Add-ons</span>
                    <span class="smodal-sum-val" style="font-size:0.75rem; font-weight:600;">{{ implode(', ', $addonDetails) }}</span>
                </div>
                @endif
                <div class="smodal-sum-row full-width" id="smodal-date-row">
                    <span class="smodal-sum-key">Date Needed</span>
                    <span class="smodal-sum-val" id="smodal-date-val" style="color:var(--caramel);">—</span>
                </div>
                <div class="smodal-sum-row full-width" id="smodal-time-row" style="display:none;">
                    <span class="smodal-sum-key">Time Needed</span>
                    <span class="smodal-sum-val" id="smodal-time-val" style="color:var(--caramel);">—</span>
                </div>
                <div class="smodal-sum-row full-width">
                    <span class="smodal-sum-key">Budget</span>
                    <span class="smodal-sum-val" id="smodal-budget-val">
                        ₱<span id="smodal-budget-min">{{ number_format($config['total'] ?? 0, 0) }}</span>
                        – ₱<span id="smodal-budget-max">{{ number_format(round(($config['total'] ?? 0) * 1.3), 0) }}</span>
                    </span>
                </div>
                <div class="smodal-sum-row full-width" id="smodal-rush-row" style="display:none;">
                    <span class="smodal-sum-key">Type</span>
                    <span class="smodal-sum-val" style="color:var(--caramel);display:inline-flex;align-items:center;gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Order</span>
                </div>
                <div class="smodal-sum-row full-width" id="smodal-normal-total-row">
                    <span class="smodal-sum-key">Est. Total</span>
                    <span class="smodal-sum-val price">₱{{ number_format($config['total'] ?? 0, 0) }}</span>
                </div>
                <div id="smodal-rush-breakdown" style="display:none; grid-column: 1 / -1;">
                    <div class="smodal-sum-row full-width">
                        <span class="smodal-sum-key">Cake Price</span>
                        <span class="smodal-sum-val">₱{{ number_format($config['total'] ?? 0, 0) }}</span>
                    </div>
                    <div class="smodal-sum-row full-width">
                        <span class="smodal-sum-key" style="color:var(--caramel);display:inline-flex;align-items:center;gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Fee</span>
                        <span class="smodal-sum-val" style="color:var(--caramel);">+ set by each baker</span>
                    </div>
                    <div class="smodal-sum-row full-width" style="border-top:1px solid var(--esp);border-bottom:0;">
                        <span class="smodal-sum-key">Est. Total</span>
                        <span class="smodal-sum-val price">₱{{ number_format($config['total'] ?? 0, 0) }}+</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="smodal-footer">
            <button type="button" class="smodal-btn-cancel" onclick="closeSubmitModal()">← Go Back</button>
            <button type="button" class="smodal-btn-confirm" id="smodal-confirm-btn" onclick="confirmAndSubmit()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                <span id="smodal-confirm-text">Yes, Submit!</span>
            </button>
        </div>
    </div>
</div>

{{-- VALIDATION MODAL --}}
<div class="submit-modal-backdrop" id="validationModal" role="alertdialog" aria-modal="true" aria-labelledby="vmodal-title">
    <div class="submit-modal">
        <div class="smodal-header" style="display:flex;">
            <div class="smodal-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <div>
                <div class="smodal-title" id="vmodal-title">A few details are missing</div>
                <div class="smodal-subtitle">Complete the items below so bakers can respond to your request.</div>
            </div>
        </div>
        <div class="smodal-body">
            <ul class="vmodal-list" id="vmodal-list"></ul>
        </div>
        <div class="smodal-footer">
            <button type="button" class="smodal-btn-confirm" id="vmodal-ok" onclick="closeValidationModal()">Got it</button>
        </div>
    </div>
</div>

</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Fulfillment is always delivery — just set the hidden input
    document.getElementById('fulfillment_type_input').value = 'delivery';

    // ── LEAFLET MAP ───────────────────────────────────────────────────────────
    const DEFAULT_LAT = 14.5995, DEFAULT_LNG = 120.9842;
    const map = L.map('delivery-map', { center: [DEFAULT_LAT, DEFAULT_LNG], zoom: 13 });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>', maxZoom: 19,
    }).addTo(map);

    const markerIcon = L.divIcon({
        className: '',
        html: `<div style="width:18px;height:18px;background:#B89452;border:3px solid #24150F;border-radius:50%;box-shadow:0 2px 8px rgba(36,21,15,0.5);"></div>`,
        iconSize: [18,18], iconAnchor: [9,9],
    });
    let marker = null;

    function setLocation(lat, lng, label) {
        document.getElementById('delivery_lat').value             = lat;
        document.getElementById('delivery_lng').value             = lng;
        document.getElementById('delivery_address_hidden').value  = label;
        document.getElementById('address-text').textContent       = label;
        document.getElementById('address-display').classList.add('visible');
    }

    function reverseGeocode(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(r => r.json())
            .then(d => {
                const a = d.display_name || `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                setLocation(lat, lng, a);
                document.getElementById('map-search').value = a;
            })
            .catch(() => setLocation(lat, lng, `${lat.toFixed(5)}, ${lng.toFixed(5)}`));
    }

    function placeMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { icon: markerIcon, draggable: true }).addTo(map);
            marker.on('dragend', e => {
                const p = e.target.getLatLng();
                reverseGeocode(p.lat, p.lng);
            });
        }
        map.panTo([lat, lng]);
    }

    map.on('click', e => {
        placeMarker(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(p => {
            map.setView([p.coords.latitude, p.coords.longitude], 15);
            placeMarker(p.coords.latitude, p.coords.longitude);
            reverseGeocode(p.coords.latitude, p.coords.longitude);
        }, () => {});
    }

    // ── SEARCH DROPDOWN ───────────────────────────────────────────────────────
    const searchInput = document.getElementById('map-search');
    const dropdown    = document.createElement('div');
    dropdown.style.cssText = 'position:absolute;top:100%;left:0;right:0;background:#FBF8F2;border:1px solid #B89452;box-shadow:0 14px 34px rgba(36,21,15,0.18);z-index:1000;margin-top:4px;max-height:220px;overflow-y:auto;display:none;';
    searchInput.parentElement.style.position = 'relative';
    searchInput.parentElement.appendChild(dropdown);

    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const q = this.value.trim();
        if (q.length < 3) { dropdown.style.display = 'none'; return; }
        searchTimeout = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}&limit=5&countrycodes=ph`)
                .then(r => r.json())
                .then(results => {
                    dropdown.innerHTML = '';
                    if (!results.length) {
                        dropdown.innerHTML = '<div style="padding:0.75rem 1rem;font-size:0.78rem;color:#9A897A;">No results found</div>';
                        dropdown.style.display = 'block';
                        return;
                    }
                    results.forEach(place => {
                        const item = document.createElement('div');
                        item.style.cssText = 'padding:0.7rem 1rem;font-size:0.78rem;cursor:pointer;border-bottom:1px solid rgba(36,21,15,0.14);color:#24150F;transition:background 0.15s;';
                        item.textContent = place.display_name;
                        item.addEventListener('mouseenter', () => item.style.background = '#EFE6D7');
                        item.addEventListener('mouseleave', () => item.style.background = 'transparent');
                        item.addEventListener('click', () => {
                            const lat = parseFloat(place.lat), lng = parseFloat(place.lon);
                            placeMarker(lat, lng);
                            setLocation(lat, lng, place.display_name);
                            searchInput.value = place.display_name;
                            dropdown.style.display = 'none';
                            map.setView([lat, lng], 16);
                        });
                        dropdown.appendChild(item);
                    });
                    dropdown.style.display = 'block';
                });
        }, 400);
    });

    document.addEventListener('click', e => {
        if (!searchInput.parentElement.contains(e.target)) dropdown.style.display = 'none';
    });

    // ── PH TIME HELPERS ──
    function getPHNow() {
        return new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
    }
    function getTodayPH() {
        return getPHNow().toLocaleDateString('en-CA');
    }
    function toHHMM(h, m) {
        return String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
    }
    function formatSlotLabel(h, m) {
        const period = h < 12 ? 'AM' : 'PM';
        const h12 = h === 0 ? 12 : h > 12 ? h - 12 : h;
        const mm = String(m).padStart(2,'0');
        return `${h12}:${mm} ${period}`;
    }

    const timeInput   = document.getElementById('needed_time');
    const dateInput   = document.getElementById('delivery_date');
    const timeHint    = document.getElementById('time-hint');
    const timeDisplay = document.getElementById('time-display-text');
    const timeSlotsEl = document.getElementById('time-slots');
    const timeDropdown= document.getElementById('time-dropdown');

    function buildTimeSlots() {
        const selectedDate = dateInput.value;
        if (!selectedDate) return;
        const isToday = selectedDate === getTodayPH();
        const phNow   = getPHNow();

        // Min allowed = PH now + 5 hrs, rounded up to next 30-min slot
        let total = phNow.getHours() * 60 + phNow.getMinutes() + 300;
        total = Math.ceil(total / 30) * 30;
        const minMins = total;              // can be >= 1440 (rolls past midnight)
        const minH = Math.floor(total / 60) % 24;
        const minM = total % 60;

        const oldVal = timeInput.value;
        timeSlotsEl.innerHTML = '';
        let firstValidVal = null;

        for (let h = 0; h < 24; h++) {
            for (let m of [0, 30]) {
                const slotMins = h * 60 + m;
                if (isToday && slotMins < minMins) continue;
                const val   = toHHMM(h, m);
                const label = formatSlotLabel(h, m);
                if (!firstValidVal) firstValidVal = val;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = label;
                btn.dataset.val = val;
                btn.style.cssText = `
                    padding:0.4rem 0.2rem; border-radius:0; border:1px solid var(--border);
                    background:${val === oldVal ? 'var(--esp)' : 'var(--cream)'};
                    color:${val === oldVal ? 'var(--gold-l)' : 'var(--text-dark)'};
                    font-size:0.68rem; font-weight:700; cursor:pointer;
                    font-family:'Plus Jakarta Sans',sans-serif;
                    transition:all 0.15s; white-space:nowrap;
                `;
                btn.addEventListener('mouseenter', () => { if (btn.dataset.val !== timeInput.value) btn.style.background = '#F3EAD3'; });
                btn.addEventListener('mouseleave', () => { if (btn.dataset.val !== timeInput.value) btn.style.background = 'var(--cream)'; });
                btn.addEventListener('click', () => selectTime(val, label));
                timeSlotsEl.appendChild(btn);
            }
        }

        // Restore or default to earliest
        const restoreVal = oldVal || firstValidVal;
        if (restoreVal) {
            const restoreLabel = formatSlotLabel(parseInt(restoreVal.split(':')[0]), parseInt(restoreVal.split(':')[1]));
            selectTime(restoreVal, restoreLabel, false);
        }

        if (isToday) {
       timeHint.textContent = (total >= 1440)
    ? 'No time slots left today. Please choose tomorrow or later.'
    : `Earliest available: ${formatSlotLabel(minH, minM)} (5 hrs from now)`;
        } else {
            timeHint.textContent = '';
        }
    }

    function selectTime(val, label, closeDropdown = true) {
        timeInput.value = val;
        timeDisplay.textContent = label;
        timeDisplay.style.color = 'var(--text-dark)';
        // Update button highlights
        timeSlotsEl.querySelectorAll('button').forEach(b => {
            const active = b.dataset.val === val;
            b.style.background = active ? 'var(--esp)' : 'var(--cream)';
            b.style.color = active ? 'var(--gold-l)' : 'var(--text-dark)';
        });
        if (closeDropdown) timeDropdown.style.display = 'none';
        updateRushTime();
    }
    window.toggleTimePicker = function() {
        if (!dateInput.value) return;
        timeDropdown.style.display = timeDropdown.style.display === 'none' ? 'block' : 'none';
    };

    // Close on outside click
    document.addEventListener('click', e => {
        if (!document.getElementById('time-picker-wrap').contains(e.target)) {
            timeDropdown.style.display = 'none';
        }
    });

    dateInput.addEventListener('change', () => {
        timeDisplay.textContent = 'Select time…';
        timeInput.value = '';
        buildTimeSlots();
    });

    if (dateInput.value) buildTimeSlots();
    else timeDisplay.textContent = 'Pick a date first';

    // Run on page load in case old() date is pre-filled
    const existingDate = document.getElementById('delivery_date').value;
    if (existingDate) checkRush(existingDate);

});


function checkRush(dateVal) {
    if (!dateVal) return;
    const selected = new Date(dateVal);
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    tomorrow.setHours(23, 59, 59, 0);
    selected.setHours(0, 0, 0, 0);

    const isRush = selected <= tomorrow;
    const banner = document.getElementById('rush-banner');
    document.getElementById('is_rush_input').value = isRush ? '1' : '0';
    banner.style.display = isRush ? 'flex' : 'none';

    if (isRush) {
        const neededEl = document.getElementById('rush-needed-time');
        if (neededEl) {
            const opts = { weekday: 'short', month: 'short', day: 'numeric' };
            neededEl.textContent = selected.toLocaleDateString('en-PH', opts);
        }
        updateRushTime();
    }
}

function updateRushTime() {
    const dateVal = document.getElementById('delivery_date').value;
    const timeVal = document.getElementById('needed_time').value;
    const clockEl = document.getElementById('rush-needed-clock');
    if (!clockEl || !dateVal) return;

    // Use PH time for today/tomorrow comparison
    const phNow = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
    const todayPH = phNow.toLocaleDateString('en-CA');
    const tomorrowPH = new Date(phNow);
    tomorrowPH.setDate(tomorrowPH.getDate() + 1);
    const tomorrowStr = tomorrowPH.toLocaleDateString('en-CA');

    let prefix = '';
    if (dateVal === todayPH) prefix = 'Today';
    else if (dateVal === tomorrowStr) prefix = 'Tomorrow';
    else {
        const d = new Date(dateVal + 'T00:00:00');
        prefix = d.toLocaleDateString('en-PH', { month: 'short', day: 'numeric' });
    }

    if (timeVal) {
        const [h, m] = timeVal.split(':');
        const t = new Date(); t.setHours(parseInt(h), parseInt(m), 0, 0);
        const timeStr = t.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit' });
        clockEl.textContent = prefix + ' by ' + timeStr;
    } else {
        clockEl.textContent = prefix;
    }
}
let _vmFirstEl = null;

function validateBeforeSubmit() {
    const errors = [];
    const add = (msg, hint, el) => errors.push({ msg, hint, el });

    // clear previous highlights
    document.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));

    const dateEl = document.getElementById('delivery_date');
    const MIN_DATE = @json($minDate);
    const MIN_DAYS = @json($minLeadDays);
    const TIER_NAME = @json($tierName);
    if (!dateEl.value)
        add('Pick a date', 'Choose when you need the cake ready.', dateEl);
    else if (dateEl.value < MIN_DATE)
        add('Date is too soon', TIER_NAME + ' cakes need at least ' + MIN_DAYS + ' day' + (MIN_DAYS > 1 ? 's' : '') + ' notice. Earliest date is ' + MIN_DATE + '.', dateEl);

    if (!document.getElementById('needed_time').value)
        add('Pick a time', dateEl.value ? 'Choose a time slot. If none show for today, pick a later date.' : 'Select a date first, then a time.', document.getElementById('time-display'));

    if (!document.getElementById('delivery_lat').value || !document.getElementById('delivery_address_hidden').value)
        add('Drop a delivery pin', 'Search an address or click the map.', document.getElementById('delivery-map'));

    const minEl = document.getElementById('budget_min');
    const maxEl = document.getElementById('budget_max');
    const min = parseInt(minEl.value || 0), max = parseInt(maxEl.value || 0);
    if (!min || !max)
        add('Enter your budget range', 'Both minimum and maximum are required.', !min ? minEl : maxEl);
    else if (max < min)
        add('Check your budget range', 'Maximum must be higher than minimum.', maxEl);

    if (!errors.length) return true;

    const list = document.getElementById('vmodal-list');
    list.innerHTML = '';
    errors.forEach(e => {
        const li = document.createElement('li');
        const wrap = document.createElement('div');
        wrap.textContent = e.msg;
        const s = document.createElement('span');
        s.textContent = e.hint;
        wrap.appendChild(s);
        li.appendChild(wrap);
        list.appendChild(li);
        if (e.el) e.el.classList.add('is-invalid');
    });
    _vmFirstEl = errors[0].el;

    document.getElementById('validationModal').classList.add('is-open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('vmodal-ok').focus(), 50);
    return false;
}

function closeValidationModal() {
    document.getElementById('validationModal').classList.remove('is-open');
    document.body.style.overflow = '';
    if (_vmFirstEl) {
        _vmFirstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        if (typeof _vmFirstEl.focus === 'function' && _vmFirstEl.tagName === 'INPUT') {
            setTimeout(() => _vmFirstEl.focus({ preventScroll: true }), 350);
        }
    }
}
document.getElementById('validationModal').addEventListener('click', function (e) {
    if (e.target === this) closeValidationModal();
});
function openSubmitModal() {
    if (!validateBeforeSubmit()) return;
    const isRush = document.getElementById('is_rush_input').value === '1';

    // Swap header
    document.getElementById('smodal-header-normal').style.display = isRush ? 'none' : 'flex';
    document.getElementById('smodal-header-rush').style.display   = isRush ? 'flex' : 'none';

    // Swap note
    document.getElementById('smodal-note-normal').style.display = isRush ? 'none' : 'flex';
    document.getElementById('smodal-note-rush').style.display   = isRush ? 'flex' : 'none';

    // Rush row + breakdown
    document.getElementById('smodal-rush-row').style.display          = isRush ? 'flex' : 'none';
    document.getElementById('smodal-rush-breakdown').style.display     = isRush ? 'block' : 'none';
    document.getElementById('smodal-normal-total-row').style.display   = isRush ? 'none' : 'flex';

    // Button label
    document.getElementById('smodal-confirm-text').innerHTML = isRush ? '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Yes, Submit Rush!' : 'Yes, Submit!';

    // ── Populate date ──
    const dateVal = document.getElementById('delivery_date').value;
    const dateEl  = document.getElementById('smodal-date-val');
    if (dateVal && dateEl) {
        const d = new Date(dateVal);
        dateEl.textContent = d.toLocaleDateString('en-PH', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
    }

    const timeVal = document.getElementById('needed_time')?.value;
    // timeVal is already HH:MM from the picker
    const timeRow = document.getElementById('smodal-time-row');
    const timeEl  = document.getElementById('smodal-time-val');
    if (timeVal && timeRow && timeEl) {
        const [h, m] = timeVal.split(':');
        const t = new Date(); t.setHours(h, m, 0);
        timeEl.textContent = t.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit' });
        timeRow.style.display = 'flex';
    } else if (timeRow) {
        timeRow.style.display = 'none';
    }

    // ── Populate budget ──
    const minEl = document.getElementById('budget_min');
    const maxEl = document.getElementById('budget_max');
    const sMin  = document.getElementById('smodal-budget-min');
    const sMax  = document.getElementById('smodal-budget-max');
    if (minEl && sMin) sMin.textContent = parseInt(minEl.value || 0).toLocaleString('en-PH');
    if (maxEl && sMax) sMax.textContent = parseInt(maxEl.value || 0).toLocaleString('en-PH');

    document.getElementById('submitModal').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeSubmitModal() {
    document.getElementById('submitModal').classList.remove('is-open');
    document.body.style.overflow = '';
}
function confirmAndSubmit() {
    const btn = document.getElementById('smodal-confirm-btn');
    btn.disabled = true;
    btn.innerHTML = '<span style="width:14px;height:14px;border:2px solid rgba(255,255,255,0.3);border-top-color:white;border-radius:50%;animation:spin 0.7s linear infinite;display:inline-block;"></span> Submitting…';
    document.getElementById('requestForm').submit();
}
document.getElementById('submitModal').addEventListener('click', function(e) {
    if (e.target === this) closeSubmitModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key !== 'Escape') return;
    if (document.getElementById('validationModal').classList.contains('is-open')) closeValidationModal();
    else closeSubmitModal();
});
['delivery_date','budget_min','budget_max'].forEach(id =>
    document.getElementById(id).addEventListener('input', e => e.target.classList.remove('is-invalid')));
</script>
@endpush