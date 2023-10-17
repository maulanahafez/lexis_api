<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'uid',
        'username',
        'email',
        'name',
        'bio',
        'story_preferences',
    ];

    public function stories()
    {
        return $this->hasMany(Story::class, 'user_id');
    }

    public function like()
    {
        return $this->hasOne(Like::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');
    }

    // public function follows()
    // {
    //     return $this->hasMany(Follow::class, 'user_id');
    // }

    // public function followers()
    // {
    //     return $this->hasMany(Follow::class, 'follower_id');
    // }

    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
}
