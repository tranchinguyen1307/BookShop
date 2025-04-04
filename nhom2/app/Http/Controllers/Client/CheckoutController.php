<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{

    public function process(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        $cartItems = Cart::whereIn('id', $selectedItems)->with('product')->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return ($item->product->sale_price ?? $item->product->unit_price) * $item->quantity;
        });

        $shippingFee = $totalPrice > 300000 ? 0 : 30000;

        $user = auth()->user();

        return view(
            'client.pages.checkout',
            [
                'cartItems' => $cartItems,
                'totalPrice' => $totalPrice,
                'shippingFee' => $shippingFee,
                'user' => $user,
            ]
        );
    }
}
