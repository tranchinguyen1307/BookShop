@extends('client.layouts.master')
@section('title', 'Chi tiết đơn hàng')
@section('content')

    @php
        function getStatusLabel($status)
        {
            return match ((int) $status) {
                0 => ['label' => 'Chờ xác nhận', 'class' => 'bg-warning text-dark'],
                1 => ['label' => 'Đã xác nhận', 'class' => 'bg-info text-white'],
                2 => ['label' => 'Đã thanh toán', 'class' => 'bg-primary'],
                3 => ['label' => 'Đã nhận hàng ', 'class' => 'bg-success'],
                4 => ['label' => 'Đã hủy', 'class' => 'bg-danger'],
                default => ['label' => 'Không rõ', 'class' => 'bg-secondary'],
            };
        }

        $status = getStatusLabel($order->status);
    @endphp

    <div class="container mt-4">
        <h4>Chi tiết đơn hàng #{{ $order->id }}</h4>

        @foreach($order->orderDetails as $item)
            <div class="card mb-3 p-3 shadow-sm">
                <div class="row g-0 align-items-center">
                    <!-- Bên trái: thông tin sản phẩm -->
                    <div class="col-md-8 d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded"
                            alt="{{ $item->product->name }}" style="max-height: 100px;">
                        <div>
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <p class="mb-1">Số lượng: <strong>{{ $item->quantity }}</strong></p>
                            <p class="mb-0">Đơn giá: <strong>{{ number_format($item->price, 0, ',', '.') }}đ</strong></p>
                        </div>
                    </div>

                    <!-- Bên phải: thành tiền + trạng thái -->
                    <div class="col-md-4 text-end">
                        <p class="mb-1">Thành tiền:
                            <strong>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</strong>
                        </p>
                        <p class="mb-0">
                            Trạng thái:
                            <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h5>Tổng cộng:
                    <span class="text-danger">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                </h5>
                <a href="{{ route('orders.history') }}" class="btn btn-secondary mt-2">← Quay lại lịch sử</a>
            </div>

            @if (in_array($order->status, [1, 2]))
                <form action="{{ route('orders.receive', $order->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Xác nhận đã nhận hàng</button>
                </form>
            @endif
        </div>





    </div>
@endsection