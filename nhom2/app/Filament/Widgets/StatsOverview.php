<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();


        // Đơn hàng
        $ordersThisMonth = Order::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $ordersLastMonth = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        // Doanh thu
        $revenueThisMonth = Order::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_price');

        $revenueLastMonth = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_price');

        // Sản phẩm đã bán
        $productsThisMonth = OrderDetail::whereHas('order', function ($query) use ($now) {
            $query->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year);
        })->sum('quantity');

        $productsLastMonth = OrderDetail::whereHas('order', function ($query) use ($lastMonth) {
            $query->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year);
        })->sum('quantity');

        // So sánh
        $compare = function ($current, $previous) {
            if ($previous == 0) {
                return [
                    'change' => $current > 0 ? 100 : 0,
                    'direction' => $current > 0 ? 'arrow-trending-up' : 'minus',
                    'color' => $current > 0 ? 'success' : 'gray',
                ];
            }

            $diff = $current - $previous;
            $percent = round(($diff / $previous) * 100);

            return [
                'change' => abs($percent),
                'direction' => $percent > 0 ? 'arrow-trending-up' : ($percent < 0 ? 'arrow-trending-down' : 'minus'),
                'color' => $percent > 0 ? 'success' : ($percent < 0 ? 'danger' : 'gray'),
            ];
        };

        $orderCompare = $compare($ordersThisMonth, $ordersLastMonth);
        $revenueCompare = $compare($revenueThisMonth, $revenueLastMonth);
        $productCompare = $compare($productsThisMonth, $productsLastMonth);

        return [
            Stat::make('Tổng đơn hàng', $ordersThisMonth)
                ->icon('heroicon-o-receipt-percent')
                ->description('So với tháng trước '.$orderCompare['change'] . '%')
                ->descriptionIcon('heroicon-m-' . $orderCompare['direction'])
                ->descriptionColor($orderCompare['color']),

            Stat::make('Doanh thu', number_format($revenueThisMonth, 0, ',', '.') . ' đ')
                ->icon('heroicon-o-banknotes')
                ->description('So với tháng trước '.$revenueCompare['change'] . '%')
                ->descriptionIcon('heroicon-m-' . $revenueCompare['direction'])
                ->descriptionColor($revenueCompare['color']),

            Stat::make('Sản phẩm đã bán', $productsThisMonth)
                ->icon('heroicon-o-shopping-cart')
                ->description('So với tháng trước ' .$productCompare['change'] . '%')
                ->descriptionIcon('heroicon-m-' . $productCompare['direction'])
                ->descriptionColor($productCompare['color']),
        ];
    }
}
