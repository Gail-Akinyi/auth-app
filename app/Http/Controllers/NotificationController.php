<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        Auth::user()->unreadNotifications()->update(['read' => true]);
        return view('notifications.index', compact('notifications'));
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted!');
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        return back()->with('success', 'All notifications cleared!');
    }
}