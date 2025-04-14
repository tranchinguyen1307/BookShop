<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function history()
    {
        $orders = Order::where('user_id', auth()->id())->get()->groupBy('status');


        $orderedStatuses = collect([0, 1, 2, 3, 4])->mapWithKeys(function ($status) use ($orders) {
            return [$status => $orders->get($status, collect())];
        });

        return view('client.pages.orders.order-history', [
            'groupedOrders' => $orderedStatuses,
        ]);
    }

    // Xem chi tiết một đơn hàng
    public function show($id)
    {
        $order = auth()->user()->orders()->with('orderDetails.product')->findOrFail($id);
        return view('client.pages.orders.order-details', compact('order'));
    }
    public function cancel(Order $order)
    {
        if ($order->status == 0) {
            $order->status = 4; // Đã hủy
            $order->save();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
    }
    public function markAsReceived(Order $order)
    {
        if (in_array($order->status, [1, 2])) {
            $order->status = 3; // Đã nhận hàng
            $order->save();
        }

        return redirect()->route('orders.history')->with('success', 'Cảm ơn bạn đã xác nhận đã nhận hàng.');
    }

}
