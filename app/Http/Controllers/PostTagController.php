<?php
namespace App\Http\Controllers;
use App\Models\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostTagController extends Controller
{
    public function index()
    {
        $tags = PostTag::withCount('posts')->get();
        return view('tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:post_tags']);
        PostTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Tag created!');
    }

    public function destroy(PostTag $postTag)
    {
        $postTag->delete();
        return back()->with('success', 'Tag deleted!');
    }
}