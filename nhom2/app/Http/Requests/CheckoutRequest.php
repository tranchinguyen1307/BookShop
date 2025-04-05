<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền gửi yêu cầu này hay không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Nếu bạn có yêu cầu xác thực người dùng, có thể thay đổi thành auth()->check()
    }

    /**
     * Lấy các quy tắc xác thực cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [

            // Kiểm tra số điện thoại hợp lệ
            'phone' => 'required|string|min:10|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',

            // Kiểm tra phương thức thanh toán
            'payment' => 'required',

            // Nếu chưa chọn địa chỉ, validate các trường địa chỉ chi tiết
            'province' => 'required_if:address,null|string|max:255',
            'district' => 'required_if:address,null|string|max:255',
            'ward' => 'required_if:address,null|string|max:255',
            'detail_address' => 'required_if:address,null|string|max:255',

        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi cho các quy tắc xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'payment.required' => 'Vui lòng chọn phương thức thanh toán.',
            'province.required_if' => 'Tỉnh/Thành phố không được để trống.',
            'district.required_if' => 'Quận/Huyện không được để trống.',
            'ward.required_if' => 'Phường/Xã không được để trống.',
            'detail_address.required_if' => 'Địa chỉ chi tiết không được để trống.',
        ];
    }
}

