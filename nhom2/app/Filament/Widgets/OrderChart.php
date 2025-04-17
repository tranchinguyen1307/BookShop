<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Thống kê trạng thái đơn hàng';

    protected function getData(): array
    {
        $orderStatusCounts = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        $statusLabels = [
            0 => 'Chờ xác nhận',
            1 => 'Đã xác nhận',
            2 => 'Đã thanh toán ',
            3 => 'Đã nhận hàng',
            4 => 'Đã hủy',
        ];

        $labels = [];
        $data = [];

        foreach ($statusLabels as $status => $label) {
            $labels[] = $label;
            $data[] = $orderStatusCounts->firstWhere('status', $status)->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => [
                        '#FFEB3B',
                        '#2196F3',
                        '#4CAF50',
                        '#FF5722',
                        '#F44336',
                    ],

                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 14,
                        'padding' => 16,
                    ],
                ],
            ],
            'layout' => [
                'padding' => 0,
            ],
            'elements' => [
                'arc' => [
                    'borderWidth' => 0, // Không có đường gạch viền giữa các mảng
                ],
            ],
            'scales' => [ // Đây là điểm quan trọng để xóa grid trong một số cấu hình Chart.js
                'x' => [
                    'display' => false,
                    'grid' => [
                        'display' => false,
                        'drawBorder' => false,
                    ],
                ],
                'y' => [
                    'display' => false,
                    'grid' => [
                        'display' => false,
                        'drawBorder' => false,
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
