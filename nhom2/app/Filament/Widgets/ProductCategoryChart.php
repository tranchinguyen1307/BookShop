<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OrderDetail;
use App\Models\Product;  // Sử dụng mô hình Product
use App\Models\Category; // Giả sử bạn có mô hình Category
use Carbon\Carbon;

class ProductCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Danh mục bán chạy';

    protected function getData(): array
    {
        // Lấy danh mục và tổng số lượng sản phẩm bán được
        $categorySales = OrderDetail::join('products', 'products.id', '=', 'order_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id') // Thêm join với bảng categories
            ->selectRaw('categories.name as category_name, SUM(order_details.quantity) as total_sold')  // Lấy tên danh mục từ bảng categories
            ->groupBy('categories.name')  // Group theo tên danh mục
            ->orderBy('total_sold', 'desc') // Thứ tự theo số lượng bán ra
            ->get();

        // Mảng chứa tên các danh mục và số lượng bán ra
        $categories = $categorySales->pluck('category_name');
        $salesData = $categorySales->pluck('total_sold');

        return [
            'datasets' => [
                [
                    'data' => $salesData, // Số lượng bán được của từng danh mục
                    'backgroundColor' => ['#4CAF50', '#FFC107', '#F44336', '#2196F3', '#FF5722'], // Màu sắc của mỗi phần trong biểu đồ
                ],
            ],
            'labels' => $categories, // Các danh mục sản phẩm
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Biểu đồ là Pie Chart
    }
}


