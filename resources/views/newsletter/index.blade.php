@extends('layouts.app')
@section('title', 'Newsletter Subscribers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Newsletter Subscribers</h2>
        <p>Manage your newsletter subscriber list.</p>
    </div>
    <a href="{{ route('newsletter.export') }}"
       style="font-size:0.85rem;padding:0.5rem 1rem;border-radius:8px;
              background:#ecfdf5;color:#065f46;text-decoration:none;
              font-weight:600;border:1px solid #6ee7b7;">
        Export CSV
    </a>
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
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subscribed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                    <tr>
                        <td style="color:#9ca3af;">{{ $subscriber->id }}</td>
                        <td style="font-weight:500;color:#111827;">
                            {{ $subscriber->name ?? 'Anonymous' }}
                        </td>
                        <td style="color:#6b7280;">{{ $subscriber->email }}</td>
                        <td style="color:#6b7280;">
                            {{ $subscriber->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <form action="{{ route('newsletter.destroy', $subscriber) }}"
                                  method="POST"
                                  onsubmit="return confirm('Remove this subscriber?')">
                                @csrf
                                @method('DELETE')
                                <button style="font-size:0.8rem;padding:0.3rem 0.75rem;border-radius:8px;
                                               border:1px solid #fca5a5;color:#dc2626;background:transparent;
                                               font-weight:500;cursor:pointer;">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color:#6b7280;padding:2rem;">
                            No subscribers yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $subscribers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection