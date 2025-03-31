<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Blog extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable =
        [
            'title',
            'author',
            'content',
            'status',
            'blogcategory_id',
            'image'
        ];
    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blogcategory_id');
    }
}

