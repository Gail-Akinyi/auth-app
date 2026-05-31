<?php
namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string|max:1000']);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'body'    => $request->body,
        ]);

        // Notify post author
        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'type'    => 'comment',
                'message' => Auth::user()->name . ' commented on your post "' . $post->title . '"',
                'link'    => route('posts.show', $post),
            ]);
        }

        return back()->with('success', 'Comment added!');
    }

    public function destroy(Comment $comment)
    {
        if (!Auth::user()->isAdmin() && $comment->user_id !== Auth::id()) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'Comment deleted!');
    }
}