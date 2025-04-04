@extends('client.layouts.master')
@section('title', 'Giỏ Hàng')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="">Shop</a>
                    <span class="breadcrumb-item active">Giỏ Hàng</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <!-- Cart Start -->
    <div class="container-fluid">
        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row px-xl-5">
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($cartItems as $item)
                                <tr data-row="{{ $item->id }}">
                                    <td class="align-middle">
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="select-item">
                                    </td>
                                    <td class="align-middle d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px; overflow: hidden;">
                                                <img src="{{ url('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="img-fluid"
                                                    style="max-width: 100%; max-height: 100%;">
                                            </div>
                                            <span class="ml-2">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        {{ number_format($item->product->sale_price ?? $item->product->unit_price, 0, ',', '.') }}₫
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group input-group-sm mx-auto" style="width: 100px;">
                                            <div class="input-group-prepend">
                                                <a class="btn btn-primary btn-minus update-cart cart-minus" data-id="{{ $item->id }}">
                                                    <i class="fa fa-minus"></i>
                                                </a>
                                            </div>
                                            <input type="number" class="form-control text-center quantity-input update-cart"
                                                value="{{ $item->quantity }}" data-id="{{ $item->id }}" max="{{ $item->product->quantity}}">
                                            <div class="input-group-append">
                                                <a class="btn btn-primary btn-plus update-cart cart-plus" data-id="{{ $item->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="cart-item-total">
                                            {{ number_format(($item->product->sale_price ?? $item->product->unit_price) * $item->quantity, 0, ',', '.') }}₫
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger btn-sm remove-item" data-id="{{ $item->id }}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3">
                        <span class="bg-secondary pr-3">Tóm tắt giỏ hàng</span>
                    </h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Tổng cộng</h5>
                                <h5 class="cart-total">
                                    {{ number_format($cartItems->sum(fn($item) => ($item->product->sale_price ?? $item->product->unit_price) * $item->quantity), 0, ',', '.') }}₫
                                </h5>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Thanh toán</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        

    </div>
    @push('styles')
        <style>
            /* Ẩn mũi tên trong input[type=number] */
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('client/js/ajax/cart.js') }}"></script>
    @endpush


@endsection
