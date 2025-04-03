@extends('client.layouts.master')

@section('content')
    <div class="container">
        <h2>Danh sách địa chỉ</h2>
        <a href="{{ route('addresses.create') }}" class="btn btn-primary">Thêm địa chỉ</a>
        <ul class="list-group mt-3">
            @foreach($addresses as $address)
                <li class="list-group-item d-flex justify-content-between">
                    {{ $address->address }}
                    <div>
                        <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection