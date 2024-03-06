<?php
declare(strict_types=1);

namespace App\Filament\Resources\DeliveryMethodResource\Pages;

use App\Filament\Resources\DeliveryMethodResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeliveryMethod extends CreateRecord
{
    protected static string $resource = DeliveryMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
