@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="page-header">
    <h2>Edit User</h2>
    <p>Update the details for {{ $user->name }}.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
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

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                General User
                            </option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-primary-custom">
                            Save Changes
                        </button>
                        <a href="{{ route('dashboard') }}"
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