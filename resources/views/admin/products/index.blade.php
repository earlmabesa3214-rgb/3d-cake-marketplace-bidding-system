@extends('layouts.admin')
@section('title', 'Products & Cakes')

@push('styles')
<style>
:root{
    --gold:#C07828;--gold-dark:#9A5E14;--gold-light:#DC9E48;--gold-soft:#FEF3E2;
    --gold-glow:rgba(192,120,40,.16);--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;
    --rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;
    --t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--bg:#F5F0E8;
    --s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;
    --r:10px;--rl:14px;--rxl:18px;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes slideUp{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:none}}
@keyframes pulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(.7);opacity:.4}}

.page{padding:0 0 5rem;}

/* HERO */
.prd-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:1rem;}
.prd-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.prd-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.prd-hero-left{position:relative;z-index:1;}
.prd-hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.prd-hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.prd-hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.prd-hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.prd-hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}
.prd-hero-right{position:relative;z-index:1;display:flex;align-items:center;gap:.625rem;}
.sbar{display:flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);border-radius:var(--r);padding:0 .8rem;height:40px;min-width:200px;transition:border-color .2s;}
.sbar:focus-within{background:rgba(255,255,255,.15);border-color:rgba(192,120,40,.5);}
.sbar svg{color:rgba(255,255,255,.5);flex-shrink:0;}
.sbar input{border:none;background:none;outline:none;font-family:'DM Sans',sans-serif;font-size:.8rem;color:#fff;width:100%;}
.sbar input::placeholder{color:rgba(255,255,255,.38);}
.btn-add{display:inline-flex;align-items:center;gap:.4rem;height:40px;padding:0 1.2rem;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:700;color:var(--espresso);background:linear-gradient(135deg,var(--gold-light),var(--gold));border:none;border-radius:var(--r);cursor:pointer;box-shadow:0 3px 12px rgba(192,120,40,.3);transition:transform .15s;white-space:nowrap;position:relative;overflow:hidden;}
.btn-add::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.22),transparent 55%);}
.btn-add:hover{transform:translateY(-2px);}

.prd-content{padding:1.5rem 2rem 0;}

.alert-ok{display:flex;align-items:center;gap:.75rem;background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.28);border-radius:var(--r);padding:.8rem 1.1rem;font-size:.86rem;color:var(--teal);margin-bottom:1.5rem;}
.alert-ok button{margin-left:auto;background:none;border:none;color:var(--teal);font-size:1.2rem;cursor:pointer;opacity:.6;}

/* PRODUCT GRID */
.pgrid{display:grid;grid-template-columns:repeat(auto-fill,minmax(288px,1fr));gap:1rem;animation:fadeUp .5s ease .08s both;}
.pcard{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rl);overflow:hidden;display:flex;flex-direction:column;transition:border-color .2s,box-shadow .2s,transform .2s;}
.pcard:hover{border-color:rgba(192,120,40,.3);box-shadow:0 8px 24px var(--gold-glow);transform:translateY(-3px);}
.pcard-vis{height:108px;background:linear-gradient(150deg,var(--s2),var(--s3));display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;flex-shrink:0;}
.pcard-vis::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(192,120,40,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(192,120,40,.04) 1px,transparent 1px);background-size:18px 18px;}
.pcard-emojis{position:relative;z-index:1;display:flex;gap:.3rem;flex-wrap:wrap;justify-content:center;align-items:center;max-width:200px;padding:.4rem;}
.pcard-emoji{font-size:1.4rem;filter:drop-shadow(0 2px 4px rgba(80,40,10,.15));transition:transform .2s;}
.pcard:hover .pcard-emoji{transform:scale(1.1);}
.pcard-ing-count{position:absolute;top:.5rem;right:.55rem;background:var(--espresso);color:#fff;font-family:'DM Mono',monospace;font-size:.58rem;font-weight:700;padding:.18rem .5rem;border-radius:20px;z-index:2;}
.pcard-empty-vis{color:var(--tm);opacity:.3;position:relative;z-index:1;}
.pcard-body{padding:.9rem 1rem;flex:1;}
.pcard-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:700;color:var(--t1);margin-bottom:.18rem;}
.pcard-desc{font-size:.76rem;color:var(--tm);line-height:1.45;margin-bottom:.55rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.pcard-price{font-family:'DM Mono',monospace;font-size:.9rem;font-weight:700;color:var(--teal);margin-bottom:.6rem;}
.itags{display:flex;flex-wrap:wrap;gap:.22rem;}
.itag{display:inline-flex;align-items:center;gap:.18rem;padding:.14rem .45rem;background:var(--gold-soft);border:1px solid rgba(192,120,40,.2);border-radius:5px;font-size:.6rem;font-weight:600;color:var(--gold-dark);white-space:nowrap;}
.itag-more{background:var(--s3);border-color:var(--bdr-md);color:var(--tm);}
.itag-none{font-size:.7rem;color:var(--tm);font-style:italic;}
.pcard-foot{display:flex;align-items:center;justify-content:space-between;padding:.65rem 1rem;border-top:1px solid var(--bdr);background:var(--s2);flex-shrink:0;}
.pill{display:inline-flex;align-items:center;gap:.28rem;padding:.22rem .65rem;border-radius:20px;font-size:.67rem;font-weight:600;}
.pill::before{content:'';width:5px;height:5px;border-radius:50%;flex-shrink:0;}
.pill.on{background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.3);color:var(--teal);}.pill.on::before{background:var(--teal);animation:pulse 2.5s infinite;}
.pill.off{background:var(--s3);border:1.5px solid var(--bdr-md);color:var(--tm);}.pill.off::before{background:var(--bdr-md);}
.foot-btns{display:flex;gap:.35rem;}
.bsm{display:inline-flex;align-items:center;gap:.25rem;height:28px;padding:0 .65rem;font-family:'DM Sans',sans-serif;font-size:.68rem;font-weight:600;border-radius:8px;border:1.5px solid;cursor:pointer;transition:all .16s;background:transparent;}
.bsm-edit{color:var(--gold-dark);border-color:rgba(192,120,40,.32);background:var(--gold-soft);}
.bsm-edit:hover{background:var(--gold);border-color:var(--gold);color:#fff;}
.bsm-del{color:var(--rose);border-color:rgba(180,56,64,.22);background:var(--rose-soft);}
.bsm-del:hover{background:var(--rose);border-color:var(--rose);color:#fff;}
.empty-st{text-align:center;padding:4rem 2rem;grid-column:1/-1;}
.empty-orb{width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,var(--gold-soft),#FDE4CC);border:1.5px solid rgba(192,120,40,.2);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;color:var(--gold);}

/* MODAL SHELL */
.mbackdrop{position:fixed;inset:0;background:rgba(44,26,10,.52);backdrop-filter:blur(6px);z-index:1040;display:none;}
.mbackdrop.show{display:block;animation:fadeIn .2s ease;}
.mwrap{position:fixed;inset:0;z-index:1050;display:none;align-items:center;justify-content:center;padding:1rem;}
.mwrap.show{display:flex;}
.mbox{background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--rxl);width:100%;max-width:640px;max-height:94vh;display:flex;flex-direction:column;box-shadow:0 28px 70px rgba(80,40,10,.22);overflow:hidden;position:relative;}
.mbox.show{animation:slideUp .28s cubic-bezier(.34,1.15,.64,1) both;}
.mbox::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--copper),var(--gold-light));z-index:1;}
.mhd{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.375rem 0;flex-shrink:0;}
.mhd-l{display:flex;align-items:center;gap:.8rem;}
.mhd-icon{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--gold),var(--copper));display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;}
.mhd-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.98rem;font-weight:700;color:var(--espresso);}
.mhd-sub{font-size:.7rem;color:var(--tm);margin-top:2px;}
.mclose{background:var(--s2);border:1.5px solid var(--bdr);color:var(--tm);cursor:pointer;width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .15s;line-height:1;}
.mclose:hover{color:var(--rose);background:var(--rose-soft);}
.mbody{padding:1.2rem 1.375rem;display:flex;flex-direction:column;gap:.8rem;overflow-y:auto;flex:1;}
.mbody::-webkit-scrollbar{width:4px;}
.mbody::-webkit-scrollbar-thumb{background:var(--bdr-md);border-radius:2px;}
.mfoot{padding:.8rem 1.375rem;display:flex;justify-content:flex-end;gap:.5rem;border-top:1px solid var(--bdr);background:var(--s2);flex-shrink:0;}
.fg label,.flbl{display:block;font-size:.68rem;font-weight:700;color:var(--t2);margin-bottom:.38rem;letter-spacing:.06em;text-transform:uppercase;}
.fi{width:100%;height:40px;padding:0 .85rem;font-family:'DM Sans',sans-serif;font-size:.84rem;color:var(--t1);background:var(--s2);border:1.5px solid var(--bdr-md);border-radius:var(--r);outline:none;transition:border-color .2s,box-shadow .2s;}
.fi:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-glow);background:#fff;}
.fi::placeholder{color:var(--tm);}
textarea.fi{height:auto;padding:.6rem .85rem;resize:vertical;min-height:64px;line-height:1.5;}
.frow{display:grid;grid-template-columns:1fr 1fr;gap:.8rem;}
.tog-card{display:flex;align-items:center;justify-content:space-between;padding:.6rem 1rem;background:var(--s2);border:1.5px solid var(--bdr);border-radius:var(--r);height:40px;transition:all .2s;}
.tog-card:has(input:checked){border-color:rgba(31,122,108,.32);background:var(--teal-soft);}
.tsw{position:relative;width:42px;height:22px;flex-shrink:0;}
.tsw input{opacity:0;width:0;height:0;position:absolute;}
.ttr{position:absolute;inset:0;background:var(--bdr-md);border-radius:12px;cursor:pointer;transition:all .25s;}
.ttr::after{content:'';position:absolute;left:3px;top:3px;width:14px;height:14px;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(40,20,0,.18);transition:all .25s cubic-bezier(.34,1.4,.64,1);}
.tsw input:checked+.ttr{background:var(--teal);}
.tsw input:checked+.ttr::after{transform:translateX(18px);}
.btn-cancel{height:36px;padding:0 1rem;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:600;color:var(--tm);background:var(--s2);border:1.5px solid var(--bdr-md);border-radius:var(--r);cursor:pointer;transition:all .15s;}
.btn-cancel:hover{background:var(--gold-soft);}
.btn-save{height:36px;padding:0 1.25rem;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:700;color:#fff;background:linear-gradient(135deg,var(--gold),var(--copper));border:none;border-radius:var(--r);cursor:pointer;box-shadow:0 3px 12px var(--gold-glow);transition:all .18s;position:relative;overflow:hidden;}
.btn-save::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.18),transparent 55%);}
.btn-save:hover{transform:translateY(-1px);}

/* INGREDIENT PICKER */
.ipicker{border:1.5px solid var(--bdr-md);border-radius:var(--r);overflow:hidden;display:flex;flex-direction:column;}
.ipicker-search{display:flex;align-items:center;gap:.4rem;padding:.5rem .8rem;background:var(--s3);border-bottom:1px solid var(--bdr);}
.ipicker-search-inner{display:flex;align-items:center;gap:.35rem;flex:1;background:var(--s);border:1.5px solid var(--bdr-md);border-radius:8px;padding:0 .6rem;height:32px;transition:border-color .2s;}
.ipicker-search-inner:focus-within{border-color:var(--gold);}
.ipicker-search-inner svg{color:var(--tm);flex-shrink:0;}
.ipicker-search-inner input{border:none;background:none;outline:none;font-family:'DM Sans',sans-serif;font-size:.78rem;color:var(--t1);width:100%;}
.ipicker-search-inner input::placeholder{color:var(--tm);}
.ipicker-badge{font-family:'DM Mono',monospace;font-size:.64rem;font-weight:700;background:var(--gold-soft);color:var(--gold-dark);border:1px solid rgba(192,120,40,.22);border-radius:20px;padding:.18rem .55rem;white-space:nowrap;flex-shrink:0;}
.ipicker-list{max-height:320px;overflow-y:auto;}
.ipicker-list::-webkit-scrollbar{width:3px;}
.ipicker-list::-webkit-scrollbar-thumb{background:var(--bdr-md);border-radius:2px;}
.icat{border-bottom:1px solid var(--bdr);}
.icat:last-child{border-bottom:none;}
.icat-hdr{display:flex;align-items:center;gap:.5rem;padding:.5rem .875rem;background:linear-gradient(90deg,var(--s2) 0%,var(--s) 100%);position:sticky;top:0;z-index:2;border-bottom:1px solid var(--bdr);cursor:pointer;user-select:none;transition:background .15s;}
.icat-hdr:hover{background:var(--gold-soft);}
.icat-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.icat-label{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--t2);flex:1;}
.icat-rule{font-size:.58rem;font-weight:700;padding:.1rem .4rem;border-radius:4px;white-space:nowrap;}
.icat-rule.radio{background:var(--gold-soft);color:var(--gold-dark);border:1px solid rgba(192,120,40,.22);}
.icat-rule.check{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.2);}
.icat-chev{color:var(--tm);transition:transform .2s;flex-shrink:0;}
.icat.closed .icat-chev{transform:rotate(-90deg);}
.icat.closed .icat-items{display:none;}
.icat-items{display:flex;flex-direction:column;}
.iitem{display:flex;align-items:center;gap:.6rem;padding:.52rem .875rem;cursor:pointer;user-select:none;border-bottom:1px solid rgba(232,224,208,.6);transition:background .12s;position:relative;}
.iitem:last-child{border-bottom:none;}
.iitem:hover{background:rgba(192,120,40,.06);}
.iitem:has(input:checked){background:rgba(192,120,40,.1);}
.iitem:has(input:checked)::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold);border-radius:0 3px 3px 0;}
.iitem input{width:15px;height:15px;accent-color:var(--gold);flex-shrink:0;cursor:pointer;margin:0;}
.iitem-emoji{font-size:1rem;line-height:1;flex-shrink:0;width:22px;text-align:center;}
.iitem-name{font-size:.8rem;font-weight:500;color:var(--t1);flex:1;}
.iitem-price{font-family:'DM Mono',monospace;font-size:.67rem;font-weight:600;padding:.1rem .42rem;border-radius:4px;flex-shrink:0;}
.iitem-price.paid{color:var(--teal);background:var(--teal-soft);border:1px solid rgba(31,122,108,.18);}
.iitem-price.free{color:var(--tm);background:var(--s3);border:1px solid var(--bdr);}
.ipicker-empty{display:none;padding:1.5rem;text-align:center;font-size:.8rem;color:var(--tm);}
.ichips{min-height:36px;padding:.4rem .8rem;display:flex;align-items:flex-start;flex-wrap:wrap;gap:.28rem;border-top:1.5px solid var(--bdr);background:var(--s2);}
.ichip{display:inline-flex;align-items:center;gap:.22rem;padding:.18rem .52rem;border-radius:20px;font-size:.62rem;font-weight:600;color:var(--gold-dark);background:var(--gold-soft);border:1px solid rgba(192,120,40,.25);white-space:nowrap;}
.ichip-x{background:none;border:none;padding:0 0 0 1px;cursor:pointer;color:var(--gold-dark);font-size:.78rem;line-height:1;opacity:.55;display:inline-flex;align-items:center;transition:opacity .15s;}
.ichip-x:hover{opacity:1;}
.ichips-ph{font-size:.7rem;color:var(--tm);font-style:italic;padding:.1rem 0;}

/* DELETE MODAL */
.dbox{background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--rxl);width:100%;max-width:360px;box-shadow:0 24px 64px rgba(100,60,20,.22);overflow:hidden;position:relative;}
.dbox::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--rose),#E05560);}
.dbox.show{animation:slideUp .25s cubic-bezier(.34,1.2,.64,1) both;}
.dbody{padding:1.75rem 1.5rem;text-align:center;}
.dico{width:50px;height:50px;border-radius:13px;background:var(--rose-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--rose);margin-bottom:.875rem;}
.dtitle{font-family:'Plus Jakarta Sans',sans-serif;font-size:.98rem;font-weight:700;color:var(--espresso);margin-bottom:.4rem;}
.ddesc{font-size:.8rem;color:var(--tm);line-height:1.5;}
.dfoot{display:flex;gap:.75rem;padding:0 1.5rem 1.5rem;}
.dfoot .btn-cancel{flex:1;display:flex;align-items:center;justify-content:center;}
.btn-del-confirm{flex:1;height:36px;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:700;color:#fff;background:linear-gradient(135deg,var(--rose),#943048);border:none;border-radius:var(--r);cursor:pointer;}

.tc{position:fixed;bottom:1.5rem;right:1.5rem;z-index:3000;display:flex;flex-direction:column;gap:.5rem;pointer-events:none;}
.toast{display:flex;align-items:center;gap:.7rem;padding:.8rem 1.1rem;background:var(--espresso);color:#FDFAF5;border-radius:var(--rl);font-size:.82rem;font-weight:500;box-shadow:0 8px 32px rgba(40,20,0,.28);pointer-events:all;min-width:240px;}
.toast.ok{border-left:3px solid var(--teal);}.toast.err{border-left:3px solid var(--rose);}
@keyframes tIn{from{opacity:0;transform:translateX(18px)}to{opacity:1;transform:none}}
@keyframes tOut{to{opacity:0;transform:translateX(18px)}}

@media(max-width:768px){.prd-content{padding:1.25rem 1rem 0;}.frow{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')

@php
$fixedCatalog = [
    ['id'=>'shape_1','sec'=>'shape','name'=>'Round 6 inch','emoji'=>'🎂','price'=>350],
    ['id'=>'shape_2','sec'=>'shape','name'=>'Round 8 inch','emoji'=>'🎂','price'=>550],
    ['id'=>'shape_3','sec'=>'shape','name'=>'Round 10 inch','emoji'=>'🎂','price'=>800],
    ['id'=>'shape_4','sec'=>'shape','name'=>'Square','emoji'=>'🟫','price'=>650],
    ['id'=>'shape_5','sec'=>'shape','name'=>'Heart','emoji'=>'❤️','price'=>750],
    ['id'=>'shape_6','sec'=>'shape','name'=>'Two-tier Round','emoji'=>'🎂','price'=>1800],
    ['id'=>'flv_1','sec'=>'flavor','name'=>'Vanilla','emoji'=>'🍦','price'=>0],
    ['id'=>'flv_2','sec'=>'flavor','name'=>'Chocolate','emoji'=>'🍫','price'=>80],
    ['id'=>'flv_3','sec'=>'flavor','name'=>'Red Velvet','emoji'=>'🔴','price'=>100],
    ['id'=>'flv_4','sec'=>'flavor','name'=>'Strawberry','emoji'=>'🍓','price'=>120],
    ['id'=>'flv_5','sec'=>'flavor','name'=>'Ube','emoji'=>'🟣','price'=>130],
    ['id'=>'flv_6','sec'=>'flavor','name'=>'Mocha','emoji'=>'☕','price'=>100],
    ['id'=>'fro_1','sec'=>'frosting','name'=>'Smooth Buttercream','emoji'=>'🎨','price'=>0],
    ['id'=>'fro_2','sec'=>'frosting','name'=>'Textured Buttercream','emoji'=>'🖌️','price'=>150],
    ['id'=>'fro_3','sec'=>'frosting','name'=>'Fondant Smooth','emoji'=>'⬜','price'=>350],
    ['id'=>'fro_4','sec'=>'frosting','name'=>'Chocolate Ganache','emoji'=>'🍫','price'=>250],
    ['id'=>'fro_5','sec'=>'frosting','name'=>'Semi-naked Style','emoji'=>'🎂','price'=>200],
    ['id'=>'drp_1','sec'=>'drip','name'=>'Chocolate Drip','emoji'=>'🍫','price'=>180],
    ['id'=>'drp_2','sec'=>'drip','name'=>'White Chocolate Drip','emoji'=>'🤍','price'=>200],
    ['id'=>'drp_3','sec'=>'drip','name'=>'Caramel Drip','emoji'=>'🍯','price'=>180],
    ['id'=>'drp_4','sec'=>'drip','name'=>'Strawberry Drip','emoji'=>'🍓','price'=>200],
    ['id'=>'frt_1','sec'=>'fruit','name'=>'Strawberry','emoji'=>'🍓','price'=>120],
    ['id'=>'frt_2','sec'=>'fruit','name'=>'Blueberry','emoji'=>'🫐','price'=>180],
    ['id'=>'frt_3','sec'=>'fruit','name'=>'Raspberry','emoji'=>'🫐','price'=>220],
    ['id'=>'frt_4','sec'=>'fruit','name'=>'Cherry','emoji'=>'🍒','price'=>150],
    ['id'=>'frt_5','sec'=>'fruit','name'=>'Mango Slice','emoji'=>'🥭','price'=>100],
    ['id'=>'cho_1','sec'=>'choco','name'=>'Chocolate Bar Shard','emoji'=>'🍫','price'=>120],
    ['id'=>'cho_2','sec'=>'choco','name'=>'Ferrero-style Ball','emoji'=>'🟤','price'=>80],
    ['id'=>'cho_3','sec'=>'choco','name'=>'Chocolate Curls','emoji'=>'🌀','price'=>100],
    ['id'=>'cho_4','sec'=>'choco','name'=>'Kitkat Sticks','emoji'=>'🍬','price'=>90],
    ['id'=>'cho_5','sec'=>'choco','name'=>'Oreo Cookie','emoji'=>'⚫','price'=>60],
    ['id'=>'cho_6','sec'=>'choco','name'=>'Chocolate Plaque','emoji'=>'🟫','price'=>200],
    ['id'=>'spr_1','sec'=>'sprinkle','name'=>'Cylinder Sprinkles','emoji'=>'✨','price'=>50],
    ['id'=>'spr_2','sec'=>'sprinkle','name'=>'Sphere Sprinkles','emoji'=>'🔮','price'=>50],
    ['id'=>'cdl_1','sec'=>'candle','name'=>'Number Candles (0–9)','emoji'=>'🔢','price'=>35],
    ['id'=>'cdl_2','sec'=>'candle','name'=>'Happy Birthday Topper','emoji'=>'🎉','price'=>80],
    ['id'=>'cdl_3','sec'=>'candle','name'=>'Name Plaque','emoji'=>'📛','price'=>150],
    ['id'=>'cdl_4','sec'=>'candle','name'=>'Crown Topper','emoji'=>'👑','price'=>120],
    ['id'=>'cdl_5','sec'=>'candle','name'=>'Heart Topper','emoji'=>'❤️','price'=>100],
    ['id'=>'dec_1','sec'=>'deco','name'=>'Buttercream Swirls','emoji'=>'🌀','price'=>150],
    ['id'=>'dec_2','sec'=>'deco','name'=>'Rosettes','emoji'=>'🌹','price'=>180],
    ['id'=>'dec_3','sec'=>'deco','name'=>'Macarons','emoji'=>'🟡','price'=>65],
    ['id'=>'dec_4','sec'=>'deco','name'=>'Meringue Drops','emoji'=>'⚪','price'=>120],
    ['id'=>'dec_5','sec'=>'deco','name'=>'Ribbon Wrap','emoji'=>'🎀','price'=>80],
    ['id'=>'dec_6','sec'=>'deco','name'=>'Edible Pearls','emoji'=>'🫧','price'=>100],
];
$sections=['shape'=>['label'=>'Cake Shape','color'=>'#C07828','rule'=>'radio','note'=>'Pick one'],'flavor'=>['label'=>'Flavor','color'=>'#B43840','rule'=>'checkbox','note'=>'Multi-select'],'frosting'=>['label'=>'Frosting Style','color'=>'#885404','rule'=>'checkbox','note'=>'Multi-select'],'drip'=>['label'=>'Drip','color'=>'#C07828','rule'=>'checkbox','note'=>'Optional'],'fruit'=>['label'=>'Fruits','color'=>'#1F7A6C','rule'=>'checkbox','note'=>'Optional'],'choco'=>['label'=>'Chocolate Decor','color'=>'#6A4824','rule'=>'checkbox','note'=>'Optional'],'sprinkle'=>['label'=>'Sprinkles','color'=>'#A45224','rule'=>'checkbox','note'=>'Optional'],'candle'=>['label'=>'Candles & Toppers','color'=>'#B47224','rule'=>'checkbox','note'=>'Optional'],'deco'=>['label'=>'Decorative Elements','color'=>'#1F6058','rule'=>'checkbox','note'=>'Optional']];
$byId=collect($fixedCatalog)->keyBy('id');
$grouped=collect($fixedCatalog)->groupBy('sec');
@endphp

<div class="page">
    <div class="prd-hero">
        <div class="prd-hero-left">
            <div class="prd-hero-pill"><span class="prd-hero-dot"></span> Product Management</div>
            <div class="prd-hero-title"><em>Products</em> & Cakes</div>
            <div class="prd-hero-sub">Build products by combining ingredients from the fixed catalog</div>
        </div>
        <div class="prd-hero-right">
            <div class="sbar">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Search products…" oninput="filterCards(this.value)">
            </div>
            <button class="btn-add" id="btnAdd">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </button>
        </div>
    </div>

    <div class="prd-content">
        @if(session('success'))
        <div class="alert-ok" id="sa">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
            <button onclick="this.parentElement.remove()">×</button>
        </div>
        @endif

        <div class="pgrid" id="pgrid">
            @forelse($products as $product)
            @php
                $raw=$product->ingredient_ids;
                $ids=is_array($raw)?$raw:(json_decode($raw??'[]',true)??[]);
                $items=$byId->only($ids)->values();
                $shown=$items->take(6);
                $extra=max(0,$items->count()-6);
                $editData=json_encode(['id'=>$product->id,'name'=>$product->name,'description'=>$product->description,'base_price'=>$product->base_price,'is_active'=>$product->is_active,'ingredient_ids'=>$ids]);
            @endphp
            <div class="pcard" data-name="{{ strtolower($product->name) }}">
                <div class="pcard-vis">
                    @if($items->count())
                        <div class="pcard-emojis">@foreach($shown as $it)<span class="pcard-emoji" title="{{ $it['name'] }}">{{ $it['emoji'] }}</span>@endforeach</div>
                        <span class="pcard-ing-count">{{ $items->count() }} ingredient{{ $items->count()!=1?'s':'' }}</span>
                    @else
                        <div class="pcard-empty-vis"><svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg></div>
                    @endif
                </div>
                <div class="pcard-body">
                    <div class="pcard-name">{{ $product->name }}</div>
                    <div class="pcard-desc">{{ $product->description ?: 'No description provided.' }}</div>
                    <div class="pcard-price">₱{{ number_format($product->base_price,2) }}</div>
                    <div class="itags">
                        @forelse($shown as $it)
                            <span class="itag">{{ $it['emoji'] }} {{ Str::limit($it['name'],14) }}</span>
                        @empty
                            <span class="itag-none">No ingredients linked</span>
                        @endforelse
                        @if($extra)<span class="itag itag-more">+{{ $extra }} more</span>@endif
                    </div>
                </div>
                <div class="pcard-foot">
                    <span class="pill {{ $product->is_active ? 'on' : 'off' }}">{{ $product->is_active ? 'Available' : 'Unavailable' }}</span>
                    <div class="foot-btns">
                        <button class="bsm bsm-edit" data-product="{{ $editData }}" onclick="openEdit(JSON.parse(this.dataset.product))">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit
                        </button>
                        <button class="bsm bsm-del" onclick="openDel({{ $product->id }},'{{ addslashes($product->name) }}')">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg> Delete
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-st">
                <div class="empty-orb"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
                <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;margin-bottom:.3rem;color:var(--espresso);">No products yet</h3>
                <p style="color:var(--tm);font-size:.8rem;">Click "Add Product" to get started.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<form id="delForm" method="POST" style="display:none">@csrf @method('DELETE')</form>
<div class="tc" id="tc"></div>
<div class="mbackdrop" id="backdrop"></div>

<!-- PRODUCT MODAL -->
<div class="mwrap" id="prodModal">
    <div class="mbox" id="prodMbox" onclick="event.stopPropagation()">
        <form id="prodForm" method="POST" action="{{ route('products.store') }}">
            @csrf
            <input type="hidden" name="_method" id="fMethod" value="POST">
            <input type="hidden" name="ingredient_ids" id="fIngIds" value="[]">
            <div class="mhd">
                <div class="mhd-l">
                    <div class="mhd-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
                    <div><div class="mhd-title" id="mTitle">Add Product</div><div class="mhd-sub" id="mSub">Fill in details then link ingredients below</div></div>
                </div>
                <button type="button" class="mclose" onclick="closeModal()">×</button>
            </div>
            <div class="mbody">
                <div class="fg"><label>Product Name</label><input class="fi" type="text" name="name" id="fName" placeholder="e.g. Classic Chocolate Birthday Cake" required></div>
                <div class="fg"><label>Description</label><textarea class="fi" name="description" id="fDesc" placeholder="Describe this product…"></textarea></div>
                <div class="frow">
                    <div class="fg"><label>Base Price (₱)</label><input class="fi" type="number" name="base_price" id="fPrice" min="0" step="0.01" placeholder="0.00" required></div>
                    <div class="fg" style="display:flex;flex-direction:column;justify-content:flex-end;">
                        <div class="tog-card">
                            <span style="font-size:.82rem;font-weight:600;color:var(--t1);">Available to order</span>
                            <label class="tsw"><input type="checkbox" name="is_active" id="fActive" value="1" checked><span class="ttr"></span></label>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flbl" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                        <span>Linked Ingredients</span>
                        <span class="ipicker-badge" id="iBadge">0 selected</span>
                    </div>
                    <div class="ipicker">
                        <div class="ipicker-search">
                            <div class="ipicker-search-inner">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input type="text" id="iSearch" placeholder="Search ingredients…" oninput="iFilter(this.value)">
                            </div>
                        </div>
                        <div class="ipicker-list" id="iList">
                            <div class="ipicker-empty" id="iEmpty">No ingredients match your search.</div>
                            @foreach($sections as $sk=>$sm)
                            <div class="icat" id="icat_{{ $sk }}" data-sec="{{ $sk }}">
                                <div class="icat-hdr" onclick="iToggleCat('{{ $sk }}')">
                                    <span class="icat-dot" style="background:{{ $sm['color'] }}"></span>
                                    <span class="icat-label">{{ $sm['label'] }}</span>
                                    <span class="icat-rule {{ $sm['rule'] }}">{{ $sm['rule']==='radio'?'🔘 Pick one':'☑ Multi-select' }}</span>
                                    <svg class="icat-chev" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                                </div>
                                <div class="icat-items">
                                    @foreach($grouped->get($sk,collect()) as $item)
                                    <label class="iitem" data-id="{{ $item['id'] }}" data-name="{{ strtolower($item['name']) }}" data-sec="{{ $sk }}">
                                        @if($sm['rule']==='radio')
                                            <input type="radio" name="radio_{{ $sk }}" value="{{ $item['id'] }}" data-emoji="{{ $item['emoji'] }}" data-label="{{ $item['name'] }}" data-sec="{{ $sk }}" onchange="onRadio(this)">
                                        @else
                                            <input type="checkbox" value="{{ $item['id'] }}" data-emoji="{{ $item['emoji'] }}" data-label="{{ $item['name'] }}" data-sec="{{ $sk }}" onchange="onCheck(this)">
                                        @endif
                                        <span class="iitem-emoji">{{ $item['emoji'] }}</span>
                                        <span class="iitem-name">{{ $item['name'] }}</span>
                                        @if($item['price']===0)<span class="iitem-price free">Included</span>@else<span class="iitem-price paid">+₱{{ number_format($item['price']) }}</span>@endif
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="ichips" id="iChips"><span class="ichips-ph" id="iChipsPh">No ingredients selected yet</span></div>
                    </div>
                    <p style="font-size:.66rem;color:var(--tm);margin-top:.35rem;"><strong>Cake Shape</strong> allows only one selection. All other categories allow multiple.</p>
                </div>
            </div>
            <div class="mfoot">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-save" id="btnSave">Add Product</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="mwrap" id="delModal">
    <div class="dbox" id="dbox" onclick="event.stopPropagation()">
        <div class="dbody">
            <div class="dico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg></div>
            <div class="dtitle">Delete Product?</div>
            <div class="ddesc">Permanently delete <strong id="dName"></strong>? This cannot be undone.</div>
        </div>
        <div class="dfoot">
            <button type="button" class="btn-cancel" onclick="closeDel()">Keep it</button>
            <button type="button" class="btn-del-confirm" onclick="doDelete()">Delete</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let SM={},DID=null;
function onRadio(input){Object.keys(SM).forEach(k=>{if(SM[k].sec===input.dataset.sec)delete SM[k];});SM[input.value]={emoji:input.dataset.emoji,label:input.dataset.label,sec:input.dataset.sec};renderState();}
function onCheck(input){if(input.checked){SM[input.value]={emoji:input.dataset.emoji,label:input.dataset.label,sec:input.dataset.sec};}else{delete SM[input.value];}renderState();}
function iRemove(id){delete SM[id];const inp=document.querySelector(`#iList input[value="${CSS.escape(id)}"]`);if(inp)inp.checked=false;renderState();}
function renderState(){const ids=Object.keys(SM);document.getElementById('fIngIds').value=JSON.stringify(ids);document.getElementById('iBadge').textContent=ids.length+' selected';const wrap=document.getElementById('iChips');const ph=document.getElementById('iChipsPh');wrap.querySelectorAll('.ichip').forEach(c=>c.remove());if(ids.length===0){ph.style.display='';}else{ph.style.display='none';ids.forEach(id=>{const m=SM[id];if(!m)return;const c=document.createElement('span');c.className='ichip';c.innerHTML=`<span>${m.emoji}</span><span>${m.label}</span><button type="button" class="ichip-x" onclick="iRemove('${id}')">×</button>`;wrap.appendChild(c);});}}
function iFilter(q){q=q.toLowerCase().trim();document.querySelectorAll('.icat').forEach(c=>c.classList.remove('closed'));let any=false;document.querySelectorAll('.icat').forEach(cat=>{let catHas=false;cat.querySelectorAll('.iitem').forEach(item=>{const match=!q||item.dataset.name.includes(q);item.style.display=match?'':'none';if(match)catHas=true;});cat.style.display=catHas?'':'none';if(catHas)any=true;});document.getElementById('iEmpty').style.display=any?'none':'block';}
function iToggleCat(sk){document.getElementById('icat_'+sk).classList.toggle('closed');}
function showModal(){document.getElementById('backdrop').classList.add('show');document.getElementById('prodModal').classList.add('show');document.getElementById('prodMbox').classList.add('show');document.body.style.overflow='hidden';setTimeout(()=>document.getElementById('fName').focus(),180);}
function closeModal(){['backdrop','prodModal','prodMbox','delModal','dbox'].forEach(id=>document.getElementById(id).classList.remove('show'));document.body.style.overflow='';}
function resetModal(){document.getElementById('mTitle').textContent='Add Product';document.getElementById('mSub').textContent='Fill in details then link ingredients below';document.getElementById('prodForm').action='{{ route("products.store") }}';document.getElementById('fMethod').value='POST';document.getElementById('btnSave').textContent='Add Product';document.getElementById('fName').value='';document.getElementById('fDesc').value='';document.getElementById('fPrice').value='';document.getElementById('fActive').checked=true;document.getElementById('iSearch').value='';document.getElementById('iEmpty').style.display='none';SM={};document.querySelectorAll('#iList input').forEach(i=>i.checked=false);document.querySelectorAll('.icat').forEach(c=>{c.classList.remove('closed');c.style.display='';});document.querySelectorAll('.iitem').forEach(i=>i.style.display='');renderState();}
document.getElementById('btnAdd').addEventListener('click',()=>{resetModal();showModal();});
document.getElementById('backdrop').addEventListener('click',closeModal);
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal();});
function openEdit(p){resetModal();document.getElementById('mTitle').textContent='Edit Product';document.getElementById('mSub').textContent='Update details and ingredient links';document.getElementById('prodForm').action='/products/'+p.id;document.getElementById('fMethod').value='PUT';document.getElementById('btnSave').textContent='Save Changes';document.getElementById('fName').value=p.name;document.getElementById('fDesc').value=p.description||'';document.getElementById('fPrice').value=p.base_price;document.getElementById('fActive').checked=p.is_active==1;(p.ingredient_ids||[]).forEach(id=>{const inp=document.querySelector(`#iList input[value="${CSS.escape(id)}"]`);if(!inp)return;inp.checked=true;SM[id]={emoji:inp.dataset.emoji,label:inp.dataset.label,sec:inp.dataset.sec};});renderState();showModal();}
function filterCards(q){q=q.toLowerCase().trim();document.querySelectorAll('#pgrid .pcard').forEach(c=>{c.style.display=(!q||c.dataset.name.includes(q))?'':'none';});}
function openDel(id,name){DID=id;document.getElementById('dName').textContent='"'+name+'"';document.getElementById('backdrop').classList.add('show');document.getElementById('delModal').classList.add('show');document.getElementById('dbox').classList.add('show');document.body.style.overflow='hidden';}
function closeDel(){document.getElementById('backdrop').classList.remove('show');document.getElementById('delModal').classList.remove('show');document.getElementById('dbox').classList.remove('show');document.body.style.overflow='';DID=null;}
function doDelete(){if(!DID)return;document.getElementById('delForm').action='/products/'+DID;document.getElementById('delForm').submit();}
function toast(msg,type='ok'){const c=document.getElementById('tc');const t=document.createElement('div');t.className='toast '+type;t.style.animation='tIn .3s ease';t.innerHTML='<span>'+msg+'</span>';c.appendChild(t);setTimeout(()=>{t.style.animation='tOut .3s ease forwards';setTimeout(()=>t.remove(),300);},3500);}
@if(session('success'))document.addEventListener('DOMContentLoaded',()=>toast('{{ session("success") }}','ok'));@endif
@if(session('error'))document.addEventListener('DOMContentLoaded',()=>toast('{{ session("error") }}','err'));@endif
document.addEventListener('DOMContentLoaded',()=>{document.querySelectorAll('.pcard').forEach((c,i)=>{c.style.cssText+='opacity:0;transform:translateY(12px);';setTimeout(()=>{c.style.transition='opacity .32s ease,transform .32s cubic-bezier(.22,1,.36,1),border-color .2s,box-shadow .2s';c.style.opacity='1';c.style.transform='';},50+i*50);});});
</script>
@endpush

@endsection