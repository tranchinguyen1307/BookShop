@extends('client.layouts.master')
@section('title', 'Sản phẩm')
@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="position-relative w-100 bg-light d-flex align-items-center justify-content-center"
                style="height: 500px;">
               <img id="main-image"
                    src="{{ url('storage/' . $product->image) }}"
                    alt="Ảnh sản phẩm"
                    style="max-width: 100%; max-height: 100%; object-fit: contain;">

               <!-- Mũi tên điều hướng -->
               <button id="prev-btn" class="carousel-control-prev" type="button">
                   <i class="fa fa-2x fa-angle-left text-dark"></i>
               </button>
               <button id="next-btn" class="carousel-control-next" type="button">
                   <i class="fa fa-2x fa-angle-right text-dark"></i>
               </button>
           </div>
           <div class="mt-3">
            <div id="thumbnails" class="d-flex overflow-hidden">
                <!-- Thumbnail ảnh chính -->
                <img class="thumb img-thumbnail active"
                     src="{{ url('storage/' . $product->image) }}"
                     onclick="changeImage(0)"
                     alt="Thumbnail">

                <!-- Thumbnail album -->
                @foreach ($product->images as $key => $image)
                    <img class="thumb img-thumbnail"
                         src="{{ url('storage/' . $image->image) }}"
                         onclick="changeImage({{ $key + 1 }})"
                         alt="Thumbnail">

                @endforeach
            </div>
        </div>

            </div>

            @push('styles')
            <style>
                /* CSS thumbnail */
                .thumbnail-container {
                    max-width: 100%;
                    overflow-x: auto;
                }
                #thumbnails {
                     display: flex;
                     justify-content: center; /* Căn giữa thumbnail */
                     overflow-x: auto;
                     white-space: nowrap;
                     padding: 10px 0;
                     cursor: grab;
                     scroll-behavior: smooth;}
                .thumb {
                    width: 70px;
                    height: 70px;
                    object-fit: cover;
                    cursor: pointer;
                    border: 2px solid transparent;
                    transition: 0.3s;
                }
                .thumb.active, .thumb:hover {
                    border-color: #007bff;
                }

                /* CSS mũi tên */
                .carousel-control-prev, .carousel-control-next {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    border: none;
                    padding: 10px;
                    cursor: pointer;
                    z-index: 10;
                    background: none;
                }
                .carousel-control-prev { left: 10px; }
                .carousel-control-next { right: 10px; }
            </style>
            @endpush

            @push('scripts')
            <script>
                let images = [
                    "{{ url('storage/' . $product->image) }}",
                    @foreach ($product->images as $image)
                        "{{ url('storage/' . $image->image) }}",
                    @endforeach
                ];
                let currentIndex = 0;

                function changeImage(index) {
                    currentIndex = index;
                    document.getElementById('main-image').src = images[currentIndex];
                    updateThumbnails();
                }

                function updateThumbnails() {
                    document.querySelectorAll('.thumb').forEach((img, i) => {
                        img.classList.toggle('active', i === currentIndex);
                    });
                }

                document.getElementById('prev-btn').addEventListener('click', function () {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    document.getElementById('main-image').src = images[currentIndex];
                    updateThumbnails();
                });

                document.getElementById('next-btn').addEventListener('click', function () {
                    currentIndex = (currentIndex + 1) % images.length;
                    document.getElementById('main-image').src = images[currentIndex];
                    updateThumbnails();
                });

                updateThumbnails();
            </script>
            @endpush
            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{$product->name}}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">
                        @if ($product->sale_price)
                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                            <small class="text-muted"><del>{{ number_format($product->unit_price, 0, ',', '.') }}₫</del></small>
                        @else
                            {{ number_format($product->unit_price, 0, ',', '.') }}₫
                        @endif
                    </h3>
                    <div>
                     {!!$product->short_description!!}
                    </div>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    {{-- <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Mô tả</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Đánh giá (0)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            {!! $product->description !!}
                        </div>

                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">1 review for "Product Name"</h4>
                                    <div class="media mb-4">
                                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                            style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum
                                                et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Cùng thể loại</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @if($relatedProducts)
                    @foreach ($relatedProducts as $relatedProduct)
                            <div class="product-item bg-light">
                                <div class="product-img position-relative overflow-hidden d-flex align-items-center justify-content-center"
                                    style="height: 250px;">
                                    <img class="img-fluid" src="{{ url('storage/' . $relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}"
                                        style="max-height: 100%; object-fit: contain; background-color: #f8f9fa;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square"
                                            href="{{ route('product.show', ['id' => $relatedProduct->id]) }}"><i
                                                class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">{{$relatedProduct->name}}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        @if ($relatedProduct->sale_price)
                                            <h5>{{ number_format($relatedProduct->sale_price, 0, ',', '.') }}₫</h5>
                                            <h6 class="text-muted ml-2">
                                                <del>{{ number_format($relatedProduct->unit_price, 0, ',', '.') }}₫</del></h6>
                                        @else
                                            <h5>{{ number_format($relatedProduct->unit_price, 0, ',', '.') }}₫</h5>
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
                    @endforeach
                @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
