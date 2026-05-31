<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function activityLogs()
{
    return $this->hasMany(ActivityLog::class)->latest()->limit(10);
}
public function posts()
{
    return $this->hasMany(Post::class);
}
public function comments()
{
    return $this->hasMany(Comment::class);
}

public function likes()
{
    return $this->hasMany(PostLike::class);
}

public function notifications()
{
    return $this->hasMany(Notification::class)->latest();
}

public function unreadNotifications()
{
    return $this->hasMany(Notification::class)->where('read', false);
}

public function getAvatarUrlAttribute()
{
    return $this->avatar
        ? asset('storage/' . $this->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4f46e5&color=fff';
}
}