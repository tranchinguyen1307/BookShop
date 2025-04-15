<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User; // Giả sử bạn có mô hình User
use Carbon\Carbon;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Người dùng đăng ký'; // Tiêu đề biểu đồ
    

    protected function getData(): array
    {
        // Lấy số lượng người dùng đăng ký theo từng tháng trong năm nay
        $usersPerMonth = User::whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mảng để chứa số lượng người dùng theo tháng và tên tháng
        $monthlyCounts = [];
        $months = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];

        // Lấy dữ liệu cho từng tháng, nếu không có người dùng trong tháng sẽ để 0
        foreach ($months as $index => $month) {
            $monthlyCounts[] = $usersPerMonth->firstWhere('month', $index + 1)->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Số lượng Người dùng Đăng ký', // Nhãn cho dữ liệu
                    'data' => $monthlyCounts, // Số lượng người dùng theo từng tháng
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Màu nền của các điểm dữ liệu
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Màu viền của các điểm dữ liệu
                    'borderWidth' => 1, // Độ dày viền
                ],
            ],
            'labels' => $months, // Các tháng hiển thị trên biểu đồ
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Loại biểu đồ là line chart (biểu đồ đường)
    }
}
