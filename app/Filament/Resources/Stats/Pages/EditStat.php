<?php

namespace App\Filament\Resources\Stats\Pages;

use App\Filament\Resources\Stats\StatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStat extends EditRecord
{
    protected static string $resource = StatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
