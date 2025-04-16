@extends('client.layouts.master')

@section('content')
    <div class="container">
        <h2>Thêm địa chỉ mới</h2>
        <form id="addressForm" action="{{ route('addresses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="province" class="form-label">Tỉnh/Thành phố:</label>
                <select name="province" id="province" class="form-control">
                    <option value="">Chọn tỉnh/thành phố</option>
                </select>
                @error('province')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="district" class="form-label">Quận/Huyện:</label>
                <select name="district" id="district" class="form-control">
                    <option value="">Chọn quận/huyện</option>
                </select>
                @error('district')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="ward" class="form-label">Phường/Xã:</label>
                <select name="ward" id="ward" class="form-control">
                    <option value="">Chọn phường/xã</option>
                </select>
                @error('ward')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="detail_address" class="form-label">Địa chỉ chi tiết:</label>
                <input type="text" name="detail_address" id="detail_address" class="form-control"
                    placeholder="Số nhà, tên đường" value="{{ old('detail_address') }}">
                @error('detail_address')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Input ẩn để lưu địa chỉ hoàn chỉnh --}}
            <input type="hidden" name="address" id="address">

            <button type="submit" class="btn btn-success">Lưu</button>
        </form>

    </div>
    @push('scripts')

        <script src="{{ asset('client/js/address.js') }}"></script>
    @endpush
@endsection