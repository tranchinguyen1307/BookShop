<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tin công nghệ',
                'description' => 'Cập nhật tin tức mới nhất về công nghệ.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Hướng dẫn lập trình',
                'description' => 'Các bài viết hướng dẫn lập trình từ cơ bản đến nâng cao.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chia sẻ kinh nghiệm',
                'description' => 'Tổng hợp kinh nghiệm làm việc thực tế từ các lập trình viên.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Review sách lập trình',
                'description' => 'Giới thiệu và đánh giá các sách hay về lập trình.',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('blog_categories')->insert($categories);
    }
}
