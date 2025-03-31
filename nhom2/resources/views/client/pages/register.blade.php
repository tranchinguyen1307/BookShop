@extends('client.layouts.master')
@section('title', 'Đăng ký')
@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Trang chủ</a>
                    <span class="breadcrumb-item active">Đăng ký</span>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Đăng ký</span>
        </h2>
        <div class="row px-xl-5">
            <div class="col-lg-6 mx-auto">
                <div class="bg-light p-30">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Tên">
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                            @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Xác nhận mật khẩu">
                            @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection