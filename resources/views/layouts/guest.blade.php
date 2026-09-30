<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>BakeSphere</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--esp:#24150F;--cof:#3A241A;--car:#B89452;--car-l:#D4B06A;--caramel:#A96F42;--burg:#54252C;--mocha:#7A5E4C;--taupe:#9A897A;--latte:#D8C8B7;--beige:#EFE6D7;--cream:#F7F2E9;--w:#FBF8F2;--gold-line:rgba(184,148,82,.32);--r:2px;--e:cubic-bezier(.2,.7,.2,1)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;font-family:'Plus Jakarta Sans',system-ui,sans-serif}
body{min-height:100svh;display:grid;place-items:center;padding:24px;color:var(--esp);background:var(--esp);
 background-image:radial-gradient(ellipse 70% 50% at 85% 0%,rgba(184,148,82,.14),transparent 60%),repeating-linear-gradient(45deg,rgba(247,242,233,.014) 0 1px,transparent 1px 8px)}
:focus-visible{outline:2px solid var(--car);outline-offset:3px}
.g-card{display:grid;grid-template-columns:248px 1fr;width:720px;max-width:100%;border:1px solid var(--car);border-radius:var(--r);overflow:hidden;box-shadow:0 40px 100px rgba(0,0,0,.6);animation:g-in .6s var(--e) backwards}
@keyframes g-in{from{opacity:0;transform:translateY(20px)}}
.g-left{background:var(--esp);background-image:radial-gradient(ellipse 120% 40% at 0 0,rgba(184,148,82,.14),transparent 62%);padding:42px 24px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:var(--cream);border-right:1px solid var(--gold-line)}
.g-name{font-weight:800;font-size:1.2rem;margin-bottom:24px;text-decoration:none;color:var(--cream)}
.g-name span{color:var(--car-l)}
.g-mark{width:104px;aspect-ratio:1;border:1px solid var(--car);border-radius:var(--r);box-shadow:inset 0 0 0 5px var(--esp),inset 0 0 0 6px var(--gold-line);color:var(--car-l);display:grid;place-items:center;margin-bottom:20px}
.g-mark svg{width:58%}
.g-tag{font-size:.66rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--taupe);line-height:1.9}
.g-right{background:var(--cream);padding:38px 34px 30px;display:flex;flex-direction:column;justify-content:center}
.g-title{font-size:1.55rem;font-weight:800;letter-spacing:-.03em;line-height:1.2;margin-bottom:10px}
.g-sub{font-size:.84rem;line-height:1.65;color:var(--mocha);margin-bottom:22px}
.g-alert{padding:10px 12px;border-radius:var(--r);margin-bottom:16px;font-size:.8rem;font-weight:600;border-left:2px solid}
.g-ok{background:var(--beige);border-color:var(--car);color:var(--esp)}
.g-field{margin-bottom:14px}
.g-field label{display:block;font-size:.6rem;font-weight:800;color:var(--mocha);text-transform:uppercase;letter-spacing:.2em;margin-bottom:6px}
.g-field input{width:100%;padding:12px 13px;background:var(--w);border:1px solid var(--latte);border-radius:var(--r);font-size:.9rem;color:var(--esp);outline:none;transition:.25s}
.g-field input::placeholder{color:var(--taupe)}
.g-field input:focus{border-color:var(--car);box-shadow:0 0 0 3px rgba(184,148,82,.18)}
.g-field input.is-invalid{border-color:var(--burg);border-width:2px}
.g-err{margin-top:5px;font-size:.74rem;font-weight:700;color:var(--burg)}
.g-btn{width:100%;margin-top:6px;padding:14px;background:var(--esp);color:var(--car-l);border:1px solid var(--esp);border-radius:var(--r);font-weight:800;font-size:.76rem;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;transition:.3s var(--e)}
.g-btn:hover{background:var(--car);border-color:var(--car);color:var(--esp);transform:translateY(-1px)}
.g-back{display:inline-block;align-self:center;margin-top:20px;font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--caramel);text-decoration:none;border-bottom:1px solid var(--gold-line);padding-bottom:2px;transition:color .3s}
.g-back:hover{color:var(--esp)}
@media(max-width:720px){.g-card{grid-template-columns:1fr}.g-left{display:none}.g-right{padding:32px 22px 24px}}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}
</style>
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><symbol id="ico-cake" viewBox="0 0 24 24"><rect x="4" y="15" width="16" height="5" rx="1.2" fill="currentColor"/><rect x="6.5" y="10" width="11" height="5" rx="1.2" fill="currentColor" opacity=".8"/><rect x="9" y="6" width="6" height="4" rx="1.2" fill="currentColor" opacity=".6"/><rect x="11.4" y="3" width="1.2" height="3" fill="currentColor"/><ellipse cx="12" cy="2.6" rx="1" ry="1.4" fill="#C47B2E"/></symbol></svg>
<main class="g-card">
    <aside class="g-left">
        <a class="g-name" href="{{ url('/') }}">Bake<span>Sphere</span></a>
        <div class="g-mark"><svg viewBox="0 0 24 24" aria-hidden="true"><use href="#ico-cake"/></svg></div>
        <div class="g-tag">Order handcrafted cakes made<br>with love.</div>
    </aside>
    <section class="g-right">
        {{ $slot }}
    </section>
</main>
</body>
</html>