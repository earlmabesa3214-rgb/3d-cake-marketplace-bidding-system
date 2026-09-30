<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join as Baker — BakeSphere</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
      /* BakeSphere baker registration: luxury atelier system. Plus Jakarta Sans only.
   Replace the entire <style> block contents (keep the Leaflet <link> above it). */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;font-family:'Plus Jakarta Sans',system-ui,sans-serif}
:root{
--esp:#24150F;--cof:#3A241A;--cream:#F7F2E9;--beige:#EFE6D7;--caramel:#A96F42;
--gold:#B89452;--gold-l:#D4B06A;--burg:#54252C;--taupe:#9A897A;--latte:#D8C8B7;--blush:#E8D3CA;
--w:#FBF8F2;--mocha:#7A5E4C;--ink:#1C0E08;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.32);--e:cubic-bezier(.2,.7,.2,1);--r:2px;
/* legacy tokens used by inline styles and JS */
--warm-white:var(--w);--border:var(--latte);--text-dark:var(--ink);--text-muted:var(--taupe);
--brown-dark:var(--esp);--brown-mid:var(--mocha);--brown-accent:var(--caramel);--brown-pale:var(--beige);--brown-light:var(--gold-l);
--err:var(--burg);--success:var(--caramel)}
html,body{min-height:100vh;background:var(--cream);color:var(--ink)}
body{font-weight:500;line-height:1.6}
:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes fadeSlideUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}
@keyframes slideInLeft{from{opacity:0;transform:translateX(-32px)}to{opacity:1;transform:none}}
@keyframes slideInRight{from{opacity:0;transform:translateX(28px)}to{opacity:1;transform:none}}
@media(prefers-reduced-motion:reduce){
*,*::before,*::after{animation:none!important;transition:none!important}
.left-panel,.form-header,.approval-notice,.seller-type-toggle,.section-label,.map-column,.submit-wrap{opacity:1!important;transform:none!important}}

.page-wrap{display:grid;grid-template-columns:min(30vw,400px) 1fr;min-height:100vh}

/* ═══ EDITORIAL PANEL ═══ */
.left-panel{position:sticky;top:0;height:100vh;overflow:hidden;padding:2.75rem 2.5rem;display:flex;flex-direction:column;color:var(--cream);
  background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),
    radial-gradient(ellipse 130% 40% at 0 0,rgba(184,148,82,.14),transparent 62%),linear-gradient(180deg,#2B1A12,#24150F 55%,#1B0F09);
  border-right:1px solid var(--gold-line);animation:slideInLeft .7s var(--e) backwards}
.left-panel::before,.left-panel::after{display:none}
.panel-photo{position:absolute;left:0;right:0;bottom:0;width:100%;height:40%;object-fit:cover;opacity:.3;filter:saturate(.8);pointer-events:none;
  -webkit-mask-image:linear-gradient(0deg,#000 20%,transparent);mask-image:linear-gradient(0deg,#000 20%,transparent)}
.panel-num{position:absolute;right:1rem;top:5.5rem;font-size:clamp(8rem,15vw,13rem);font-weight:900;line-height:.8;letter-spacing:-.08em;color:transparent;-webkit-text-stroke:1px rgba(184,148,82,.22);pointer-events:none;user-select:none}
.brand{position:relative;z-index:1;display:flex;align-items:center;gap:1rem;margin-bottom:2.25rem}
.brand-icon{width:46px;height:46px;border:1px solid var(--gold);box-shadow:inset 0 0 0 3px var(--esp),inset 0 0 0 4px var(--gold-line);display:grid;place-items:center;flex-shrink:0;color:var(--gold-l)}
.brand-icon svg{width:22px;height:22px}
.brand-name{font-size:1.18rem;font-weight:700;color:var(--cream);line-height:1.1}
.brand-sub{font-size:.56rem;font-weight:700;letter-spacing:.36em;text-transform:uppercase;color:var(--gold);margin-top:6px}
.panel-heading{position:relative;z-index:1;font-size:clamp(2.1rem,3.3vw,3.1rem);font-weight:900;line-height:.98;letter-spacing:-.05em;margin-bottom:1rem}
.panel-heading em{font-style:normal;color:transparent;-webkit-text-stroke:1.5px var(--gold)}
.panel-sub{position:relative;z-index:1;font-size:.84rem;line-height:1.75;color:rgba(247,242,233,.6);max-width:34ch;margin-bottom:1.5rem;padding-top:1.1rem;border-top:1px solid var(--gold-line)}
.perks{position:relative;z-index:1;list-style:none}
.perks li{display:flex;gap:.85rem;align-items:flex-start;padding:.65rem 0;border-bottom:1px solid rgba(184,148,82,.14);font-size:.76rem;line-height:1.5;color:rgba(247,242,233,.55)}
.perks li:last-child{border-bottom:0}
.perk-icon{width:30px;height:30px;border:1px solid var(--gold-line);border-radius:var(--r);display:grid;place-items:center;flex-shrink:0;color:var(--gold-l)}
.perk-title{font-weight:700;color:var(--cream);font-size:.8rem;margin-bottom:.1rem}
.already-link{position:relative;z-index:1;margin-top:auto;padding-top:1.25rem;border-top:1px solid var(--gold-line);display:flex;flex-direction:column;gap:.5rem}
.already-link-label{font-size:.58rem;font-weight:700;letter-spacing:.3em;text-transform:uppercase;color:var(--gold)}
.already-link a{display:inline-flex;align-items:center;gap:.55rem;padding:.6rem .9rem;border:1px solid rgba(247,242,233,.16);border-radius:var(--r);background:rgba(36,21,15,.7);color:rgba(247,242,233,.75);text-decoration:none;font-size:.74rem;font-weight:700;transition:.3s}
.already-link a:hover{border-color:var(--gold);color:var(--gold-l)}

/* ═══ WORKSPACE ═══ */
.right-panel{min-width:0;overflow-y:auto;padding:3.5rem clamp(1.5rem,4vw,4rem) 5rem;background:radial-gradient(ellipse 60% 30% at 100% 0,rgba(184,148,82,.09),transparent 60%),var(--cream)}
.form-header{margin-bottom:1.75rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gold-line);animation:fadeSlideUp .6s var(--e) .15s backwards}
.form-header-eyebrow{font-size:.64rem;font-weight:700;letter-spacing:.3em;text-transform:uppercase;color:var(--caramel);margin-bottom:.7rem}
.form-header h1{font-size:clamp(2rem,4vw,3.2rem);font-weight:900;line-height:1;letter-spacing:-.05em;color:var(--esp);margin-bottom:.8rem}
.form-header p{font-size:.86rem;color:var(--mocha);max-width:62ch}

.alert-error{background:#F6ECEA;border:0;border-left:2px solid var(--burg);border-radius:var(--r);padding:.9rem 1.1rem;margin-bottom:1.5rem;font-size:.82rem;font-weight:600;color:var(--burg)}
.approval-notice,.homebased-notice{display:flex;gap:.8rem;align-items:flex-start;background:var(--beige);border:1px solid var(--gold-line);border-left:2px solid var(--gold);border-radius:var(--r);padding:1rem 1.2rem;color:var(--caramel)}
.approval-notice{margin-bottom:1.75rem;animation:fadeSlideUp .6s var(--e) .3s backwards}
.homebased-notice{margin-bottom:1rem;padding:.9rem 1rem}
.approval-notice-icon,.homebased-notice-icon{flex-shrink:0;color:var(--gold)}
.approval-notice-text,.homebased-notice-text{font-size:.8rem;line-height:1.65;color:var(--mocha)}
.approval-notice-text strong,.homebased-notice-text strong{color:var(--esp);font-weight:800}

/* SELLER TYPE: editorial panels */
.seller-type-toggle{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2.25rem;animation:fadeSlideUp .6s var(--e) .45s backwards}
.seller-type-card{position:relative;display:block;padding:1.4rem 1.4rem 1.3rem;cursor:pointer;background:var(--w);border:1px solid var(--latte);border-radius:var(--r);transition:border-color .3s,background .3s,box-shadow .3s}
.seller-type-card::after{content:"";position:absolute;left:-1px;right:-1px;bottom:-1px;height:3px;background:var(--gold);transform:scaleX(0);transform-origin:left;transition:transform .45s var(--e)}
.seller-type-card:hover{border-color:var(--taupe)}
.seller-type-card.active{background:var(--esp);border-color:var(--gold);color:var(--cream);box-shadow:0 18px 40px -16px rgba(36,21,15,.5)}
.seller-type-card.active::after{transform:scaleX(1)}
.seller-type-card input[type=radio]{display:none}
.stc-badge{position:absolute;top:12px;right:12px;display:inline-flex;align-items:center;gap:.3rem;font-size:.54rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;padding:3px 8px;border:1px solid var(--gold-line);border-radius:var(--r);background:transparent;color:var(--caramel)}
.seller-type-card.active .stc-badge{color:var(--gold-l);border-color:var(--gold)}
.stc-icon{color:var(--gold);margin-bottom:.5rem}
.stc-title{font-size:1.05rem;font-weight:800;letter-spacing:-.02em;color:var(--esp);margin-bottom:.25rem}
.stc-desc{font-size:.76rem;line-height:1.6;color:var(--taupe)}
.seller-type-card.active .stc-title{color:var(--cream)}
.seller-type-card.active .stc-desc{color:rgba(247,242,233,.65)}

.content-grid{display:grid;grid-template-columns:minmax(0,1fr) 400px;gap:3rem;align-items:start}

/* numbered sections via CSS counter */
form{counter-reset:sec}
.section-label{counter-increment:sec;display:flex;align-items:center;gap:.7rem;margin:2.5rem 0 1.25rem;padding-bottom:.7rem;border-bottom:1px solid var(--gold-line);font-size:.66rem;font-weight:800;letter-spacing:.26em;text-transform:uppercase;color:var(--esp);animation:fadeSlideUp .6s var(--e) backwards}
.section-label:first-child{margin-top:0}
.section-label::before{content:counter(sec,decimal-leading-zero);font-size:1.5rem;font-weight:900;letter-spacing:-.05em;color:var(--gold)}
.section-label svg{color:var(--caramel);margin-left:auto}
.map-column .section-label{margin-top:0}

.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.1rem}
.form-group{margin-bottom:1.2rem}
.form-label{display:block;margin-bottom:.5rem;font-size:.62rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:var(--mocha)}
.form-label .req{color:var(--caramel)}
.form-label .hint{font-size:.62rem;font-weight:600;letter-spacing:.04em;text-transform:none;color:var(--taupe);margin-left:4px}
.form-input{width:100%;padding:.85rem 1rem;background:var(--w);border:1px solid var(--latte);border-radius:var(--r);font-size:.9rem;font-weight:500;color:var(--ink);outline:none;transition:border-color .25s,box-shadow .25s,background .25s}
.form-input::placeholder{color:var(--taupe)}
.form-input:hover{border-color:var(--taupe)}
.form-input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.2);background:#fff}
.form-input.is-invalid{border-color:var(--burg);border-width:1.5px}
.form-input.is-valid{border-color:var(--caramel)}
textarea.form-input{resize:vertical;min-height:100px}
select.form-input{appearance:none;padding-right:2.5rem;cursor:pointer;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23B89452' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 1rem center}
.field-error{margin-top:.4rem;font-size:.74rem;font-weight:700;color:var(--burg)}
.field-hint{margin-top:.35rem;font-size:.7rem;color:var(--taupe);line-height:1.4}

.pw-wrap{position:relative}
.pw-wrap .form-input{padding-right:46px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:0;cursor:pointer;color:var(--taupe);padding:4px;display:flex;font-size:.62rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;transition:color .25s}
.pw-toggle:hover{color:var(--gold)}
.strength-bar{height:2px;background:var(--latte);margin-top:10px;overflow:hidden}
.strength-fill{height:100%;width:0;background:var(--gold)!important;transition:width .4s var(--e)}
.strength-label{margin-top:5px;font-size:.62rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel)}
.match-msg{margin-top:6px;font-size:.72rem;font-weight:700}

/* SPECIALTIES: refined tags, SVG check drawn in CSS */
.specialties-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem}
.specialty-check{display:flex;align-items:center;gap:.6rem;padding:.6rem .85rem;background:var(--w);border:1px solid var(--latte);border-radius:var(--r);cursor:pointer;user-select:none;font-size:.8rem;font-weight:600;color:var(--mocha);transition:.25s}
.specialty-check:hover{border-color:var(--gold);color:var(--esp)}
.specialty-check input{display:none}
.specialty-check.checked{background:var(--esp);border-color:var(--gold);color:var(--gold-l)}
.check-indicator{position:relative;width:15px;height:15px;flex-shrink:0;border:1px solid currentColor;border-radius:var(--r);font-size:0;color:inherit}
.specialty-check.checked .check-indicator{background:var(--gold);border-color:var(--gold)}
.specialty-check.checked .check-indicator::after{content:"";position:absolute;left:4px;top:1px;width:4px;height:8px;border:solid var(--esp);border-width:0 1.8px 1.8px 0;transform:rotate(45deg)}

/* DOCUMENT DROP ZONES */
.file-upload-area{position:relative;padding:1.25rem .75rem;text-align:center;cursor:pointer;background:var(--w);border:1px dashed var(--taupe);border-radius:var(--r);transition:.3s;overflow:hidden}
.file-upload-area:hover{border-color:var(--gold);background:var(--beige)}
.file-upload-area.has-file{border-style:solid;border-color:var(--gold);background:var(--beige)}
.file-upload-area input[type=file]{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
.file-upload-icon{color:var(--gold);margin-bottom:.3rem}
.file-upload-title{font-size:.78rem;font-weight:800;color:var(--esp);margin-bottom:.15rem}
.file-upload-hint{font-size:.68rem;color:var(--taupe);line-height:1.4}
.file-name-display{position:absolute;bottom:6px;left:50%;transform:translateX(-50%);width:90%;font-size:.7rem;font-weight:700;color:var(--caramel);display:none;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text-align:center;pointer-events:none}

/* MAP + DOCS CARDS */
.map-column{display:flex;flex-direction:column;position:sticky;top:2rem;animation:slideInRight .7s var(--e) .35s backwards}
.map-card,.docs-card{background:var(--w);border:1px solid var(--gold-line);border-radius:var(--r);overflow:hidden;box-shadow:0 20px 40px -24px rgba(36,21,15,.35)}
.map-card-header,.docs-card-header{padding:1rem 1.25rem;background:var(--esp);color:var(--cream)}
.map-card-header h3,.docs-card-header h3{font-size:.9rem;font-weight:800;letter-spacing:-.01em;display:flex;align-items:center;gap:.45rem;flex-wrap:wrap;color:var(--cream)}
.map-card-header h3 svg,.docs-card-header h3 svg{color:var(--gold-l)}
.map-card-header p,.docs-card-header p{font-size:.72rem;color:rgba(247,242,233,.6);margin-top:.25rem;line-height:1.55}
#baker-map{height:280px;width:100%;filter:sepia(.18) saturate(.85)}
.map-card-footer{padding:.9rem 1.25rem;border-top:1px solid var(--gold-line)}
.btn-locate{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.65rem .9rem;margin-bottom:.6rem;background:transparent;border:1px solid var(--esp);border-radius:var(--r);font-size:.68rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:.3s}
.btn-locate:hover{background:var(--esp);color:var(--gold-l)}
.map-coords{display:none;font-size:.72rem;font-weight:700;color:var(--caramel);margin-bottom:.4rem}
.map-coords.visible{display:block}
.map-instructions{font-size:.7rem;color:var(--taupe);line-height:1.5}
.address-field-wrap{padding:.9rem 1.25rem 1.1rem;border-top:1px solid var(--gold-line)}
.docs-card{margin-top:1.25rem}
.docs-card-body{padding:1.1rem 1.25rem 1.25rem}
.docs-card-body .form-group:last-child{margin-bottom:0}
.doc-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-top:.75rem}
.doc-grid .form-group{margin-bottom:0!important}
.doc-grid-full{grid-column:1/-1}
.section-registered,.section-homebased{display:none;margin-top:1.25rem}
.section-registered.show,.section-homebased.show{display:block}
.docs-type-badge{display:inline-flex;align-items:center;gap:.3rem;padding:2px 8px;border:1px solid var(--gold);border-radius:var(--r);font-size:.54rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--gold-l)}

/* SUBMIT */
.submit-wrap{margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--gold-line);animation:fadeSlideUp .6s var(--e) .95s backwards}
.btn-submit{display:flex;align-items:center;justify-content:center;gap:.6rem;width:100%;padding:1.05rem;background:var(--esp);color:var(--cream);border:1px solid var(--esp);border-radius:var(--r);font-size:.76rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:transform .3s var(--e),background .3s,color .3s,box-shadow .3s}
.btn-submit:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);box-shadow:0 16px 34px rgba(184,148,82,.4)}
.login-link{text-align:center;font-size:.8rem;color:var(--mocha)}
.login-link a{color:var(--esp);font-weight:800;text-decoration:none;border-bottom:1px solid var(--gold)}

/* CONFIRMATION DIALOG */
.modal-overlay{position:fixed;inset:0;z-index:9999;background:rgba(28,14,8,.88);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:1.5rem;opacity:0;pointer-events:none;transition:opacity .3s}
.modal-overlay.open{opacity:1;pointer-events:all}
.modal-box{width:100%;max-width:640px;max-height:88vh;overflow-y:auto;background:var(--cream);border:1px solid var(--gold);border-radius:var(--r);box-shadow:0 40px 100px rgba(0,0,0,.6);transform:translateY(16px);transition:transform .4s var(--e)}
.modal-overlay.open .modal-box{transform:none}
.modal-head{position:sticky;top:0;z-index:2;display:flex;align-items:center;justify-content:space-between;padding:1.15rem 1.5rem;background:var(--esp);color:var(--cream);border-bottom:1px solid var(--gold)}
.modal-head h2{font-size:1.05rem;font-weight:800;letter-spacing:-.02em;display:flex;align-items:center;gap:.6rem;color:var(--cream)}
.modal-head h2 svg{color:var(--gold-l)}
.modal-close{width:32px;height:32px;display:grid;place-items:center;background:none;border:1px solid var(--gold-line);border-radius:var(--r);color:var(--gold-l);cursor:pointer;transition:.25s}
.modal-close:hover{border-color:var(--gold);background:rgba(184,148,82,.15)}
.modal-body{padding:1.4rem 1.5rem 1.5rem}
.modal-section{margin-bottom:1.35rem}
.modal-section-title{display:flex;align-items:center;gap:.5rem;font-size:.6rem;font-weight:800;letter-spacing:.26em;text-transform:uppercase;color:var(--caramel);padding-bottom:.5rem;margin-bottom:.75rem;border-bottom:1px solid var(--gold-line)}
.modal-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem}
.modal-item{background:var(--w);border:1px solid var(--latte);border-radius:var(--r);padding:.6rem .8rem}
.modal-item.missing{background:#F6ECEA;border-color:var(--burg)}
.modal-item-label{font-size:.56rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--taupe);margin-bottom:.15rem}
.modal-item.missing .modal-item-label{color:var(--burg)}
.modal-item-value{font-size:.82rem;font-weight:700;color:var(--esp);line-height:1.35}
.modal-item.missing .modal-item-value{color:var(--burg);font-style:italic}
.modal-missing-banner{display:none;background:#F6ECEA;border-left:2px solid var(--burg);border-radius:var(--r);padding:.8rem 1rem;margin-bottom:1.25rem;font-size:.8rem;font-weight:600;color:var(--burg)}
.modal-missing-banner.show{display:block}
.modal-footer{position:sticky;bottom:0;display:flex;gap:.75rem;padding:1rem 1.5rem 1.25rem;background:var(--cream);border-top:1px solid var(--gold-line)}
.btn-modal-back,.btn-modal-confirm{padding:.85rem;border-radius:var(--r);font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;transition:.3s}
.btn-modal-back{flex:1;background:transparent;border:1px solid var(--esp);color:var(--esp)}
.btn-modal-back:hover{background:var(--beige);border-color:var(--gold)}
.btn-modal-confirm{flex:2;display:flex;align-items:center;justify-content:center;gap:.5rem;background:var(--esp);border:1px solid var(--esp);color:var(--cream)}
.btn-modal-confirm:hover:not(:disabled){background:var(--gold);border-color:var(--gold);color:var(--esp)}
.btn-modal-confirm:disabled{opacity:.5;cursor:not-allowed}
.specialties-tags{display:flex;flex-wrap:wrap;gap:.3rem;margin-top:.25rem}
.specialty-tag{padding:.2rem .55rem;border:1px solid var(--gold);border-radius:var(--r);font-size:.64rem;font-weight:800;letter-spacing:.06em;color:var(--esp);background:var(--beige)}

/* RESPONSIVE */
@media(max-width:1200px){.content-grid{grid-template-columns:1fr}.map-column{position:static}}
@media(max-width:900px){.page-wrap{grid-template-columns:260px 1fr}.right-panel{padding:2.5rem 1.75rem 4rem}.panel-num{font-size:8rem}}
@media(max-width:768px){
.page-wrap{grid-template-columns:1fr}
.left-panel{position:relative;height:auto;padding:1.75rem 1.25rem 2rem;border-right:0;border-bottom:1px solid var(--gold-line)}
.panel-photo,.perks,.already-link{display:none}
.panel-num{font-size:6rem;top:1rem;right:.75rem}
.brand{margin-bottom:1.5rem}.panel-heading{font-size:2.1rem}.panel-sub{margin-bottom:0}
.right-panel{padding:2rem 1.25rem 3rem;overflow:visible}
.seller-type-toggle,.form-row,.doc-grid,.specialties-grid,.modal-grid{grid-template-columns:1fr}
.modal-footer{flex-direction:column}
}
/* keep paired drop zones aligned */
.doc-grid .form-group{display:flex;flex-direction:column}
.doc-grid .form-group:not(.doc-grid-full) .form-label{min-height:3.3em;white-space:normal!important;font-size:.62rem!important}
.doc-grid .file-upload-area{flex:1;display:flex;flex-direction:column;justify-content:center}
    </style>
</head>
<body>
<div class="page-wrap">

    {{-- SIDEBAR --}}
    <div class="left-panel">
        <div class="brand">
          <div class="brand-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg></div>
            <div>
                <div class="brand-name">BakeSphere</div>
                <div class="brand-sub">Baker Portal</div>
            </div>
        </div>
        <img class="panel-photo" src="{{ asset('models/pic1.jpg') }}" alt="">
<div class="panel-num" aria-hidden="true">02</div>
<h2 class="panel-heading">Turn your<br>craft into<br><em>opportunity.</em></h2>
        <p class="panel-sub">Join our network of talented bakers — home-based or registered. Receive orders and grow your baking business.</p>
        <ul class="perks">
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div><div><div class="perk-title">Bid on Orders</div>Browse custom cake requests and submit competitive bids.</div></li>
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><line x1="12" y1="6" x2="12" y2="18"/></svg></div><div><div class="perk-title">Set Your Price</div>You decide what your creations are worth.</div></li>
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div><div><div class="perk-title">Home Bakers Welcome</div>No business permit needed — just a valid government ID.</div></li>
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div><div><div class="perk-title">Build Your Reputation</div>Earn reviews and grow your baker profile over time.</div></li>
        </ul>
        <div class="already-link">
            <span class="already-link-label">Quick Links</span>
            <a href="{{ route('login') }}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><circle cx="7.5" cy="15.5" r="5.5"/><path d="M21 2l-9.6 9.6"/><path d="M15.5 7.5l3 3L22 7l-3-3"/></svg> Already a baker? Sign in</a>
            <a href="{{ route('register') }}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg> Ordering a cake? Customer sign up</a>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="form-header">
            <div class="form-header-eyebrow">Baker Registration</div>
            <h1>Create Your Baker Account</h1>
            <p>Fill in your details below. Our admin team will review and approve your account within 1–2 business days before you can start bidding.</p>
        </div>

        @if($errors->any())
        <div class="alert-error"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> {{ $errors->first() }}</div>
        @endif

        <div class="approval-notice">
            <div class="approval-notice-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg></div>
            <div class="approval-notice-text"><strong>Approval required.</strong> After registering, an admin will review your profile and documents before you can start receiving orders. This usually takes 1–2 business days.</div>
        </div>

        {{-- SELLER TYPE --}}
        <div class="seller-type-toggle">
            <label class="seller-type-card active" id="card-registered" onclick="setSellerType('registered')">
                <input type="radio" name="_seller_type_ui" value="registered" checked>
                <span class="stc-badge badge-registered"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Verified</span>
                <div class="stc-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin-bottom:.4rem"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                <div class="stc-title">Registered Business</div>
                <div class="stc-desc">DTI/SEC registration and business permit.</div>
            </label>
            <label class="seller-type-card" id="card-homebased" onclick="setSellerType('homebased')">
                <input type="radio" name="_seller_type_ui" value="homebased">
                <span class="stc-badge badge-homebased"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Home Baker</span>
                <div class="stc-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin-bottom:.4rem"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg></div>
                <div class="stc-title">Home-Based Baker</div>
                <div class="stc-desc">No business permit needed — just a valid government ID and a selfie. Great for starting out!</div>
            </label>
        </div>

        <form method="POST" action="{{ route('baker.register.submit') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="seller_type" id="seller_type_input" value="registered">

            <div class="content-grid">

                {{-- ── LEFT COLUMN: Personal + Bakery + Profile ── --}}
                <div>

                    <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><circle cx="12" cy="7" r="4"/><path d="M4 21v-1a8 8 0 0 1 16 0v1"/></svg> Personal Information</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" id="first_name" class="form-input" value="{{ old('first_name') }}" required placeholder="Juan">
                            <div class="field-error" id="first_name_err" style="display:none;"></div>
                            @error('first_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" id="last_name" class="form-input" value="{{ old('last_name') }}" required placeholder="dela Cruz">
                            <div class="field-error" id="last_name_err" style="display:none;"></div>
                            @error('last_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address <span class="req">*</span></label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="you@email.com">
                        @error('email') <div class="field-error">{{ $message }}</div> @enderror
                    </div>


                  <div class="form-group">
    <label class="form-label">Phone Number <span class="req">*</span> <span class="hint">(PH — 11 digits)</span></label>
                        <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone') }}" required placeholder="09XXXXXXXXX" maxlength="11" inputmode="numeric">

                        <div class="field-error" id="phone_err" style="display:none;"></div>
                        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password <span class="req">*</span></label>
                            <div class="pw-wrap">
                                <input type="password" name="password" id="password" class="form-input" required placeholder="Min. 8 characters">
                                <button type="button" class="pw-toggle" onclick="togglePw('password', this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                            </div>
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                            <div class="strength-label" id="strengthLabel"></div>
                            @error('password') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password <span class="req">*</span></label>
                            <div class="pw-wrap">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required placeholder="Repeat password">
                                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                            </div>
                            <div class="match-msg" id="pw_match_msg"></div>
                        </div>
                    </div>

                    <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Bakery Information</div>

                    <div class="form-group">
                        <label class="form-label">Cake Shop / Brand Name <span class="req">*</span></label>
                        <input type="text" name="shop_name" class="form-input" value="{{ old('shop_name') }}" required placeholder="e.g. Sweet Dreams Bakery">
                        @error('shop_name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

 <div class="form-group">
                        <label class="form-label">Years of Experience <span class="req">*</span></label>
                        <select name="experience_years" class="form-input" required>
                            <option value="">Select...</option>
                            <option value="less_than_1" {{ old('experience_years')=='less_than_1'?'selected':'' }}>Less than 1 year</option>
                            <option value="1-2" {{ old('experience_years')=='1-2'?'selected':'' }}>1–2 years</option>
                            <option value="3-5" {{ old('experience_years')=='3-5'?'selected':'' }}>3–5 years</option>
                            <option value="5-10" {{ old('experience_years')=='5-10'?'selected':'' }}>5–10 years</option>
                            <option value="10+" {{ old('experience_years')=='10+'?'selected':'' }}>10+ years</option>
                        </select>
                        @error('experience_years') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Social Media Page / Online Shop <span class="hint">(optional but recommended)</span></label>
                        <input type="url" name="social_media" class="form-input" value="{{ old('social_media') }}" placeholder="https://facebook.com/yourbakery or Instagram link">
                        <div class="field-hint">Helps customers find and trust your shop. Boosts approval chances.</div>
                        @error('social_media') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="none" style="display:inline-block;vertical-align:middle"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> Baker Profile</div>

                    <div class="form-group">
                        <label class="form-label">Short Bio <span class="hint">(optional)</span></label>
                        <textarea name="bio" class="form-input" placeholder="Tell customers about your baking style, experience, and what makes your cakes special…">{{ old('bio') }}</textarea>
                        @error('bio') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                 <div class="form-group">
                        <label class="form-label">Cake Designs <span class="hint">(up to 3 photos of your best work) You can upload more later.</span></label>
                        <div class="file-upload-area" id="portfolio-area" style="height:auto;min-height:150px;cursor:pointer;">
                            <input type="file" name="portfolio[]" accept=".jpg,.jpeg,.png" multiple onchange="handlePortfolio(this)" style="z-index:4;">
                            <div id="portfolio-empty-state">
                                <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg></div>
                                <div class="file-upload-title">Upload Cake Designs</div>
                                <div class="file-upload-hint">Select up to 3 cake photos · JPG or PNG · Max 5MB each</div>
                            </div>
                          <div id="portfolio-preview-grid" style="display:none;width:100%;padding:8px;pointer-events:none;"></div>
                            <div class="file-name-display" id="portfolio-names" style="position:relative;transform:none;width:100%;margin-top:4px;bottom:auto;left:auto;"></div>
                        </div>
                        @error('portfolio') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Specialties <span class="hint">(select all that apply)</span></label>
                        <div class="specialties-grid">
                            @php
                                $specialtyOptions = ['Wedding Cakes','Birthday Cakes','Fondant Art','Cupcakes','Macarons','Cheesecakes','Custom Designs','Vegan Cakes','Gluten-Free','Chocolate Cakes','Pastries','Tarts'];
                                $oldSpecs = old('specialties', []);
                            @endphp
                            @foreach($specialtyOptions as $spec)
                            <label class="specialty-check {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}">
                                <input type="checkbox" name="specialties[]" value="{{ $spec }}" {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}>
                                <span class="check-indicator">{{ in_array($spec, $oldSpecs) ? '✓' : '' }}</span>
                                {{ $spec }}
                            </label>
                            @endforeach
                        </div>
                        @error('specialties') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="submit-wrap">
                  <button type="button" class="btn-submit" onclick="openModal(this.closest('form'))">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Submit Baker Application
</button>
 
<div style="display:flex;align-items:center;gap:12px;margin-top:1.25rem;margin-bottom:1rem;">
    <div style="flex:1;height:1px;background:var(--border);"></div>
    <span style="font-size:.72rem;color:#B09080;white-space:nowrap;">or sign up with Google</span>
    <div style="flex:1;height:1px;background:var(--border);"></div>
</div>
 
<a href="{{ route('auth.google', ['as' => 'baker']) }}"
   style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:.85rem;border:1.5px solid var(--border);border-radius:12px;text-decoration:none;background:var(--warm-white);font-family:'Plus Jakarta Sans',sans-serif;font-size:.94rem;font-weight:600;color:var(--brown-dark);transition:border-color .2s,background .2s,box-shadow .2s;"
   onmouseover="this.style.borderColor='var(--brown-accent)';this.style.background='var(--brown-pale)'"
   onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--warm-white)'">
    <img src="https://www.svgrepo.com/show/475656/google-color.svg" style="width:18px;height:18px;" alt="Google">
    Continue with Google as Baker
</a>
 
<div class="login-link" style="margin-top:1.25rem;">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
 
                    </div>

                </div>

                {{-- ── RIGHT COLUMN: Map + Documents ── --}}
                <div class="map-column">

                    {{-- MAP --}}
               <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Bakery Location</div>
                    <p style="font-size:.82rem;color:var(--text-muted);line-height:1.65;margin-bottom:.9rem;">Pin your location so customers know how far you are when reviewing your bids.</p>

                    <div class="map-card">
                        <div class="map-card-header">
                            <h3>Pin Your Location</h3>
                            <p>Click the map or use your current location to drop a pin.</p>
                        </div>
                        <div id="baker-map"></div>
                        <div class="map-card-footer">
                            <button type="button" class="btn-locate" onclick="locateMe()"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg> Use My Current Location</button>
                            <div class="map-coords" id="map-coords"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Pinned: <span id="coords-display"></span></div>
                            <div class="map-instructions"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M4 4l7.07 17 2.51-7.39L21 11.07z"/></svg> Click the map to place your pin, or drag to fine-tune.</div>
                        </div>
                        <div class="address-field-wrap">
                            <label class="form-label">Full Address</label>
                            <input type="text" name="full_address" id="display-address" class="form-input" value="{{ old('full_address') }}" placeholder="Auto-fills when you pin the map, or type manually">
                            @error('full_address') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <input type="hidden" name="latitude"  id="input-lat"  value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="input-lng"  value="{{ old('longitude') }}">
                    <input type="hidden" name="address"   id="input-addr" value="{{ old('address') }}">
                    @error('latitude') <div class="field-error" style="margin-top:.5rem;">Please pin your location on the map.</div> @enderror

                    {{-- ── REGISTERED BUSINESS DOCUMENTS ── --}}
                    <div class="section-registered show" id="section-registered">
                        <div class="docs-card">
                            <div class="docs-card-header">
                                <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg> Business Documents <span class="docs-type-badge registered"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Registered</span></h3>
                                <p>Upload your DTI/SEC registration, business permit, and sanitary permit.</p>
                            </div>
                            <div class="docs-card-body">

                        

                                <div class="doc-grid">
                                    <div class="form-group">
                                        <label class="form-label">Business Permit <span class="req">*</span></label>
                                        <div class="file-upload-area" id="permit-upload-area">
                                            <input type="file" name="business_permit" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'permit-upload-area','permit-file-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                            <div class="file-upload-title">Mayor's Permit</div>
                                            <div class="file-upload-hint">JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="permit-file-name"></div>
                                        </div>
                                        @error('business_permit') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">DTI / SEC Certificate <span class="req">*</span></label>
                                        <div class="file-upload-area" id="dti-upload-area">
                                            <input type="file" name="dti_certificate" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'dti-upload-area','dti-file-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
                                            <div class="file-upload-title">DTI / SEC Cert</div>
                                            <div class="file-upload-hint">JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="dti-file-name"></div>
                                        </div>
                                        @error('dti_certificate') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Sanitary / Health Permit <span class="req">*</span></label>
                                        <div class="file-upload-area" id="sanitary-upload-area">
                                            <input type="file" name="sanitary_permit" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'sanitary-upload-area','sanitary-file-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                                            <div class="file-upload-title">Sanitary Permit</div>
                                            <div class="file-upload-hint">Food Safety / Health · Max 5MB</div>
                                            <div class="file-name-display" id="sanitary-file-name"></div>
                                        </div>
                                        @error('sanitary_permit') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">BIR COR <span class="hint">(optional)</span></label>
                                        <div class="file-upload-area" id="bir-upload-area">
                                            <input type="file" name="bir_certificate" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'bir-upload-area','bir-file-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
                                            <div class="file-upload-title">BIR Certificate</div>
                                            <div class="file-upload-hint">JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="bir-file-name"></div>
                                        </div>
                                        @error('bir_certificate') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ── HOME-BASED DOCUMENTS ── --}}
                    <div class="section-homebased" id="section-homebased">
                        <div class="docs-card">
                            <div class="docs-card-header">
                                <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Home Baker Verification <span class="docs-type-badge homebased"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Home Baker</span></h3>
                                <p>No business permit needed — just a valid government ID and a selfie.</p>
                            </div>
                            <div class="docs-card-body">

                                <div class="homebased-notice">
                                    <div class="homebased-notice-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></div>
                                    <div class="homebased-notice-text">
                                        <strong>No business permit required.</strong> Similar to how Shopee and Lazada verify sellers — submit a government ID and selfie. You'll get a <em>Home Baker</em> badge with the option to upgrade to Verified later.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Government ID Type <span class="req">*</span></label>
                                    <select name="gov_id_type" class="form-input">
                                        <option value="">Select ID type...</option>
                                        <option value="national_id">Philippine National ID (PhilSys)</option>
                                        <option value="passport">Philippine Passport</option>
                                        <option value="drivers_license">Driver's License</option>
                                        <option value="sss">SSS ID</option>
                                        <option value="philhealth">PhilHealth ID</option>
                                        <option value="voters_id">Voter's ID</option>
                                        <option value="postal_id">Postal ID</option>
                                        <option value="prc_id">PRC ID</option>
                                    </select>
                                    @error('gov_id_type') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="doc-grid">
                                    <div class="form-group">
                                        <label class="form-label">Gov't ID — Front <span class="req">*</span></label>
                                        <div class="file-upload-area" id="gov-id-front-area">
                                            <input type="file" name="gov_id_front" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'gov-id-front-area','gov-id-front-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="12" r="2.5"/><line x1="13" y1="10" x2="20" y2="10"/><line x1="13" y1="14" x2="20" y2="14"/></svg></div>
                                            <div class="file-upload-title">Front of ID</div>
                                            <div class="file-upload-hint">Clear photo · JPG/PNG</div>
                                            <div class="file-name-display" id="gov-id-front-name"></div>
                                        </div>
                                        @error('gov_id_front') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" style="white-space:nowrap; font-size:.75rem;">Gov't ID — Back <span class="hint">(if applicable)</span></label>
                                        <div class="file-upload-area" id="gov-id-back-area">
                                            <input type="file" name="gov_id_back" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'gov-id-back-area','gov-id-back-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="12" r="2.5"/><line x1="13" y1="10" x2="20" y2="10"/><line x1="13" y1="14" x2="20" y2="14"/></svg></div>
                                            <div class="file-upload-title">Back of ID</div>
                                            <div class="file-upload-hint">Clear photo · JPG/PNG</div>
                                            <div class="file-name-display" id="gov-id-back-name"></div>
                                        </div>
                                        @error('gov_id_back') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group doc-grid-full">
                                        <label class="form-label">Selfie Holding Your ID <span class="req">*</span></label>
                                        <div class="file-upload-area" id="selfie-area">
                                            <input type="file" name="id_selfie" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'selfie-area','selfie-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><circle cx="12" cy="7" r="4"/><path d="M4 21v-1a8 8 0 0 1 16 0v1"/></svg></div>
                                            <div class="file-upload-title">Selfie with ID</div>
                                            <div class="file-upload-hint">Hold your ID clearly beside your face · JPG/PNG · Max 5MB</div>
                                            <div class="file-name-display" id="selfie-name"></div>
                                        </div>
                                        @error('id_selfie') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group doc-grid-full">
                                        <label class="form-label">Food Safety Certificate <span class="hint">(optional but preferred)</span></label>
                                        <div class="file-upload-area" id="food-cert-area">
                                            <input type="file" name="food_safety_cert" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'food-cert-area','food-cert-name')">
                                            <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 4px"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                                            <div class="file-upload-title">Food Safety Certificate</div>
                                            <div class="file-upload-hint">NCDA / DOH certificate · JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="food-cert-name"></div>
                                        </div>
                                        @error('food_safety_cert') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>{{-- end map-column --}}

            </div>
        </form>
    </div>
</div>
<!-- CONFIRMATION MODAL -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div class="modal-head">
            <h2><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Review Your Application</h2>
            <button type="button" class="modal-close" onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="modal-body">

            <div class="modal-missing-banner" id="missingBanner">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Please go back and fill in the highlighted required fields before submitting.
            </div>

            <!-- Personal Info -->
            <div class="modal-section">
                <div class="modal-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><circle cx="12" cy="7" r="4"/><path d="M4 21v-1a8 8 0 0 1 16 0v1"/></svg> Personal Information</div>
                <div class="modal-grid">
                    <div class="modal-item" id="ms-first_name">
                        <div class="modal-item-label">First Name</div>
                        <div class="modal-item-value" id="mv-first_name">—</div>
                    </div>
                    <div class="modal-item" id="ms-last_name">
                        <div class="modal-item-label">Last Name</div>
                        <div class="modal-item-value" id="mv-last_name">—</div>
                    </div>
                    <div class="modal-item" id="ms-email">
                        <div class="modal-item-label">Email</div>
                        <div class="modal-item-value" id="mv-email">—</div>
                    </div>
                    <div class="modal-item" id="ms-phone">
                        <div class="modal-item-label">Phone</div>
                        <div class="modal-item-value" id="mv-phone">—</div>
                    </div>
                </div>
            </div>

            <!-- Bakery Info -->
            <div class="modal-section">
                <div class="modal-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Bakery Information</div>
                <div class="modal-grid">
                    <div class="modal-item" id="ms-shop_name">
                        <div class="modal-item-label">Shop / Brand Name</div>
                        <div class="modal-item-value" id="mv-shop_name">—</div>
                    </div>
                    <div class="modal-item" id="ms-experience_years">
                        <div class="modal-item-label">Years of Experience</div>
                        <div class="modal-item-value" id="mv-experience_years">—</div>
                    </div>
                 
                    <div class="modal-item">
                        <div class="modal-item-label">Social Media</div>
                        <div class="modal-item-value" id="mv-social_media">Not provided</div>
                    </div>
                </div>
            </div>

            <!-- Baker Profile -->
            <div class="modal-section">
                <div class="modal-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="currentColor" stroke="none" style="display:inline-block;vertical-align:middle"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> Baker Profile</div>
                <div class="modal-grid">
                    <div class="modal-item">
                        <div class="modal-item-label">Bio</div>
                        <div class="modal-item-value" id="mv-bio" style="font-size:.78rem;font-weight:400;">Not provided</div>
                    </div>
                    <div class="modal-item">
                        <div class="modal-item-label">Cake Designs</div>
                        <div class="modal-item-value" id="mv-portfolio">None selected</div>
                    </div>
                </div>
                <div class="modal-item" style="margin-top:.5rem;">
                    <div class="modal-item-label">Specialties</div>
                    <div id="mv-specialties"><span style="font-size:.8rem;color:var(--text-muted);font-style:italic;">None selected</span></div>
                </div>
            </div>

            <!-- Location -->
            <div class="modal-section">
                <div class="modal-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Location</div>
                <div class="modal-item">
                    <div class="modal-item-label">Address</div>
                    <div class="modal-item-value" id="mv-full_address">Not pinned</div>
                </div>
            </div>

            <!-- Seller Type -->
            <div class="modal-section">
                <div class="modal-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg> Seller Type &amp; Documents</div>
                <div class="modal-item" style="margin-bottom:.5rem;">
                    <div class="modal-item-label">Type</div>
                    <div class="modal-item-value" id="mv-seller_type">—</div>
                </div>
                <div id="mv-docs-registered" style="display:none;">
                    <div class="modal-grid">
                        
                        <div class="modal-item" id="ms-business_permit">
                            <div class="modal-item-label">Business Permit</div>
                            <div class="modal-item-value" id="mv-business_permit">—</div>
                        </div>
                        <div class="modal-item" id="ms-dti_certificate">
                            <div class="modal-item-label">DTI / SEC Cert</div>
                            <div class="modal-item-value" id="mv-dti_certificate">—</div>
                        </div>
                        <div class="modal-item" id="ms-sanitary_permit">
                            <div class="modal-item-label">Sanitary Permit</div>
                            <div class="modal-item-value" id="mv-sanitary_permit">—</div>
                        </div>
                    </div>
                </div>
                <div id="mv-docs-homebased" style="display:none;">
                    <div class="modal-grid">
                        <div class="modal-item" id="ms-gov_id_type">
                            <div class="modal-item-label">ID Type</div>
                            <div class="modal-item-value" id="mv-gov_id_type">—</div>
                        </div>
                        <div class="modal-item" id="ms-gov_id_front">
                            <div class="modal-item-label">Gov't ID Front</div>
                            <div class="modal-item-value" id="mv-gov_id_front">—</div>
                        </div>
                        <div class="modal-item" id="ms-id_selfie">
                            <div class="modal-item-label">Selfie with ID</div>
                            <div class="modal-item-value" id="mv-id_selfie">—</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn-modal-back" onclick="closeModal()">← Go Back &amp; Edit</button>
       <button type="button" class="btn-modal-confirm" id="btnConfirmSubmit" onclick="doSubmit()">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Confirm &amp; Submit Application
</button>
        </div>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    /* SELLER TYPE */
    function setSellerType(type) {
        document.getElementById('seller_type_input').value = type;
        document.getElementById('card-registered').classList.toggle('active', type==='registered');
        document.getElementById('card-homebased').classList.toggle('active', type==='homebased');
        document.getElementById('section-registered').classList.toggle('show', type==='registered');
        document.getElementById('section-homebased').classList.toggle('show', type==='homebased');
    }

    /* SPECIALTIES */
    document.querySelectorAll('.specialty-check').forEach(label => {
        label.addEventListener('click', function () {
            const input = this.querySelector('input'), indicator = this.querySelector('.check-indicator');
         setTimeout(() => { this.classList.toggle('checked', input.checked); }, 0);
        });
    });
function handleFile(input, areaId, nameId) {
        const area = document.getElementById(areaId), nameEl = document.getElementById(nameId);
        if (input.files && input.files[0]) {
            const file = input.files[0];
            area.classList.add('has-file');
            nameEl.style.display='block';
            nameEl.textContent='✓ '+file.name;
            const prevId = areaId+'-img-prev';
            let prevEl = document.getElementById(prevId);
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!prevEl) {
                        prevEl = document.createElement('img');
                        prevEl.id = prevId;
                        prevEl.style.cssText='position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:8px;opacity:0.92;z-index:1;pointer-events:none;';
                        area.appendChild(prevEl);
                    }
                    prevEl.src = e.target.result;
                    nameEl.style.zIndex = '3';
                    nameEl.style.background = 'rgba(0,0,0,0.45)';
                    nameEl.style.color = '#fff';
                    nameEl.style.borderRadius = '20px';
                    nameEl.style.padding = '2px 10px';
                    nameEl.style.bottom = '8px';
                };
                reader.readAsDataURL(file);
            } else {
                if (prevEl) prevEl.remove();
            }
        }
    }
/* Portfolio — accumulates up to 3 files across multiple picks */
(function () {
    const dt = new DataTransfer();

    function renderGrid() {
        const area       = document.getElementById('portfolio-area');
        const nameEl     = document.getElementById('portfolio-names');
        const grid       = document.getElementById('portfolio-preview-grid');
        const emptyState = document.getElementById('portfolio-empty-state');
        const files      = Array.from(dt.files);

        area.classList.toggle('has-file', files.length > 0);
        grid.innerHTML = '';
        grid.style.display = 'grid';
        grid.style.gridTemplateColumns = 'repeat(3, 1fr)';
        grid.style.gap = '6px';
        emptyState.style.display = files.length > 0 ? 'none' : '';
        nameEl.style.display = files.length > 0 ? 'block' : 'none';
        nameEl.textContent = files.length > 0 ? '✓ ' + files.length + ' of 3 photo(s) selected' : '';

        for (let i = 0; i < 3; i++) {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'position:relative;border-radius:8px;overflow:hidden;aspect-ratio:1;flex-shrink:0;';

            if (files[i]) {
                wrap.style.background = '#eee';
                /* Remove button */
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.textContent = '✕';
                removeBtn.style.cssText = 'position:absolute;top:4px;right:4px;z-index:5;width:20px;height:20px;border-radius:50%;border:none;background:rgba(0,0,0,0.55);color:#fff;font-size:.65rem;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;padding:0;';
                const idx = i;
                removeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const newDt = new DataTransfer();
                    Array.from(dt.files).forEach(function (f, fi) { if (fi !== idx) newDt.items.add(f); });
                    /* Clear and refill dt */
                    while (dt.items.length) dt.items.remove(0);
                    Array.from(newDt.files).forEach(function (f) { dt.items.add(f); });
                    /* Sync input */
                    document.querySelector('[name="portfolio[]"]').files = dt.files;
                    renderGrid();
                });
                const reader = new FileReader();
                const capturedWrap = wrap;
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
                    capturedWrap.appendChild(img);
                    capturedWrap.appendChild(removeBtn);
                };
                reader.readAsDataURL(files[i]);
            } else {
                wrap.style.cssText += 'background:rgba(0,0,0,0.05);border:2px dashed rgba(0,0,0,0.12);display:flex;align-items:center;justify-content:center;cursor:pointer;';
              wrap.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#B89452" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:.6;pointer-events:none"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>';
                /* Clicking empty slot opens file picker */
                wrap.addEventListener('click', function (e) {
                    e.stopPropagation();
                    document.querySelector('[name="portfolio[]"]').click();
                });
            }

            grid.appendChild(wrap);
        }
    }

    window.handlePortfolio = function (input) {
        if (!input.files || input.files.length === 0) return;
        Array.from(input.files).forEach(function (f) {
            if (dt.files.length < 3) dt.items.add(f);
        });
        /* Sync input element so the form submits the accumulated files */
        input.files = dt.files;
        renderGrid();
    };
})();
    function enforceNoNumbers(inputId, errId) {
        const inp = document.getElementById(inputId), err = document.getElementById(errId);
        inp.addEventListener('input', function() {
            if (/\d/.test(this.value)) { this.value = this.value.replace(/\d/g,''); inp.classList.add('is-invalid'); err.textContent='Name must not contain numbers.'; err.style.display='block'; }
            else { inp.classList.remove('is-invalid'); err.style.display='none'; }
        });
    }
    enforceNoNumbers('first_name','first_name_err');
    enforceNoNumbers('last_name','last_name_err');

    /* PHONE */
    const phoneInput = document.getElementById('phone'), phoneErr = document.getElementById('phone_err');
  phoneInput.addEventListener('input', function() { this.value = this.value.replace(/\D/g,'').slice(0,11); });

    phoneInput.addEventListener('keydown', function(e) { const a=['Backspace','Delete','Tab','ArrowLeft','ArrowRight','Home','End']; if(a.includes(e.key))return; if(!/^\d$/.test(e.key))e.preventDefault(); });
    phoneInput.addEventListener('blur', function() {
       if (this.value.length>0 && this.value.length!==11) { phoneErr.textContent='Must be exactly 11 digits (e.g. 09XXXXXXXXX).';
 phoneErr.style.display='block'; this.classList.add('is-invalid'); }
        else { phoneErr.style.display='none'; this.classList.remove('is-invalid'); }
    });

    /* PASSWORD STRENGTH */
    const pw=document.getElementById('password'), fill=document.getElementById('strengthFill'), slabel=document.getElementById('strengthLabel');
    pw.addEventListener('input', function() {
        const v=this.value; let s=0;
        if(v.length>=8)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^A-Za-z0-9]/.test(v))s++;
        fill.style.width=(s/4*100)+'%';
        fill.style.background=['#E53935','#FB8C00','#FDD835','#43A047'][s-1]||'transparent';
        slabel.textContent=s>0?['Weak','Fair','Good','Strong'][s-1]:'';
        checkMatch();
    });

    /* PASSWORD MATCH */
    const pwc=document.getElementById('password_confirmation'), matchMsg=document.getElementById('pw_match_msg');
    function checkMatch() {
        if(!pwc.value){matchMsg.textContent='';pwc.classList.remove('is-invalid','is-valid');return;}
        if(pw.value===pwc.value){matchMsg.innerHTML='<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Passwords match';matchMsg.style.color='var(--success)';pwc.classList.remove('is-invalid');pwc.classList.add('is-valid');}
        else{matchMsg.innerHTML='<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Passwords do not match';matchMsg.style.color='var(--err)';pwc.classList.remove('is-valid');pwc.classList.add('is-invalid');}
    }
    pwc.addEventListener('input', checkMatch);
function togglePw(id,btn){
  const f=document.getElementById(id),show=f.type==='password';
  f.type=show?'text':'password';
  btn.innerHTML=show
   ?'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'
   :'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
}
    /* MAP */
    const map=L.map('baker-map').setView([14.5995,120.9842],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap',maxZoom:19}).addTo(map);
    const brownIcon=L.divIcon({html:`<div style="width:26px;height:26px;background:linear-gradient(135deg,#24150F,#B89452);border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.35);"></div>`,iconSize:[26,26],iconAnchor:[13,26],className:''});
    let marker=null;
    @if(old('latitude') && old('longitude'))
        placeMarker({{old('latitude')}},{{old('longitude')}});map.setView([{{old('latitude')}},{{old('longitude')}}],15);
    @endif
    map.on('click',e=>placeMarker(e.latlng.lat,e.latlng.lng));
    function placeMarker(lat,lng){
        if(marker)marker.setLatLng([lat,lng]);
        else{marker=L.marker([lat,lng],{icon:brownIcon,draggable:true}).addTo(map);marker.on('dragend',()=>{const p=marker.getLatLng();updateCoords(p.lat,p.lng);reverseGeocode(p.lat,p.lng);});}
        updateCoords(lat,lng);reverseGeocode(lat,lng);
    }
    function updateCoords(lat,lng){
        document.getElementById('input-lat').value=lat.toFixed(7);document.getElementById('input-lng').value=lng.toFixed(7);
        const b=document.getElementById('map-coords');b.classList.add('visible');document.getElementById('coords-display').textContent=lat.toFixed(5)+', '+lng.toFixed(5);
    }
    function reverseGeocode(lat,lng){
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`).then(r=>r.json()).then(d=>{if(d&&d.display_name){document.getElementById('display-address').value=d.display_name;document.getElementById('input-addr').value=d.display_name;}}).catch(()=>{});
    }
    function locateMe(){
        if(!navigator.geolocation){alert('Geolocation not supported.');return;}
        navigator.geolocation.getCurrentPosition(p=>{map.setView([p.coords.latitude,p.coords.longitude],16);placeMarker(p.coords.latitude,p.coords.longitude);},()=>alert('Could not get your location. Please pin manually.'));
    }
    /* ── CONFIRMATION MODAL ── */
var _bakerForm = null;

function openModal(form) {
    _bakerForm = form;
    var missing = [];

    // Helper
    function fill(id, val, required) {
        var s = document.getElementById('ms-' + id);
        var v = document.getElementById('mv-' + id);
        if (!v) return;
        if (val) {
            if (s) s.classList.remove('missing');
            v.textContent = val;
        } else {
            if (required) {
                if (s) s.classList.add('missing');
                v.textContent = 'Required — please fill this in';
                missing.push(id);
            } else {
                if (s) s.classList.remove('missing');
                v.textContent = 'Not provided';
            }
        }
    }

    // Personal
    fill('first_name',      document.querySelector('[name=first_name]')?.value,      true);
    fill('last_name',       document.querySelector('[name=last_name]')?.value,       true);
    fill('email',           document.querySelector('[name=email]')?.value,           true);
    var phone = document.querySelector('[name=phone]')?.value;
    fill('phone', phone && phone.length === 11 ? phone : '', true);

    // Bakery
    fill('shop_name',        document.querySelector('[name=shop_name]')?.value,       true);
    var expEl = document.querySelector('[name=experience_years]');
    fill('experience_years', expEl?.options[expEl.selectedIndex]?.text !== 'Select...' ? expEl?.options[expEl.selectedIndex]?.text : '', true);

    document.getElementById('mv-social_media').textContent = document.querySelector('[name=social_media]')?.value || 'Not provided';

    // Profile
    var bio = document.querySelector('[name=bio]')?.value;
    document.getElementById('mv-bio').textContent = bio ? (bio.length > 80 ? bio.slice(0,80)+'…' : bio) : 'Not provided';

    var portfolioInput = document.querySelector('[name="portfolio[]"]');
    document.getElementById('mv-portfolio').textContent = portfolioInput?.files?.length ? portfolioInput.files.length + ' photo(s) selected' : 'None selected';

    var checked = Array.from(document.querySelectorAll('[name="specialties[]"]:checked')).map(c => c.value);
    var specEl = document.getElementById('mv-specialties');
    if (checked.length) {
        specEl.innerHTML = '<div class="specialties-tags">' + checked.map(s => '<span class="specialty-tag">' + s + '</span>').join('') + '</div>';
    } else {
        specEl.innerHTML = '<span style="font-size:.8rem;color:var(--text-muted);font-style:italic;">None selected</span>';
    }

    // Location
    var addr = document.getElementById('display-address')?.value;
    document.getElementById('mv-full_address').textContent = addr || 'Not pinned yet';

    // Seller type
    var type = document.getElementById('seller_type_input').value;
    const buildingIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>';
const homeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>';
document.getElementById('mv-seller_type').innerHTML = type === 'registered' ? buildingIcon + ' Registered Business' : homeIcon + ' Home-Based Baker';
    document.getElementById('mv-docs-registered').style.display = type === 'registered' ? 'block' : 'none';
    document.getElementById('mv-docs-homebased').style.display  = type === 'homebased'  ? 'block' : 'none';

   if (type === 'registered') {
        fill('business_permit', document.querySelector('[name=business_permit]')?.files?.[0]?.name,  true);
        fill('dti_certificate', document.querySelector('[name=dti_certificate]')?.files?.[0]?.name,  true);
        fill('sanitary_permit', document.querySelector('[name=sanitary_permit]')?.files?.[0]?.name,  true);
    } else {
        var govIdEl = document.querySelector('[name=gov_id_type]');
        fill('gov_id_type',  govIdEl?.value ? govIdEl.options[govIdEl.selectedIndex].text : '', true);
        fill('gov_id_front', document.querySelector('[name=gov_id_front]')?.files?.[0]?.name,   true);
        fill('id_selfie',    document.querySelector('[name=id_selfie]')?.files?.[0]?.name,      true);
    }

    // Missing banner + confirm button
    var banner = document.getElementById('missingBanner');
    var btn    = document.getElementById('btnConfirmSubmit');
    if (missing.length > 0) {
        banner.classList.add('show');
        btn.disabled = true;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Fill in ' + missing.length + ' required field(s) first';
    } else {
        banner.classList.remove('show');
        btn.disabled = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Confirm & Submit Application';
    }

    document.getElementById('confirmModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('confirmModal').classList.remove('open');
    document.body.style.overflow = '';
}

function doSubmit() {
    if (_bakerForm) {
        document.getElementById('btnConfirmSubmit').textContent = 'Submitting\u2026';
        document.getElementById('btnConfirmSubmit').disabled = true;
        _bakerForm.submit();
    }
}

// Close on overlay click
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

</body>
</html>