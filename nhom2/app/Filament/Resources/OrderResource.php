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
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Livewire\Livewire;
use App\Mail\OrderCancelledMail;
use Illuminate\Support\Facades\Mail;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
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
                            2 => 'Đã thanh toán ',
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
                            2 => 'Đã thanh toán',
                            4 => 'Đã hủy',
                        ];

                        $filtered = collect($statusOptions)
                            ->filter(fn($label, $key) => $key > $record->status)
                            ->toArray();

                        return [
                            Select::make('status')
                                ->label('Trạng thái')
                                ->options($filtered)
                                ->required()
                                ->live(),

                            Textarea::make('cancellation_reason')
                                ->label('Lý do hủy đơn hàng')
                                ->required()
                                ->visible(fn($get) => $get('status') == 4),
                        ];
                    })
                    ->action(function (Order $order, array $data) {
                        $newStatus = (int) $data['status'];

                        // Kiểm tra xem trạng thái mới có phải là trạng thái hợp lệ hay không
                        if ($newStatus <= $order->status) {
                            Notification::make()
                                ->title('Không thể cập nhật trạng thái lùi lại hoặc giống nhau!')
                                ->danger()
                                ->send();
                            return;
                        }

                        $updateData = ['status' => $newStatus];

                        if ($newStatus === 4) { // Nếu trạng thái là "Đã hủy"
                            if ($order->status == 2) { // Kiểm tra nếu đơn hàng đã thanh toán
                                Notification::make()
                                    ->title('Không thể hủy đơn đã thanh toán!')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            // Cập nhật lý do hủy đơn hàng
                            $updateData['cancellation_reason'] = $data['cancellation_reason'] ?? null;

                            // Gửi email thông báo hủy đơn hàng
                            Mail::to($order->user->email)->send(new OrderCancelledMail($order));
                        }

                        // Cập nhật trạng thái đơn hàng
                        $order->update($updateData);

                        // Thông báo thành công
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
