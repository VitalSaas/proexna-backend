<?php

namespace App\Filament\Resources\Stats\Pages;

use App\Filament\Resources\Stats\StatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStat extends ViewRecord
{
    protected static string $resource = StatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
