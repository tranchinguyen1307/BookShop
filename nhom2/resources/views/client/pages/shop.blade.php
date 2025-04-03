@extends('client.layouts.master')
@section('title', 'Cửa Hàng')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                        giá</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form method="GET" action="{{ route('shop') }}">
                        @foreach($priceSteps as $index => $range)
                            @php
                                [$min, $max] = explode('-', $range);
                            @endphp
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox"
                                       name="unit_price[]"
                                       value="{{ $range }}"
                                       class="custom-control-input"
                                       id="price-{{ $index }}"
                                       {{ in_array($range, $selectedPrices) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="price-{{ $index }}">
                                    {{ number_format($min, 0, ',', '.') }}đ - {{ number_format($max, 0, ',', '.') }}đ
                                </label>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-2">Lọc</button>
                    </form>

                </div>

                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                        danh mục</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form method="GET" action="{{ route('shop') }}">
                        @foreach($categories as $category)
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" name="category[]" value="{{ $category->id }}"
                                    {{ in_array($category->id, $selectedCategories ?? []) ? 'checked' : '' }} id="category-{{ $category->id }}">
                                <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                <span class="badge border font-weight-normal">{{ $category->products_count }}</span>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a>
                                    </div>
                                </div>
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ url('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square add-to-cart" data-id="{{ $product->id }}"><i
                                                class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="far fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square"
                                            href="{{ route('product.show', ['id' => $product->id]) }}"><i
                                                class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate"
                                        href="{{ route('product.show', ['id' => $product->id]) }}">{{ $product->name }}</a>
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
                    @if ($products->hasPages())
                        <div class="col-12">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    {{-- Nút "Previous" --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Trước</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}">Trước</a>
                                        </li>
                                    @endif

                                    {{-- Các số trang --}}
                                    @foreach ($products->links()->elements[0] as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Nút "Next" --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}">Sau</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Sau</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
    @push('scripts')
    <script src="{{ asset('client/js/ajax/cart.js') }}"></script>
    @endpush
@endsection
