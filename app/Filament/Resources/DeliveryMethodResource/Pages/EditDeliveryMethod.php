<?php
declare(strict_types=1);

namespace App\Filament\Resources\DeliveryMethodResource\Pages;

use App\Filament\Resources\DeliveryMethodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryMethod extends EditRecord
{
    protected static string $resource = DeliveryMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
