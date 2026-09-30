@php $draftCfg = $config['draft_config'] ?? null; @endphp

@if($draftCfg)
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header">
        <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>3D Cake Preview</h3>
        <span style="font-size:0.68rem;font-weight:700;color:var(--caramel);background:#FBF4EC;border:1px solid #D4B896;padding:0.15rem 0.6rem;border-radius:20px;">Interactive</span>
    </div>
    <div style="position:relative;height:420px;background:#F2E8D7;overflow:hidden;">
        @if($cakeRequest->cake_preview_image)
        <img src="{{ asset('storage/' . $cakeRequest->cake_preview_image) }}" alt="3D Cake Preview"
             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
        @endif
        <iframe id="cake3dFrame"
                src="{{ route('customer.cake-builder.index') }}?view_request={{ $cakeRequest->id }}"
                title="Interactive 3D cake"
                style="position:absolute;inset:0;width:100%;height:100%;border:0;opacity:0;transition:opacity .5s ease;"></iframe>
        <div id="cake3dStatus" style="position:absolute;left:50%;bottom:14px;transform:translateX(-50%);background:rgba(40,20,8,.7);color:#F5D090;font-size:.72rem;font-weight:600;padding:.35rem .9rem;border-radius:20px;pointer-events:none;">Loading interactive 3D…</div>
    </div>
    <div style="padding:0.75rem 1.5rem;font-size:0.75rem;color:var(--text-muted);text-align:center;">
        Drag to rotate · Tap <strong>With Slice</strong> to see inside · Exactly as designed at time of request
    </div>
</div>
<script>
(function(){
    var frame  = document.getElementById('cake3dFrame');
    var status = document.getElementById('cake3dStatus');
    var cfg    = @json($draftCfg);
    var shown  = false;
    function send(){ try{ frame.contentWindow.postMessage({type:'bakesphere-tracker-config', config:cfg}, window.location.origin); }catch(e){} }
    function reveal(){
        if(shown) return; shown = true;
        frame.style.opacity = '1';
        if(status) status.style.display = 'none';
    }
    window.addEventListener('message', function(e){
        if(e.origin !== window.location.origin || e.source !== frame.contentWindow || !e.data) return;
        if(e.data.type === 'bakesphere-tracker-ready')  send();
        if(e.data.type === 'bakesphere-tracker-loaded') reveal();
    });
    frame.addEventListener('load', send);
    setTimeout(reveal, 20000); // safety: never stay hidden
})();
</script>

@elseif($cakeRequest->cake_preview_image)
{{-- older requests: static photo --}}
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header"><h3>3D Cake Preview</h3></div>
    <img src="{{ asset('storage/' . $cakeRequest->cake_preview_image) }}" alt="3D Cake Preview"
         style="width:100%; max-height:320px; object-fit:cover; display:block;">
    <div style="padding:0.75rem 1.5rem; font-size:0.75rem; color:var(--text-muted); text-align:center;">3D preview captured at time of request</div>
</div>
@endif