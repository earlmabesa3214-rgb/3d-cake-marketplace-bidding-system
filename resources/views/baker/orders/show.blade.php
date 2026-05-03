@extends('layouts.baker')
@section('title', 'Order #' . str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --brown-deep:   #3B1F0F;
    --brown-mid:    #7A4A28;
    --caramel:      #C8893A;
    --caramel-light:#E8A94A;
    --warm-white:   #FFFDF9;
    --cream:        #F5EFE6;
    --border:       #EAE0D0;
    --text-dark:    #2C1A0E;
    --text-mid:     #6B4A2A;
    --text-muted:   #9A7A5A;
    --shadow-lg:    0 8px 32px rgba(59,31,15,0.12);
}

@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; } 

.order-wrap {
    padding: 0;
}

.back-link {
    display: inline-flex; align-items: center; gap: 0.4rem;
    font-size: 0.82rem; color: var(--text-muted); text-decoration: none;
    margin-bottom: 1.25rem; transition: color 0.2s;
}
.back-link:hover { color: var(--caramel); }

/* ── HERO ── */
.order-hero {
    border-radius: 20px;
    padding: 2rem 2.5rem;
    margin-bottom: 1.75rem;
    color: white;
    position: relative;
    overflow: hidden;
    width: 100%;
}
.order-hero::before {
    content: ''; position: absolute;
    right: -40px; top: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.order-hero.s-ACCEPTED,
.order-hero.s-WAITING_FOR_PAYMENT,
.order-hero.s-PREPARING,
.order-hero.s-READY,
.order-hero.s-WAITING_FINAL_PAYMENT,
.order-hero.s-DELIVERED,
.order-hero.s-COMPLETED            { background: linear-gradient(135deg, #3B1F0F, #6A3518); }
.order-hero.s-CANCELLED            { background: linear-gradient(135deg, #5A1A1A, #8B2A2A); }

.hero-top {
    display: flex; justify-content: space-between; align-items: flex-start;
    position: relative; z-index: 1; margin-bottom: 1.75rem;
}
.hero-id    { font-size: 0.68rem; letter-spacing: 0.2em; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.3rem; }
.hero-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.6rem; font-weight: 800; line-height: 1.2; }
.hero-sub   { font-size: 0.82rem; opacity: 0.65; margin-top: 0.25rem; }
.status-badge {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.45rem 1rem; border-radius: 20px;
    background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
    font-size: 0.78rem; font-weight: 700; white-space: nowrap;
}

/* ── PROGRESS BAR ── */
.progress-row { display: flex; align-items: center; position: relative; z-index: 1; }
.p-step { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.4rem; position: relative; }
.p-step::after {
    content: ''; position: absolute; top: 13px; left: 50%;
    width: 100%; height: 2px; background: rgba(255,255,255,0.2); z-index: 0;
}
.p-step:last-child::after { display: none; }
.p-dot {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700; position: relative; z-index: 1;
    border: 2px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.5); transition: all 0.3s;
}
.p-dot.done   { background: rgba(255,255,255,0.9); color: var(--brown-mid); border-color: white; }
.p-dot.active { background: white; color: var(--brown-deep); border-color: white; box-shadow: 0 0 0 6px rgba(255,255,255,0.2); }
.p-label { font-size: 0.58rem; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.5; text-align: center; font-weight: 600; line-height: 1.3; }
.p-label.active { opacity: 1; font-weight: 700; }
.p-label.done   { opacity: 0.8; }

/* ── MAIN LAYOUT ── */
.order-page-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.5rem;
    align-items: start;
}
.order-sidebar-col {
    position: sticky;
    top: 5rem;
}

/* ── CARD ── */
.card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    width: 100%;
}
.card:last-child { margin-bottom: 0; }
.card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
}
.card-header h3 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.95rem; font-weight: 700; color: var(--brown-deep); margin: 0;
}

/* ── INFO ROW ── */
.info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 0.8rem 1.5rem; border-bottom: 1px solid var(--border); gap: 1rem;
}
.info-row:last-child { border-bottom: none; }
.i-key { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600; }
.i-val { font-size: 0.86rem; font-weight: 500; color: var(--text-dark); text-align: right; }

/* ── PAYMENT STATUS CARD ── */
.payment-status-card {
    background: var(--warm-white);
    border: 2px solid #EDD090;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    margin-bottom: 1.5rem;
    width: 100%;
}
.payment-status-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--caramel), var(--caramel-light), var(--caramel));
}
.psc-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #EDD090;
    display: flex; align-items: center; gap: 0.75rem;
}
.psc-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-light));
    border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.psc-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem; color: var(--brown-deep); font-weight: 700; }
.psc-sub   { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.1rem; }

.pay-split { display: flex; align-items: center; padding: 1rem 1.5rem; gap: 0; }
.pay-half  { flex: 1; text-align: center; padding: 0.85rem; border-radius: 12px; }
.pay-half.paid     { background: #FBF3E8; border: 1px solid #EDD090; }
.pay-half.pending  { background: #FEF9ED; border: 1px solid #EDD090; }
.pay-half.locked   { background: #F8F5F0; border: 1px solid var(--border); }
.pay-half.rejected { background: #FDF0EE; border: 1px solid #F5C5BE; }
.pay-label  { font-size: 0.62rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); }
.pay-amount { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.2rem; font-weight: 800; color: var(--brown-deep); margin: 0.25rem 0; }
.pay-status { font-size: 0.72rem; font-weight: 600; }
.pay-status.paid     { color: var(--caramel); }
.pay-status.pending  { color: #9B6A10; }
.pay-status.locked   { color: #aaa; }
.pay-status.rejected { color: #8B2A1E; }
.pay-divider { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 0 0.75rem; }
.pay-divider-line { width: 1px; height: 18px; background: var(--border); }

/* ── ACTION AREA — compact, inline buttons ── */
.action-area {
    padding: 1rem 1.5rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
}
.btn-advance {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
    padding: 0.55rem 1.2rem;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-light));
    color: white; border: none; border-radius: 10px;
    font-size: 0.82rem; font-weight: 700;
    cursor: pointer;font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 2px 8px rgba(200,137,58,0.28);
    transition: all 0.2s; text-decoration: none;
}
.btn-advance:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(200,137,58,0.4); color: white; }
.btn-confirm-pay {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
    padding: 0.55rem 1.2rem;
    background: linear-gradient(135deg, #3B1F0F, #6A3518);
    color: white; border: none; border-radius: 10px;
    font-size: 0.82rem; font-weight: 700;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 2px 8px rgba(59,31,15,0.28);
    transition: all 0.2s;
}
.btn-confirm-pay:hover { transform: translateY(-1px); }
.btn-reject-proof {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: #FDF0EE; color: #8B2A1E;
    border: 1.5px solid #F5C5BE; border-radius: 10px;
    font-size: 0.78rem; font-weight: 700;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-reject-proof:hover { background: #F5C5BE; border-color: #C44030; }
.btn-secondary {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem;
    padding: 0.5rem 1rem;
    background: transparent; color: var(--text-muted);
    border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 0.78rem; font-weight: 600;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s; text-decoration: none;
}
.btn-secondary:hover { border-color: var(--caramel); color: var(--caramel); }
.action-note {
    font-size: 0.72rem; color: var(--text-muted);
    line-height: 1.5; width: 100%; margin: 0;
}

/* ── ALERT ── */
.alert {
    display: flex; align-items: flex-start; gap: 0.75rem;
    border-radius: 12px; padding: 0.9rem 1.25rem;
    margin-bottom: 1.25rem; font-size: 0.84rem;
}
.alert.success { background: #FBF3E8; border: 1px solid #EDD090; color: var(--brown-deep); }
.alert.error   { background: #F8EDEA; border: 1px solid #DDB5A8; color: #8B2A1E; }
.alert.warning { background: #FEF9ED; border: 1px solid #EDD090; color: #8A5010; }
.alert-icon { font-size: 1.2rem; flex-shrink: 0; }
.alert-body { font-weight: 600; }

/* ── SIDEBAR ID CARD ── */
.id-card {
    background: linear-gradient(135deg, var(--brown-deep), var(--brown-mid));
    border-radius: 20px; padding: 1.75rem 1.5rem;
    text-align: center; margin-bottom: 1.5rem; color: white;
}
.id-label { font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; opacity: 0.45; margin-bottom: 0.3rem; }
.id-num   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2.5rem; font-weight: 800; color: var(--caramel-light); line-height: 1; }
.id-divider { border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 1rem 0; }
.id-sub   { font-size: 0.75rem; opacity: 0.6; margin-bottom: 0.3rem; }
.id-val   { font-size: 0.9rem; font-weight: 700; color: white; }

/* Config grid */
.config-grid { display: grid; grid-template-columns: 1fr 1fr; }
.config-item {
    padding: 0.8rem 1.4rem;
    border-bottom: 1px solid var(--border);
    border-right: 1px solid var(--border);
}
.config-item:nth-child(even) { border-right: none; }
.config-item:nth-last-child(-n+2) { border-bottom: none; }
.c-label { font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-muted); font-weight: 600; margin-bottom: 0.2rem; }
.c-value { font-size: 0.86rem; font-weight: 600; color: var(--brown-deep); }

/* Timeline */
.timeline-log { list-style: none; padding: 0; margin: 0; }
.timeline-log li {
    padding: 0.8rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex; gap: 0.75rem; font-size: 0.8rem;
}
.timeline-log li:last-child { border-bottom: none; }
.log-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--caramel); flex-shrink: 0; margin-top: 0.25rem; }
.log-event { font-weight: 600; color: var(--text-dark); }
.log-time  { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.1rem; }

/* Baker payment methods */
.bpm-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.bpm-item:last-child { border-bottom: none; }
.bpm-type { font-weight: 700; font-size: 0.86rem; color: var(--brown-deep); display: flex; align-items: center; gap: 0.5rem; }
.bpm-details { text-align: right; font-size: 0.78rem; color: var(--text-muted); }
.bpm-details strong { color: var(--text-dark); display: block; font-size: 0.84rem; }

/* Proof section */
.proof-section {
    padding: 1rem 1.5rem;
    border-top: 1px solid #EDD090;
}
.proof-section.proof-rejected {
    border-top-color: #F5C5BE;
    background: #FDF5F3;
}
.proof-section-label {
    font-size: 0.68rem; text-transform: uppercase;
    letter-spacing: 0.1em; color: var(--text-muted);
    font-weight: 600; margin-bottom: 0.6rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.proof-section-label .label-badge {
    padding: 0.1rem 0.45rem; border-radius: 4px;
    font-size: 0.62rem; font-weight: 700; letter-spacing: 0.05em;
}
.label-badge.rejected { background: #F5C5BE; color: #8B2A1E; }
.label-badge.pending  { background: #FEF9ED; color: #9B6A10; }
.label-badge.confirmed{ background: #EBF5EE; color: #166534; }
.proof-img-full {
    width: 100%; max-height: 220px; object-fit: contain;
    border-radius: 10px; border: 1px solid var(--border); background: #f5f5f5;
}
.proof-img-full.dimmed { opacity: 0.5; border: 2px dashed #F5C5BE; }
.proof-meta-row {
    margin-top: 0.6rem; display: flex; gap: 1rem;
    font-size: 0.75rem; color: var(--text-muted); flex-wrap: wrap;
}

/* Rejection reason display */
.rejection-reason-box {
    margin-top: 0.75rem;
    padding: 0.75rem 1rem;
    background: #FDF0EE; border: 1.5px solid #F5C5BE; border-radius: 10px;
}
.rejection-reason-box .rr-label {
    font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.1em;
    color: #8B2A1E; font-weight: 700; margin-bottom: 0.25rem;
}
.rejection-reason-box .rr-text {
    font-size: 0.84rem; font-weight: 600; color: #5A1A1A;
}
.rejection-reason-box .rr-note {
    font-size: 0.76rem; color: #7A2A20; margin-top: 0.3rem; font-style: italic; line-height: 1.5;
}

/* Waiting state box */
.waiting-box {
    border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 0.5rem; width: 100%;
}
.waiting-box.has-proof { background: #FEF9ED; border: 1.5px solid #EDD090; }
.waiting-box.no-proof  { background: #F8F5F0; border: 1.5px solid var(--border); }
.waiting-box .w-icon { font-size: 1.2rem; margin-bottom: 0.2rem; }
.waiting-box .w-title { font-weight: 700; font-size: 0.82rem; }
.waiting-box.has-proof .w-title { color: #8A5010; }
.waiting-box.no-proof  .w-title { color: var(--text-muted); }
.waiting-box .w-sub { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.15rem; }

@media (max-width: 900px) { .order-page-grid { grid-template-columns: 1fr; } }

/* ═══════════════════════════════════════════
   CUSTOM CONFIRMATION MODALS
═══════════════════════════════════════════ */
.confirm-modal-backdrop {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(20, 10, 4, 0.65);
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem; opacity: 0; pointer-events: none;
    transition: opacity 0.25s ease;
}
.confirm-modal-backdrop.is-open { opacity: 1; pointer-events: all; }
.confirm-modal {
    background: var(--warm-white); border-radius: 24px; width: 100%; max-width: 400px;
    overflow: hidden; box-shadow: 0 32px 80px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.1);
    transform: translateY(20px) scale(0.96);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.confirm-modal-backdrop.is-open .confirm-modal { transform: translateY(0) scale(1); }
.confirm-modal-header { padding: 2rem 2rem 1.5rem; text-align: center; position: relative; }
.confirm-modal-header.variant-advance  { background: linear-gradient(135deg, #4A2E08, #9A6830); }
.confirm-modal-header.variant-confirm  { background: linear-gradient(135deg, #2A1A08, #6A3A18); }
.confirm-modal-header.variant-complete { background: linear-gradient(135deg, #3B1F0F, #6A3518); }

.confirm-modal-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; margin: 0 auto 1rem;
}
.confirm-modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.25rem; font-weight: 800; color: white; margin-bottom: 0.35rem; line-height: 1.3; }.confirm-modal-subtitle { font-size: 0.78rem; color: rgba(255,255,255,0.65); line-height: 1.5; }
.confirm-modal-body { padding: 1.5rem 2rem; }
.confirm-modal-detail { background: var(--cream); border: 1px solid var(--border); border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
.confirm-modal-detail-row { display: flex; justify-content: space-between; align-items: center; padding: 0.35rem 0; font-size: 0.82rem; }
.confirm-modal-detail-row:not(:last-child) { border-bottom: 1px solid var(--border); margin-bottom: 0.35rem; padding-bottom: 0.5rem; }
.confirm-modal-detail-key { color: var(--text-muted); font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; }
.confirm-modal-detail-val { font-weight: 700; color: var(--brown-deep); font-size: 0.86rem; text-align: right; }
.confirm-modal-note { font-size: 0.76rem; color: var(--text-muted); line-height: 1.6; text-align: center; padding: 0 0.5rem; }
.confirm-modal-footer { display: flex; gap: 0.75rem; padding: 0 2rem 2rem; }
.confirm-modal-btn-cancel {
    flex: 1; padding: 0.75rem 1rem; border-radius: 12px;
    border: 1.5px solid var(--border); background: white; color: var(--text-mid);
    font-size: 0.85rem; font-weight: 600; cursor: pointer;font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.2s;
}
.confirm-modal-btn-cancel:hover { border-color: var(--text-muted); color: var(--text-dark); }
.confirm-modal-btn-ok {
    flex: 2; padding: 0.75rem 1rem; border-radius: 12px; border: none;
    font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.4rem;
}
.confirm-modal-btn-ok:hover { transform: translateY(-1px); }
.confirm-modal-btn-ok:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.confirm-modal-btn-ok.style-advance  { background: linear-gradient(135deg, var(--caramel), var(--caramel-light)); color: white; box-shadow: 0 4px 14px rgba(200,137,58,0.4); }
.confirm-modal-btn-ok.style-advance:hover { box-shadow: 0 6px 20px rgba(200,137,58,0.5); }
.confirm-modal-btn-ok.style-confirm  { background: linear-gradient(135deg, #3B1F0F, #6A3518); color: white; box-shadow: 0 4px 14px rgba(59,31,15,0.4); }
.confirm-modal-btn-ok.style-complete { background: linear-gradient(135deg, #3B1F0F, #6A3518); color: white; box-shadow: 0 4px 14px rgba(59,31,15,0.4); }


/* ── REJECT PAYMENT MODAL ── */
.reject-modal-backdrop {
    position: fixed; inset: 0; z-index: 10000;
    background: rgba(20,8,4,0.7);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem; opacity: 0; pointer-events: none;
    transition: opacity 0.25s ease;
}
.reject-modal-backdrop.is-open { opacity: 1; pointer-events: all; }
.reject-modal {
    background: var(--warm-white); border-radius: 24px; width: 100%; max-width: 460px;
    overflow: hidden; box-shadow: 0 32px 80px rgba(0,0,0,0.3);
    transform: translateY(24px) scale(0.95);
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.reject-modal-backdrop.is-open .reject-modal { transform: translateY(0) scale(1); }
.reject-modal-header { background: linear-gradient(135deg, #5A1A1A, #8B2E2E); padding: 2rem 2rem 1.5rem; text-align: center; }
.reject-modal-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; margin: 0 auto 1rem;
}
.reject-modal-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.2rem; color:white; font-weight:800; margin-bottom:0.25rem; }
.reject-modal-sub   { font-size:0.78rem; color:rgba(255,255,255,0.65); }
.reject-modal-body  { padding: 1.5rem 2rem; }
.reject-warning-box {
    background: #FEF9E8; border: 1.5px solid #F0D090; border-radius: 12px;
    padding: 0.85rem 1rem; margin-bottom: 1.25rem;
    display: flex; align-items: flex-start; gap: 0.6rem;
    font-size: 0.78rem; color: #8A5010; line-height: 1.5;
}
.reject-reasons-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-muted); font-weight: 600; margin-bottom: 0.6rem; }
.reject-reason-list  { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.25rem; }
.reject-reason-item  {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.65rem 1rem; border: 1.5px solid var(--border); border-radius: 10px;
    cursor: pointer; font-size: 0.84rem; color: var(--text-dark);
    background: white; transition: all 0.15s; user-select: none;
}
.reject-reason-item:hover { border-color: #8B2A1E; background: #FDF5F3; }
.reject-reason-item.selected { border-color: #8B2A1E; background: #FDF0EE; color: #5A1A1A; font-weight: 600; }
.reject-reason-radio {
    width: 16px; height: 16px; border-radius: 50%;
    border: 2px solid var(--border); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; transition: all 0.15s;
}
.reject-reason-item.selected .reject-reason-radio { border-color: #8B2A1E; background: #8B2A1E; box-shadow: inset 0 0 0 3px white; }
.reject-note-area {
    width: 100%; padding: 0.75rem 1rem; border: 1.5px solid var(--border); border-radius: 10px;
   font-family: 'Plus Jakarta Sans',sans-serif; font-size: 0.84rem; color: var(--text-dark);
    resize: vertical; min-height: 80px; background: white; transition: border-color 0.2s; box-sizing: border-box;
}
.reject-note-area:focus { outline: none; border-color: #8B2A1E; }
.reject-modal-footer { display: flex; gap: 0.75rem; padding: 0 2rem 2rem; }
.reject-modal-cancel {
    flex: 1; padding: 0.75rem; border-radius: 12px;
    border: 1.5px solid var(--border); background: white; color: var(--text-mid);
    font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans',sans-serif; transition: all 0.2s;
}
.reject-modal-cancel:hover { border-color: var(--text-muted); }
.reject-modal-submit {
    flex: 2; padding: 0.75rem; border-radius: 12px; border: none;
    background: linear-gradient(135deg,#8B2A1E,#C44030); color: white;
    font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: 'Plus Jakarta Sans',sans-serif;
    box-shadow: 0 4px 14px rgba(139,42,30,0.4); transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 0.4rem;
}
.reject-modal-submit:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(139,42,30,0.5); }
.reject-modal-submit:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }

/* Spinner */
@keyframes spin { to { transform: rotate(360deg); } }
.btn-spinner {
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,0.3); border-top-color: white;
    border-radius: 50%; animation: spin 0.7s linear infinite; display: none;
}
.is-loading .btn-spinner { display: block; }
.is-loading .btn-text    { display: none; }
</style>
@endpush

@section('content')

@php
    $statusFlow   = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED'];
    $statusLabels = [
        'ACCEPTED'              => ['icon' => '✓',  'label' => 'Accepted',       'sub' => 'Customer bid accepted'],
   'WAITING_FOR_PAYMENT'   => ['icon' => '', 'dot' => '⏳', 'label' => 'Awaiting Down',  'sub' => 'Waiting for customer downpayment'],
        'PREPARING'             => ['icon' => '🥣', 'label' => 'Preparing',      'sub' => 'Working on the cake'],
        'READY'                 => ['icon' => '📦', 'label' => 'Ready',          'sub' => 'Cake is ready for delivery'],
        'WAITING_FINAL_PAYMENT' => ['icon' => '₱', 'label' => 'Awaiting Final', 'sub' => 'Waiting for final payment'],
        'DELIVERED'             => ['icon' => '🚚', 'label' => 'Delivered',      'sub' => 'Cake delivered'],
        'COMPLETED'             => ['icon' => '', 'label' => 'Completed',      'sub' => 'Order fully completed'],
        'CANCELLED'             => ['icon' => '✕',  'label' => 'Cancelled',      'sub' => 'Order cancelled'],
    ];

    $displayStatus = $order->status === 'COMPLETED' ? 'DELIVERED' : $order->status;
    $currentIdx    = array_search($displayStatus, $statusFlow);
    if ($currentIdx === false) $currentIdx = -1;

    $config = is_array($order->cakeRequest->cake_configuration)
        ? $order->cakeRequest->cake_configuration
        : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);

    $totalAmount       = $order->agreed_price;
    $downpaymentAmount = round($totalAmount * 0.5, 2);
    $finalAmount       = $totalAmount - $downpaymentAmount;

    $downIsPaid      = $downpayment  && $downpayment->status  === 'confirmed';
    $downIsPending   = $downpayment  && $downpayment->status  === 'pending';
    $downIsRejected  = $downpayment  && $downpayment->status  === 'rejected';
    $finalIsPaid     = $finalPayment && $finalPayment->status === 'confirmed';
    $finalIsPending  = $finalPayment && $finalPayment->status === 'pending';
    $finalIsRejected = $finalPayment && $finalPayment->status === 'rejected';

    $info = $statusLabels[$order->status] ?? $statusLabels['ACCEPTED'];

    $isPickup = $order->cakeRequest->isPickup();

    if ($isPickup) {
        $statusLabels['WAITING_FINAL_PAYMENT']['label'] = 'Pickup Pay';
        $statusLabels['WAITING_FINAL_PAYMENT']['icon']  = '';
        $statusLabels['DELIVERED']['label'] = 'Collected';
        $statusLabels['DELIVERED']['icon']  = '';
    }

    $rejectionReasons = \App\Models\Payment::REJECTION_REASONS;
@endphp

<div class="order-wrap">

<a href="{{ route('baker.orders.index') }}" class="back-link">← All Orders</a>


    @if(session('error'))
    <div class="alert error">
        <span class="alert-icon">⚠️</span>
        <div><div class="alert-body">{{ session('error') }}</div></div>
    </div>
    @endif

  {{-- ── HERO ── --}}
    @php
        $heroTitle = $info['icon'] . ' ' . $info['label'];
        $heroSub   = $isPickup ? ' Pickup order — customer will collect and pay cash on pickup' : $info['sub'];
        if ($order->status === 'WAITING_FINAL_PAYMENT' && $finalEscrow === 'held') {
            $heroTitle = 'Out for Delivery';
            $heroSub   = 'Payment secured — deliver the cake. Your payment releases once the customer confirms receipt.';
        }
    @endphp
    <div class="order-hero s-{{ $order->status }}">
        <div class="hero-top">
            <div>
          <div class="hero-id">Order #{{ str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="hero-title">{{ $heroTitle }}</div>
                <div class="hero-sub">{{ $heroSub }}</div>
            </div>
            <div class="status-badge">
                @if($isPickup)<span style="font-size:0.75rem;"></span>@endif
                {{ str_replace('_', ' ', $order->status) }}
            </div>
        </div>

        @if($order->status !== 'CANCELLED')
        <div class="progress-row">
            @foreach($statusFlow as $i => $st)
            @php
                $isDone   = $i < $currentIdx;
                $isActive = $i === $currentIdx;
                $sl       = $statusLabels[$st] ?? [];
            @endphp
            <div class="p-step">
                <div class="p-dot {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
               {{ $isDone ? '✓' : ($sl['dot'] ?? $sl['icon'] ?? $i+1) }}
                </div>
                <div class="p-label {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                    {{ $sl['label'] ?? $st }}
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── TWO-COLUMN LAYOUT ── --}}
    <div class="order-page-grid">

        {{-- ════════════════ LEFT COLUMN ════════════════ --}}
        <div>



            {{-- ── ACTIONS CARD (all states except ACCEPTED/COMPLETED/CANCELLED/DELIVERED) ── --}}
            @if(!in_array($order->status, ['ACCEPTED','COMPLETED','CANCELLED','DELIVERED']))
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Actions</h3></div>
                <div class="action-area">

               @if($order->status === 'WAITING_FOR_PAYMENT')
    <div style="width:100%; background:#FEF9E8; border:1.5px solid #F0D090; border-radius:12px; padding:1rem 1.25rem;">
    
        <div style="font-weight:700; font-size:0.85rem; color:#8A5010; margin-bottom:0.25rem;">Waiting for Customer Downpayment</div>
        <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.6;">We will notify you once the customer has sent their downpayment. No action needed on your end right now — just sit tight!</div>
    </div>
 

   @elseif($order->status === 'PREPARING')
                        <form id="form-mark-ready" method="POST" action="{{ route('baker.orders.advance', $order->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="cake_final_photo" id="form-mark-ready-photo" accept="image/*" style="display:none;">
                        </form>
                        <div style="width:100%; background:#FBF4EC; border:1.5px solid #D4B896; border-radius:12px; padding:1rem 1.25rem; margin-bottom:0.25rem;">
                            <div style="font-size:1.2rem; margin-bottom:0.4rem;">🥣</div>
                            <div style="font-weight:700; font-size:0.85rem; color:var(--brown-deep); margin-bottom:0.25rem;">You can start preparing now!</div>
                            <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.6;">The customer's downpayment has been confirmed. Start crafting the cake and click the button below when it's ready.</div>
                        </div>
                       <button type="button" class="btn-advance"
                            onclick="openConfirmModal('modal-mark-ready')">
                            📦 Mark as Ready for {{ $isPickup ? 'Pickup' : 'Delivery' }}
                        </button>
                        <p class="action-note">Upload a photo of your finished cake and notify your customer.</p>

           @elseif($order->status === 'READY')
                        @if($isPickup)
                        <form id="form-request-final" method="POST" action="{{ route('baker.orders.advance', $order->id) }}">
                            @csrf
                        </form>
                        <div style="width:100%; background:#FEF9E8; border:1.5px solid #F0D090; border-radius:12px; padding:1rem 1.25rem;">
                            <div style="font-size:1.2rem; margin-bottom:0.4rem;"></div>
                            <div style="font-weight:700; font-size:0.85rem; color:#8A5010; margin-bottom:0.25rem;">Customer Notified — Waiting for Pickup</div>
                            <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.6;">The customer has been notified that their cake is ready. Wait for them to arrive at your location with <strong>₱{{ number_format(round($order->agreed_price * 0.5, 2), 2) }}</strong> cash.</div>
                        </div>
                       
                        @else
                        <form id="form-request-final" method="POST" action="{{ route('baker.orders.advance', $order->id) }}">
                            @csrf
                        </form>
                        <div style="width:100%; background:#FEF9E8; border:1.5px solid #F0D090; border-radius:12px; padding:1rem 1.25rem;">
                    
                            <div style="font-weight:700; font-size:0.85rem; color:#8A5010; margin-bottom:0.25rem;">Cake is ready — waiting for final payment</div>
                            <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.6;">Your customer has been notified that their cake is ready. Once they complete the final payment, you'll be prompted to confirm delivery. No action needed from you right now!</div>
                        </div>
                      
                        @endif

                    @elseif($order->status === 'WAITING_FINAL_PAYMENT')
                        @if($isPickup)
                            <div class="waiting-box has-proof" style="background:#FEF9E8; border-color:#F0D090; width:100%;">
                                <div class="w-icon"></div>
                                <div class="w-title" style="color:#8A5010;">Waiting for customer to arrive</div>
                                <div class="w-sub">When the customer arrives and pays cash, click below to complete the order.</div>
                            </div>
                            <form id="form-confirm-final" method="POST" action="{{ route('baker.orders.confirm-final-payment', $order->id) }}">
                                @csrf
                            </form>
                            <div style="background:#FEF9E8; border:1px solid #F0D090; border-radius:8px; padding:0.5rem 0.85rem; font-size:0.73rem; color:#8A5010; width:100%;">
                                Cash amount: <strong>₱{{ number_format(round($order->agreed_price * 0.5, 2), 2) }}</strong>
                            </div>
                            <button type="button" class="btn-confirm-pay"
                                onclick="openConfirmModal('modal-confirm-final')">
                                💵 Confirm Cash & Complete
                            </button>
                   @elseif($finalIsPending)
    <form id="form-confirm-final" method="POST" action="{{ route('baker.orders.confirm-final-payment', $order->id) }}">
        @csrf
    </form>
    @if($finalEscrow === 'held')
    <button type="button" class="btn-confirm-pay"
        onclick="openConfirmModal('modal-confirm-final')">
         Confirm Delivered & Complete
    </button>
    <p class="action-note" style="color:#1A3A6B;">✓ Final payment verified and held in escrow.</p>
    @else
    <div class="waiting-box has-proof" style="background:#EBF3FE; border-color:#BEDAF5; width:100%;">
        <div class="w-icon">🔒</div>
        <div class="w-title" style="color:#1A3A6B;">Final payment received — platform verifying</div>
        <div class="w-sub">Our team is confirming the customer's payment. You'll be notified once funds are held in escrow.</div>
    </div>
    @endif
                        @elseif($finalIsRejected)
                            <div class="waiting-box no-proof" style="border-color:#F5C5BE; background:#FDF5F3; width:100%;">
                                <div class="w-icon">❌</div>
                                <div class="w-title" style="color:#8B2A1E;">Proof Rejected</div>
                                <div class="w-sub">Waiting for customer to re-upload valid proof</div>
                            </div>
    @elseif($finalEscrow === 'held')
                            <div style="width:100%; background:#EFF5EF; border:1.5px solid #BFDFBE; border-radius:12px; padding:1rem 1.25rem;">
                              
                                <div style="font-weight:700; font-size:0.85rem; color:#1B4D2E; margin-bottom:0.25rem;">Complete Your Order Delivery</div>
                                <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.6;">The customer’s payment is secured. Once the customer confirms receipt of the cake, your full payment of <strong>₱{{ number_format($order->agreed_price, 2) }}</strong> will be automatically released to your wallet.</div>
                            </div>
                        @else
                            <div style="width:100%; background:#FEF9E8; border:1.5px solid #F0D090; border-radius:12px; padding:1rem 1.25rem;">
                                <div style="font-size:1.2rem; margin-bottom:0.4rem;">⏳</div>
                                <div style="font-weight:700; font-size:0.85rem; color:#8A5010; margin-bottom:0.25rem;">Waiting for Customer's Final Payment</div>
                                <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.6;">The customer has been notified. Once they confirm and pay, a <strong>Confirm Delivered</strong> button will appear here.</div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
            @elseif(in_array($order->status, ['COMPLETED','DELIVERED']))
            <div class="card">
                <div style="padding:2rem; text-align:center;">
                    <div style="margin-bottom:0.75rem;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--caramel)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                    <div style="font-weight:700; color:var(--brown-deep); font-size:1rem;">Order Complete!</div>
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-top:0.3rem;">
                        @if($isPickup) Cash received and order completed.
                        @else Both payments confirmed. This order is archived. @endif
                    </div>
                </div>
            </div>
            @endif
{{-- ── 3D CAKE PREVIEW ── --}}
@if($order->cakeRequest->cake_preview_image)
<div class="card">
    <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>Cake Design Preview</h3></div>
    <img src="{{ asset('storage/' . $order->cakeRequest->cake_preview_image) }}"
         alt="3D Cake Preview"
         style="width:100%; max-height:320px; object-fit:cover; display:block;">
    <div style="padding:0.75rem 1.5rem; font-size:0.75rem; color:var(--text-muted); text-align:center;">
        3D preview captured at time of request
    </div>
</div>
@endif
          {{-- ── CAKE & ORDER DETAILS (combined) ── --}}
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>Cake &amp; Order Details</h3></div>
                <div class="config-grid">
                    @foreach(['shape','size','flavor','frosting'] as $key)
                        @if(!empty($config[$key]))
                        <div class="config-item">
                            <div class="c-label">{{ ucfirst($key) }}</div>
                            <div class="c-value">{{ $config[$key] }}</div>
                        </div>
                        @endif
                    @endforeach
                    @if(!empty($config['addons']))
                    <div class="config-item" style="grid-column:1/-1; border-right:none;">
                        <div class="c-label">Add-ons</div>
                        <div class="c-value">{{ implode(', ', (array)$config['addons']) }}</div>
                    </div>
                    @endif
                </div>
                <div style="border-top:1px solid var(--border);">
                    <div class="info-row">
                        <span class="i-key">Fulfillment</span>
                  
                    </div>
                    <div class="info-row">
                        <span class="i-key">Budget</span>
                        <span class="i-val">₱{{ number_format($order->cakeRequest->budget_min, 0) }} — ₱{{ number_format($order->cakeRequest->budget_max, 0) }}</span>
                    </div>
             <div class="info-row">
    <span class="i-key">{{ $isPickup ? 'Date' : 'Delivery Date' }}</span>
    <span class="i-val" style="font-weight:700; color:var(--caramel);">
        {{ $order->cakeRequest->delivery_date->format('M d, Y') }}
        @if($order->cakeRequest->needed_time)
            <span style="font-size:0.75rem; color:var(--caramel); font-weight:600; display:block; margin-top:1px;">
                🕐 {{ \Carbon\Carbon::parse($order->cakeRequest->needed_time)->format('g:i A') }}
            </span>
        @endif
    </span>
</div>
                    @if(!empty($config['total']))
                    <div class="info-row">
                        <span class="i-key">Est. Price</span>
                        <span class="i-val" style="color:var(--caramel); font-weight:700;">₱{{ number_format($config['total'], 0) }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="i-key">Submitted</span>
                        <span class="i-val">{{ $order->cakeRequest->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($order->cakeRequest->custom_message)
                    <div class="info-row" style="flex-direction:column; align-items:flex-start; gap:0.25rem;">
                        <span class="i-key">Message on Cake</span>
                        <span style="font-size:0.82rem; color:var(--text-dark); font-style:italic;">"{{ $order->cakeRequest->custom_message }}"</span>
                    </div>
                    @endif
                    @if($order->cakeRequest->special_instructions)
                    <div class="info-row" style="flex-direction:column; align-items:flex-start; gap:0.25rem; border-bottom:none;">
                        <span class="i-key">Special Instructions</span>
                        <span style="font-size:0.82rem; color:var(--text-dark); line-height:1.5;">{{ $order->cakeRequest->special_instructions }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── DELIVERY LOCATION MAP (Baker Side) ── --}}
            @if(!$isPickup && $order->cakeRequest->delivery_lat && $order->cakeRequest->delivery_lng)
            <div class="card">
                <div class="card-header">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Location</h3>
                </div>
              
                <div id="baker-delivery-map" style="width:100%; height:260px;"></div>
            </div>
            @endif

            @include('partials.order-chat-bubble', ['order' => $order])

        </div>{{-- /left column --}}

        {{-- ════════════════ RIGHT SIDEBAR ════════════════ --}}
        <div class="order-sidebar-col">
            <div class="id-card">
                <div class="id-label">Order</div>
              <div class="id-num">#{{ str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div style="font-size:0.7rem; opacity:0.35; margin-top:0.4rem;">{{ $order->created_at->format('M d, Y') }}</div>
                <hr class="id-divider">
                <div class="id-sub">Status</div>
                <div class="id-val" style="color:var(--caramel-light);">{{ str_replace('_', ' ', $order->status) }}</div>
                @if($isPickup)
                <hr class="id-divider">
                <div class="id-sub">Type</div>
                <div class="id-val" style="color:#F0D090; font-size:0.85rem;"> Pickup Order</div>
                @endif
                <hr class="id-divider">
                <div class="id-sub">Agreed Price</div>
              <div class="id-val" style="font-family:'Plus Jakarta Sans',sans-serif; font-size:1.3rem; font-weight:800;">₱{{ number_format($order->agreed_price, 0) }}</div>
    
            </div>

     {{-- ── PAYMENT STATUS (ESCROW) ── --}}
            @if(!in_array($order->status, ['ACCEPTED','CANCELLED']))
            <div class="card" style="border:2px solid #EDD090; position:relative;">
                <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--caramel),var(--caramel-light),var(--caramel));"></div>
                <div class="card-header">
          <h3 style="white-space:nowrap;">Payment Status</h3>

                </div>
                <div style="padding:0.6rem 1rem; background:#FEF9ED; border-bottom:1px solid #EDD090; font-size:0.72rem; color:#8A5010; line-height:1.5;">
                    🔒 Payments are held securely by BakeSphere until you complete the order.
                </div>

                <div style="padding:0.75rem 1rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:0.5rem;">
                    <div>
                        <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); font-weight:600; margin-bottom:0.15rem;">50% Downpayment</div>
                        <div style="font-size:0.95rem; font-weight:800; color:var(--brown-deep);">₱{{ number_format(round($order->agreed_price * 0.5, 2), 2) }}</div>
                    </div>
                    <div>
                        @if($downEscrow === 'held')
                        <span style="background:#EBF3FE; color:#1A3A6B; border:1px solid #BEDAF5; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">🔒 In Escrow</span>
                        @elseif($downEscrow === 'released')
                        <span style="background:#EFF5EF; color:#1B4D2E; border:1px solid #BFDFBE; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">✓ Released</span>
                        @elseif($downpayment && $downpayment->status === 'pending')
                        <span style="background:#FEF9E8; color:#8A5010; border:1px solid #F0D090; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">⏳ Verifying</span>
                        @elseif($downpayment && $downpayment->status === 'rejected')
                        <span style="background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">✕ Rejected</span>
                        @else
                        <span style="background:#F8F5F0; color:var(--text-muted); border:1px solid var(--border); padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">⌛ Awaiting</span>
                        @endif
                    </div>
                </div>

                <div style="padding:0.75rem 1rem; display:flex; align-items:center; justify-content:space-between; gap:0.5rem;">
                    <div>
                        <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); font-weight:600; margin-bottom:0.15rem;">50% {{ $isPickup ? 'Cash on Pickup' : 'Final Payment' }}</div>
                        <div style="font-size:0.95rem; font-weight:800; color:var(--brown-deep);">₱{{ number_format(round($order->agreed_price * 0.5, 2), 2) }}</div>
                    </div>
                    <div>
                        @if($finalEscrow === 'held')
                        <span style="background:#EBF3FE; color:#1A3A6B; border:1px solid #BEDAF5; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">🔒 In Escrow</span>
                        @elseif($finalEscrow === 'released')
                        <span style="background:#EFF5EF; color:#1B4D2E; border:1px solid #BFDFBE; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">✓ Released</span>
                        @elseif($finalPayment && $finalPayment->status === 'pending')
                        <span style="background:#FEF9E8; color:#8A5010; border:1px solid #F0D090; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">⏳ Verifying</span>
                        @elseif($isPickup && in_array($order->status, ['WAITING_FINAL_PAYMENT']))
                        <span style="background:#FEF9E8; color:#8A5010; border:1px solid #F0D090; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">💵 Cash on Pickup</span>
                        @else
                        <span style="background:#F8F5F0; color:var(--text-muted); border:1px solid var(--border); padding:0.2rem 0.6rem; border-radius:20px; font-size:0.68rem; font-weight:700;">🔒 Not Yet</span>
                        @endif
                    </div>
                </div>

                @if($order->baker_payout)
                <div style="padding:0.65rem 1rem; background:var(--cream); border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-size:0.68rem; color:var(--text-muted);">Your payout (after 5% fee)</div>
                    <div style="font-size:1rem; font-weight:800; color:#1B4D2E;">₱{{ number_format($order->baker_payout, 2) }}</div>
                </div>
                @endif

  @if(in_array($order->status, ['DELIVERED','COMPLETED']))
                <div style="padding:0.75rem 1rem; background:#EFF5EF; border-top:1px solid #BFDFBE; font-size:0.75rem; color:#1B4D2E; font-weight:600; display:flex; align-items:center; gap:0.4rem;">
                     Funds released! <a href="{{ route('baker.wallet.index') }}" style="color:var(--caramel); font-weight:700;">View wallet →</a>
                </div>
                @endif
            </div>
            @endif

            @if($order->cakeRequest->reference_image)
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Reference</h3></div>
                <img src="{{ asset('storage/'.$order->cakeRequest->reference_image) }}" alt="Reference" style="width:100%; max-height:220px; object-fit:cover;">
            </div>
            @endif

            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Activity</h3></div>
                <ul class="timeline-log">
                    <li>
                        <div class="log-dot"></div>
                        <div>
                            <div class="log-event">Order created</div>
                            <div class="log-time">{{ $order->created_at->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @if($downpayment)
                    <li>
                        <div class="log-dot" style="background:{{ $downIsRejected ? '#F5C5BE' : 'var(--caramel-light)' }};"></div>
                        <div>
                            <div class="log-event" style="{{ $downIsRejected ? 'color:#8B2A1E;' : '' }}">
                                ₱ Downpayment {{ $downIsPaid ? 'confirmed' : ($downIsRejected ? 'rejected' : 'proof submitted') }}
                            </div>
                            <div class="log-time">{{ ($downpayment->confirmed_at ?? $downpayment->rejected_at ?? $downpayment->paid_at)?->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @endif
                    @if(!$isPickup && $finalPayment)
                    <li>
                        <div class="log-dot" style="background:{{ $finalIsRejected ? '#F5C5BE' : 'var(--brown-mid)' }};"></div>
                        <div>
                            <div class="log-event" style="{{ $finalIsRejected ? 'color:#8B2A1E;' : '' }}">
                                ₱ Final payment {{ $finalIsPaid ? 'confirmed' : ($finalIsRejected ? 'rejected' : 'proof submitted') }}
                            </div>
                            <div class="log-time">{{ ($finalPayment->confirmed_at ?? $finalPayment->rejected_at ?? $finalPayment->paid_at)?->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @endif
                    @if($order->completed_at)
                    <li>
                        <div class="log-dot" style="background:var(--caramel);"></div>
                        <div>
                            <div class="log-event" style="color:var(--caramel);"> Order {{ $isPickup ? 'collected & completed' : 'completed' }}</div>
                            <div class="log-time">{{ $order->completed_at->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @endif
                </ul>
         </div>

        

        </div>

    </div>{{-- /order-page-grid --}}
</div>{{-- /order-wrap --}}

<div class="confirm-modal-backdrop" id="modal-mark-ready" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header variant-advance">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div>
            <div class="confirm-modal-title">Mark as Ready?</div>
            <div class="confirm-modal-subtitle">Upload your finished cake photo to notify the customer</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Customer</span>
                    <span class="confirm-modal-detail-val">{{ $order->cakeRequest->user->first_name }} {{ $order->cakeRequest->user->last_name }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Date</span>
                    <span class="confirm-modal-detail-val">{{ $order->cakeRequest->delivery_date->format('M d, Y') }}</span>
                </div>
            </div>

            <div style="margin-bottom:1rem;">
                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);margin-bottom:0.5rem;">
                    📸 Final Cake Photo <span style="color:#C44030;">*</span>
                </div>
                <div id="cake-photo-dropzone"
                    onclick="document.getElementById('form-mark-ready-photo').click()"
                    style="border:2px dashed var(--border);border-radius:12px;padding:1rem;cursor:pointer;text-align:center;background:#FDFAF6;transition:all 0.2s;">
                    <div id="cake-photo-placeholder">
                        <div style="font-size:1.5rem;margin-bottom:0.3rem;">📷</div>
                        <div style="font-size:0.78rem;font-weight:600;color:var(--brown-mid);">Click to upload cake photo</div>
                        <div style="font-size:0.68rem;color:var(--text-muted);margin-top:0.2rem;">JPG, PNG · max 5MB · Required</div>
                    </div>
                    <div id="cake-photo-preview-wrap" style="display:none;">
                        <img id="cake-photo-preview" src="" alt="Cake preview"
                            style="max-height:140px;border-radius:8px;object-fit:cover;border:1px solid var(--border);">
                        <div id="cake-photo-filename" style="font-size:0.72rem;color:var(--brown-mid);margin-top:0.4rem;font-weight:600;"></div>
                        <div style="font-size:0.65rem;color:#22c55e;margin-top:0.1rem;font-weight:600;">✓ Ready to submit</div>
                    </div>
                </div>
                <div id="cake-photo-error" style="display:none;margin-top:0.4rem;font-size:0.72rem;color:#C44030;font-weight:600;">
                    ⚠ Please upload a photo of the finished cake before continuing.
                </div>
            </div>

            <p class="confirm-modal-note">This will move to <strong>Ready for {{ $isPickup ? 'Pickup' : 'Delivery' }}</strong> and notify the customer with your cake photo.</p>
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-mark-ready')">Cancel</button>
            <button class="confirm-modal-btn-ok style-advance" onclick="submitMarkReadyWithPhoto(this)">
                <span class="btn-spinner"></span><span class="btn-text">{{ $isPickup ? ' Mark as Ready' : '📦 Mark as Ready' }}</span>
            </button>
        </div>
    </div>
</div>

<div class="confirm-modal-backdrop" id="modal-request-final" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header variant-advance">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg></div>
            <div class="confirm-modal-title">{{ $isPickup ? 'Notify — Ready for Pickup?' : 'Request Final Payment?' }}</div>
            <div class="confirm-modal-subtitle">{{ $isPickup ? 'Customer will come to collect and pay cash' : 'Prompt the customer to pay the remaining balance' }}</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">{{ $isPickup ? 'Cash on Pickup (50%)' : 'Final Amount (50%)' }}</span>
                    <span class="confirm-modal-detail-val" style="color:var(--caramel);">₱{{ number_format($finalAmount, 2) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Total Order</span>
                    <span class="confirm-modal-detail-val">₱{{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>
    

            <p class="confirm-modal-note">
                @if($isPickup)
                    The customer will be notified to come to your location and bring <strong>₱{{ number_format($finalAmount, 2) }} cash</strong>.
                @else
                    The customer will be prompted to pay the remaining 50% after seeing your finished cake photo.
                @endif
            </p>
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-request-final')">Cancel</button>
         <button class="confirm-modal-btn-ok style-advance" id="btn-request-final"
                onclick="submitModal('modal-request-final','form-request-final',this)">
                <span class="btn-spinner"></span><span class="btn-text"> Notify Customer</span>
            </button>
        </div>
    </div>
</div>

<div class="confirm-modal-backdrop" id="modal-confirm-final" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header variant-complete">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div class="confirm-modal-title">{{ $isPickup ? 'Confirm Cash Received?' : 'Complete This Order?' }}</div>
            <div class="confirm-modal-subtitle">{{ $isPickup ? 'Confirm the customer has paid in cash and collected their cake' : 'Confirm final payment received to mark as complete' }}</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">{{ $isPickup ? 'Cash Received (50%)' : 'Final Payment (50%)' }}</span>
                    <span class="confirm-modal-detail-val" style="color:var(--caramel);">₱{{ number_format($finalAmount, 2) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Total Received</span>
                   <span class="confirm-modal-detail-val" style="color:#2E8A2E; font-family:'Plus Jakarta Sans',sans-serif; font-size:1rem; font-weight:800;">₱{{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>
            @if($isPickup)
            <p class="confirm-modal-note" style="background:#FEF9E8; border:1px solid #F0D090; border-radius:8px; padding:0.65rem; color:#8A5010;">
                💵 This confirms you received <strong>₱{{ number_format(round($order->agreed_price * 0.5, 2), 2) }}</strong> cash from the customer in person.
            </p>
            @else
            <p class="confirm-modal-note">This will <strong>complete the order</strong>. Make sure you've received the full final payment.</p>
            @endif
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-confirm-final')">Cancel</button>
            <button class="confirm-modal-btn-ok style-complete" onclick="submitModal('modal-confirm-final', 'form-confirm-final', this)">
                <span class="btn-spinner"></span><span class="btn-text">{{ $isPickup ? '💵 Yes, Complete Order' : ' Complete Order' }}</span>
            </button>
        </div>
    </div>
</div>

{{-- ══════════════ REJECT PAYMENT MODAL ══════════════ --}}
<div class="reject-modal-backdrop" id="rejectPaymentModal" role="dialog" aria-modal="true">
    <div class="reject-modal">
        <div class="reject-modal-header">
            <div class="reject-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
            <div class="reject-modal-title">Reject Payment Proof?</div>
            <div class="reject-modal-sub" id="rejectModalSub">Select a reason for the rejection</div>
        </div>
        <div class="reject-modal-body">
            <div class="reject-warning-box">
                <span>⚠️</span>
                <div>The customer will be <strong>notified immediately</strong> and asked to re-upload.
                A <strong>second rejection</strong> will <strong>automatically cancel</strong> the order.</div>
            </div>
            <div class="reject-reasons-label">Reason for Rejection *</div>
            <div class="reject-reason-list" id="rejectReasonList">
                @foreach($rejectionReasons as $key => $label)
                <div class="reject-reason-item" data-value="{{ $key }}" onclick="selectRejectReason(this)">
                    <div class="reject-reason-radio"></div>
                    {{ $label }}
                </div>
                @endforeach
            </div>
            <div class="reject-reasons-label">Additional Note <span style="opacity:0.5;">(optional)</span></div>
            <textarea class="reject-note-area" id="rejectNoteInput"
                placeholder="e.g. The GCash reference number could not be verified…"></textarea>
        </div>
        <div class="reject-modal-footer">
            <button class="reject-modal-cancel" onclick="closeRejectModal()">Cancel</button>
            <button class="reject-modal-submit" id="rejectSubmitBtn" disabled onclick="submitRejectModal()">
                <span id="rejectBtnSpinner" style="display:none; width:16px; height:16px; border:2px solid rgba(255,255,255,0.3); border-top-color:white; border-radius:50%; animation:spin 0.7s linear infinite;"></span>
                <span id="rejectBtnLabel">✕ Reject Proof</span>
            </button>
        </div>
    </div>
</div>

<form id="rejectPaymentForm" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="payment_type"     id="rejectFormPaymentType">
    <input type="hidden" name="rejection_reason" id="rejectFormReason">
    <input type="hidden" name="rejection_note"   id="rejectFormNote">
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('form-mark-ready-photo');
    if (!photoInput) return;
    photoInput.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        const file = this.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('cake-photo-placeholder').style.display = 'none';
            document.getElementById('cake-photo-preview-wrap').style.display = 'block';
            document.getElementById('cake-photo-preview').src = e.target.result;
            document.getElementById('cake-photo-filename').textContent = file.name;
            document.getElementById('cake-photo-dropzone').style.borderColor = 'var(--caramel)';
            document.getElementById('cake-photo-dropzone').style.borderStyle = 'solid';
            document.getElementById('cake-photo-dropzone').style.background = '#FEF9F0';
            document.getElementById('cake-photo-error').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
});

function submitMarkReadyWithPhoto(btn) {
    const photoInput = document.getElementById('form-mark-ready-photo');
    if (!photoInput || !photoInput.files || !photoInput.files[0]) {
        document.getElementById('cake-photo-error').style.display = 'block';
        document.getElementById('cake-photo-dropzone').style.borderColor = '#C44030';
        document.getElementById('cake-photo-dropzone').style.borderStyle = 'solid';
        return;
    }
    btn.disabled = true;
    btn.classList.add('is-loading');
    document.getElementById('form-mark-ready').submit();
}
function toggleProof(wrapperId) {
    const wrap = document.getElementById(wrapperId);
    const btnId = wrapperId === 'down-proof-wrap' ? 'down-proof-btn' : 'final-proof-btn';
    const btn = document.getElementById(btnId);
    const isHidden = wrap.style.display === 'none';
    wrap.style.display = isHidden ? 'block' : 'none';
    btn.textContent = isHidden ? '👁 Hide' : '👁 Show';
}
function openConfirmModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeConfirmModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
}
function submitModal(modalId, formId, btn) {
    const form = document.getElementById(formId);
    if (!form) return;
    btn.disabled = true;
    btn.classList.add('is-loading');
    form.submit();
}
document.querySelectorAll('.confirm-modal-backdrop').forEach(b => {
    b.addEventListener('click', function(e) { if (e.target === this) closeConfirmModal(this.id); });
});

let _selectedRejectReason = null;
function openRejectModal(paymentType, paymentTypeLabel, orderId) {
    document.getElementById('rejectPaymentForm').action = '/baker/orders/' + orderId + '/reject-payment';
    document.getElementById('rejectFormPaymentType').value = paymentType;
    document.getElementById('rejectModalSub').textContent  = 'Rejecting: ' + paymentTypeLabel + ' proof';
    _selectedRejectReason = null;
    document.querySelectorAll('.reject-reason-item').forEach(el => el.classList.remove('selected'));
    document.getElementById('rejectNoteInput').value   = '';
    document.getElementById('rejectSubmitBtn').disabled = true;
    document.getElementById('rejectPaymentModal').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeRejectModal() {
    document.getElementById('rejectPaymentModal').classList.remove('is-open');
    document.body.style.overflow = '';
}
function selectRejectReason(el) {
    document.querySelectorAll('.reject-reason-item').forEach(e => e.classList.remove('selected'));
    el.classList.add('selected');
    _selectedRejectReason = el.dataset.value;
    document.getElementById('rejectSubmitBtn').disabled = false;
}
function submitRejectModal() {
    if (!_selectedRejectReason) return;
    document.getElementById('rejectFormReason').value = _selectedRejectReason;
    document.getElementById('rejectFormNote').value   = document.getElementById('rejectNoteInput').value;
    const btn = document.getElementById('rejectSubmitBtn');
    btn.disabled = true;
    document.getElementById('rejectBtnSpinner').style.display = 'block';
    document.getElementById('rejectBtnLabel').style.display   = 'none';
    document.getElementById('rejectPaymentForm').submit();
}
document.getElementById('rejectPaymentModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key !== 'Escape') return;
    document.querySelectorAll('.confirm-modal-backdrop.is-open').forEach(m => closeConfirmModal(m.id));
    if (document.getElementById('rejectPaymentModal').classList.contains('is-open')) closeRejectModal();
});
</script>

@php $terminalBakerStates = ['COMPLETED','CANCELLED','DELIVERED']; @endphp
@if(!in_array($order->status, $terminalBakerStates))
<script>
(function () {
    'use strict';

    var POLL_URL    = @json(route('baker.orders.state-poll', $order->id));
   var POLL_MS     = 3000;
    var lastFp      = null;
    var reloading   = false;

  function fp(d) {
    return [
        d.order_status,
        d.request_status,
        d.down_status,
        d.down_escrow,
        d.final_status,
        d.final_escrow,
        d.has_cake_photo ? '1' : '0',
        d.agreed_price ?? '',
        d.baker_payout ?? '',
    ].join('|');
}
    function ensureStyle() {
        if (document.getElementById('rt-style')) return;
        var s = document.createElement('style');
        s.id  = 'rt-style';
        s.textContent =
            '@keyframes rt-slidein{from{opacity:0;transform:translateX(-50%) translateY(-10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}' +
            '@keyframes rt-pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.65)}}';
        document.head.appendChild(s);
    }

    function triggerReload(msg) {
        if (reloading) return;
        reloading = true;
        ensureStyle();

        var el = document.createElement('div');
        el.style.cssText = [
            'position:fixed','top:1.1rem','left:50%',
            'transform:translateX(-50%)','z-index:99999',
            'background:#3B1F0F','color:white',
            'padding:0.55rem 1.2rem','border-radius:20px',
            'font-size:0.8rem','font-weight:600',
            'display:flex','align-items:center','gap:0.5rem',
            'box-shadow:0 4px 24px rgba(0,0,0,0.28)',
            'white-space:nowrap',
            'animation:rt-slidein 0.25s ease',
        ].join(';');
        el.innerHTML =
            '<span style="width:8px;height:8px;border-radius:50%;background:#E8A94A;' +
            'display:inline-block;animation:rt-pulse 1s ease-in-out infinite;"></span> ' +
            (msg || 'Order updated — reloading…');
        document.body.appendChild(el);
        setTimeout(function () { window.location.reload(); }, 950);
    }

  var STATUS_MSGS = {
    'WAITING_FOR_PAYMENT'    : 'Customer is ready to pay — reloading…',
    'PREPARING'              : 'Downpayment confirmed — start baking!',
    'READY'                  : 'Cake marked ready — reloading…',
    'WAITING_FINAL_PAYMENT'  : 'Final payment received — reloading…',
    'DELIVERED'              : 'Order delivered — reloading…',
    'COMPLETED'              : 'Order completed — reloading…',
    'CANCELLED'              : 'Order was cancelled.',
    'ACCEPTED'               : 'Order updated — reloading…',
};

    setInterval(function () {
        fetch(POLL_URL, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            },
        })
        .then(function (r) { return r.ok ? r.json() : null; })
       .then(function (data) {
            if (!data) return;
            var current = fp(data);
            if (lastFp === null) { lastFp = current; return; }
            if (current !== lastFp) {
                var msg = STATUS_MSGS[data.order_status]
                       || STATUS_MSGS[data.request_status]
                       || 'Order updated — reloading…';
                triggerReload(msg);
            }
        })
        .catch(function () {});
    }, POLL_MS);
})();
</script>
@endif

@if(!$isPickup && $order->cakeRequest->delivery_lat && $order->cakeRequest->delivery_lng)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $order->cakeRequest->delivery_lat }};
    const lng = {{ $order->cakeRequest->delivery_lng }};

    const map = L.map('baker-delivery-map', {
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false,
    }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:20px;height:20px;background:#C8893A;border:3px solid white;border-radius:50%;box-shadow:0 2px 12px rgba(200,137,58,0.7);"></div>`,
        iconSize: [20, 20],
        iconAnchor: [10, 10],
    });

    L.marker([lat, lng], { icon })
        .addTo(map)
        .bindPopup('📍 <strong>{{ addslashes($order->cakeRequest->user->first_name) }}\'s Delivery Address</strong>')
        .openPopup();
});
</script>
@endif

@endpush

@endsection