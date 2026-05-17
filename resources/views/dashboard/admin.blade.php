@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
@endif

<div class="page-header">
    <h2>Dashboard</h2>
    <p>Welcome back, {{ $user->name }}. Here's what's happening.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#ede9fe;">&#128101;</div>
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#fef3c7;">&#128081;</div>
            <div class="stat-value">{{ \App\Models\User::where('role','admin')->count() }}</div>
            <div class="stat-label">Administrators</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-white">
            <div class="stat-icon" style="background:#ecfdf5;">&#9989;</div>
            <div class="stat-value">{{ \App\Models\User::where('role','user')->count() }}</div>
            <div class="stat-label">General Users</div>
        </div>
    </div>
</div>

<div class="card-custom mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Search Users</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name or email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filter by Role</label>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>General User</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-primary-custom flex-fill text-center">Search</button>
                    <a href="{{ route('dashboard') }}"
                       style="padding:0.65rem 1rem;border-radius:10px;border:1px solid #e5e7eb;
                              color:#374151;text-decoration:none;font-weight:600;font-size:0.9rem;
                              white-space:nowrap;">Clear</a>
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 style="font-weight:700;color:#111827;margin:0;">Registered Users</h5>
                <small style="color:#6b7280;">
                    Showing {{ $users->firstItem() }}-{{ $users->lastItem() }}
                    of {{ $users->total() }} users
                </small>
            </div>
            <a href="{{ route('admin.users.export') }}"
               style="font-size:0.85rem;padding:0.5rem 1rem;border-radius:8px;
                      background:#ecfdf5;color:#065f46;text-decoration:none;
                      font-weight:600;border:1px solid #6ee7b7;white-space:nowrap;">
                Export CSV
            </a>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td style="color:#9ca3af;">{{ $u->id }}</td>
                        <td style="font-weight:500;color:#111827;">{{ $u->name }}</td>
                        <td style="color:#6b7280;">{{ $u->email }}</td>
                        <td>
                            <span class="badge-role {{ $u->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td style="color:#6b7280;">{{ $u->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.edit', $u->id) }}"
                                   style="font-size:0.8rem;padding:0.3rem 0.75rem;border-radius:8px;
                                          border:1px solid #e5e7eb;color:#374151;text-decoration:none;
                                          font-weight:500;">Edit</a>
                                @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $u->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button style="font-size:0.8rem;padding:0.3rem 0.75rem;
                                                   border-radius:8px;border:1px solid #fca5a5;
                                                   color:#dc2626;background:transparent;
                                                   font-weight:500;cursor:pointer;">Delete</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color:#6b7280;padding:2rem;">
                            No users found matching your search.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

<div class="card-custom">
    <div class="card-body">
        <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">Recent Activity</h5>
        @forelse($logs as $log)
        <div style="display:flex;align-items:flex-start;gap:1rem;padding:0.85rem 0;
                    border-bottom:1px solid #f3f4f6;">
            <div style="width:36px;height:36px;border-radius:50%;
                        background:{{ $log->action === 'login' ? '#ecfdf5' : '#fef2f2' }};
                        display:flex;align-items:center;justify-content:center;
                        font-size:1rem;flex-shrink:0;">
                {{ $log->action === 'login' ? '&#9989;' : '&#128682;' }}
            </div>
            <div style="flex:1;">
                <div style="font-size:0.875rem;font-weight:500;color:#111827;">
                    {{ $log->user->name ?? 'Unknown' }}
                    <span style="font-weight:400;color:#6b7280;">{{ $log->description }}</span>
                </div>
                <div style="font-size:0.75rem;color:#9ca3af;margin-top:0.2rem;">
                    {{ $log->created_at->diffForHumans() }} &middot; {{ $log->ip_address }}
                </div>
            </div>
            <span style="font-size:0.75rem;padding:0.25rem 0.6rem;border-radius:20px;
                         background:{{ $log->action === 'login' ? '#ecfdf5' : '#fef2f2' }};
                         color:{{ $log->action === 'login' ? '#065f46' : '#991b1b' }};
                         font-weight:600;">
                {{ ucfirst($log->action) }}
            </span>
        </div>
        @empty
        <p style="color:#6b7280;font-size:0.875rem;text-align:center;padding:1rem 0;">
            No activity recorded yet.
        </p>
        @endforelse
    </div>
</div>

@endsection