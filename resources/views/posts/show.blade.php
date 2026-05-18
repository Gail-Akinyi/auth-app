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

        <div class="card-custom">
            <div class="card-body" style="padding:2.5rem;">

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
                        <div style="width:36px;height:36px;background:#4f46e5;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;
                                    color:white;font-size:0.85rem;font-weight:600;">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:0.875rem;font-weight:600;color:#111827;">
                                {{ $post->user->name }}
                            </div>
                            <div style="font-size:0.75rem;color:#9ca3af;">
                                {{ $post->published_at->format('F d, Y') }}
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->isAdmin() || $post->user_id === Auth::id())
                    <div style="margin-left:auto;display:flex;gap:0.5rem;">
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

                <div style="color:#374151;font-size:1rem;line-height:1.8;white-space:pre-wrap;">
                    {{ $post->body }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection