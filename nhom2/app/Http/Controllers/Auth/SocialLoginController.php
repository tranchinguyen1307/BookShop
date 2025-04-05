<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Tìm user theo Google ID và provider
            $user = User::where('auth_provider', 'google')
                ->where('auth_provider_id', $googleUser->getId())
                ->first();

            // Nếu không có, tìm tiếp theo email (trường hợp user đã đăng ký thủ công trước đó)
            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Nếu có user trùng email, cập nhật thêm thông tin từ Google
                    $user->update([
                        'auth_provider' => 'google',
                        'auth_provider_id' => $googleUser->getId(),
                        'image' => $googleUser->getAvatar(),
                    ]);
                } else {
                    // Nếu hoàn toàn chưa có user, tạo mới
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'password' => bcrypt('google_dummy_password'), // Không dùng nhưng bắt buộc có
                        'auth_provider' => 'google',
                        'auth_provider_id' => $googleUser->getId(),
                        'image' => $googleUser->getAvatar(),
                        'role_id' => 2, // Gán quyền mặc định nếu bạn có role (tùy bạn)
                    ]);
                }
            }

            // Đăng nhập user
            Auth::login($user);

            return redirect()->route('home'); // hoặc route bạn muốn chuyển sau khi đăng nhập

        } catch (\Exception $e) {
            \Log::error($e); // Log lỗi để dễ debug nếu cần
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại!');
        }
    }
}
