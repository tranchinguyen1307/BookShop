<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Livewire\Livewire;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Quản lý Đơn hàng';
    protected static ?string $modelLabel = 'Đơn hàng';

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([]); // Không cần schema vì không cho tạo/sửa
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Mã đơn')->sortable(),
                TextColumn::make('user.name')->label('Khách hàng')->searchable(),
                TextColumn::make('address')->label('Địa chỉ'),
                TextColumn::make('total_price')->label('Tổng tiền')->money('VND'),
                TextColumn::make('payment_method')
                    ->label('Thanh toán')
                    ->formatStateUsing(function ($state) {
                        return match ((int) $state) {
                            1 => 'Thanh toán khi nhận hàng',
                            2 => 'Momo',
                            default => 'Không rõ',
                        };
                    }),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        $statusText = [
                            0 => 'Chờ xác nhận',
                            1 => 'Đã xác nhận',
                            2 => 'Đang giao hàng',
                            3 => 'Đã nhận hàng',
                            4 => 'Đã hủy',
                        ];
                        return $statusText[$state] ?? 'Không rõ';
                    }),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime(),
            ])
            ->actions([
                Action::make('updateStatus')
                    ->label('Cập nhật trạng thái')
                    ->icon('heroicon-o-pencil')
                    ->form(function (Order $record) {
                        $statusOptions = [
                            0 => 'Chờ xác nhận',
                            1 => 'Đã xác nhận',
                            2 => 'Đang giao hàng',
                            4 => 'Đã hủy',
                        ];

                        // Chỉ hiển thị các trạng thái có giá trị lớn hơn trạng thái hiện tại
                        $filtered = collect($statusOptions)
                            ->filter(fn($label, $key) => $key > $record->status)
                            ->toArray();

                        return [
                            Select::make('status')
                                ->label('Trạng thái')
                                ->options($filtered)
                                ->required(),
                        ];
                    })
                    ->action(function (Order $order, array $data) {
                        $newStatus = (int) $data['status'];

                        if ($newStatus <= $order->status) {
                            Notification::make()
                                ->title('Không thể cập nhật trạng thái lùi lại hoặc giống nhau!')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Cập nhật trạng thái
                        $order->update(['status' => $newStatus]);

                        // Nếu trạng thái là "Đã hủy", phát sự kiện Livewire từ component thực tế
                        if ($newStatus === 4) {
                            // Phát sự kiện Livewire tới tất cả các component đang nghe
                            Livewire::emit('showCancelReasonModal', $order->id);
                        }

                        // Giảm số lượng sản phẩm trong kho tương ứng với số lượng sản phẩm trong đơn hàng
                        foreach ($order->orderDetails as $orderDetail) {
                            $product = $orderDetail->product;
                            $product->increment('quantity', $orderDetail->quantity); // Hoàn lại số lượng
                        }

                        Notification::make()
                            ->title('Cập nhật trạng thái thành công!')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Không cho tạo đơn hàng mới
    }
}
