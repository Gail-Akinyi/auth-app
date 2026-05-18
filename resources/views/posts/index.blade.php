@extends('layouts.app')
@section('title', 'Posts')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Blog Posts</h2>
        <p>Read the latest posts from our community.</p>
    </div>
    <a href="{{ route('posts.create') }}" class="btn-primary-custom">+ New Post</a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

{{-- Search & Filter --}}
<form method="GET" action="{{ route('posts.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control"
                   placeholder="Search posts..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}"
                        {{ request('category') === $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn-primary-custom flex-fill text-center">Search</button>
            <a href="{{ route('posts.index') }}"
               style="padding:0.65rem 1rem;border-radius:10px;border:1px solid #e5e7eb;
                      color:#374151;text-decoration:none;font-weight:600;font-size:0.9rem;">
                Clear
            </a>
        </div>
    </div>
</form>

{{-- Posts Grid --}}
@if($posts->count() > 0)
<div class="row g-4">
    @foreach($posts as $post)
    <div class="col-md-6 col-lg-4">
        <div class="card-custom h-100" style="transition:transform 0.2s;"
             onmouseover="this.style.transform='translateY(-4px)'"
             onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body d-flex flex-column">

                {{-- Category Badge --}}
                @if($post->category)
                <span style="font-size:0.75rem;font-weight:600;color:#4f46e5;
                             background:#ede9fe;padding:0.25rem 0.75rem;
                             border-radius:20px;display:inline-block;
                             margin-bottom:0.75rem;width:fit-content;">
                    {{ $post->category->name }}
                </span>
                @endif

                {{-- Title --}}
                <h5 style="font-weight:700;color:#111827;margin-bottom:0.5rem;
                           font-size:1.1rem;line-height:1.4;">
                    <a href="{{ route('posts.show', $post) }}"
                       style="text-decoration:none;color:inherit;">
                        {{ $post->title }}
                    </a>
                </h5>

                {{-- Excerpt --}}
                <p style="color:#6b7280;font-size:0.875rem;flex:1;margin-bottom:1rem;">
                    {{ $post->excerpt ?? Str::limit($post->body, 120) }}
                </p>

                {{-- Footer --}}
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding-top:0.75rem;border-top:1px solid #f3f4f6;">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <div style="width:28px;height:28px;background:#4f46e5;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;
                                    color:white;font-size:0.7rem;font-weight:600;">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <span style="font-size:0.8rem;color:#6b7280;">{{ $post->user->name }}</span>
                    </div>
                    <span style="font-size:0.75rem;color:#9ca3af;">
                        {{ $post->published_at->format('M d, Y') }}
                    </span>
                </div>

                {{-- Actions --}}
                @if(Auth::user()->isAdmin() || $post->user_id === Auth::id())
                <div style="display:flex;gap:0.5rem;margin-top:0.75rem;">
                    <a href="{{ route('posts.edit', $post) }}"
                       style="font-size:0.8rem;padding:0.3rem 0.75rem;border-radius:8px;
                              border:1px solid #e5e7eb;color:#374151;text-decoration:none;
                              font-weight:500;">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                          onsubmit="return confirm('Delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button style="font-size:0.8rem;padding:0.3rem 0.75rem;border-radius:8px;
                                       border:1px solid #fca5a5;color:#dc2626;background:transparent;
                                       font-weight:500;cursor:pointer;">Delete</button>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>

@else
<div class="card-custom">
    <div class="card-body text-center" style="padding:3rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">📝</div>
        <h5 style="font-weight:700;color:#111827;">No posts yet</h5>
        <p style="color:#6b7280;">Be the first to write something!</p>
        <a href="{{ route('posts.create') }}" class="btn-primary-custom">Create First Post</a>
    </div>
</div>
@endif

@endsection