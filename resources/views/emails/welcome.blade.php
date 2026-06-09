<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background:#f0f2f5; margin:0; padding:20px; }
        .container { max-width:600px; margin:0 auto; background:white; border-radius:16px; overflow:hidden; }
        .header { background:#4f46e5; padding:40px; text-align:center; }
        .header h1 { color:white; margin:0; font-size:1.8rem; font-weight:700; }
        .body { padding:40px; }
        .body h2 { color:#111827; font-weight:700; }
        .body p { color:#6b7280; line-height:1.6; }
        .btn { display:inline-block; background:#4f46e5; color:white; padding:12px 30px;
               border-radius:10px; text-decoration:none; font-weight:600; margin:20px 0; }
        .footer { padding:20px 40px; background:#f9fafb; text-align:center; }
        .footer p { color:#9ca3af; font-size:0.8rem; margin:0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>&#127881; Welcome to AuthApp!</h1>
        </div>
        <div class="body">
            <h2>Hi {{ $user->name }}!</h2>
            <p>Thank you for joining AuthApp. Your account has been successfully created.</p>
            <p>Here are your account details:</p>
            <p><strong>Email:</strong> {{ $user->email }}<br>
               <strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p>You can now log in and start exploring all the features we have to offer.</p>
            <a href="{{ url('/login') }}" class="btn">Go to Dashboard</a>
            <p>If you have any questions feel free to <a href="{{ url('/contact') }}" style="color:#4f46e5;">contact us</a>.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AuthApp. All rights reserved.</p>
        </div>
    </div>
</body>
</html>