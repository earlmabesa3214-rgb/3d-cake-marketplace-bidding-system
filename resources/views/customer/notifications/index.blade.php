@extends('layouts.customer')
@section('title', 'Notifications')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }

    .notif-page { max-width: 100%; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .page-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--brown-deep);
        letter-spacing: -0.01em;
        margin: 0;
    }
    .page-subtitle {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
        font-weight: 400;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.9rem;
        border-radius: 7px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.15s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-mid);
    }
    .btn-outline:hover {
        border-color: var(--caramel);
        color: var(--caramel);
        background: var(--cream);
    }

    .notif-list {
        display: flex;
        flex-direction: column;
        background: var(--warm-white);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    .notif-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
        position: relative;
        color: inherit;
        text-decoration: none;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--cream); }
    .notif-item.unread { background: #FEF9F4; }
    .notif-item.unread::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--caramel);
        border-radius: 0 2px 2px 0;
    }

    .notif-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .notif-icon.bid     { background: rgba(200,137,74,0.13); }
    .notif-icon.order   { background: rgba(200,137,74,0.10); }
    .notif-icon.payment { background: rgba(200,137,74,0.16); }
    .notif-icon.warning { background: rgba(212,137,106,0.13); }
    .notif-icon.error   { background: rgba(180,60,60,0.09); }
    .notif-icon.success { background: rgba(92,158,106,0.11); }
    .notif-icon.info    { background: rgba(122,158,126,0.13); }
    .notif-icon.default { background: rgba(232,221,212,0.5); }

    .notif-body {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
    }
    .notif-title-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
    }
    .notif-title {
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .notif-message {
        font-size: 0.77rem;
        color: var(--text-muted);
        line-height: 1.45;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notif-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.35rem;
        flex-shrink: 0;
    }
    .notif-time {
        font-size: 0.68rem;
        color: var(--text-muted);
        white-space: nowrap;
        font-weight: 500;
    }
    .notif-actions {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .mark-read-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 0.7rem;
        padding: 0.25rem 0.45rem;
        border-radius: 5px;
        transition: all 0.15s;
        line-height: 1;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .mark-read-btn:hover { background: var(--border); color: var(--text-dark); }

    .delete-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 0.7rem;
        padding: 0.25rem 0.45rem;
        border-radius: 5px;
        transition: all 0.15s;
        line-height: 1;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .delete-btn:hover { background: rgba(180,60,60,0.09); color: #8B2A1E; }

    .unread-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--caramel);
        flex-shrink: 0;
    }
    .new-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.1rem 0.45rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        background: var(--caramel);
        color: white;
        flex-shrink: 0;
    }

    .notif-link {
        font-size: 0.7rem;
        color: var(--caramel);
        text-decoration: none;
        font-weight: 600;
    }
    .notif-link:hover { text-decoration: underline; }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        color: var(--text-muted);
    }
    .empty-state .emoji { font-size: 2rem; margin-bottom: 0.75rem; }
    .empty-state h3 {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--brown-mid);
        margin-bottom: 0.35rem;
    }
    .empty-state p {
        font-size: 0.8rem;
    }

    .notif-pagination {
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="notif-page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Notifications</h1>
            <p class="page-subtitle">Stay updated on your cake requests</p>
        </div>
        @if($notifications->whereNull('read_at')->count() > 0)
        <form method="POST" action="{{ route('customer.notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-outline">✓ Mark all as read</button>
        </form>
        @endif
    </div>

    <div class="notif-list">
        @forelse($notifications as $notif)
        @php
            $data     = is_array($notif->data) ? $notif->data : (json_decode($notif->data, true) ?? []);
            $title    = $data['title']      ?? $data['subject']    ?? 'Notification';
            $message  = $data['message']    ?? $data['body']       ?? $data['line'] ?? '';
            $icon     = $data['icon']       ?? '🔔';
            $type     = $data['type']       ?? 'default';
            $link     = $data['url']        ?? $data['action_url'] ?? null;
            $isUnread = is_null($notif->read_at);
        @endphp
        <div class="notif-item {{ $isUnread ? 'unread' : '' }}">
            <div class="notif-icon {{ $type }}">{{ $icon }}</div>

            <div class="notif-body">
                <div class="notif-title-row">
                    <span class="notif-title">{{ $title }}</span>
                    @if($isUnread)<span class="new-badge">New</span>@endif
                    @if($link)
                        <a href="{{ $link }}" class="notif-link">View →</a>
                    @endif
                </div>
                <div class="notif-message">{{ $message }}</div>
            </div>

            <div class="notif-meta">
                <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                <div class="notif-actions">
                    @if($isUnread)
                        <div class="unread-dot" title="Unread"></div>
                        <form method="POST" action="{{ route('customer.notifications.read', $notif->id) }}">
                            @csrf
                            <button type="submit" class="mark-read-btn" title="Mark as read">✓</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('customer.notifications.destroy', $notif->id) }}"
                          onsubmit="return confirm('Delete this notification?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="delete-btn" title="Delete">🗑</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="emoji">🔔</div>
            <h3>No notifications yet</h3>
            <p>You'll be notified when bakers respond to your requests.</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="notif-pagination">{{ $notifications->links() }}</div>
    @endif

</div>
@endsection