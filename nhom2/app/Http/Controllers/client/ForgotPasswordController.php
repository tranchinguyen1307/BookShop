<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\client\ResetPasswordRequest;
use App\Http\Requests\client\VerifyOtpRequest;
use App\Http\Requests\client\SendOtpRequest;
use Exception;
class ForgotPasswordController extends Controller
{
    // Hiển thị form nhập email
    public function showForgotPasswordForm()
    {
        return view('client.pages.forgot-password');
    }

    // Gửi OTP qua email
    public function sendOtp(SendOtpRequest $request)
    {
        try {
            $otp = rand(100000, 999999);

            // Xóa OTP cũ nếu có
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            // Lưu OTP mới
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => bcrypt($otp),
                'created_at' => Carbon::now(),
            ]);

            // Gửi OTP qua email
            Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
                $message->to($request->email)->subject('Mã OTP Đặt Lại Mật Khẩu');
            });

            return redirect()->route('forgot-password.otpForm')->with('email', $request->email);
        } catch (Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }
    // Hiển thị form nhập OTP
    public function showOtpForm(Request $request)
    {
        return view('client.pages.verify-otp', ['email' => session('email')]);
    }

    // Xác minh OTP
    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

            if (!$record || !password_verify($request->otp, $record->token)) {
                return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
            }

            return redirect()->route('reset-password.form')->with(['email' => $request->email]);
        } catch (Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }
    // Hiển thị form đặt lại mật khẩu
    public function showResetPasswordForm()
    {
        return view('client.pages.reset-password', ['email' => session('email')]);
    }

    // Đặt lại mật khẩu
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            // Tìm người dùng theo email
            $user = User::where('email', $request->email)->firstOrFail();

            // Cập nhật mật khẩu
            $user->update(['password' => Hash::make($request->password)]);

            // Xóa token đặt lại mật khẩu
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công.');
        } catch (Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }
}
