@extends('client.layouts.master')
@section('title', 'Giỏ Hàng')
@section('content')
    <!-- Toast Thông báo -->
    @if(session('success') || session('error'))
        <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} mt-3" role="alert">
            <strong>{{ session('success') ? 'Thành công!' : 'Thất bại!' }}</strong>
            {{ session('success') ?? session('error') }}
        </div>
    @endif
    <div class="container">
        <h4>Xác Nhận Xóa Tài Khoản</h4>
        <form action="{{ route('account.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label for="password" class="form-label">Nhập mật khẩu của bạn để xác nhận</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('account') }}" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-danger">Xóa Tài Khoản</button>
            </div>
        </form>
    </div>
@endsection