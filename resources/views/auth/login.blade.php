@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mb-4">
            <h2 style="font-weight:700;color:#111827;">Welcome back</h2>
            <p style="color:#6b7280;">Sign in to your account</p>
        </div>

        <div class="card-custom">
            <div class="card-body">

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

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Password</label>
                            <a href="{{ route('password.request') }}"
                               style="font-size:0.8rem;color:#4f46e5;text-decoration:none;">
                               Forgot password?
                            </a>
                        </div>
                        <input type="password" name="password" class="form-control mt-1"
                               placeholder="••••••••" required>
                    </div>
                    <div class="mb-4 d-flex align-items-center gap-2">
                        <input type="checkbox" name="remember" id="remember"
                               style="width:16px;height:16px;accent-color:#4f46e5;">
                        <label for="remember" style="font-size:0.875rem;color:#374151;margin:0;">
                            Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Sign in
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-4" style="font-size:0.875rem;color:#6b7280;">
            Don't have an account?
            <a href="{{ route('register') }}"
               style="color:#4f46e5;font-weight:600;text-decoration:none;">Sign up</a>
        </p>
    </div>
</div>
@endsection