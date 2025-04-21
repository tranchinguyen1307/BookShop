<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Quản lý đánh giá';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Người dùng')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('order.order_code')
                    ->label('Mã đơn hàng')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Sản phẩm')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('product.image')
                    ->label('Hình ảnh')
                    ->circular(), // hoặc .square(), tuỳ bạn

                Tables\Columns\TextColumn::make('rating')
                    ->label('Đánh giá')
                    ->formatStateUsing(function ($state) {
                        return collect(range(1, 5))
                            ->map(fn($i) => $i <= $state ? '⭐' : '☆')
                            ->implode('');
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('message')
                    ->label('Nội dung')
                    ->limit(50)
                    ->extraAttributes(['class' => 'cursor-pointer text-blue-500 underline'])
                    ->action(function ($record) {
                        \Filament\Notifications\Notification::make()
                            ->title('Nội dung đánh giá')
                            ->body($record->message)
                            ->send();
                    }),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime(),
            ])

            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false; // Không cho phép tạo
    }

    public static function canEdit(Model $record): bool
    {
        return false; // Không cho phép sửa
    }

}
