<?php

namespace App\Http\Controllers\client;


use App\Http\Requests\client\UpdateUserRequest;
use App\Http\Requests\client\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    /**
     * Hiển thị trang thông tin tài khoản.
     */
    public function index()
    {
        return view('client.pages.account', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Cập nhật thông tin tài khoản.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        // Xử lý cập nhật ảnh đại diện
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($user->image) {
                Storage::delete('public/' . $user->image);
            }

            // Lưu ảnh mới vào thư mục "storage/app/public/users/"
            $path = $request->file('image')->store('users', 'public');
            $data['image'] = $path;
        }

        // Cập nhật thông tin người dùng
        $user->update($data);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }


    /**
     * Đổi mật khẩu.
     */
    public function changePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // confirmed yêu cầu input có name là `new_password_confirmation`
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        // Kiểm tra xem mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }

        // Cập nhật mật khẩu mới (đã mã hóa)
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }

    /**
     * Xóa tài khoản người dùng.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra nếu người dùng có role_id = 0 thì không được xóa
        if ($user->role_id == 0) {
            return back()->with('error', 'Tài khoản này không thể bị xóa.');
        }


        // Xóa ảnh đại diện nếu có
        if ($user->image) {
            Storage::delete('public/' . $user->image);
        }

        // Xóa tài khoản
        $user->delete();

        // Đăng xuất người dùng
        Auth::logout();

        // Chuyển hướng về trang chủ với thông báo
        return redirect('/')->with('success', 'Tài khoản đã bị xóa.');
    }

    public function confirmDelete()
    {
        return view('client.pages.confirm-delete');
    }


}
