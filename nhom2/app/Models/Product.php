<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
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
        'quantity'
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
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function averageRating(): Attribute
    {
        return Attribute::get(fn() => round($this->reviews()->avg('rating'), 1));
    }

    public function reviewsCount(): Attribute
    {
        return Attribute::get(fn() => $this->reviews()->count());
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if (! $product->isForceDeleting()) {
                Cart::where('product_id', $product->id)->delete();
            }
        });
    }
}
