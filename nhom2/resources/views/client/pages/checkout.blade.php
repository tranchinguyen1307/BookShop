@extends('client.layouts.master')
@section('title', 'Thanh toán')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid mb-4">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light p-3 mb-4 rounded">
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
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
   
            <div class="row px-xl-5">
                <div class="col-lg-6 mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tổng đơn
                            hàng</span></h5>
                    <div class="bg-light p-4 rounded shadow-sm">
                        <div class="border-bottom mb-3">
                            <h6 class="mb-3">Sản phẩm</h6>
                            @foreach ($cartItems as $cartItem)
                                <div class="d-flex align-items-center mb-3"
                                    style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px;">
                                    <div class="d-flex align-items-center mr-4">
                                        <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                                            style="width: 80px; height: 80px; overflow: hidden;">
                                            <img src="{{ url('storage/' . $cartItem->product->image) }}"
                                                alt="{{ $cartItem->product->name }}" class="img-fluid"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1" style="overflow: hidden;">
                                        <p class="mb-1"
                                            style="font-size: 16px; font-weight: 600; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $cartItem->product->name }}
                                        </p>
                                        <p class="mb-0" style="font-size: 14px; color: #555;">
                                            @if($cartItem->product->sale_price)
                                                <span class="text-danger" style="font-weight: bold; font-size: 16px;">
                                                    {{ number_format($cartItem->product->sale_price, 0, ',', '.') }}₫
                                                </span>
                                                <span class="text-muted"
                                                    style="text-decoration: line-through; font-weight: 500; font-size: 14px;">
                                                    {{ number_format($cartItem->product->unit_price, 0, ',', '.') }}₫
                                                </span>
                                            @else
                                                <span style="font-size: 16px;">
                                                    {{ number_format($cartItem->product->unit_price, 0, ',', '.') }}₫
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column align-items-end" style="min-width: 120px;">
                                        <span style="font-size: 16px; font-weight: 600;">Số lượng:
                                            {{ $cartItem->quantity }}</span>
                                        <span style="font-size: 16px; font-weight: 600;">
                                            @if($cartItem->product->sale_price)
                                                {{ number_format($cartItem->product->sale_price * $cartItem->quantity, 0, ',', '.') }}₫
                                            @else
                                                {{ number_format($cartItem->product->unit_price * $cartItem->quantity, 0, ',', '.') }}₫
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="selected_items[]" value="{{ $cartItem->id }}">
                            @endforeach
                        </div>

                        <div class="border-bottom pt-3 pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Tổng cộng</h6>
                                <h6>{{ number_format($totalPrice, 0, ',', '.') }}₫</h6>
                            </div>
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Vận chuyển</h6>
                                <h6 class="font-weight-medium">{{ number_format($shippingFee, 0, ',', '.') }}₫</h6>
                            </div>
                            <input type="hidden" name="shippingFee" value="{{ $shippingFee }}">
                            <div class="mt-0">
                                <small class="text-danger">Giá trên 300,000đ sẽ được miễn phí vận chuyển</small>
                            </div>
                        </div>

                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Tổng tiền</h5>
                                <h5>{{ number_format($totalPrice + $shippingFee, 0, ',', '.') }}₫</h5>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-6 mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Địa chỉ
                            thanh toán</span></h5>
                    <div class="bg-light p-4 rounded shadow-sm">
                        <div class="row">
                            <!-- Tên người dùng -->
                            <div class="col-md-12 form-group">
                                <label for="name" class="font-weight-bold">Tên</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" readonly>
                            </div>

                            <!-- Email người dùng -->
                            <div class="col-md-12 form-group">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="email" name="email " id="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>


                            <!-- Số điện thoại -->
                            <div class="col-md-12 form-group">
                                <label for="phone" class="font-weight-bold">Số điện thoại</label>
                                <input class="form-control" type="text" name="phone" id="phone"
                                       placeholder="Nhập số điện thoại" value="{{ old('phone', $user->phone) }}">
                                @error('phone') 
                                    <p class="text-danger">{{ $message }}</p> 
                                @enderror
                            </div>
                            

                            @if($user->addresses && $user->addresses->isNotEmpty())
                                <div class="col-md-12 form-group">
                                    <label for="address" class="font-weight-bold">Địa chỉ</label>
                                    <select name="address" id="address" class="form-control" required>
                                        @foreach ($user->addresses as $address)
                                            <option value="{{ $address->address }}">{{ $address->address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <!-- Tỉnh/Thành phố -->
                                <div class="col-md-12 form-group">
                                    <label for="province" class="font-weight-bold">Tỉnh/Thành phố:</label>
                                    <select name="province" id="province" class="form-control " required>
                                        <option value="">Chọn tỉnh/thành phố</option>
                                    </select>
                                    @error('province') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <!-- Quận/Huyện -->
                                <div class="col-md-12 form-group">
                                    <label for="district" class="font-weight-bold">Quận/Huyện:</label>
                                    <select name="district" id="district" class="form-control " required>
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                    @error('district') <p class="text-danger">{{ $message }}</p> @enderror
                                    
                                </div>

                                <!-- Phường/Xã -->
                                <div class="col-md-12 form-group">
                                    <label for="ward" class="font-weight-bold">Phường/Xã:</label>
                                    <select name="ward" id="ward" class="form-control " required>
                                        <option value="">Chọn phường/xã</option>
                                    </select>
                                    @error('ward') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <!-- Địa chỉ chi tiết -->
                                <div class="col-md-12 form-group">
                                    <label for="detail_address" class="font-weight-bold">Địa chỉ chi tiết:</label>
                                    <input type="text" name="detail_address" id="detail_address"
                                        class="form-control " placeholder="Số nhà, tên đường">
                                        @error('detail_address') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                <input type="hidden" name="address" id="address">
                            @endif
                        </div>
                    </div>
                    <!-- Phần thanh toán -->
                    <div class="mt-3">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Thanh toán</span></h5>
                                <div class="bg-light p-4 rounded shadow-sm">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="payment" id="paypal" value="1" 
                                                @if(old('payment') == 1) checked @endif>
                                            <label class="custom-control-label" for="paypal">Thanh toán khi nhận hàng</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="payment" id="directcheck" value="2" 
                                                @if(old('payment', ) == 2) checked @endif>
                                            <label class="custom-control-label" for="directcheck">Thanh toán momo</label>
                                        </div>
                                    </div>
                                    @error('payment') 
                                        <p class="text-danger">{{ $message }}</p> 
                                    @enderror
                                </div>
                                
                            <button class="btn btn-block btn-primary font-weight-bold py-3">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->
    @push('scripts')
        <script src="{{ asset('client/js/address.js') }}"></script>
    @endpush

@endsection