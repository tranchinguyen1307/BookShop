<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000',
        ];
    }
    
    public function messages(): array
    {
        return [
            'rating.required' => 'Vui lòng đánh giá sao.',
            'rating.integer' => 'Số sao phải là số nguyên.',
            'rating.min' => 'Vui lòng chọn số sao.',
            'rating.max' => 'Số sao tối đa là 5.',
            'message.required' => 'Vui lòng nhập nội dung đánh giá.',
            'message.min' => 'Nội dung đánh giá phải có ít nhất 10 ký tự.',
            'message.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ];
    }
    

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
