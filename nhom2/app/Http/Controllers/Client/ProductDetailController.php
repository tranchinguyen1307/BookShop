<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Review;

class ProductDetailController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        $quantityInCart = $cartItem ? $cartItem->quantity : 0;
        $maxQuantity = $product->quantity - $quantityInCart;


        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();

        $rating = $product->reviews()->avg('rating'); // Điểm trung bình

        $totalReviews = $product->reviews()->count(); // Tổng số đánh giá

        return view(
            'client.pages.productdetail',
            [
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'MaxQuantity' => $maxQuantity,
                'rating' => $rating,
                'totalReviews' => $totalReviews
            ]
        );
    }
}
