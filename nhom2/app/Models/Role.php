<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Chỉ định bảng nếu tên bảng không phải theo chuẩn plural hóa
    protected $table = 'roles';

    // Các thuộc tính có thể được gán đại diện cho bảng
    protected $fillable = [
        'name',
        'status',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

