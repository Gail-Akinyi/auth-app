<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        \App\Models\ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'login',
            'description' => 'User logged in',
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'These credentials do not match our records.',
    ]);
}

    public function logout(Request $request)
{
    \App\Models\ActivityLog::create([
        'user_id'     => Auth::id(),
        'action'      => 'logout',
        'description' => 'User logged out',
        'ip_address'  => $request->ip(),
    ]);

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}
}