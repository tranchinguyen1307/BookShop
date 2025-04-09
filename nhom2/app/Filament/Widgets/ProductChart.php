<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product; // Giả sử bạn có mô hình Product
use Carbon\Carbon;

class ProductChart extends ChartWidget
{
    protected static ?string $heading = 'Biểu đồ Sản phẩm'; // Tiêu đề biểu đồ
    

    protected function getData(): array
    {
        // Lấy số lượng sản phẩm bán theo từng tháng trong năm nay
        $productsPerMonth = Product::whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        

        // Mảng để chứa số lượng sản phẩm theo tháng và tên tháng
        $monthlyCounts = [];
        $months = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];

        // Lấy dữ liệu cho từng tháng, nếu không có sản phẩm trong tháng sẽ để 0
        foreach ($months as $index => $month) {
            $monthlyCounts[] = $productsPerMonth->firstWhere('month', $index + 1)->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Số lượng Sản phẩm Bán', // Nhãn cho dữ liệu
                    'data' => $monthlyCounts, // Số lượng sản phẩm theo từng tháng
                    'backgroundColor' => 'rgba(192, 75, 75, 0.2)', // Màu nền của các điểm dữ liệu
                    'borderColor' => 'rgb(192, 75, 83)', // Màu viền của các điểm dữ liệu
                    'borderWidth' => 1, // Độ dày viền
                ],
            ],
            'labels' => $months, // Các tháng hiển thị trên biểu đồ
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Loại biểu đồ là biểu đồ cột (bar chart)
    }
}
