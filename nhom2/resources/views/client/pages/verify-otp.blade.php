@extends('client.layouts.master')

@section('content')
    <div class="container">
        <h2>Xác Nhận OTP</h2>
        <form action="{{ route('forgot-password.verifyOtp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="mb-3">
                <label>Mã OTP:</label>
                <input type="text" name="otp" class="form-control">
                @error('otp') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn btn-success">Xác Nhận</button>
        </form>
    </div>
@endsection