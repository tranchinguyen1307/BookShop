<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $recent_products = Product::all();
        return view(
            'client.pages.home',
            [
                'recent_products' => $recent_products
            ]
        );
    }
}
