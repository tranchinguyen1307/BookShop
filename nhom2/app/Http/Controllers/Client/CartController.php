<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!",
                "redirect" => route("login"),
            ], 401);
        }

        $quantity = $request->input("quantity", 1);

        $request->validate([
            "product_id" => "required|exists:products,id",
            "quantity" => "integer|min:1",
        ]);

        $cartItem = Cart::where("user_id", auth()->id())
            ->where("product_id", $request->product_id)
            ->first();

        $product = Product::findOrFail($request->product_id);
        $quantityInCart = $cartItem ? $cartItem->quantity : 0;
        $maxQuantity = $product->quantity - $quantityInCart;
        
            if ($request->quantity > $maxQuantity) {
                return response()->json([
                    "message" => "Số lượng sản phẩm bạn muốn thêm vượt quá số lượng còn lại trong kho",
                ], 400);
            }

        if ($cartItem) {
            $cartItem->increment("quantity", $quantity);
        } else {
            Cart::create([
                "user_id" => auth()->id(),
                "product_id" => $request->product_id,
                "quantity" => $quantity,
            ]);
        }

        $cartCount = Cart::where("user_id", auth()->id())->sum("quantity");

        return response()->json([
            "message" => "Sản phẩm đã được thêm vào giỏ hàng!",
            "cart_count" => $cartCount,
            "max_quantity" => $maxQuantity,
        ]);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request)
    {
        $request->validate([
            "id" => "required|exists:carts,id",
            "quantity" => "integer|min:1",
        ]);

        $cartItem = Cart::where("id", $request->id)
            ->where("user_id", auth()->id())
            ->first();

        if ($cartItem) {
            $cartItem->update(["quantity" => $request->quantity]);
            $cartCount = Cart::where("user_id", auth()->id())->sum("quantity");
            return response()->json([
                "success" => true,
                "cart_count" => $cartCount,
            ]);
        }

        return response()->json(["success" => false, "message" => "Không tìm thấy sản phẩm!"], 404);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart(Request $request)
    {
        $request->validate([
            "id" => "required|exists:carts,id",
        ]);

        $cartItem = Cart::where("id", $request->id)
            ->where("user_id", auth()->id())
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            $cartCount = Cart::where("user_id", auth()->id())->sum("quantity");

            return response()->json(["success" => true, "cart_count" => $cartCount]);
        }

        return response()->json(["success" => false, "message" => "Không tìm thấy sản phẩm!"], 404);
    }

    public function index()
    {
        $cartItems = Cart::where("user_id", auth()->id())->with("product")->get();

        return view("client.pages.cart", ["cartItems" => $cartItems]);
    }
}
