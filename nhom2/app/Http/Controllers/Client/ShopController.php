<?php
namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        // Lọc theo khoảng giá nếu có
        if ($request->has('unit_price')) {
            $priceRanges = $request->input('unit_price');
            $products->where(function ($query) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    [$min, $max] = explode('-', $range);
                    $query->orWhere(function ($subQuery) use ($min, $max) {
                        $subQuery->where(function ($q) use ($min, $max) {
                            $q->whereNotNull('sale_price')
                                ->whereBetween('sale_price', [(int) $min, (int) $max]);
                        })->orWhere(function ($q) use ($min, $max) {
                            $q->whereNull('sale_price')
                                ->whereBetween('unit_price', [(int) $min, (int) $max]);
                        });
                    });
                }
            });
        }

        // Lọc theo danh mục nếu có
        if ($request->has('category')) {
            $categories = $request->input('category');
            $products->whereIn('category_id', $categories); // Lọc theo nhiều danh mục
        }

        // Lấy sản phẩm phân trang
        $productsPaginated = $products->paginate(9);

        // Lấy min và max giá thực tế để sinh khoảng giá
        $minPrice = Product::whereNotNull('sale_price')->min('sale_price');
        if ($minPrice === null) {
            $minPrice = Product::min('unit_price');
        }

        $maxPrice = Product::whereNotNull('sale_price')->max('sale_price');
        if ($maxPrice === null) {
            $maxPrice = Product::max('unit_price');
        }

        // Tạo các khoảng giá
        $priceSteps = [];
        $step = 50000;
        for ($i = floor($minPrice / $step) * $step; $i < $maxPrice; $i += $step) {
            $priceSteps[] = $i . '-' . ($i + $step);
        }

        // Lấy danh sách tất cả các danh mục để hiển thị trong form lọc
        $categories = Category::all();

        return view('client.pages.shop', [
            'products' => $productsPaginated,
            'selectedPrices' => $request->input('unit_price', []),
            'priceSteps' => $priceSteps,
            'categories' => $categories, // Truyền danh mục vào view
            'selectedCategories' => $request->input('category', []), // Đánh dấu các danh mục đã chọn
        ]);
    }
}
