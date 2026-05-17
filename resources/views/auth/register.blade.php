@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mb-4">
            <h2 style="font-weight:700;color:#111827;">Create an account</h2>
            <p style="color:#6b7280;">Join us today, it's free</p>
        </div>

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

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Min. 6 characters" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Account Type</label>
                        <select name="role" class="form-select">
                            <option value="user">General User</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Create account
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-4" style="font-size:0.875rem;color:#6b7280;">
            Already have an account?
            <a href="{{ route('login') }}"
               style="color:#4f46e5;font-weight:600;text-decoration:none;">Sign in</a>
        </p>
    </div>
</div>
@endsection