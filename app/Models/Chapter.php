<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id');
    }

    public function like()
    {
        return $this->hasOne(Like::class, 'chapter_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'chapter_id');
    }
}
