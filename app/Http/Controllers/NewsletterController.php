<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name'  => 'nullable|string|max:255',
        ]);

        NewsletterSubscriber::create($request->only('email', 'name'));

        return back()->with('newsletter_success', 'You have successfully subscribed to our newsletter!');
    }

    public function index()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(10);
        return view('newsletter.index', compact('subscribers'));
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();
        return back()->with('success', 'Subscriber removed.');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::where('active', true)->get();
        $filename    = 'subscribers_' . now()->format('Y_m_d') . '.csv';
        $headers     = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="' . $filename . '"'];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Subscribed At']);
            foreach ($subscribers as $sub) {
                fputcsv($file, [$sub->id, $sub->name, $sub->email, $sub->created_at->format('Y-m-d')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}