@extends('layouts.app')
@section('title', 'Access Denied')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 text-center">
        <div class="card-custom">
            <div class="card-body" style="padding:3rem 2rem;">
                <div style="font-size:3.5rem;margin-bottom:1rem;">🚫</div>
                <h1 style="font-size:4rem;font-weight:800;color:#111827;margin:0;">403</h1>
                <h4 style="font-weight:700;color:#111827;margin:0.5rem 0;">Access Denied</h4>
                <p style="color:#6b7280;margin:1rem 0 2rem;font-size:0.9rem;">
                    You don't have permission to view this page.
                    This area is restricted to administrators only.
                </p>
                <a href="{{ route('dashboard') }}" class="btn-primary-custom">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection