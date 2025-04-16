<x-filament::page>
    <div class="bg-white shadow rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🧾 Chi tiết đơn hàng</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-200">
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <th class="bg-gray-100 w-1/4 p-3 font-medium text-gray-700">ID đơn hàng</th>
                        <td class="p-3">{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 p-3 font-medium text-gray-700">Khách hàng</th>
                        <td class="p-3">{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 p-3 font-medium text-gray-700">Số điện thoại: </th>
                        <td class="p-3">{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 p-3 font-medium text-gray-700">Địa chỉ</th>
                        <td class="p-3">{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 p-3 font-medium text-gray-700">Phương thức thanh toán</th>
                        <td class="p-3">
                            {{ $order->payment_method == 1 ? 'Thanh toán khi nhận hàng' : 'MoMo' }}
                        </td>
                    </tr>

                    <tr>
                        <th class="bg-gray-100 p-3 font-medium text-gray-700">Trạng thái</th>
                        <td class="p-3 text-blue-600 font-semibold">
                            @php
                                $statusText = ['Chờ xác nhận', 'Đã xác nhận', 'Đã thanh toán', 'Đã nhận hàng', 'Đã hủy'];
                            @endphp
                            {{ $statusText[$order->status] ?? 'Không xác định' }}

                            @if ($order->status == 4 && $order->cancellation_reason)
                                <div class="text-sm text-red-600 mt-2">
                                    <strong>Lý do hủy:</strong> {{ $order->cancellation_reason }}
                                </div>
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mt-10 mb-4">📦 Sản phẩm trong đơn</h3>
        <div class="card bg-white shadow-lg rounded-lg p-6">
            <div class="space-y-4">
                @foreach ($order->orderDetails as $detail)
                    <div class="bg-gray-50 p-4 shadow rounded-lg flex items-center justify-between gap-6">
                        <!-- Hình ảnh -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}"
                                class="w-16 h-16 object-cover rounded-md">
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="flex-1 flex items-center justify-between gap-6">
                            <div class="min-w-[180px]">
                                <h4 class="text-md font-bold text-gray-800 truncate">{{ $detail->product->name }}</h4>
                                <div class="text-sm text-gray-600">
                                    SL: <span class="font-medium text-gray-800">{{ $detail->quantity }}</span><br>
                                    Giá: <span class="font-medium text-gray-800">{{ number_format($detail->price) }}
                                        VND</span>
                                </div>
                            </div>

                            <!-- Thành tiền -->
                            <div class="text-green-600 font-semibold whitespace-nowrap text-right">
                                {{ number_format($detail->price * $detail->quantity) }} VND
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tổng tiền -->
            <div class="mt-6 border-t pt-4 flex justify-end items-center">
                <div class="text-right">
                    <div class="text-gray-600 text-sm font-medium">Tổng giá</div>
                    <div class="text-2xl font-bold text-red-600">
                        {{ number_format($order->total_price) }} VND
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-filament::page>