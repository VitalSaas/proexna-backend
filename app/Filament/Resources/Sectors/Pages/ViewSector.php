<?php

namespace App\Filament\Resources\Sectors\Pages;

use App\Filament\Resources\Sectors\SectorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSector extends ViewRecord
{
    protected static string $resource = SectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
