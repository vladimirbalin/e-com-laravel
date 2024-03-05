<?php
declare(strict_types=1);

namespace App\Filament\Resources\SeoResource\Pages;

use App\Filament\Resources\SeoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSeo extends CreateRecord
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
