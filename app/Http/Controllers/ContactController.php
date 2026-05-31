<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact.show');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($request->only('name', 'email', 'subject', 'message'));

        return back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);
        return view('contact.index', compact('messages'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'Message marked as read.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }
}