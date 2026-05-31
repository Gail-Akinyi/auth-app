@extends('layouts.app')
@section('title', 'Post Tags')

@section('content')
<div class="page-header">
    <h2>Post Tags</h2>
    <p>Manage tags for blog posts.</p>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">Add Tag</h5>
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tag Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Laravel" required>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Add Tag
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">All Tags</h5>
                <div style="display:flex;flex-wrap:wrap;gap:0.75rem;">
                    @forelse($tags as $tag)
                    <div style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;
                                background:#f3f4f6;border-radius:20px;">
                        <span style="font-size:0.875rem;font-weight:500;color:#374151;">
                            {{ $tag->name }}
                        </span>
                        <span style="font-size:0.75rem;color:#9ca3af;">
                            ({{ $tag->posts_count }})
                        </span>
                        <form action="{{ route('tags.destroy', $tag) }}" method="POST"
                              onsubmit="return confirm('Delete tag?')">
                            @csrf
                            @method('DELETE')
                            <button style="background:none;border:none;color:#dc2626;
                                           cursor:pointer;font-size:0.8rem;padding:0;">
                                &times;
                            </button>
                        </form>
                    </div>
                    @empty
                    <p style="color:#6b7280;">No tags yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection