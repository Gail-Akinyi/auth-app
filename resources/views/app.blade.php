<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="/">AuthApp</a>
    <div class="ms-auto">
        @auth
            <span class="text-white me-3">Hello, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
        @endauth
    </div>
</nav>

<div class="container mt-5">
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @yield('content')
</div>

</body>
</html>