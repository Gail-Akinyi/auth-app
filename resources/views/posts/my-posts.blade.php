@extends('layouts.app')
@section('title', 'My Posts')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>My Posts</h2>
        <p>Manage all your posts here.</p>
    </div>
    <a href="{{ route('posts.create') }}" class="btn-primary-custom">+ New Post</a>
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
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td style="font-weight:500;color:#111827;">
                            <a href="{{ route('posts.show', $post) }}"
                               style="text-decoration:none;color:inherit;">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td style="color:#6b7280;">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </td>
                        <td>
                            <span style="font-size:0.75rem;padding:0.25rem 0.6rem;border-radius:20px;
                                         font-weight:600;
                                         background:{{ $post->status === 'published' ? '#ecfdf5' : '#f3f4f6' }};
                                         color:{{ $post->status === 'published' ? '#065f46' : '#374151' }};">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td style="color:#6b7280;">
                            {{ $post->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-2">
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color:#6b7280;padding:2rem;">
                            You haven't written any posts yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection