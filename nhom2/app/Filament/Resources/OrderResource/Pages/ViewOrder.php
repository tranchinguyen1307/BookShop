<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\Page;

class ViewOrder extends Page
{
    protected static string $resource = OrderResource::class;

    // Đảm bảo khai báo view để xác định view sẽ được sử dụng
    protected static string $view = 'admin.pages.orders.view-order';

    public $order;

    public function mount($record): void
    {
        // Tải đơn hàng từ database
        $this->order = \App\Models\Order::findOrFail($record);
    }

    protected function getViewData(): array
    {
        return [
            'order' => $this->order,
        ];
    }
}
