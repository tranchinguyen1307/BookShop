<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;


    protected static ?string $label = 'Sản phẩm';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                       Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Tiêu đề')
                                    ->rules(['required', 'min:3', 'max:200']),
                                TextInput::make('unit_price')
                                    ->label('Giá')
                                    ->rules(['required', 'numeric', 'min:1000'])
                                    ->suffix('VND')
                                    ->formatStateUsing(fn($state) => $state !== null ? intval($state) : ''),
                                Select::make('category_id')
                                    ->label('Danh mục')
                                    ->required()
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload(),
                                RichEditor::make('short_description')
                                    ->label('Mô tả ngắn')
                                    ->rule(['required']),
                                RichEditor::make('description')
                                    ->label('Mô tả')
                                    ->rule(['required']),
                            ]),

                        Group::make()
                            ->schema([
                                TextInput::make('author')
                                    ->label('Tác giả')
                                    ->rules(['required', 'min:3', 'max:200']),
                                TextInput::make('sale_price')
                                    ->label('Giá giảm')
                                    ->numeric()
                                    ->suffix('VND')
                                    ->formatStateUsing(fn($state) => $state !== null ? intval($state) : '')
                                    ->rule(fn($get) => function (string $attribute, $value, $fail) use ($get) {
                                        $unitPrice = $get('unit_price');
                                        if ($value && $unitPrice && $value > $unitPrice) {
                                            $fail('Giá giảm không được lớn hơn giá gốc.');
                                        }
                                    }),
                                FileUpload::make('image')
                                    ->label('Hình ảnh')
                                    ->directory('products')
                                    ->rule(['required']),
                                Repeater::make('images')
                                    ->label('Album ảnh')
                                    ->relationship('images')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('')
                                            ->directory('products/albums')
                                            ->image()
                                            ->required(),
                                    ])
                                    ->collapsible(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tiêu đề'),
                TextColumn::make('category.name')
                    ->label('Danh mục'),
                TextColumn::make('author')
                    ->label('Tác giả'),
                ImageColumn::make('image')
                    ->label('Hình ảnh'),
                TextColumn::make('unit_price')
                    ->label('Giá')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->sale_price
                            ? "<strong style='color:red;'>" . number_format($record->sale_price) . " VND</strong><br>
                               <s style='color:green;'>" . number_format($record->unit_price) . " VND</s>"
                            :   "<strong style='color:green;'>" . number_format($record->unit_price) . " VND</strong>"

                    )
                    ->html()
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw("COALESCE(sale_price, unit_price) $direction");
                    }),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
