@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2>My Dashboard</h2>
    <p>Welcome back, {{ $user->name }}!</p>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card-custom h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:56px;height:56px;background:#ede9fe;border-radius:14px;
                                display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        👤
                    </div>
                    <div>
                        <h5 style="font-weight:700;color:#111827;margin:0;">{{ $user->name }}</h5>
                        <p style="color:#6b7280;margin:0;font-size:0.875rem;">{{ $user->email }}</p>
                    </div>
                </div>
                <div style="background:#f9fafb;border-radius:10px;padding:1rem;">
                    <div class="d-flex justify-content-between mb-2">
                        <span style="font-size:0.8rem;color:#6b7280;font-weight:500;">Account Type</span>
                        <span class="badge-role badge-user">General User</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="font-size:0.8rem;color:#6b7280;font-weight:500;">Member Since</span>
                        <span style="font-size:0.8rem;color:#374151;font-weight:500;">
                            {{ $user->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom h-100">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1rem;">Quick Actions</h5>
                <a href="{{ route('profile.show') }}"
                   style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem 1rem;
                          border-radius:10px;border:1px solid #e5e7eb;text-decoration:none;
                          color:#374151;font-weight:500;font-size:0.875rem;transition:all 0.2s;
                          margin-bottom:0.75rem;">
                    <span style="font-size:1.1rem;">✏️</span> Edit Profile
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem 1rem;
                                   border-radius:10px;border:1px solid #fca5a5;background:transparent;
                                   color:#dc2626;font-weight:500;font-size:0.875rem;cursor:pointer;
                                   width:100%;transition:all 0.2s;">
                        <span style="font-size:1.1rem;">🚪</span> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection