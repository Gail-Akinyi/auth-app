@extends('layouts.app')
@section('title', 'Create Post')

@section('content')
<div class="page-header">
    <h2>Create New Post</h2>
    <p>Share your thoughts with the community.</p>
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

                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title') }}"
                               placeholder="Enter post title..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">No Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Excerpt <small style="color:#9ca3af;">(short summary)</small></label>
                        <textarea name="excerpt" class="form-control" rows="2"
                                  placeholder="Brief description of your post...">{{ old('excerpt') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="body" class="form-control" rows="12"
                                  placeholder="Write your post content here..." required>{{ old('body') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <div class="mb-3">
    <label class="form-label">Tags</label>
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
        @foreach($tags as $tag)
        <label style="display:flex;align-items:center;gap:0.3rem;padding:0.3rem 0.75rem;
                      background:#f3f4f6;border-radius:20px;cursor:pointer;font-size:0.875rem;">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
            {{ $tag->name }}
        </label>
        @endforeach
    </div>
    @if($tags->isEmpty())
    <small style="color:#9ca3af;">No tags yet. Ask an admin to create some.</small>
    @endif
</div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                Published
                            </option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-primary-custom">Publish Post</button>
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