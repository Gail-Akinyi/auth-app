<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
    $query = User::latest();

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('role') && in_array($request->role, ['admin', 'user'])) {
        $query->where('role', $request->role);
    }

    $users = $query->paginate(10)->withQueryString();
    $logs  = \App\Models\ActivityLog::with('user')->latest()->take(10)->get();

    return view('dashboard.admin', compact('user', 'users', 'logs'));
}

        return view('dashboard.user', compact('user'));
    }
}