@extends('client.layouts.master')

@section('content')
    <div class="container">
        <h2>Đặt Lại Mật Khẩu</h2>
        <form action="{{ route('reset-password') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">
            <div class="mb-3">
                <label>Mật khẩu mới:</label>
                <input type="password" name="password" class="form-control">
                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="mb-3">
                <label>Xác nhận mật khẩu:</label>
                <input type="password" name="password_confirmation" class="form-control">
                @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn btn-danger">Đặt Lại Mật Khẩu</button>
        </form>
    </div>
@endsection