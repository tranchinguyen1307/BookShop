@extends('client.layouts.master')
@section('title', 'Lịch sử đơn hàng')
@section('content')

    @php
        function getStatusLabel($status)
        {
            return match ((int) $status) {
                0 => 'Chờ xác nhận',
                1 => 'Đã xác nhận',
                2 => 'Đã thanh toán',
                3 => 'Đã nhận hàng',
                4 => 'Đã hủy',
                default => 'Không rõ',
            };
        }
    @endphp

    <div class="container mt-4">
        <h4>Lịch sử đơn hàng</h4>

        <ul class="nav nav-tabs mb-3" id="orderTab" role="tablist">
            @foreach ($groupedOrders as $status => $orders)
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($loop->first) active @endif" id="status-{{ $status }}-tab"
                        data-bs-toggle="tab" href="#status-{{ $status }}" role="tab">
                        {{ getStatusLabel($status) }} ({{ $orders->count() }})
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="orderTabContent">
            @foreach ($groupedOrders as $status => $orders)
                <div class="tab-pane fade @if ($loop->first) show active @endif"
                    id="status-{{ $status }}" role="tabpanel">
                    @if ($orders->isEmpty())
                        <p class="text-center my-4">Không có đơn hàng.</p>
                    @else
                        @foreach ($orders as $order)
                            <div class="card mb-3 shadow-sm p-3">
                                <div class="row align-items-center">
                                    <!-- Hình ảnh sản phẩm đầu tiên -->
                                    <div class="col-md-2 text-center">
                                        @php
                                            $firstProduct = $order->orderDetails->first()?->product;
                                            $firstImage = $firstProduct?->image;
                                        @endphp
                                    
                                        @if ($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid rounded"
                                                style="max-height: 100px;" alt="product">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" class="img-fluid rounded"
                                                style="max-height: 100px;" alt="no image">
                                        @endif
                                    </div>
                                    

                                    <!-- Thông tin đơn hàng -->
                                    <div class="col-md-7">
                                        <h5>Đơn hàng #{{ $order->order_code }}</h5>
                                        <p class="mb-1 text-muted">🗓 Ngày đặt:
                                            {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="mb-1 text-danger fw-bold">💰 Tổng tiền:
                                            {{ number_format($order->total_price, 0, ',', '.') }}đ
                                        </p>
                                        <p class="mb-1 text-muted"> Địa chỉ:
                                            {{ $order->address }}</p>
                                    </div>

                                    <!-- Nút hành động -->
                                    <div class="col-md-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="btn btn-outline-success mx-1">
                                                Xem chi tiết
                                            </a>

                                            @if ($order->status == 0)
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        Hủy đơn hàng
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>


    </div>
@endsection
