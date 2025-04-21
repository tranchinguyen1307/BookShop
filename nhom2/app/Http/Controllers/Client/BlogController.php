<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        // Lọc theo category nếu có
        if ($request->has('blogcategory_id')) {
            $query->where('blogcategory_id', $request->blogcategory_id);
        }

        $blogsPaginated = $query->paginate(6);

        // Lấy danh sách danh mục để hiển thị ở sidebar
        $categories = BlogCategory::all();

        return view('client.pages.blog', [
            'blogs' => $blogsPaginated,
            'categories' => $categories,
            'selectedCategory' => $request->blogcategory_id
        ]);
    }

}
