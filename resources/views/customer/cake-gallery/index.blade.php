@extends('layouts.customer')
@section('title', 'Cake Gallery')

@push('styles')
<style>
/* ── BASE ── */
.gallery-wrap { max-width: 1100px; }

.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
.section-title  { font-size: 1.1rem; font-weight: 700; color: var(--brown-deep); display: flex; align-items: center; gap: 0.5rem; }
.section-sub    { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.15rem; }
.section-link   { font-size: 0.78rem; color: var(--caramel); font-weight: 600; text-decoration: none; }
.section-link:hover { text-decoration: underline; }

.gallery-section { margin-bottom: 2.5rem; }

/* ── HERO ── */
.gallery-hero {
    background: linear-gradient(135deg, #2C1A0E 0%, #7A4A28 60%, #C8894A 100%);
    border-radius: 20px; padding: 2.5rem 2rem; margin-bottom: 2rem;
    color: white; position: relative; overflow: hidden;
}
.gallery-hero::before { content:''; position:absolute; top:-60px; right:-60px; width:220px; height:220px; background:rgba(255,255,255,0.06); border-radius:50%; }
.gallery-hero::after  { content:''; position:absolute; bottom:-80px; right:80px; width:160px; height:160px; background:rgba(255,255,255,0.04); border-radius:50%; }
.hero-title   { font-size: 1.8rem; font-weight: 800; margin-bottom: 0.4rem; position: relative; z-index: 1; }
.hero-sub     { font-size: 0.9rem; opacity: 0.75; margin-bottom: 1.5rem; position: relative; z-index: 1; line-height: 1.6; }
.hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; position: relative; z-index: 1; }
.hero-btn-primary {
    background: white; color: var(--brown-deep); padding: 0.65rem 1.4rem;
    border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none;
    transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem;
}
.hero-btn-primary:hover { background: var(--caramel-light); color: white; }
.hero-btn-secondary {
    background: rgba(255,255,255,0.15); color: white; border: 1.5px solid rgba(255,255,255,0.3);
    padding: 0.65rem 1.4rem; border-radius: 10px; font-weight: 600; font-size: 0.875rem;
    text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem;
}
.hero-btn-secondary:hover { background: rgba(255,255,255,0.25); color: white; }

/* ── BUDGET TIERS ── */
.budget-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.85rem; }
.budget-card {
    background: var(--warm-white); border: 1.5px solid var(--border); border-radius: 14px;
    padding: 1.1rem 1rem; text-align: center; cursor: pointer; text-decoration: none;
    transition: all 0.2s; display: block;
}
.budget-card:hover, .budget-card.active { border-color: var(--caramel); background: #FBF4EC; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(200,137,74,0.2); }
.budget-icon  { font-size: 1.5rem; margin-bottom: 0.4rem; }
.budget-label { font-size: 0.78rem; font-weight: 700; color: var(--brown-deep); }
.budget-hint  { font-size: 0.65rem; color: var(--text-muted); margin-top: 0.15rem; }

/* ── TRENDING ── */
.trending-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.trending-card {
    background: var(--warm-white); border: 1px solid var(--border); border-radius: 14px;
    overflow: hidden; transition: all 0.2s; cursor: pointer; text-decoration: none; display: block;
}
.trending-card:hover { box-shadow: 0 8px 32px rgba(44,26,14,0.12); transform: translateY(-2px); }
.trending-img {
    width: 100%; aspect-ratio: 4/3; background: var(--cream);
    display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
    position: relative; overflow: hidden;
}
.trending-img img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.trending-rank {
    position: absolute; top: 0.5rem; left: 0.5rem;
    background: var(--caramel); color: white; font-size: 0.62rem; font-weight: 700;
    padding: 0.15rem 0.5rem; border-radius: 6px;
}
.trending-body  { padding: 0.85rem; }
.trending-name  { font-size: 0.85rem; font-weight: 700; color: var(--brown-deep); margin-bottom: 0.2rem; }
.trending-meta  { font-size: 0.7rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.4rem; }
.trending-price { font-size: 0.78rem; font-weight: 700; color: var(--caramel); margin-top: 0.4rem; }

/* ── OCCASIONS ── */
.occasion-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 0.75rem; }
.occasion-card {
    background: var(--warm-white); border: 1.5px solid var(--border); border-radius: 14px;
    padding: 1rem 0.5rem; text-align: center; cursor: pointer; text-decoration: none;
    transition: all 0.2s; display: block;
}
.occasion-card:hover { border-color: var(--caramel); background: #FBF4EC; transform: translateY(-2px); }
.occasion-icon  { font-size: 1.75rem; margin-bottom: 0.4rem; display: block; }
.occasion-label { font-size: 0.72rem; font-weight: 700; color: var(--brown-deep); }

/* ── TEMPLATES ── */
.templates-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.template-card {
    background: var(--warm-white); border: 1.5px solid var(--border); border-radius: 14px;
    padding: 1.25rem; transition: all 0.2s; position: relative; overflow: hidden;
}
.template-card:hover { border-color: var(--caramel); box-shadow: 0 4px 20px rgba(200,137,74,0.15); transform: translateY(-2px); }
.template-card::before { content:''; position:absolute; top:0; right:0; width:80px; height:80px; background:rgba(200,137,74,0.05); border-radius:50% 0 0 50%; }
.template-icon  { font-size: 2rem; margin-bottom: 0.6rem; display: block; }
.template-tag   { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--caramel); background: rgba(200,137,74,0.1); padding: 0.15rem 0.5rem; border-radius: 20px; display: inline-block; margin-bottom: 0.4rem; }
.template-name  { font-size: 0.9rem; font-weight: 700; color: var(--brown-deep); margin-bottom: 0.5rem; }
.template-specs { display: flex; flex-wrap: wrap; gap: 0.3rem; margin-bottom: 0.85rem; }
.template-spec  { font-size: 0.65rem; font-weight: 600; padding: 0.15rem 0.45rem; background: var(--cream); border: 1px solid var(--border); border-radius: 6px; color: var(--text-muted); }
.template-btn {
    display: inline-flex; align-items: center; gap: 0.35rem;
    background: var(--caramel); color: white; border: none; border-radius: 8px;
    padding: 0.45rem 0.9rem; font-size: 0.75rem; font-weight: 700; cursor: pointer;
    text-decoration: none; transition: background 0.2s;
}
.template-btn:hover { background: var(--brown-light); color: white; }

/* ── BAKER SHOWCASE ── */
.baker-showcase-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.baker-showcase-card {
    background: var(--warm-white); border: 1px solid var(--border); border-radius: 14px;
    overflow: hidden; transition: all 0.2s;
}
.baker-showcase-card:hover { box-shadow: 0 6px 24px rgba(44,26,14,0.1); transform: translateY(-2px); }
.baker-sample-img {
    width: 100%; height: 140px; background: linear-gradient(135deg, #3B1F0F, #7A4A28);
    display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
    position: relative; overflow: hidden;
}
.baker-sample-img img { width: 100%; height: 100%; object-fit: cover; }
.baker-showcase-body { padding: 1rem; }
.baker-showcase-row  { display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.5rem; }
.baker-showcase-avatar {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0; overflow: hidden;
    background: linear-gradient(135deg, #C07840, #E8A96A);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.85rem; color: white;
}
.baker-showcase-avatar img { width: 100%; height: 100%; object-fit: cover; }
.baker-showcase-name { font-size: 0.85rem; font-weight: 700; color: var(--brown-deep); }
.baker-showcase-meta { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.1rem; }
.baker-showcase-rating { display: flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; margin-bottom: 0.6rem; }
.baker-stars { color: #F5A623; }
.baker-showcase-btn {
    display: block; text-align: center; background: var(--caramel); color: white;
    border-radius: 8px; padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 700;
    text-decoration: none; transition: background 0.2s;
}
.baker-showcase-btn:hover { background: var(--brown-light); color: white; }

/* ── RECENT FEED ── */
.recent-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.85rem; }
.recent-card {
    border-radius: 12px; overflow: hidden; aspect-ratio: 1;
    position: relative; cursor: pointer; background: var(--cream);
    display: flex; align-items: center; justify-content: center; font-size: 2rem;
}
.recent-card img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; transition: transform 0.3s; }
.recent-card:hover img { transform: scale(1.05); }
.recent-card-overlay {
    position: absolute; inset: 0; background: linear-gradient(to top, rgba(44,26,14,0.7), transparent);
    opacity: 0; transition: opacity 0.2s; display: flex; align-items: flex-end; padding: 0.6rem;
}
.recent-card:hover .recent-card-overlay { opacity: 1; }
.recent-card-label { font-size: 0.7rem; font-weight: 700; color: white; }

/* ── EMPTY ── */
.gallery-empty { text-align: center; padding: 3rem 2rem; color: var(--text-muted); }
.gallery-empty .e-icon { font-size: 2.5rem; margin-bottom: 0.85rem; }
.gallery-empty h3 { font-size: 1rem; font-weight: 700; color: var(--brown-mid); margin-bottom: 0.4rem; }
.gallery-empty p  { font-size: 0.82rem; }

@media (max-width: 768px) {
    .budget-grid       { grid-template-columns: repeat(2, 1fr); }
    .trending-grid     { grid-template-columns: repeat(2, 1fr); }
    .occasion-grid     { grid-template-columns: repeat(3, 1fr); }
    .templates-grid    { grid-template-columns: 1fr; }
    .baker-showcase-grid { grid-template-columns: repeat(2, 1fr); }
    .recent-grid       { grid-template-columns: repeat(3, 1fr); }
}
</style>
@endpush

@section('content')
<div class="gallery-wrap">

{{-- ── HERO ── --}}
<div class="gallery-hero">
    <div class="hero-title"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg> Cake Gallery</div>
    <div class="hero-sub">Browse designs, pick a template, or get inspired — then build your perfect cake.</div>
    <div class="hero-actions">
        <a href="{{ route('customer.cake-builder.index') }}" class="hero-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> Build My Cake
        </a>
        <a href="{{ route('customer.cake-requests.index') }}" class="hero-btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg> My Orders
        </a>
    </div>
</div>

{{-- ── BUDGET TIERS ── --}}
<div class="gallery-section">
    <div class="section-header">
        <div>
            <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg> Shop by Budget</div>
            <div class="section-sub">Find cakes that fit your price range</div>
        </div>
    </div>
    <div class="budget-grid">
        @foreach($budgetTiers as $tier)
        <a href="{{ route('customer.cake-builder.index') }}?budget_min={{ $tier['min'] }}&budget_max={{ $tier['max'] }}"
           class="budget-card {{ $selectedBudget === $tier['label'] ? 'active' : '' }}">
            <div class="budget-icon">{{ $tier['icon'] }}</div>
            <div class="budget-label">{{ $tier['label'] }}</div>
            <div class="budget-hint">Tap to order</div>
        </a>
        @endforeach
    </div>
</div>

{{-- ── TRENDING ── --}}
@if($trending->count() > 0)
<div class="gallery-section">
    <div class="section-header">
        <div>
            <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg> Trending Cakes</div>
            <div class="section-sub">Most ordered by customers like you</div>
        </div>
    </div>
    <div class="trending-grid">
        @foreach($trending as $i => $item)
        @php
            $cfg   = $item['config'];
            $label = ($cfg['flavor'] ?? '') . ' ' . ($cfg['frosting'] ?? '');
        @endphp
        <a href="{{ route('customer.cake-builder.index') }}?flavor={{ urlencode($cfg['flavor'] ?? '') }}&frosting={{ urlencode($cfg['frosting'] ?? '') }}&size={{ urlencode($cfg['size'] ?? '') }}"
           class="trending-card">
            <div class="trending-img">
                @if($item['image'])
                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $label }}">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.4"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>
                @endif
                <div class="trending-rank">#{{ $i + 1 }}</div>
            </div>
            <div class="trending-body">
                <div class="trending-name">{{ trim($label) ?: 'Custom Cake' }}</div>
                <div class="trending-meta">
                    <span>{{ $cfg['size'] ?? '' }}</span>
                    @if($cfg['addons'] ?? false)
                        <span>·</span><span>{{ count((array)$cfg['addons']) }} add-on{{ count((array)$cfg['addons']) !== 1 ? 's' : '' }}</span>
                    @endif
                    <span>·</span><span>{{ $item['count'] }} orders</span>
                </div>
                <div class="trending-price">
                    ₱{{ number_format($item['min_price'], 0) }}–₱{{ number_format($item['max_price'], 0) }}
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ── OCCASIONS ── --}}
<div class="gallery-section">
    <div class="section-header">
        <div>
            <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M5.8 11.3 2 22l10.7-3.79"/><path d="M4 3h.01"/><path d="M22 8h.01"/><path d="M15 2h.01"/><path d="M22 20h.01"/><path d="m22 2-2.24.75a2.9 2.9 0 0 0-1.96 3.12c.1.86-.57 1.63-1.45 1.63h-.38c-.86 0-1.6.6-1.76 1.44L14 10"/><path d="m22 13-.82-.33c-.86-.34-1.82.2-1.98 1.11c-.11.7-.72 1.22-1.43 1.22H17"/><path d="m11 2 .33.82c.34.86-.2 1.82-1.11 1.98C9.52 4.9 9 5.52 9 6.23V7"/><path d="M11 13c1.93 1.93 2.83 4.17 2 5-.83.83-3.07-.07-5-2-1.93-1.93-2.83-4.17-2-5 .83-.83 3.07.07 5 2z"/></svg> Shop by Occasion</div>
            <div class="section-sub">Find the perfect cake for every celebration</div>
        </div>
    </div>
    <div class="occasion-grid">
        @foreach($occasions as $occasion)
        <a href="{{ route('customer.cake-builder.index') }}?occasion={{ urlencode($occasion['label']) }}"
           class="occasion-card">
            <span class="occasion-icon">{{ $occasion['icon'] }}</span>
            <div class="occasion-label">{{ $occasion['label'] }}</div>
        </a>
        @endforeach
    </div>
</div>

{{-- ── CUSTOMIZABLE TEMPLATES ── --}}
<div class="gallery-section">
    <div class="section-header">
        <div>
            <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg> Start from a Template</div>
            <div class="section-sub">Pick a base design and customize it in the 3D builder</div>
        </div>
        <a href="{{ route('customer.cake-builder.index') }}" class="section-link">Customize freely →</a>
    </div>
    <div class="templates-grid">
        @foreach($templates as $tpl)
        <div class="template-card">
            <span class="template-icon">{{ $tpl['icon'] }}</span>
            <span class="template-tag">{{ $tpl['tag'] }}</span>
            <div class="template-name">{{ $tpl['name'] }}</div>
            <div class="template-specs">
                <span class="template-spec">{{ $tpl['size'] }}</span>
                <span class="template-spec">{{ $tpl['flavor'] }}</span>
                <span class="template-spec">{{ $tpl['frosting'] }}</span>
            </div>
            <a href="{{ route('customer.cake-builder.index') }}?flavor={{ urlencode($tpl['flavor']) }}&frosting={{ urlencode($tpl['frosting']) }}&size={{ urlencode($tpl['size']) }}"
               class="template-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg> Customize This
            </a>
        </div>
        @endforeach
    </div>
</div>

{{-- ── BAKER SHOWCASE ── --}}
@if($topBakers->count() > 0)
<div class="gallery-section">
    <div class="section-header">
        <div>
            <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" x2="18" y1="17" y2="17"/></svg> Baker Showcase</div>
            <div class="section-sub">Top-rated bakers on BakeSphere</div>
        </div>
    </div>
    <div class="baker-showcase-grid">
        @foreach($topBakers as $b)
        <div class="baker-showcase-card">
            <div class="baker-sample-img">
                @if($b['sample_photo'])
                    <img src="{{ asset('storage/' . $b['sample_photo']) }}" alt="Sample">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.4"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>
                @endif
            </div>
            <div class="baker-showcase-body">
                <div class="baker-showcase-row">
                    <div class="baker-showcase-avatar">
                        @if($b['user']->profile_photo)
                            <img src="{{ str_starts_with($b['user']->profile_photo, 'http') ? $b['user']->profile_photo : asset('storage/'.$b['user']->profile_photo) }}" alt="">
                        @else
                            {{ strtoupper(substr($b['user']->first_name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="baker-showcase-name">{{ $b['user']->first_name }} {{ $b['user']->last_name }}</div>
                        <div class="baker-showcase-meta">{{ $b['completed'] }} completed order{{ $b['completed'] !== 1 ? 's' : '' }}</div>
                    </div>
                </div>
                @if($b['avg_rating'])
                <div class="baker-showcase-rating">
                    <span class="baker-stars">
                        @for($s = 1; $s <= 5; $s++)
                            {{ $s <= round($b['avg_rating']) ? '★' : '☆' }}
                        @endfor
                    </span>
                    <span style="font-weight:700; color:var(--brown-deep);">{{ number_format($b['avg_rating'], 1) }}</span>
                    <span style="color:var(--text-muted);">({{ $b['review_count'] }})</span>
                </div>
                @endif
                <a href="{{ route('customer.cake-builder.index') }}?baker={{ $b['baker']->id }}"
                   class="baker-showcase-btn">
                    Order from this Baker
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ── RECENT COMPLETED CAKES ── --}}
@if($recentCakes->count() > 0)
<div class="gallery-section">
    <div class="section-header">
        <div>
            <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg> Recently Made</div>
            <div class="section-sub">Real cakes made by our bakers</div>
        </div>
    </div>
    <div class="recent-grid">
        @foreach($recentCakes as $cake)
        <a href="{{ route('customer.cake-builder.index') }}" class="recent-card">
            @if($cake->cake_preview_image)
                <img src="{{ asset('storage/' . $cake->cake_preview_image) }}" alt="Recent cake">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.4"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/></svg>
            @endif
            <div class="recent-card-overlay">
                <div class="recent-card-label">
                    @php $cfg = is_array($cake->cake_configuration) ? $cake->cake_configuration : json_decode($cake->cake_configuration, true); @endphp
                    {{ $cfg['flavor'] ?? 'Custom' }} · {{ $cfg['size'] ?? '' }}
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@else
<div class="gallery-empty">
    <div class="e-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg></div>
    <h3>No completed cakes yet</h3>
    <p>Be the first — order a cake and it'll appear here once delivered!</p>
</div>
@endif

</div>
@endsection