{{--
    Floating Chat Bubble v3 — ZERO onclick attributes.
    All events wired via addEventListener inside DOMContentLoaded.

    @include('partials.order-chat-bubble', ['order' => $order])
--}}
@php
    $me           = auth()->user();
    $messages     = $order->messages ?? collect();
    $otherUser    = ($order->baker_id === $me->id)
                      ? $order->cakeRequest->user
                      : $order->baker;
    $otherName    = $otherUser->name ?? ($otherUser->first_name . ' ' . $otherUser->last_name);
    $otherInitial = strtoupper(substr($otherUser->name ?? $otherUser->first_name ?? '?', 0, 1));
    $isBaker      = ($order->baker_id === $me->id);
    $theirRole    = $isBaker ? 'Customer' : 'Your Baker';
    $unreadCount  = $messages->filter(fn($m) => $m->sender_id !== $me->id && is_null($m->read_at))->count();
    $isArchived   = in_array($order->status ?? '', ['COMPLETED', 'CANCELLED', 'DELIVERED']);
    $lastMsgId    = $messages->last()?->id ?? 0;
    $statusShort  = \Illuminate\Support\Str::limit(str_replace('_', ' ', $order->status ?? ''), 15);
@endphp

{{-- ── BUBBLE BUTTON ── --}}
<button class="ocb-btn" id="ocbBtn" aria-label="Open chat">
    <svg class="ocb-ic-chat" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
    <svg class="ocb-ic-close" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
    <span class="ocb-badge" id="ocbBadge" @if($unreadCount < 1) style="display:none" @endif>
        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
    </span>
</button>

{{-- ── PANEL ── --}}
<div class="ocp" id="ocpPanel" aria-hidden="true">

    {{-- HEADER --}}
    <div class="ocp-hdr">
        <div class="ocp-hdr-left">
            <div class="ocp-hdr-av">{{ $otherInitial }}</div>
            <div class="ocp-hdr-info">
                <div class="ocp-hdr-name">{{ $otherName }}</div>
                <div class="ocp-hdr-meta">
                    <span class="ocp-hdr-role">{{ $theirRole }}</span>
                    <span class="ocp-hdr-ref">&nbsp;· #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
        <div class="ocp-hdr-right">
            <span class="ocp-hdr-status {{ $isArchived ? 'is-archived' : 'is-live' }}">
                @if(!$isArchived)<i class="ocp-hdr-dot"></i>@endif{{ $statusShort }}
            </span>
            <button class="ocp-hdr-close" id="ocpCloseBtn" aria-label="Close chat">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div class="ocp-body" id="ocpBody">
        @if($messages->isNotEmpty())
        <div class="ocp-datesep"><span>{{ $messages->first()->created_at->format('M d, Y') }}</span></div>
        @endif

        @forelse($messages as $i => $msg)
            @php
                $mine   = $msg->sender_id === $me->id;
                $prev   = $i > 0 ? $messages[$i - 1] : null;
                $newDay = $prev && $msg->created_at->format('Ymd') !== $prev->created_at->format('Ymd');
            @endphp
            @if($newDay)
            <div class="ocp-datesep"><span>{{ $msg->created_at->format('M d, Y') }}</span></div>
            @endif
            <div class="ocm {{ $mine ? 'ocm-mine' : 'ocm-theirs' }}" data-id="{{ $msg->id }}">
                @if(!$mine)<div class="ocm-av">{{ $otherInitial }}</div>@endif
                <div class="ocm-bub {{ $mine ? 'ocm-bub-mine' : 'ocm-bub-theirs' }}">
                    @if(!empty($msg->image_path))
                    <a href="{{ asset('storage/'.$msg->image_path) }}" target="_blank" class="ocm-imglink">
                        <img src="{{ asset('storage/'.$msg->image_path) }}" class="ocm-img" alt="Image" loading="lazy">
                    </a>
                    @endif
                    @if(!empty($msg->body))
                    <div class="ocm-txt">{{ $msg->body }}</div>
                    @endif
                    <div class="ocm-time">
                        {{ $msg->created_at->format('g:i A') }}
                        @if($mine && $msg->read_at)<span class="ocm-seen">· Seen</span>@endif
                    </div>
                </div>
            </div>
        @empty
            <div class="ocp-empty">
                <div class="ocp-empty-ico">💬</div>
                <div class="ocp-empty-ttl">Start the conversation</div>
                <div class="ocp-empty-sub">Send a message or photo about this order.</div>
            </div>
        @endforelse
        <div id="ocpAnchor"></div>
    </div>

    {{-- IMAGE PREVIEW --}}
    <div class="ocp-preview" id="ocpPreview" style="display:none">
        <img id="ocpPreviewImg" src="" alt="">
        <div class="ocp-preview-info">
            <span id="ocpPreviewName" class="ocp-preview-name"></span>
            <button type="button" id="ocpPreviewRm" class="ocp-preview-rm" aria-label="Remove image">✕</button>
        </div>
    </div>

    {{-- INPUT --}}
    @if(!$isArchived)
    <form class="ocp-form" id="ocpForm" method="POST"
          action="{{ route('order.messages.store', $order->id) }}"
          enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="ocpFileIn" accept="image/*" style="display:none">
        <button type="button" id="ocpAttach" class="ocp-attach" title="Attach image">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
            </svg>
        </button>
        <input type="text" name="body" id="ocpInput" class="ocp-input"
               placeholder="Message {{ \Illuminate\Support\Str::limit($otherName, 16) }}…"
               autocomplete="off" maxlength="2000">
        <button type="submit" id="ocpSend" class="ocp-send" aria-label="Send">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </form>
    @else
    <div class="ocp-archived">
        Conversation archived · {{ str_replace('_', ' ', $order->status ?? '') }}
    </div>
    @endif

</div>{{-- /panel --}}


<style>
.ocb-btn {
    position:fixed; bottom:1.75rem; right:1.75rem; z-index:8900;
    width:54px; height:54px; border-radius:50%; border:none; cursor:pointer; outline:none;
    background:linear-gradient(135deg,#C8893A,#E8A94A); color:white;
    box-shadow:0 4px 18px rgba(200,137,58,.5),0 2px 6px rgba(0,0,0,.12);
    display:flex; align-items:center; justify-content:center;
    transition:transform .3s cubic-bezier(.34,1.56,.64,1),box-shadow .2s;
}
.ocb-btn:hover  { transform:scale(1.09); box-shadow:0 6px 22px rgba(200,137,58,.6); }
.ocb-btn:active { transform:scale(.93); }

.ocb-ic-chat,.ocb-ic-close {
    position:absolute;
    transition:opacity .18s,transform .24s cubic-bezier(.34,1.56,.64,1);
}
.ocb-ic-chat  { opacity:1; transform:scale(1) rotate(0deg); }
.ocb-ic-close { opacity:0; transform:scale(.4) rotate(-90deg); }
.ocb-btn.open .ocb-ic-chat  { opacity:0; transform:scale(.4) rotate(90deg); }
.ocb-btn.open .ocb-ic-close { opacity:1; transform:scale(1) rotate(0deg); }

.ocb-badge {
    position:absolute; top:-3px; right:-3px;
    min-width:18px; height:18px; padding:0 4px; border-radius:9px;
    background:#E53E3E; color:white; font-size:.6rem; font-weight:700;
    display:flex; align-items:center; justify-content:center;
    border:2px solid white;
}

.ocp {
    position:fixed; bottom:5rem; right:1.75rem; z-index:8800;
    width:340px; max-height:490px;
    display:flex; flex-direction:column;
    border-radius:18px; overflow:hidden;
    background:#FAFAF7; border:1px solid #E8DDD0;
    box-shadow:0 16px 48px rgba(59,31,15,.18),0 4px 16px rgba(0,0,0,.1);
    opacity:0; transform:translateY(14px) scale(.96);
    pointer-events:none; transform-origin:bottom right;
    transition:opacity .25s ease,transform .3s cubic-bezier(.34,1.56,.64,1);
}
.ocp.open { opacity:1; transform:translateY(0) scale(1); pointer-events:all; }

.ocp-hdr {
    background:linear-gradient(135deg,#3B1F0F,#7A4A28);
    padding:.65rem .75rem .65rem .9rem;
    display:flex; align-items:center; justify-content:space-between; gap:.5rem;
    flex-shrink:0;
}
.ocp-hdr-left { display:flex; align-items:center; gap:.55rem; min-width:0; flex:1; }
.ocp-hdr-av {
    width:32px; height:32px; border-radius:50%;
    background:rgba(255,255,255,.18); border:1.5px solid rgba(255,255,255,.22);
    color:white; font-weight:700; font-size:.78rem;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.ocp-hdr-info { min-width:0; }
.ocp-hdr-name {
    font-weight:700; font-size:.82rem; color:white;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:140px;
}
.ocp-hdr-meta { display:flex; align-items:center; margin-top:.1rem; }
.ocp-hdr-role {
    font-size:.56rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
    background:rgba(255,255,255,.14); color:rgba(255,255,255,.82);
    padding:.1rem .38rem; border-radius:3px; white-space:nowrap;
}
.ocp-hdr-ref { font-size:.58rem; color:rgba(255,255,255,.32); white-space:nowrap; }

.ocp-hdr-right { display:flex; flex-direction:column; align-items:flex-end; gap:.22rem; flex-shrink:0; }
.ocp-hdr-status {
    font-size:.56rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em;
    padding:.14rem .42rem; border-radius:4px;
    display:flex; align-items:center; gap:.28rem;
    white-space:nowrap; max-width:115px; overflow:hidden; text-overflow:ellipsis;
}
.ocp-hdr-status.is-live     { background:rgba(232,169,74,.2); color:#E8A94A; border:1px solid rgba(232,169,74,.26); }
.ocp-hdr-status.is-archived { background:rgba(255,255,255,.07); color:rgba(255,255,255,.36); border:1px solid rgba(255,255,255,.1); }
.ocp-hdr-dot {
    width:5px; height:5px; border-radius:50%; background:#E8A94A; flex-shrink:0;
    animation:ocpDot 1.8s ease-in-out infinite; display:inline-block;
}
@keyframes ocpDot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.3;transform:scale(.6)}}
.ocp-hdr-close {
    width:22px; height:22px; border-radius:50%;
    background:rgba(255,255,255,.09); border:none;
    color:rgba(255,255,255,.55); cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    transition:background .15s,color .15s;
}
.ocp-hdr-close:hover { background:rgba(255,255,255,.2); color:white; }

.ocp-body {
    flex:1; overflow-y:auto; min-height:0;
    padding:.8rem .8rem .4rem;
    display:flex; flex-direction:column; gap:.38rem;
    scroll-behavior:smooth; background:#FAFAF7;
}
.ocp-body::-webkit-scrollbar { width:3px; }
.ocp-body::-webkit-scrollbar-thumb { background:#D4C4B0; border-radius:3px; }

.ocp-datesep { display:flex; align-items:center; gap:.55rem; margin:.35rem 0; }
.ocp-datesep::before,.ocp-datesep::after { content:''; flex:1; height:1px; background:#EAE0D0; }
.ocp-datesep span { font-size:.56rem; color:#9A7A5A; font-weight:600; text-transform:uppercase; letter-spacing:.08em; white-space:nowrap; }

.ocp-empty { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:2rem 1rem; gap:.38rem; }
.ocp-empty-ico { font-size:1.9rem; }
.ocp-empty-ttl { font-weight:700; font-size:.85rem; color:#3B1F0F; }
.ocp-empty-sub { font-size:.7rem; color:#9A7A5A; line-height:1.5; max-width:180px; }

.ocm { display:flex; align-items:flex-end; gap:.3rem; }
.ocm-mine   { flex-direction:row-reverse; }
.ocm-theirs { flex-direction:row; }
.ocm-av {
    width:20px; height:20px; border-radius:50%;
    background:#C8893A; color:white; font-size:.55rem; font-weight:700;
    display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-bottom:2px;
}
.ocm-bub { max-width:80%; padding:.45rem .7rem; border-radius:13px; word-break:break-word; }
.ocm-bub-mine   { background:linear-gradient(135deg,#C8893A,#D9994A); color:white; border-bottom-right-radius:3px; }
.ocm-bub-theirs { background:white; border:1px solid #EAE0D0; color:#2C1A0E; border-bottom-left-radius:3px; }
.ocm-imglink { display:block; margin-bottom:.3rem; }
.ocm-img     { max-width:100%; max-height:150px; border-radius:7px; object-fit:cover; display:block; cursor:pointer; }
.ocm-txt  { font-size:.8rem; line-height:1.5; }
.ocm-time { font-size:.57rem; opacity:.55; margin-top:.16rem; display:flex; align-items:center; gap:.18rem; }
.ocm-bub-mine .ocm-time { justify-content:flex-end; }
.ocm-seen { color:rgba(255,255,255,.72); }

.ocp-preview {
    flex-shrink:0; padding:.4rem .75rem; background:#F5EFE6;
    border-top:1px solid #EAE0D0; display:flex; align-items:center; gap:.55rem;
}
.ocp-preview img { width:44px; height:44px; border-radius:7px; object-fit:cover; border:1.5px solid #D4B896; flex-shrink:0; }
.ocp-preview-info { display:flex; align-items:center; gap:.4rem; flex:1; min-width:0; }
.ocp-preview-name { font-size:.68rem; color:#7A4A28; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; flex:1; }
.ocp-preview-rm { width:18px; height:18px; border-radius:50%; background:#8B2A1E; border:none; color:white; cursor:pointer; font-size:.6rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

.ocp-form {
    display:flex; align-items:center; gap:.38rem;
    padding:.55rem .7rem; border-top:1px solid #EAE0D0;
    background:white; flex-shrink:0;
}
.ocp-attach {
    width:32px; height:32px; border-radius:50%;
    background:#F5EFE6; border:1.5px solid #EAE0D0; color:#9A7A5A;
    cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;
    transition:background .15s,color .15s,border-color .15s;
}
.ocp-attach:hover,.ocp-attach.has-file { background:#FBF3E8; border-color:#C8893A; color:#C8893A; }
.ocp-input {
    flex:1; min-width:0; padding:.48rem .8rem;
    border:1.5px solid #EAE0D0; border-radius:16px;
    font-size:.8rem; background:#F5EFE6; color:#2C1A0E; outline:none;
    transition:border-color .18s,background .18s;
}
.ocp-input:focus { border-color:#C8893A; background:white; }
.ocp-input::placeholder { color:#9A7A5A; }
.ocp-send {
    width:34px; height:34px; border-radius:50%;
    background:linear-gradient(135deg,#C8893A,#E8A94A);
    border:none; color:white; cursor:pointer;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
    transition:transform .2s cubic-bezier(.34,1.56,.64,1);
}
.ocp-send:hover  { transform:scale(1.1); }
.ocp-send:active { transform:scale(.88); }
.ocp-send:disabled { opacity:.45; cursor:not-allowed; transform:none; }
.ocp-archived {
    display:flex; align-items:center; justify-content:center;
    padding:.6rem .75rem; border-top:1px solid #EAE0D0;
    background:#F5F0EC; font-size:.68rem; color:#9A7A5A; font-weight:500; flex-shrink:0;
}
@media(max-width:480px){
    .ocp{ right:.6rem; bottom:4.5rem; width:calc(100vw - 1.2rem); max-height:70vh; }
    .ocb-btn{ right:.6rem; bottom:.6rem; }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    var POLL_MS    = 3000;
    var ME_ID      = {{ $me->id }};
    var OTHER_INIT = @json($otherInitial);
    var POLL_URL   = @json(route('order.messages.poll', $order->id));
    var CSRF       = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
    var IS_ARCH    = {{ $isArchived ? 'true' : 'false' }};
    var lastId     = {{ $lastMsgId }};
    var isOpen     = false;
    var pollTimer  = null;

    var btn       = document.getElementById('ocbBtn');
    var panel     = document.getElementById('ocpPanel');
    var badge     = document.getElementById('ocbBadge');
    var bodyEl    = document.getElementById('ocpBody');
    var anchor    = document.getElementById('ocpAnchor');
    var closeBtn  = document.getElementById('ocpCloseBtn');
    var form      = document.getElementById('ocpForm');
    var input     = document.getElementById('ocpInput');
    var fileIn    = document.getElementById('ocpFileIn');
    var attachBtn = document.getElementById('ocpAttach');
    var preview   = document.getElementById('ocpPreview');
    var prevImg   = document.getElementById('ocpPreviewImg');
    var prevName  = document.getElementById('ocpPreviewName');
    var prevRm    = document.getElementById('ocpPreviewRm');
    var sendBtn   = document.getElementById('ocpSend');

    function toggle() {
        isOpen = !isOpen;
        btn.classList.toggle('open', isOpen);
        panel.classList.toggle('open', isOpen);
        panel.setAttribute('aria-hidden', String(!isOpen));
        if (isOpen) {
            if (badge) badge.style.display = 'none';
            scrollDown();
            if (input) setTimeout(function(){ input.focus(); }, 110);
            startPoll();
        }
    }

    btn.addEventListener('click', toggle);
    if (closeBtn) closeBtn.addEventListener('click', toggle);

    document.addEventListener('click', function(e){
        if (!isOpen) return;
        if (panel.contains(e.target) || btn.contains(e.target)) return;
        toggle();
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && isOpen) toggle();
    });

    function scrollDown() {
        if (anchor) setTimeout(function(){ anchor.scrollIntoView({ behavior: 'smooth' }); }, 35);
    }

    function startPoll() {
        if (pollTimer || IS_ARCH) return;
        pollTimer = setInterval(doPoll, POLL_MS);
    }

    function doPoll() {
        fetch(POLL_URL + '?after=' + lastId, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            }
        })
        .then(function(r){ return r.ok ? r.json() : null; })
        .then(function(data){
            if (!data || !data.messages || !data.messages.length) return;
            var empty = bodyEl.querySelector('.ocp-empty');
            if (empty) empty.remove();
            var newUnread = 0;
            data.messages.forEach(function(m){
                if (bodyEl.querySelector('.ocm[data-id="'+m.id+'"]')) return;
                appendMsg(m, m.sender_id === ME_ID);
                lastId = Math.max(lastId, m.id);
                if (m.sender_id !== ME_ID) newUnread++;
            });
            scrollDown();
            if (!isOpen && newUnread > 0) {
                var cur = parseInt((badge && badge.textContent) || '0') || 0;
                if (badge) {
                    badge.textContent = (cur + newUnread > 9) ? '9+' : String(cur + newUnread);
                    badge.style.display = 'flex';
                }
            }
        })
        .catch(function(){});
    }

    function appendMsg(m, mine) {
        var row = document.createElement('div');
        row.className = 'ocm ' + (mine ? 'ocm-mine' : 'ocm-theirs');
        row.dataset.id = m.id;
        var t    = fmtTime(m.created_at);
        var seen = (mine && m.read_at) ? '<span class="ocm-seen">· Seen</span>' : '';
        var imgH = m.image_url ? '<a href="'+esc(m.image_url)+'" target="_blank" class="ocm-imglink"><img src="'+esc(m.image_url)+'" class="ocm-img" loading="lazy"></a>' : '';
        var txtH = m.body ? '<div class="ocm-txt">'+esc(m.body)+'</div>' : '';
        row.innerHTML = (!mine ? '<div class="ocm-av">'+OTHER_INIT+'</div>' : '') +
            '<div class="ocm-bub '+(mine?'ocm-bub-mine':'ocm-bub-theirs')+'">'+imgH+txtH+'<div class="ocm-time">'+t+seen+'</div></div>';
        bodyEl.insertBefore(row, anchor);
    }

    if (attachBtn && fileIn) {
        attachBtn.addEventListener('click', function(){ fileIn.click(); });
        fileIn.addEventListener('change', function(){
            var f = this.files[0];
            if (!f) return;
            if (!f.type.startsWith('image/')) { alert('Select an image file.'); this.value=''; return; }
            if (f.size > 5*1024*1024) { alert('Max 5 MB.'); this.value=''; return; }
            var rd = new FileReader();
            rd.onload = function(e){ prevImg.src=e.target.result; prevName.textContent=f.name; preview.style.display='flex'; attachBtn.classList.add('has-file'); };
            rd.readAsDataURL(f);
        });
        if (prevRm) prevRm.addEventListener('click', clearPreview);
    }

if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            var txt  = input ? input.value.trim() : '';
            var hasF = fileIn && fileIn.files.length > 0;
            if (!txt && !hasF) return;
            if (sendBtn) sendBtn.disabled = true;

            // ── IMPORTANT: capture FormData FIRST before clearing anything ──
            var fd = new FormData(form);

            var imgDataUrl = (hasF && prevImg && prevImg.src) ? prevImg.src : null;
            var optEl = appendOptimistic(txt, imgDataUrl);

            // Clear inputs AFTER FormData is captured
            if (input) input.value = '';
            clearPreview();
            scrollDown();

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: fd
            })
            .then(function(r){ return r.json().then(function(d){ return {ok:r.ok,data:d}; }); })
            .then(function(res){
                if (res.ok && res.data.message) {
                    var m = res.data.message;
                    lastId = Math.max(lastId, m.id);
                    if (optEl) {
                        optEl.dataset.id = m.id;
                        var t = optEl.querySelector('.ocm-time');
                        if (t) t.textContent = fmtTime(m.created_at);
                    }
                } else {
                    if (optEl) optEl.remove();
                    if (input && txt) input.value = txt;
                }
            })
            .catch(function(){
                if (optEl) optEl.remove();
                if (input && txt) input.value = txt;
            })
            .finally(function(){
                if (sendBtn) sendBtn.disabled = false;
                if (fileIn) fileIn.value = '';
                scrollDown();
            });
        });
    }

    function appendOptimistic(txt, imgDataUrl) {
        var empty = bodyEl.querySelector('.ocp-empty');
        if (empty) empty.remove();
        var row = document.createElement('div');
        row.className = 'ocm ocm-mine'; row.dataset.id = 'pending';
        var imgH = imgDataUrl ? '<div class="ocm-imglink"><img src="'+imgDataUrl+'" class="ocm-img"></div>' : '';
        var txtH = txt ? '<div class="ocm-txt">'+esc(txt)+'</div>' : '';
        var t = new Date().toLocaleTimeString('en-US',{hour:'numeric',minute:'2-digit'});
        row.innerHTML = '<div class="ocm-bub ocm-bub-mine">'+imgH+txtH+'<div class="ocm-time">'+t+' <span style="opacity:.45">· Sending…</span></div></div>';
        bodyEl.insertBefore(row, anchor);
        return row;
    }

    function clearPreview() {
        if (preview) preview.style.display='none';
        if (prevImg) prevImg.src='';
        if (prevName) prevName.textContent='';
        if (attachBtn) attachBtn.classList.remove('has-file');
        if (fileIn) fileIn.value='';
    }

    function esc(s) { var d=document.createElement('div'); d.appendChild(document.createTextNode(s)); return d.innerHTML; }
    function fmtTime(iso) { var d=new Date(iso); return isNaN(d)?'':d.toLocaleTimeString('en-US',{hour:'numeric',minute:'2-digit'}); }

    // scroll on load
    if (anchor) anchor.scrollIntoView({ behavior: 'instant' });

    // start background polling immediately (updates badge even when closed)
    if (!IS_ARCH) startPoll();

    @if(session('message_sent'))
    toggle();
    @endif

});
</script>