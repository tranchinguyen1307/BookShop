@extends('client.layouts.master')
@section('title', 'Đăng nhập')
@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Trang chủ</a>
                    <span class="breadcrumb-item active">Đăng nhập</span>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Đăng nhập</span>
        </h2>
        <div class="row px-xl-5">
            <div class="col-lg-6 mx-auto">
                <div class="bg-light p-30">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                            @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </form>
                    <a href="{{ route('google.login') }}" class="btn btn-danger">
                        <i class="ion-logo-google"></i> Đăng nhập bằng Google
                    </a>
                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('forgot-password.sendOtp') }}">Quên mật khẩu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection