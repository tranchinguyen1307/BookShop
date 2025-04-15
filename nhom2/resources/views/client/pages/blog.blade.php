@extends('client.layouts.master')
@section('title', 'Bài Viết Mới')
@section('content')

<!-- Breadcrumb Section -->
<div class="container-fluid mb-4">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-white py-3 px-4 shadow-sm rounded">
                <a class="breadcrumb-item text-muted" href="#">Trang chủ</a>
                <span class="breadcrumb-item active">Bài viết</span>
            </nav>
        </div>
    </div>
</div>

<!-- Blog Section -->
<div class="container-fluid">
    <div class="row px-xl-5">

        <!-- Sidebar -->
        <aside class="col-lg-3 col-md-4 mb-4">
            <div class="bg-light p-4 rounded shadow-sm">
                <h5 class="text-uppercase mb-3">Chủ đề</h5>
                <ul class="list-unstyled">
                    @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('blog', ['blogcategory_id' => $category->id]) }}"
                               class="text-dark d-flex justify-content-between {{ request('blogcategory_id') == $category->id ? 'fw-bold' : '' }}">
                                {{ $category->name }}
                                <span class="badge badge-secondary">
                                    
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>


        <!-- Blog Posts -->
        <section class="col-lg-9 col-md-8">
            <div class="row">

                @foreach ($blogs as $blog)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ url('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title font-weight-bold">{{ $blog->title }}</h6>
                            <p class="card-text text-muted small">
                                {{ Str::limit(strip_tags($blog->content), 100) }}
                            </p>
                            <a href="" class="mt-auto text-primary">
                                Xem chi tiết <i class="fa fa-chevron-right small ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach



                <!-- Pagination -->
                @if ($blogs->hasPages())
                        <div class="col-12">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    {{-- Nút "Previous" --}}
                                    @if ($blogs->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Trước</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $blogs->previousPageUrl() }}">Trước</a>
                                        </li>
                                    @endif

                                    {{-- Các số trang --}}
                                    @foreach ($blogs->links()->elements[0] as $page => $url)
                                        @if ($page == $blogs->currentPage())
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
                                    @if ($blogs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $blogs->nextPageUrl() }}">Sau</a>
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
        </section>

    </div>
</div>

@endsection
