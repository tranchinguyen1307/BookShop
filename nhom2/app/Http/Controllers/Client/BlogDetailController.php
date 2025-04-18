<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogDetailController extends Controller
{
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        // Lấy các bài viết cùng danh mục, loại trừ bài hiện tại
        $relatedBlogs = Blog::where('blogcategory_id', $blog->blogcategory_id)
            ->where('id', '!=', $id)
            ->latest()
            ->take(5)
            ->get();

        return view(
            'client.pages.blogdetail',
            [
                'blog' => $blog,
                'relatedBlogs' => $relatedBlogs,
            ]
        );
    }
}
