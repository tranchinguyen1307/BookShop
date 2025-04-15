@extends('client.layouts.master')

@section('title', 'Cảm ơn')

@section('content')
    <div class="container-fluid mb-5">
        <div class="row px-xl-5">
            <div class="col-12">
                <div class="text-center mt-5 mb-5">
                    <h2 class="font-weight-bold">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</h2>
                    <p class="lead">Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ gửi thông tin đơn hàng đến email của bạn trong thời gian sớm nhất.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
@endsection
