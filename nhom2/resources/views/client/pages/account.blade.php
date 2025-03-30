@extends('client.layouts.master')
@section('title', 'Thông Tin Tài Khoản')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Thông Tin Tài Khoản</h2>

        <!-- Toast Thông báo -->
        @if(session('success') || session('error'))
        <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} mt-3" role="alert">
            <strong>{{ session('success') ? 'Thành công!' : 'Thất bại!' }}</strong> 
            {{ session('success') ?? session('error') }}
        </div>
    @endif
    

        <div class="row">
            <!-- Thông tin tài khoản -->
            <div class="col-md-6">
                <div class="card p-4">
                    
                    <h4>Thông Tin Cá Nhân</h4>
                    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group text-center">
                            <label class="form-label">Ảnh Đại Diện</label>
                            <div class="mb-3">
                                <img id="preview-image" class="rounded"
                                    src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('default-avatar.jpg') }}"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                            <input type="file" name="image" accept="image/*" id="image-input">
                        </div>
                        
                        <div class="form-group">
                            <label>Họ và Tên</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Đổi Mật Khẩu</h4>
                        <div class="dropdown ms-auto">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="{{ route('account.destroy') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Xóa Tài Khoản</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                   
              

                    <form action="{{ route('account.changePassword') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            
                            <label>Mật Khẩu Hiện Tại</label>
                            <input type="password" name="current_password" class="form-control">
                            @error('current_password')  
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Mật Khẩu Mới</label>
                            <input type="password" name="new_password" class="form-control">
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Xác Nhận Mật Khẩu Mới</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                            @error('new_password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning">Đổi Mật Khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
          
@endsection
