<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{

    public function history()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderDetails.product')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        $orderedStatuses = collect([0, 1, 2, 3, 4])->mapWithKeys(function ($status) use ($orders) {
            $perPage = 5;
            $currentPage = request()->get("page_{$status}", 1);
            $items = $orders->get($status, collect());
            $pagedItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginator = new LengthAwarePaginator(
                $pagedItems,
                $items->count(),
                $perPage,
                $currentPage,
                ['pageName' => "page_{$status}", 'path' => request()->url()]
            );

            return [$status => $paginator];
        });

        return view('client.pages.orders.order-history', [
            'groupedOrders' => $orderedStatuses,
        ]);
    }


    // Xem chi tiết một đơn hàng
    public function show($id)
    {
        $order = auth()->user()->orders()->with('orderDetails.product')->findOrFail($id);
        foreach ($order->orderDetails as $item) {
            $item->alreadyReviewed = $item->product->reviews()
                ->where('user_id', auth()->id())
                ->where('order_id', $order->id)
                ->exists();
        }
        return view('client.pages.orders.order-details', compact('order'));
    }

    public function cancel(Order $order, Request $request)
    {
        // Kiểm tra trạng thái đơn hàng
        if ($order->status == 0) {
            // Kiểm tra nếu có lý do hủy được gửi lên
            $validatedData = $request->validate([
                'cancellation_reason' => 'required|string|max:255',
            ]);

            // Sử dụng transaction để đảm bảo tính nhất quán
            DB::beginTransaction();
            try {
                // Cập nhật trạng thái đơn hàng thành đã hủy (status = 4)
                $order->status = 4;

                // Lưu lý do hủy vào cơ sở dữ liệu
                $order->cancellation_reason = $validatedData['cancellation_reason'];

                // Duyệt qua từng chi tiết đơn hàng (order_details) để hoàn lại số lượng
                foreach ($order->orderDetails as $detail) {
                    $product = $detail->product; // Lấy sản phẩm từ chi tiết đơn hàng
                    $product->increment('quantity', $detail->quantity); // Tăng số lượng sản phẩm lại vào kho
                }

                // Lưu thay đổi trong đơn hàng
                $order->save();

                // Commit transaction
                DB::commit();

                return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công và số lượng sản phẩm đã được hoàn lại.');
            } catch (\Exception $e) {
                // Rollback nếu có lỗi xảy ra
                DB::rollBack();
                return redirect()->back()->with('error', 'Đã xảy ra lỗi khi hủy đơn hàng.');
            }
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
    }





    public function markAsReceived(Order $order)
    {
        // Kiểm tra nếu đơn hàng có trạng thái đang chờ xử lý (status là 1 hoặc 2)
        if (in_array($order->status, [1, 2])) {
            // Đánh dấu đơn hàng là đã nhận hàng (status = 3)
            $order->status = 3;

            // Duyệt qua từng chi tiết đơn hàng (order_details)
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product; // Lấy sản phẩm từ chi tiết đơn hàng
                $product->decrement('quantity', $detail->quantity); // Trừ số lượng sản phẩm trong kho
            }

            // Lưu thay đổi trong đơn hàng
            $order->save();

            // Trả về thông báo thành công
            return redirect()->route('orders.history')->with('success', 'Cảm ơn bạn đã xác nhận đã nhận hàng và số lượng sản phẩm đã được cập nhật.');
        }

        // Nếu trạng thái đơn hàng không phải là 1 hoặc 2, không thể đánh dấu là đã nhận hàng
        return redirect()->route('orders.history')->with('error', 'Không thể xác nhận đã nhận hàng ở trạng thái hiện tại.');
    }


}
