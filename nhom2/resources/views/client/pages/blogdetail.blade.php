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
            <div class="col-lg-9 mb-4">
                <div class="bg-white p-4 shadow-sm rounded">
                    <h3 class="mb-3">{{ $blog->title }}</h3>
                    <p class="text-muted small mb-3">Đăng ngày: {{ $blog->created_at->format('d/m/Y') }}</p>
                    <img src="{{ url('storage/' . $blog->image) }}" class="img-fluid rounded mb-4"
                        alt="{{ $blog->title }}">
                    <div class="blog-content">
                        {!! $blog->content !!}
                    </div>
                </div>

                @auth
                    <!-- Bình luận -->
                    <div class="bg-white p-4 shadow-sm rounded mt-4">
                        <h5 class="mb-4">Bình luận</h5>

                        <!-- Form bình luận -->
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <div class="form-group">
                                <label for="comment">Nội dung bình luận</label>
                                <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>

                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
                        </form>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>  
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <!-- Danh sách bình luận -->
                        <hr class="my-4">
                        <h6 class="mb-3">Các bình luận trước</h6>

                        @foreach ($blog->comments as $comment)
                            <div class="mb-3" id="comment-box-{{ $comment->id }}">
                                <strong>{{ $comment->user->name }}</strong>
                                <small class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>

                                @auth
                                    @if (Auth::id() === $comment->user_id)
                                        <div id="comment-content-{{ $comment->id }}">
                                            <p class="mb-0">{{ $comment->content }}</p>
                                            <button onclick="showEditForm({{ $comment->id }}, '{{ $comment->content }}')"
                                                class="btn btn-sm btn-secondary mt-1">Sửa</button>

                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mt-1"
                                                    onclick="return confirm('Xóa bình luận này?')">Xóa</button>
                                            </form>
                                        </div>
                                    @else
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    @endif
                                @else
                                    <p class="mb-0">{{ $comment->content }}</p>
                                @endauth
                            </div>
                        @endforeach


                        @if ($blog->comments->isEmpty())
                            <p class="text-muted">Chưa có bình luận nào.</p>
                        @endif


                    </div>
                @else
                    <p class="text-muted">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
                @endauth

            </div>


            <!-- Bài viết cùng danh mục -->
            <div class="col-lg-3 mb-4">
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
<script>
    function showEditForm(id, content) {
        const box = document.getElementById('comment-box-' + id);
        const formHtml = `
            <form onsubmit="return updateComment(event, ${id})" class="mt-2">
                <textarea id="edit-content-${id}" class="form-control" rows="3">${content}</textarea>
                <button type="submit" class="btn btn-sm btn-primary mt-2">Cập nhật</button>
                <button type="button" onclick="cancelEdit(${id}, '${content}')" class="btn btn-sm btn-secondary mt-2">Hủy</button>
            </form>
        `;
        document.getElementById('comment-content-' + id).innerHTML = formHtml;
    }

    function updateComment(event, id) {
        event.preventDefault();
        const content = document.getElementById('edit-content-' + id).value;

        fetch('/comments/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    comment: content
                })
            })
            .then(response => response.json())
            .then(data => {
                const box = document.getElementById('comment-content-' + id);
                box.innerHTML = `
                <p class="mb-0">${data.content}</p>
                <button onclick="showEditForm(${id}, '${data.content}')" class="btn btn-sm btn-secondary mt-1">Sửa</button>
                <form action="/comments/${id}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Xóa bình luận này?')">Xóa</button>
                </form>
            `;
            });
    }

    function cancelEdit(id, content) {
        const box = document.getElementById('comment-content-' + id);
        box.innerHTML = `
            <p class="mb-0">${content}</p>
            <button onclick="showEditForm(${id}, '${content}')" class="btn btn-sm btn-secondary mt-1">Sửa</button>
            <form action="/comments/${id}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Xóa bình luận này?')">Xóa</button>
            </form>
        `;
    }
</script>
