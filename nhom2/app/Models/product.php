<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable =
    [
        'name',
        'description',
        'unit_price',
        'sale_price',
        'image',
        'category_id',
        'author',
        'short_description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function imagesList(): Attribute
    {
        return Attribute::get(fn() => $this->images->pluck('image')->toArray());
    }
}
