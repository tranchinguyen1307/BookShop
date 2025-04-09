<x-filament::page>
    <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-10 space-y-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">🧾 Chi tiết đơn hàng</h2>

        <div class="grid grid-cols-2 gap-6 text-lg text-gray-700">
            <p><strong>ID đơn hàng:</strong> {{ $order->id }}</p>
            <p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Phương thức thanh toán:</strong>
                @if($order->payment_method == 1)
                    Thanh toán khi nhận hàng
                @else
                    MoMo
                @endif
            </p>
            <p><strong>Tổng giá:</strong> <span
                    class="text-red-600 font-semibold">{{ number_format($order->total_price) }} VND</span></p>
            <p><strong>Trạng thái:</strong>
                @php
                    $statusText = ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao hàng', 'Đã nhận hàng', 'Đã hủy'];
                @endphp
                <span class="text-blue-600 font-medium">
                    {{ $statusText[$order->status] ?? 'Không xác định' }}
                </span>
            </p>
        </div>

        <h3 class="text-2xl font-semibold text-gray-800">📦 Sản phẩm trong đơn</h3>
        <div class="space-y-6">
            @foreach ($order->orderDetails as $detail)
                <div class="flex items-center gap-6 p-6 border border-gray-200 rounded-2xl shadow-md bg-gray-50">
                    <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}"
                        class="w-32 h-32 object-cover rounded-xl border border-gray-300">

                    <div class="flex-1 text-lg">
                        <h4 class="font-semibold text-gray-900 text-xl">{{ $detail->product->name }}</h4>
                        <p class="text-gray-700 mt-1">
                            <span class="block">Số lượng: <strong>{{ $detail->quantity }}</strong></span>
                            <span class="block">Đơn giá: <strong>{{ number_format($detail->price) }} VND</strong></span>
                            <span class="block text-green-600 font-semibold text-lg">Thành tiền:
                                {{ number_format($detail->price * $detail->quantity) }} VND</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::page>