<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BakeSphere — Design the cake. Bakers bid.</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* BakeSphere landing: luxury atelier system. Plus Jakarta Sans only.
   Paste as the full contents of the <style> block. Token names are unchanged,
   so all existing markup, inline var() usage and JS keep working. */
:root{
--ink:#1C0E08;--esp:#24150F;--cof:#3A241A;--mocha:#7A5E4C;--taupe:#9A897A;
--car:#B89452;--car-l:#D4B06A;--caramel:#A96F42;--burg:#54252C;
--latte:#D8C8B7;--beige:#EFE6D7;--cream:#F7F2E9;--w:#FBF8F2;--blush:#E8D3CA;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.32);
--e:cubic-bezier(.2,.7,.2,1);--sy:0;--r:2px}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;font-family:'Plus Jakarta Sans',system-ui,sans-serif}
html{scroll-behavior:smooth}
body{font:500 1rem/1.65 'Plus Jakarta Sans',sans-serif;background:var(--cream);color:var(--esp);overflow-x:hidden}
button,input{font:inherit;color:inherit}
.sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)}
:focus-visible{outline:2px solid var(--car);outline-offset:3px}
.lbl{font-size:.66rem;font-weight:700;letter-spacing:.24em;text-transform:uppercase}

/* buttons: squared, refined */
.btn{display:inline-flex;align-items:center;gap:10px;padding:14px 26px;border:1px solid var(--esp);border-radius:var(--r);background:var(--esp);color:var(--cream);font-weight:800;font-size:.78rem;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;cursor:pointer;transition:transform .3s var(--e),background .3s,color .3s,box-shadow .3s}
.btn:hover:not(:disabled){background:var(--cof);transform:translateY(-2px);box-shadow:0 12px 28px rgba(36,21,15,.3)}
.btn.car{background:var(--car);border-color:var(--car);color:var(--esp)}
.btn.car:hover:not(:disabled){background:var(--car-l);border-color:var(--car-l)}
.btn:disabled{opacity:.45;cursor:default}

/* scroll reveals (.rv added by JS) */
.rv [data-r]{opacity:0;transition:opacity .9s var(--e),transform .9s var(--e),filter .9s var(--e),clip-path 1s var(--e);transition-delay:var(--d,0ms)}
.rv [data-r=up]{transform:translateY(32px)}
.rv [data-r=left]{transform:translateX(-48px)}
.rv [data-r=right]{transform:translateX(48px)}
.rv [data-r=scale]{transform:scale(.96);filter:blur(8px)}
.rv [data-r=clip]{opacity:1;clip-path:inset(0 0 100% 0);transform:translateY(24px)}
.rv [data-r].in{opacity:1;transform:none;filter:none;clip-path:inset(0 0 -20% 0)}

/* NAV: espresso, architectural */
.bar{position:sticky;top:0;z-index:50;display:flex;align-items:center;gap:32px;padding:14px 48px;background:var(--esp);color:var(--cream);border-bottom:1px solid var(--gold-line);animation:drop .6s var(--e) backwards}
.brand{display:flex;align-items:center;gap:14px;margin-right:auto;color:var(--cream);text-decoration:none;font-weight:700;font-size:1.15rem;letter-spacing:.01em}
.brand b{color:var(--car-l);font-weight:800}
.brand i{width:40px;height:40px;border-radius:var(--r);border:1px solid var(--car);box-shadow:inset 0 0 0 3px var(--esp),inset 0 0 0 4px var(--gold-line);color:var(--car-l);display:grid;place-items:center}
.bar .lnk{position:relative;color:rgba(247,242,233,.68);font-size:.72rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;padding:6px 0;transition:color .3s}
.bar .lnk::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--car);transform:scaleX(0);transform-origin:left;transition:transform .35s var(--e)}
.bar .lnk:hover{color:var(--cream)}.bar .lnk:hover::after{transform:scaleX(1)}
.bar .btn{padding:10px 22px}

/* HERO */
.hero{position:relative;max-width:1360px;margin:0 auto;padding:36px 48px 48px;min-height:calc(100svh - 70px);display:flex;flex-direction:column;justify-content:center}
.hero-meta{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:22px;color:var(--taupe)}
.hero-meta .lbl:first-child{padding:7px 14px;border:1px solid var(--car);border-radius:var(--r);color:var(--esp);background:transparent}
.hero h1{font-weight:900;font-size:clamp(2.5rem,min(6.4vw,11.5vh),6.4rem);line-height:.92;letter-spacing:-.05em;margin:0 0 20px}
.hero h1 span{display:block}
.hero h1 span+span{color:transparent;-webkit-text-stroke:2px var(--car);padding-left:clamp(0px,25vw,820px);white-space:nowrap;margin-top:14px}
.hero-sub{white-space:nowrap;font-size:clamp(1rem,1.4vw,1.15rem);line-height:1.7;color:var(--mocha);margin-bottom:38px}
.hero-foot{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-top:30px;padding-top:20px;border-top:1px solid var(--gold-line);font-size:.78rem;font-weight:600;color:var(--mocha)}
.hero-foot a{color:var(--esp);font-weight:800;letter-spacing:.06em;text-decoration:none;border-bottom:1px solid var(--car);padding-bottom:2px}
.ra{display:flex;gap:28px}
.a{animation:rise .8s var(--e) var(--a,0ms) backwards}

/* the five-step journey: one gold line, numbered nodes */
.flow{position:relative;list-style:none;display:grid;grid-template-columns:repeat(5,1fr);gap:20px;align-items:stretch}
.flow::before,.flow::after{content:"";position:absolute;top:6px;left:7px;right:calc((100% - 80px)/5 - 7px);height:1px;background:var(--line)}
.flow::after{height:2px;top:5.5px;background:var(--car);transform-origin:left;animation:draw 1.8s linear .6s backwards}
.flow>li{position:relative;z-index:1;display:flex;flex-direction:column;gap:12px;animation:rise .6s var(--e) var(--a,0ms) backwards}
.flow>li:nth-child(1){--a:350ms;--t:.6s}.flow>li:nth-child(2){--a:500ms;--t:1.2s}.flow>li:nth-child(3){--a:650ms;--t:1.8s}.flow>li:nth-child(4){--a:800ms;--t:2.4s}.flow>li:nth-child(5){--a:950ms;--t:3s}
.fh{display:flex;flex-direction:column;gap:10px}
.flow .lbl{color:var(--mocha)}
.fh .lbl em{font-style:normal;color:var(--car);margin-right:8px;font-weight:800}
.dot{position:relative;z-index:2;flex:none;width:13px;height:13px;border-radius:50%;background:var(--car);box-shadow:0 0 0 4px var(--cream),0 0 0 5px var(--car);animation:dot .5s var(--e) var(--t) backwards}
.flow>li:last-child .dot{animation:dot .5s var(--e) var(--t) backwards,beat 2.4s ease-in-out calc(var(--t) + 1.6s) 2}
.node{position:relative;flex:1;padding:20px;border-radius:var(--r);background:var(--w);border:1px solid var(--line)}
.flow .node{padding:18px}
.flow>li:nth-child(even) .node{margin-top:18px}
.chip{position:absolute;right:-1px;top:-11px;z-index:3;padding:5px 10px;border-radius:var(--r);background:var(--car);color:var(--esp);font-size:.58rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;white-space:nowrap;box-shadow:0 8px 16px rgba(36,21,15,.22);animation:rise .5s var(--e) calc(var(--t) + .35s) backwards}
.chip.d{background:var(--esp);color:var(--car-l);border:1px solid var(--gold-line)}
.bubble{background:var(--esp);color:var(--cream);border-color:var(--esp);font-weight:700;font-size:1.2rem;line-height:1.35;letter-spacing:-.02em}
.bubble::after{content:"";display:inline-block;width:2px;height:1em;margin-left:3px;background:var(--car-l);vertical-align:-.15em;animation:caret 1s steps(1) .3s 3 both}
.mini{display:grid;place-items:center;background:var(--beige)}
.tkt{border-style:solid;border-color:var(--car)}
.tkt b{font-weight:800;letter-spacing:.02em}
.tkt dl{display:grid;grid-template-columns:auto 1fr;gap:5px 14px;margin-top:10px;font-size:.84rem;color:var(--mocha)}
.tkt dd{color:var(--esp);font-weight:700;text-align:right}
.tkt b,.tkt dl{animation:rise .6s var(--e) var(--t) backwards}
.offers{background:var(--esp);color:var(--cream);border-color:var(--esp);display:grid;gap:8px;align-content:start}
.offers div{display:flex;justify-content:space-between;padding:10px 12px;border-radius:var(--r);border:1px solid rgba(247,242,233,.2);font-weight:700;font-size:.9rem;animation:rise .5s var(--e) backwards}
.offers div:nth-child(1){animation-delay:calc(var(--t) + .1s)}
.offers div:nth-child(2){animation-delay:calc(var(--t) + .4s)}
.offers div:nth-child(3){animation-delay:calc(var(--t) + .7s)}
.offers div.sel{background:var(--car);border-color:var(--car);color:var(--esp);animation:rise .5s var(--e) calc(var(--t) + .4s) backwards,chosen .7s var(--e) calc(var(--t) + 1.5s) backwards}
.flow .meta{font-size:.72rem;font-weight:600;color:var(--mocha);animation:rise .5s var(--e) calc(var(--t) + .2s) backwards}
.plate{position:relative;width:min(100%,220px);aspect-ratio:1;border-radius:50%;background:radial-gradient(circle,#fff 56%,var(--latte) 57% 60%,#fff 61% 92%,rgba(184,148,82,.35) 93% 94%,#fff 95%);box-shadow:0 24px 44px rgba(36,21,15,.22);display:grid;place-items:center}
.plate svg{width:86%;height:auto;margin-top:-6%}
.flow .plate{width:min(100%,150px);animation:cakein .9s var(--e) var(--t) backwards}

@keyframes rise{from{opacity:0;transform:translateY(22px);filter:blur(8px)}}
@keyframes drop{from{transform:translateY(-100%)}}
@keyframes dot{from{background:var(--latte);box-shadow:0 0 0 0 transparent;transform:scale(.6)}}
@keyframes draw{from{transform:scaleX(0)}}
@keyframes drawy{from{transform:scaleY(0)}}
@keyframes caret{0%,49%{opacity:1}50%,100%{opacity:0}}
@keyframes cakein{from{opacity:0;transform:scale(.7)}}
@keyframes chosen{from{background:transparent;border-color:rgba(247,242,233,.2);color:var(--cream)}}
@keyframes beat{50%{box-shadow:0 0 0 4px var(--cream),0 0 0 10px rgba(184,148,82,.2)}}
@keyframes in{from{transform:translateX(28px);opacity:0}}
@keyframes bob{50%{transform:translateY(-6px)}}
@keyframes pop{0%{transform:scale(.95)}60%{transform:scale(1.03)}}

/* section transitions: thin gold rule instead of scallops */
.demo::before,.roles::before,.faq::before{content:"";position:absolute;left:0;right:0;top:0;height:1px;background:linear-gradient(90deg,transparent,var(--car),transparent)}

/* DEMO: cake configurator */
.demo{position:relative;background:var(--esp);color:var(--cream);padding:130px 48px 120px;background-image:repeating-linear-gradient(45deg,rgba(247,242,233,.014) 0 1px,transparent 1px 8px),radial-gradient(ellipse 70% 50% at 85% 0%,rgba(184,148,82,.12),transparent 60%)}
.orb{position:absolute;border-radius:50%;border:1px solid var(--gold-line);pointer-events:none;transform:translate3d(0,calc(var(--sy)*-.05px),0)}
.in-w{position:relative;max-width:1260px;margin:0 auto}
.demo h2,.finale h2{font-weight:900;font-size:clamp(2.2rem,6vw,5.2rem);line-height:.95;letter-spacing:-.05em}
.demo h2 em,.finale h2 em{font-style:normal;color:var(--car-l)}
.demo .sub{max-width:46ch;color:var(--latte);margin:18px 0 34px}
.demo-flag{display:inline-flex;align-items:center;margin-left:10px;padding:4px 10px;border-radius:var(--r);border:1px solid var(--car);color:var(--car-l);font-size:.62rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;white-space:nowrap;vertical-align:middle}
.rail{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;list-style:none;margin-bottom:24px;font-weight:700;font-size:.72rem;letter-spacing:.16em;text-transform:uppercase}
.rail li{padding-top:12px;border-top:2px solid rgba(247,242,233,.16);color:rgba(247,242,233,.4);transition:.4s}
.rail li.on{border-color:var(--car);color:var(--cream)}
.rail li.done{border-color:var(--latte);color:var(--latte)}
.win{border-radius:var(--r);overflow:hidden;background:var(--w);color:var(--esp);border:1px solid var(--gold-line);box-shadow:0 60px 110px -24px rgba(0,0,0,.7)}
.chrome{display:flex;align-items:center;gap:7px;padding:12px 18px;background:var(--cof);color:var(--car-l);border-bottom:1px solid var(--gold-line)}
.chrome i{width:8px;height:8px;border-radius:50%;background:var(--car);opacity:.5}
.chrome .lbl{margin-left:auto}
.panes{display:grid;grid-template-columns:240px 1fr 330px;min-height:580px}
.ctl{padding:22px;border-right:1px solid var(--line);background:var(--cream)}
.ctl fieldset{border:0;margin-bottom:20px}
.ctl legend{font-size:.62rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--caramel);margin-bottom:9px}
.ctl label{display:inline-block;margin:0 4px 6px 0}
.ctl span{display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border:1px solid var(--latte);border-radius:var(--r);font-size:.76rem;font-weight:700;cursor:pointer;background:var(--w);transition:.25s}
.ctl span:hover{border-color:var(--car)}
.ctl span[style]::before{content:"";width:12px;height:12px;border-radius:50%;background:var(--c);border:1px solid rgba(36,21,15,.35)}
.ctl input:checked+span{background:var(--esp);border-color:var(--car);color:var(--car-l);box-shadow:0 8px 14px -8px rgba(36,21,15,.6)}
.ctl input:focus-visible+span{outline:2px solid var(--car);outline-offset:2px}
.ctl input:disabled+span{opacity:.5;cursor:default}
.stage{position:relative;display:grid;place-items:center;padding:64px 20px 76px;background:radial-gradient(circle at 50% 42%,rgba(255,255,255,.9),transparent 58%),repeating-linear-gradient(45deg,rgba(36,21,15,.025) 0 1px,transparent 1px 8px),var(--beige)}
.stage .tag{position:absolute;left:18px;top:16px;line-height:1.6;color:var(--mocha)}
.stage .tag b{display:block;color:var(--esp);font-size:.9rem;letter-spacing:0;text-transform:none;font-weight:800}
.stage .plate{width:min(94%,390px)}
.stage .plate svg{width:92%}
.stage.made .plate{box-shadow:0 0 0 8px rgba(184,148,82,.3),0 18px 34px rgba(36,21,15,.2)}
.stage.delivered .plate{box-shadow:0 0 0 8px rgba(184,148,82,.6),0 22px 44px rgba(36,21,15,.3)}
.stage.delivered #made{background:var(--car);color:var(--esp);font-weight:800}
.pop{animation:pop .45s var(--e)}
.bob{animation:bob 6s ease-in-out infinite}
#send{position:absolute;bottom:20px;padding:15px 30px;box-shadow:0 14px 26px -10px rgba(184,148,82,.8)}
#made{position:absolute;bottom:18px;padding:10px 18px;border-radius:var(--r);background:var(--esp);color:var(--car-l);font-weight:700;font-size:.78rem;letter-spacing:.06em;opacity:0;transform:translateY(12px);transition:.5s var(--e);pointer-events:none}
.stage.made #made{opacity:1;transform:none}
.stage.made #send{display:none}
.feed{background:var(--ink);color:var(--cream);padding:22px}
.feed-h{display:block;margin-bottom:14px;color:var(--car-l)}
.req{padding:14px;border-radius:var(--r);background:var(--cof);border-left:2px solid var(--car);margin-bottom:14px;font-size:.84rem;line-height:1.6}
.req b{color:var(--car-l)}
.feed p{color:rgba(247,242,233,.62);font-size:.84rem}
.bids{list-style:none;margin-top:12px}
.bid{display:grid;grid-template-columns:1fr auto;gap:6px 10px;align-items:center;padding:13px;margin-bottom:8px;border:1px solid rgba(247,242,233,.18);border-radius:var(--r);animation:in .5s var(--e);transition:.4s}
.bid small{display:block;color:rgba(247,242,233,.55)}
.bid strong{font-size:1.3rem;font-weight:800;letter-spacing:-.03em;color:var(--car-l)}
.bid .btn{grid-column:1/-1;padding:9px;justify-content:center;font-size:.68rem}
.bid.won{border-color:var(--car);background:rgba(184,148,82,.18);box-shadow:0 0 0 1px var(--car)}
.bid.lost{opacity:.3}
.nums{display:flex;flex-wrap:wrap;gap:clamp(28px,6vw,90px);margin-top:80px;padding-top:34px;border-top:1px solid var(--gold-line)}
.nums div{font-size:clamp(3rem,6vw,5.4rem);font-weight:900;line-height:.9;letter-spacing:-.06em}
.nums i{font-style:normal;color:var(--car-l)}
.nums span{display:block;margin-top:12px;font-size:.66rem;font-weight:700;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}

/* ROLES */
.roles{position:relative;padding:130px 48px 120px;background:var(--cream);color:var(--esp);transition:background .7s var(--e),color .7s var(--e)}
.roles:has(#r-b:checked){background:var(--cof);color:var(--cream)}
.roles h2{font-weight:900;font-size:clamp(2.2rem,6vw,5rem);line-height:.95;letter-spacing:-.05em}
.sw{position:relative;display:grid;grid-template-columns:1fr 1fr;width:min(100%,440px);margin:34px 0 60px;padding:4px;border:1px solid var(--car);border-radius:var(--r)}
.sw::before{content:"";position:absolute;top:4px;bottom:4px;left:4px;width:calc(50% - 4px);border-radius:var(--r);background:var(--car);transition:transform .55s var(--e)}
.roles:has(#r-b:checked) .sw::before{transform:translateX(100%)}
.sw span{position:relative;display:block;padding:14px 10px;text-align:center;font-weight:800;font-size:.74rem;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;transition:color .4s}
.sw input:checked+span{color:var(--esp)}
.sw input:focus-visible+span{outline:2px solid var(--car);outline-offset:3px}
.stack{display:grid}
.pane{grid-area:1/1;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:start;opacity:0;visibility:hidden;pointer-events:none;transition:opacity .6s var(--e),transform .7s var(--e),visibility 0s .7s}
.pc{transform:translateX(-60px)}
.pb{transform:translateX(60px)}
.pb .steps{order:2}
.roles:has(#r-c:checked) .pc,.roles:has(#r-b:checked) .pb{opacity:1;visibility:visible;pointer-events:auto;transform:none;transition-delay:.15s,.15s,0s}
.steps{list-style:none;counter-reset:n}
.steps li{counter-increment:n;display:grid;grid-template-columns:90px 1fr;padding:22px 0;border-top:1px solid var(--gold-line);opacity:0;transform:translateY(16px);transition:.6s var(--e)}
.steps li::before{content:counter(n,decimal-leading-zero);font-size:3rem;font-weight:900;line-height:1;letter-spacing:-.06em;color:var(--car)}
.steps b{display:block;font-size:1.25rem;font-weight:800;letter-spacing:-.02em}
.steps span{opacity:.75}
.steps li:nth-child(2){transition-delay:.12s}.steps li:nth-child(3){transition-delay:.24s}.steps li:nth-child(4){transition-delay:.36s}
.roles:has(#r-c:checked) .pc li,.roles:has(#r-b:checked) .pb li,.roles:has(#r-c:checked) .pc .mock,.roles:has(#r-b:checked) .pb .mock{opacity:1;transform:none}
/* product-UI cards: espresso, gold frame, in both modes */
.mock{background:var(--esp);color:var(--cream);padding:30px;border-radius:var(--r);border:1px solid var(--car);box-shadow:0 30px 60px -20px rgba(0,0,0,.5),inset 0 0 0 5px var(--esp),inset 0 0 0 6px var(--gold-line);opacity:0;transform:translateY(28px) scale(.98);transition:transform .8s var(--e) .25s,opacity .8s var(--e) .25s}
.mock h3{font-size:1.6rem;font-weight:800;letter-spacing:-.03em;margin:8px 0}
.mock .lbl{color:var(--car-l)}
.who{display:flex;align-items:center;gap:12px;margin:16px 0 8px}
.who i{width:40px;height:40px;border-radius:var(--r);border:1px solid var(--car);color:var(--car-l);display:grid;place-items:center;font-style:normal;font-weight:800;font-size:.8rem}
.who small{opacity:.68}
.who strong{margin-left:auto;font-size:1.3rem;font-weight:800;color:var(--car-l)}
.trk{list-style:none;margin:18px 0 24px}
.trk li{position:relative;padding:0 0 20px 30px;color:rgba(247,242,233,.5);font-weight:600}
.trk li::before{content:"";position:absolute;left:0;top:3px;width:13px;height:13px;border-radius:50%;background:rgba(247,242,233,.2)}
.trk li::after{content:"";position:absolute;left:6px;top:20px;bottom:0;width:1px;background:rgba(247,242,233,.2)}
.trk li:last-child::after{display:none}
.trk .d,.trk .n{color:var(--cream)}
.trk .d::before{background:var(--car)}
.trk .n::before{background:var(--car-l);box-shadow:0 0 0 5px rgba(184,148,82,.3)}
.mock dl{display:grid;grid-template-columns:auto 1fr;gap:8px 18px;margin:16px 0;color:var(--taupe);font-size:.88rem}
.mock dd{color:var(--cream);font-weight:700}
.offer{display:flex;gap:10px;margin:18px 0 8px}
.offer input{flex:1;min-width:0;padding:12px 14px;border:1px solid var(--gold-line);border-radius:var(--r);font-weight:800;font-size:1.05rem;background:transparent;color:var(--cream)}
.offer input:focus{border-color:var(--car);outline:none}
.sent{min-height:1.4em;margin-bottom:10px;font-weight:700;font-size:.82rem;color:var(--car-l)}

/* FAQ */
.faq{position:relative;background:var(--beige);color:var(--esp);padding:120px 48px 70px}
.faq h2{font-weight:900;font-size:clamp(2.2rem,6vw,5rem);line-height:.95;letter-spacing:-.05em;margin-bottom:16px}
.faq h2 em{font-style:normal;color:var(--caramel)}
.faq .in-w{text-align:center;display:flex;flex-direction:column;align-items:center}
.faq .sub{max-width:46ch;color:var(--mocha);margin-bottom:34px}
.faq-sw{position:relative;display:grid;grid-template-columns:1fr 1fr;width:min(100%,360px);margin-bottom:52px;padding:4px;border:1px solid var(--esp);border-radius:var(--r)}
.faq-sw::before{content:"";position:absolute;top:4px;bottom:4px;left:4px;width:calc(50% - 4px);border-radius:var(--r);background:var(--esp);transition:transform .55s var(--e)}
body:has(#f-b:checked) .faq-sw::before{transform:translateX(100%)}
.faq-sw button{position:relative;display:block;width:100%;padding:12px 10px;background:none;border:0;font-weight:800;font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;color:var(--esp);transition:color .4s}
body:has(#f-c:checked) .faq-sw button[data-role="f-c"],body:has(#f-b:checked) .faq-sw button[data-role="f-b"]{color:var(--car-l)}
.faq-list{list-style:none;max-width:840px;text-align:left}
.faq-stack{display:grid}
.faq-pane{grid-area:1/1;opacity:0;visibility:hidden;pointer-events:none;transform:translateX(var(--fx,-60px));transition:opacity .6s var(--e),transform .7s var(--e),visibility 0s .7s}
.faq-pane.faq-pb{--fx:60px}
body:has(#f-c:checked) .faq-pc,body:has(#f-b:checked) .faq-pb{opacity:1;visibility:visible;pointer-events:auto;transform:none;transition-delay:.15s,.15s,0s}
.faq-item{border-bottom:1px solid var(--gold-line)}
.faq-item:first-child{border-top:1px solid var(--gold-line)}
.faq-q{width:100%;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:26px 4px;background:none;border:0;text-align:left;font-weight:700;font-size:clamp(1.05rem,2vw,1.3rem);letter-spacing:-.01em;color:var(--esp);cursor:pointer;transition:color .3s}
.faq-q:hover{color:var(--caramel)}
.faq-q .plus{flex:none;position:relative;width:26px;height:26px;border:1px solid var(--car)}
.faq-q .plus::before,.faq-q .plus::after{content:"";position:absolute;left:50%;top:50%;background:var(--car);transform:translate(-50%,-50%)}
.faq-q .plus::before{width:10px;height:1.5px}
.faq-q .plus::after{width:1.5px;height:10px;transition:transform .35s var(--e)}
.faq-item.open .faq-q .plus::after{transform:translate(-50%,-50%) rotate(90deg) scaleY(0)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .4s var(--e)}
.faq-a p{padding:0 4px 28px;max-width:64ch;color:var(--mocha);font-size:.96rem;line-height:1.75}
.faq-foot{margin-top:64px;padding-top:24px;border-top:1px solid var(--gold-line);font-size:.7rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--mocha);text-align:center}

/* LOGIN MODAL */
.modal-overlay{position:fixed;inset:0;z-index:200;background:rgba(28,14,8,.9);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .35s}
.modal-overlay.active{opacity:1;pointer-events:all}
.modal{display:grid;grid-template-columns:248px 1fr;width:700px;max-width:100%;max-height:96vh;border-radius:var(--r);border:1px solid var(--car);overflow:hidden;box-shadow:0 40px 100px rgba(0,0,0,.7);transform:translateY(24px);opacity:0;transition:transform .45s var(--e),opacity .35s}
.modal-overlay.active .modal{transform:none;opacity:1}
.modal-left{background:var(--esp);background-image:radial-gradient(ellipse 120% 40% at 0 0,rgba(184,148,82,.14),transparent 62%);padding:42px 24px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:var(--cream);border-right:1px solid var(--gold-line)}
.modal-logo-name{font-weight:800;font-size:1.2rem;letter-spacing:.01em;margin-bottom:24px}
.modal-logo-name span{color:var(--car-l)}
.modal-cake{width:112px;aspect-ratio:1;border-radius:var(--r);border:1px solid var(--car);box-shadow:inset 0 0 0 5px var(--esp),inset 0 0 0 6px var(--gold-line);color:var(--car-l);display:grid;place-items:center;margin-bottom:20px;animation:bob 4s ease-in-out infinite}
.modal-cake svg{width:60%}
.modal-tagline-sub{font-size:.68rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--taupe);line-height:1.9}
.modal-right{background:var(--cream);padding:34px 32px 28px;display:flex;flex-direction:column;justify-content:center;position:relative;overflow-y:auto}
.modal-close{position:absolute;top:12px;right:16px;background:none;border:0;color:var(--mocha);font-size:1.5rem;cursor:pointer;line-height:1;transition:color .3s}
.modal-close:hover{color:var(--car)}
.form-title{font-size:1.55rem;font-weight:800;letter-spacing:-.03em;margin-bottom:20px;line-height:1.2}
.alert{padding:10px 12px;border-radius:var(--r);margin-bottom:12px;font-size:.8rem;font-weight:600;border-left:2px solid}
.alert-err{background:#F6ECEA;border-color:var(--burg);color:var(--burg)}
.alert-ok{background:var(--beige);border-color:var(--car);color:var(--esp)}
.alert-pending,.alert-google-hint{background:var(--beige);border-left:2px solid var(--car);border-radius:var(--r);padding:.65rem .85rem;margin-bottom:12px;display:flex;gap:.55rem;align-items:flex-start;font-size:.78rem;color:var(--mocha);line-height:1.5}
.alert-google-hint img{width:13px;height:13px;flex-shrink:0;margin-top:2px}
.pending-title{font-weight:800;color:var(--caramel);font-size:.78rem;margin-bottom:2px}
.pending-msg{font-size:.72rem;color:var(--mocha);line-height:1.5}
.field{margin-bottom:12px}
.field label{display:block;font-size:.6rem;font-weight:800;color:var(--mocha);text-transform:uppercase;letter-spacing:.2em;margin-bottom:6px}
.field input{width:100%;padding:11px 13px;background:var(--w);border:1px solid var(--latte);border-radius:var(--r);font-size:.9rem;outline:none;transition:.25s}
.field input::placeholder{color:var(--taupe)}
.field input:focus{border-color:var(--car);box-shadow:0 0 0 3px rgba(184,148,82,.18)}
.field input.is-invalid{border-color:var(--burg);border-width:2px}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:40px}
.pw-toggle{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:0;cursor:pointer;color:var(--mocha);display:flex;padding:3px}
.pw-toggle:hover{color:var(--car)}
.row-extra{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.row-extra label{display:flex;align-items:center;gap:6px;font-size:.75rem;color:var(--mocha);cursor:pointer}
.row-extra input{accent-color:var(--car)}
.row-extra a{font-size:.75rem;color:var(--caramel);text-decoration:none;font-weight:700}
.btn-signin{width:100%;padding:14px;background:var(--esp);color:var(--car-l);font-weight:800;font-size:.76rem;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--esp);border-radius:var(--r);cursor:pointer;transition:.3s}
.btn-signin:hover{background:var(--car);border-color:var(--car);color:var(--esp);transform:translateY(-1px)}
.divider{display:flex;align-items:center;gap:10px;margin:14px 0}
.divider-line{flex:1;height:1px;background:var(--gold-line)}
.divider-text{font-size:.56rem;font-weight:700;color:var(--mocha);white-space:nowrap;letter-spacing:.18em;text-transform:uppercase}
.google-cards,.register-links{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.google-card,.reg-link{display:flex;align-items:center;justify-content:center;gap:8px;padding:9px 10px;border:1px solid var(--latte);border-radius:var(--r);text-decoration:none;background:var(--w);color:var(--esp);transition:.25s}
.google-card:hover,.reg-link:hover{border-color:var(--car);transform:translateY(-1px)}
.google-card img{width:14px;height:14px}
.reg-link-icon{display:flex}
.reg-link-icon svg{stroke:var(--car)}
.google-card-sub,.reg-link-action{font-size:.52rem;text-transform:uppercase;letter-spacing:.14em;color:var(--mocha);font-weight:700}
.google-card-title,.reg-link-title{font-size:.78rem;font-weight:800}

/* RESPONSIVE (recomposed, not just shrunk) */
@media(max-width:1000px){
.bar{padding:12px 20px;gap:14px}.bar .lnk{display:none}
.hero{padding:26px 20px 56px;min-height:0;justify-content:flex-start}
.hero h1 span+span{padding-left:0;white-space:normal}
.hero-meta .lbl:last-child,.hero-foot>span:first-child{display:none}
.hero-foot{justify-content:flex-start}
.flow{grid-template-columns:1fr;gap:28px}
.flow>li{padding-left:32px}
.flow>li:nth-child(even) .node{margin-top:0}
.flow::before,.flow::after{left:6px;right:auto;top:7px;bottom:0;width:1px;height:auto}
.flow::after{width:2px;transform-origin:top;animation-name:drawy}
.flow .dot{position:absolute;left:0;top:1px}
.demo,.roles{padding-left:20px;padding-right:20px}
.demo{padding-top:110px}.roles{padding-top:100px}
.faq{padding:90px 20px 56px}
.rail{grid-template-columns:repeat(2,1fr)}
.panes{grid-template-columns:1fr}
.ctl{border-right:0;border-bottom:1px solid var(--line)}
.stage{min-height:420px}
.pane{grid-template-columns:1fr;gap:40px}
.pb .steps{order:0}
}
@media(max-width:640px){
.hero-sub{white-space:normal;max-width:52ch}
.faq-q{padding:20px 2px;gap:14px}
.steps li{grid-template-columns:64px 1fr}
.mock{padding:22px}
}
@media(max-width:820px){
.modal{grid-template-columns:1fr}.modal-left{display:none}
.modal-right{padding:32px 22px 24px}
.google-cards,.register-links{grid-template-columns:1fr}
}
@media(prefers-reduced-motion:reduce){
*,*::before,*::after{animation:none!important;transition:none!important}
html{scroll-behavior:auto}
.rv [data-r]{opacity:1!important;transform:none!important;filter:none!important;clip-path:none!important}
}
</style>
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><symbol id="ico-cake" viewBox="0 0 24 24"><rect x="4" y="15" width="16" height="5" rx="1.2" fill="currentColor"/><rect x="6.5" y="10" width="11" height="5" rx="1.2" fill="currentColor" opacity=".8"/><rect x="9" y="6" width="6" height="4" rx="1.2" fill="currentColor" opacity=".6"/><rect x="11.4" y="3" width="1.2" height="3" fill="currentColor"/><ellipse cx="12" cy="2.6" rx="1" ry="1.4" fill="#C47B2E"/></symbol></svg>

<header class="bar">
    <a class="brand" href="{{ url('/') }}" aria-label="BakeSphere home"><i><svg width="20" height="20" aria-hidden="true"><use href="#ico-cake"/></svg></i>Bake<b>Sphere</b></a>
    <a class="lnk" href="#roles" data-role="r-c">For customers</a>
    <a class="lnk" href="#roles" data-role="r-b">For bakers</a>
    <button class="btn car" type="button" onclick="openLogin()">Log in</button>
</header>

<main>
<section class="hero" aria-labelledby="hd">
    <div class="hero-meta a" style="--a:100ms"><span class="lbl">Cake marketplace</span><span class="lbl">Design in 3D · Bakers bid · You choose</span></div>
    <h1 id="hd"><span class="a" style="--a:180ms">Customers bring the idea.</span><span class="a" style="--a:320ms">Bakers bring it to life.</span></h1>
    <p class="hero-sub a" style="--a:460ms">Design a cake in 3D, send it as a request, and let bakers offer their price. The whole marketplace, playing live below.</p>
    <ol class="flow" aria-label="From idea to cake">
        <li><div class="fh"><i class="dot"></i><span class="lbl"><em>01</em>Idea</span></div><div class="node bubble">“A 6-inch vanilla heart cake.”<span class="chip">Customer</span></div><small class="meta">Idea by the customer</small></li>
        <li><div class="fh"><i class="dot"></i><span class="lbl"><em>02</em>3D design</span></div><div class="node mini"><div class="plate" id="heroCake"></div><span class="chip d">Live 3D</span></div><small class="meta">Designing specs of the cake</small></li>
        <li><div class="fh"><i class="dot"></i><span class="lbl"><em>03</em>Request</span></div><div class="node tkt"><b>Request #2481</b><dl><dt>Size</dt><dd>6 in</dd><dt>Style</dt><dd>Heart, vanilla</dd><dt>Budget</dt><dd>₱750–₱1,000</dd></dl><span class="chip d">Sent to 3 bakers</span></div><small class="meta">Specs travel with it</small></li>
        <li><div class="fh"><i class="dot"></i><span class="lbl"><em>04</em>Baker offers</span></div><div class="node offers"><div><span>Sugar &amp; Salt</span><span>₱780</span></div><div class="sel"><span>Mika’s Oven</span><span>₱850</span></div><div><span>Tanaw Bakehouse</span><span>₱900</span></div><span class="chip">Baker side</span></div><small class="meta">Customer picks one</small></li>
        <li><div class="fh"><i class="dot"></i><span class="lbl"><em>05</em>Delivery</span></div><div class="node tkt"><b>Order #2481</b><dl><dt>Baker</dt><dd>Mika’s Oven</dd><dt>Status</dt><dd>Delivered</dd><dt>Total</dt><dd>₱850</dd></dl><span class="chip d">Completed</span></div><small class="meta">Cake in hand</small></li>
    </ol>
    <div class="hero-foot a" style="--a:1200ms"><span>Free to design. Nothing is sent in the demo.</span><span class="ra"><a href="#roles" data-role="r-c">I want a cake →</a><a href="#roles" data-role="r-b">I make cakes →</a></span></div>
</section>  

<section class="demo" id="demo" aria-labelledby="dh">
    <div class="orb" style="width:620px;height:620px;right:-220px;top:80px"></div><div class="orb" style="width:380px;height:380px;right:-120px;top:200px"></div>
    <div class="in-w">
        <h2 id="dh" data-r="up">Design it. Price it.<br><em>Watch bakers bid.</em></h2>
        <p class="sub" data-r="up" style="--d:120ms">Change the cake, send the request <span class="demo-flag">Live demo · nothing is sent</span></p>
        <ol class="rail" id="rail" aria-label="Request progress"><li class="on">Design it</li><li>Price it</li><li>Bakers bid</li><li>Cake gets made</li></ol>
        <div class="win" data-r="scale">
            <div class="chrome"><i></i><i></i><i></i><span class="lbl">New request</span></div>
            <div class="panes">
                <div class="ctl" id="ctl" role="group" aria-label="Cake options"></div>
                <div class="stage" id="stage">
                    <div class="tag lbl">Your cake<b id="ro"></b><span id="bud"></span></div>
                    <div class="plate bob" id="cake"></div>
                    <button class="btn car" id="send" type="button">Send request</button>
                    <div id="made" role="status"></div>
                </div>
                <div class="feed" aria-live="polite"><span class="lbl feed-h">Baker inbox</span>
                    <div class="req"><span class="lbl">Request #2481</span><br><span id="req"></span></div>
                    <div id="feed"><p>No offers yet. Send the request and nearby bakers will answer.</p></div>
                </div>
            </div>
        </div>
        <div class="nums" data-stagger>
            <div><b data-count="500">0</b><i>+</i><span>Cake decorators</span></div>
            <div><b data-count="12">0</b><i>k</i><span>Cake orders</span></div>
            <div><b data-count="4.9" data-dec="1">0</b><i>★</i><span>Avg. baker rating</span></div>
        </div>
    </div>
</section>

<section class="roles" id="roles" aria-labelledby="rq">
    <div class="in-w">
        <h2 id="rq" data-r="up">What brings you to BakeSphere?</h2>
        <div class="sw" role="radiogroup" aria-label="I am a" data-r="up" style="--d:120ms">
            <label><input class="sr" type="radio" name="role" id="r-c" checked><span>I want a cake</span></label>
            <label><input class="sr" type="radio" name="role" id="r-b"><span>I make cakes</span></label>
        </div>
        <div class="stack">
            <div class="pane pc">
                <ol class="steps">
                    <li><div><b>Design</b><span>Size, shape, frosting and add-ons in a 3D preview.</span></div></li>
                    <li><div><b>Request</b><span>Set your budget and send it to bakers.</span></div></li>
                    <li><div><b>Offers</b><span>Bakers bid on your exact cake.</span></div></li>
                    <li><div><b>Choose</b><span>Pick a baker, then track the order.</span></div></li>
                </ol>
                <div class="mock" aria-label="Order tracking preview">
                    <span class="lbl">Order #2481</span>
                    <div class="who"><i>MO</i><div><b>Mika’s Oven</b><br><small>★ 4.9 · Imus</small></div><strong>₱850</strong></div>
                    <ul class="trk"><li class="d">Offer accepted</li><li class="d">Payment confirmed</li><li class="n">Baking</li><li>Out for delivery</li></ul>
                    <button class="btn car" type="button" onclick="openLogin()">Design a cake</button>
                </div>
            </div>
            <div class="pane pb">
                <ol class="steps">
                    <li><div><b>Discover</b><span>Browse open requests with full specs and budgets.</span></div></li>
                    <li><div><b>Bid</b><span>Name your price for the exact cake.</span></div></li>
                    <li><div><b>Bake</b><span>Get selected, accept the project, manage orders.</span></div></li>
                    <li><div><b>Deliver</b><span>Finish the order and build your reputation.</span></div></li>
                </ol>
                <div class="mock">
                    <span class="lbl">Custom cake request #2481</span>
                    <h3>Heart cake, 6 inch</h3>
                    <dl><dt>Sponge</dt><dd>Vanilla</dd><dt>Frosting</dt><dd>Buttercream</dd><dt>Decoration</dt><dd>Minimal</dd><dt>Budget</dt><dd>₱750–₱1,000</dd></dl>
                    <div class="offer"><input id="amt" type="number" value="850" min="0" step="10" aria-label="Your offer in pesos"><button class="btn" id="offer" type="button">Submit offer</button></div>
                    <p class="sent" id="sent" role="status"></p>
                    <button class="btn car" type="button" onclick="openLogin()">Explore requests</button>
                </div>
            </div>
        </div>
    </div>
</section>
</main>

<section class="faq" id="faq" aria-labelledby="fh">
    <div class="in-w">
        <h2 id="fh" data-r="up">Frequently Asked <em>Questions (FAQ)</em></h2>
        <p class="sub" data-r="up" style="--d:120ms">Everything you need to know before your first order or your first bid.</p>
        <input class="sr" type="radio" name="faqrole" id="f-c" checked>
        <input class="sr" type="radio" name="faqrole" id="f-b">
        <div class="faq-sw" data-r="up" style="--d:160ms">
            <button type="button" data-role="f-c">For customers</button>
            <button type="button" data-role="f-b">For bakers</button>
        </div>
        <div class="faq-stack" data-r="up" style="--d:200ms">
            <div class="faq-pane faq-pc">
                <ul class="faq-list">
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>How does pricing work?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>You set a budget range when you send your request. Bakers see your exact design and respond with their own price, so you're always comparing real offers, not fixed menu prices.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>Do I need to know exactly what I want?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Not at all. The 3D designer lets you try sizes, shapes, frostings and add-ons until it looks right, then it becomes your request. You can change it any time before sending.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>How are bakers selected?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Bakers apply and are reviewed before joining. Once you send a request, nearby bakers who can make that style are notified and respond with offers for you to compare and choose from.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>How can I know if it'll be accurate to the cake I want?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Along with your 3D design, you can upload reference photos of the exact look you're going for. Bakers see these alongside your specs, so their offer reflects what you actually have in mind.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>Is designing a cake free?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Yes. Designing in 3D and sending a request costs nothing. You only pay once you accept a baker's offer.</p></div>
                    </li>
                </ul>
            </div>
            <div class="faq-pane faq-pb">
                <ul class="faq-list">
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>How do I start getting requests?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Register as a baker and complete a short application. Once approved, you'll see open requests in your area with full specs and budgets attached.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>How do I decide what to bid?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Each request shows the customer's full design and budget range, so you can price it based on the actual size, flavor and complexity, not a guess.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>What happens after a customer picks my offer?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>You and the customer continue the transaction together until the order is completed to their specification.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>Is there a fee to join or bid?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Joining and bidding is free. Once a transaction starts, though, bakers are expected to follow through on the order — failing to comply can lead to a report and a warning on your account.</p></div>
                    </li>
                    <li class="faq-item">
                        <button class="faq-q" aria-expanded="false"><span>How does my rating and reputation work?</span><span class="plus" aria-hidden="true"></span></button>
                        <div class="faq-a"><p>Every completed order can be rated by the customer. Your rating shows on your profile and on future offers, so consistent quality helps you win more requests over time.</p></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <footer class="faq-foot">© BakeSphere. 2026</footer>
</section>

<!-- ════════ LOGIN MODAL ════════ -->
<div class="modal-overlay" id="loginOverlay" onclick="handleOverlayClick(event)">
    <div class="modal" role="dialog" aria-modal="true" aria-label="Sign in to BakeSphere">
        <div class="modal-left">
            <div class="modal-logo-name">Bake<span>Sphere</span></div>
            <div class="modal-cake"><svg viewBox="0 0 24 24" aria-hidden="true"><use href="#ico-cake"/></svg></div>
            <div class="modal-tagline-sub">Order handcrafted cakes made<br>with love.</div>
        </div>
        <div class="modal-right">
            <button class="modal-close" onclick="closeLogin()" aria-label="Close">&times;</button>
            
            <h2 class="form-title">Sign In to your Account</h2>

            {{-- Google account error --}}
            @if ($errors->has('email') && str_contains($errors->first('email'), 'Google'))
                <div class="alert-google-hint">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="">
                    <div>{{ $errors->first('email') }}</div>
                </div>
            @elseif ($errors->has('password'))
                {{-- password error: shown inline under field --}}
            @elseif ($errors->any())
                <div class="alert alert-err">
                    @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-ok">{{ session('success') }}</div>
            @endif

            @if (session('pending_approval'))
                <div class="alert-pending">
                    <div style="flex-shrink:0;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C47B2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12M6 22h12M6 2c0 6 6 8 6 10s-6 4-6 10M18 2c0 6-6 8-6 10s6 4 6 10"/></svg></div>
                    <div>
                        <div class="pending-title">Application Submitted!</div>
                        <div class="pending-msg">{{ session('pending_approval') }}</div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="juan@email.com" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" id="loginEmail" required autofocus>
                </div>
                <div class="field" id="pwFieldWrap" style="{{ $errors->has('password') ? 'display:block' : 'display:none' }}">
                    <label>Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="loginPassword" placeholder="Your password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        <button type="button" class="pw-toggle" onclick="togglePw()" id="pwToggleBtn" aria-label="Show or hide password">
                            <svg id="pwIconEye" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="pwIconEyeOff" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <div style="color:#4A2C1C;font-weight:700;font-size:.74rem;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row-extra" id="extraRow" style="{{ $errors->has('password') ? 'display:flex' : 'display:none' }}">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>
                <button type="submit" class="btn-signin" id="submitBtn">{{ $errors->has('password') ? 'Sign In' : 'Continue' }}</button>
            </form>

            <div class="divider"><div class="divider-line"></div><span class="divider-text">or continue with Google</span><div class="divider-line"></div></div>
            <div class="google-cards">
                <a href="{{ route('auth.google', ['as' => 'customer']) }}" class="google-card"><img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"><div><div class="google-card-sub">Sign in as</div><div class="google-card-title">Customer</div></div></a>
                <a href="{{ route('auth.google', ['as' => 'baker']) }}" class="google-card"><img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"><div><div class="google-card-sub">Sign in as</div><div class="google-card-title">Baker</div></div></a>
            </div>

            <div class="divider"><div class="divider-line"></div><span class="divider-text">Don't have an account yet?</span><div class="divider-line"></div></div>
            <div class="register-links">
                <a href="{{ route('register') }}" class="reg-link"><span class="reg-link-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C47B2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span><div><div class="reg-link-action">Register as</div><div class="reg-link-title">Customer</div></div></a>
                <a href="{{ route('baker.register') }}" class="reg-link"><span class="reg-link-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C47B2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4M9 4h6"/><path d="M4 21v-7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v7"/><path d="M4 21h16"/><path d="M4 14c1-1.2 2-1.2 3 0s2 1.2 3 0 2-1.2 3 0 2 1.2 3 0 2-1.2 3 0"/></svg></span><div><div class="reg-link-action">Register as</div><div class="reg-link-title">Baker</div></div></a>
            </div>
        </div>
    </div>
</div>

<script>
/* ── Modal (unchanged behaviour) ── */
function openLogin(){document.getElementById('loginOverlay').classList.add('active');document.body.style.overflow='hidden';setTimeout(()=>document.getElementById('loginEmail').focus(),350)}
function closeLogin(){document.getElementById('loginOverlay').classList.remove('active');document.body.style.overflow=''}
function handleOverlayClick(e){if(e.target===document.getElementById('loginOverlay'))closeLogin()}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeLogin()});
@if ($errors->any() || session('success') || session('pending_approval'))
    document.addEventListener('DOMContentLoaded',()=>openLogin());
@endif
function togglePw(){const f=document.getElementById('loginPassword'),a=document.getElementById('pwIconEye'),b=document.getElementById('pwIconEyeOff');f.type=f.type==='password'?'text':'password';a.style.display=f.type==='password'?'block':'none';b.style.display=f.type==='password'?'none':'block'}

const emailInput=document.getElementById('loginEmail'),pwWrap=document.getElementById('pwFieldWrap'),extraRow=document.getElementById('extraRow'),submitBtn=document.getElementById('submitBtn');
let debTimer;
emailInput.addEventListener('input',function(){
    clearTimeout(debTimer);pwWrap.style.display=extraRow.style.display='none';submitBtn.style.display='block';submitBtn.textContent='Continue';hideHints();
    const email=this.value.trim();if(!email.includes('@')||!email.includes('.'))return;
    debTimer=setTimeout(()=>checkProvider(email),600);
});
async function checkProvider(email){
    try{
        const res=await fetch('{{ route("check.email.provider") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({email})});
        const data=await res.json();
        if(data.status==='google'){pwWrap.style.display=extraRow.style.display='none';submitBtn.style.display='none';showHint('google')}
        else if(data.status==='password'){pwWrap.style.display='block';extraRow.style.display='flex';submitBtn.style.display='block';submitBtn.textContent='Sign In';hideHints()}
        else{pwWrap.style.display=extraRow.style.display='none';submitBtn.style.display='block';submitBtn.textContent='Continue';showHint('noreg')}
    }catch{pwWrap.style.display='block';extraRow.style.display='flex';submitBtn.style.display='block';submitBtn.textContent='Sign In'}
}
function showHint(type){
    hideHints();const hint=document.createElement('div');hint.className='alert-google-hint';
    if(type==='google'){hint.id='hint-google';hint.innerHTML='<img src="https://www.svgrepo.com/show/475656/google-color.svg" alt=""><div>This account uses Google Sign-In. Use the <strong>Continue with Google</strong> button below.</div>'}
    else{hint.id='hint-noreg';hint.innerHTML='<div>No account found. <a href="{{ route('register') }}" style="color:#C47B2E;font-weight:800">Register as Customer</a> or <a href="{{ route('baker.register') }}" style="color:#C47B2E;font-weight:800">Register as Baker</a>.</div>'}
    emailInput.closest('.field').after(hint);
}
function hideHints(){['hint-google','hint-noreg'].forEach(id=>{const el=document.getElementById(id);if(el)el.remove()})}
/* ── Landing experience ── */
(()=>{
const $=id=>document.getElementById(id),RM=matchMedia('(prefers-reduced-motion:reduce)').matches;

/* scroll reveals: below the fold only */
document.querySelectorAll('[data-stagger]').forEach(p=>[...p.children].forEach((c,i)=>{c.dataset.r=c.dataset.r||'up';c.style.setProperty('--d',i*110+'ms')}));
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.12,rootMargin:'0px 0px -6% 0px'});
document.querySelectorAll('[data-r]').forEach(el=>io.observe(el));
if(!RM)document.documentElement.classList.add('rv');
addEventListener('load',()=>setTimeout(()=>document.querySelectorAll('[data-r]:not(.in)').forEach(el=>{if(el.getBoundingClientRect().top<innerHeight*.92)el.classList.add('in')}),1200));

/* re-fix anchor scroll: initial jump can land short since JS-injected
   content (controls, cake SVGs, counters) grows the page after load */
if(location.hash){
 const target=document.querySelector(location.hash);
 if(target){
  const fix=()=>target.scrollIntoView({block:'start'});
  requestAnimationFrame(()=>requestAnimationFrame(fix));
  addEventListener('load',()=>setTimeout(fix,300));
 }
}

/* number counting */
const cio=new IntersectionObserver(es=>es.forEach(e=>{
 if(!e.isIntersecting)return;cio.unobserve(e.target);
 const el=e.target,t=+el.dataset.count,f=el.dataset.dec?1:0,s=performance.now();
 const fmt=v=>f?v.toFixed(1):Math.round(v);
 if(RM){el.textContent=fmt(t);return}
 const step=n=>{const p=Math.min(1,(n-s)/1400);el.textContent=fmt(t*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(step)};
 requestAnimationFrame(step)
}),{threshold:.6});
document.querySelectorAll('[data-count]').forEach(el=>cio.observe(el));

/* light parallax on the rings */
if(!RM){let k=0;addEventListener('scroll',()=>{if(k)return;k=1;requestAnimationFrame(()=>{document.documentElement.style.setProperty('--sy',scrollY);k=0})},{passive:true})}

/* role links + baker offer mock */
document.querySelectorAll('[data-role]').forEach(a=>a.addEventListener('click',()=>{$(a.dataset.role).checked=true}));
$('offer').addEventListener('click',function(){
 $('sent').textContent='Offer sent: ₱'+(+$('amt').value||0).toLocaleString('en-US')+'. Waiting for the customer.';
 this.textContent='Offer sent';this.disabled=true
});

/* cake renderer (hero + demo) */
const OPT={size:[['4 in',4],['6 in',6],['8 in',8]],shape:[['Round','round'],['Heart','heart']],frost:[['Vanilla','#F6EAD6'],['Chocolate','#4A2C1C'],['Caramel','#C47B2E'],['Mocha','#A9825F']],extra:[['None','none'],['Sprinkles','sprinkles'],['Pearls','pearls'],['Candle','candle']]};
const LBL={size:'Size',shape:'Shape',frost:'Frosting',extra:'Add-on'},RNG={4:[450,650],6:[750,1000],8:[1200,1600]};
const BK=[['Mika’s Oven','4.9',.4],['Tanaw Bakehouse','4.8',.6],['Sugar & Salt','4.9',.12]];
const S={size:6,shape:'heart',frost:0,extra:'none',stage:0},P=n=>'₱'+n.toLocaleString('en-US');
const shade=(h,f)=>'#'+[1,3,5].map(i=>Math.round(parseInt(h.substr(i,2),16)*f).toString(16).padStart(2,'0')).join('');
function cakeSVG(s,uid){
 const c=OPT.frost[s.frost][1],k=s.size/6,R=72*k,H=34,side=shade(c,.82),id='sh'+uid,ring=shade(c,.68);
 const shape=s.shape==='heart'?`<path id="${id}" transform="scale(${1.4*k} ${.9*k})" d="M0-28C-10-50-50-40-50-8C-50 20-20 38 0 56C20 38 50 20 50-8C50-40 10-50 0-28Z"/>`:`<ellipse id="${id}" rx="${R}" ry="${R*.44}"/>`;
 let g='';for(let y=H;y>0;y-=2)g+=`<use href="#${id}" x="120" y="${100+y}" fill="${side}"/>`;
 g+=`<use href="#${id}" x="120" y="100" fill="${c}" stroke="${ring}" stroke-width="1.5"/>`;
 const dark=s.frost===1||s.frost===2;
 if(s.extra==='sprinkles')for(let i=0;i<18;i++){const a=i*2.4,r=(i%5+1)*.15*R,x=120+Math.cos(a)*r,y=100+Math.sin(a)*r*.45;g+=`<rect x="${x}" y="${y}" width="7" height="2.4" rx="1.2" fill="${['#2B1810','#fff','#C47B2E','#7A4E33'][(i+(dark?1:0))%4]}" transform="rotate(${i*37} ${x} ${y})"/>`}
 if(s.extra==='pearls')for(let i=0;i<9;i++){const a=i*.7,x=120+Math.cos(a)*R*.62,y=100+Math.sin(a)*R*.27;g+=`<circle cx="${x}" cy="${y}" r="5" fill="#fff" stroke="#E6D0B3"/>`}
 if(s.extra==='candle')g+=`<rect x="116" y="64" width="8" height="34" rx="2" fill="#fff" stroke="#E6D0B3"/><ellipse cx="120" cy="56" rx="4.5" ry="8" fill="#C47B2E"/><ellipse cx="120" cy="58" rx="2.2" ry="4.5" fill="#F6EAD6"/>`;
 return `<svg viewBox="0 0 240 240" role="img" aria-label="${s.size}-inch ${s.shape} cake, ${OPT.frost[s.frost][0]} frosting, add-on: ${s.extra}"><defs>${shape}</defs>${g}</svg>`;
}
$('heroCake').innerHTML=cakeSVG(S,'h');

/* demo: controls */
$('ctl').innerHTML=Object.keys(OPT).map(k=>`<fieldset><legend>${LBL[k]}</legend>${OPT[k].map((o,i)=>{const v=k==='frost'?i:o[1];return `<label><input class="sr" type="radio" name="${k}" value="${v}"${String(S[k])===String(v)?' checked':''}><span${k==='frost'?` style="--c:${o[1]}"`:''}>${o[0]}</span></label>`}).join('')}</fieldset>`).join('');

function draw(pop){
 const [lo,hi]=RNG[S.size],nm=OPT.frost[S.frost][0];
 $('cake').innerHTML=cakeSVG(S,'d');
 $('ro').textContent=`${S.size} in ${S.shape}, ${nm.toLowerCase()}`;
 $('bud').textContent=`Budget ${P(lo)}–${P(hi)}`;
 $('req').innerHTML=`<b>${S.size} in ${S.shape}</b>, ${nm.toLowerCase()}${S.extra!=='none'?', '+S.extra:''}<br>Budget ${P(lo)}–${P(hi)}`;
 if(pop&&!RM){const c=$('cake').firstChild;c.classList.remove('pop');void c.getBoundingClientRect();c.classList.add('pop')}
}
const go=n=>{S.stage=n;[...$('rail').children].forEach((li,i)=>li.className=i<n?'done':i===n?'on':'')};
const lock=on=>{document.querySelectorAll('#ctl input').forEach(i=>i.disabled=on);$('send').disabled=on;$('send').textContent=on?'Request sent':'Send request'};
const EMPTY='<p>No offers yet. Send the request and nearby bakers will answer.</p>';
let timers=[];

function reset(){
 timers.forEach(clearTimeout);timers=[];
 chosenIdx=-1;chosenPrice=0;
 lock(false);go(0);
 $('stage').classList.remove('made','delivered');
 $('feed').innerHTML=EMPTY
}
function send(){
 const [lo,hi]=RNG[S.size];lock(true);go(1);
 $('feed').innerHTML='<p>Sent to 3 bakers nearby. Offers arrive below.</p><ul class="bids" id="bids"></ul>';
 BK.forEach((b,i)=>timers.push(setTimeout(()=>{
  const price=Math.round((lo+(hi-lo)*b[2])/10)*10;
  $('bids').insertAdjacentHTML('beforeend',`<li class="bid"><div><b>${b[0]}</b><small>★ ${b[1]} · Have an offer for you</small></div><strong>${P(price)}</strong><button class="btn car" type="button" data-i="${i}" data-p="${price}">Choose ${b[0]}</button></li>`);
  if(i===2)go(2)
 },900+i*850)));
}
let chosenIdx=-1,chosenPrice=0;
function choose(i,price){
 timers.forEach(clearTimeout);timers=[];
 chosenIdx=+i;chosenPrice=+price;
 document.querySelectorAll('.bid').forEach((li,j)=>{li.classList.add(j===+i?'won':'lost');const b=li.querySelector('button');if(b)b.remove()});
 go(3);$('stage').classList.add('made');
 document.querySelectorAll('#ctl input').forEach(x=>x.disabled=false);
 $('made').textContent='Baking with '+BK[i][0]+' · '+P(+price);
 $('feed').insertAdjacentHTML('beforeend','<p style="margin-top:12px">Order created. Baking starts now.</p><div style="display:flex;gap:8px;margin-top:10px"><button class="btn car" type="button" data-finish="1">Proceed</button><button class="btn" type="button" data-reset="1" style="background:var(--cream);color:var(--ink)">Design another</button></div>');
}
function finish(){
 $('stage').classList.add('delivered');
 $('made').textContent='Delivered ✓ · '+BK[chosenIdx][0]+' · '+P(chosenPrice);
 const btn=document.querySelector('[data-finish]');
 if(btn){btn.textContent='Delivered ✓';btn.disabled=true}
}

/* everything below is user-driven: nothing plays until you click */
$('ctl').addEventListener('change',e=>{
 const n=e.target.name;
 if(S.stage>0)reset();
 S[n]=(n==='size'||n==='frost')?+e.target.value:e.target.value;
 draw(true)
});
$('send').addEventListener('click',send);
$('feed').addEventListener('click',e=>{
 const b=e.target.closest('button');if(!b)return;
 if(b.dataset.reset){reset();return}
 if(b.dataset.finish){finish();return}
 choose(b.dataset.i,b.dataset.p)
});
draw(false);

/* ── FAQ accordion ── */
document.querySelectorAll('.faq-item').forEach(item=>{
 const q=item.querySelector('.faq-q'),a=item.querySelector('.faq-a'),p=a.querySelector('p');
 q.addEventListener('click',()=>{
  const open=item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(o=>{if(o!==item){o.classList.remove('open');o.querySelector('.faq-q').setAttribute('aria-expanded','false');o.querySelector('.faq-a').style.maxHeight=null}});
  item.classList.toggle('open',!open);
  q.setAttribute('aria-expanded',String(!open));
  a.style.maxHeight=open?null:p.offsetHeight+40+'px';
 });
});
})();
</script>
</body>
</html>