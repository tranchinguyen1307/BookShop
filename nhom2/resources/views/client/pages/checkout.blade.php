@extends('client.layouts.master')
@section('title', 'Thanh toán')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="#">Cửa hàng</a>
                    <span class="breadcrumb-item active">Thanh toán</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Địa chỉ
                        thanh toán</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ</label>
                            <input class="form-control" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tên</label>
                            <input class="form-control" type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ 1</label>
                            <input class="form-control" type="text" placeholder="123 Đường phố">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ 2</label>
                            <input class="form-control" type="text" placeholder="123 Đường phố">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quốc gia</label>
                            <select class="custom-select">
                                <option selected>Hoa Kỳ</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Thành phố</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tiểu bang</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mã bưu chính</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Tạo tài khoản mới</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                    data-target="#shipping-address">Gửi đến địa chỉ khác</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Địa chỉ
                            giao hàng</span></h5>
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Họ</label>
                                <input class="form-control" type="text" placeholder="John">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tên</label>
                                <input class="form-control" type="text" placeholder="Doe">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" type="text" placeholder="+123 456 789">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ 1</label>
                                <input class="form-control" type="text" placeholder="123 Đường phố">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ 2</label>
                                <input class="form-control" type="text" placeholder="123 Đường phố">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Quốc gia</label>
                                <select class="custom-select">
                                    <option selected>Hoa Kỳ</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Thành phố</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tiểu bang</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mã bưu chính</label>
                                <input class="form-control" type="text" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tổng đơn
                        hàng</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Sản phẩm</h6>
                        @foreach ($cartItems as $cartItem)
                            <div class="d-flex align-items-center mb-3" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px;">
                                <!-- Hình ảnh sản phẩm -->
                                <div class="d-flex align-items-center mr-4">
                                    <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                                         style="width: 80px; height: 80px; overflow: hidden;">
                                        <img src="{{ url('storage/' . $cartItem->product->image) }}"
                                             alt="{{ $cartItem->product->name }}" class="img-fluid"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                    
                                <!-- Tên và giá sản phẩm -->
                                <div class="flex-grow-1" style="overflow: hidden;">
                                    <p class="mb-1" style="font-size: 16px; font-weight: 600; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $cartItem->product->name }}
                                    </p>
                                    <p class="mb-0" style="font-size: 14px; color: #555;">
                                        @if($cartItem->product->sale_price)
                                            <span class="text-danger" style="font-weight: bold; font-size: 16px;">
                                                {{ number_format($cartItem->product->sale_price, 0, ',', '.') }}₫
                                            </span>
                                            <span class="text-muted" style="text-decoration: line-through; font-weight: 500; font-size: 14px;">
                                                {{ number_format($cartItem->product->unit_price, 0, ',', '.') }}₫
                                            </span>
                                        @else
                                            <span style="font-size: 16px;">
                                                {{ number_format($cartItem->product->unit_price, 0, ',', '.') }}₫
                                            </span>
                                        @endif
                                    </p>
                                </div>
                    
                                <!-- Thông tin số lượng và tổng tiền (dồn về bên phải) -->
                                <div class="d-flex flex-column align-items-end" style="min-width: 120px;">
                                    <!-- Số lượng sản phẩm -->
                                    <span style="font-size: 16px; font-weight: 600;">Số lượng: {{ $cartItem->quantity }}</span>
                                    
                                    <!-- Tổng tiền sản phẩm -->
                                    <span style="font-size: 16px; font-weight: 600;">
                                        @if($cartItem->product->sale_price)
                                            {{ number_format($cartItem->product->sale_price * $cartItem->quantity, 0, ',', '.') }}₫
                                        @else
                                            {{ number_format($cartItem->product->unit_price * $cartItem->quantity, 0, ',', '.') }}₫
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tổng cộng</h6>
                            <h6>{{ number_format($totalPrice, 0, ',', '.') }}₫</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Vận chuyển</h6>
                            <h6 class="font-weight-medium">{{ number_format($shippingFee, 0, ',', '.') }}₫</h6>
                        </div>
                        <div class="mt-0">
                            <small class="text-danger">Giá trên 300,000đ sẽ được miễn phí vận chuyển</small>
                        </div>
                    </div>
                    

                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Tổng tiền</h5>
                            <h5>{{ number_format($totalPrice + $shippingFee, 0, ',', '.') }}₫</h5>
                            <!-- Tổng tiền phải trả -->
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thanh
                            toán</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Chuyển khoản trực tiếp</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Chuyển khoản ngân hàng</label>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

@endsection