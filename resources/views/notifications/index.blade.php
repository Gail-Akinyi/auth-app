@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Notifications</h2>
        <p>Stay up to date with activity on your posts.</p>
    </div>
    @if($notifications->count() > 0)
    <form action="{{ route('notifications.clear') }}" method="POST">
        @csrf
        <button type="submit"
                style="padding:0.5rem 1rem;border-radius:8px;border:1px solid #fca5a5;
                       color:#dc2626;background:transparent;font-weight:500;cursor:pointer;">
            Clear All
        </button>
    </form>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="card-custom">
    <div class="card-body">
        @forelse($notifications as $notification)
        <div style="display:flex;align-items:flex-start;gap:1rem;padding:1rem 0;
                    border-bottom:1px solid #f3f4f6;
                    opacity:{{ $notification->read ? '0.6' : '1' }};">
            <div style="width:40px;height:40px;border-radius:50%;flex-shrink:0;
                        background:{{ $notification->type === 'like' ? '#fef3c7' : '#ede9fe' }};
                        display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
                {{ $notification->type === 'like' ? '&#10084;' : '&#128172;' }}
            </div>
            <div style="flex:1;">
                <p style="margin:0;font-size:0.875rem;color:#111827;font-weight:{{ $notification->read ? '400' : '600' }};">
                    {{ $notification->message }}
                </p>
                <span style="font-size:0.75rem;color:#9ca3af;">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
                @if($notification->link)
                <a href="{{ $notification->link }}"
                   style="font-size:0.75rem;color:#4f46e5;margin-left:0.5rem;text-decoration:none;">
                    View →
                </a>
                @endif
            </div>
            <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                @csrf
                @method('DELETE')
                <button style="background:none;border:none;color:#9ca3af;cursor:pointer;font-size:1rem;">
                    &times;
                </button>
            </form>
        </div>
        @empty
        <div class="text-center" style="padding:3rem;">
            <div style="font-size:3rem;margin-bottom:1rem;">&#128276;</div>
            <h5 style="font-weight:700;color:#111827;">No notifications yet</h5>
            <p style="color:#6b7280;">You'll be notified when someone likes or comments on your posts.</p>
        </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection