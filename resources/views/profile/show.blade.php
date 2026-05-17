@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="page-header">
    <h2>My Profile</h2>
    <p>Manage your account information and password.</p>
</div>

<div class="row g-4">

    {{-- Profile Info --}}
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    Personal Information
                </h5>

                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
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
                    <div class="mb-3">
                        <label class="form-label">Account Type</label>
                        <div style="padding:0.65rem 1rem;background:#f9fafb;border-radius:10px;
                                    border:1px solid #e5e7eb;font-size:0.875rem;color:#374151;">
                            <span class="badge-role {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Member Since</label>
                        <div style="padding:0.65rem 1rem;background:#f9fafb;border-radius:10px;
                                    border:1px solid #e5e7eb;font-size:0.875rem;color:#6b7280;">
                            {{ $user->created_at->format('F d, Y') }}
                        </div>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">
                    Change Password
                </h5>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password"
                               class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password"
                               class="form-control" placeholder="Min. 6 characters" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection