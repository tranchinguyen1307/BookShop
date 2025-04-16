<?php

namespace App\Http\Controllers\Client;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AddressController extends Controller
{
    // Hiển thị danh sách địa chỉ của user hiện tại
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return view('client.pages.addresses.index', compact('addresses'));
    }

    // Hiển thị form thêm mới địa chỉ
    public function create()
    {
        return view('client.pages.addresses.create');
    }

    // Lưu địa chỉ mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required|string|max:255',
        ]);

        // Tạo địa chỉ hoàn chỉnh
        $fullAddress = "{$request->address}, {$request->ward}, {$request->district}, {$request->province}";

        // Loại bỏ số không mong muốn nhưng giữ nguyên dấu phẩy và khoảng trắng
        $fullAddress = preg_replace('/\b\d+\b/', '', $fullAddress); // Chỉ xóa số đứng độc lập
        $fullAddress = preg_replace('/,\s*,/', ',', $fullAddress);  // Loại bỏ dấu phẩy dư
        $fullAddress = trim($fullAddress, ', '); // Xóa dấu phẩy dư ở đầu/cuối chuỗi


        Auth::user()->addresses()->create([
            'address' => $fullAddress,
        ]);

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được thêm!');
    }


    // Hiển thị form chỉnh sửa địa chỉ
    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403); // Không cho phép sửa địa chỉ của người khác
        }

        return view('client.pages.addresses.edit', compact('address'));
    }

    // Cập nhật địa chỉ
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $address->update(['address' => $request->address]);

        return redirect()->route('addresses.index')->with('success', 'Cập nhật địa chỉ thành công!');
    }

    // Xóa địa chỉ
    public function destroy(Request $request, Address $address)
    {
        // Kiểm tra nếu địa chỉ thuộc về người dùng hiện tại
        if ($address->user_id !== Auth::id()) {
            abort(403); // Nếu địa chỉ không phải của người dùng, trả về lỗi
        }

        // Xóa địa chỉ
        $address->delete();

        return redirect()->back()->with('success', 'Địa chỉ đã được xóa thành công.');
    }


}
