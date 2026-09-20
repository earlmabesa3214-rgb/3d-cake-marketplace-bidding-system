@extends('layouts.customer')
@section('title', 'Dashboard')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
.sidebar .nav-link { gap: 0.55rem; padding: 0.7rem 0.9rem; }
.sidebar .nav-link .icon { width: 16px; text-align: left; flex-shrink: 0; }

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.studio, .studio * { font-family: 'Plus Jakarta Sans', sans-serif; }

.studio, .studio * {
    --brown-deep:   #1C0F07;
    --brown-mid:    #3D2416;
    --brown-warm:   #5C3D2E;
    --caramel:      #C8894A;
    --caramel-light:#E8B07A;
    --caramel-pale: #FDDFC0;
     --strawberry:   #6B4530;
    --strawberry-pale: #EFE3D3;
    --butter:       #8B6F47;
    --butter-pale:  #F5EDE0;
    --skyicing:     #E4D9C7;
    --cream:        #FDF6ED;
    --cream-dark:   #F6EADA;
    --warm-white:   #FEFAF5;
    --border:       rgba(92,61,46,0.18);
    --text-dark:    #2A160A;
    --text-muted:   #8C6C57;
    --r-sm: 12px;
    --r-md: 20px;
    --r-lg: 32px;
}

@keyframes fadeUp  { from { opacity:0; transform:translateY(16px);} to { opacity:1; transform:none;} }
@keyframes bob     { 0%,100% { transform: translateY(0) rotate(var(--r,0deg)); } 50% { transform: translateY(-8px) rotate(var(--r,0deg)); } }
@keyframes sparkle { 0%,100% { opacity:.35; transform: scale(.9); } 50% { opacity:1; transform: scale(1.08); } }

.reveal { opacity: 0; animation: fadeUp .7s cubic-bezier(.22,.68,0,1.12) both; }
.reveal.d1 { animation-delay: .05s; }
.reveal.d2 { animation-delay: .14s; }
.reveal.d3 { animation-delay: .22s; }

@media (prefers-reduced-motion: reduce) {
    .reveal, .float-deco { animation: none !important; opacity: 1 !important; }
}

.studio { display: flex; flex-direction: column; gap: 0; padding: 0; margin: -1.8rem; background: var(--cream); }
@media (max-width: 768px) { .studio { margin: -1rem; } }

.studio a { text-decoration: none; }
.studio img { display: block; max-width: 100%; }
.studio button { font-family: inherit; }

/* ---------- shared bits ---------- */
.eyebrow {
    display: inline-flex; align-items: center; gap: .5rem;
    font-size: .78rem; font-weight: 700; color: var(--strawberry);
    letter-spacing: .01em;
}
.eyebrow::before {
    content: ''; width: 7px; height: 7px; border-radius: 50%;
    background: var(--strawberry); flex-shrink: 0;
}
.btn-primary {
    display: inline-flex; align-items: center; gap: 0.6rem;
    padding: 0.95rem 1.7rem;
    background: linear-gradient(135deg, var(--caramel) 0%, #D4944F 100%);
    color: white; border-radius: 999px;
    font-size: 0.92rem; font-weight: 800;
    box-shadow: 0 12px 26px rgba(200,137,74,0.38);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    white-space: nowrap; border: none; cursor: pointer;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 32px rgba(200,137,74,0.46); color: white; }
.btn-secondary {
    display: inline-flex; align-items: center; gap: 0.6rem;
    padding: 0.9rem 1.6rem;
    background: transparent; color: var(--text-dark); border-radius: 999px;
    font-size: 0.92rem; font-weight: 700;
    border: 2px solid var(--brown-deep);
    transition: transform 0.2s ease, background 0.2s ease;
    white-space: nowrap; cursor: pointer;
}
.btn-secondary:hover { background: var(--brown-deep); color: var(--cream); transform: translateY(-2px); }
.icon { width: 16px; height: 16px; flex-shrink: 0; }

/* ================= HERO ================= */
.hero {
    position: relative;
    overflow: hidden;
    padding: 4rem 4rem 6.5rem;
    background: radial-gradient(ellipse 90% 70% at 15% 0%, var(--butter-pale) 0%, transparent 55%),
                radial-gradient(ellipse 80% 60% at 100% 20%, var(--strawberry-pale) 0%, transparent 50%),
                var(--cream);
}
.hero-grid {
    position: relative; z-index: 2;
    display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 3rem; align-items: center;
    max-width: 1280px; margin: 0 auto;
}
.hero h1 {
    font-size: clamp(2.5rem, 4.2vw, 4rem);
    font-weight: 700;
    line-height: 1.02;
    letter-spacing: -0.01em;
    color: var(--text-dark);
    margin: 0.9rem 0 1.2rem;
}
.hero h1 em { font-style: italic; color: var(--strawberry); }
.hero p.lede {
    font-size: 1.08rem; line-height: 1.6; color: var(--text-muted);
    max-width: 46ch; margin-bottom: 2rem;
}
.hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

.hero-visual { position: relative; height: 460px; }
.hero-photo-main {
    position: absolute; right: 4%; top: 6%;
    width: 78%; aspect-ratio: 4/5;
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(28,15,7,0.22);
    border: 6px solid var(--warm-white);
    transform: rotate(3deg);
}
.hero-photo-main img { width: 100%; height: 100%; object-fit: cover; }
.hero-photo-side {
    position: absolute; left: 0; bottom: 2%;
    width: 46%; aspect-ratio: 1/1;
    border-radius: var(--r-md);
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(28,15,7,0.2);
    border: 5px solid var(--warm-white);
    transform: rotate(-6deg);
}
.hero-photo-side img { width: 100%; height: 100%; object-fit: cover; }
.hero-badge {
    position: absolute; left: 2%; top: 4%;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    width: 108px; height: 108px; border-radius: 50%;
    background: var(--strawberry); color: white; text-align: center;
    font-weight: 800; font-size: .8rem; line-height: 1.25;
    box-shadow: 0 14px 26px rgba(107,69,48,0.4);
    transform: rotate(-10deg);
    animation: bob 5s ease-in-out infinite;
    z-index: 3;
}
.hero-badge span { display: block; font-size: 1.5rem; font-weight: 700; }
.float-deco { position: absolute; opacity: .8; animation: bob 6s ease-in-out infinite; --r: 0deg; }

@media (max-width: 980px) {
    .hero { padding: 3rem 1.5rem 4rem; }
    .hero-grid { grid-template-columns: 1fr; }
    .hero-visual { height: 340px; order: -1; }
}

/* ================= QUICK ACTIONS ================= */
.quick-actions {
    padding: 0 4rem; margin-top: -3.5rem; position: relative; z-index: 4;
}
.quick-actions-row {
    max-width: 1280px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.1rem;
}
.quick-card {
    background: var(--warm-white);
    border-radius: var(--r-md);
    padding: 1.5rem 1.2rem;
    box-shadow: 0 16px 32px rgba(28,15,7,0.1);
    border: 1px solid var(--border);
    display: flex; flex-direction: column; gap: .7rem;
    transition: transform .22s ease, box-shadow .22s ease;
    color: var(--text-dark);
}
.quick-card:hover { transform: translateY(-6px); box-shadow: 0 22px 40px rgba(28,15,7,0.16); }
.quick-card .qc-icon {
    width: 46px; height: 46px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
}
.quick-card .qc-title { font-weight: 800; font-size: .95rem; }
.quick-card .qc-sub { font-size: .78rem; color: var(--text-muted); line-height: 1.4; }
.qc-1 .qc-icon { background: var(--caramel-pale); }
.qc-2 .qc-icon { background: var(--strawberry-pale); }
.qc-3 .qc-icon { background: var(--butter-pale); }
.qc-4 .qc-icon { background: #EFE6D8; }
.qc-5 .qc-icon { background: var(--caramel-pale); }

@media (max-width: 980px) {
    .quick-actions { padding: 0 1.2rem; margin-top: -2.5rem; }
    .quick-actions-row { grid-template-columns: repeat(2, 1fr); }
}

/* ================= SECTION SHELL ================= */
.section { padding: 6rem 4rem 2rem; max-width: 1280px; margin: 0 auto; }
.section-head { max-width: 640px; margin-bottom: 2.6rem; }
.section-head h2 {
    font-weight: 700;
    font-size: clamp(1.9rem, 3vw, 2.6rem); color: var(--text-dark);
    line-height: 1.08; margin-top: .7rem;
}
.section-head p { color: var(--text-muted); margin-top: .8rem; line-height: 1.6; }
@media (max-width: 980px) { .section { padding: 4rem 1.2rem 1rem; } }

/* ================= SCREEN TO TABLE ================= */
.compare-wrap {
    position: relative;
    background: linear-gradient(160deg, var(--brown-deep) 0%, var(--brown-mid) 100%);
    border-radius: var(--r-lg);
    padding: 3.5rem;
    overflow: hidden;
}
.compare-wrap::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(circle at 85% 15%, rgba(232,176,122,0.14), transparent 45%);
}
.compare-head { position: relative; z-index: 2; margin-bottom: 2.5rem; max-width: 620px; }
.compare-head .eyebrow { color: var(--caramel-light); }
.compare-head .eyebrow::before { background: var(--caramel-light); }
.compare-head h2 {
    color: var(--warm-white); font-weight: 700;
    font-size: clamp(1.8rem, 2.8vw, 2.4rem); margin-top: .7rem; line-height: 1.1;
}
.compare-head p { color: rgba(253,246,237,0.7); margin-top: .8rem; line-height: 1.6; }

.compare-stage {
    position: relative; z-index: 2;
    display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 1.5rem;
}
.compare-panel {
    background: var(--warm-white); border-radius: var(--r-md); padding: 1.4rem;
    box-shadow: 0 24px 50px rgba(0,0,0,0.35);
}
.compare-panel .panel-tag {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .74rem; font-weight: 800; padding: .35rem .8rem; border-radius: 999px;
    margin-bottom: .9rem;
}
.compare-panel.design .panel-tag { background: var(--skyicing); color: #4a3826; }
.compare-panel.real .panel-tag { background: var(--strawberry); color: white; }
.compare-panel .frame {
    border-radius: var(--r-sm); overflow: hidden; aspect-ratio: 1/1;
    background: var(--cream-dark);
}
.compare-panel .frame img { width: 100%; height: 100%; object-fit: cover; }
.compare-panel .panel-caption { margin-top: .9rem; font-weight: 700; color: var(--text-dark); font-size: .92rem; }
.compare-panel .panel-sub { font-size: .8rem; color: var(--text-muted); margin-top: .2rem; }

.compare-divider {
    display: flex; flex-direction: column; align-items: center; gap: .6rem;
}
.compare-divider .vs-badge {
    width: 62px; height: 62px; border-radius: 50%;
    background: var(--caramel);
    color: white; font-weight: 700; font-size: 1.15rem;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 10px 22px rgba(200,137,74,0.5);
}
.compare-divider .arrow-track { width: 2px; height: 90px; background: linear-gradient(180deg, rgba(232,176,122,0.5), transparent); }

@media (max-width: 860px) {
    .compare-wrap { padding: 2rem 1.4rem; }
    .compare-stage { grid-template-columns: 1fr; }
    .compare-divider { flex-direction: row; }
    .compare-divider .arrow-track { width: 60px; height: 2px; }
}


.steps-wrap {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; position: relative;
}
.step-card { position: relative; padding: 0 1.4rem 0 0; }
.step-card:not(:last-child)::after {
    content: ''; position: absolute; top: 26px; right: -8px; width: calc(100% - 40px); height: 2px;
    background: repeating-linear-gradient(90deg, var(--caramel-light) 0 8px, transparent 8px 16px);
}
.step-num {
    width: 52px; height: 52px; border-radius: 50%; background: var(--brown-deep); color: var(--cream);
    display: flex; align-items: center; justify-content: center; font-family: var(--display); font-weight: 700;
    font-size: 1.2rem; margin-bottom: 1.2rem; position: relative; z-index: 2;
}
.step-title { font-weight: 800; color: var(--text-dark); font-size: 1.05rem; margin-bottom: .5rem; }
.step-desc { color: var(--text-muted); font-size: .88rem; line-height: 1.55; }

@media (max-width: 980px) {
    .steps-wrap { grid-template-columns: 1fr 1fr; row-gap: 2rem; }
    .step-card:not(:last-child)::after { display: none; }
}


.saved-scroll {
    display: flex; gap: 1.2rem; overflow-x: auto; padding-bottom: 1rem;
    scroll-snap-type: x mandatory;
}
.saved-scroll::-webkit-scrollbar { height: 6px; }
.saved-scroll::-webkit-scrollbar-thumb { background: var(--caramel-pale); border-radius: 999px; }
.saved-card {
    flex: 0 0 220px; scroll-snap-align: start;
    background: var(--warm-white); border-radius: var(--r-md); overflow: hidden;
    border: 1px solid var(--border); box-shadow: 0 10px 22px rgba(28,15,7,0.06);
}
.saved-card .saved-photo { aspect-ratio: 1/1; }
.saved-card .saved-photo img { width: 100%; height: 100%; object-fit: cover; }
.saved-card .saved-body { padding: .9rem 1rem 1.1rem; }
.saved-card .saved-name { font-weight: 800; font-size: .88rem; color: var(--text-dark); }
.saved-card .saved-price { color: var(--caramel); font-weight: 800; font-size: .82rem; margin-top: .25rem; }

(nothing — delete this whole block, including the trailing blank line before `</style>`)
</style>
@endpush

@section('content')
<div class="studio">

    {{-- ============================================================
         HERO
    ============================================================= --}}
    <section class="hero">
        <svg class="float-deco" viewBox="0 0 24 24" width="34" style="top:12%; right:8%; --r:12deg;" fill="none" stroke="var(--caramel)" stroke-width="2"><path d="M12 2l1.8 5.6H19l-4.6 3.5 1.8 5.6L12 13.2 7.8 16.7l1.8-5.6L5 7.6h5.2z"/></svg>
        <svg class="float-deco" viewBox="0 0 24 24" width="26" style="bottom:16%; left:44%; --r:-8deg; animation-delay:1.2s;" fill="var(--strawberry)"><circle cx="12" cy="12" r="6"/></svg>

        <div class="hero-grid">
            <div class="reveal">
                <span class="eyebrow">Welcome back{{ isset($customer) ? ', ' . $customer->first_name : '' }}</span>
                <h1>Design the cake.<br>Make it <em>yours</em>.</h1>
                <p class="lede">Build a cake exactly the way you picture it, then let real bakers bid to bring it to life. See it, customize it, get it &mdash; all in one place.</p>
                <div class="hero-actions">
                    <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/><path d="M12 11V7"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
                        Customize your cake
                    </a>
                    <a href="{{ url('/customer/cakes') }}" class="btn-secondary">Explore cakes</a>
                </div>
            </div>

            <div class="hero-visual reveal d2">
                <div class="hero-badge">See it.<span>Customize.<br>Get it.</span></div>
                <div class="hero-photo-main">
                    {{-- Replace with a real hero cake photograph --}}
                    <img src="{{ asset('images/cakes/hero-real-cake.jpg') }}" alt="A finished celebration cake made through BakeSphere" loading="lazy">
                </div>
                <div class="hero-photo-side">
                    {{-- Replace with a real detail/lifestyle photo --}}
                    <img src="{{ asset('images/cakes/hero-detail.jpg') }}" alt="Close-up detail of a BakeSphere cake" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         QUICK ACTIONS
    ============================================================= --}}
    <section class="quick-actions">
        <div class="quick-actions-row">
            <a href="{{ route('customer.cake-builder.index') }}" class="quick-card qc-1">
                <div class="qc-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="var(--brown-deep)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21v-7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v7"/><path d="M2 21h20"/><path d="M4 14c1-1.2 2-1.8 3-1.8s2 .6 3 1.8 2 1.8 3 1.8 2-.6 3-1.8 2-1.8 3-1.8"/><path d="M12 3v4"/><circle cx="12" cy="3.5" r="1.5"/></svg>
                </div>
                <div class="qc-title">Customize a cake</div>
                <div class="qc-sub">Start designing from scratch</div>
            </a>
            <a href="{{ url('/customer/cakes') }}" class="quick-card qc-2">
                <div class="qc-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="var(--brown-deep)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                </div>
                <div class="qc-title">Browse gallery</div>
                <div class="qc-sub">Get inspired by real cakes</div>
            </a>
            {{-- TODO: point to the customer order-tracking route --}}
            <a href="{{ url('/customer/orders') }}" class="quick-card qc-3">
                <div class="qc-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="var(--brown-deep)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                </div>
                <div class="qc-title">Track my orders</div>
                <div class="qc-sub">See status &amp; delivery</div>
            </a>
            {{-- TODO: point to the customer wallet route --}}
            <a href="{{ url('/customer/wallet') }}" class="quick-card qc-4">
                <div class="qc-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="var(--brown-deep)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 7V5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2"/><path d="M18 12h.01"/></svg>
                </div>
                <div class="qc-title">My wallet</div>
                <div class="qc-sub">Balance &amp; transactions</div>
            </a>
            {{-- TODO: point to the customer saved-designs route --}}
            <a href="{{ url('/customer/saved') }}" class="quick-card qc-5">
                <div class="qc-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="var(--brown-deep)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.1 21.35l-1.1-1.02C5.14 15.36 2 12.5 2 8.99 2 6.42 4.02 4.4 6.6 4.4c1.5 0 2.94.7 3.9 1.8a5.3 5.3 0 0 1 3.9-1.8c2.58 0 4.6 2.02 4.6 4.6 0 3.5-3.14 6.37-8.9 11.35l-1 0.99z"/></svg>
                </div>
                <div class="qc-title">Saved designs</div>
                <div class="qc-sub">Your favorite cakes</div>
            </a>
        </div>
    </section>

    {{-- ============================================================
         FROM YOUR SCREEN TO YOUR TABLE
    ============================================================= --}}
    <section class="section">
        <div class="compare-wrap reveal">
            <div class="compare-head">
                <span class="eyebrow">The BakeSphere difference</span>
                <h2>From your screen to your table.</h2>
                <p>Design your cake in the BakeSphere builder and see exactly how your digital creation becomes a real celebration cake.</p>
            </div>
            <div class="compare-stage">
                <div class="compare-panel design">
                    <span class="panel-tag">3D preview</span>
                    <div class="frame">
                        {{-- Replace with an export/screenshot from the cake builder --}}
                        <img src="{{ asset('images/cakes/compare-3d-preview.jpg') }}" alt="A cake design created in the BakeSphere 3D cake builder" loading="lazy">
                    </div>
                    <div class="panel-caption">Your design</div>
                    <div class="panel-sub">Built in the cake customizer</div>
                </div>

                <div class="compare-divider">
                    <div class="arrow-track"></div>
                    <div class="vs-badge">VS</div>
                    <div class="arrow-track"></div>
                </div>

                <div class="compare-panel real">
                    <span class="panel-tag">Real cake</span>
                    <div class="frame">
                        {{-- Replace with the real photographed result --}}
                        <img src="{{ asset('images/cakes/compare-real-cake.jpg') }}" alt="The finished physical cake baked from the design" loading="lazy">
                    </div>
                    <div class="panel-caption">Your finished cake</div>
                    <div class="panel-sub">Baked by a BakeSphere baker</div>
                </div>
            </div>
        </div>
    </section>


    <section class="section">
        <div class="section-head reveal">
            <span class="eyebrow">How it works</span>
            <h2>Your idea becomes a cake in four steps.</h2>
        </div>
        <div class="steps-wrap">
            <div class="step-card reveal">
                <div class="step-num">1</div>
                <div class="step-title">Design</div>
                <div class="step-desc">Customize your cake&rsquo;s shape, flavor, and decorations in the builder.</div>
            </div>
            <div class="step-card reveal d1">
                <div class="step-num">2</div>
                <div class="step-title">Set your budget</div>
                <div class="step-desc">Tell bakers what you&rsquo;re looking for and what you&rsquo;re willing to spend.</div>
            </div>
            <div class="step-card reveal d2">
                <div class="step-num">3</div>
                <div class="step-title">Receive offers</div>
                <div class="step-desc">Bakers review your request and bid to make it for you.</div>
            </div>
            <div class="step-card reveal d3">
                <div class="step-num">4</div>
                <div class="step-title">Order &amp; enjoy</div>
                <div class="step-desc">Pick your baker, track the order, and enjoy your cake.</div>
            </div>
        </div>
    </section>


    @if(!empty($savedCakes))
    <section class="section">
        <div class="section-head reveal">
            <span class="eyebrow">Saved for later</span>
            <h2>Your favorite cakes</h2>
        </div>
        <div class="saved-scroll">
            @foreach($savedCakes as $cake)
                <div class="saved-card">
                    <div class="saved-photo">
                        <img src="{{ $cake->image_url ?? asset('images/cakes/placeholder-cake.jpg') }}" alt="{{ $cake->name }}" loading="lazy">
                    </div>
                    <div class="saved-body">
                        <div class="saved-name">{{ $cake->name }}</div>
                        <div class="saved-price">From &#8369;{{ number_format($cake->starting_price ?? 0) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) e.target.style.animationPlayState = 'running'; });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
}


</script>
@endpush