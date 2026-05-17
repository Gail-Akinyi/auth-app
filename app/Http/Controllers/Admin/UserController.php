<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:user,admin',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('dashboard')->with('success', 'User deleted successfully.');
    }

    public function export(Request $request)
{
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

    $users = $query->get();

    $filename = 'users_' . now()->format('Y_m_d_His') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function() use ($users) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Joined']);

        foreach ($users as $user) {
            fputcsv($file, [
                $user->id,
                $user->name,
                $user->email,
                ucfirst($user->role),
                $user->created_at->format('Y-m-d'),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}