<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class HomeController extends Controller
{
    public function index()
    {
        $recent_products = Product::where('quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        $sale_products = Product::where('quantity', '>', 0)
            ->whereNotNull('sale_price')
            ->limit(8)
            ->get();
        $categories = Category::withCount('products')->limit(8)->get();
        return view(
            'client.pages.home',
            [
                'recent_products' => $recent_products,
                'sale_products' => $sale_products,
                'categories' => $categories
            ]
        );
    }
}
