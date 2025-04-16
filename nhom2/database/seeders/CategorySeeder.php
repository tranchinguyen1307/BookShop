<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tiểu thuyết',
                'description' => 'Những câu chuyện hư cấu hấp dẫn.',
                'thumbnail' => 'categories/novel.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Kinh tế',
                'description' => 'Sách về tài chính, kinh doanh, và đầu tư.',
                'thumbnail' => 'categories/economy.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Tâm lý - Kỹ năng sống',
                'description' => 'Phát triển bản thân và hiểu về tâm lý con người.',
                'thumbnail' => 'categories/psychology.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Thiếu nhi',
                'description' => 'Sách dành cho trẻ em và thiếu nhi.',
                'thumbnail' => 'categories/kid.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Văn học nước ngoài',
                'description' => 'Tác phẩm nổi tiếng của văn học thế giới.',
                'thumbnail' => 'categories/world-literature.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Sách giáo khoa',
                'description' => 'Tài liệu học tập dành cho học sinh các cấp.',
                'thumbnail' => 'categories/textbook.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Lịch sử - Văn hóa',
                'description' => 'Sách về các sự kiện lịch sử và văn hóa Việt Nam, thế giới.',
                'thumbnail' => 'categories/history.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Công nghệ - Kỹ thuật',
                'description' => 'Thông tin công nghệ và kỹ thuật hiện đại.',
                'thumbnail' => 'categories/technology.jpg',
                'status' => 1,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'thumbnail' => $category['thumbnail'],
                'status' => $category['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
