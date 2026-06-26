@extends('layouts.customer')
@section('title', 'Cake Gallery')

@push('styles')
<style>
/* ═══════════════════════════════════════════════
   DESIGN TOKENS — Luxury Cake Boutique
═══════════════════════════════════════════════ */
:root {
    --ivory:        #FAF7F2;
    --ivory-warm:   #F5EFE4;
    --cream-light:  #EDE3D3;
    --espresso:     #1C0F08;
    --espresso-mid: #3D2010;
    --caramel:      #C07840;
    --caramel-light:#D4A96A;
    --blush:        #F2DDD0;
    --blush-deep:   #E8C8B4;
    --gold:         #B8935A;
    --text-muted:   #8A7060;
    --text-mid:     #5C3D28;

    --radius-sm:  8px;
    --radius-md:  16px;
    --radius-lg:  24px;
    --radius-xl:  36px;

    --shadow-sm:  0 2px 12px rgba(28,15,8,.06);
    --shadow-md:  0 8px 32px rgba(28,15,8,.10);
    --shadow-lg:  0 20px 60px rgba(28,15,8,.16);
    --shadow-xl:  0 32px 80px rgba(28,15,8,.22);

    --transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* ─── RESET / PAGE BASE ─── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.gallery-page {
    background: var(--ivory);
    color: var(--espresso);
    font-family: 'Plus Jakarta Sans', sans-serif;
    overflow-x: hidden;
}

/* ─── UTILITY ─── */
.eyebrow {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--caramel);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.eyebrow::before, .eyebrow::after {
    content: '';
    display: block;
    height: 1px;
    width: 28px;
    background: var(--caramel);
    opacity: 0.5;
}

.display-headline {
    font-size: clamp(2.2rem, 4.5vw, 3.6rem);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: var(--espresso);
}
.display-headline em {
    font-style: italic;
    font-weight: 300;
    color: var(--caramel);
}

.section-wrap { padding: 0 4rem; }

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--espresso);
    color: white;
    padding: 0.8rem 1.75rem;
    border-radius: 100px;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition);
}
.btn-primary:hover {
    background: var(--caramel);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(192,120,64,.3);
}

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: transparent;
    color: var(--espresso);
    padding: 0.75rem 1.6rem;
    border-radius: 100px;
    font-size: 0.82rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-decoration: none;
    border: 1.5px solid rgba(28,15,8,.2);
    cursor: pointer;
    transition: var(--transition);
}
.btn-ghost:hover {
    border-color: var(--caramel);
    color: var(--caramel);
    transform: translateY(-1px);
}

.btn-caramel {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--caramel);
    color: white;
    padding: 0.7rem 1.5rem;
    border-radius: 100px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-decoration: none;
    transition: var(--transition);
}
.btn-caramel:hover {
    background: var(--espresso);
    color: white;
    transform: translateY(-1px);
}


/* ══════════════════════════════════════════════
   1. SHOP BY BUDGET — Opening section
══════════════════════════════════════════════ */
.budget-hero-section {
    background: var(--ivory);
    padding: 4.5rem 0 3.5rem;
    border-bottom: 1px solid var(--cream-light);
}
.budget-hero-inner {
    padding: 0 4rem;
}
.budget-hero-top {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 2.75rem;
    flex-wrap: wrap;
}
.budget-hero-sub {
    font-size: 0.88rem;
    color: var(--text-muted);
    margin-top: 0.65rem;
    line-height: 1.65;
    max-width: 440px;
}
.budget-hero-actions {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
    align-items: center;
}

/* Budget cards */
.budget-cards-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
.budget-hero-card {
    display: block;
    text-decoration: none;
    background: white;
    border: 1.5px solid var(--cream-light);
    border-radius: var(--radius-xl);
    padding: 1.75rem 1.5rem;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.budget-hero-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(192,120,64,0) 0%, rgba(192,120,64,0.06) 100%);
    opacity: 0;
    transition: opacity 0.3s;
}
.budget-hero-card:hover::before,
.budget-hero-card.active::before { opacity: 1; }
.budget-hero-card:hover,
.budget-hero-card.active {
    border-color: var(--caramel);
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(192,120,64,.15);
}
.bhc-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 1rem;
}
.bhc-label {
    font-size: 0.92rem;
    font-weight: 800;
    color: var(--espresso);
    display: block;
    margin-bottom: 0.3rem;
    letter-spacing: -0.01em;
}
.bhc-hint {
    font-size: 0.7rem;
    color: var(--text-muted);
}
.bhc-arrow {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    font-size: 1rem;
    color: var(--caramel);
    opacity: 0;
    transform: translateX(-4px);
    transition: all 0.25s;
}
.budget-hero-card:hover .bhc-arrow,
.budget-hero-card.active .bhc-arrow {
    opacity: 1;
    transform: translateX(0);
}

@media (max-width: 768px) {
    .budget-hero-top { flex-direction: column; align-items: flex-start; }
    .budget-cards-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 420px) {
    .budget-cards-grid { grid-template-columns: 1fr 1fr; }
}


/* ══════════════════════════════════════════════
   3. SIGNATURE COLLECTION (was: Trending)
══════════════════════════════════════════════ */
.signature-section {
    padding: 5.5rem 0;
    background: var(--ivory);
}

.section-header-editorial {
    padding: 0 4rem;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 3.5rem;
    gap: 2rem;
}
.section-header-editorial .left { }
.section-header-editorial .eyebrow { margin-bottom: 1rem; }
.section-header-editorial .link-see-all {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--caramel);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    white-space: nowrap;
    padding-bottom: 0.25rem;
    border-bottom: 1.5px solid var(--caramel);
    transition: opacity 0.2s;
}
.section-header-editorial .link-see-all:hover { opacity: 0.7; }

/* Main collection layout */
.signature-grid {
    padding: 0 4rem;
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 1.5rem;
}

.sig-card {
    position: relative;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: var(--cream-light);
    cursor: pointer;
    text-decoration: none;
    display: block;
    transition: var(--transition);
}
.sig-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-xl); }

.sig-card-main { aspect-ratio: 4/3; }

.sig-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.sig-card:hover .sig-card-img { transform: scale(1.04); }

.sig-card-placeholder {
    width: 100%;
    height: 100%;
    min-height: 340px;
    background: linear-gradient(135deg, #3D2010 0%, #7A4A28 60%, #C8894A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
}

.sig-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(28,15,8,.85) 0%, rgba(28,15,8,.1) 50%, transparent 100%);
}

.sig-card-body {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.75rem;
}

.sig-rank {
    display: inline-block;
    background: var(--caramel);
    color: white;
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 0.25rem 0.65rem;
    border-radius: 100px;
    margin-bottom: 0.65rem;
}

.sig-name {
    font-size: 1.25rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.4rem;
    letter-spacing: -0.01em;
}
.sig-name-sm { font-size: 1rem; }

.sig-desc {
    font-size: 0.75rem;
    color: rgba(255,255,255,.6);
    line-height: 1.5;
    margin-bottom: 0.85rem;
}

.sig-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sig-price {
    font-size: 1rem;
    font-weight: 800;
    color: var(--caramel-light);
    letter-spacing: -0.01em;
}
.sig-price-sm { font-size: 0.88rem; }

.sig-meta {
    font-size: 0.68rem;
    color: rgba(255,255,255,.5);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.sig-action {
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.2);
    color: white;
    border-radius: 100px;
    padding: 0.4rem 1rem;
    font-size: 0.7rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}
.sig-action:hover { background: white; color: var(--espresso); }

/* Heart/save icon */
.sig-save {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 5;
    font-size: 0.85rem;
}
.sig-save:hover { background: white; color: #e05a5a; }

/* Side stack of smaller cards */
.sig-stack { display: flex; flex-direction: column; gap: 1.5rem; }
.sig-card-side { aspect-ratio: unset; }
.sig-card-side .sig-card-placeholder { min-height: 220px; }


/* ══════════════════════════════════════════════
   4. CELEBRATIONS — large visual category cards
══════════════════════════════════════════════ */
.celebrations-section {
    padding: 5.5rem 0;
    background: var(--ivory-warm);
}

.celebrations-scroll {
    padding: 0 4rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.celebration-card {
    position: relative;
    border-radius: var(--radius-xl);
    overflow: hidden;
    aspect-ratio: 3/4;
    cursor: pointer;
    text-decoration: none;
    display: block;
    transition: var(--transition);
    background: var(--cream-light);
}
.celebration-card:hover { transform: translateY(-4px) scale(1.01); box-shadow: var(--shadow-xl); }

.celebration-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.celebration-card:hover .celebration-img { transform: scale(1.06); }

.celebration-bg-placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
}

/* Unique gradient per occasion */
.cel-bg-birthday  { background: linear-gradient(160deg, #4A1E08, #A0501E, #E8A056); }
.cel-bg-wedding   { background: linear-gradient(160deg, #1E1628, #4A3060, #C8A0E0); }
.cel-bg-anniversary { background: linear-gradient(160deg, #1E0810, #7A1830, #D45A60); }
.cel-bg-graduation{ background: linear-gradient(160deg, #0A2820, #1A5A40, #50A878); }
.cel-bg-baby      { background: linear-gradient(160deg, #101E30, #2858A0, #80B8E8); }
.cel-bg-corporate { background: linear-gradient(160deg, #1A1410, #4A3828, #8A6848); }

.celebration-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(28,15,8,.75) 0%, rgba(28,15,8,.05) 55%, transparent 100%);
}
.celebration-body {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.75rem;
}
.cel-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 0.75rem;
}
.cel-label {
    font-size: 1.15rem;
    font-weight: 800;
    color: white;
    letter-spacing: -0.01em;
    display: block;
    margin-bottom: 0.35rem;
}
.cel-hint {
    font-size: 0.7rem;
    color: rgba(255,255,255,.55);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.cel-arrow {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
    transition: all 0.25s;
}
.celebration-card:hover .cel-arrow {
    background: white;
    color: var(--espresso);
    transform: rotate(45deg);
}

/* Full-width feature row */
.celebrations-feature-row {
    
    margin: 1.25rem auto 0;
    padding: 0 3.5rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.celebration-card-wide {
    aspect-ratio: 16/7;
    border-radius: var(--radius-lg);
}


/* ══════════════════════════════════════════════
   5. SEASONAL BANNER
══════════════════════════════════════════════ */
.seasonal-section {
    padding: 5rem 0;
    background: var(--ivory);
}

.seasonal-wrap {
    padding: 0 4rem;
}

.seasonal-banner {
    border-radius: var(--radius-xl);
    overflow: hidden;
    position: relative;
    padding: 3.5rem 3rem;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 2rem;
    min-height: 200px;
    text-decoration: none;
    transition: var(--transition);
}
.seasonal-banner:hover { transform: translateY(-2px); box-shadow: var(--shadow-xl); }

.sb-espresso { background: linear-gradient(130deg, #1C0F08 0%, #3D2010 50%, #5C3020 100%); }
.sb-rose     { background: linear-gradient(130deg, #2E0818 0%, #7A1838 50%, #D45878 100%); }
.sb-green    { background: linear-gradient(130deg, #0A2018 0%, #1A5038 50%, #40A870 100%); }
.sb-gold     { background: linear-gradient(130deg, #2A1808 0%, #7A4818 50%, #C89040 100%); }

.sb-deco {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}
.sb-circle-1 {
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    top: -100px; right: -60px;
}
.sb-circle-2 {
    position: absolute;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    bottom: -60px; right: 180px;
}

.sb-content { position: relative; z-index: 2; }
.sb-eyebrow {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: rgba(255,255,255,.6);
    margin-bottom: 0.65rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.sb-headline {
    font-size: 1.6rem;
    font-weight: 800;
    color: white;
    letter-spacing: -0.02em;
    line-height: 1.15;
    margin-bottom: 0.5rem;
}
.sb-desc {
    font-size: 0.8rem;
    color: rgba(255,255,255,.55);
    line-height: 1.6;
    max-width: 380px;
}

.sb-cta {
    position: relative;
    z-index: 2;
    flex-shrink: 0;
}
.sb-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    color: var(--espresso);
    padding: 0.8rem 1.6rem;
    border-radius: 100px;
    font-size: 0.78rem;
    font-weight: 800;
    white-space: nowrap;
    text-decoration: none;
    transition: all 0.2s;
}
.sb-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(0,0,0,.2); }

.seasonal-banners-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}


/* ══════════════════════════════════════════════
   6. DESIGNER'S PICKS (was: Templates)
══════════════════════════════════════════════ */
.picks-section {
    padding: 5.5rem 0;
    background: var(--espresso);
}

.picks-wrap {
    padding: 0 4rem;
}

.picks-header { margin-bottom: 3.5rem; }
.picks-header .eyebrow { color: var(--caramel-light); }
.picks-header .eyebrow::before,
.picks-header .eyebrow::after { background: var(--caramel-light); }
.picks-header .display-headline { color: white; }

.picks-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.pick-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
}
.pick-card:hover {
    background: rgba(255,255,255,.07);
    border-color: rgba(192,120,64,.3);
    transform: translateY(-4px);
    box-shadow: 0 20px 60px rgba(0,0,0,.3);
}

.pick-visual {
    aspect-ratio: 4/3;
    background: rgba(255,255,255,.05);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    position: relative;
    overflow: hidden;
}
.pick-visual img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    transition: transform 0.5s;
}
.pick-card:hover .pick-visual img { transform: scale(1.04); }
.pick-emoji {
    position: relative;
    z-index: 1;
}

.pick-editorial-label {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    padding: 1rem 1.25rem;
    background: linear-gradient(to bottom, rgba(0,0,0,.4), transparent);
}
.pick-label-text {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: rgba(255,255,255,.8);
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
    padding: 0.25rem 0.7rem;
    border-radius: 100px;
    display: inline-block;
}

.pick-body { padding: 1.5rem; flex: 1; display: flex; flex-direction: column; }
.pick-name {
    font-size: 1rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
    letter-spacing: -0.01em;
}
.pick-specs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-bottom: 1.25rem;
}
.pick-spec {
    font-size: 0.65rem;
    font-weight: 600;
    color: rgba(255,255,255,.5);
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
}
.pick-cta {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.pick-price {
    font-size: 0.75rem;
    color: var(--caramel-light);
    font-weight: 600;
}

.pick-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--caramel);
    color: white;
    border: none;
    border-radius: 100px;
    padding: 0.5rem 1.1rem;
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}
.pick-btn:hover { background: white; color: var(--espresso); }


/* ══════════════════════════════════════════════
   7. RECENT CREATIONS — Pinterest masonry
══════════════════════════════════════════════ */
.creations-section {
    padding: 5.5rem 0;
    background: var(--ivory-warm);
}

.masonry-grid {
    padding: 0 4rem;
    columns: 4;
    column-gap: 1rem;
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 1rem;
    display: block;
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
    background: var(--cream-light);
}
.masonry-item:nth-child(3n+1) { }
.masonry-item:nth-child(3n+2) { }
.masonry-item:nth-child(3n)   { margin-top: 2rem; }

.masonry-item img {
    width: 100%;
    display: block;
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.masonry-item:hover img { transform: scale(1.04); }

.masonry-placeholder {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    background: linear-gradient(135deg, #3D2010, #7A4A28);
}
.masonry-item:nth-child(odd) .masonry-placeholder { min-height: 220px; }
.masonry-item:nth-child(even) .masonry-placeholder { min-height: 160px; }
.masonry-item:nth-child(3n) .masonry-placeholder { min-height: 280px; }

.masonry-hover {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(28,15,8,.8) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s;
    display: flex;
    align-items: flex-end;
    padding: 1rem;
}
.masonry-item:hover .masonry-hover { opacity: 1; }

.masonry-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: white;
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}
.masonry-sub { font-size: 0.62rem; color: rgba(255,255,255,.6); font-weight: 400; }


/* ══════════════════════════════════════════════
   8. MEET THE BAKERS
══════════════════════════════════════════════ */
.bakers-section {
    padding: 5.5rem 0;
    background: white;
}

.bakers-grid {
    padding: 0 4rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.baker-card {
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: var(--transition);
    background: var(--ivory);
    border: 1px solid var(--cream-light);
}
.baker-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--blush-deep);
}

.baker-portfolio {
    height: 220px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #3D2010, #7A4A28);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
}
.baker-portfolio img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    transition: transform 0.5s;
}
.baker-card:hover .baker-portfolio img { transform: scale(1.04); }

.baker-portfolio-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(28,15,8,.5), transparent);
}

/* Avatar pulled up */
.baker-avatar-wrap {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0 1.5rem;
    margin-top: -28px;
    position: relative;
    z-index: 5;
    margin-bottom: 0.75rem;
}
.baker-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: 3px solid white;
    overflow: hidden;
    background: linear-gradient(135deg, #C07840, #E8A96A);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.1rem;
    color: white;
    box-shadow: var(--shadow-md);
    flex-shrink: 0;
}
.baker-avatar img { width: 100%; height: 100%; object-fit: cover; }

.baker-rating-pill {
    background: white;
    border: 1px solid var(--cream-light);
    border-radius: 100px;
    padding: 0.3rem 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    box-shadow: var(--shadow-sm);
    font-size: 0.72rem;
    margin-top: 8px;
}
.baker-stars { color: #F5A623; letter-spacing: -0.05em; }
.baker-rating-num { font-weight: 800; color: var(--espresso); }
.baker-rating-cnt { color: var(--text-muted); }

.baker-body { padding: 0 1.5rem 1.5rem; }
.baker-name {
    font-size: 1rem;
    font-weight: 800;
    color: var(--espresso);
    margin-bottom: 0.2rem;
}
.baker-meta {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
}

.baker-specialties {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-bottom: 1.1rem;
}
.baker-tag {
    font-size: 0.62rem;
    font-weight: 700;
    color: var(--caramel);
    background: rgba(192,120,64,.08);
    border: 1px solid rgba(192,120,64,.2);
    padding: 0.2rem 0.55rem;
    border-radius: 100px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.baker-book-btn {
    display: block;
    text-align: center;
    background: var(--espresso);
    color: white;
    border-radius: 100px;
    padding: 0.6rem;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-decoration: none;
    transition: all 0.2s;
}
.baker-book-btn:hover { background: var(--caramel); color: white; }


/* ══════════════════════════════════════════════
   FOOTER CTA
══════════════════════════════════════════════ */
.footer-cta {
    background: var(--ivory-warm);
    padding: 6rem 3.5rem;
    text-align: center;
    border-top: 1px solid var(--cream-light);
}
.footer-cta .eyebrow { justify-content: center; margin-bottom: 1.5rem; }
.footer-cta .display-headline {
    margin-bottom: 1rem;
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
}
.footer-cta p {
    font-size: 0.88rem;
    color: var(--text-muted);
    max-width: 400px;
    margin: 0 auto 2.5rem;
    line-height: 1.75;
}
.footer-cta-btns {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}


/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .signature-grid { grid-template-columns: 1fr 1fr; }
    .celebrations-scroll { grid-template-columns: repeat(3, 1fr); }
    .celebrations-feature-row { grid-template-columns: repeat(3, 1fr); }
    .masonry-grid { columns: 3; }
}

@media (max-width: 768px) {
    .section-header-editorial { flex-direction: column; align-items: flex-start; padding: 0 1.5rem; }
    .signature-grid { grid-template-columns: 1fr; padding: 0 1.5rem; }
    .sig-stack { display: grid; grid-template-columns: 1fr 1fr; }
    .budget-hero-inner { padding: 0 1.5rem; }
    .celebrations-scroll { grid-template-columns: repeat(2, 1fr); padding: 0 1.5rem; }
    .celebrations-feature-row { grid-template-columns: 1fr 1fr; padding: 0 1.5rem; }
    .celebration-card { aspect-ratio: 2/3; }
    .seasonal-banners-grid { grid-template-columns: 1fr; }
    .seasonal-banner { grid-template-columns: 1fr; }
    .seasonal-wrap { padding: 0 1.5rem; }
    .picks-grid { grid-template-columns: 1fr 1fr; }
    .picks-wrap { padding: 0 1.5rem; }
    .masonry-grid { columns: 2; padding: 0 1.5rem; }
    .bakers-grid { grid-template-columns: 1fr 1fr; padding: 0 1.5rem; }
}

@media (max-width: 500px) {
    .celebrations-scroll { grid-template-columns: 1fr 1fr; }
    .celebrations-feature-row { grid-template-columns: 1fr; }
    .picks-grid { grid-template-columns: 1fr; }
    .masonry-grid { columns: 2; }
    .bakers-grid { grid-template-columns: 1fr; }
    .section-wrap { padding: 0 1.25rem; }
}
</style>
@endpush

@section('content')
<div class="gallery-page">


{{-- ══════════════════════════════════════════════
     1. SHOP BY BUDGET — Opening section
══════════════════════════════════════════════ --}}
<section class="budget-hero-section">
    <div class="budget-hero-inner">
        <div class="budget-hero-top">
            <div>
                <div class="eyebrow" style="margin-bottom:0.75rem;">BakeSphere Gallery</div>
                <h1 class="display-headline">Find your perfect cake, <em>at your price</em></h1>
                <p class="budget-hero-sub">Handcrafted to order — browse by budget and discover cakes made just for you.</p>
            </div>
            <div class="budget-hero-actions">
                <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                    Design Your Cake
                </a>
                <a href="{{ route('customer.cake-requests.index') }}" class="btn-ghost">View Orders</a>
            </div>
        </div>

        <div class="budget-cards-grid">
            @foreach($budgetTiers as $tier)
            <a href="{{ route('customer.cake-builder.index') }}?budget_min={{ $tier['min'] }}&budget_max={{ $tier['max'] }}"
               class="budget-hero-card {{ $selectedBudget === $tier['label'] ? 'active' : '' }}">
                <div class="bhc-icon">{{ $tier['icon'] }}</div>
                <div class="bhc-label">{{ $tier['label'] }}</div>
                <div class="bhc-hint">Tap to explore</div>
                <div class="bhc-arrow">→</div>
            </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     2. SIGNATURE COLLECTION (Trending)
══════════════════════════════════════════════ --}}
@if($trending->count() > 0)
<section class="signature-section">
    <div class="section-header-editorial">
        <div class="left">
            <div class="eyebrow">Signature Collection</div>
            <h2 class="display-headline">Most <em>loved</em> right now</h2>
        </div>
        <a href="{{ route('customer.cake-builder.index') }}" class="link-see-all">
            Explore all →
        </a>
    </div>

    <div class="signature-grid">
        {{-- Feature card (first trending item) --}}
        @if($trending->count() > 0)
        @php
            $first = $trending[0];
            $fcfg = $first['config'];
            $flabel = trim(($fcfg['flavor'] ?? '') . ' ' . ($fcfg['frosting'] ?? '')) ?: 'Custom Cake';
        @endphp
        <a href="{{ route('customer.cake-builder.index') }}?flavor={{ urlencode($fcfg['flavor'] ?? '') }}&frosting={{ urlencode($fcfg['frosting'] ?? '') }}&size={{ urlencode($fcfg['size'] ?? '') }}"
           class="sig-card sig-card-main">
            @if($first['image'])
                <img class="sig-card-img" src="{{ asset('storage/' . $first['image']) }}" alt="{{ $flabel }}">
            @else
                <div class="sig-card-placeholder">🎂</div>
            @endif
            <div class="sig-card-overlay"></div>
            <div class="sig-save" title="Save">♡</div>
            <div class="sig-card-body">
                <span class="sig-rank">#1 Most Ordered</span>
                <div class="sig-name">{{ $flabel }}</div>
                <div class="sig-desc">
                    {{ $fcfg['size'] ?? '' }}
                    @if(!empty($fcfg['addons'])) · {{ count((array)$fcfg['addons']) }} add-ons included @endif
                    · {{ $first['count'] }} orders placed
                </div>
                <div class="sig-footer">
                    <div class="sig-price">₱{{ number_format($first['min_price'], 0) }} – ₱{{ number_format($first['max_price'], 0) }}</div>
                    <span class="sig-action">Customize →</span>
                </div>
            </div>
        </a>
        @endif

        {{-- Side stack: 2nd and 3rd --}}
        <div class="sig-stack">
            @foreach($trending->skip(1)->take(2) as $i => $item)
            @php
                $cfg = $item['config'];
                $label = trim(($cfg['flavor'] ?? '') . ' ' . ($cfg['frosting'] ?? '')) ?: 'Custom Cake';
            @endphp
            <a href="{{ route('customer.cake-builder.index') }}?flavor={{ urlencode($cfg['flavor'] ?? '') }}&frosting={{ urlencode($cfg['frosting'] ?? '') }}&size={{ urlencode($cfg['size'] ?? '') }}"
               class="sig-card sig-card-side">
                @if($item['image'])
                    <img class="sig-card-img" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $label }}" style="min-height:220px; object-fit:cover; display:block; width:100%;">
                @else
                    <div class="sig-card-placeholder" style="min-height:220px;">{{ $i === 0 ? '🍰' : '🧁' }}</div>
                @endif
                <div class="sig-card-overlay"></div>
                <div class="sig-save" title="Save">♡</div>
                <div class="sig-card-body">
                    <span class="sig-rank">#{{ $i + 2 }} Trending</span>
                    <div class="sig-name sig-name-sm">{{ $label }}</div>
                    <div class="sig-footer">
                        <div class="sig-price sig-price-sm">₱{{ number_format($item['min_price'], 0) }}–₱{{ number_format($item['max_price'], 0) }}</div>
                        <span class="sig-action">Order →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════
     3. SHOP BY CELEBRATION
══════════════════════════════════════════════ --}}
<section class="celebrations-section">
    <div class="section-header-editorial" style="padding:0 4rem 0; margin-bottom:2.5rem;">
        <div class="left">
            <div class="eyebrow">Every occasion</div>
            <h2 class="display-headline">Shop by <em>celebration</em></h2>
        </div>
    </div>

    @php
    $occasionBgs = [
        'Birthday'    => 'cel-bg-birthday',
        'Wedding'     => 'cel-bg-wedding',
        'Anniversary' => 'cel-bg-anniversary',
        'Graduation'  => 'cel-bg-graduation',
        'Baby Shower' => 'cel-bg-baby',
        'Corporate'   => 'cel-bg-corporate',
    ];
    @endphp

    <div class="celebrations-scroll">
        @foreach(array_slice($occasions, 0, 3) as $occasion)
        @php $bg = $occasionBgs[$occasion['label']] ?? 'cel-bg-corporate'; @endphp
        <a href="{{ route('customer.cake-builder.index') }}?occasion={{ urlencode($occasion['label']) }}"
           class="celebration-card">
            <div class="celebration-bg-placeholder {{ $bg }}">{{ $occasion['icon'] }}</div>
            <div class="celebration-overlay"></div>
            <div class="cel-arrow">↗</div>
            <div class="celebration-body">
                <span class="cel-icon">{{ $occasion['icon'] }}</span>
                <span class="cel-label">{{ $occasion['label'] }}</span>
                <span class="cel-hint">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    Shop collection
                </span>
            </div>
        </a>
        @endforeach
    </div>

    <div class="celebrations-feature-row">
        @foreach(array_slice($occasions, 3, 3) as $occasion)
        @php $bg = $occasionBgs[$occasion['label']] ?? 'cel-bg-corporate'; @endphp
        <a href="{{ route('customer.cake-builder.index') }}?occasion={{ urlencode($occasion['label']) }}"
           class="celebration-card celebration-card-wide">
            <div class="celebration-bg-placeholder {{ $bg }}" style="min-height:100%">{{ $occasion['icon'] }}</div>
            <div class="celebration-overlay"></div>
            <div class="cel-arrow">↗</div>
            <div class="celebration-body">
                <span class="cel-label" style="font-size:1rem">{{ $occasion['label'] }}</span>
                <span class="cel-hint">Shop collection</span>
            </div>
        </a>
        @endforeach
    </div>
</section>


{{-- ══════════════════════════════════════════════
     5. SEASONAL SPECIALS
══════════════════════════════════════════════ --}}
<section class="seasonal-section">
    <div class="seasonal-wrap">
        <div class="section-header-editorial" style="padding:0; margin-bottom:2rem;">
            <div class="left">
                <div class="eyebrow">Limited Time</div>
                <h2 class="display-headline" style="font-size:clamp(1.6rem,3vw,2.2rem)">Seasonal <em>specials</em></h2>
            </div>
        </div>

        <div class="seasonal-banners-grid">
            <a href="{{ route('customer.cake-builder.index') }}?occasion=Wedding" class="seasonal-banner sb-rose" style="text-decoration:none">
                <div class="sb-deco"><div class="sb-circle-1"></div><div class="sb-circle-2"></div></div>
                <div class="sb-content">
                    <div class="sb-eyebrow">💍 Wedding Season</div>
                    <div class="sb-headline">Tiered Wedding Cakes</div>
                    <div class="sb-desc">Elegant multi-tier cakes for your perfect day — fondant, floral, and custom designs.</div>
                </div>
                <div class="sb-cta">
                    <span class="sb-btn">Shop Now →</span>
                </div>
            </a>

            <a href="{{ route('customer.cake-builder.index') }}?occasion=Graduation" class="seasonal-banner sb-green" style="text-decoration:none">
                <div class="sb-deco"><div class="sb-circle-1"></div><div class="sb-circle-2"></div></div>
                <div class="sb-content">
                    <div class="sb-eyebrow">🎓 Graduation Season</div>
                    <div class="sb-headline">Graduation Cakes</div>
                    <div class="sb-desc">Celebrate their achievement with a custom graduation cake — personalized just for them.</div>
                </div>
                <div class="sb-cta">
                    <span class="sb-btn">Shop Now →</span>
                </div>
            </a>

            <a href="{{ route('customer.cake-builder.index') }}?occasion=Birthday" class="seasonal-banner sb-gold" style="text-decoration:none">
                <div class="sb-deco"><div class="sb-circle-1"></div><div class="sb-circle-2"></div></div>
                <div class="sb-content">
                    <div class="sb-eyebrow">🎂 Birthday Essentials</div>
                    <div class="sb-headline">Birthday Cakes</div>
                    <div class="sb-desc">From classic cream to bold custom — the perfect birthday cake for every age.</div>
                </div>
                <div class="sb-cta">
                    <span class="sb-btn">Shop Now →</span>
                </div>
            </a>

            <a href="{{ route('customer.cake-builder.index') }}?occasion=Baby Shower" class="seasonal-banner sb-espresso" style="text-decoration:none">
                <div class="sb-deco"><div class="sb-circle-1"></div><div class="sb-circle-2"></div></div>
                <div class="sb-content">
                    <div class="sb-eyebrow">🍼 Baby Shower Cakes</div>
                    <div class="sb-headline">Gender Reveal & More</div>
                    <div class="sb-desc">Adorable, pastel-perfect cakes for welcoming a new little one into the world.</div>
                </div>
                <div class="sb-cta">
                    <span class="sb-btn">Shop Now →</span>
                </div>
            </a>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     6. DESIGNER'S PICKS (Templates)
══════════════════════════════════════════════ --}}
<section class="picks-section">
    <div class="picks-wrap">
        <div class="picks-header">
            <div class="eyebrow">Curated Designs</div>
            <h2 class="display-headline" style="color:white">Designer's <em style="color:var(--caramel-light)">picks</em></h2>
        </div>

        @php
        $editorialLabels = [
            0 => 'Luxury Choice',
            1 => 'Minimalist Fave',
            2 => 'Best for Weddings',
            3 => 'Weekend Classic',
            4 => 'Bold & Beautiful',
            5 => 'Crowd Pleaser',
        ];
        @endphp

        <div class="picks-grid">
            @foreach($templates as $idx => $tpl)
            <div class="pick-card">
                <div class="pick-visual">
                    <span class="pick-emoji">{{ $tpl['icon'] }}</span>
                    <div class="pick-editorial-label">
                        <span class="pick-label-text">{{ $editorialLabels[$idx] ?? $tpl['tag'] }}</span>
                    </div>
                </div>
                <div class="pick-body">
                    <div class="pick-name">{{ $tpl['name'] }}</div>
                    <div class="pick-specs">
                        <span class="pick-spec">{{ $tpl['size'] }}</span>
                        <span class="pick-spec">{{ $tpl['flavor'] }}</span>
                        <span class="pick-spec">{{ $tpl['frosting'] }}</span>
                    </div>
                    <div class="pick-cta">
                        <span class="pick-price">{{ $tpl['tag'] }}</span>
                        <a href="{{ route('customer.cake-builder.index') }}?flavor={{ urlencode($tpl['flavor']) }}&frosting={{ urlencode($tpl['frosting']) }}&size={{ urlencode($tpl['size']) }}"
                           class="pick-btn">
                            Customize →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top:2.5rem; text-align:center;">
            <a href="{{ route('customer.cake-builder.index') }}" class="btn-ghost" style="color:rgba(255,255,255,.6); border-color:rgba(255,255,255,.15);">
                Build from scratch — no template needed →
            </a>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     7. REAL CUSTOMER CREATIONS (Recent cakes)
══════════════════════════════════════════════ --}}
@if($recentCakes->count() > 0)
<section class="creations-section">
    <div class="section-header-editorial" style="padding:0 4rem; margin-bottom:3rem;">
        <div class="left">
            <div class="eyebrow">Customer Creations</div>
            <h2 class="display-headline">Real cakes, <em>real moments</em></h2>
        </div>
        <a href="{{ route('customer.cake-builder.index') }}" class="link-see-all">Start yours →</a>
    </div>

    <div class="masonry-grid">
        @foreach($recentCakes as $cake)
        @php $cfg = is_array($cake->cake_configuration) ? $cake->cake_configuration : json_decode($cake->cake_configuration, true); @endphp
        <a href="{{ route('customer.cake-builder.index') }}" class="masonry-item">
            @if($cake->cake_preview_image)
                <img src="{{ asset('storage/' . $cake->cake_preview_image) }}" alt="Customer cake">
            @else
                <div class="masonry-placeholder">🎂</div>
            @endif
            <div class="masonry-hover">
                <div class="masonry-label">
                    {{ $cfg['flavor'] ?? 'Custom Cake' }}
                    <span class="masonry-sub">{{ $cfg['size'] ?? '' }} · Order now</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════
     8. MEET OUR BAKERS
══════════════════════════════════════════════ --}}
@if($topBakers->count() > 0)
<section class="bakers-section">
    <div class="section-header-editorial" style="padding:0 4rem; margin-bottom:3rem;">
        <div class="left">
            <div class="eyebrow">The Artists</div>
            <h2 class="display-headline">Meet our <em>bakers</em></h2>
        </div>
    </div>

    <div class="bakers-grid">
        @foreach($topBakers as $b)
        <div class="baker-card">
            {{-- Portfolio preview --}}
            <div class="baker-portfolio">
                @if($b['sample_photo'])
                    <img src="{{ asset('storage/' . $b['sample_photo']) }}" alt="Baker's work">
                @else
                    🎂
                @endif
                <div class="baker-portfolio-overlay"></div>
            </div>

            {{-- Avatar pulled up from photo --}}
            <div class="baker-avatar-wrap">
                <div class="baker-avatar">
                    @if($b['user']->profile_photo)
                        <img src="{{ str_starts_with($b['user']->profile_photo, 'http') ? $b['user']->profile_photo : asset('storage/'.$b['user']->profile_photo) }}" alt="">
                    @else
                        {{ strtoupper(substr($b['user']->first_name, 0, 1)) }}
                    @endif
                </div>
                @if($b['avg_rating'])
                <div class="baker-rating-pill">
                    <span class="baker-stars">★</span>
                    <span class="baker-rating-num">{{ number_format($b['avg_rating'], 1) }}</span>
                    <span class="baker-rating-cnt">({{ $b['review_count'] }})</span>
                </div>
                @endif
            </div>

            <div class="baker-body">
                <div class="baker-name">{{ $b['user']->first_name }} {{ $b['user']->last_name }}</div>
                <div class="baker-meta">{{ $b['completed'] }} cake{{ $b['completed'] !== 1 ? 's' : '' }} completed</div>
                <div class="baker-specialties">
                    <span class="baker-tag">Custom Cakes</span>
                    <span class="baker-tag">Artisan</span>
                    @if($b['avg_rating'] >= 4.8)<span class="baker-tag">Top Rated</span>@endif
                </div>
                <a href="{{ route('customer.cake-builder.index') }}?baker={{ $b['baker']->id }}"
                   class="baker-book-btn">
                    Book this Baker
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif


{{-- ══════════════════════════════════════════════
     FOOTER CTA
══════════════════════════════════════════════ --}}
<div class="footer-cta">
    <div class="eyebrow">Ready to order?</div>
    <h2 class="display-headline">Your dream cake <em>awaits</em></h2>
    <p>Every cake is handcrafted to order — your vision, their artistry, your celebration.</p>
    <div class="footer-cta-btns">
        <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Start Designing
        </a>
        <a href="{{ route('customer.cake-requests.index') }}" class="btn-ghost">
            View My Orders
        </a>
    </div>
</div>


</div>{{-- end .gallery-page --}}
@endsection