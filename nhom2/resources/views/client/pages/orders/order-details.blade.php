@extends('client.layouts.master')
@section('title', 'Chi tiết đơn hàng')
@section('content')

    @php
        function getStatusLabel($status)
        {
            return match ((int) $status) {
                0 => ['label' => 'Chờ xác nhận', 'class' => 'bg-warning text-dark'],
                1 => ['label' => 'Đã xác nhận', 'class' => 'bg-info text-white'],
                2 => ['label' => 'Đang chuẩn bị', 'class' => 'bg-primary'],
                3 => ['label' => 'Hoàn tất', 'class' => 'bg-success'],
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
                    <div class="col-md-2 text-end">
                        <p class="mb-1">Thành tiền:
                            <strong>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</strong>
                        </p>
                        <p class="mb-0">
                            Trạng thái:
                            <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                        </p>
                    </div>
                    @if($order->status == 3 && !$item->alreadyReviewed)
                        <div class=" col-md-2">
                            <button class="btn btn-sm btn-primary open-review-modal" data-bs-toggle="modal"
                                data-bs-target="#reviewModal" data-order-id="{{ $order->id }}"
                                data-product-id="{{ $item->product->id }}">
                                Đánh giá
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="text-end mt-4">
            <h5>Tổng cộng:
                <span class="text-danger">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
            </h5>
            <a href="{{ route('orders.history') }}" class="btn btn-secondary mt-2">← Quay lại lịch sử</a>
        </div>
    </div>
    <!-- Modal đánh giá -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                    <button type="button" class="btn btn-sm btn-outline-dark rounded-circle" data-bs-dismiss="modal"
                        aria-label="Đóng">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="reviewForm">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">
                        <input type="hidden" name="product_id" id="product_id">
                        <input type="hidden" name="rating" id="rating" value="0">

                        <div class="d-flex align-items-center mb-1" style="padding-bottom: 0; line-height: 1;">
                            <p class="mb-0 me-2">Đánh giá:</p>
                            <div class="rating text-warning fs-5" id="starRating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star" data-value="{{ $i }}">&#9733;</span>
                                @endfor
                            </div>
                        </div>

                        <div id="ratingError" class="text-danger small mt-3 mb-3"></div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung đánh giá</label>
                            <textarea name="message" id="message" class="form-control" rows="4"></textarea>
                        </div>
                        <div id="messageError" class="text-danger small mb-3"></div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </div>
                    </form>
                    <div id="errorMessages"></div>
                </div>

            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .star {
                font-size: 2rem;
                color: #ccc;
                cursor: pointer;
                transition: color 0.2s;
            }

            .star.selected,
            .star.hovered {
                color: gold;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            let currentRating = 0;

            stars.forEach(star => {
                star.addEventListener('mouseover', () => {
                    const val = parseInt(star.getAttribute('data-value'));
                    highlightStars(val);
                });

                star.addEventListener('mouseout', () => {
                    highlightStars(currentRating);
                });

                star.addEventListener('click', () => {
                    currentRating = parseInt(star.getAttribute('data-value'));
                    ratingInput.value = currentRating;
                    highlightStars(currentRating);
                });
            });

            function highlightStars(rating) {
                stars.forEach(star => {
                    const val = parseInt(star.getAttribute('data-value'));
                    if (val <= rating) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }
        </script>
        <script src="{{ asset('client/js/ajax/review.js') }}"></script>

    @endpush
@endsection
