<?php

namespace App\Http\Controllers\client;

use App\Http\Requests\client\LoginRequest;
use App\Http\Requests\client\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{
    // Hiển thị trang đăng ký
    public function showRegister()
    {
        return view('client.pages.register');
    }

    // Xử lý đăng ký
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2 // Giả sử 2 là role khách hàng
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }

    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('client.pages.login');
    }

    // Xử lý đăng nhập
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!']);
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}
