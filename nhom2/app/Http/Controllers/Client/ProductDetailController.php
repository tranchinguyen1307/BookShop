<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id); 
        $relatedProducts = Product::where('category_id', $product->category_id)
                              ->where('id', '!=', $product->id)
                              ->limit(6)
                              ->get();
        return view('client.pages.productdetail',
        [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]); 
    }
    
  
}
