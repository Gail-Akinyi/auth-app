@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="page-header text-center">
    <h2>Contact Us</h2>
    <p>Have a question or feedback? We'd love to hear from you.</p>
</div>

<div class="row justify-content-center g-4">
    <div class="col-md-7">
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

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" placeholder="you@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control"
                                   value="{{ old('subject') }}" placeholder="What is this about?" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="6"
                                      placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-primary-custom w-100 text-center">
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom h-100">
            <div class="card-body">
                <h5 style="font-weight:700;color:#111827;margin-bottom:1.5rem;">Get in Touch</h5>

                <div style="display:flex;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:40px;height:40px;background:#ede9fe;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;
                                font-size:1.2rem;flex-shrink:0;">&#128231;</div>
                    <div>
                        <div style="font-weight:600;color:#111827;font-size:0.875rem;">Email</div>
                        <div style="color:#6b7280;font-size:0.875rem;">support@authapp.com</div>
                    </div>
                </div>

                <div style="display:flex;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:40px;height:40px;background:#ecfdf5;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;
                                font-size:1.2rem;flex-shrink:0;">&#9200;</div>
                    <div>
                        <div style="font-weight:600;color:#111827;font-size:0.875rem;">Response Time</div>
                        <div style="color:#6b7280;font-size:0.875rem;">Within 24 hours</div>
                    </div>
                </div>

                <div style="display:flex;gap:1rem;">
                    <div style="width:40px;height:40px;background:#fef3c7;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;
                                font-size:1.2rem;flex-shrink:0;">&#128205;</div>
                    <div>
                        <div style="font-weight:600;color:#111827;font-size:0.875rem;">Location</div>
                        <div style="color:#6b7280;font-size:0.875rem;">Nairobi, Kenya</div>
                    </div>
                </div>

                <hr style="margin:1.5rem 0;border-color:#f3f4f6;">

                <h6 style="font-weight:700;color:#111827;margin-bottom:1rem;">Newsletter</h6>
                <p style="color:#6b7280;font-size:0.875rem;margin-bottom:1rem;">
                    Subscribe to get the latest updates.
                </p>

                @if(session('newsletter_success'))
                    <div class="alert alert-success">{{ session('newsletter_success') }}</div>
                @else
                <form action="{{ route('newsletter.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="name" class="form-control"
                               placeholder="Your name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-2">
                        <input type="email" name="email" class="form-control"
                               placeholder="Your email" required>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 text-center">
                        Subscribe
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection