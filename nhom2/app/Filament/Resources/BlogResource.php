<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;


class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $label = 'Bài viết';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Tiêu đề')
                    ->rules(['required', 'min:3', 'max:200']),
                TextInput::make('author')
                    ->label('Tác giả')
                    ->rules(['required', 'min:3', 'max:200']),
                Select::make('blogcategory_id')
                    ->label('Danh mục bài viết')
                    ->required()
                    ->relationship('blogCategory', 'name')
                    ->searchable()
                    ->preload(),
                FileUpload::make('image')
                    ->label('Ảnh đại diện')
                    ->directory('blogs')
                    ->rule(['required']),
                RichEditor::make('content')
                    ->label('Nội dung')
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('uploads/blog')
                    ->rule(['required']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề'),
                TextColumn::make('blogCategory.name')
                    ->label('Danh mục'),
                TextColumn::make('author')
                    ->label('Tác giả'),
                ImageColumn::make('image')
                    ->label('Ảnh đại diện'),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
