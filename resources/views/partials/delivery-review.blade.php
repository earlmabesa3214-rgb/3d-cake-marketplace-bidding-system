{{--
    Include this partial inside the customer cake-requests/show.blade.php
    in the @else (all other states) section, right after the baker order card.

    Usage: @include('partials.delivery-review', ['bakerOrder' => $bakerOrder, 'cakeRequest' => $cakeRequest])
--}}

@php
    $alreadyReviewed = \App\Models\BakerReview::where('baker_order_id', $bakerOrder->id)->exists();
@endphp

{{-- ── DELIVERED: Customer must confirm receipt ── --}}
@if($cakeRequest->status === 'COMPLETED' && isset($bakerOrder))

    @if(session('success') && session('success') === 'Thank you for your review!')
    <div class="success-toast" style="background:#F0FBF4; border-color:#B8DFC6;">
       <div class="toast-icon" style="color:#F5A623;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
        <div>
            <div class="toast-title" style="color:#1A5A1A;">Review Submitted!</div>
            <div class="toast-sub" style="color:#2E8A2E;">Thank you for rating your baker.</div>
        </div>
    </div>
    @endif

    @if(!$alreadyReviewed)
    {{-- Review prompt card --}}
    <div class="card" style="border:2px solid #F0D090; background:linear-gradient(135deg,#FFFDF5,#FEF9ED); margin-bottom:1.5rem;">
        <div class="card-header" style="background:#FEF9ED; border-bottom-color:#F0D090;">
           <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Rate Your Baker</h3>
        </div>
        <div style="padding:1.5rem;">
            <p style="font-size:0.84rem; color:var(--text-muted); margin-bottom:1.25rem; line-height:1.6;">
                How was your experience with <strong>{{ $bakerOrder->baker->first_name }}</strong>? Your review helps other customers choose the right baker.
            </p>
            <button type="button" class="psc-pay-btn" style="width:100%; display:block; text-align:center;"
                onclick="document.getElementById('review-modal').classList.add('is-open'); document.body.style.overflow='hidden';">
                              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Leave a Review
            </button>
        </div>
    </div>
    @else
    {{-- Already reviewed --}}
    @php $review = \App\Models\BakerReview::where('baker_order_id', $bakerOrder->id)->first(); @endphp
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Your Review</h3></div>
        <div style="padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                @for($i=1; $i<=5; $i++)
                    <span style="font-size:1.3rem; color:{{ $i <= $review->rating ? '#F5A623' : '#DDD' }};">★</span>
                @endfor
                <span style="font-size:0.85rem; font-weight:700; color:var(--brown-deep); margin-left:0.3rem;">{{ $review->rating }}/5</span>
            </div>
            @if($review->comment)
            <p style="font-size:0.84rem; color:var(--text-mid); font-style:italic; line-height:1.6;">"{{ $review->comment }}"</p>
            @endif
            <p style="font-size:0.7rem; color:var(--text-muted); margin-top:0.5rem;">{{ $review->created_at->format('M d, Y') }}</p>
        </div>
    </div>
    @endif

@elseif(isset($bakerOrder) && $bakerOrder->status === 'DELIVERED')

    {{-- Confirm Delivery card --}}
    <div class="card" style="border:2px solid #EDD090; margin-bottom:1.5rem; position:relative; overflow:hidden;">
        <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#c8862a,#e8a94a,#c8862a);"></div>
        <div class="card-header" style="background:#FEF9ED; border-bottom-color:#F0D090;">
<h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg>Confirm Delivery</h3>
            <span style="font-size:0.72rem; font-weight:700; color:#c8862a; background:#FBF3E8; padding:0.2rem 0.65rem; border-radius:20px; border:1px solid #EDD090;">Action Required</span>
        </div>
        <div style="padding:1.5rem;">
            <div style="display:flex; align-items:flex-start; gap:0.85rem; background:#FFFDF5; border:1px solid #EDD090; border-radius:12px; padding:1rem; margin-bottom:1.25rem;">
              <div style="flex-shrink:0;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div>
                <div>
                    <div style="font-weight:700; font-size:0.9rem; color:var(--brown-deep); margin-bottom:0.25rem;">Your cake has been delivered!</div>
                    <div style="font-size:0.78rem; color:var(--text-muted); line-height:1.6;">Please confirm that you have received your cake in good condition. This will complete the order and release the baker's payment.</div>
                </div>
            </div>

            <form id="form-confirm-delivery" method="POST"
                  action="{{ route('customer.orders.confirm-delivery', $bakerOrder->id) }}">
                @csrf
            </form>
            <button type="button" class="psc-pay-btn" style="width:100%; display:block; text-align:center;"
                onclick="document.getElementById('modal-confirm-delivery').classList.add('is-open'); document.body.style.overflow='hidden';">
                              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>I Received My Cake
            </button>
            <p style="text-align:center; font-size:0.72rem; color:var(--text-muted); margin-top:0.6rem; line-height:1.5;">Only confirm if you have physically received your order</p>
        </div>
    </div>

@endif

{{-- ═══════════════════════════════════════════════
     CONFIRM DELIVERY MODAL
═══════════════════════════════════════════════ --}}
@if(isset($bakerOrder) && $bakerOrder->status === 'DELIVERED')
<div class="confirm-modal-backdrop" id="modal-confirm-delivery" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header" style="background:linear-gradient(135deg,#4A2E08,#9A6830); padding:2rem 2rem 1.5rem; text-align:center;">
<div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg></div>
            <div class="confirm-modal-title">Confirm Delivery?</div>
            <div class="confirm-modal-subtitle">Only confirm if you've received your cake</div>
        </div>
              <div class="confirm-modal-body">
            @php
                $rdCakePrice   = $bakerOrder->agreed_price;
                $rdRushFee     = 0;
                if ($cakeRequest->is_rush) {
                    $rdAcceptedBid = $cakeRequest->bids->whereIn('status', ['ACCEPTED','accepted'])->first();
                    $rdRushFee = $rdAcceptedBid->rush_fee ?? 0;
                }
                $rdDeliveryFee = (float) ($bakerOrder->delivery_fee ?? 0);
                $rdTotal       = $rdCakePrice + $rdRushFee + $rdDeliveryFee;
            @endphp
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Baker</span>
                    <span class="confirm-modal-detail-val">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Cake Price</span>
                    <span class="confirm-modal-detail-val">₱{{ number_format($rdCakePrice, 2) }}</span>
                </div>
                @if($rdRushFee > 0)
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key" style="color:#C8562A;"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:3px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Rush Fee</span>
                    <span class="confirm-modal-detail-val" style="color:#C8562A;">₱{{ number_format($rdRushFee, 2) }}</span>
                </div>
                @endif
                @if($rdDeliveryFee > 0)
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Delivery Fee{{ $bakerOrder->delivery_distance_km ? ' ('.$bakerOrder->delivery_distance_km.' km)' : '' }}</span>
                    <span class="confirm-modal-detail-val">₱{{ number_format($rdDeliveryFee, 2) }}</span>
                </div>
                @endif
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Total Paid</span>
                    <span class="confirm-modal-detail-val" style="color:var(--caramel); font-family:'Playfair Display',serif;">₱{{ number_format($rdTotal, 2) }}</span>
                </div>
            </div>
            <p class="confirm-modal-note">This will mark the order as <strong>Complete</strong>. You'll then be asked to rate your baker.</p>
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel"
                onclick="document.getElementById('modal-confirm-delivery').classList.remove('is-open'); document.body.style.overflow='';">
                Not Yet
            </button>
            <button class="confirm-modal-btn-ok style-accept"
                onclick="this.disabled=true; this.classList.add('is-loading'); document.getElementById('form-confirm-delivery').submit();">
                <span class="btn-spinner"></span>
                             <span class="btn-text"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:4px;"><polyline points="20 6 9 17 4 12"/></svg>Yes, Received!</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════
     REVIEW MODAL (shown after COMPLETED or manual open)
═══════════════════════════════════════════════ --}}
@if(isset($bakerOrder) && $cakeRequest->status === 'COMPLETED' && !$alreadyReviewed)
<div class="confirm-modal-backdrop {{ session('show_review_modal') ? 'is-open' : '' }}" id="review-modal" role="dialog" aria-modal="true">
    <div class="confirm-modal" style="max-width:460px;">
        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#7B4A1E,#C07840); padding:2rem 2rem 1.5rem; text-align:center;">
               <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.25); display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
            <div style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:white; margin-bottom:0.3rem;">Rate Your Baker</div>
            <div style="font-size:0.78rem; color:rgba(255,255,255,0.65);">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</div>
        </div>

        <form method="POST" action="{{ route('customer.orders.review', $bakerOrder->id) }}" id="review-form">
            @csrf
            <div style="padding:1.5rem 2rem;">

                {{-- Star rating --}}
                <div style="text-align:center; margin-bottom:1.5rem;">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:600; margin-bottom:0.85rem;">Your Rating</div>
                    <div style="display:flex; justify-content:center; gap:0.4rem;" id="star-group">
                        @for($i=1; $i<=5; $i++)
                        <button type="button" class="star-btn" data-val="{{ $i }}"
                            style="font-size:2.2rem; background:none; border:none; cursor:pointer; color:#DDD; transition:color 0.15s, transform 0.15s; padding:0 0.1rem; line-height:1;">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="">
                    <div id="rating-label" style="font-size:0.78rem; color:var(--text-muted); margin-top:0.5rem; min-height:1.2em;"></div>
                </div>

                {{-- Comment --}}
                <div style="margin-bottom:1.25rem;">
                    <label style="display:block; font-size:0.72rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); margin-bottom:0.5rem;">Comment <span style="font-weight:400; text-transform:none;">(optional)</span></label>
                    <textarea name="comment" rows="3" maxlength="1000"
                        style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid var(--border); border-radius:10px; font-size:0.84rem; font-family:'DM Sans',sans-serif; color:var(--text-dark); resize:vertical; outline:none; transition:border-color 0.18s;"
                        placeholder="How was the cake? Was the baker responsive? Share your experience…"
                        onfocus="this.style.borderColor='var(--caramel)'"
                        onblur="this.style.borderColor='var(--border)'"></textarea>
                </div>

                {{-- Baker info --}}
                <div style="display:flex; align-items:center; gap:0.75rem; background:var(--cream); border:1px solid var(--border); border-radius:10px; padding:0.75rem 1rem; margin-bottom:1.25rem;">
                    <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#C07840,#E8A96A); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem; flex-shrink:0; overflow:hidden;">
                        @if($bakerOrder->baker->profile_photo)
                            <img src="{{ asset('storage/'.$bakerOrder->baker->profile_photo) }}" style="width:100%; height:100%; object-fit:cover;" alt="">
                        @else
                            {{ strtoupper(substr($bakerOrder->baker->first_name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div style="font-weight:700; font-size:0.84rem; color:var(--brown-deep);">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</div>
                        <div style="font-size:0.7rem; color:var(--text-muted);">Order #{{ str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT) }} · ₱{{ number_format($bakerOrder->agreed_price, 0) }}</div>
                    </div>
                </div>

            </div>

            <div style="display:flex; gap:0.75rem; padding:0 2rem 2rem;">
                <button type="button" class="confirm-modal-btn-cancel"
                    onclick="document.getElementById('review-modal').classList.remove('is-open'); document.body.style.overflow='';">
                    Maybe Later
                </button>
                <button type="submit" id="review-submit-btn" class="confirm-modal-btn-ok style-accept" disabled
                    style="opacity:0.45; cursor:not-allowed;">
                    <span class="btn-spinner"></span>
                                        <span class="btn-text"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Submit Review</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.star-btn:hover, .star-btn.active { transform: scale(1.15); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var labels = ['', 'Poor 😞', 'Fair 😐', 'Good 🙂', 'Great 😊', 'Excellent! 🤩'];
    var stars  = document.querySelectorAll('.star-btn');
    var input  = document.getElementById('rating-input');
    var label  = document.getElementById('rating-label');
    var submit = document.getElementById('review-submit-btn');
    var current = 0;

    function paint(n) {
        stars.forEach(function(s, i) {
            s.style.color = i < n ? '#F5A623' : '#DDD';
            s.classList.toggle('active', i < n);
        });
    }

    stars.forEach(function(s) {
        s.addEventListener('mouseenter', function() { paint(+this.dataset.val); });
        s.addEventListener('mouseleave', function() { paint(current); });
        s.addEventListener('click', function() {
            current = +this.dataset.val;
            input.value = current;
            label.textContent = labels[current];
            paint(current);
            submit.disabled = false;
            submit.style.opacity = '1';
            submit.style.cursor  = 'pointer';
        });
    });

    // Auto-open if just confirmed delivery
    @if(session('show_review_modal'))
    document.getElementById('review-modal').classList.add('is-open');
    document.body.style.overflow = 'hidden';
    @endif

    // Close on backdrop click
    document.getElementById('review-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    });

    // Submit loading state
    document.getElementById('review-form').addEventListener('submit', function() {
        submit.disabled = true;
        submit.classList.add('is-loading');
    });
});
</script>
@endif