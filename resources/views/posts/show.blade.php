@extends('layouts.app')
@section('title', $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="mb-3">
            <a href="{{ route('posts.index') }}"
               style="color:#4f46e5;text-decoration:none;font-size:0.875rem;font-weight:500;">
                ← Back to Posts
            </a>
        </div>

        <div class="card-custom mb-4">
            <div class="card-body" style="padding:2.5rem;">

                {{-- Tags --}}
                @if($post->tags->count() > 0)
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
                    @foreach($post->tags as $tag)
                    <span style="font-size:0.75rem;font-weight:600;color:#374151;
                                 background:#f3f4f6;padding:0.2rem 0.6rem;border-radius:20px;">
                        #{{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                {{-- Category --}}
                @if($post->category)
                <span style="font-size:0.75rem;font-weight:600;color:#4f46e5;
                             background:#ede9fe;padding:0.25rem 0.75rem;
                             border-radius:20px;display:inline-block;margin-bottom:1rem;">
                    {{ $post->category->name }}
                </span>
                @endif

                <h1 style="font-weight:800;color:#111827;font-size:1.8rem;
                           line-height:1.3;margin-bottom:1rem;">
                    {{ $post->title }}
                </h1>

                <div style="display:flex;align-items:center;gap:1rem;
                            padding-bottom:1.5rem;border-bottom:1px solid #f3f4f6;
                            margin-bottom:1.5rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <img src="{{ $post->user->avatar_url }}"
                             style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                        <div>
                            <div style="font-size:0.875rem;font-weight:600;color:#111827;">
                                {{ $post->user->name }}
                            </div>
                            <div style="font-size:0.75rem;color:#9ca3af;">
                                {{ $post->published_at->format('F d, Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- Like Button --}}
                    <div style="margin-left:auto;display:flex;align-items:center;gap:1rem;">
                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button style="display:flex;align-items:center;gap:0.4rem;
                                           padding:0.4rem 0.9rem;border-radius:20px;cursor:pointer;
                                           border:1px solid {{ $post->isLikedBy(Auth::user()) ? '#fca5a5' : '#e5e7eb' }};
                                           background:{{ $post->isLikedBy(Auth::user()) ? '#fef2f2' : 'transparent' }};
                                           color:{{ $post->isLikedBy(Auth::user()) ? '#dc2626' : '#6b7280' }};
                                           font-size:0.875rem;font-weight:500;">
                                &#10084; {{ $post->likes->count() }}
                            </button>
                        </form>

                        <span style="font-size:0.875rem;color:#6b7280;">
                            &#128172; {{ $post->comments->count() }} comments
                        </span>

                        @if(Auth::user()->isAdmin() || $post->user_id === Auth::id())
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
                        @endif
                    </div>
                </div>

                <div style="color:#374151;font-size:1rem;line-height:1.8;white-space:pre-wrap;">
                    {{ $post->body }}
                </div>

            </div>
        </div>

        {{-- Comments --}}
        <div class="card-custom mb-4">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    Comments ({{ $post->comments->count() }})
                </h5>

                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                {{-- Add Comment --}}
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-2">
                        <textarea name="body" class="form-control" rows="3"
                                  placeholder="Write a comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn-primary-custom">Post Comment</button>
                </form>

                {{-- Comments List --}}
                @forelse($post->comments as $comment)
                <div style="display:flex;gap:0.75rem;padding:1rem 0;border-top:1px solid #f3f4f6;">
                    <img src="{{ $comment->user->avatar_url }}"
                         style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                    <div style="flex:1;">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-weight:600;color:#111827;font-size:0.875rem;">
                                {{ $comment->user->name }}
                            </span>
                            <span style="font-size:0.75rem;color:#9ca3af;">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p style="color:#374151;font-size:0.875rem;margin:0.25rem 0 0;">
                            {{ $comment->body }}
                        </p>
                        @if(Auth::user()->isAdmin() || $comment->user_id === Auth::id())
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                              style="margin-top:0.25rem;">
                            @csrf
                            @method('DELETE')
                            <button style="background:none;border:none;color:#dc2626;
                                           font-size:0.75rem;cursor:pointer;padding:0;">
                                Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <p style="color:#6b7280;font-size:0.875rem;text-align:center;padding:1rem 0;">
                    No comments yet. Be the first to comment!
                </p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection