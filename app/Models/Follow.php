<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function follower()
    // {
    //     return $this->belongsTo(User::class, 'follower_id');
    // }
}