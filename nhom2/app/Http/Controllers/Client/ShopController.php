<?php
namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view(

            'client.pages.shop',
            [
                'products' => $products
            ]
        );
    }
}
