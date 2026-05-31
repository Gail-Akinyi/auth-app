@extends('layouts.app')
@section('title', 'Edit Post')

@section('content')
<div class="page-header">
    <h2>Edit Post</h2>
    <p>Update your post details.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('posts.update', $post) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $post->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">No Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="body" class="form-control" rows="12" required>{{ old('body', $post->body) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <div class="mb-3">
    <label class="form-label">Tags</label>
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
        @foreach($tags as $tag)
        <label style="display:flex;align-items:center;gap:0.3rem;padding:0.3rem 0.75rem;
                      background:#f3f4f6;border-radius:20px;cursor:pointer;font-size:0.875rem;">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                   {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
            {{ $tag->name }}
        </label>
        @endforeach
    </div>
</div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-primary-custom">Save Changes</button>
                        <a href="{{ route('posts.index') }}"
                           style="padding:0.65rem 1.5rem;border-radius:10px;border:1px solid #e5e7eb;
                                  color:#374151;text-decoration:none;font-weight:600;font-size:0.9rem;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection