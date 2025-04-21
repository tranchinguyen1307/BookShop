<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'blog_id', // hoặc post_id tùy vào hệ thống của bạn
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(blog::class);
    }
}

