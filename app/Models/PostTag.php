<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'post_tag_id', 'post_id');
    }
}