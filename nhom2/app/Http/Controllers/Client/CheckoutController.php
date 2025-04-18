<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Http;
use App\Models\User;


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

        // Lấy các thông tin đã tính toán từ trang thanh toán
        $totalPrice = $request->input('totalPrice');
        $shippingFee = $request->input('shippingFee');
        $user = auth()->user();
        $address = $request->input('address');

        $paymentMethod = $request->input('payment');
        $phone = $request->input('phone');
        if ($paymentMethod == 1) // thanh toán bình thường
        {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice + $shippingFee,
                'shipping_fee' => $shippingFee,
                'address' => $address,
                'payment_method' => $paymentMethod,
                'status' => 0,
                'phone' => $phone,
                'order_code' => 'MDH-' . uniqid()
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

            return view('client.pages.thank_you');
        } else if ($paymentMethod == 2) {

            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = env('MOMO_PARTNER_CODE');
            $accessKey = env('MOMO_ACCESS_KEY');
            $secretKey = env('MOMO_SECRET_KEY');
            $orderId = 'MDH-' . uniqid();
            $requestId = time() . "";
            $amount = $totalPrice + $shippingFee;
            $orderInfo = "Thanh toán đơn hàng MoMo";
            $redirectUrl = env('MOMO_REDIRECT_URL');
            $ipnUrl = env('MOMO_IPN_URL');
            $extraData = json_encode([
                'selected_items' => $request->input('selected_items', []),
                'totalPrice' => $request->input('totalPrice'),
                'shippingFee' => $request->input('shippingFee'),
                'address' => $request->input('address')
                    ?? "{$request->address}, {$request->ward}, {$request->district}, {$request->province}",
                'payment' => $request->input('payment'),
                'phone' => $request->input('phone'),
                'user_id' => auth()->user() ? auth()->user()->id : null,
            ]);

            $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType=captureWallet";
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = [
                'partnerCode' => $partnerCode,
                'accessKey' => $accessKey,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'extraData' => $extraData,
                'requestType' => 'captureWallet',
                'signature' => $signature,
                'lang' => 'vi'
            ];

            // Gửi yêu cầu đến Momo
            $response = Http::post($endpoint, $data);
            $result = $response->json();

            if (!empty($result['payUrl'])) {
                return redirect($result['payUrl']);
            }

            return redirect()->back()->with('error', 'Không thể tạo thanh toán MoMo.');
        }
    }

    private function verifySignature($data)
    {
        $signature = $data['signature'];

        return true;
    }

    public function handleIPN(Request $request)
    {
        $data = $request->all();

        if (!$this->verifySignature($data)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        if ($data['resultCode'] != 0) {
            // Giải mã extraData thành mảng
            $extraData = json_decode($data['extraData'], true);
            $orderId = $data['orderId'];

            // Kiểm tra nếu extraData là mảng
            if (!is_array($extraData)) {
                return response()->json(['message' => 'extraData không hợp lệ'], 400);
            }

            // Lấy các giá trị từ extraData
            $address = $extraData['address'];  // Địa chỉ người dùng
            $totalPrice = $extraData['totalPrice']; // Tổng giá trị đơn hàng
            $shippingFee = $extraData['shippingFee']; // Phí vận chuyển
            $selectedItems = $extraData['selected_items']; // Các sản phẩm đã chọn trong giỏ hàng (mảng ID sản phẩm)
            $phone = $extraData['phone']; // Số điện thoại người dùng
            $user_id = $extraData['user_id'];

            // Lấy thông tin người dùng
            $user = User::find($user_id);

            if (!$user) {
                return response()->json(['message' => 'Người dùng không hợp lệ'], 400);
            }

            // Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice + $shippingFee,
                'shipping_fee' => $shippingFee,
                'status' => 2, // Đơn hàng đã thanh toán
                'address' => $address,
                'payment_method' => 2, // Momo
                'phone' => $phone,
                'momo_order_id' => $data['orderId'],  // Lưu mã đơn hàng từ MoMo
                'created_at' => now(),
                'updated_at' => now(),
                'order_code' => $orderId
            ]);

            // Lấy thông tin sản phẩm từ Cart dựa trên ID
            $cartItems = Cart::whereIn('id', $selectedItems)->with('product')->get();

            // Lưu chi tiết đơn hàng và giảm số lượng sản phẩm
            foreach ($cartItems as $cartItem) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->sale_price ?? $cartItem->product->unit_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Giảm số lượng sản phẩm trong kho
                $product = $cartItem->product;
                $product->quantity -= $cartItem->quantity;
                $product->save();
            }

            // Xóa các sản phẩm đã thanh toán khỏi giỏ hàng
            Cart::whereIn('id', $selectedItems)->delete();
            session()->forget('selected_items');
        }
    }

    public function thanks()
    {
        return view('client.pages.thank_you');
    }
}
