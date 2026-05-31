@extends('layouts.app')
@section('title', 'Contact Messages')

@section('content')
<div class="page-header">
    <h2>Contact Messages</h2>
    <p>Messages sent through the contact form.</p>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr style="{{ $message->status === 'unread' ? 'background:#fafafa;font-weight:500;' : '' }}">
                        <td style="color:#111827;">{{ $message->name }}</td>
                        <td style="color:#6b7280;">{{ $message->email }}</td>
                        <td style="color:#111827;">
                            {{ Str::limit($message->subject, 40) }}
                            <div style="font-size:0.75rem;color:#9ca3af;margin-top:0.2rem;">
                                {{ Str::limit($message->message, 60) }}
                            </div>
                        </td>
                        <td>
                            <span style="font-size:0.75rem;padding:0.25rem 0.6rem;border-radius:20px;
                                         font-weight:600;
                                         background:{{ $message->status === 'unread' ? '#fef3c7' : '#f3f4f6' }};
                                         color:{{ $message->status === 'unread' ? '#92400e' : '#374151' }};">
                                {{ ucfirst($message->status) }}
                            </span>
                        </td>
                        <td style="color:#6b7280;">{{ $message->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($message->status === 'unread')
                                <form action="{{ route('contact.read', $message) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button style="font-size:0.8rem;padding:0.3rem 0.75rem;border-radius:8px;
                                                   border:1px solid #6ee7b7;color:#065f46;background:transparent;
                                                   font-weight:500;cursor:pointer;">
                                        Mark Read
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('contact.destroy', $message) }}" method="POST"
                                      onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button style="font-size:0.8rem;padding:0.3rem 0.75rem;border-radius:8px;
                                                   border:1px solid #fca5a5;color:#dc2626;background:transparent;
                                                   font-weight:500;cursor:pointer;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color:#6b7280;padding:2rem;">
                            No messages yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $messages->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection