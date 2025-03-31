@extends('client.layouts.master')

@section('content')
    <div class="container">
        <h2>Quên Mật Khẩu</h2>
        <form action="{{ route('forgot-password.sendOtp') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control">
                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Gửi OTP</button>
        </form>
    </div>
@endsection