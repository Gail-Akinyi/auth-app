<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
                     ->where('status', 'published')
                     ->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $posts      = $query->paginate(6)->withQueryString();
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'required|in:draft,published',
            'excerpt'     => 'nullable|string|max:500',
        ]);

        Post::create([
            'user_id'      => Auth::id(),
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Post::generateSlug($request->title),
            'excerpt'      => $request->excerpt,
            'body'         => $request->body,
            'status'       => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if (!Auth::user()->isAdmin() && $post->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if (!Auth::user()->isAdmin() && $post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'required|in:draft,published',
            'excerpt'     => 'nullable|string|max:500',
        ]);

        $post->update([
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'excerpt'      => $request->excerpt,
            'body'         => $request->body,
            'status'       => $request->status,
            'published_at' => $request->status === 'published' && !$post->published_at ? now() : $post->published_at,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (!Auth::user()->isAdmin() && $post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function myPosts()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->paginate(10);
        return view('posts.my-posts', compact('posts'));
    }
}