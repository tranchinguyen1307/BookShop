<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // Lịch sử đơn hàng chia theo trạng thái
    public function history()
    {
        $orders = auth()->user()->orders()->with('orderDetails.product')->latest()->get();
        $groupedOrders = $orders->groupBy('status');
        return view('client.pages.orders.order-history', compact('groupedOrders'));
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

}
