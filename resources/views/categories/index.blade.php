@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<div class="page-header">
    <h2>Categories</h2>
    <p>Manage blog post categories.</p>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    Add Category
                </h5>
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Technology" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="Optional description..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    All Categories
                </h5>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Posts</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td style="font-weight:500;color:#111827;">
                                    {{ $category->name }}
                                    @if($category->description)
                                    <div style="font-size:0.75rem;color:#9ca3af;">
                                        {{ $category->description }}
                                    </div>
                                    @endif
                                </td>
                                <td style="color:#6b7280;font-size:0.875rem;">
                                    {{ $category->slug }}
                                </td>
                                <td>
                                    <span class="badge-role badge-user">
                                        {{ $category->posts_count }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button style="font-size:0.8rem;padding:0.3rem 0.75rem;
                                                       border-radius:8px;border:1px solid #fca5a5;
                                                       color:#dc2626;background:transparent;
                                                       font-weight:500;cursor:pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center"
                                    style="color:#6b7280;padding:2rem;">
                                    No categories yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection