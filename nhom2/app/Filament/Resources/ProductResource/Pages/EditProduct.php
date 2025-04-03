<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
    
        $data['images'] = $this->record->images->pluck('image')->toArray();
    
        return $data;
    }
    
    

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Cập nhật thông tin sản phẩm
        $record->update($data);

        // Xóa ảnh cũ nếu cần
        $record->images()->delete();

        // Lưu ảnh mới vào bảng product_images
        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                $record->images()->create([
                    'image' => $image, 
                ]);
            }
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
