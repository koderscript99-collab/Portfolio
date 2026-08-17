<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Actions\DeleteAction $action, Product $record) {
                    if ($record->orders()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('Cannot delete this product')
                            ->body('It has existing orders — deleting it would break purchase history for buyers who already paid. Turn off "Published" instead to hide it from the storefront.')
                            ->send();

                        $action->halt();
                    }
                }),
        ];
    }
}