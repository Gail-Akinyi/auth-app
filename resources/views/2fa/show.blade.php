@extends('layouts.app')
@section('title', 'Two Factor Authentication')

@section('content')
<div class="page-header">
    <h2>Two Factor Authentication</h2>
    <p>Add an extra layer of security to your account.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
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

                @if(Auth::user()->two_factor_enabled)
                    <div class="text-center mb-4">
                        <div style="font-size:3rem;">&#128274;</div>
                        <h5 style="font-weight:700;color:#111827;margin-top:1rem;">
                            2FA is Enabled
                        </h5>
                        <p style="color:#6b7280;">
                            Your account is protected with two-factor authentication.
                        </p>
                    </div>
                    <form action="{{ route('2fa.disable') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Enter code to disable 2FA</label>
                            <input type="text" name="code" class="form-control"
                                   placeholder="6-digit code" maxlength="6" required>
                        </div>
                        <button type="submit"
                                style="padding:0.65rem 1.5rem;border-radius:10px;
                                       border:1px solid #fca5a5;color:#dc2626;background:transparent;
                                       font-weight:600;cursor:pointer;width:100%;">
                            Disable 2FA
                        </button>
                    </form>
                @else
                    <div class="text-center mb-4">
                        <div style="font-size:3rem;">&#128275;</div>
                        <h5 style="font-weight:700;color:#111827;margin-top:1rem;">
                            2FA is Disabled
                        </h5>
                        <p style="color:#6b7280;">
                            Scan the QR code below with Google Authenticator or Authy.
                        </p>
                    </div>

                    @if($qrCode)
<div class="text-center mb-4">
    <div style="display:inline-block;padding:1rem;background:white;
                border-radius:10px;border:1px solid #e5e7eb;">
        {!! base64_decode($qrCode) !!}
    </div>
    <p style="color:#6b7280;font-size:0.8rem;margin-top:0.5rem;">
        Scan with Google Authenticator or Authy
    </p>
</div>
@endif

                    <form action="{{ route('2fa.enable') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Enter the 6-digit code to confirm</label>
                            <input type="text" name="code" class="form-control"
                                   placeholder="6-digit code" maxlength="6" required>
                        </div>
                        <button type="submit" class="btn-primary-custom w-100 text-center">
                            Enable 2FA
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
