<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Requests\Client\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        $userId = Auth::id(); 
        Review::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'user_id' => $userId,
            'rating' => $request->rating,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Cảm ơn bạn đã đánh giá',
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
        ]);
    }
}

