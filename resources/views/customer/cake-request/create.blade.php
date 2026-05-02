@extends('layouts.customer')
@section('title', 'Request This Cake')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ── RESET & BASE ── */
*, *::before, *::after { box-sizing: border-box; }
/* Add to your :root or top of styles */
body { max-width: 100%; overflow-x: hidden; }

:root {
    --cream:      #FAF6F1;
    --warm-white: #FFFFFF;
    --border:     #EDE5DA;
    --border-dk:  #D9CDBD;
    --brown-deep: #2C1A0E;
    --brown-mid:  #5C3D28;
    --text-dark:  #2C1A0E;
    --text-mid:   #6B5040;
    --text-muted: #9C8070;
    --caramel:    #C8894A;
    --caramel-lt: #E8A96A;
    --accent-lt:  #FEF3E8;
    --green:      #2D6A30;
    --green-lt:   #EFF7EF;
    --red:        #C0392B;
    --shadow-sm:  0 1px 4px rgba(44,26,14,0.06);
    --shadow-md:  0 4px 20px rgba(44,26,14,0.09);
    --radius-sm:  8px;
    --radius:     14px;
    --radius-lg:  20px;
    --transition: 0.18s ease;
}
/* ── PESO SIGN FIX ── */
.price-banner-amount,
.sum-total .amount {
    font-family: 'Plus Jakarta Sans', sans-serif;

    font-weight: 700;
}
.price-banner-amount .peso,
.sum-total .amount .peso {
    font-family: 'Plus Jakarta Sans', sans-serif;

    font-size: 0.75em;
    font-weight: 600;
    vertical-align: 0.1em;
    margin-right: 0.05em;
    opacity: 0.85;
}
.page-nav {
    display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.65rem;
}
.back-link {
    display: inline-flex; align-items: center; gap: 0.35rem;
    font-size: 0.78rem; font-weight: 500; color: var(--text-muted);
    text-decoration: none; padding: 0.35rem 0.8rem;
    border: 1px solid var(--border); border-radius: 20px;
    background: var(--warm-white); transition: all var(--transition);
}
.back-link:hover { border-color: var(--caramel); color: var(--caramel); }
.breadcrumb-sep { color: var(--border-dk); font-size: 0.75rem; }
.breadcrumb-cur { font-size: 0.78rem; color: var(--text-muted); }

/* ── PAGE HEADING ── */
.page-heading { margin-bottom: 0.85rem; }
.page-heading h1 {
   font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.2rem, 3vw, 1.55rem);
    font-weight: 600; color: var(--brown-deep); line-height: 1.2; letter-spacing: -0.01em;
}
.page-heading p { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.15rem; }
.request-layout > div {
    min-width: 0;
}
/* ── LAYOUT ── */
.request-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.25rem;
    align-items: start;
}
@media (max-width: 900px) {
    .request-layout {
        grid-template-columns: 1fr;
    }
    .sidebar-col {
        order: -1; /* summary card on top */
    }
    .submit-card {
        position: static; /* don't sticky on mobile */
    }
}
@media (max-width: 600px) {
    .page-heading h1 { font-size: 1.3rem; }

    .config-details { grid-template-columns: 1fr 1fr; }

    .fulfillment-toggle { grid-template-columns: 1fr 1fr; gap: 0.5rem; }
    .ft-option { padding: 0.7rem 0.75rem; }
    .ft-title { font-size: 0.8rem; }
    .ft-sub { font-size: 0.64rem; }

    .budget-row { grid-template-columns: 1fr 18px 1fr; gap: 0.35rem; }

    #delivery-map { height: 200px; }

    .form-control { font-size: 0.82rem; padding: 0.55rem 0.8rem; }

    .card-header { padding: 0.75rem 1rem; }
    .form-section { padding: 0.9rem 1rem; }
    .sidebar-form-section { padding: 0.85rem 1rem; }
    .submit-body { padding: 0.85rem 1rem; }
    .submit-top { padding: 0.9rem 1rem; }

    .sum-row { font-size: 0.75rem; }
    .sum-row .val { font-size: 0.74rem; }
    .sum-total .amount { font-size: 1.25rem; }

    .btn-submit { font-size: 0.83rem; padding: 0.75rem; }
    .btn-ghost  { font-size: 0.75rem; }
}
/* ── CARDS ── */
.card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: var(--radius-lg); overflow: hidden;
    margin-bottom: 1rem; box-shadow: var(--shadow-sm);
}
.card:last-child { margin-bottom: 0; }
.card-header {
    padding: 0.9rem 1.25rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 0.5rem; background: var(--cream);
}
.card-header-icon {
    width: 26px; height: 26px; border-radius: 7px;
    background: var(--accent-lt); display: flex; align-items: center;
    justify-content: center; font-size: 0.8rem; flex-shrink: 0;
}
.card-header h3 {
   font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9rem;
    font-weight: 600; color: var(--brown-deep);
}

/* ── CAKE CONFIG CHIPS ── */
.config-chips-row {
    padding: 0.9rem 1.25rem 0.75rem; display: flex; flex-wrap: wrap;
    gap: 0.4rem; border-bottom: 1px solid var(--border);
}
.chip {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.28rem 0.75rem; border-radius: 20px; font-size: 0.75rem;
    font-weight: 700; background: var(--warm-white); color: var(--brown-deep);
    border: 1px solid var(--border);
}
.chip-key {
    font-size: 0.62rem; color: var(--text-muted); opacity: 1;
    font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em;
    padding-right: 0.2rem; border-right: 1px solid var(--border); margin-right: 0.1rem;
}
.config-details {
    display: grid; grid-template-columns: repeat(3, 1fr);
    border-bottom: 1px solid var(--border);
}
@media (max-width: 500px) {
    .config-details { grid-template-columns: 1fr 1fr; }
}
.config-item { padding: 0.85rem 1.25rem; border-right: 1px solid var(--border); }
.config-item:last-child { border-right: none; }
.config-label {
    font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.12em;
    color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;
}
.config-value { font-size: 0.85rem; font-weight: 600; color: var(--brown-deep); }
.price-banner {
    padding: 0.9rem 1.25rem; display: flex; justify-content: space-between; align-items: center;
    background: linear-gradient(105deg, var(--brown-deep) 0%, #4A2D1A 100%);
}
.price-banner-label {
    font-size: 0.7rem; color: rgba(255,255,255,0.5);
    text-transform: uppercase; letter-spacing: 0.1em; font-weight: 500;
}
.price-banner-sub { font-size: 0.7rem; color: rgba(255,255,255,0.35); margin-top: 0.1rem; }
.price-banner-amount {
    font-size: 1.5rem;
    color: var(--caramel-lt); font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;

}

/* ── FORM SECTIONS ── */
.form-section { padding: 1.1rem 1.25rem; border-bottom: 1px solid var(--border); }
.form-section:last-child { border-bottom: none; }
.form-section:last-child { border-bottom: none; padding-bottom: 1.5rem; }
.section-heading {
  font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.87rem; font-weight: 600;
    color: var(--brown-deep); margin-bottom: 0.9rem;
    display: flex; align-items: center; gap: 0.4rem;
}
.form-group { display: flex; flex-direction: column; gap: 0.3rem; margin-bottom: 0.85rem; }
.form-group:last-child { margin-bottom: 0; }
label {
    font-size: 0.67rem; font-weight: 600; color: var(--text-mid);
    letter-spacing: 0.08em; text-transform: uppercase;
}
.form-control {
    padding: 0.6rem 0.85rem; border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif;

    font-size: 0.85rem; color: var(--text-dark); background: var(--cream);
    outline: none; width: 100%;
    transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
}
.form-control:focus {
    border-color: var(--caramel); box-shadow: 0 0 0 3px rgba(200,137,74,0.10);
    background: var(--warm-white);
}
.form-control.is-invalid { border-color: var(--red); }
.invalid-feedback { font-size: 0.7rem; color: var(--red); margin-top: 0.1rem; }
textarea.form-control { resize: vertical; min-height: 75px; }
.hint { font-size: 0.69rem; color: var(--text-muted); margin-top: 0.1rem; line-height: 1.4; }

/* ── BUDGET ROW ── */
.budget-row {
    display: grid; grid-template-columns: 1fr 22px 1fr;
    gap: 0.5rem; align-items: end;
}
.budget-sep {
    text-align: center; color: var(--text-muted); font-size: 0.8rem;
    padding-bottom: 0.6rem; font-weight: 300;
}

/* ── FULFILLMENT TOGGLE ── */
.fulfillment-toggle {
    display: grid; grid-template-columns: 1fr 1fr; gap: 0.65rem; margin-bottom: 1rem;
}
@media (max-width: 400px) {
    .fulfillment-toggle { grid-template-columns: 1fr; }
    .config-details { grid-template-columns: 1fr; }
    .config-item { border-right: none; }
}
.ft-option {
    border: 2px solid var(--border); border-radius: 12px;
    padding: 0.85rem 1rem; cursor: pointer; transition: all 0.2s;
    background: var(--warm-white); position: relative;
}
.ft-option.active { border-color: var(--caramel); background: var(--accent-lt); }
.ft-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
.ft-inner { display: flex; align-items: center; gap: 0.6rem; }
.ft-emoji { font-size: 1.25rem; flex-shrink: 0; }
.ft-title { font-weight: 700; font-size: 0.84rem; color: var(--brown-deep); }
.ft-sub { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.05rem; }
.ft-check {
    width: 16px; height: 16px; border: 2px solid var(--border);
    border-radius: 50%; margin-left: auto; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.ft-option.active .ft-check { border-color: var(--caramel); background: var(--caramel); }
.ft-option.active .ft-check::after {
    content: ''; width: 5px; height: 5px; border-radius: 50%; background: white;
}

/* ── PICKUP NOTICE ── */
.pickup-notice {
    display: none; background: #FEF9E8; border: 1.5px solid #F0D090;
    border-radius: 12px; padding: 0.85rem 1rem; margin-bottom: 1rem;
}
.pickup-notice.visible { display: flex; align-items: flex-start; gap: 0.7rem; }
.pickup-notice-icon { font-size: 1.2rem; flex-shrink: 0; }
.pickup-notice-title { font-weight: 700; color: var(--brown-deep); font-size: 0.84rem; margin-bottom: 0.2rem; }
.pickup-notice-sub { font-size: 0.75rem; color: var(--text-muted); line-height: 1.6; }
.pickup-notice-sub strong { color: #B07030; }

/* ── MAP ── */
.map-search-wrap { position: relative; margin-bottom: 0.55rem; }
.map-search-icon {
    position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
    font-size: 0.82rem; pointer-events: none; z-index: 1;
}
#map-search { padding-left: 2.1rem; }
#delivery-map {
    width: 100%; height: 240px; border-radius: var(--radius-sm);
    border: 1.5px solid var(--border); margin-bottom: 0.55rem; z-index: 1;
    display: block;
}
/* ── SUBMIT CONFIRMATION MODAL ── */
.submit-modal-backdrop {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(20, 10, 4, 0.65);
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem; opacity: 0; pointer-events: none;
    transition: opacity 0.25s ease;
}
.submit-modal-backdrop.is-open { opacity: 1; pointer-events: all; }
.submit-modal {
    background: var(--warm-white); border-radius: 20px; width: 100%; max-width: 540px;
    overflow: hidden; box-shadow: 0 32px 80px rgba(0,0,0,0.25);
    transform: translateY(20px) scale(0.96);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.submit-modal-backdrop.is-open .submit-modal { transform: translateY(0) scale(1); }
.smodal-header {
    background: linear-gradient(135deg, #3B1F0F 0%, #7A4A28 100%);
    padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1rem; color: white;
}
.smodal-header-icon {
    width: 46px; height: 46px; border-radius: 50%; flex-shrink: 0;
    background: rgba(255,255,255,0.12); border: 2px solid rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
}
.smodal-title {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1rem;
    font-weight: 700; color: white; margin-bottom: 0.15rem;
}
.smodal-subtitle { font-size: 0.73rem; color: rgba(255,255,255,0.6); line-height: 1.45; }
.smodal-body { padding: 1rem 1.25rem; }
.smodal-note {
    background: var(--accent-lt); border: 1.5px solid rgba(200,137,74,0.25);
    border-radius: 10px; padding: 0.65rem 0.9rem;
    font-size: 0.75rem; color: var(--text-mid); line-height: 1.55;
    margin-bottom: 0.85rem;
    display: flex; align-items: flex-start; gap: 0.5rem;
}
.smodal-note > span { flex-shrink: 0; margin-top: 1px; }
.smodal-note strong { color: var(--caramel); }
.smodal-summary {
    background: var(--cream); border: 1px solid var(--border);
    border-radius: 10px; overflow: hidden; margin-bottom: 0;
    display: grid; grid-template-columns: 1fr 1fr;
}
.smodal-sum-row {
    display: flex; flex-direction: column; gap: 0.15rem;
    font-size: 0.78rem; padding: 0.5rem 0.85rem;
    border-bottom: 1px solid var(--border);
    border-right: 1px solid var(--border);
}
.smodal-sum-row:nth-child(even) { border-right: none; }
.smodal-sum-row:nth-last-child(-n+2) { border-bottom: none; }
.smodal-sum-row.full-width {
    grid-column: 1 / -1; flex-direction: row;
    justify-content: space-between; align-items: center;
    border-right: none;
}
.smodal-sum-key { color: var(--text-muted); font-size: 0.62rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; }
.smodal-sum-val { font-weight: 700; color: var(--brown-deep); font-size: 0.78rem; }
.smodal-sum-val.price { color: var(--caramel); font-size: 0.92rem; font-weight: 700; }
.smodal-footer { display: flex; gap: 0.55rem; padding: 0 1.25rem 1.25rem; }
.smodal-btn-cancel {
    flex: 1; padding: 0.65rem; border-radius: 10px;
    border: 1.5px solid var(--border); background: white;
    color: var(--text-mid); font-size: 0.82rem; font-weight: 600;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.smodal-btn-cancel:hover { border-color: var(--caramel); color: var(--caramel); }
.smodal-btn-confirm {
    flex: 2; padding: 0.65rem; border-radius: 10px; border: none;
    background: linear-gradient(135deg, #3B1F0F 0%, #7A4A28 100%);
    color: white; font-size: 0.82rem; font-weight: 700;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(59,31,15,0.35);
    transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.45rem;
}
.smodal-btn-confirm:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(59,31,15,0.45); }
.smodal-btn-confirm:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
@keyframes spin { to { transform: rotate(360deg); } }
.map-instruction {
    display: flex; align-items: center; gap: 0.4rem; font-size: 0.71rem;
    color: var(--text-muted); background: var(--cream); border: 1px solid var(--border);
    border-radius: var(--radius-sm); padding: 0.5rem 0.75rem;
    margin-bottom: 0.55rem; line-height: 1.4;
}
.selected-address-display {
    background: var(--green-lt); border: 1px solid rgba(45,106,48,0.2);
    border-radius: var(--radius-sm); padding: 0.6rem 0.85rem;
    font-size: 0.78rem; color: var(--green);
    display: none; align-items: flex-start; gap: 0.4rem; line-height: 1.5;
    margin-bottom: 0;
}
.selected-address-display.visible { display: flex; }
.selected-address-display .addr-text { flex: 1; }
.leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif;
 sans-serif !important; }

/* ── SIDEBAR SUBMIT CARD ── */
.submit-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: var(--radius-lg); overflow: hidden;
    position: sticky; top: 5rem; box-shadow: var(--shadow-md);
}
.submit-top {
    padding: 1.1rem 1.25rem;
    background: linear-gradient(135deg, var(--brown-deep), #4A2D1A); color: white;
}
.submit-top-label {
    font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.14em;
    color: rgba(255,255,255,0.4); font-weight: 600; margin-bottom: 0.15rem;
}
.submit-top h3 {
  font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem;
    color: var(--caramel-lt); font-weight: 600;
}
.submit-body { padding: 1rem 1.25rem; }
.sum-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 0.45rem 0; font-size: 0.78rem; border-bottom: 1px solid var(--border);
    color: var(--text-mid);
}
.sum-row:last-of-type { border-bottom: none; }
.sum-row .val { font-weight: 600; color: var(--text-dark); text-align: right; max-width: 55%; font-size: 0.77rem; }
.sum-row .key { color: var(--text-muted); font-size: 0.73rem; }
.sum-divider { height: 1px; background: var(--border); margin: 0.65rem 0; }
.sum-total {
    display: flex; justify-content: space-between; align-items: baseline; padding: 0.4rem 0 0;
}
.sum-total .lbl {
    font-size: 0.7rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: 0.1em; color: var(--text-muted);
}

/* ── SIDEBAR FORM SECTIONS ── */
.sidebar-form-section {
    padding: 1rem 1.25rem; border-top: 1px solid var(--border);
}
.sidebar-section-heading {
   font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.84rem; font-weight: 600;
    color: var(--brown-deep); margin-bottom: 0.8rem;
    display: flex; align-items: center; gap: 0.4rem;
}

/* ── BUTTONS ── */
.btn-submit {
    width: 100%; padding: 0.8rem; margin-top: 0.9rem; background: var(--caramel);
    color: white; border: none; border-radius: var(--radius-sm);
    font-family: 'Plus Jakarta Sans', sans-serif;
 font-size: 0.86rem; font-weight: 600;
    cursor: pointer; transition: all var(--transition);
    box-shadow: 0 3px 14px rgba(200,137,74,0.30);
    display: flex; align-items: center; justify-content: center; gap: 0.45rem;
}
.btn-submit:hover { background: #B87838; transform: translateY(-1px); box-shadow: 0 5px 18px rgba(200,137,74,0.38); }
.btn-ghost {
    width: 100%; padding: 0.65rem; margin-top: 0.4rem; background: transparent;
    color: var(--text-muted); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif;

    font-size: 0.78rem; font-weight: 500; cursor: pointer; transition: all var(--transition);
    text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.35rem;
}
.btn-ghost:hover { border-color: var(--caramel); color: var(--caramel); }

/* ── ADDON PILLS ── */
.addon-pills { display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.25rem; }
.addon-pill {
    font-size: 0.65rem; padding: 0.18rem 0.5rem; border-radius: 20px;
    background: var(--accent-lt); color: var(--caramel);
    border: 1px solid rgba(200,137,74,0.15); font-weight: 500;
}

/* ── FULFILLMENT BADGE ── */
.fulfillment-badge {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.71rem;
    font-weight: 600; border: 1px solid;
}
.fulfillment-badge.delivery { background: #EBF3FE; color: #1A3A6B; border-color: #BEDAF5; }
.fulfillment-badge.pickup   { background: #FEF9E8; color: #8A5010; border-color: #F0D090; }
.empty-state { padding: 2rem; text-align: center; color: var(--text-muted); font-size: 0.83rem; }
.empty-state a { color: var(--caramel); text-decoration: none; }

/* Time select compact */
#needed_time {
    max-height: 38px;
    appearance: auto;
    cursor: pointer;
    font-size: 0.85rem;
    padding: 0.6rem 0.85rem;
}
#needed_time:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: var(--border);
}
</style>
@endpush

@section('content')


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

    {{-- ── LEFT COLUMN ── --}}
    <div>

        {{-- CAKE DESIGN --}}
        <div class="card">
            <div class="card-header">
     
                <h3>Your Cake Design</h3>
            </div>

            @if(!empty($config))
                <div class="config-chips-row">
                    @foreach($config as $key => $val)
                        @php
                            $skipKeys = ['addons','total','roundSize','placedFruits','placedFerrero','placedKitkat','placedOreo','placedBarShard','placedCandles','frostings','hasDrip','hasIcing','icingColor','numberDigits','numberChoice','numberTens','numberUnits','ferreroCount','kitkatCount','oreoCount'];
                        @endphp
                        @if(!empty($val) && !is_bool($val) && !in_array($key, $skipKeys))
                        <div class="chip">
                      @php
$chipLabels = [
    'shape'             => 'Shape',
    'shapeLabel'        => 'Size',
    'flavor'            => 'Flavor',
    'frosting'          => 'Frosting',
    'frostings'         => 'Frosting',
    'kitkatOrientation' => 'KitKat',
    'kitKatOrientation' => 'KitKat',
    'oreoOrientation'   => 'Oreo',
    'size'              => 'Size',
   'layers'            => 'Layers',
    'color'             => 'Color',
];
@endphp
<span class="chip-key">{{ $chipLabels[$key] ?? ucfirst($key) }}</span>
                          {{ is_array($val) ? implode(', ', array_filter(array_map(fn($v) => is_scalar($v) ? (string)$v : null, $val))) : (string)$val }}
                        </div>
                        @endif
                    @endforeach
                    @if(!empty($config['addons']))
                    <div class="chip">
                        <span class="chip-key">Add-ons</span>
                        {{ implode(', ', (array)$config['addons']) }}
                    </div>
                    @endif
                </div>

                <div class="config-details">
                    @foreach(['shape','flavor','frosting'] as $key)
                        @if(!empty($config[$key]))
                        <div class="config-item">
                            <div class="config-label">{{ ucfirst($key) }}</div>
                            <div class="config-value">{{ $config[$key] }}</div>
                        </div>
                        @endif
                    @endforeach
                </div>

                @if(!empty($config['total']))
                <div class="price-banner">
                    <div>
                        <div class="price-banner-label">Estimated Price</div>
                        <div class="price-banner-sub">Based on your selections</div>
                    </div>
                  <div class="price-banner-amount"><span class="peso">₱</span>{{ number_format($config['total'], 0) }}</div>

                </div>
                @endif
            @else
                <div class="empty-state">
                    No configuration found. <a href="{{ route('customer.cake-builder.index') }}">Go to Cake Builder →</a>
                </div>
            @endif
        </div>

  {{-- FULFILLMENT + DATE + MAP ── --}}
        <div class="card">

    
            {{-- DATE ── --}}
            <div class="form-section">
                <div class="section-heading">
                   <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg></span> <span id="date-heading-text">When do you need the</span> cake ready?
                </div>
            <div class="form-group">
<div style="display:grid; grid-template-columns:1fr 1fr; gap:0.65rem;">
    <div class="form-group" style="margin-bottom:0;">
        <label for="delivery_date">Pick a Date *</label>
        <input type="date" id="delivery_date" name="delivery_date"
               class="form-control @error('delivery_date') is-invalid @enderror"
               value="{{ old('delivery_date') }}"
               min="{{ now()->format('Y-m-d') }}"
               onchange="checkRush(this.value)" required>
        @error('delivery_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group" style="margin-bottom:0;">
        <label for="needed_time">Time Needed *</label>
 <input type="hidden" id="needed_time" name="needed_time" value="{{ old('needed_time') }}" required>
  <div id="time-picker-wrap" style="position:relative;">
      <div id="time-display" class="form-control" style="cursor:pointer; display:flex; align-items:center; justify-content:space-between; user-select:none;" onclick="toggleTimePicker()">
          <span id="time-display-text" style="color:var(--text-muted);">Pick a date first</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div id="time-dropdown" style="display:none; position:absolute; top:calc(100% + 4px); left:0; right:0;
           background:white; border:1.5px solid var(--caramel); border-radius:10px; z-index:500;
           box-shadow:0 8px 24px rgba(44,26,14,0.12); overflow:hidden;">
          <div id="time-slots" style="display:grid; grid-template-columns: repeat(4,1fr); gap:2px; padding:6px; max-height:220px; overflow-y:auto;"></div>
      </div>
  </div>
  <p class="hint" id="time-hint" style="margin-top:0.3rem;"></p>
        @error('needed_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>


           <div id="rush-banner" style="display:none; background:linear-gradient(135deg,#1A0A00,#3B1F0F);
                         border:1.5px solid #C8893A; border-radius:12px; padding:0.85rem 1rem;
                         margin-top:0.75rem; align-items:center; gap:0.75rem;">
                     <span style="flex-shrink:0;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E8A94A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></span>
                        <div style="flex:1;">
                            <div style="font-weight:700;font-size:0.85rem;color:#E8A94A;">Rush Order — Bakers Compete for You!</div>
                            <div style="font-size:0.73rem;color:rgba(255,255,255,0.55);margin-top:0.1rem;line-height:1.5;">
                                Nearby rush bakers will submit their prices (including rush fee).
                            </div>
                            <div style="margin-top:0.6rem;display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                            <span style="font-size:0.68rem;background:rgba(200,137,58,0.2);border:1px solid rgba(200,137,58,0.4);color:#E8C07A;padding:0.15rem 0.55rem;border-radius:20px;font-weight:600;display:inline-flex;align-items:center;gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg> Needed: <span id="rush-needed-time">—</span></span>
<span style="font-size:0.68rem;background:rgba(200,137,58,0.2);border:1px solid rgba(200,137,58,0.4);color:#E8C07A;padding:0.15rem 0.55rem;border-radius:20px;font-weight:600;display:inline-flex;align-items:center;gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> By: <span id="rush-needed-clock">—</span></span>
                          
                            </div>
                        </div>
                    </div>
                    @error('delivery_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- MAP ── --}}
                <div id="delivery-section">
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Preferred delivery location (if delivery is chosen later) *</label>
                        <div class="map-search-wrap">
                        <span class="map-search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9C8070" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></span>
                            <input type="text" id="map-search" class="form-control"
                                   placeholder="Search for your street, barangay, or landmark…"
                                   autocomplete="off">
                        </div>
                    <div class="map-instruction">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9C8070" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 13-8 13s-8-7-8-13a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg> <span>Search or <strong>click the map</strong> to drop a pin. Drag to fine-tune.</span>
                        </div>
                        <div id="delivery-map"></div>
                        <div class="selected-address-display" id="address-display">
                          <span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D6A30" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                            <div class="addr-text" id="address-text">—</div>
                        </div>
                        @error('delivery_address')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                        @error('delivery_lat')<div class="invalid-feedback" style="display:block;">Please drop a pin to set your delivery location.</div>@enderror
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- ── RIGHT: STICKY SUMMARY + BUDGET + CUSTOMIZATION ── --}}
    <div class="sidebar-col">
        <div class="submit-card">

            {{-- ORDER SUMMARY ── --}}
            <div class="submit-top">
                <div class="submit-top-label">Order Summary</div>
                <h3>Review before submitting</h3>
            </div>
            <div class="submit-body">
                <div class="sum-row">
                    <span class="key">Shape</span>
                    <span class="val">{{ $config['shapeLabel'] ?? $config['shape'] ?? '—' }}</span>
                </div>
                <div class="sum-row">
                    <span class="key">Flavour</span>
                    <span class="val">{{ $config['flavor'] ?? '—' }}</span>
                </div>
                <div class="sum-row">
                    <span class="key">Frosting</span>
                    <span class="val">{{ $config['frosting'] ?? '—' }}</span>
                </div>
                @if(!empty($config['addons']))
                <div class="sum-row" style="flex-direction:column; align-items:flex-start; gap:0.35rem;">
                    <span class="key">Add-ons</span>
                    <div class="addon-pills">
                        @foreach((array)$config['addons'] as $addon)
                        <span class="addon-pill">{{ $addon }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            <div class="sum-row">
                    <span class="key">Fulfillment</span>
                    <span class="val" id="sidebar-fulfillment">
                        <span class="fulfillment-badge delivery" id="sidebar-ft-badge" style="display:inline-flex;align-items:center;gap:0.35rem;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> Delivery</span>
                    </span>
                </div>
           
                <div class="sum-total">
                    <span class="lbl">Est. Total</span>
                <span class="amount"><span class="peso">₱</span>{{ number_format($config['total'] ?? 0, 0) }}</span>

                </div>
            </div>

            {{-- BUDGET ── --}}
            <div class="sidebar-form-section">
              <div class="sidebar-section-heading"><span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v2"/><path d="M12 16v2"/><path d="M9 9.5A2.5 2.5 0 0 1 14.5 12a2.5 2.5 0 0 1-5 1"/></svg></span> Budget Range *</div>
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

            {{-- CUSTOMIZATION ── --}}
            <div class="sidebar-form-section">
             <div class="sidebar-section-heading"><span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></span> Customization</div>

                <div class="form-group">
                    <label>Message on Cake</label>
                    <input type="text" name="custom_message" class="form-control"
                           value="{{ old('custom_message') }}"
                           placeholder='"Happy Birthday, Maria! 🎉"'>
                </div>

                <div class="form-group">
                    <label>Reference Image <span style="font-weight:400;text-transform:none;letter-spacing:0;font-size:0.68rem;color:var(--text-muted);">(optional)</span></label>
                    <input type="file" name="reference_image"
                           class="form-control @error('reference_image') is-invalid @enderror"
                           accept="image/*">
                    <p class="hint">Upload a photo for inspiration. Max 5MB.</p>
                    @error('reference_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Special Instructions</label>
                    <textarea name="special_instructions" class="form-control" rows="3"
                              placeholder="Birthday cake but i want it like this..">{{ old('special_instructions') }}</textarea>
                </div>
            </div>

            {{-- SUBMIT ── --}}
            <div class="sidebar-form-section" style="padding-top:0.75rem;">
<button type="button" class="btn-submit" id="submit-btn" onclick="openSubmitModal()">                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Submit to Bakers
                </button>
                <a href="{{ route('customer.cake-builder.index') }}" class="btn-ghost">← Edit Design</a>
            </div>

        </div>
    </div>

</div>
</form>
<div class="submit-modal-backdrop" id="submitModal">
    <div class="submit-modal">

        {{-- Header changes based on rush --}}
      <div class="smodal-header" id="smodal-header-normal" style="background:linear-gradient(135deg, #3B1F0F 0%, #7A4A28 100%); display:flex; flex-direction:row; align-items:center; gap:1rem;">
        <div class="smodal-header-icon" style="flex-shrink:0;"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div>
        <div>
            <div class="smodal-title">Submit Your Request?</div>
            <div class="smodal-subtitle">Your order will be posted to available bakers who will send you their best offers.</div>
        </div>
      </div>
       <div class="smodal-header" id="smodal-header-rush" style="background:linear-gradient(135deg,#1A0A00,#5C3010); display:none; flex-direction:row; align-items:center; gap:1rem;">
            <div class="smodal-header-icon" style="flex-shrink:0;"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
            <div>
                <div class="smodal-title">Rush Order — Submit?</div>
                <div class="smodal-subtitle">The nearest available baker will be auto-matched and assigned instantly.</div>
            </div>
        </div>

      <div class="smodal-body">

            {{-- Normal note --}}
            <div class="smodal-note" id="smodal-note-normal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><path d="M16.5 9.4 7.55 4.24"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg>
                <span>You'll choose <strong>delivery or pickup</strong> when you accept a baker's bid — no need to decide now!</span>
            </div>

            {{-- Rush note --}}
            <div class="smodal-note" id="smodal-note-rush" style="display:none; background:#FEF3E8; border-color:rgba(200,137,74,0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <span>Nearby rush bakers will be notified. Each submits their own price + rush fee. You have <strong>60 seconds</strong> to pick the best offer.</span>
            </div>

            <div class="smodal-summary">
                <div class="smodal-sum-row">
                    <span class="smodal-sum-key">Cake</span>
                    <span class="smodal-sum-val">{{ ($config['flavor'] ?? '—') }} · {{ ($config['shapeLabel'] ?? $config['shape'] ?? '—') }}</span>
                </div>
                <div class="smodal-sum-row">
                    <span class="smodal-sum-key">Frosting</span>
                    <span class="smodal-sum-val">{{ $config['frosting'] ?? '—' }}</span>
                </div>
                @if(!empty($config['addons']))
                <div class="smodal-sum-row">
                    <span class="smodal-sum-key">Add-ons</span>
                    <span class="smodal-sum-val" style="font-size:0.75rem;">{{ implode(', ', (array)$config['addons']) }}</span>
                </div>
                @endif
                <div class="smodal-sum-row full-width" id="smodal-date-row">
                    <span class="smodal-sum-key">Date Needed</span>
                    <span class="smodal-sum-val" id="smodal-date-val" style="color:#C8893A;">—</span>
                </div>
                <div class="smodal-sum-row full-width" id="smodal-time-row" style="display:none;">
                    <span class="smodal-sum-key">Time Needed</span>
                    <span class="smodal-sum-val" id="smodal-time-val" style="color:#C8893A;">—</span>
                </div>
                <div class="smodal-sum-row full-width">
                    <span class="smodal-sum-key">Budget</span>
                    <span class="smodal-sum-val" id="smodal-budget-val">
                        ₱<span id="smodal-budget-min">{{ number_format($config['total'] ?? 0, 0) }}</span>
                        – ₱<span id="smodal-budget-max">{{ number_format(round(($config['total'] ?? 0) * 1.3), 0) }}</span>
                    </span>
                </div>
                {{-- Rush badge row --}}
                <div class="smodal-sum-row full-width" id="smodal-rush-row" style="display:none;">
                    <span class="smodal-sum-key">Type</span>
                    <span class="smodal-sum-val" style="color:#C8893A; font-weight:700;display:inline-flex;align-items:center;gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Order</span>
                </div>
                {{-- Normal total --}}
                <div class="smodal-sum-row full-width" id="smodal-normal-total-row">
                    <span class="smodal-sum-key">Est. Total</span>
                    <span class="smodal-sum-val price">₱{{ number_format($config['total'] ?? 0, 0) }}</span>
                </div>
                {{-- Rush price breakdown --}}
                <div id="smodal-rush-breakdown" style="display:none; grid-column: 1 / -1;">
                    <div class="smodal-sum-row full-width" style="border-right:none;">
                        <span class="smodal-sum-key">Cake Price</span>
                        <span class="smodal-sum-val">₱{{ number_format($config['total'] ?? 0, 0) }}</span>
                    </div>
                    <div class="smodal-sum-row full-width" style="border-right:none;">
                        <span class="smodal-sum-key" style="color:#C8893A;display:inline-flex;align-items:center;gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Fee</span>
                        <span class="smodal-sum-val" style="color:#C8893A;">+ set by each baker</span>
                    </div>
                    <div class="smodal-sum-row full-width" style="border-top:1.5px solid #EAE0D0; border-right:none; margin-top:2px; padding-top:4px;">
                        <span class="smodal-sum-key" style="font-size:0.72rem;">Est. Total</span>
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
        html: `<div style="width:18px;height:18px;background:#C8894A;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(200,137,74,0.6);"></div>`,
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
    dropdown.style.cssText = 'position:absolute;top:100%;left:0;right:0;background:white;border:1.5px solid #EDE5DA;border-radius:10px;box-shadow:0 8px 24px rgba(44,26,14,0.10);z-index:1000;margin-top:4px;max-height:200px;overflow-y:auto;display:none;';
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
                        dropdown.innerHTML = '<div style="padding:0.75rem 1rem;font-size:0.78rem;color:#9B8070;">No results found</div>';
                        dropdown.style.display = 'block';
                        return;
                    }
                    results.forEach(place => {
                        const item = document.createElement('div');
                        item.style.cssText = 'padding:0.65rem 1rem;font-size:0.78rem;cursor:pointer;border-bottom:1px solid #F5EDE8;color:#1A0F08;transition:background 0.15s;';
                        item.textContent = place.display_name;
                        item.addEventListener('mouseenter', () => item.style.background = '#FEF3E8');
                        item.addEventListener('mouseleave', () => item.style.background = 'white');
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
        let minH = phNow.getHours() + 5;
        let minM = phNow.getMinutes();
        if (minM === 0 || minM === 30) { /* on slot */ }
        else if (minM < 30) minM = 30;
        else { minM = 0; minH++; }
        if (minH >= 24) minH -= 24;
        const minMins = minH * 60 + minM;

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
                    padding:0.3rem 0.2rem; border-radius:6px; border:1px solid var(--border);
                    background:${val === oldVal ? 'var(--caramel)' : 'var(--cream)'};
                    color:${val === oldVal ? 'white' : 'var(--text-dark)'};
                    font-size:0.68rem; font-weight:600; cursor:pointer;
                    font-family:'Plus Jakarta Sans',sans-serif;
                    transition:all 0.15s; white-space:nowrap;
                `;
                btn.addEventListener('mouseenter', () => { if (btn.dataset.val !== timeInput.value) btn.style.background = '#FEF3E8'; });
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
            timeHint.textContent = `⏱ Earliest available: ${formatSlotLabel(minH, minM)} (5 hrs from now)`;
            timeHint.style.color = '#C8894A';
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
            b.style.background = active ? 'var(--caramel)' : 'var(--cream)';
            b.style.color = active ? 'white' : 'var(--text-dark)';
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

function openSubmitModal() {
    const isRush = document.getElementById('is_rush_input').value === '1';

    // Swap header
    document.getElementById('smodal-header-normal').style.display = isRush ? 'none' : 'flex';
    document.getElementById('smodal-header-rush').style.display   = isRush ? 'flex' : 'none';

    // Swap note
    document.getElementById('smodal-note-normal').style.display = isRush ? 'none' : 'block';
    document.getElementById('smodal-note-rush').style.display   = isRush ? 'block' : 'none';

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
    // timeVal is already HH:MM from the select
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
</script>
@endpush