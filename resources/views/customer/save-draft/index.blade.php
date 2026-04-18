@extends('layouts.customer')

@section('title', 'Saved Draft')

@section('content')
<style>
.drafts-header { margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.drafts-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--brown-deep); }
.drafts-header p   { color: var(--text-muted); font-size: 0.875rem; margin-top: 0.25rem; }

.btn-new {
    background: var(--caramel); color: white; border: none; border-radius: 10px;
    padding: 0.6rem 1.2rem; font-size: 0.85rem; font-weight: 600;
    text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;
    transition: background 0.2s; white-space: nowrap;
}
.btn-new:hover { background: var(--brown-light); color: white; }

.draft-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 14px; padding: 1.5rem;
}
.draft-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: rgba(200,137,74,0.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; margin-bottom: 1rem;
}
.draft-title { font-size: 1rem; font-weight: 700; color: var(--brown-deep); margin-bottom: 1rem; }

.draft-details { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem; }
.detail-chip {
    background: var(--cream); border: 1px solid var(--border); border-radius: 10px;
    padding: 0.6rem 0.9rem;
}
.detail-chip .label { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 0.2rem; }
.detail-chip .value { font-size: 0.875rem; font-weight: 600; color: var(--brown-deep); }

.draft-price { font-size: 1.3rem; font-weight: 700; color: var(--caramel); margin-bottom: 1.25rem; }

.draft-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.btn-resume {
    background: var(--caramel); color: white; border: none; border-radius: 10px;
    padding: 0.6rem 1.3rem; font-size: 0.85rem; font-weight: 600;
    text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;
    transition: background 0.2s;
}
.btn-resume:hover { background: var(--brown-light); color: white; }
.btn-discard {
    background: rgba(180,56,64,0.1); color: #B43840;
    border: 1px solid rgba(180,56,64,0.2); border-radius: 10px;
    padding: 0.6rem 1.3rem; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; transition: background 0.2s;
}
.btn-discard:hover { background: rgba(180,56,64,0.2); }

.empty-state {
    text-align: center; padding: 4rem 2rem; color: var(--text-muted);
    background: var(--warm-white); border: 1px solid var(--border); border-radius: 14px;
}
.empty-state .empty-icon { font-size: 3rem; margin-bottom: 1rem; }
.empty-state h3 { font-size: 1.1rem; font-weight: 600; color: var(--brown-mid); margin-bottom: 0.5rem; }
.empty-state p   { font-size: 0.875rem; margin-bottom: 1.5rem; }
</style>

<div class="drafts-header">
    <div>
        <h1>💾 Saved Draft</h1>
        <p>Resume your cake design where you left off.</p>
    </div>
    <a href="{{ route('customer.cake-builder.index') }}" class="btn-new">+ New Cake</a>
</div>

@if($draft)
    <div class="draft-card">
        <div class="draft-icon">🎂</div>
        <div class="draft-title">My Saved Cake Design</div>

        <div class="draft-details">
            @if(!empty($draft['size']))
            <div class="detail-chip">
                <div class="label">Size</div>
                <div class="value">{{ $draft['size'] }}</div>
            </div>
            @endif
            @if(!empty($draft['flavor']))
            <div class="detail-chip">
                <div class="label">Flavor</div>
                <div class="value">{{ $draft['flavor'] }}</div>
            </div>
            @endif
            @if(!empty($draft['frosting']))
            <div class="detail-chip">
                <div class="label">Frosting</div>
                <div class="value">{{ $draft['frosting'] }}</div>
            </div>
            @endif
            @if(!empty($draft['layers']))
            <div class="detail-chip">
                <div class="label">Layers</div>
                <div class="value">{{ $draft['layers'] }}</div>
            </div>
            @endif
            @if(!empty($draft['addons']) && count($draft['addons']) > 0)
            <div class="detail-chip">
                <div class="label">Add-ons</div>
                <div class="value">{{ implode(', ', $draft['addons']) }}</div>
            </div>
            @endif
            @if(!empty($draft['message']))
            <div class="detail-chip">
                <div class="label">Cake Message</div>
                <div class="value">"{{ $draft['message'] }}"</div>
            </div>
            @endif
        </div>

        @if(!empty($draft['total_price']))
        <div class="draft-price">Estimated: ₱{{ number_format($draft['total_price'], 0) }}</div>
        @endif

        <div class="draft-actions">
            <a href="{{ route('customer.cake-builder.index') }}?load_draft=1" class="btn-resume">
                ✏️ Resume Design
            </a>
            <form method="POST" action="{{ route('customer.cake-builder.discardDraft') }}"
                  onsubmit="return confirm('Discard this draft? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-discard">🗑 Discard Draft</button>
            </form>
        </div>
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">📋</div>
        <h3>No saved draft yet</h3>
        <p>Start designing a cake and hit "Save Draft" — it'll appear here.</p>
        <a href="{{ route('customer.cake-builder.index') }}" class="btn-new">Start Designing</a>
    </div>
@endif
@endsection