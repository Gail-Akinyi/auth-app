<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; padding-top: 0; }

        .navbar-custom {
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    padding: 0.85rem 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    z-index: 1000;
}
        .navbar-brand-custom {
            font-weight: 700;
            font-size: 1.3rem;
            color: #111827;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .navbar-brand-custom span {
            color: #4f46e5;
        }
        .nav-btn {
            padding: 0.45rem 1.1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        .nav-btn-outline {
            border: 1px solid #e5e7eb;
            color: #374151;
            background: transparent;
        }
        .nav-btn-outline:hover {
            background: #f9fafb;
            color: #111827;
        }
        .nav-btn-primary {
            background: #4f46e5;
            color: white;
            border: 1px solid #4f46e5;
        }
        .nav-btn-primary:hover {
            background: #4338ca;
            color: white;
        }
        .nav-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-user:hover { background: #f9fafb; color: #111827; }
        .nav-avatar {
            width: 28px; height: 28px;
            background: #4f46e5;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.75rem; font-weight: 600;
        }
        .btn-logout {
            padding: 0.45rem 1.1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            background: transparent;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: #fee2e2; border-color: #fca5a5; color: #dc2626; }

        .main-content { padding: 2.5rem 1.5rem; max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }

        .card-custom {
    background: white;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
    position: relative;
    z-index: 2;
}
        .card-custom .card-body { padding: 2rem; }

        .btn-primary-custom {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary-custom:hover { background: #4338ca; color: white; transform: translateY(-1px); }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-label { font-weight: 500; font-size: 0.875rem; color: #374151; margin-bottom: 0.4rem; }

        .alert { border-radius: 10px; border: none; font-size: 0.875rem; }
        .alert-success { background: #ecfdf5; color: #065f46; }
        .alert-danger { background: #fef2f2; color: #991b1b; }

        .stat-card {
            border-radius: 14px;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        .stat-card .stat-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: 1rem;
        }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; color: #111827; }
        .stat-card .stat-label { font-size: 0.8rem; color: #6b7280; font-weight: 500; margin-top: 0.2rem; }

        .table { font-size: 0.875rem; }
        .table thead th {
            background: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.85rem 1rem;
        }
        .table tbody td { padding: 0.85rem 1rem; vertical-align: middle; border-color: #f3f4f6; }
        .table tbody tr:hover { background: #fafafa; }

        .badge-role {
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-admin { background: #ede9fe; color: #5b21b6; }
        .badge-user { background: #f3f4f6; color: #374151; }

        .page-header { margin-bottom: 2rem; }
        .page-header h2 { font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0; }
        .page-header p { color: #6b7280; margin: 0.3rem 0 0; font-size: 0.9rem; }
    </style>
</head>
<body>

<nav class="navbar-custom d-flex align-items-center justify-content-between">
    <a class="navbar-brand-custom" href="/">Auth<span>App</span></a>
    <div class="d-flex align-items-center gap-2">
        @auth
            <a href="{{ route('profile.show') }}" class="nav-user">
                <div class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                {{ Auth::user()->name }}
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn-logout">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-btn nav-btn-outline">Login</a>
            <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Register</a>
        @endauth
    </div>
</nav>

<div class="main-content">
    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    @yield('content')
</div>

</body>
</html>