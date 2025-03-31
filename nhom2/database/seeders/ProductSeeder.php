<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Nhà giả kim',
                'description' => 'Cuốn sách truyền cảm hứng về hành trình đi tìm ước mơ.',
                'author' => 'Paulo Coelho',
                'unit_price' => 120000,
                'sale_price' => 99000,
                'image' => 'products/01JQB1PCYKBXNTVHB7G8Y6YGNX.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đắc nhân tâm',
                'description' => 'Sách kỹ năng sống giúp bạn cải thiện giao tiếp và quan hệ.',
                'author' => 'Dale Carnegie',
                'unit_price' => 150000,
                'sale_price' => 120000,
                'image' => 'products/01JQB1PCYKBXNTVHB7G8Y6YGNX.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tuổi trẻ đáng giá bao nhiêu',
                'description' => 'Sách truyền cảm hứng dành cho giới trẻ.',
                'author' => 'Rosie Nguyễn',
                'unit_price' => 100000,
                'sale_price' => null,
                'image' => 'products/01JQB1PCYKBXNTVHB7G8Y6YGNX.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bí mật tư duy triệu phú',
                'description' => 'Hướng dẫn cách thay đổi tư duy để thành công tài chính.',
                'author' => 'T. Harv Eker',
                'unit_price' => 180000,
                'sale_price' => 150000,
                'image' => 'products/01JQB1PCYKBXNTVHB7G8Y6YGNX.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dám bị ghét',
                'description' => 'Sách triết lý dựa trên tâm lý học Adler.',
                'author' => 'Ichiro Kishimi & Fumitake Koga',
                'unit_price' => 140000,
                'sale_price' => 130000,
                'image' => 'products/01JQB1PCYKBXNTVHB7G8Y6YGNX.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
