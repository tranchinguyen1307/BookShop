<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'blog_id' => 'required|exists:blogs,id',
        ]);

        $userId = Auth::id();
        $cacheKey = 'last_comment_time_user_' . $userId;

        // Nếu người dùng đã gửi bình luận trong 30 giây qua
        if (Cache::has($cacheKey)) {
            return redirect()->back()->with('error', 'Bạn đang gửi quá nhanh, vui lòng chờ một chút.');
        }

        // Lưu thời gian gửi bình luận vào cache (hết hạn sau 30 giây)
        Cache::put($cacheKey, now(), now()->addSeconds(30));

        Comment::create([
            'user_id' => $userId,
            'blog_id' => $request->blog_id,
            'content' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi!');
    }


    public function update(Request $request, $id)
    {
        $request->validate(['comment' => 'required|string']);
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->update(['content' => $request->comment]);

        // Trả JSON cho JS xử lý
        return response()->json([
            'success' => true,
            'content' => $comment->content
        ]);
    }


    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Đã xóa bình luận!');
    }
}
