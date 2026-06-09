<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class ChartController extends Controller
{
    public function index()
    {
        // Users registered per month (last 6 months)
        $userStats = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'month' => $date->format('M Y'),
                'count' => User::whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count(),
            ];
        });

        // Posts published per month (last 6 months)
        $postStats = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'month' => $date->format('M Y'),
                'count' => Post::whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count(),
            ];
        });

        $totalUsers    = User::count();
        $totalPosts    = Post::count();
        $totalComments = Comment::count();
        $bannedUsers   = User::where('banned', true)->count();

        return view('admin.charts', compact(
            'userStats', 'postStats',
            'totalUsers', 'totalPosts', 'totalComments', 'bannedUsers'
        ));
    }
}