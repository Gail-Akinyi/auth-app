<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function toggle(Post $post)
    {
        $existing = PostLike::where('user_id', Auth::id())
                            ->where('post_id', $post->id)
                            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            PostLike::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);

            // Notify post author
            if ($post->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'type'    => 'like',
                    'message' => Auth::user()->name . ' liked your post "' . $post->title . '"',
                    'link'    => route('posts.show', $post),
                ]);
            }
        }

        return back();
    }
}