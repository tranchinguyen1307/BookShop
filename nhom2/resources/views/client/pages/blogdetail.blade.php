@extends('client.layouts.master')
@section('title', $blog->title)
@section('content')

    <!-- Breadcrumb -->
    <div class="container-fluid mb-4">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-white py-3 px-4 shadow-sm rounded">
                    <a class="breadcrumb-item text-muted" href="#">Trang chủ</a>
                    <a class="breadcrumb-item text-muted" href="{{ route('blog') }}">Bài viết</a>
                    <span class="breadcrumb-item active">{{ $blog->title }}</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Blog Detail -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Chi tiết bài viết -->
            <div class="col-lg-8 mb-4">
                <div class="bg-white p-4 shadow-sm rounded">
                    <h3 class="mb-3">{{ $blog->title }}</h3>
                    <p class="text-muted small mb-3">Đăng ngày: {{ $blog->created_at->format('d/m/Y') }}</p>
                    <img src="{{ url('storage/' . $blog->image) }}" class="img-fluid rounded mb-4"
                        alt="{{ $blog->title }}">
                    <div class="blog-content">
                        {!! $blog->content !!}
                    </div>
                </div>


                <!-- Bình luận -->
                <div class="bg-white p-4 shadow-sm rounded mt-4">
                    <h5 class="mb-4">Bình luận</h5>

                    <!-- Form bình luận -->
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên của bạn</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Nội dung bình luận</label>
                            <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
                    </form>

                    <!-- Danh sách bình luận -->
                    <hr class="my-4">
                    <h6 class="mb-3">Các bình luận trước</h6>


                        <div class="mb-3">
                            <strong></strong>
                            <small class="text-muted d-block"></small>
                            <p class="mb-0"></p>
                        </div>

                        <p class="text-muted">Chưa có bình luận nào.</p>

                </div>

            </div>


            <!-- Bài viết cùng danh mục -->
            <div class="col-lg-4 mb-4">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h5 class="text-uppercase mb-3">Bài viết cùng danh mục</h5>
                    <ul class="list-unstyled">
                        @foreach ($relatedBlogs as $related)
                            <li class="mb-3 d-flex">
                                <img src="{{ url('storage/' . $related->image) }}" class="img-thumbnail mr-3"
                                    style="width: 80px; height: 60px; object-fit: cover;" alt="{{ $related->title }}">
                                <div>
                                    <a href="{{ route('blog.show', $related->id) }}" class="text-dark fw-bold d-block">
                                        {{ $related->title }}
                                    </a>
                                    <small class="text-muted">{{ $related->created_at->format('d/m/Y') }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
