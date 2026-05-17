@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-2">Forgot Password?</h4>
                <p class="text-muted mb-4">Enter your email and we'll send you a reset link.</p>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        Send Reset Link
                    </button>
                </form>

                <p class="text-center mt-3 mb-0">
                    <a href="{{ route('login') }}">← Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection