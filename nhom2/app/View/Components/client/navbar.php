<?php

namespace App\View\Components\client;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\BlogCategory;
use App\Models\Category;


class navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->userEmail = Auth::check() ? Auth::user()->email : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cartCount = auth()->check()
            ? Cart::where("user_id", auth()->id())->sum("quantity")
            : 0;
        $Categories = Category::all();
        $blogCategories = BlogCategory::all();
        return view(
            'components.client.navbar',
            [
                'cartCount' => $cartCount,
                'blogCategories' => $blogCategories,
                'Categories' => $Categories
            ]
        );
    }



    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
            ->paginate(9); // nên phân trang để đồng bộ

        // Lấy min và max giá để tạo khoảng giá
        $minPrice = Product::whereNotNull('sale_price')->min('sale_price');
        if ($minPrice === null) {
            $minPrice = Product::min('unit_price');
        }

        $maxPrice = Product::whereNotNull('sale_price')->max('sale_price');
        if ($maxPrice === null) {
            $maxPrice = Product::max('unit_price');
        }

        $priceSteps = [];
        $step = 50000;
        for ($i = floor($minPrice / $step) * $step; $i < $maxPrice; $i += $step) {
            $priceSteps[] = $i . '-' . ($i + $step);
        }

        $categories = \App\Models\Category::all();

        return view('client.pages.shop', [
            'products' => $products,
            'query' => $query,
            'priceSteps' => $priceSteps,
            'categories' => $categories,
            'selectedPrices' => [],
            'selectedCategories' => [],
        ]);
    }

}
