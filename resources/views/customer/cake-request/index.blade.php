@extends('layouts.customer')
@section('title', 'My Cake Requests')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<style>
.bs-page,.bs-modal,.bs-toast{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--blush:#E8D3CA;--w:#FBF8F2;--mocha:#7A5E4C;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
font-family:'Plus Jakarta Sans',sans-serif}
.bs-page{max-width:1500px;width:100%;margin:1vh auto 6vh;padding:0 clamp(.85rem,2.5vw,2rem);color:var(--esp)}
.bs-page *,.bs-modal *{box-sizing:border-box;font-family:inherit}
.bs-modal button,.bs-page button{font-family:inherit}
.bs-page a:focus-visible,.bs-page button:focus-visible,.bs-modal button:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes bs-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes bs-fadeIn{from{opacity:0;transform:scale(.98)}to{opacity:1;transform:none}}
@keyframes bs-reveal{from{clip-path:inset(0 100% 0 0)}to{clip-path:inset(0 0 0 0)}}
@keyframes bs-pulse{50%{opacity:.3}}
@keyframes bs-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@media(prefers-reduced-motion:reduce){
*,*::before,*::after{animation:none!important;transition:none!important}
.bs-head,.st,.bs-list-head,.oc,.bs-pager,.bs-empty{opacity:1!important;transform:none!important}}
 
/* ═══ EDITORIAL HEADER ═══ */
.bs-head{display:block;margin:0 0 2.25rem;padding-bottom:1.75rem;position:relative;animation:bs-fadeUp .6s var(--e) backwards}
.bs-head::after{content:"";position:absolute;left:0;bottom:0;width:100%;height:1px;background:var(--gold-line)}
.bs-head::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:bs-line .9s var(--e) .3s backwards}
.bs-eyebrow{display:block;font-size:.66rem;font-weight:800;letter-spacing:.32em;text-transform:uppercase;color:var(--caramel);margin-bottom:.9rem}
.bs-head h1{font-weight:900;font-size:clamp(2.4rem,6vw,4.8rem);line-height:.95;letter-spacing:-.05em;color:var(--esp);margin:0}
.bs-head p{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}
 
/* ═══ STATS STRIP ═══ */
.bs-stats{display:grid;grid-template-columns:repeat(4,1fr);margin:0 0 3rem;border-top:1px solid var(--esp);border-bottom:1px solid var(--line)}
.st{position:relative;display:flex;flex-direction:column-reverse;gap:.25rem;padding:1.5rem 1.5rem 1.4rem;background:transparent;border:0;border-left:1px solid var(--line);border-radius:0;box-shadow:none;animation:bs-fadeUp .6s var(--e) backwards}
.st:first-child{border-left:0;padding-left:0}
.st:nth-child(1){animation-delay:.1s}.st:nth-child(2){animation-delay:.18s}.st:nth-child(3){animation-delay:.26s}.st:nth-child(4){animation-delay:.34s}
.st>div:last-child{display:flex;flex-direction:column}
.st-ic{position:absolute;top:1.35rem;right:1.4rem;width:auto;height:auto;background:none;color:var(--gold);border-radius:0;display:block}
.st-ic svg{width:20px;height:20px}
.st-n{order:2;font-weight:900;font-size:clamp(2.6rem,4.5vw,4rem);line-height:.9;letter-spacing:-.06em;color:var(--esp);font-variant-numeric:tabular-nums}
.st-l{order:1;margin:0 0 .7rem;font-size:.62rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);line-height:1.3}
.st.t1 .st-n{color:var(--esp)}.st.t2 .st-n{color:var(--caramel)}.st.t3 .st-n{color:var(--esp)}.st.t4 .st-n{color:var(--gold)}
 
/* ═══ ARCHIVE HEADING ═══ */
.bs-list-head{display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;margin:0 0 1.25rem;animation:bs-fadeUp .6s var(--e) .38s backwards}
.bs-list-head h2{font-weight:900;font-size:1.6rem;letter-spacing:-.04em;color:var(--esp);margin:0}
.bs-list-head span{font-size:.62rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--taupe)}
 
/* ═══ ORDER ENTRIES ═══ */
.oc-list{display:grid;gap:0;border-top:1px solid var(--esp)}
.oc{position:relative;display:grid;grid-template-columns:220px minmax(0,1fr) 270px;background:transparent;border:0;border-bottom:1px solid var(--line);border-radius:0;box-shadow:none;cursor:pointer;transition:background .35s;animation:bs-fadeUp .6s var(--e) backwards;animation-delay:calc(.46s + var(--i,0)*.08s)}
.oc::before{content:"";position:absolute;left:0;top:-1px;height:2px;width:100%;background:var(--gold);transform:scaleX(0);transform-origin:left;transition:transform .55s var(--e)}
.oc:hover{background:rgba(239,230,215,.45)}
.oc:hover::before{transform:scaleX(1)}
.oc.p0{--c1:#F7F2E9;--c2:#D8C8B7}
.oc.p1{--c1:#3A241A;--c2:#A96F42}
.oc.p2{--c1:#E8D3CA;--c2:#B89452}
.oc.p3{--c1:#EFE6D7;--c2:#A96F42}
 
/* framed product presentation */
.oc-thumb{position:relative;display:grid;place-items:center;margin:1.5rem 1.5rem 1.5rem 0;min-height:200px;border-radius:0;
  background:radial-gradient(circle at 50% 40%,rgba(255,255,255,.95),transparent 62%),repeating-linear-gradient(45deg,rgba(36,21,15,.03) 0 1px,transparent 1px 8px),var(--cream);
  border:1px solid var(--gold-line);box-shadow:inset 0 0 0 5px var(--ivory),inset 0 0 0 6px var(--gold-line)}
.oc-thumb .cake{width:128px;height:128px;margin-top:.9rem;filter:drop-shadow(0 14px 12px rgba(36,21,15,.25));transition:transform .6s var(--e)}
.oc:hover .oc-thumb .cake{transform:scale(1.05)}
.oc-id{position:absolute;top:.9rem;left:1rem;display:flex;flex-direction:column;background:none;color:var(--esp);padding:0;border-radius:0;font-size:.95rem;font-weight:900;letter-spacing:-.02em;line-height:1.1;font-variant-numeric:tabular-nums}
.oc-id::before{content:"Order";font-size:.5rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--caramel);padding-bottom:.3rem;margin-bottom:.3rem;border-bottom:1px solid var(--gold);align-self:flex-start;padding-right:.9rem}
 
.oc-body{padding:1.6rem 1.75rem;min-width:0;display:flex;flex-direction:column;gap:1rem;justify-content:center}
.oc-title{font-weight:900;font-size:clamp(1.5rem,2.4vw,2.1rem);line-height:1.05;letter-spacing:-.04em;color:var(--esp);margin:0}
.oc-chips{display:flex;flex-wrap:wrap;gap:0}
.oc-chip{font-size:.62rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--mocha);background:none;border:0;border-radius:0;padding:0 .9rem}
.oc-chip:first-child{padding-left:0}
.oc-chip+.oc-chip{border-left:1px solid var(--gold-line)}
.oc-facts{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem 2.5rem;max-width:640px;padding-top:1.1rem;border-top:1px solid var(--line)}
.oc-fact{display:flex;align-items:center;gap:.8rem;min-width:0}
.oc-fact .fi{width:38px;height:38px;flex-shrink:0;display:grid;place-items:center;border:1px solid var(--gold-line);border-radius:0;background:none;color:var(--gold);font-weight:800;font-size:1rem}
.oc-fact .fi svg{width:18px;height:18px}
.oc-fact small{display:block;font-size:.56rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);margin-bottom:.15rem}
.oc-fact b{display:block;font-size:1.05rem;font-weight:900;letter-spacing:-.02em;color:var(--esp);white-space:nowrap;font-variant-numeric:tabular-nums}
.oc-fact em{font-style:normal;font-size:.74rem;color:var(--caramel);font-weight:700}
 
.oc-side{position:relative;border-left:1px solid var(--line);padding:1.6rem 0 1.6rem 1.75rem;display:flex;flex-direction:column;justify-content:center;align-items:stretch;gap:.75rem}
.oc-side::before,.oc-side::after{display:none}
 
/* status: icon + text + tint, never colour alone */
.stt{display:inline-flex;align-items:center;gap:.5rem;align-self:flex-start;padding:.4rem .75rem .4rem .55rem;border-radius:0;font-size:.62rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;line-height:1.15;border:1px solid transparent;border-left-width:2px}
.stt svg{width:15px;height:15px;flex-shrink:0}
.stt.live svg circle:first-child{animation:bs-pulse 1.8s ease-in-out infinite}
.s-OPEN{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.s-BIDDING{background:#EFE3D2;color:#7A4A25;border-color:rgba(169,111,66,.35);border-left-color:var(--caramel)}
.s-ACCEPTED,.s-COMPLETED{background:#E9ECDD;color:#3F5233;border-color:rgba(94,127,90,.35);border-left-color:#5E7F5A}
.s-IN_PROGRESS{background:#EFE6D7;color:var(--cof);border-color:var(--beige);border-left-color:var(--cof)}
.s-CANCELLED{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.3);border-left-color:var(--burg)}
.s-EXPIRED{background:#EAE3DA;color:var(--mocha);border-color:var(--beige);border-left-color:var(--taupe)}
.s-WAITING_FOR_PAYMENT,.s-WAITING_FINAL_PAYMENT{background:#F3E4D6;color:#8A4F1E;border-color:rgba(169,111,66,.35);border-left-color:var(--caramel)}
 
.bt{display:inline-flex;align-items:center;justify-content:center;gap:.6rem;padding:.85rem 1rem;border-radius:0;font-size:.68rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;cursor:pointer;border:1px solid transparent;transition:background .3s,color .3s,border-color .3s,transform .3s var(--e)}
.bt svg{width:15px;height:15px;transition:transform .3s var(--e)}
.bt-view{background:var(--esp);color:var(--ivory);border-color:var(--esp)}
.bt-view:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-1px)}
.bt-view:hover svg{transform:translateX(4px)}
.bt-x{background:transparent;color:var(--burg);border-color:rgba(84,37,44,.3);padding:.65rem .9rem;font-size:.6rem}
.bt-x:hover{background:#F6ECEA;border-color:var(--burg)}
.bt:disabled{opacity:.5;cursor:not-allowed}
 
/* ═══ PAGINATION ═══ */
.bs-pager{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-top:2rem;padding:1rem 0 0;background:none;border:0;border-top:1px solid var(--esp);border-radius:0;animation:bs-fadeUp .6s var(--e) .1s backwards}
.bs-pager-info{font-size:.62rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe)}
.bs-pager ul{display:flex;gap:.25rem;list-style:none;margin:0;padding:0}
.bs-pager a,.bs-pager span.pg{display:inline-flex;align-items:center;justify-content:center;min-width:38px;height:38px;padding:0 .6rem;border-radius:0;font-size:.8rem;font-weight:800;text-decoration:none;border:1px solid transparent;color:var(--mocha);background:transparent;font-variant-numeric:tabular-nums;transition:.3s}
.bs-pager a:hover{border-color:var(--gold);color:var(--esp)}
.bs-pager .on span.pg{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.bs-pager .off span.pg{opacity:.35}
 
/* ═══ EMPTY STATE ═══ */
.bs-empty{position:relative;display:grid;place-items:center;text-align:center;padding:4.5rem 1.5rem 4rem;margin-top:1rem;background:radial-gradient(ellipse 60% 50% at 50% 30%,rgba(255,255,255,.8),transparent 70%),repeating-linear-gradient(45deg,rgba(36,21,15,.03) 0 1px,transparent 1px 8px),var(--cream);border:1px solid var(--gold-line);box-shadow:inset 0 0 0 8px var(--ivory),inset 0 0 0 9px var(--gold-line);border-radius:0;overflow:hidden;animation:bs-fadeIn .7s var(--e) .1s backwards}
.bs-empty-art{position:relative;width:min(300px,70vw);aspect-ratio:1;margin:0 auto 1.5rem;display:grid;place-items:center;border-radius:50%;background:radial-gradient(circle,#fff 56%,var(--beige) 57% 60%,#fff 61% 92%,var(--gold-line) 93% 94%,#fff 95%);box-shadow:0 30px 50px -20px rgba(36,21,15,.35)}
.bs-empty-art .cake{width:64%;height:64%;--c1:#E8D3CA;--c2:#B89452;filter:drop-shadow(0 14px 12px rgba(36,21,15,.25))}
.bs-empty-art .sp{position:absolute;fill:var(--gold)}
.bs-empty-art .sp:nth-of-type(1){width:22px;height:22px;top:8%;right:10%}
.bs-empty-art .sp:nth-of-type(2){width:14px;height:14px;bottom:14%;left:6%;fill:var(--caramel)}
.bs-empty h3{font-weight:900;font-size:clamp(1.9rem,4vw,3rem);line-height:1;letter-spacing:-.05em;color:var(--esp);margin:0 0 .8rem}
.bs-empty p{color:var(--mocha);font-size:.96rem;line-height:1.7;margin:0 auto 1.8rem;max-width:42ch}
.bs-empty::before{content:"Your cake archive is waiting";display:block;font-size:.66rem;font-weight:800;letter-spacing:.32em;text-transform:uppercase;color:var(--caramel);margin-bottom:1.5rem}
.bs-cta{display:inline-flex;align-items:center;gap:.75rem;padding:1rem 1.6rem;border-radius:0;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-weight:800;font-size:.72rem;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;box-shadow:0 14px 30px rgba(36,21,15,.28);transition:background .3s,color .3s,transform .3s var(--e),box-shadow .3s}
.bs-cta:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);box-shadow:0 18px 36px rgba(184,148,82,.4)}
.bs-cta .ic{width:20px;height:20px;padding:0;background:none;color:var(--gold-l)}
.bs-cta:hover .ic{color:var(--esp)}
.bs-cta .sp{width:12px;height:12px;fill:var(--gold-l);transition:transform .4s var(--e)}
.bs-cta:hover .sp{transform:rotate(90deg);fill:var(--esp)}
.bs-sr{position:absolute;left:-9999px}
 
/* ═══ CANCEL DIALOG + TOAST ═══ */
.bs-modal{position:fixed;inset:0;z-index:999;background:rgba(28,14,8,.82);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:1rem}
.bs-modal[hidden],.bs-toast[hidden]{display:none}
.bs-modal-box{width:100%;max-width:420px;background:var(--ivory);border:1px solid var(--gold);border-top:4px solid var(--burg);border-radius:0;padding:2rem 1.75rem 1.75rem;text-align:center;box-shadow:0 40px 100px rgba(0,0,0,.55);animation:bs-fadeUp .35s var(--e)}
.bs-modal-ic{width:52px;height:52px;margin:0 auto 1rem;border:1px solid var(--burg);border-radius:0;display:grid;place-items:center;background:#F6ECEA;color:var(--burg)}
.bs-modal-ic svg{width:24px;height:24px}
.bs-modal-box h3{font-weight:900;font-size:1.5rem;letter-spacing:-.04em;color:var(--esp);margin:0 0 .5rem}
.bs-modal-box p{font-size:.88rem;color:var(--mocha);line-height:1.65;margin:0 0 1.5rem}
.bs-modal-act{display:flex;gap:.6rem}
.bs-modal-act .bt{flex:1}
.bs-keep{background:transparent;color:var(--esp);border-color:var(--esp)}
.bs-keep:hover{background:var(--cream);border-color:var(--gold)}
.bs-danger{background:var(--burg);color:var(--ivory);border-color:var(--burg)}
.bs-danger:hover{background:#3F1A20}
.bs-toast{position:fixed;bottom:1.25rem;left:50%;transform:translateX(-50%);z-index:1000;background:var(--burg);color:var(--ivory);border-left:3px solid var(--gold);padding:.85rem 1.3rem;border-radius:0;font-size:.82rem;font-weight:700;box-shadow:0 16px 36px rgba(0,0,0,.35)}
 
/* ═══ RESPONSIVE ═══ */
@media(max-width:1000px){
.bs-stats{grid-template-columns:repeat(2,1fr)}
.st:nth-child(3){border-left:0;padding-left:0}
.st:nth-child(n+3){border-top:1px solid var(--line)}
.oc{grid-template-columns:200px minmax(0,1fr)}
.oc-side{grid-column:1/-1;flex-direction:row;flex-wrap:wrap;align-items:center;justify-content:space-between;border-left:0;border-top:1px solid var(--line);padding:1.1rem 0 1.4rem}
.oc-side .bt-view{flex:1 1 160px}
}
@media(max-width:720px){
.bs-head h1{letter-spacing:-.04em}
.oc{grid-template-columns:1fr}
.oc-thumb{margin:1.25rem 0 0;min-height:170px}
.oc-thumb .cake{width:104px;height:104px}
.oc-body{padding:1.25rem 0 1rem}
.oc-facts{grid-template-columns:1fr}
.oc-side{padding-top:1rem}
.oc-side .bt{min-height:46px}
.bs-modal-act{flex-direction:column-reverse}
}
@media(max-width:420px){.st{padding:1.1rem .9rem}.st-n{font-size:2.4rem}.st-ic{right:.6rem}}
</style>
@endpush

@section('content')
@php
    $statusMeta = [
        'OPEN' => ['Open', 'i-dot'], 'BIDDING' => ['Bidding', 'i-tag'], 'ACCEPTED' => ['Accepted', 'i-check'],
        'IN_PROGRESS' => ['In progress', 'i-flame'], 'COMPLETED' => ['Completed', 'i-badge'],
        'CANCELLED' => ['Cancelled', 'i-x'], 'EXPIRED' => ['Expired', 'i-hourglass'],
        'WAITING_FOR_PAYMENT' => ['Waiting for payment', 'i-card'], 'WAITING_FINAL_PAYMENT' => ['Waiting for final payment', 'i-card'],
    ];
    $activeStatuses = ['OPEN','BIDDING','ACCEPTED','IN_PROGRESS','WAITING_FOR_PAYMENT','WAITING_FINAL_PAYMENT'];
    $items = $requests->getCollection();
    $activeCount = $items->whereIn('status', $activeStatuses)->count();
    $doneCount = $items->where('status', 'COMPLETED')->count();
    $upcomingCount = $items->filter(fn($r) => in_array($r->status, $activeStatuses) && $r->delivery_date->copy()->endOfDay()->isFuture())->count();
    $scope = $requests->hasPages() ? 'on this page' : '';
@endphp

{{-- Shared SVG icons and cake illustration --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <symbol id="bs-cake" viewBox="0 0 120 120">
      <ellipse cx="60" cy="110" rx="52" ry="7" fill="#000" opacity=".13"/>
      <rect x="14" y="62" width="92" height="44" rx="11" fill="var(--c2)"/>
      <rect x="14" y="62" width="92" height="16" rx="8" fill="var(--c1)"/>
      <path d="M14 78h92v2c-8 10-15 10-23 0s-15 10-23 0-15 10-23 0-15 10-23 0z" fill="var(--c1)"/>
      <rect x="30" y="34" width="60" height="32" rx="9" fill="var(--c2)"/>
      <rect x="30" y="34" width="60" height="14" rx="7" fill="var(--c1)"/>
      <path d="M30 48h60v2c-5 9-15 9-20 0s-15 9-20 0-15 9-20 0z" fill="var(--c1)"/>
      <rect x="40" y="90" width="8" height="3" rx="1.5" fill="#fff" opacity=".85" transform="rotate(20 44 91)"/>
      <rect x="70" y="94" width="8" height="3" rx="1.5" fill="#FFD98A" transform="rotate(-25 74 95)"/>
      <rect x="88" y="88" width="8" height="3" rx="1.5" fill="#fff" opacity=".85" transform="rotate(50 92 89)"/>
      <path d="M60 26q1-9 9-12" fill="none" stroke="#5C7A3A" stroke-width="2.5" stroke-linecap="round"/>
      <circle cx="60" cy="31" r="7.5" fill="#C62A47"/><circle cx="57.5" cy="28.5" r="2" fill="#fff" opacity=".55"/>
    </symbol>
    <symbol id="i-spark" viewBox="0 0 24 24"><path d="M12 1l2.2 7.8L22 12l-7.8 2.2L12 23l-2.2-8.8L2 12l7.8-3.2z"/></symbol>
    <symbol id="i-dot" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" fill="currentColor"/><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-width="2"/></symbol>
    <symbol id="i-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><path d="M3 12V4h8l9 9-8 8z"/><circle cx="7.5" cy="8.5" r="1"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7"/></symbol>
    <symbol id="i-flame" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><path d="M12 3c1 4 5 5 5 10a5 5 0 0 1-10 0c0-2 1-3 2-4 0 2 1 3 2 3 0-3-1-5 1-9z"/></symbol>
    <symbol id="i-badge" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></symbol>
    <symbol id="i-hourglass" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h10M7 21h10M8 3v3l4 6-4 6v3M16 3v3l-4 6 4 6v3"/></symbol>
    <symbol id="i-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="6" width="18" height="12" rx="2.5"/><path d="M3 10.5h18"/></symbol>
    <symbol id="i-cal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="4" y="5" width="16" height="16" rx="3"/><path d="M4 10h16M9 3v4M15 3v4"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
    <symbol id="i-cakeline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21h16M5 21v-8h14v8M5 17c2 2 3 2 5 0s3 2 5 0 3 2 4 0M12 13V9M12 6.5c.7-1 .7-1.8 0-2.6-.7.8-.7 1.6 0 2.6z"/></symbol>
  </defs>
</svg>

{{-- Cancel confirmation dialog --}}
<div id="bs-modal" class="bs-modal" hidden>
    <div class="bs-modal-box" role="dialog" aria-modal="true" aria-labelledby="bs-modal-title">
        <div class="bs-modal-ic"><svg aria-hidden="true"><use href="#i-x"/></svg></div>
        <h3 id="bs-modal-title">Cancel this request?</h3>
        <p id="bs-modal-text">This cannot be undone.</p>
        <div class="bs-modal-act">
            <button type="button" class="bt bs-keep" id="bs-no">Keep it</button>
            <button type="button" class="bt bs-danger" id="bs-yes">Yes, cancel</button>
        </div>
    </div>
</div>
<div id="bs-toast" class="bs-toast" role="alert" hidden></div>

<div class="bs-page">

    <header class="bs-head">
        <span class="bs-eyebrow">Your BakeSphere archive</span>
        <h1>My Cake Orders</h1>
        <p>Every design you've requested, from first idea to final cake.</p>
    </header>

    @if($requests->count())

    {{-- Stats (only real values; counts cover the current page when paginated) --}}
    <section class="bs-stats" aria-label="Order summary">
        <div class="st t1"><div class="st-ic"><svg aria-hidden="true"><use href="#i-cakeline"/></svg></div>
            <div><div class="st-n">{{ $requests->total() }}</div><div class="st-l">Total {{ Str::plural('order', $requests->total()) }}</div></div></div>
        <div class="st t2"><div class="st-ic"><svg aria-hidden="true"><use href="#i-flame"/></svg></div>
            <div><div class="st-n">{{ $activeCount }}</div><div class="st-l">Active {{ $scope }}</div></div></div>
        <div class="st t3"><div class="st-ic"><svg aria-hidden="true"><use href="#i-badge"/></svg></div>
            <div><div class="st-n">{{ $doneCount }}</div><div class="st-l">Completed {{ $scope }}</div></div></div>
        <div class="st t4"><div class="st-ic"><svg aria-hidden="true"><use href="#i-cal"/></svg></div>
            <div><div class="st-n">{{ $upcomingCount }}</div><div class="st-l">Upcoming deliveries {{ $scope }}</div></div></div>
    </section>

    <div class="bs-list-head">
        <h2>Your cake requests</h2>
        <span>Select an order to see its details</span>
    </div>

    <div class="oc-list">
    @foreach($requests as $req)
        @php
            $config = is_array($req->cake_configuration)
                ? $req->cake_configuration
                : (json_decode($req->cake_configuration, true) ?? []);
            $showUrl = route('customer.cake-requests.show', $req->id);
            $padId = str_pad($req->id, 4, '0', STR_PAD_LEFT);
            [$stLabel, $stIcon] = $statusMeta[$req->status] ?? [ucfirst(strtolower(str_replace('_', ' ', $req->status))), 'i-dot'];
            $isLive = in_array($req->status, ['OPEN', 'BIDDING']);
            $isFinal = in_array($req->status, ['COMPLETED', 'CANCELLED', 'EXPIRED']);
        @endphp
        <article class="oc p{{ $req->id % 4 }}" data-href="{{ $showUrl }}">
            <div class="oc-thumb">
                <span class="oc-id">#{{ $padId }}</span>
                <svg class="cake" aria-hidden="true"><use href="#bs-cake"/></svg>
            </div>

            <div class="oc-body">
                <h3 class="oc-title">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</h3>
                <div class="oc-chips">
                    @if(!empty($config['size']))<span class="oc-chip">{{ $config['size'] }}</span>@endif
                    @if(!empty($config['frosting']))<span class="oc-chip">{{ $config['frosting'] }}</span>@endif
                    @if(!empty($config['addons']))<span class="oc-chip">{{ count((array) $config['addons']) }} add-ons</span>@endif
                </div>
                <div class="oc-facts">
                    <div class="oc-fact">
                        <span class="fi" aria-hidden="true">₱</span>
                        <div><small>Budget</small><b>₱{{ number_format($req->budget_min, 0) }} – ₱{{ number_format($req->budget_max, 0) }}</b></div>
                    </div>
                    <div class="oc-fact">
                        <span class="fi"><svg aria-hidden="true"><use href="#i-cal"/></svg></span>
                        <div><small>Delivery date</small><b>{{ $req->delivery_date->format('M d, Y') }}</b><em>{{ $req->delivery_date->diffForHumans() }}</em></div>
                    </div>
                </div>
            </div>

            <div class="oc-side">
                <span class="stt s-{{ $req->status }} {{ $isLive ? 'live' : '' }}">
                    <svg aria-hidden="true"><use href="#{{ $stIcon }}"/></svg>{{ $stLabel }}
                </span>
                <a href="{{ $showUrl }}" class="bt bt-view" aria-label="View order #{{ $padId }}">View order <svg aria-hidden="true"><use href="#i-arrow"/></svg></a>
                @unless($isFinal)
                <button type="button" class="bt bt-x bs-cancel"
                        data-request-id="{{ $req->id }}"
                        data-delete-url="{{ route('customer.cake-requests.destroy', $req->id) }}"
                        aria-label="Cancel request #{{ $padId }}">Cancel request</button>
                @endunless
            </div>
        </article>
    @endforeach
    </div>

    @if($requests->hasPages())
    <nav class="bs-pager" aria-label="Pagination">
        <div class="bs-pager-info">Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} results</div>
        <ul>
            <li class="{{ $requests->onFirstPage() ? 'off' : '' }}">
                @if($requests->onFirstPage())<span class="pg">‹</span>@else<a href="{{ $requests->previousPageUrl() }}" aria-label="Previous page">‹</a>@endif
            </li>
            @foreach($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                <li class="{{ $page == $requests->currentPage() ? 'on' : '' }}">
                    @if($page == $requests->currentPage())<span class="pg" aria-current="page">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif
                </li>
            @endforeach
            <li class="{{ !$requests->hasMorePages() ? 'off' : '' }}">
                @if($requests->hasMorePages())<a href="{{ $requests->nextPageUrl() }}" aria-label="Next page">›</a>@else<span class="pg">›</span>@endif
            </li>
        </ul>
    </nav>
    @endif

    @else
    {{-- Empty state --}}
    <section class="bs-empty">
        <div class="bs-empty-art" aria-hidden="true">
            <svg class="cake"><use href="#bs-cake"/></svg>
            <svg class="sp"><use href="#i-spark"/></svg>
            <svg class="sp"><use href="#i-spark"/></svg>
        </div>
        <h3>Your cake shelf is empty</h3>
        <p>Describe the cake you have in mind and bakers will send you their quotes.</p>
        <a href="{{ route('customer.cake-requests.create') }}" class="bs-cta">
            <svg class="ic" aria-hidden="true"><use href="#i-cakeline"/></svg>
            Create your first request
            <svg class="sp" aria-hidden="true"><use href="#i-spark"/></svg>
        </a>
    </section>
    @endif

</div>

<script>
(function () {
    // Whole card opens the order (the "View order" link stays the keyboard target)
    document.querySelectorAll('.oc[data-href]').forEach(function (card, idx) {
        card.style.setProperty('--i', idx);
        card.addEventListener('click', function (e) {
            if (e.target.closest('a, button')) return;
            window.location = card.dataset.href;
        });
    });

    var modal = document.getElementById('bs-modal');
    var text = document.getElementById('bs-modal-text');
    var yes = document.getElementById('bs-yes');
    var no = document.getElementById('bs-no');
    var toast = document.getElementById('bs-toast');
    var pending = null, timer = null;

    function showToast(msg) {
        toast.textContent = msg; toast.hidden = false;
        clearTimeout(timer); timer = setTimeout(function () { toast.hidden = true; }, 4000);
    }
    function openModal(btn) {
        pending = btn;
        text.textContent = 'Cancel request #' + String(btn.getAttribute('data-request-id')).padStart(4, '0') + '? This cannot be undone.';
        modal.hidden = false; no.focus();
    }
    function closeModal() { modal.hidden = true; pending = null; }

    no.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !modal.hidden) closeModal(); });

    document.querySelectorAll('.bs-cancel').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation(); e.preventDefault();
            if (!btn.disabled) openModal(btn);
        });
    });

    yes.addEventListener('click', function () {
        var btn = pending;
        if (!btn) return;
        closeModal();
        var meta = document.querySelector('meta[name="csrf-token"]');
        var label = btn.textContent;
        btn.disabled = true; btn.textContent = 'Cancelling…';

        fetch(btn.getAttribute('data-delete-url'), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': meta ? meta.getAttribute('content') : '', 'Accept': 'application/json' }
        })
        .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
        .then(function (r) {
            if (!r.ok || !r.data.success) throw new Error(r.data.message || 'Cancel failed');
            var card = btn.closest('.oc');
            if (card) { card.style.transition = 'opacity .2s, transform .2s'; card.style.opacity = '0'; card.style.transform = 'scale(.97)'; }
            // reload so the summary tiles and pagination stay accurate
            setTimeout(function () { window.location.reload(); }, 250);
        })
        .catch(function (err) {
            console.error('[bakesphere] cancel failed', err);
            showToast(err.message || 'Could not cancel this request. Please try again.');
            btn.disabled = false; btn.textContent = label;
        });
    });
})();
</script>
@endsection