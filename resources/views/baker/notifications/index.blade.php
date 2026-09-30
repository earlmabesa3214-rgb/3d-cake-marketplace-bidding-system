@extends('layouts.baker')
@section('title', 'Notifications')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* Notifications: same cake-atelier ledger language as Bids, Orders, Wallet and Earnings. Plus Jakarta Sans only. */
.notif-page{
--esp:#24150F;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;--sage-d:#33502F;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.notif-page *{box-sizing:border-box;font-family:inherit}
.notif-page svg{flex-shrink:0}
.notif-page a:focus-visible,.notif-page button:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes nt-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes nt-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@media(prefers-reduced-motion:reduce){.notif-page *,.notif-page *::before,.notif-page *::after{animation:none!important;transition:none!important}}

/* header */
.nt-header{position:relative;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;margin:0 0 2rem;padding-bottom:1.75rem;animation:nt-fadeUp .6s var(--e) backwards}
.nt-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.nt-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:nt-line .9s var(--e) .3s backwards}
.nt-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.nt-sub{margin:1rem 0 0;max-width:56ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* buttons: clearly bordered and labeled */
.nt-btn{display:inline-flex;align-items:center;justify-content:center;gap:.45rem;height:36px;padding:0 .95rem;background:var(--w);border:1px solid var(--esp);border-radius:0;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);white-space:nowrap;cursor:pointer;transition:background .25s,color .25s,border-color .25s}
.nt-btn:hover{background:var(--esp);color:var(--gold-l)}
.nt-btn.primary{height:42px;padding:0 1.3rem;background:var(--esp);color:var(--ivory)}
.nt-btn.primary:hover{background:var(--gold);border-color:var(--gold);color:var(--esp)}
.nt-btn.danger{border-color:var(--burg);color:var(--burg)}
.nt-btn.danger:hover{background:var(--burg);border-color:var(--burg);color:var(--ivory)}

/* list */
.nt-list{border-top:1px solid var(--esp);animation:nt-fadeUp .6s var(--e) .15s backwards}
.nt-item{position:relative;display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:1.25rem;padding:1.25rem 1.25rem 1.25rem 1.5rem;border-bottom:1px solid var(--line);color:inherit;text-decoration:none;animation:nt-fadeUp .5s var(--e) backwards;transition:background .3s}
.nt-item:hover{background:rgba(239,230,215,.5)}
.nt-item.unread{background:#F8F1E2}
.nt-item.unread:hover{background:#F3EAD3}
.nt-item.unread::before{content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold)}

/* icon tile */
.nt-icon{width:42px;height:42px;display:flex;align-items:center;justify-content:center;border:1px solid var(--beige);background:var(--cream);color:var(--mocha)}
.nt-icon.bid,.nt-icon.order,.nt-icon.payment{background:#F3EAD3;border-color:var(--gold-line);color:var(--credit)}
.nt-icon.warning{background:#F6E9D2;border-color:rgba(169,111,66,.4);color:var(--caramel)}
.nt-icon.error{background:#F6ECEA;border-color:rgba(84,37,44,.28);color:var(--burg)}
.nt-icon.success{background:#EFF2E8;border-color:rgba(94,127,90,.35);color:var(--sage-d)}
.nt-icon.info{background:var(--cream);border-color:var(--beige);color:var(--mocha)}

/* body */
.nt-body{min-width:0}
.nt-title-row{display:flex;align-items:center;flex-wrap:wrap;gap:.6rem}
.nt-item-title{font-size:.98rem;font-weight:800;letter-spacing:-.02em;line-height:1.3;color:var(--esp)}
.nt-new{display:inline-flex;align-items:center;padding:.22rem .5rem;background:var(--esp);color:var(--gold-l);font-size:.52rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase}
.nt-link{display:inline-flex;align-items:center;gap:.35rem;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--caramel);text-decoration:none;border-bottom:1px solid var(--gold-line);padding-bottom:1px;transition:color .3s,border-color .3s}
.nt-link:hover{color:var(--esp);border-color:var(--esp);text-decoration:none}
.nt-message{margin-top:.35rem;max-width:90ch;font-size:.86rem;line-height:1.6;color:var(--mocha);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

/* meta + actions */
.nt-meta{display:flex;flex-direction:column;align-items:flex-end;gap:.7rem}
.nt-time{display:inline-flex;align-items:center;gap:.5rem;font-size:.74rem;font-weight:600;color:var(--taupe);white-space:nowrap}
.nt-dot{width:7px;height:7px;background:var(--gold);transform:rotate(45deg);flex-shrink:0}
.nt-actions{display:flex;align-items:center;gap:.5rem}
.nt-actions form{margin:0}

/* empty */
.nt-empty{padding:4.5rem 1rem;text-align:center;border-bottom:1px solid var(--line)}
.nt-empty svg{color:var(--gold);opacity:.75;margin-bottom:1.1rem}
.nt-empty h3{margin:0 0 .7rem;font-size:clamp(1.5rem,3vw,2.2rem);font-weight:900;letter-spacing:-.04em;line-height:1}
.nt-empty p{margin:0 auto;max-width:48ch;font-size:.92rem;color:var(--mocha)}

/* pagination: covers the bootstrap-style and the default Laravel views */
.nt-pager{margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid var(--esp)}
.nt-pager nav{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:.75rem}
.nt-pager ul,.nt-pager .pagination{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:.3rem;list-style:none;margin:0;padding:0}
.nt-pager li{list-style:none;margin:0;padding:0}
.nt-pager li::marker{content:""}
.nt-pager a,.nt-pager li>span,.nt-pager .page-link,.nt-pager nav span[aria-current] span,.nt-pager nav span[aria-disabled] span{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;padding:0 .8rem;background:var(--w);border:1px solid var(--beige);border-radius:0;font-size:.82rem;font-weight:800;color:var(--esp);text-decoration:none;transition:background .25s,color .25s,border-color .25s}
.nt-pager a:hover,.nt-pager .page-link:hover{background:var(--esp);border-color:var(--esp);color:var(--gold-l);text-decoration:none}
.nt-pager li.active>span,.nt-pager li.active>a,.nt-pager .page-item.active .page-link,.nt-pager li>span[aria-current="page"],.nt-pager nav span[aria-current] span{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.nt-pager li.disabled>span,.nt-pager .page-item.disabled .page-link,.nt-pager nav span[aria-disabled] span{opacity:.4;background:transparent;cursor:default}
.nt-pager nav svg{width:14px;height:14px}
.nt-pager nav p{margin:0;font-size:.6rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe)}
.nt-pager nav>div:first-child{display:none}
.nt-pager nav>div:last-child{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:1rem}
.nt-pager nav>div:last-child>div>span{display:inline-flex;gap:.3rem}

/* responsive */
@media(max-width:720px){
    .nt-item{grid-template-columns:auto minmax(0,1fr);row-gap:.9rem;padding:1.1rem 1rem 1.1rem 1.25rem}
    .nt-meta{grid-column:1 / -1;flex-direction:row;align-items:center;justify-content:space-between;flex-wrap:wrap}
    .nt-icon{width:38px;height:38px}
}
</style>
@endpush

@section('content')

@php
    // ── SVG icon set (replaces the emoji icon; chosen by notification type) ──
    $ntSvg = fn ($paths) => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">'.$paths.'</svg>';
    $ntIcons = [
        'bid'     => $ntSvg('<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M2 13h20"/>'),
        'order'   => $ntSvg('<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>'),
        'payment' => $ntSvg('<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>'),
        'warning' => $ntSvg('<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>'),
        'error'   => $ntSvg('<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'),
        'success' => $ntSvg('<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'),
        'info'    => $ntSvg('<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>'),
        'default' => $ntSvg('<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>'),
    ];
    $icoCheck = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
    $icoCheckAll = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>';
    $icoTrash = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>';
    $icoArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
    $icoBellLg = '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>';
@endphp

<div class="notif-page">
    <div class="nt-header">
        <div>
            <h1 class="nt-title">Notifications</h1>
            <p class="nt-sub">Stay updated on your orders, bids, and payments</p>
        </div>
        @if($notifications->whereNull('read_at')->count() > 0)
        <form method="POST" action="{{ route('baker.notifications.read-all') }}">
            @csrf
            <button type="submit" class="nt-btn primary">{!! $icoCheckAll !!} Mark all as read</button>
        </form>
        @endif
    </div>

    <div class="nt-list">
        @forelse($notifications as $notif)
        @php
            $data     = is_array($notif->data) ? $notif->data : (json_decode($notif->data, true) ?? []);
            $title    = $data['title']      ?? $data['subject']    ?? 'Notification';
            $message  = $data['message']    ?? $data['body']       ?? $data['line'] ?? '';
            $icon     = $data['icon']       ?? '🔔';
            $type     = $data['type']       ?? 'default';
            $link     = $data['url']        ?? $data['action_url'] ?? null;
            $isUnread = is_null($notif->read_at);
            $typeKey  = array_key_exists($type, $ntIcons) ? $type : 'default';
        @endphp
        <div class="nt-item {{ $isUnread ? 'unread' : '' }}" style="animation-delay: {{ min($loop->index, 12) * 0.05 + 0.25 }}s;">
            <div class="nt-icon {{ $type }}">{!! $ntIcons[$typeKey] !!}</div>
            <div class="nt-body">
                <div class="nt-title-row">
                    <span class="nt-item-title">{{ $title }}</span>
                    @if($isUnread)<span class="nt-new">New</span>@endif
                    @if($link)
                        <a href="{{ $link }}" class="nt-link">View {!! $icoArrow !!}</a>
                    @endif
                </div>
                <div class="nt-message">{{ $message }}</div>
            </div>
            <div class="nt-meta">
                <span class="nt-time">
                    @if($isUnread)<span class="nt-dot" title="Unread"></span>@endif
                    {{ $notif->created_at->diffForHumans() }}
                </span>
                <div class="nt-actions">
                    @if($isUnread)
                        <form method="POST" action="{{ route('baker.notifications.read', $notif->id) }}">
                            @csrf
                            <button type="submit" class="nt-btn" title="Mark as read">{!! $icoCheck !!} Mark read</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('baker.notifications.destroy', $notif->id) }}"
                          onsubmit="return confirm('Delete this notification?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="nt-btn danger" title="Delete">{!! $icoTrash !!} Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="nt-empty">
            {!! $icoBellLg !!}
            <h3>No notifications yet</h3>
            <p>You'll be notified when customers accept your bids, orders progress, and payments arrive.</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="nt-pager">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection