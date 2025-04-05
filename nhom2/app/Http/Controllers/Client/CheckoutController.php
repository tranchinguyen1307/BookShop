<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{

    public function process(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        if ($selectedItems) {
            session(['selected_items' => $selectedItems]);
        }
      
        $id = session('selected_items', []);
        if (empty($id)) {
            return redirect()->back()->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }
        $cartItems = Cart::whereIn('id', $id)->with('product')->get();

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

    public function storeOrder(CheckoutRequest $request)
    {
        // Lấy các sản phẩm đã chọn từ giỏ hàng
        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        // Lấy các thông tin đã tính toán từ trang thanh toán
        $totalPrice = $request->input('totalPrice');
        $shippingFee = $request->input('shippingFee');
        $user = auth()->user();

        if ($request->input('address')) {
            $address = $request->input('address');
        } else {
            $address = "{$request->address}, {$request->ward}, {$request->district}, {$request->province}";
        }

        $paymentMethod = $request->input('payment');
        $phone = $request->input('phone');

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice + $shippingFee,
            'shipping_fee' => $shippingFee,
            'address' => $address,
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'phone'  => $phone
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($selectedItems as $cartItemId) {
            $cartItem = Cart::find($cartItemId);
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->sale_price ?? $cartItem->product->unit_price,
            ]);

            $product = $cartItem->product;
            $product->quantity -= $cartItem->quantity;
            $product->save();

        }

     

        // Xóa các sản phẩm đã thanh toán khỏi giỏ hàng
        Cart::whereIn('id', $selectedItems)->delete();
        session()->forget('selected_items');

        return view('client.pages.thank_you', ['order' => $order]);
    }
}
