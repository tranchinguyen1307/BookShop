<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Lập Trình PHP Từ Cơ Bản Đến Nâng Cao',
                'description' => 'Cuốn sách hướng dẫn chi tiết về PHP cho người mới bắt đầu.',
                'short_description' => 'Học lập trình PHP chuyên sâu.',
                'purchase_count' => 15,
                'author' => 'Nguyễn Văn A',
                'unit_price' => 150000,
                'sale_price' => 120000,
                'image' => 'books/php.jpg',
                'category_id' => 1,
                'quantity' => 50,
            ],
            [
                'name' => 'JavaScript Toàn Tập',
                'description' => 'Tài liệu toàn diện về lập trình JavaScript hiện đại.',
                'short_description' => 'JS từ cơ bản đến nâng cao.',
                'purchase_count' => 25,
                'author' => 'Lê Thị B',
                'unit_price' => 180000,
                'sale_price' => 150000,
                'image' => 'books/javascript.jpg',
                'category_id' => 1,
                'quantity' => 40,
            ],
            [
                'name' => 'Laravel 10 Pro',
                'description' => 'Xây dựng ứng dụng web với Laravel 10.',
                'short_description' => 'Framework mạnh mẽ Laravel.',
                'purchase_count' => 30,
                'author' => 'Trần Văn C',
                'unit_price' => 200000,
                'sale_price' => 170000,
                'image' => 'books/laravel.jpg',
                'category_id' => 1,
                'quantity' => 60,
            ],
            [
                'name' => 'Clean Code - Code Sạch Cho Dev',
                'description' => 'Kỹ thuật viết code sạch và dễ bảo trì.',
                'short_description' => 'Code dễ đọc, dễ hiểu.',
                'purchase_count' => 45,
                'author' => 'Robert C. Martin',
                'unit_price' => 220000,
                'sale_price' => 200000,
                'image' => 'books/cleancode.jpg',
                'category_id' => 2,
                'quantity' => 30,
            ],
            [
                'name' => 'Thiết Kế Cơ Sở Dữ Liệu',
                'description' => 'Cách thiết kế CSDL hiệu quả, chuẩn hóa và tối ưu.',
                'short_description' => 'Database chuyên sâu.',
                'purchase_count' => 20,
                'author' => 'Nguyễn Thị D',
                'unit_price' => 170000,
                'sale_price' => 150000,
                'image' => 'books/database.jpg',
                'category_id' => 2,
                'quantity' => 45,
            ],
            [
                'name' => 'ReactJS Nâng Cao',
                'description' => 'Khám phá ReactJS qua các dự án thực tế.',
                'short_description' => 'React hiện đại.',
                'purchase_count' => 28,
                'author' => 'Phạm Văn E',
                'unit_price' => 190000,
                'sale_price' => 160000,
                'image' => 'books/react.jpg',
                'category_id' => 1,
                'quantity' => 35,
            ],
            [
                'name' => 'Thuật Toán Và Giải Thuật',
                'description' => 'Nắm vững các thuật toán quan trọng.',
                'short_description' => 'Giải thuật hiệu quả.',
                'purchase_count' => 18,
                'author' => 'Trịnh Văn F',
                'unit_price' => 160000,
                'sale_price' => 130000,
                'image' => 'books/algorithm.jpg',
                'category_id' => 3,
                'quantity' => 25,
            ],
            [
                'name' => 'Kỹ Năng Mềm Cho Lập Trình Viên',
                'description' => 'Phát triển kỹ năng mềm giúp bạn thăng tiến sự nghiệp.',
                'short_description' => 'Giao tiếp, teamwork...',
                'purchase_count' => 12,
                'author' => 'Lưu Thị G',
                'unit_price' => 140000,
                'sale_price' => 110000,
                'image' => 'books/softskill.jpg',
                'category_id' => 3,
                'quantity' => 20,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
