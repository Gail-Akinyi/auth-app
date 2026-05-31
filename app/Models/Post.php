<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug',
        'excerpt', 'body', 'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function generateSlug($title)
    {
        return Str::slug($title) . '-' . uniqid();
    }
    public function comments()
{
    return $this->hasMany(Comment::class)->latest();
}

public function likes()
{
    return $this->hasMany(PostLike::class);
}

public function tags()
{
    return $this->belongsToMany(PostTag::class, 'post_tag', 'post_id', 'post_tag_id');
}

public function isLikedBy($user)
{
    return $this->likes()->where('user_id', $user->id)->exists();
}
}