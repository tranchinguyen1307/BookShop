<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // Chỉ định bảng nếu tên bảng không phải theo chuẩn plural hóa
    protected $table = 'addresses';

    // Các thuộc tính có thể được gán đại diện cho bảng
    protected $fillable = [
        'user_id',
        'address',
    ];

    // Quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

