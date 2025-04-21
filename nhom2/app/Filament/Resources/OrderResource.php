<?php

namespace App\Filament\Resources;

use App\Models\Order;  // Đảm bảo dòng này được thêm vào
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCancelledMail;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter; // Đảm bảo dòng này cũng có
use App\Filament\Resources\OrderResource\Pages\ListOrders; // Đảm bảo thêm dòng này
use App\Filament\Resources\OrderResource\Pages\ViewOrder; // Đảm bảo thêm dòng này

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
                TextColumn::make('order_code')->label('Mã đơn')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Khách hàng')->searchable(),
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
                            2 => 'Đã thanh toán',
                            3 => 'Đã nhận hàng',
                            4 => 'Đã hủy',
                        ];
                        return $statusText[$state] ?? 'Không rõ';
                    }),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->sortable()
                    ->default('desc'),
            ])
            ->filters([
                // Lọc theo trạng thái
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        0 => 'Chờ xác nhận',
                        1 => 'Đã xác nhận',
                        2 => 'Đã thanh toán',
                        3 => 'Đã nhận hàng',
                        4 => 'Đã hủy',
                    ])
                    ->placeholder('Tất cả trạng thái'),
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
                            3 => 'Đã nhận hàng',
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
            'index' => ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Không cho tạo đơn hàng mới
    }
}
