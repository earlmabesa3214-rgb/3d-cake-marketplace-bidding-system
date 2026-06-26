@extends('layouts.customer')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ── RESET & BASE ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
* { font-family: 'Plus Jakarta Sans', sans-serif; }

:root {
    --brown-deep:   #1C0F07;
    --brown-mid:    #3D2416;
    --brown-warm:   #5C3D2E;
    --caramel:      #C8894A;
    --caramel-light:#E8B07A;
    --caramel-pale: #FDDFC0;
    --cream:        #FDF6ED;
    --cream-dark:   #F5EDE0;
    --warm-white:   #FEFAF5;
    --border:       rgba(200,137,74,0.15);
    --text-dark:    #2A160A;
    --text-muted:   #9A7A65;
    --glass-bg:     rgba(253,246,237,0.72);
    --glass-border: rgba(255,255,255,0.55);
}

/* ── ANIMATIONS ── */
@keyframes rise     { from { opacity:0; transform:translateY(28px);} to { opacity:1; transform:none;} }
@keyframes fadeIn   { from { opacity:0; } to { opacity:1; } }
@keyframes floatUp  { 0%,100%{ transform:translateY(0);} 50%{ transform:translateY(-10px);} }
@keyframes floatUpB { 0%,100%{ transform:translateY(0) rotate(-2deg);} 50%{ transform:translateY(-14px) rotate(2deg);} }
@keyframes shimmer  { 0%{background-position:-400% center;} 100%{background-position:400% center;} }
@keyframes drift    { 0%,100%{transform:translateX(0) scale(1);} 50%{transform:translateX(8px) scale(1.02);} }
@keyframes scroll-x { 0%{transform:translateX(0);} 100%{transform:translateX(-50%);} }
@keyframes pulse    { 0%,100%{transform:scale(1);} 50%{transform:scale(1.05);} }
@keyframes orbit    { 0%{transform:rotate(0deg) translateX(90px) rotate(0deg);}
                      100%{transform:rotate(360deg) translateX(90px) rotate(-360deg);} }

.rise-1  { animation: rise 0.7s cubic-bezier(.22,.68,0,1.15) 0.05s both; }
.rise-2  { animation: rise 0.7s cubic-bezier(.22,.68,0,1.15) 0.15s both; }
.rise-3  { animation: rise 0.7s cubic-bezier(.22,.68,0,1.15) 0.25s both; }
.rise-4  { animation: rise 0.7s cubic-bezier(.22,.68,0,1.15) 0.35s both; }
.rise-5  { animation: rise 0.7s cubic-bezier(.22,.68,0,1.15) 0.45s both; }

/* ══════════════════════════════════════════
   § 1  HERO
══════════════════════════════════════════ */
.bs-hero {
    position: relative;
    min-height: 580px;
    background: var(--brown-deep);
    border-radius: 28px;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1fr;
    margin-bottom: 2.5rem;
    box-shadow: 0 32px 80px rgba(28,15,7,0.45);
}

/* diagonal cream slice cutting through the dark */
.bs-hero::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 58%;
    height: 100%;
    background: var(--cream);
    clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%);
    z-index: 0;
}

/* ambient warm glow */
.bs-hero::after {
    content: '';
    position: absolute;
    top: 50%; left: 30%;
    transform: translate(-50%,-50%);
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(200,137,74,0.18) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

/* ── dot texture on dark side ── */
.hero-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(200,137,74,0.12) 1px, transparent 1px);
    background-size: 22px 22px;
    z-index: 0;
    pointer-events: none;
}

/* ── left text panel ── */
.hero-left {
    position: relative;
    z-index: 2;
    padding: 3.5rem 2.5rem 3.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 0;
}

.hero-greeting {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.65rem;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: var(--caramel-light);
    font-weight: 700;
    margin-bottom: 1rem;
    opacity: 0.9;
}
.hero-greeting-line {
    width: 20px; height: 1.5px;
    background: var(--caramel-light);
    opacity: 0.5;
    display: inline-block;
}

.hero-display {
    font-size: clamp(2.2rem, 4.5vw, 3.4rem);
    font-weight: 900;
    line-height: 1.08;
    letter-spacing: -0.04em;
    color: white;
    margin-bottom: 1.5rem;
}
.hero-display em {
    font-style: normal;
    background: linear-gradient(120deg, var(--caramel-light), #F7D48A, var(--caramel));
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmer 4s linear infinite;
}

.hero-body {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.5);
    line-height: 1.7;
    max-width: 340px;
    margin-bottom: 2rem;
}
.hero-body strong { color: rgba(255,255,255,0.8); }

.hero-btns {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.6rem;
    background: linear-gradient(135deg, var(--caramel) 0%, #D4944F 100%);
    color: white;
    border-radius: 14px;
    font-size: 0.84rem;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 8px 28px rgba(200,137,74,0.5);
    transition: transform 0.2s, box-shadow 0.2s;
    letter-spacing: 0.01em;
}
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 40px rgba(200,137,74,0.6);
    color: white;
}

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.4rem;
    background: rgba(255,255,255,0.07);
    border: 1.5px solid rgba(255,255,255,0.18);
    color: rgba(255,255,255,0.75);
    border-radius: 14px;
    font-size: 0.84rem;
    font-weight: 600;
    text-decoration: none;
    backdrop-filter: blur(8px);
    transition: all 0.2s;
}
.btn-ghost:hover {
    background: rgba(255,255,255,0.14);
    color: white;
}

/* ── floating stat chips on hero left ── */
.hero-chips {
    display: flex;
    gap: 0.6rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}
.hero-chip {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(200,137,74,0.3);
    border-radius: 50px;
    padding: 0.35rem 0.85rem;
    font-size: 0.72rem;
    color: rgba(255,255,255,0.7);
    font-weight: 600;
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.hero-chip-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--caramel-light);
    animation: pulse 2s ease-in-out infinite;
}
.hero-chip-dot.green { background: #5CB87A; }

/* ── right collage panel ── */
.hero-right {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 2rem 2.5rem 3rem;
}

.cake-collage {
    position: relative;
    width: 100%;
    max-width: 380px;
    height: 430px;
}

/* main big cake image placeholder */
.collage-main {
    position: absolute;
    top: 20px; left: 20px;
    width: 240px; height: 300px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(28,15,7,0.35);
    animation: floatUp 6s ease-in-out infinite;
}
.collage-main img,
.collage-thumb img { width:100%; height:100%; object-fit:cover; }

/* small accent images */
.collage-thumb {
    position: absolute;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(28,15,7,0.3);
}
.collage-thumb.t1 {
    width: 130px; height: 140px;
    top: 10px; right: 5px;
    animation: floatUpB 7s ease-in-out infinite 1s;
}
.collage-thumb.t2 {
    width: 110px; height: 110px;
    bottom: 40px; right: 10px;
    animation: floatUp 5.5s ease-in-out infinite 0.5s;
}
.collage-thumb.t3 {
    width: 90px; height: 95px;
    bottom: 20px; left: 10px;
    animation: floatUpB 8s ease-in-out infinite 1.5s;
}

/* glassmorphic floating label cards */
.collage-badge {
    position: absolute;
    background: var(--glass-bg);
    backdrop-filter: blur(16px);
    border: 1px solid var(--glass-border);
    border-radius: 14px;
    padding: 0.55rem 0.9rem;
    box-shadow: 0 8px 32px rgba(28,15,7,0.15);
    white-space: nowrap;
    z-index: 5;
}
.collage-badge .cb-label {
    font-size: 0.6rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--text-muted);
    font-weight: 700;
}
.collage-badge .cb-value {
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--brown-deep);
    margin-top: 0.1rem;
}
.collage-badge .cb-icon { font-size: 1rem; margin-right: 0.3rem; }

.cb-pos1 { top: -10px; left: 230px; animation: floatUp 5s ease-in-out infinite 0.3s; }
.cb-pos2 { bottom: 110px; left: -10px; animation: floatUpB 6s ease-in-out infinite 1s; }
.cb-pos3 { bottom: -5px; left: 120px; animation: floatUp 7s ease-in-out infinite 0.8s; }

/* image placeholders (used when real imgs aren't available) */
.img-placeholder {
    width: 100%; height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: rgba(255,255,255,0.5);
    font-weight: 700;
    letter-spacing: 0.08em;
    text-align: center;
    gap: 0.5rem;
}
.img-placeholder svg { opacity: 0.6; }

.placeholder-main { background: linear-gradient(160deg, #5C3D2E 0%, #9A6028 60%, #C8894A 100%); }
.placeholder-t1    { background: linear-gradient(135deg, #C8703A 0%, #E8B07A 100%); }
.placeholder-t2    { background: linear-gradient(135deg, #3D2416 0%, #7A4F2E 100%); }
.placeholder-t3    { background: linear-gradient(135deg, #9A6028 0%, #D4944F 100%); }

@media (max-width: 760px) {
    .bs-hero { grid-template-columns: 1fr; min-height: auto; }
    .bs-hero::before { display: none; }
    .hero-right { display: none; }
    .hero-left { padding: 2.5rem 1.75rem; }
}

/* ══════════════════════════════════════════
   § 2  FEATURED CAKES CAROUSEL
══════════════════════════════════════════ */
.section-label {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 1.25rem;
}
.section-eyebrow {
    font-size: 0.62rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--caramel);
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-eyebrow::before {
    content: '';
    width: 16px; height: 2px;
    background: var(--caramel);
    display: inline-block;
    border-radius: 2px;
}
.section-heading {
    font-size: 1.55rem;
    font-weight: 900;
    letter-spacing: -0.03em;
    color: var(--brown-deep);
    margin-top: 0.3rem;
}
.section-see-all {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--caramel);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    white-space: nowrap;
    transition: gap 0.2s;
    align-self: flex-end;
}
.section-see-all:hover { gap: 0.6rem; }

.carousel-wrap {
    display: flex;
    gap: 1.1rem;
    overflow-x: auto;
    padding-bottom: 1rem;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.carousel-wrap::-webkit-scrollbar { display: none; }

.feat-card {
    min-width: 260px;
    max-width: 260px;
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 22px;
    overflow: hidden;
    scroll-snap-align: start;
    transition: transform 0.25s cubic-bezier(.22,.68,0,1.2), box-shadow 0.25s;
    flex-shrink: 0;
    position: relative;
}
.feat-card:hover {
    transform: translateY(-6px) scale(1.015);
    box-shadow: 0 20px 52px rgba(44,26,14,0.16);
}

.feat-img {
    width: 100%;
    height: 200px;
    overflow: hidden;
    position: relative;
}
.feat-img img { width:100%; height:100%; object-fit:cover; transition: transform 0.4s ease; }
.feat-card:hover .feat-img img { transform: scale(1.06); }

.feat-tag {
    position: absolute;
    top: 12px; left: 12px;
    background: rgba(28,15,7,0.7);
    backdrop-filter: blur(8px);
    color: white;
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.25rem 0.65rem;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.15);
}
.feat-tag.new  { background: linear-gradient(135deg, var(--caramel), #D4944F); }
.feat-tag.hot  { background: rgba(180,60,30,0.85); }

.feat-body { padding: 1.1rem 1.25rem 1.25rem; }
.feat-name { font-size: 0.95rem; font-weight: 800; color: var(--brown-deep); }
.feat-desc { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.3rem; line-height: 1.5; }
.feat-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
}
.feat-price { font-size: 0.82rem; font-weight: 800; color: var(--caramel); }
.feat-price span { font-size: 0.68rem; color: var(--text-muted); font-weight: 600; }
.feat-btn {
    padding: 0.45rem 1rem;
    background: var(--brown-deep);
    color: white;
    border-radius: 9px;
    font-size: 0.73rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s, transform 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.feat-btn:hover { background: var(--caramel); transform: scale(1.04); color: white; }

/* placeholder images for featured */
.feat-ph {
    width: 100%; height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
}

/* ══════════════════════════════════════════
   § 3  PERSONALISED RECS
══════════════════════════════════════════ */
.recs-section { margin-bottom: 2.5rem; }
.recs-row { margin-bottom: 2rem; }
.recs-label {
    font-size: 0.8rem;
    font-weight: 800;
    color: var(--brown-deep);
    margin-bottom: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.recs-label .recs-icon { font-size: 1rem; }

.rec-scroll {
    display: flex;
    gap: 0.85rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
    scrollbar-width: none;
}
.rec-scroll::-webkit-scrollbar { display: none; }

.rec-pill {
    flex-shrink: 0;
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.7rem 1.1rem 0.7rem 0.7rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    min-width: 210px;
}
.rec-pill:hover {
    border-color: rgba(200,137,74,0.5);
    box-shadow: 0 6px 22px rgba(44,26,14,0.1);
    transform: translateY(-2px);
}
.rec-thumb {
    width: 52px; height: 52px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    font-size: 1.8rem;
    display: flex; align-items: center; justify-content: center;
    background: var(--cream-dark);
}
.rec-info { flex: 1; min-width: 0; }
.rec-name { font-size: 0.8rem; font-weight: 700; color: var(--brown-deep); }
.rec-sub  { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.1rem; }

/* ══════════════════════════════════════════
   § 4  ORDER TIMELINE
══════════════════════════════════════════ */
.timeline-section {
    margin-bottom: 2.5rem;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
    align-items: start;
}
@media (max-width: 900px) { .timeline-section { grid-template-columns: 1fr; } }

.timeline-list { display: flex; flex-direction: column; gap: 0; }

.tl-item {
    display: flex;
    align-items: stretch;
    gap: 0;
    text-decoration: none;
    color: inherit;
    position: relative;
}

/* vertical connector */
.tl-track {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
    width: 48px;
}
.tl-node {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    font-size: 0.75rem;
    font-weight: 800;
    border: 2.5px solid transparent;
    transition: transform 0.2s;
}
.tl-item:hover .tl-node { transform: scale(1.1); }

.tl-node.open        { background: #FEF9E8; border-color: #F0D480; color: #9B7A10; }
.tl-node.bidding     { background: #EBF3FE; border-color: #93C5FD; color: #1A5BBE; }
.tl-node.accepted    { background: #EFF5EF; border-color: #86EFAC; color: #2D6A30; }
.tl-node.in_progress { background: #FEF3E8; border-color: var(--caramel-pale); color: var(--caramel); }
.tl-node.completed   { background: #EFF5EF; border-color: #86EFAC; color: #2D6A30; }
.tl-node.cancelled   { background: #FDF0EE; border-color: #FCA5A5; color: #8B2A1E; }

.tl-line {
    width: 2px;
    flex: 1;
    min-height: 24px;
    background: var(--border);
    margin: 4px 0;
}
.tl-item:last-child .tl-line { display: none; }

.tl-content {
    flex: 1;
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 1rem 1.2rem;
    margin: 0 0 0.75rem 0;
    display: flex;
    gap: 1rem;
    align-items: center;
    transition: all 0.2s;
    min-height: 80px;
}
.tl-item:hover .tl-content {
    border-color: rgba(200,137,74,0.4);
    box-shadow: 0 8px 28px rgba(44,26,14,0.09);
}

.tl-cake-thumb {
    width: 54px; height: 54px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--cream-dark);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
}

.tl-meta { flex: 1; min-width: 0; }
.tl-order-id {
    font-size: 0.7rem;
    font-weight: 800;
    color: var(--caramel);
    letter-spacing: 0.04em;
    margin-bottom: 0.2rem;
}
.tl-cake-name { font-size: 0.87rem; font-weight: 700; color: var(--brown-deep); }
.tl-status-msg { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.2rem; }

.tl-right { text-align: right; flex-shrink: 0; }
.tl-progress-wrap { margin-bottom: 0.4rem; }
.tl-progress-bar {
    width: 80px;
    height: 4px;
    background: var(--cream-dark);
    border-radius: 99px;
    overflow: hidden;
    margin-left: auto;
}
.tl-progress-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, var(--caramel), var(--caramel-light));
    transition: width 0.6s ease;
}
.tl-pct { font-size: 0.65rem; font-weight: 700; color: var(--caramel); margin-top: 0.2rem; text-align: right; }
.tl-date { font-size: 0.68rem; color: var(--text-muted); font-weight: 500; }

/* timeline status badge */
.tl-badge {
    font-size: 0.58rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    padding: 0.18rem 0.6rem;
    border-radius: 50px;
    border: 1px solid;
    white-space: nowrap;
}
.tl-badge.open        { background:#FEF9E8; color:#9B7A10; border-color:#F0D480; }
.tl-badge.bidding     { background:#EBF3FE; color:#1A5BBE; border-color:#93C5FD; }
.tl-badge.accepted    { background:#EFF5EF; color:#2D6A30; border-color:#86EFAC; }
.tl-badge.in_progress { background:#FEF3E8; color:var(--caramel); border-color:var(--caramel-pale); }
.tl-badge.completed   { background:#EFF5EF; color:#2D6A30; border-color:#86EFAC; }
.tl-badge.cancelled   { background:#FDF0EE; color:#8B2A1E; border-color:#FCA5A5; }

/* empty timeline */
.tl-empty {
    background: var(--warm-white);
    border: 1.5px dashed var(--border);
    border-radius: 20px;
    padding: 3rem 2rem;
    text-align: center;
}
.tl-empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; opacity: 0.4; }
.tl-empty p { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem; }

/* ── right: quick summary panel ── */
.summary-panel {
    background: var(--brown-deep);
    border-radius: 22px;
    padding: 1.6rem;
    color: white;
    position: relative;
    overflow: hidden;
}
.summary-panel::before {
    content: '';
    position: absolute;
    bottom: -30px; right: -30px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(200,137,74,0.2) 0%, transparent 70%);
    pointer-events: none;
}
.summary-panel h4 {
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.45);
    margin-bottom: 1.2rem;
}
.sp-stat { margin-bottom: 1.2rem; }
.sp-val {
    font-size: 2.5rem;
    font-weight: 900;
    letter-spacing: -0.04em;
    line-height: 1;
    color: white;
}
.sp-val span {
    font-size: 1rem;
    font-weight: 600;
    color: var(--caramel-light);
}
.sp-lab {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.45);
    margin-top: 0.2rem;
    font-weight: 600;
}

.sp-divider { border: none; border-top: 1px solid rgba(255,255,255,0.08); margin: 0.5rem 0 1.2rem; }

.sp-action-list { display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.75rem; }
.sp-action {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 0.7rem 0.9rem;
    text-decoration: none;
    color: rgba(255,255,255,0.8);
    font-size: 0.78rem;
    font-weight: 600;
    transition: all 0.2s;
}
.sp-action:hover {
    background: rgba(200,137,74,0.2);
    border-color: rgba(200,137,74,0.4);
    color: white;
}
.sp-action-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: rgba(200,137,74,0.15);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.sp-action-arrow { margin-left: auto; opacity: 0.4; font-size: 0.75rem; }
.sp-action:hover .sp-action-arrow { opacity: 1; }

/* ── page bottom padding ── */
.page-end-pad { height: 2rem; }

/* ══════════════════════════════════════════
   SECTION SPACING
══════════════════════════════════════════ */
.section-mb { margin-bottom: 2.5rem; }
.section-mt { margin-top: 2.5rem; }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 640px) {
    .masonry-grid { columns: 2 150px; }
}

@media (prefers-reduced-motion: reduce) {
    * { animation: none !important; transition: none !important; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════
     § 1  HERO
══════════════════════════════════════ --}}
<div class="bs-hero rise-1">
    <div class="hero-dots"></div>

    {{-- LEFT --}}
    <div class="hero-left">
        <div class="hero-greeting">
            <span class="hero-greeting-line"></span>
            Welcome back
        </div>

        <h1 class="hero-display">
            Your next<br>
            <em>perfect cake</em><br>
            awaits.
        </h1>

        <p class="hero-body">
            @if($totalRequests === 0)
                Design something delicious. Your custom cake journey starts right here, <strong>{{ auth()->user()->first_name }}</strong>.
            @elseif($pendingRequests > 0)
                You have <strong>{{ $pendingRequests }} {{ Str::plural('order', $pendingRequests) }}</strong> being crafted with care, <strong>{{ auth()->user()->first_name }}</strong>.
            @else
                Every celebration is better with a cake made just for you, <strong>{{ auth()->user()->first_name }}</strong>.
            @endif
        </p>

        <div class="hero-btns">
            <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Design My Cake
            </a>
            @if($pendingRequests > 0)
            <a href="{{ route('customer.cake-requests.index') }}" class="btn-ghost">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Track Orders
            </a>
            @endif
        </div>

        <div class="hero-chips">
            <div class="hero-chip">
                <span class="hero-chip-dot"></span>
                {{ $totalRequests }} total orders
            </div>
            @if($completedRequests > 0)
            <div class="hero-chip">
                <span class="hero-chip-dot green"></span>
                {{ $completedRequests }} delivered
            </div>
            @endif
            <div class="hero-chip">
                <span class="hero-chip-dot"></span>
                Custom 3D builder
            </div>
        </div>
    </div>

    {{-- RIGHT: COLLAGE --}}
    <div class="hero-right">
        <div class="cake-collage">

            {{-- Main big cake --}}
            <div class="collage-main">
                <div class="img-placeholder placeholder-main">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>
                    <span>Wedding Tier</span>
                </div>
            </div>

            {{-- Accent thumbnails --}}
            <div class="collage-thumb t1">
                <div class="img-placeholder placeholder-t1">🎂</div>
            </div>
            <div class="collage-thumb t2">
                <div class="img-placeholder placeholder-t2">🍰</div>
            </div>
            <div class="collage-thumb t3">
                <div class="img-placeholder placeholder-t3">🧁</div>
            </div>

            {{-- Floating badge cards --}}
            <div class="collage-badge cb-pos1">
                <div class="cb-label">⭐ Top Rated</div>
                <div class="cb-value">4.9 / 5.0</div>
            </div>
            <div class="collage-badge cb-pos2">
                <div class="cb-label">🎉 Orders Today</div>
                <div class="cb-value">24 cakes</div>
            </div>
            <div class="collage-badge cb-pos3">
                <div class="cb-label">✨ Ready in</div>
                <div class="cb-value">3–5 days</div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     § 2  FEATURED CAKES
══════════════════════════════════════ --}}
<div class="section-mb rise-2">
    <div class="section-label">
        <div>
            <div class="section-eyebrow">Signature Collection</div>
            <div class="section-heading">Featured Cakes</div>
        </div>
        <a href="{{ route('customer.cake-builder.index') }}" class="section-see-all">Customize any →</a>
    </div>

    <div class="carousel-wrap">

        <div class="feat-card">
            <div class="feat-img">
                <div class="feat-ph" style="background:linear-gradient(160deg,#C8894A,#F5D4A0);">🎂</div>
                <span class="feat-tag new">Bestseller</span>
            </div>
            <div class="feat-body">
                <div class="feat-name">Classic Chocolate Fudge</div>
                <div class="feat-desc">Rich triple-layer dark chocolate with silky ganache drip and gold leaf finish.</div>
                <div class="feat-foot">
                    <div class="feat-price">From ₱950 <span>/ 6 inches</span></div>
               <a href="{{ route('customer.cake-builder.index', ['preset_flavor'=>'Chocolate','preset_shape'=>'Round','preset_size'=>'6','preset_frosting'=>'Smooth Buttercream','preset_drip'=>'1','preset_drip_flavor'=>'Chocolate','preset_name'=>'Classic Chocolate Fudge']) }}" class="feat-btn">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Customize
                    </a>
                </div>
            </div>
        </div>

        <div class="feat-card">
            <div class="feat-img">
                <div class="feat-ph" style="background:linear-gradient(160deg,#F5C6D0,#FADADD);">🌸</div>
                <span class="feat-tag" style="background:rgba(180,80,100,0.8);">Trending</span>
            </div>
            <div class="feat-body">
                <div class="feat-name">Strawberry Rose Dream</div>
                <div class="feat-desc">Ombre pink sponge layered with fresh strawberry compote and rosewater cream.</div>
                <div class="feat-foot">
                    <div class="feat-price">From ₱1,100 <span>/ 6 inches</span></div>
                <a href="{{ route('customer.cake-builder.index', ['preset_flavor'=>'Strawberry','preset_shape'=>'Round','preset_size'=>'6','preset_frosting'=>'Smooth Buttercream','preset_name'=>'Strawberry Rose Dream']) }}" class="feat-btn">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Customize
                    </a>
                </div>
            </div>
        </div>

        <div class="feat-card">
            <div class="feat-img">
                <div class="feat-ph" style="background:linear-gradient(160deg,#3D2416,#9A6028);">🤎</div>
                <span class="feat-tag hot">Hot Pick</span>
            </div>
            <div class="feat-body">
                <div class="feat-name">Salted Caramel Elegance</div>
                <div class="feat-desc">Buttery caramel sponge with fleur de sel buttercream and a caramel mirror glaze.</div>
                <div class="feat-foot">
                    <div class="feat-price">From ₱1,250 <span>/ 6 inches</span></div>
              <a href="{{ route('customer.cake-builder.index', ['preset_flavor'=>'Mocha','preset_shape'=>'Round','preset_size'=>'6','preset_frosting'=>'Semi-naked Style','preset_drip'=>'1','preset_drip_flavor'=>'Caramel','preset_name'=>'Salted Caramel Elegance']) }}" class="feat-btn">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Customize
                    </a>
                </div>
            </div>
        </div>

        <div class="feat-card">
            <div class="feat-img">
                <div class="feat-ph" style="background:linear-gradient(160deg,#E8D5B7,#D4B896);">🍋</div>
                <span class="feat-tag new">New</span>
            </div>
            <div class="feat-body">
                <div class="feat-name">Lemon Velvet Cloud</div>
                <div class="feat-desc">Airy lemon chiffon with limoncello curd, meringue kisses, and edible flowers.</div>
                <div class="feat-foot">
                    <div class="feat-price">From ₱1,050 <span>/ 6 inches</span></div>
                 <a href="{{ route('customer.cake-builder.index', ['preset_flavor'=>'Vanilla','preset_shape'=>'Round','preset_size'=>'6','preset_frosting'=>'Textured Buttercream','preset_name'=>'Lemon Velvet Cloud']) }}" class="feat-btn">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Customize
                    </a>
                </div>
            </div>
        </div>

        <div class="feat-card">
            <div class="feat-img">
                <div class="feat-ph" style="background:linear-gradient(160deg,#5C3D2E,#C8894A);">🎉</div>
            </div>
            <div class="feat-body">
                <div class="feat-name">Birthday Confetti Burst</div>
                <div class="feat-desc">Rainbow funfetti layers loaded with vanilla bean cream and sprinkle explosion.</div>
                <div class="feat-foot">
                    <div class="feat-price">From ₱850 <span>/ 6 inches</span></div>
              <a href="{{ route('customer.cake-builder.index', ['preset_flavor'=>'Vanilla','preset_shape'=>'Round','preset_size'=>'6','preset_frosting'=>'Smooth Buttercream','preset_addon_sprinkles'=>'Cylinder Sprinkles','preset_name'=>'Birthday Confetti Burst']) }}" class="feat-btn">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Customize
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     § 3  PERSONALISED RECS
══════════════════════════════════════ --}}
<div class="recs-section rise-3">
    <div class="section-eyebrow" style="margin-bottom:1rem;">Made for you</div>

    <div class="recs-row">
        <div class="recs-label">
            <span class="recs-icon">✨</span>
            @if($completedRequests > 0) Because you love custom cakes @else Popular right now @endif
        </div>
        <div class="rec-scroll">
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">🍫</div>
                <div class="rec-info">
                    <div class="rec-name">Dark Chocolate Torte</div>
                    <div class="rec-sub">Pairs with your taste</div>
                </div>
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">🎂</div>
                <div class="rec-info">
                    <div class="rec-name">Matcha & White Choc</div>
                    <div class="rec-sub">Trending in PH</div>
                </div>
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">🌺</div>
                <div class="rec-info">
                    <div class="rec-name">Ube Royale</div>
                    <div class="rec-sub">Local favourite</div>
                </div>
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">🍓</div>
                <div class="rec-info">
                    <div class="rec-name">Berry Basque Burnt</div>
                    <div class="rec-sub">5 ★ reviews</div>
                </div>
            </a>
        </div>
    </div>

    <div class="recs-row">
        <div class="recs-label">
            <span class="recs-icon">🔥</span>
            Trending this week
        </div>
        <div class="rec-scroll">
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">💍</div>
                <div class="rec-info">
                    <div class="rec-name">Wedding Tier Classic</div>
                    <div class="rec-sub">34 orders this week</div>
                </div>
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">🎓</div>
                <div class="rec-info">
                    <div class="rec-name">Graduation Milestone</div>
                    <div class="rec-sub">Season pick</div>
                </div>
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">🌙</div>
                <div class="rec-info">
                    <div class="rec-name">Midnight Velvet</div>
                    <div class="rec-sub">New arrival</div>
                </div>
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="rec-pill">
                <div class="rec-thumb">☁️</div>
                <div class="rec-info">
                    <div class="rec-name">Cloud Chiffon Stack</div>
                    <div class="rec-sub">Baker favourite</div>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     § 4  ORDER TIMELINE + SUMMARY PANEL
══════════════════════════════════════ --}}
<div class="timeline-section rise-4">

    {{-- LEFT: ORDER TIMELINE --}}
    <div>
        <div class="section-label" style="margin-bottom:1.25rem;">
            <div>
                <div class="section-eyebrow">Your Journey</div>
                <div class="section-heading">Order Timeline</div>
            </div>
            <a href="{{ route('customer.cake-requests.index') }}" class="section-see-all">All orders →</a>
        </div>

        @if($recentRequests->count())
            <div class="timeline-list">
                @foreach($recentRequests->take(5) as $req)
                @php
                    $cfg = is_array($req->cake_configuration)
                        ? $req->cake_configuration
                        : (json_decode($req->cake_configuration, true) ?? []);

                    $dotClass = match($req->status) {
                        'OPEN'                                         => 'open',
                        'BIDDING'                                      => 'bidding',
                        'ACCEPTED'                                     => 'accepted',
                        'IN_PROGRESS','WAITING_FOR_PAYMENT',
                        'WAITING_FINAL_PAYMENT'                        => 'in_progress',
                        'COMPLETED'                                    => 'completed',
                        'CANCELLED','EXPIRED'                          => 'cancelled',
                        default                                        => 'open',
                    };

                    $statusMsg = match($req->status) {
                        'OPEN'                  => 'Waiting for baker bids',
                        'BIDDING'               => 'Bakers are bidding!',
                        'ACCEPTED'              => 'Baker confirmed, awaiting start',
                        'WAITING_FOR_PAYMENT'   => 'Downpayment needed',
                        'IN_PROGRESS'           => 'Your cake is being crafted ✨',
                        'WAITING_FINAL_PAYMENT' => 'Ready — pay final balance',
                        'COMPLETED'             => 'Delivered with love ✓',
                        'CANCELLED'             => 'Order cancelled',
                        'EXPIRED'               => 'Request expired',
                        default                 => str_replace('_', ' ', $req->status),
                    };

                    $pct = match($req->status) {
                        'OPEN'                  => 15,
                        'BIDDING'               => 30,
                        'ACCEPTED'              => 45,
                        'WAITING_FOR_PAYMENT'   => 55,
                        'IN_PROGRESS'           => 72,
                        'WAITING_FINAL_PAYMENT' => 88,
                        'COMPLETED'             => 100,
                        'CANCELLED','EXPIRED'   => 0,
                        default                 => 20,
                    };

                    $emoji = match($cfg['flavor'] ?? '') {
                        'Chocolate' => '🍫',
                        'Vanilla'   => '🍰',
                        'Strawberry'=> '🍓',
                        'Red Velvet'=> '❤️',
                        'Matcha'    => '🍵',
                        'Ube'       => '💜',
                        default     => '🎂',
                    };
                @endphp
                <div class="tl-item">
                    <div class="tl-track">
                        <div class="tl-node {{ $dotClass }}">
                            @if($req->status === 'COMPLETED')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            @elseif(in_array($req->status, ['CANCELLED','EXPIRED']))
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            @else
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/></svg>
                            @endif
                        </div>
                        <div class="tl-line"></div>
                    </div>

                    <a href="{{ route('customer.cake-requests.show', $req->id) }}" class="tl-content" style="flex:1; margin-left:0.75rem;">
                        <div class="tl-cake-thumb">{{ $emoji }}</div>
                        <div class="tl-meta">
                            <div class="tl-order-id">ORDER #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</div>
                            <div class="tl-cake-name">{{ $cfg['flavor'] ?? 'Custom' }} {{ $cfg['shape'] ?? 'Cake' }}</div>
                            <div class="tl-status-msg">{{ $statusMsg }}</div>
                        </div>
                        <div class="tl-right">
                            @if(!in_array($req->status, ['CANCELLED','EXPIRED']))
                            <div class="tl-progress-wrap">
                                <div class="tl-progress-bar">
                                    <div class="tl-progress-fill" style="width:{{ $pct }}%"></div>
                                </div>
                                <div class="tl-pct">{{ $pct }}%</div>
                            </div>
                            @endif
                            <span class="tl-badge {{ $dotClass }}">{{ str_replace('_', ' ', $req->status) }}</span>
                            <div class="tl-date" style="margin-top:0.3rem;">{{ $req->delivery_date->format('M d') }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="tl-empty">
                <span class="tl-empty-icon">🎂</span>
                <p>No orders yet — your timeline starts with your first cake.</p>
                <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary" style="display:inline-flex;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Start My First Order
                </a>
            </div>
        @endif
    </div>

    {{-- RIGHT: SUMMARY PANEL --}}
    <div class="summary-panel">
        <h4>Your Account</h4>

        <div class="sp-stat">
            <div class="sp-val">{{ $totalRequests }}<span> cakes</span></div>
            <div class="sp-lab">Total orders placed</div>
        </div>

        <hr class="sp-divider">

        <div class="sp-stat">
            <div class="sp-val" style="font-size:1.8rem;">{{ $pendingRequests }}<span> active</span></div>
            <div class="sp-lab">Orders in progress</div>
        </div>

        <div class="sp-stat">
            <div class="sp-val" style="font-size:1.8rem;">{{ $completedRequests }}<span> done</span></div>
            <div class="sp-lab">Deliveries completed</div>
        </div>

        <hr class="sp-divider">

        <div class="sp-action-list">
            <a href="{{ route('customer.cake-builder.index') }}" class="sp-action">
                <div class="sp-action-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--caramel-light)" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                Design a New Cake
                <span class="sp-action-arrow">→</span>
            </a>
            <a href="{{ route('customer.cake-requests.index') }}" class="sp-action">
                <div class="sp-action-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--caramel-light)" stroke-width="2"><rect x="9" y="2" width="6" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>
                </div>
                All My Requests
                <span class="sp-action-arrow">→</span>
            </a>
            <a href="{{ route('customer.notifications.index') }}" class="sp-action">
                <div class="sp-action-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--caramel-light)" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                Notifications
                <span class="sp-action-arrow">→</span>
            </a>
            <a href="{{ route('customer.profile.index') }}" class="sp-action">
                <div class="sp-action-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--caramel-light)" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </div>
                My Profile
                <span class="sp-action-arrow">→</span>
            </a>
        </div>
    </div>

</div>

<div class="page-end-pad"></div>

@endsection