@extends('client.layouts.master')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa địa chỉ</h2>
        <form action="{{ route('addresses.update', $address->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ $address->address }}"
                    required>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>
@endsection