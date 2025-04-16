@extends('client.layouts.master')

@section('title', 'Trang Chủ')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="{{ asset('client/img/ms_banner_img5.webp') }}"
                                style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Khám phá
                                        sách mới nhất</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Cập nhật những đầu sách hot
                                        nhất từ các tác giả nổi tiếng và nhà xuất bản uy tín.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#">Mua ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="{{ asset('client/img/ms_banner_img2.webp') }}"
                                style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Sách kỹ năng
                                        sống</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Giúp bạn nâng cao tư duy,
                                        cải thiện bản thân và thành công trong cuộc sống.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="{{ asset('client/img/ms_banner_img4.webp') }}"
                                style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Tủ sách
                                        thiếu nhi</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Những cuốn sách hay, ý
                                        nghĩa, phù hợp với trẻ em ở mọi lứa tuổi.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#">Khám phá</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Danh
                mục</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="{{ route('shop', ['category[]' => $category->id]) }}">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="img/cat-1.jpg" alt="">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{ $category->name }}</h6>
                                <small class="text-body">{{ $category->products_count }} sản phẩm</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm
                giảm giá</span></h2>
        <div class="row px-xl-5">
            @foreach ($sale_products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden d-flex align-items-center justify-content-center"
                            style="height: 250px;">
                            <img class="img-fluid" src="{{ url('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                style="max-height: 100%; object-fit: contain; background-color: #f8f9fa;">
                            <div class="product-action">
                                <a href="#" class="btn btn-outline-dark btn-square add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square"
                                    href="{{ route('product.show', ['id' => $product->id]) }}"><i class="fa fa-search"></i></a>
                            </div>

                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('product.show', ['id' => $product->id]) }}">
                                {{ $product->name }}
                            </a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                @if ($product->sale_price)
                                    <h5>{{ number_format($product->sale_price, 0, ',', '.') }}₫</h5>
                                    <h6 class="text-muted ml-2">
                                        <del>{{ number_format($product->unit_price, 0, ',', '.') }}₫</del>
                                    </h6>
                                @else
                                    <h5>{{ number_format($product->unit_price, 0, ',', '.') }}₫</h5>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="{{ asset('client/img/ms_banner_img5.webp') }}" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="{{ asset('client/img/ms_banner_img4.webp') }}" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm mới
                nhất</span></h2>
        <div class="row px-xl-5">
            @foreach ($recent_products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden d-flex align-items-center justify-content-center"
                            style="height: 250px;">
                            <img class="img-fluid" src="{{ url('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                style="max-height: 100%; object-fit: contain; background-color: #f8f9fa;">
                            <div class="product-action">
                                <a href="#" class="btn btn-outline-dark btn-square add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square"
                                    href="{{ route('product.show', ['id' => $product->id]) }}"><i class="fa fa-search"></i></a>
                            </div>

                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('product.show', ['id' => $product->id]) }}">
                                {{ $product->name }}
                            </a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                @if ($product->sale_price)
                                    <h5>{{ number_format($product->sale_price, 0, ',', '.') }}₫</h5>
                                    <h6 class="text-muted ml-2">
                                        <del>{{ number_format($product->unit_price, 0, ',', '.') }}₫</del>
                                    </h6>
                                @else
                                    <h5>{{ number_format($product->unit_price, 0, ',', '.') }}₫</h5>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->
    @push('scripts')
        <script src="{{ asset('client/js/ajax/cart.js') }}"></script>
    @endpush
@endsection