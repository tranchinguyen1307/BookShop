<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Carbon\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Doanh thu theo tháng (VND)';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $revenuePerMonth = Order::whereYear('created_at', Carbon::now()->year)
            ->where('status', 3)
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];
        $monthlyRevenue = [];

        foreach (range(1, 12) as $month) {
            $revenue = $revenuePerMonth->firstWhere('month', $month)->revenue ?? 0;
            $monthlyRevenue[] = round($revenue);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu (VNĐ)',
                    'data' => $monthlyRevenue,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $months,
        ];
    }

}
